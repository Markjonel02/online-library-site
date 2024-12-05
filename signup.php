<?php
session_start();
include('includes/config.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure CSRF token is only generated once per session
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    try {
        // CSRF Protection
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            throw new Exception('Invalid CSRF token.');
        }

        // File-based Student ID generation
        $count_my_page = "studentid.txt";
        if (!file_exists($count_my_page)) {
            file_put_contents($count_my_page, "0");
        }

        // Safely read and update the student ID
        $fp = fopen($count_my_page, "r+");
        if (flock($fp, LOCK_EX)) {
            $hits = intval(fgets($fp)) + 1;
            ftruncate($fp, 0);
            rewind($fp);
            fwrite($fp, $hits);
            flock($fp, LOCK_UN);
            fclose($fp);
        } else {
            throw new Exception("Unable to lock the file for writing.");
        }
        $StudentId = $hits;

        // Sanitize and validate inputs
        $fname = htmlspecialchars(trim($_POST['fullname']));
        $username = htmlspecialchars(trim($_POST['username']));
        $mobileno = htmlspecialchars(trim($_POST['mobileno']));
        $email = htmlspecialchars(trim($_POST['email']));
        $password = htmlspecialchars($_POST['password']);
        $confirmpassword = htmlspecialchars($_POST['confirmpassword']);

        // Validate Mobile Number
        if (!preg_match('/^[0-9]{10,11}$/', $mobileno)) {
            throw new Exception('Invalid mobile number format. Please enter 10-11 digits.');
        }

        // Validate Password Match
        if ($password !== $confirmpassword) {
            throw new Exception('Password and Confirm Password do not match.');
        }

        // Hash the password securely
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $status = 1;

        // Check if email or username already exists
        $checkQuery = "SELECT COUNT(*) FROM tblstudents WHERE EmailId = :email OR UserName = :username";
        $checkStmt = $dbh->prepare($checkQuery);
        $checkStmt->bindParam(':email', $email, PDO::PARAM_STR);
        $checkStmt->bindParam(':username', $username, PDO::PARAM_STR);
        $checkStmt->execute();
        $existingCount = $checkStmt->fetchColumn();

        if ($existingCount > 0) {
            throw new Exception('Email or Username already exists! Please use different credentials.');
        }

        // Insert data into the database
        $sql = "INSERT INTO tblstudents (StudentId, FullName, UserName, MobileNumber, EmailId, Password, Status) 
                VALUES (:StudentId, :fname, :username, :mobileno, :email, :password, :status)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':StudentId', $StudentId, PDO::PARAM_STR);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_INT);

        $query->execute();
        $lastInsertId = $dbh->lastInsertId();

        if ($lastInsertId) {
            echo "<script>alert('Your registration is successful. Your Student ID is: $StudentId');</script>";
        } else {
            throw new Exception('Something went wrong. Please try again later.');
        }
    } catch (Exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | Student Signup</title>
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/signup.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <script type="text/javascript">
        function valid() {
            if (document.signup.password.value != document.signup.confirmpassword.value) {
                alert("Password and Confirm Password Field do not match!");
                document.signup.confirmpassword.focus();
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <div class="centercon">
        <form class="form_container" method="post" name="signup" onsubmit="return valid();">
            <div class="title_container">
                <p class="title">Register Student</p>
            </div>
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>" />
            <div class="input_container">
                <label class="input_label" for="fullname">Full Name <span style="color:red">*</span></label>
                <input placeholder="Jane Doe" type="text" name="fullname" autocomplete="off" required class="input_field" />
            </div>
            <div class="input_container">
                <label class="input_label" for="username">UserName <span style="color:red">*</span></label>
                <input placeholder="Jane Doe" type="text" name="username" autocomplete="off" required class="input_field" />
            </div>
            <div class="input_container">
                <label class="input_label" for="mobilenumber">Mobile Number: <span style="color:red">*</span></label>
                <input placeholder="0123456789" type="number" name="mobileno" maxlength="11" autocomplete="off" required class="input_field" />
            </div>
            <div class="input_container">
                <label class="input_label" for="email_field">Email <span style="color:red">*</span></label>
                <input placeholder="sample@domain.com" type="email" name="email" autocomplete="off" required class="input_field" />
            </div>
            <div class="input_container">
                <label class="input_label" for="password_field">Password <span style="color:red">*</span></label>
                <input placeholder="*****" type="password" name="password" required class="input_field" />
            </div>
            <div class="input_container">
                <label class="input_label" for="confirmpassword_field">Confirm Password <span style="color:red">*</span></label>
                <input placeholder="*****" type="password" name="confirmpassword" required class="input_field" />
            </div>
            <button type="submit" name="signup" class="sign-in_btn">
                <span>Sign Up</span>
            </button>
            <a href="login.php">Already have an account?</a>
        </form>
    </div>
</body>

</html>