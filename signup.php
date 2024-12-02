<?php
session_start();
include('includes/config.php');
error_reporting(0);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    try {
        // Code for generating a unique Student ID
        $count_my_page = "studentid.txt";
        if (!file_exists($count_my_page)) {
            file_put_contents($count_my_page, "0"); // Initialize the file if it doesn't exist.
        }

        $hits = file($count_my_page, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $StudentId = intval($hits[0]) + 1; // Increment student ID.
        file_put_contents($count_my_page, $StudentId); // Save updated student ID.

        // Sanitize input data
        $fname = htmlspecialchars(trim($_POST['fullanme']));
        $mobileno = htmlspecialchars(trim($_POST['mobileno']));
        $email = htmlspecialchars(trim($_POST['email']));
        $password = md5($_POST['password']); // Use stronger hashing (e.g., password_hash) for production.
        $status = 1;

        // Check if email already exists
        $emailCheckQuery = "SELECT COUNT(*) FROM tblstudents WHERE EmailId = :email";
        $emailCheckStmt = $dbh->prepare($emailCheckQuery);
        $emailCheckStmt->bindParam(':email', $email, PDO::PARAM_STR);
        $emailCheckStmt->execute();
        $emailExists = $emailCheckStmt->fetchColumn();

        if ($emailExists) {
            echo "<script>alert('Email already exists! Please use another email.');</script>";
        } else {
            // Insert data into the database
            $sql = "INSERT INTO tblstudents (StudentId, FullName, MobileNumber, EmailId, Password, Status) 
                    VALUES (:StudentId, :fname, :mobileno, :email, :password, :status)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':StudentId', $StudentId, PDO::PARAM_STR);
            $query->bindParam(':fname', $fname, PDO::PARAM_STR);
            $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':password', $password, PDO::PARAM_STR);
            $query->bindParam(':status', $status, PDO::PARAM_STR);

            $query->execute();
            $lastInsertId = $dbh->lastInsertId();

            if ($lastInsertId) {
                echo "<script>alert('Your registration is successful. Your Student ID is: $StudentId');</script>";
            } else {
                echo "<script>alert('Something went wrong. Please try again later.');</script>";
            }
        }
    } catch (Exception $e) {
        echo "<script>alert('An error occurred: " . $e->getMessage() . "');</script>";
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
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>Online Library Management System | Student Signup</title>
    <!-- BOOTSTRAP CORE STYLE  -->

    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/signup.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <script type="text/javascript">
        function valid() {
            if (document.signup.password.value != document.signup.confirmpassword.value) {
                alert("Password and Confirm Password Field do not match  !!");
                document.signup.confirmpassword.focus();
                return false;
            }
            return true;
        }
    </script>
    <script>
        function checkAvailability() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "check_availability.php",
                data: 'emailid=' + $("#emailid").val(),
                type: "POST",
                success: function(data) {
                    $("#user-availability-status").html(data);
                    $("#loaderIcon").hide();
                },
                error: function() {}
            });
        }
    </script>

</head>

<body>
    <!------MENU SECTION START-->

    <div class="centercon">


        <form class="form_container" method="post" name="signup" onsubmit="return valid();">
            <div class="title_container">
                <p class="title">Register Student</p>
            </div>
            <div class="input_container">
                <label class="input_label" for="fullname">Full Name</label>
                <input placeholder="Jane Doe" type="text" name="fullanme" autocomplete="off" required class="input_field" />
            </div>
            <div class="input_container">
                <label class="input_label" for="mobilenumber">Mobile Number:</label>
                <input placeholder="0123456789" type="number" name="mobileno" maxlength="11" autocomplete="off" required class="input_field" />
            </div>
            <div class="input_container">
                <label class="input_label" for="email_field">Email</label>
                <input placeholder="sample@domain.com" type="email" name="email" autocomplete="off" required class="input_field" />
            </div>
            <div class="input_container">
                <label class="input_label" for="password_field">Password</label>
                <input type="password" name="newpassword" required class="input_field" />
            </div>
            <div class="input_container">
                <label class="input_label" for="confirmpassword_field">Confirm Password</label>
                <input type="password" name="confirmpassword" required class="input_field" />
            </div>
            <button type="submit" name="signup" class="sign-in_btn">
                <span>Sign Up</span>
            </button>
            <a href="login.php">Already have an account?</a>
        </form>

    </div>


    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->

    <!-- CUSTOM SCRIPTS  -->

</body>

</html>