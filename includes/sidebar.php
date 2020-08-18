<?php 
// removed form action with values to respond new login/forgot password form

    if (ifItIsMethod('post')) {
            
        if (isset($_POST['username']) && isset($_POST['password'])) {
            login_user($_POST['username'], $_POST['password']);
        } else {
            redirect('index');
        }
    }
?>
<!-- Blog Sidebar Widgets Column -->
<div class="col-md-4">
    <!-- Blog Search Well -->
  
    <div class="well">
        <h4>Blog Search</h4>
        <!-- search form - connected via search.php to DB -->
        <form action="search.php" method="post">
            <div class="input-group">
                <input name="search" type="text" class="form-control">
                <span class="input-group-btn">
                    <button name="submit" type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"></span>
                </button>
                </span>
            </div>
        </form>
        <!-- /.input-group -->
    </div>

    <!-- Login form -->
    <div class="well">
        <?php // Show logged in user name instead login form and short version of IF statement 
            if(isset($_SESSION['user_role'])): ?>

            <h4>Logged in as <?php echo $_SESSION['username']; ?></h4>
            <a href="/cms/includes/logout.php" class="btn btn-primary">Logout</a>

            <?php else: ?> 
 
            <h4>Login</h4>  
            <form method="post">
                <div class="form-group">
                    <input name="username" type="text" class="form-control" placeholder="Username">
                </div>
                <div class="input-group">
                    <input name="password" type="password" class="form-control" placeholder="Password">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" name="login" type="submit">Login</button>
                    </span>
                </div>
                <div class="form-group">
                    <a href="forgot.php?forgot=<?php echo uniqid(true);?>">Forgot Password</a>
                </div>
            </form>

            <?php endif; ?>
    </div> 

    <!-- Blog Categories Well -->
    <div class="well">
    <?php 
        $query = "SELECT * FROM categories ";
        $select_categories_sidebar = mysqli_query($connection , $query);
    ?>
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
    <?php 
                while ($row = mysqli_fetch_assoc($select_categories_sidebar)) {
                    $cat_title = $row["cat_title"];
                    $cat_id = $row["cat_id"];
                    echo "<li><a href='/cms/category/$cat_id'>{$cat_title}</a></li>";
                }
    ?>
                </ul>
            </div>
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
   <?php include "widget.php" ?>

</div>

</div>
    <!-- /.row -->