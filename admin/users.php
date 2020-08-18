<?php include "includes/admin_header.php"; ?>

<?php // comes from functions.php - cheking if user is subscriber cannot view some pages but redirects to admin.index.php in cms. future changes expected... 
    if (!is_admin($_SESSION['username'])) {
        header ("Location: index.php");
    }
?>


<div id="wrapper">
    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"; ?>

        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Posts
                            <small>Author</small>
                        </h1>

 <?php 
    if (isset($_GET['source'])) {
        $source = escape($_GET['source']);
    } else {
        $source = '' ;
    }

    switch($source){
        case 'add_user';
        include "includes/add_user.php";
        break;

        case 'edit_user';
        include "includes/edit_user.php";
        break;

        case '200';
        echo "NICE 200";
        break;

        default;

        include "includes/view-all-users.php";

        }
?>

                    </div>
                </div>
            </div>
        </div>
</div>
<?php include "includes/admin_footer.php" ?>
