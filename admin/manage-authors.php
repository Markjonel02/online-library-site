<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_GET['del'])) {
        $id = $_GET['del'];
        $sql = "delete from tblauthors  WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $_SESSION['delmsg'] = "Author deleted";
        $_SESSION['msgType'] = "success";
        // header('location:manage-authors.php');
    }


?>
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Online Library Site| Manage Authors</title>
        <!-- BOOTSTRAP CORE STYLE  -->
        <link href="assets/css/bootstrap.css" rel="stylesheet" />
        <!-- FONT AWESOME STYLE  -->
        <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- DATATABLE STYLE  -->
        <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
        <!-- CUSTOM STYLE  -->
        <link href="assets/css/style.css" rel="stylesheet" />
        <!-- GOOGLE FONT -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    </head>

    <body>
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

        <!-- Toast Display -->
        <?php if (isset($_SESSION['delmsg'])) : ?>
            <div class="toast <?php echo $_SESSION['msgType']; ?>">
                <?php echo $_SESSION['delmsg']; ?>
            </div>
            <?php
            // Clear the session variables after use
            unset($_SESSION['delmsg']);
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
        <div class="content-wrapper">
            <div class="container">
                <div class="row pad-botm">
                    <div class="col-md-12">
                        <h4 class="header-line">Manage Authors</h4>
                    </div>
                    <div class="row">
                        <?php if ($_SESSION['error'] != "") { ?>
                            <div class="col-md-6">
                                <div class="alert alert-danger">
                                    <strong>Error :</strong>
                                    <?php echo htmlentities($_SESSION['error']); ?>
                                    <?php echo htmlentities($_SESSION['error'] = ""); ?>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($_SESSION['msg'] != "") { ?>
                            <div class="col-md-6">
                                <div class="alert alert-success">
                                    <strong>Success :</strong>
                                    <?php echo htmlentities($_SESSION['msg']); ?>
                                    <?php echo htmlentities($_SESSION['msg'] = ""); ?>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($_SESSION['updatemsg'] != "") { ?>
                            <div class="col-md-6">
                                <div class="alert alert-success">
                                    <strong>Success :</strong>
                                    <?php echo htmlentities($_SESSION['updatemsg']); ?>
                                    <?php echo htmlentities($_SESSION['updatemsg'] = ""); ?>
                                </div>
                            </div>
                        <?php } ?>


                        <?php if ($_SESSION['delmsg'] != "") { ?>
                            <div class="col-md-6">
                                <div class="alert alert-success">
                                    <strong>Success :</strong>
                                    <?php echo htmlentities($_SESSION['delmsg']); ?>
                                    <?php echo htmlentities($_SESSION['delmsg'] = ""); ?>
                                </div>
                            </div>
                        <?php } ?>

                    </div>


                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Advanced Tables -->
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Authors Listing
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Author</th>

                                                <th>Creation Date</th>
                                                <th>Updation Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $sql = "SELECT * from  tblauthors";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt = 1;
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $result) {               ?>
                                                    <tr class="odd gradeX">
                                                        <td class="center"><?php echo htmlentities($cnt); ?></td>
                                                        <td class="center"><?php echo htmlentities($result->AuthorName); ?></td>
                                                        <td class="center"><?php echo htmlentities($result->creationDate); ?></td>
                                                        <td class="center"><?php echo htmlentities($result->UpdationDate); ?></td>
                                                        <td class="center">

                                                            <a href="edit-author.php?athrid=<?php echo htmlentities($result->id); ?>"><button class="btn btn-primary"><i class="fa fa-edit "></i> Edit</button>
                                                                <a href="manage-authors.php?del=<?php echo htmlentities($result->id); ?>" onclick="return confirm('Are you sure you want to delete?');"" >  <button class=" btn btn-danger"><i class="fa fa-pencil"></i> Delete</button>
                                                        </td>
                                                    </tr>
                                            <?php $cnt = $cnt + 1;
                                                }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                        <!--End Advanced Tables -->
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
        <!-- DATATABLE SCRIPTS  -->
        <script src="assets/js/dataTables/jquery.dataTables.js"></script>
        <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
        <!-- CUSTOM SCRIPTS  -->
        <script src="assets/js/custom.js"></script>
    </body>

    </html>
<?php } ?>