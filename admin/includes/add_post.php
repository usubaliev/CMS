<?php
    if(isset($_POST['create_post'])){
            $post_title         = escape($_POST['title']);
            $post_user          = escape($_POST['post_user']);
            $post_category_id   = escape($_POST['post_category']);
            $post_status        = escape($_POST['post_status']);
            
            $post_image         = $_FILES['image']['name'];
            $post_image_temp    = $_FILES['image']['tmp_name'];
            
            $post_tags          = escape($_POST['post_tags']);
            $post_content       = escape($_POST['post_content']);
            $post_date          = escape(date('d-m-Y'));
            
      //move_uploaded_file($post_image_temp, "/images/$post_image");
        move_uploaded_file($post_image_temp, "../images/$post_image" );
        
        $query = "INSERT INTO posts(post_category_id, post_title, post_user, post_date, post_image, post_content, post_tags, post_status) ";

        $query .= "VALUES ({$post_category_id},'{$post_title}','{$post_user}',now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_status}' )";

        $create_post_query = mysqli_query($connection, $query);
        confirmQuery($create_post_query);

        //we dont have post ID but we can pull out last ID with "mysqli_insert_id();
        $the_post_id = mysqli_insert_id($connection);
        
        echo "<div class='alert alert-success' role='alert'><b>Post created!</b> <a href='../post.php?p_id={$the_post_id}'>View Post </a> or <a href='posts.php'>Edit More Posts</a></div>";
    }
?>

<form action="" method="post" enctype="multipart/form-data">
<!-- ecntype is for sending different form data -->
    <div class="form-group">
        <label for="title"><i class="fa fa-flag"></i> Title:</label>
        <input type="text" class="form-control" name="title">
    </div>
    <!-- Columns (col-6 col-sm-3) -->
    <div class="row"> 
        <div class="col-6 col-sm-3">
            <div class="form-group">
                <label for="category"><i class="fa fa-folder-open"></i> Categories:</label>
                    <select name="post_category" id="" class="form-control">
                <?php 
                    // Category dropdown
                    $query = "SELECT * FROM categories ";
                    $select_categories = mysqli_query($connection , $query);

                    confirmQuery($select_categories);
 
                    while ($row = mysqli_fetch_assoc($select_categories)) {
                        $cat_id = $row['cat_id'];
                        $cat_title = $row['cat_title'];  

                        echo "<option value='{$cat_id}'>{$cat_title}</option>";
                    }
                ?>
                    </select>
            </div>
        </div>
        <!-- Users (was Author) dropdown -->
        <div class="col-6 col-sm-3">
            <div class="form-group">
                <label for="users"><i class="fa fa-user"></i> Users:</label>
                    <select name="post_user" id="" class="form-control">
                <?php 
                    $query = "SELECT * FROM users ";
                    $select_users = mysqli_query($connection , $query);

                    confirmQuery($select_users);

                    while ($row = mysqli_fetch_assoc($select_users)) {
                        $user_id = $row['user_id'];
                        $username = $row['username'];  

                        echo "<option value='{$username}'>{$username}</option>";
                    }
                ?>
                    </select>
            </div>
        </div>
        <!-- Force next columns to break to new line - UPDATE BOOTSTRAP TO V4.0 -->
        <div class="w-100"></div>
        <!-- Post status -->    
        <div class="col-6 col-sm-3">
            <div class="form-group">
            <label for="users"><i class="fa fa-send"></i> Post status:</label>   
                <select name="post_status" id="" class="form-control">
                    <option value="draft">Post status</option>
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                </select>
            </div>
        </div>
        <!-- Image upload -->
        <div class="col-6 col-sm-3">
            <div class="form-group">
                <label for="post_image"><i class="fa fa-image"></i> Image:</label>
                <input type="file" class="form-control" name="image">
            </div>
        </div>
    </div>
    <!-- end of Columns (col-6 col-sm-3) -->
    <!-- Post Tags -->    
    <div class="form-group">
        <label for="post_tags"><i class="fa fa-tags"></i> Tags:</label>
        <input type="text" class="form-control" name="post_tags">
    </div>
    <!-- Post content -->
    <div class="form-group">
        <label for="post_content"><i class="fa fa-file-text"></i> Content:</label>
        <textarea type="text" class="form-control" name="post_content" id="body" cols="30" rows="10"> </textarea>
    </div>
    <!-- Submit  -->
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>
</form>