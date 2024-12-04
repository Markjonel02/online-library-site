<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

    if (isset($_POST['update'])) {
        $category = $_POST['category'];
        $status = $_POST['status'];
        $catid = intval($_GET['catid']);
        $sql = "update  tblcategory set CategoryName=:category,Status=:status where id=:catid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':category', $category, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':catid', $catid, PDO::PARAM_STR);
        $query->execute();
        $_SESSION['updatemsg'] = " Category updated successfully";
        unset($_SESSION['msgType']);
        //header('location:manage-categories.php');
    }
?>
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Online Library Site| Edit Categories</title>
        <!-- BOOTSTRAP CORE STYLE  -->
        <link href="assets/css/bootstrap.css" rel="stylesheet" />
        <!-- FONT AWESOME STYLE  -->
        <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLE  -->
        <link href="assets/css/style.css" rel="stylesheet" />
        <!-- GOOGLE FONT -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    </head>

    <body> <!-- Toast Styling -->
        <style>
            .toast {
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 15px 20px;
                background-color: #4CAF50;
                color: #fff;
                border-radius: 5px;
                font-size: 16px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                opacity: 1;
                transition: opacity 0.5s ease-out;
                z-index: 1000;
            }

            .toast.success {
                background-color: #4CAF50;
            }

            .toast.error {
                background-color: #F44336;
            }
        </style>

        <!-- Toast Display -->
        <?php if (isset($_SESSION['updatemsg'])) : ?>
            <div class="toast <?php echo $_SESSION['msgType']; ?>">
                <?php echo $_SESSION['updatemsg']; ?>
            </div>
            <?php
            // Clear the session variables after use
            unset($_SESSION['updatemsg']);
            unset($_SESSION['msgType']);
            ?>
        <?php endif; ?>

        <!-- JavaScript for Toast Behavior -->
        <script type="text/javascript">
            window.onload = function() {
                var toast = document.querySelector('.toast');
                if (toast) {
                    // Show the toast for 3 seconds
                    setTimeout(function() {
                        toast.style.opacity = 0; // Fade out the toast
                        setTimeout(function() {
                            toast.remove();
                            // Redirect to manage-categories.php after the toast disappears
                            window.location.href = "manage-categories.php";
                        }, 500); // Wait for the fade-out animation
                    }, 3000); // Toast stays visible for 3 seconds
                }
            };
        </script>
        <!------MENU SECTION START-->
        <?php include('includes/header.php'); ?>
        <!-- MENU SECTION END-->
        <div class="content-wra
    <div class=" content-wrapper">
            <div class="container">
                <div class="row pad-botm">
                    <div class="col-md-12">
                        <h4 class="header-line">Edit category</h4>

                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"">
<div class=" panel panel-info">
                        <div class="panel-heading">
                            Category Info
                        </div>

                        <div class="panel-body">
                            <form role="form" method="post">
                                <?php
                                $catid = intval($_GET['catid']);
                                $sql = "SELECT * from tblcategory where id=:catid";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':catid', $catid, PDO::PARAM_STR);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) {
                                ?>
                                        <div class="form-group">
                                            <label>Category Name</label>
                                            <input class="form-control" type="text" name="category" value="<?php echo htmlentities($result->CategoryName); ?>" required />
                                        </div>
                                        <div class="form-group">
                                            <label>Status</label>
                                            <?php if ($result->Status == 1) { ?>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="status" id="status" value="1" checked="checked">Active
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="status" id="status" value="0">Inactive
                                                    </label>
                                                </div>
                                            <?php } else { ?>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="status" id="status" value="0" checked="checked">Inactive
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="status" id="status" value="1">Active
                                                    </label>
                                                </div
                                                    <?php } ?>
                                                    </div>
                                        <?php }
                                } ?>
                                        <button type="submit" name="update" class="btn btn-info">Update </button>

                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        </div>
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