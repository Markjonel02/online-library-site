<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
  header('location:index.php');
} else { ?>
  <!DOCTYPE html>
  <html xmlns="http://www.w3.org/1999/xhtml">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Site | User Dash Board</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
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
            <h4 class="header-line">STUDENT DASHBOARD</h4>

          </div>

        </div>

        <div class="row">




          <div class="col-md-3 col-sm-3 col-xs-6">
            <div class="alert alert-info back-widget-set text-center">
              <i class="fi fi-ss-book-open-cover text-secondary" style="font-size: 5em;"></i>
              <?php
              $sid = $_SESSION['stdid'];
              $sql1 = "SELECT id from tblissuedbookdetails where StudentID=:sid";
              $query1 = $dbh->prepare($sql1);
              $query1->bindParam(':sid', $sid, PDO::PARAM_STR);
              $query1->execute();
              $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
              $issuedbooks = $query1->rowCount();
              ?>

              <h3><?php echo htmlentities($issuedbooks); ?> </h3>
              Book Issued
            </div>
          </div>

          <div class="col-md-3 col-sm-3 col-xs-6">
            <div class="alert alert-warning back-widget-set text-center">
              <img src="./assets/img/restock.svg" alt="" width="80" height="80">
              <?php
              $rsts = 1; // Assuming 0 indicates books not returned
              $sql2 = "SELECT * FROM tblissuedbookdetails WHERE StudentID=:sid AND RetrunStatus=:rsts";
              $query2 = $dbh->prepare($sql2);
              $query2->bindParam(':sid', $sid, PDO::PARAM_STR);
              $query2->bindParam(':rsts', $rsts, PDO::PARAM_STR);
              $query2->execute();
              $results2 = $query2->fetchAll(PDO::FETCH_OBJ);

              $returnedbooks = $query2->rowCount();
              ?>

              <h3><?php echo htmlentities($returnedbooks); ?></h3>

              <!-- Displaying the list of returned books -->
              <?php if ($returnedbooks > 0): ?>
                <p>You've returned the book<?php echo $returnedbooks > 1 ? 's' : ''; ?>.</p>

              <?php else: ?>
                <p>No books returned yet.</p>
              <?php endif; ?>


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