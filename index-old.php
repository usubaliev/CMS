    <?php include "includes/db.php"; ?>
    <!-- Header -->
    <?php include "includes/header.php"; ?>
    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

            <?php 
                $query = "SELECT * FROM posts";
                $select_all_posts_query = mysqli_query($connection , $query);
                while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                    $post_id        = $row['post_id'];
                    $post_title     = $row["post_title"];
                    $post_author    = $row["post_author"];
                    $post_date      = $row["post_date"];
                    $post_image     = $row["post_image"];
                    // truncate - show small part of the content: excerpt
                    $post_content   = substr($row["post_content"], 0 , 250);
                    
                    // display something if there is nothing on the page
                    $post_status      = $row["post_status"];
                    
                    if ($post_status == 'published') {
                        /* echo "<div class='alert alert-warning' role='alert'>
                        <b>No post to display. Sorry!</b>
                      </div>"; */
                    } else {
            
            ?>

                <h1 class="page-header"> 
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
                <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?> </a>
                </h2>
                <p class="lead">by <a href="author_posts.php?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author; ?></a>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date; ?></p>
                <hr>
                <a href="post.php?p_id=<?php echo $post_id; ?>">
                    <img class="img-responsive" src="images/<?php echo $post_image;?>"alt="">
                </a>
                <hr>
                <p><?php echo $post_content; ?></p>
                <a class='btn btn-primary' href="post.php?p_id=<?php echo $post_id;?>">Read More <span class='glyphicon glyphicon-chevron-right'></span></a>

                <hr>
            <?php }} ?>
            
        </div>
            
<?php include "includes/sidebar.php" ?>
        <hr>
<?php include "includes/footer.php"; ?>
       
