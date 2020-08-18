<?php include "includes/admin_header.php" ?>

<div id="wrapper">
<!-- Navigation -->
<?php include "includes/admin_navigation.php" ?>

    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Categories
                    </h1>
                </div>
                <div class="col-xs-6">

                        <?php insert_categories(); ?>

                        <form action="" method="post">
                            <label for="cat-title">Add new category</label>
                            <div class="form-group">
                                <input class="form-control" type="text" name="cat_title">
                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" name="submit" value="Add New">
                            </div>
                        </form>

        
                        <?php 
                            // UPDATE AND INCLUDE QUERY - include update-categories.php with IF isset
                            if (isset($_GET['edit'])) {
                                $cat_id = escape($_GET['edit']);
                                include "includes/update-categories.php";
                            } 
                        ?>
                </div>
                <div class="col-xs-6">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr style="background-color:#f5f5f5;">
                                <th class='text-center'>ID</th>
                                <th><i class="fa fa-folder-open fa-lg" title="Categories"></i></th>
                                <th class="text-center"><i class="fa fa-edit fa-lg" title="Rename"></i></th>
                                <th class="text-center"><i class="fa fa-trash fa-lg" title="Delete"></i></th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php findAllCategories();?>
                        <?php delete_categories();?>

                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "includes/admin_footer.php" ?>
