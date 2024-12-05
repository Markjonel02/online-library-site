<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {


    if (isset($_POST['add'])) {
        $bookname = $_POST['bookname'];
        $category = $_POST['category'];
        $author = $_POST['author'];
        $isbn = $_POST['isbn'];
        $price = $_POST['price'];

        // Check if the ISBN already exists in the database
        $sqlCheck = "SELECT COUNT(*) FROM tblbooks WHERE ISBNNumber = :isbn";
        $queryCheck = $dbh->prepare($sqlCheck);
        $queryCheck->bindParam(':isbn', $isbn, PDO::PARAM_STR);
        $queryCheck->execute();
        $isbnExists = $queryCheck->fetchColumn();

        if ($isbnExists > 0) {
            $toastMessage = "ISBN number already exists. Please use a different ISBN.";
            $toastType = "error";
        } else {
            // Proceed with inserting the new book
            $sql = "INSERT INTO tblbooks(BookName, CatId, AuthorId, ISBNNumber, BookPrice) VALUES(:bookname, :category, :author, :isbn, :price)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':bookname', $bookname, PDO::PARAM_STR);
            $query->bindParam(':category', $category, PDO::PARAM_STR);
            $query->bindParam(':author', $author, PDO::PARAM_STR);
            $query->bindParam(':isbn', $isbn, PDO::PARAM_STR);
            $query->bindParam(':price', $price, PDO::PARAM_STR);
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();

            if ($lastInsertId) {
                $toastMessage = "Book Listed successfully";
                $toastType = "success";
            } else {
                $toastMessage = "Something went wrong. Please try again";
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
        <title>Online Library Site | Add Book</title>
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
                            window.location.href = "manage-books.php";
                        }, 500); // Wait for the fade-out animation
                    }, 3000); // Toast stays visible for 3 seconds
                }
            };
        </script>

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
        <?php if (isset($toastMessage)): ?>
            <div class="toast <?php echo $toastType; ?>">
                <?php echo $toastMessage; ?>
            </div>
        <?php endif; ?>

        <!------MENU SECTION START-->
        <?php include('includes/header.php'); ?>
        <!-- MENU SECTION END-->
        <div class="content-wra
    <div class=" content-wrapper">
            <div class="container">
                <div class="row pad-botm">
                    <div class="col-md-12">
                        <h4 class="header-line">Add Book</h4>

                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"">
<div class=" panel panel-primary">
                        <div class="panel-heading">
                            Book Info
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post">
                                <div class="form-group">
                                    <label>Book Name<span style="color:red;">*</span></label>
                                    <input class="form-control" type="text" name="bookname" autocomplete="off" required />
                                </div>

                                <div class="form-group">
                                    <label> Category<span style="color:red;">*</span></label>
                                    <select class="form-control" name="category" required="required">
                                        <option value=""> Select Category</option>
                                        <?php
                                        $status = 1;
                                        $sql = "SELECT * from  tblcategory where Status=:status";
                                        $query = $dbh->prepare($sql);
                                        $query->bindParam(':status', $status, PDO::PARAM_STR);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {               ?>
                                                <option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->CategoryName); ?></option>
                                        <?php }
                                        } ?>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label> Author<span style="color:red;">*</span></label>
                                    <select class="form-control" name="author" required="required">
                                        <option value=""> Select Author</option>
                                        <?php

                                        $sql = "SELECT * from  tblauthors ";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {               ?>
                                                <option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->AuthorName); ?></option>
                                        <?php }
                                        } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>ISBN Number<span style="color:red;">*</span></label>
                                    <input class="form-control" type="text" name="isbn" required="required" autocomplete="off" />
                                    <p class="help-block">An ISBN is an International Standard Book Number.ISBN Must be unique</p>
                                </div>

                                <div class="form-group">
                                    <label>Price<span style="color:red;">*</span></label>
                                    <input class="form-control" type="text" name="price" autocomplete="off" required="required" />
                                </div>
                                <button type="submit" name="add" class="btn btn-primary w-100">Add</button>




                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        </div>
        <style>
            .btn {
                width: 100%;
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