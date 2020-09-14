<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "includes/navigation.php"; ?>

<?php 
    if (isset($_POST['liked'])) {
        
        $post_id = $_POST['post_id']; // Getting from AJAX request
        $user_id = $_POST['user_id']; 

        // 1.   Select (fetching) the post
        $query = "SELECT * FROM posts WHERE post_id=$post_id";
        $postResult = mysqli_query($connection, $query);
        $post = mysqli_fetch_array($postResult);
        $likes = $post['likes'];
        
        // 2.   Add (Incrementing likes)
        mysqli_query($connection, "UPDATE posts SET likes=$likes+1 WHERE post_id=$post_id");

        // 3.   Create likes for the specific post
        mysqli_query($connection, "INSERT INTO likes(user_id, post_id) VALUES($user_id, $post_id)");
        
        exit;
    }

    if (isset($_POST['unliked'])) {

        $post_id = $_POST['post_id']; 
        $user_id = $_POST['user_id']; 

        // 1.   select (fetching) the post
        $query = "SELECT * FROM posts WHERE post_id=$post_id";
        $postResult = mysqli_query($connection, $query);
        $post = mysqli_fetch_array($postResult);
        $likes = $post['likes'];

        // 2.   Substract (Decrementing likes)
        mysqli_query($connection, "DELETE from likes WHERE post_id=$post_id AND user_id = $user_id");

        
        // 2.   update post with likes
        mysqli_query($connection, "UPDATE posts SET likes=$likes-1 WHERE post_id=$post_id");

        exit; 
    }

?>
    
<!-- Page Content -->
    <div class="container">
        <div class="row">
        <!-- Blog Entries Column -->
            <div class="col-md-8">

        <?php 
             // catch the post id
            if (isset($_GET['p_id'])) {
                $the_post_id = escape($_GET['p_id']);
                
                //Post views count query
                $view_query = "UPDATE posts SET post_views_count = post_views_count +1 WHERE post_id = $the_post_id ";
                $send_query = mysqli_query($connection, $view_query);

                    if (!$send_query) {
                        die ("QUERY FAILED!" . mysqli_error($connection));
                    }

                // ONLY ADMINS CAN SEE draft posts
                if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
                    $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
                } else {
                    $query = "SELECT * FROM posts WHERE post_id = $the_post_id AND post_status = 'published' ";
                }
                    $select_all_posts_query = mysqli_query($connection , $query);

                if (mysqli_num_rows($select_all_posts_query) < 1) {
                    echo "<div class='alert alert-warning' role='alert'><b>No post to display. Sorry!</b></div>";
                } else { 

                while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                    $post_id        = $row["post_id"];
                    $post_title     = $row["post_title"];
                    $post_author    = $row["post_author"];
                    $post_date      = $row["post_date"];
                    $post_image     = $row["post_image"];
                    $post_content   = $row["post_content"];
        ?>   
                    <!-- First Blog Post -->
                    <h2><a href="/cms/post/<?php echo $post_id; ?>"><?php echo $post_title ?></a></h2>
                    <p class="lead">by <a href="authors/<?php echo $post_author?>/<?php echo $post_id; ?>"><?php echo $post_author ?></a></p>
                    <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                    <hr>
                    <img class="img-responsive" src="/cms/images/<?php echo imagePlaceholder($post_image);?>" alt="Image">
                    <hr>
                    <p><?php echo $post_content; ?></p>
                    <hr>
        <?php 
        // we don't have mysqli_stmt
        //mysqli_stmt_free_result($stmt);

        //Show Likes if user not logged in
            
            if (isLoggedIn()) { ?>
             
                <!-- Likes -->
                
                    <div class="col-md-6">
                            <a class="<?php echo userLikedThisPost($the_post_id) ? 'unlike' : 'like'; ?>" 
                            href=""><i class="fa fa-thumbs-up fa-lg" data-toggle="tooltip" data-placement="top" title="<?php echo userLikedThisPost($the_post_id) ? ' I liked this before' : 'Want to like it?'; ?>"></i> <?php echo userLikedThisPost($the_post_id) ? ' Unlike' : ' Like'; ?>
                            </a>
                    </div>
        <?php } else { ?>
                    <div class="col-md-6">
                        <p>You need to <a href="/cms/login"><b>Login</b></a> to like</p>
                    </div>
        <?php } ?>            
                    <div class="col-md-6">
                        <span class="pull-right"><?php getPostLikes($the_post_id); ?> Likes</span>
                    </div>
                    <div class="clearfix"></div>
                <hr>
        <?php   }   ?>
                
                <!-- Blog Comments -->
        <?php 
                    if (isset($_POST['create_comment'])) {
                        $the_post_id = escape($_GET['p_id']);

                        $comment_author     = escape($_POST['comment_author']);
                        $comment_email      = escape($_POST['comment_email']);
                        $comment_content    = escape($_POST['comment_content']);

                        // check form field are empty or not:
                        if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {

                            $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
                            $query .= "VALUES ($the_post_id , '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved', now() )";
                            $create_comment_query = mysqli_query($connection, $query);

                            if (!$create_comment_query) {
                                die('Query Failed' . mysqli_error($connection));
                            }
                        } else {
                            echo "<script>alert('Fields cannot be empty')</script>";
                        }
                    }
        ?>
            <!-- Comments Form -->
            <div class="well">
                <h4>Leave a Comment:</h4>
                <form action="" method="post" role="form">
                    <div class="form-group">
                        <label for="comment_author">Author</label>
                        <input type="text" class="form-control" name="comment_author">
                    </div>
                    <div class="form-group">
                    <label for="comment_email">Email</label>
                        <input type="email" class="form-control" name="comment_email">
                    </div>
                    <div class="form-group">
                    <label for="comment">Your comment</label>
                        <textarea name="comment_content" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <hr>

        <!-- Posted Comments -->
    <?php 
            // DISPLAY COMMENTS BASED ON APPROVAL
            $query = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id} ";
            $query .= "AND comment_status = 'approved' ";
            $query .= "ORDER BY comment_id DESC ";
            $select_comment_query = mysqli_query($connection, $query);

                if(!$select_comment_query) {
                    die('Query Failed' . mysqli_error($connection));
                }

            while ($row = mysqli_fetch_array($select_comment_query)) {
            $comment_date   = $row['comment_date']; 
            $comment_content= $row['comment_content'];
            $comment_author = $row['comment_author'];
    ?>
                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author;?>
                            <small><?php echo $comment_date;?></small>
                        </h4>
                        <?php echo $comment_content;?>
                    </div>
                </div>

<?php   }   }   } else {
                    header("Location: index.php");
                }
?>
</div>
<?php include "includes/sidebar.php" ?>
<hr>
<?php include "includes/footer.php"; ?>
       
<script>

     $(document).ready(function() {
        
        $("[data-toggle='tooltip']").tooltip();

        var post_id = <?php echo $the_post_id; ?>;
        var user_id = <?php echo loggedInUserId(); ?>;
        
        // Like
        $('.like').click(function() {
            $.ajax({
                url: "/cms/post.php?p_id=<?php echo $the_post_id; ?>",
                type: 'post',
                data: {
                    'liked': 1,
                    'post_id': post_id,
                    'user_id': user_id
                }
            });
        });

        // Unlike
        $('.unlike').click(function() {
            $.ajax({
                url: "/cms/post.php?p_id=<?php echo $the_post_id; ?>",
                type: 'post',
                data: {
                    'unliked': 1,
                    'post_id': post_id,
                    'user_id': user_id
                }
            });
        });
    });
</script>