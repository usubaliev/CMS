<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    //trigger_error("Some info",E_USER_ERROR);  This was for creating an error log file for xampp
?>
    <?php include "includes/db.php"; ?>
    <?php include "includes/header.php"; ?>
    <?php include "includes/navigation.php"; ?>
    
    <!-- Page Content -->
    <div class="container">

        <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-8">
    <?php 
            
            $per_page = 5; // another way to limit posts per page

            // PAGINATION and MATH
            if (isset($_GET['page'])) {
                $page = escape($_GET['page']);
            }else {
                $page = "";
            }
            if ($page == "" || $page == 1) {
                $page_1 = 0;
            } else {
                $page_1 = ($page * $per_page) - 5;
            }

            if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
                $post_query_count = "SELECT * FROM posts";
            } else {
                $post_query_count = "SELECT * FROM posts WHERE post_status = 'published' ";
            }

            // First get total count of posts - find_count with mysqli_num_rows
            //$post_query_count = "SELECT * FROM posts WHERE post_status = 'published' ";
            $find_count = mysqli_query($connection, $post_query_count);
            $count = mysqli_num_rows($find_count); 
            
            //show NO POSTS message if post count less than 1
            if ($count < 1) {
                echo "<div class='alert alert-warning' role='alert'><b>No post to display. Sorry!</b></div>";
            } else {
                
            $count = ceil($count / $per_page); //round-up float number with ceil();

            $query = "SELECT * FROM posts LIMIT $page_1, $per_page";
            $select_all_posts_query = mysqli_query($connection , $query);

                while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                    $post_id        = $row['post_id'];
                    $post_title     = $row["post_title"];
                    $post_author    = $row['post_user'];
                    $post_date      = $row["post_date"];
                    $post_image     = $row["post_image"];

                    // truncate - show small part of the content: excerpt
                    $post_content   = substr($row["post_content"], 0 , 220);
                    
                    // display something if there is nothing on the page
                    $post_status      = $row["post_status"];
        ?>
                

                <!-- First Blog Post -->
                
                <h2><a href="post/<?php echo $post_id; ?>"><?php echo $post_title; ?> </a></h2>
                <p class="lead">by <a href="authors/<?php echo $post_author?>/<?php echo $post_id; ?>"><?php echo $post_author ?></a></p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                <hr>
                <a href="post/<?php echo $post_id; ?>"><img class="img-responsive" src="images/<?php echo imagePlaceholder($post_image);?>"alt=""></a>
                <hr>
                <p><?php echo $post_content; ?></p>
                <a class='btn btn-primary' href="post/<?php echo $post_id;?>">Read More <span class='glyphicon glyphicon-chevron-right'></span></a>
                <hr>
                
        <?php  } } ?>

            <!-- Pagination -->
                <ul class="pager">
        <?php 
                for ($i=1; $i<=$count; $i++) { 
                    // styling active link of the pagination
                    if ($i == $page) {
                        echo "<li><a class='current' href='index.php?page={$i}'>{$i}</a></li>";
                    }else {
                        echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                    }
                }
        ?>
                </ul>
    </div>
            
<?php include "includes/sidebar.php" ?>
<hr>
<?php include "includes/footer.php"; ?>
       
