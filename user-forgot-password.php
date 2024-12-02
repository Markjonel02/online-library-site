<?php
session_start();
error_reporting(0);
include('includes/config.php');/* 
if (isset($_POST['change'])) {
  //code for captach verification

  $email = $_POST['email'];
  $mobile = $_POST['mobile'];
  $newpassword = md5($_POST['newpassword']);
  $sql = "SELECT EmailId FROM tblstudents WHERE EmailId=:email and MobileNumber=:mobile";
  $query = $dbh->prepare($sql);
  $query->bindParam(':email', $email, PDO::PARAM_STR);
  $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
  $query->execute();
  $results = $query->fetchAll(PDO::FETCH_OBJ);
  if ($query->rowCount() > 0) {
    $con = "update tblstudents set Password=:newpassword where EmailId=:email and MobileNumber=:mobile";
    $chngpwd1 = $dbh->prepare($con);
    $chngpwd1->bindParam(':email', $email, PDO::PARAM_STR);
    $chngpwd1->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
    $chngpwd1->execute();
    echo "<script>alert('Your Password succesfully changed');</script>";
  } else {
    echo "<script>alert('Email id or Mobile no is invalid');</script>";
  }
}
 */
if (isset($_POST['change'])) {
  // Fetch form data
  $email = $_POST['email'];
  $mobile = $_POST['mobile'];
  $newpassword = password_hash($_POST['newpassword'], PASSWORD_DEFAULT); // Use password_hash

  // Check if the user exists
  $sql = "SELECT EmailId FROM tblstudents WHERE EmailId=:email AND MobileNumber=:mobile";
  $query = $dbh->prepare($sql);
  $query->bindParam(':email', $email, PDO::PARAM_STR);
  $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
  $query->execute();

  if ($query->rowCount() > 0) {
    // User exists, update password
    $con = "UPDATE tblstudents SET Password=:newpassword WHERE EmailId=:email AND MobileNumber=:mobile";
    $chngpwd1 = $dbh->prepare($con);
    $chngpwd1->bindParam(':email', $email, PDO::PARAM_STR);
    $chngpwd1->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);

    if ($chngpwd1->execute()) {
      echo "<script>alert('Your Password has been successfully changed');</script>";
    } else {
      echo "<script>alert('Error updating password. Please try again later.');</script>";
    }
  } else {
    echo "<script>alert('Invalid Email ID or Mobile Number');</script>";
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
  <title>Online Library Management System | Password Recovery </title>
  <!-- BOOTSTRAP CORE STYLE  -->

  <!-- FONT AWESOME STYLE  -->
  <link href="assets/css/font-awesome.css" rel="stylesheet" />
  <!-- CUSTOM STYLE  -->

  <!-- GOOGLE FONT -->
  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
  <script type="text/javascript">
    function valid() {
      if (document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
        alert("New Password and Confirm Password Field do not match  !!");
        document.chngpwd.confirmpassword.focus();
        return false;
      }
      return true;
    }
  </script>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    .main-cont {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      background-color: #f5f5f5;
      background: url('./assets/img/ACLC.png') no-repeat center;
      background-position: center;
      background-size: cover;
      position: relative;
      text-align: center;
      opacity: 0.8;

    }

    .overlay-text {
      font-family: 'Arial', sans-serif;
      font-size: 10rem;
      /* Adjust the size as needed */
      font-weight: 900;
      line-height: 1.1em;
      color: #ffffff;
      text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
      opacity: 0.4;
      z-index: 0;
    }


    .form_container {
      position: absolute;
      width: 400px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 20px 40px;
      /* Adjust padding for better spacing */
      gap: 15px;
      background-color: #ffffff;
      /* Ensures a clean background for the form */
      box-shadow: 0px 106px 42px rgba(0, 0, 0, 0.144),
        0px 59px 36px rgba(0, 0, 0, 0.05), 0px 26px 26px rgba(0, 0, 0, 0.09),
        0px 7px 15px rgba(0, 0, 0, 0.1), 0px 0px 0px rgba(0, 0, 0, 0.1);
      border-radius: 11px;
      font-family: "Inter", sans-serif;
    }



    .subtitle {
      font-size: 0.725rem;
      max-width: 80%;
      text-align: center;
      line-height: 1.1rem;
      color: #8B8E98
    }

    .input_container {
      width: 100%;
      height: fit-content;
      position: relative;
      display: flex;
      flex-direction: column;
      gap: 5px;
    }

    .icon {
      width: 20px;
      position: absolute;
      z-index: 99;
      left: 12px;
      bottom: 9px;
    }

    .input_label {
      font-size: 0.75rem;
      color: #8B8E98;
      font-weight: 600;
      text-align: left;
    }

    .input_field {
      width: auto;
      height: 40px;
      padding: 0 0 0 40px;
      border-radius: 7px;
      outline: none;
      border: 1px solid #e5e5e5;
      filter: drop-shadow(0px 1px 0px #efefef) drop-shadow(0px 1px 0.5px rgba(239, 239, 239, 0.5));
      transition: all 0.3s cubic-bezier(0.15, 0.83, 0.66, 1);
    }

    .input_field:focus {
      border: 1px solid transparent;
      box-shadow: 0px 0px 0px 2px #242424;
      background-color: transparent;
    }

    .sign-in_btn {
      width: 100%;
      height: 40px;
      border: 0;
      background: #115DFC;
      border-radius: 7px;
      outline: none;
      color: #ffffff;
      cursor: pointer;
    }

    .sign-in_ggl {
      width: 100%;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      background: #ffffff;
      border-radius: 7px;
      outline: none;
      color: #242424;
      border: 1px solid #e5e5e5;
      filter: drop-shadow(0px 1px 0px #efefef) drop-shadow(0px 1px 0.5px rgba(239, 239, 239, 0.5));
      cursor: pointer;
    }

    .sign-in_apl {
      width: 100%;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      background: #212121;
      border-radius: 7px;
      outline: none;
      color: #ffffff;
      border: 1px solid #e5e5e5;
      filter: drop-shadow(0px 1px 0px #efefef) drop-shadow(0px 1px 0.5px rgba(239, 239, 239, 0.5));
      cursor: pointer;
    }

    .separator {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 30px;
      color: #8B8E98;
    }

    .separator .line {
      display: block;
      width: 100%;
      height: 1px;
      border: 0;
      background-color: #e8e8e8;
    }

    .note {
      font-size: 0.75rem;
      color: #8B8E98;
      text-decoration: underline;
    }

    .lower-button {
      display: flex;
      width: 100%;
      justify-content: space-evenly;
      font-size: 14px;
    }

    .login-user {
      position: absolute;
      top: 10px;
      /* Adjust the value as needed */
      right: 10px;
      /* Adjust the value as needed */
    }

    .login-user a {
      display: inline-block;
      text-decoration: none;
      background-color: #007bff;
      /* Button background color */
      color: white;
      /* Text color */
      padding: 10px 15px;
      /* Padding for the button */
      border-radius: 5px;
      /* Roundedx corners */
      font-size: 14px;
      /* Font size */
      font-weight: bold;
      /* Bold text */
      transition: background-color 0.3s ease;
      /* Smooth hover effect */
    }

    .login-user a:hover {
      background-color: #0056b3;
      /* Darker shade on hover */
    }

    @media screen and (max-width: 900px) {
      .overlay-text {
        display: none;
      }
    }
  </style>
</head>

<body>



  <div class="main-cont ">
    <div class="overlay-text">ACLC COLLEGE OF TAYTAY</div>
    <form class="form_container" name="chngpwd" method="post" onSubmit="return valid();">
      <div class="title_container">
        <p class="title">Forgot Password</p>

      </div>
      <br>
      <div class="input_container">
        <label class="input_label" for="email_field">Enter Reg Email id <span style="color:red">*</span></label>

        <input title="Inpit title" type="email" name="email" required id="email_field" autocomplete="off" class="input_field" />
      </div>
      <div class="input_container">
        <label class="input_label" for="email_field">Reg MobileNo<span style="color:red">*</span></label>
        <input title="Inpit title" type="text" name="mobile" required autocomplete="off" class="input_field" />
      </div>
      <div class="input_container">
        <label class="input_label" for="password_field">New Password<span style="color:red">*</span></label>
        <input title="Inpit title" type="password" name="newpassword" required autocomplete="off" class="input_field" id="password_field" />
      </div>
      <div class="input_container">
        <label class="input_label" for="password_field">Confirm Password<span style="color:red">*</span></label>
        <input title="Inpit title" type="password" name="confirmpassword" required autocomplete="off" class="input_field" id="password_field" />
      </div>
      <button title="Sign In" type="submit" name="change" class="sign-in_btn">
        <span>Change Password</span>
      </button>
      <div class="lower-button">
        <span><a href="signup.php">Create an account</a></span>
        <span> <a href="login.php">Already have an account?</a></span>


      </div>



    </form>
  </div>

  <script src="assets/js/jquery-1.10.2.js"></script>
  <!-- BOOTSTRAP SCRIPTS  -->
  <script src="assets/js/bootstrap.js"></script>
  <!-- CUSTOM SCRIPTS  -->
  <script src="assets/js/custom.js"></script>

</body>

</html>