<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

    if (isset($_POST['create'])) {
        $category = $_POST['category'];
        $status = $_POST['status'];

        // Check if the category already exists
        $sqlCheck = "SELECT COUNT(*) FROM tblcategory WHERE CategoryName = :category";
        $queryCheck = $dbh->prepare($sqlCheck);
        $queryCheck->bindParam(':category', $category, PDO::PARAM_STR);
        $queryCheck->execute();
        $categoryExists = $queryCheck->fetchColumn();

        if ($categoryExists > 0) {
            $toastMessage = "Category already exists. Please use a different name.";
            $toastType = "error";
        } else {
            // Insert the new category
            $sql = "INSERT INTO tblcategory(CategoryName, Status) VALUES(:category, :status)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':category', $category, PDO::PARAM_STR);
            $query->bindParam(':status', $status, PDO::PARAM_STR);
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();

            if ($lastInsertId) {
                $toastMessage = "Category created successfully.";
                $toastType = "success";
            } else {
                $toastMessage = "Something went wrong. Please try again.";
                $toastType = "error";
            }
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
        <title>Online Library Site| Add Categories</title>
        <!-- BOOTSTRAP CORE STYLE  -->
        <link href="assets/css/bootstrap.css" rel="stylesheet" />
        <!-- FONT AWESOME STYLE  -->
        <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLE  -->
        <link href="assets/css/style.css" rel="stylesheet" />
        <!-- GOOGLE FONT -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    </head>

    <body>
        <!------MENU SECTION START-->
        <style>
            .toast {
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 15px 20px;
                background-color: #333;
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

        <?php include('includes/header.php'); ?>
        <!-- MENU SECTION END-->

        <?php if (isset($toastMessage)): ?>
            <div class="toast toast-primary <?php echo $toastType; ?>">
                <?php echo $toastMessage; ?>
            </div>
        <?php endif; ?>

        <div class="content-wra
    <div class=" content-wrapper">
            <div class="container">
                <div class="row pad-botm">
                    <div class="col-md-12">
                        <h4 class="header-line">Add category</h4>

                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"">
<div class=" panel panel-primary">
                        <div class="panel-heading">
                            Category Info
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post">
                                <div class="form-group">
                                    <label>Category Name</label>
                                    <input class="form-control" type="text" name="category" autocomplete="off" required />
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
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

                                </div>
                                <button type="submit" name="create" class="btn btn-info">Create </button>

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