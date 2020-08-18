<?php include "includes/db.php"; ?>
    <?php include "includes/header.php"; ?>
    <?php include "includes/navigation.php"; ?>
  
    
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-8">
        
        <?php 

            if (isset($_GET['category'])) { 
                $post_category_id = $_GET['category'];

                // change to use with PREPARE STATEMENT | stmt | placeholder ? etc.. put "i" for integer, "s" for string
                if(is_admin($_SESSION['username'])) {
                    // statement No: 1
                    $stmt1 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_category_id = ?");
                } else {
                    // statement No: 2
                    $stmt2 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_category_id = ? AND post_status = ? ");

                    $published = 'published';
                }
                
                    if (isset($stmt1)) {
                        mysqli_stmt_bind_param($stmt1, "i", $post_category_id); 
                        mysqli_stmt_execute($stmt1);
                        mysqli_stmt_bind_result($stmt1, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);

                        $stmt = $stmt1;

                    } else {
                        mysqli_stmt_bind_param($stmt2, "is", $post_category_id, $published);
                        mysqli_stmt_execute($stmt2);
                        mysqli_stmt_bind_result($stmt2, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);
                        
                        $stmt = $stmt2;
                    }
                
                if (mysqli_stmt_num_rows($stmt) === 0) {
                    echo "<div class='alert alert-warning' role='alert'><b>No categories available.</b></div>";
                } 
                    
            while (mysqli_stmt_fetch($stmt)):
        ?>

                <!-- First Blog Post -->
                <h2>
                <a href="../post/<?php echo $post_id; ?>"><?php echo $post_title; ?> </a>
                </h2>
                <p class="lead">by <a href="index.php"><?php echo $post_author; ?></a>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                <hr>
                <img class="img-responsive" src="../images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo $post_content; ?></p>
                <a class='btn btn-primary' href="../post/<?php echo $post_id;?>">Read More <span class='glyphicon glyphicon-chevron-right'></span></a>
                <hr>
        <?php 
            endwhile;
            // closing statement
            mysqli_stmt_close($stmt);
        }   else { // if there is no category redirect to index with redirect function
                  
                    redirect("index.php");
        }
        ?>
    </div>
            
<?php include "includes/sidebar.php" ?>
        <hr>
<?php include "includes/footer.php" ?>
       
