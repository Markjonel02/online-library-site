<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
  header('location:index.php');
} else { ?>
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
    <title>Online Library Site | Admin Dash Board</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->

    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>

    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-rounded/css/uicons-solid-rounded.css'>
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

  </head>

  <body>
    <!------MENU SECTION START-->
    <?php include('includes/header.php'); ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
      <div class="container">
        <div class="row pad-botm">
          <div class="col-md-12">
            <h4 class="header-line text-secondary">ADMIN DASHBOARD</h4>
          </div>
        </div>

        <div class="row">

          <div class="col-md-3 col-sm-3 col-xs-6">
            <div class="alert alert-success back-widget-set text-center">
              <i class="fi fi-ss-book-open-cover text-secondary" style="font-size: 5em;"></i>
              <?php
              $sql = "SELECT id FROM tblbooks ";
              $query = $dbh->prepare($sql);
              $query->execute();
              $results = $query->fetchAll(PDO::FETCH_OBJ);
              $listdbooks = $query->rowCount();
              ?>
              <h3 class="text-secondary"><?php echo htmlentities($listdbooks); ?></h3>
              <span class="text-secondary">Books Listed</span>
            </div>
          </div>

          <div class="col-md-3 col-sm-3 col-xs-6">
            <div class="alert alert-info back-widget-set text-center">
              <i class="fi fi-ss-duration-alt text-secondary" style="font-size: 5em;"></i>
              <?php
              $sql1 = "SELECT id FROM tblissuedbookdetails ";
              $query1 = $dbh->prepare($sql1);
              $query1->execute();
              $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
              $issuedbooks = $query1->rowCount();
              ?>
              <h3 class="text-secondary"><?php echo htmlentities($issuedbooks); ?> </h3>
              <span class="text-secondary">Times Book Issued</span>
            </div>
          </div>

          <div class="col-md-3 col-sm-3 col-xs-6">
            <div class="alert alert-warning back-widget-set text-center">
              <img src="./assets/img/restock.svg" alt="" width="80" height="80">
              <?php
              $status = 1;
              $sql2 = "SELECT id FROM tblissuedbookdetails WHERE RetrunStatus=:status";
              $query2 = $dbh->prepare($sql2);
              $query2->bindParam(':status', $status, PDO::PARAM_STR);
              $query2->execute();
              $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
              $returnedbooks = $query2->rowCount();
              ?>
              <h3 class="text-secondary"><?php echo htmlentities($returnedbooks); ?></h3>
              <span class="text-secondary">Times Books Returned</span>
            </div>
          </div>

          <div class="col-md-3 col-sm-3 col-xs-6">
            <div class="alert alert-danger back-widget-set text-center">
              <i class="fi fi-ss-users-alt text-secondary" style="font-size: 5em;"></i>
              <?php
              $sql3 = "SELECT id FROM tblstudents ";
              $query3 = $dbh->prepare($sql3);
              $query3->execute();
              $results3 = $query3->fetchAll(PDO::FETCH_OBJ);
              $regstds = $query3->rowCount();
              ?>
              <h3 class="text-secondary"><?php echo htmlentities($regstds); ?></h3>
              <span class="text-secondary">Registered Users</span>
            </div>
          </div>

        </div>

        <div class="row">

          <div class="col-md-3 col-sm-3 col-xs-6">
            <div class="alert alert-success back-widget-set text-center">
              <img src="./assets/img/user-trust.svg" alt="" width="80" height="80">
              <?php
              $sq4 = "SELECT id FROM tblauthors ";
              $query4 = $dbh->prepare($sql);
              $query4->execute();
              $results4 = $query4->fetchAll(PDO::FETCH_OBJ);
              $listdathrs = $query4->rowCount();
              ?>
              <h3 class="text-secondary"><?php echo htmlentities($listdathrs); ?></h3>
              <span class="text-secondary">Authors Listed</span>
            </div>
          </div>

          <div class="col-md-3 col-sm-3 col-xs-6">
            <div class="alert alert-info back-widget-set text-center">
              <img src="./assets/img/to-do.svg" alt="" width="80" height="80">
              <?php
              $sql5 = "SELECT id FROM tblcategory ";
              $query5 = $dbh->prepare($sql1);
              $query5->execute();
              $results5 = $query5->fetchAll(PDO::FETCH_OBJ);
              $listdcats = $query5->rowCount();
              ?>
              <h3 class="text-secondary"><?php echo htmlentities($listdcats); ?> </h3>
              <span class="text-secondary">Listed Categories</span>
            </div>
          </div>

        </div>

      </div>
    </div>
    <style>
      .back-widget-set:hover {
        background-color: #427dfcff !important;
        /* Change background to blue */
        color: white !important;
        /* Change text color to white */
      }

      .back-widget-set:hover i,
      .back-widget-set:hover img {
        color: white !important;
        /* Change icon color to white */
        filter: brightness(0) invert(1);
        /* Invert icon color for images */
      }

      .back-widget-set h3,
      .back-widget-set span {
        transition: color 0.3s ease;
        /* Smooth transition for text color */
      }
    </style>



    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
  </body>

  </html>
<?php } ?>