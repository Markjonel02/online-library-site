<div class="navbar navbar-inverse set-radius-zero " style="background-color: #fff !important; padding: 10px !important;">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>


            <img src="../assets/img/ACLClogo.png" height=100 width=100 style=" box-sizing: border-box; width: 100px;height: auto; display: flex;  align-items: center;  justify-content: center; overflow: hidden;" />


        </div>

        <div class="right-div" style="display: flex; align-items: center; justify-content: center; ">
            <a href="logout.php" class="btn btn-danger" id="logout-button">LOG ME OUT</a>
        </div>

    </div>
</div>
<!-- LOGO HEADER END-->
<section class="menu-section" style="background-color: #427dfcff !important; border-bottom: 0 none !important;">
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="navbar-collapse collapse ">
                    <ul id="menu-top" class="nav navbar-nav navbar-right">
                        <li><a href="dashboard.php" class="menu-top-active">DASHBOARD</a></li>

                        <li>
                            <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown"> Categories <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="add-category.php" class="">Add Category</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="manage-categories.php">Manage Categories</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown"> Authors <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="add-author.php">Add Author</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="manage-authors.php">Manage Authors</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown"> Books <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="add-book.php">Add Book</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="manage-books.php">Manage Books</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown"> Issue Books <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="issue-book.php">Issue New Book</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1" href="manage-issued-books.php">Manage Issued Books</a></li>
                            </ul>
                        </li>
                        <li><a href="reg-students.php">Reg Students</a></li>

                        <li><a href="change-password.php">Change Password</a></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>


<script>
    document.getElementById('logout-button').addEventListener('click', function(e) {
        e.preventDefault(); // Prevent default link behavior
        const confirmLogout = confirm('Are you sure you want to log out?');
        if (confirmLogout) {
            // Redirect to logout URL
            window.location.href = 'logout.php?logout=true';
        }
    });
</script>

<style>
    .logout-button {
        display: inline-block;
        padding: 10px 20px;
        color: #ffffff;
        background-color: #d9534f;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .logout-button:hover {
        background-color: #c9302c;
    }
</style>