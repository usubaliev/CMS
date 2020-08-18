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
             // catch the post id
            if (isset($_GET['p_id'])) {
                $the_post_id        = escape($_GET['p_id']);
                $the_post_author    = escape($_GET['author']);
            }

                $query = "SELECT * FROM posts WHERE post_user = '{$the_post_author}' ";
                $select_all_posts_query = mysqli_query($connection , $query);
                while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                    $post_id        = $row["post_id"];
                    $post_title     = $row["post_title"];
                    $post_author    = $row["post_user"];
                    $post_date      = $row["post_date"];
                    $post_image     = $row["post_image"];
                    $post_content   = substr($row["post_content"], 0 , 220);
            ?>   
               
                
                <!-- First Blog Post -->
                <h2>
                <h2><a href="post/<?php echo $post_id;?>"><?php echo $post_title; ?> </a></h2>
                </h2>
                <p class="lead">All posts by <?php echo $post_author;?>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                <hr>
                <img class="img-responsive" src="../../images/<?php echo $post_image; ?>"alt="">
                <hr>
                <p><?php echo $post_content; ?></p>
                <a class='btn btn-primary' href="post/<?php echo $post_id;?>">Read More <span class='glyphicon glyphicon-chevron-right'></span></a>

                <hr>
            <?php } ?>
            
            <!-- Blog Comments removed-->

</div>
<?php include "includes/sidebar.php" ?>
        <hr>
<?php include "includes/footer.php"; ?>
       
