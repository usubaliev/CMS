<?php 
    if (isset($_GET['p_id'])) {
        // convert ['p_id'] into a variable
        $the_post_id = escape($_GET['p_id']);
    }

     $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
     $select_posts_by_id = mysqli_query($connection , $query);
 
     while($row = mysqli_fetch_assoc($select_posts_by_id)) {
        $post_id            = $row['post_id'];
        $post_user          = $row['post_user'];
        $post_title         = $row['post_title'];
        $post_category_id   = $row['post_category_id'];
        $post_status        = $row['post_status'];
        $post_image         = $row['post_image'];
        $post_content       = $row['post_content'];
        $post_tags          = $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_date          = $row['post_date'];
        
    }   
        
    // detecting sumbit click [update post]

    if (isset($_POST['update_post'])) {
            
            $post_user             = escape($_POST['post_user']);
            $post_title            = escape($_POST['post_title']);
            $post_category_id      = escape($_POST['post_category']);
            $post_status           = escape($_POST['post_status']);
            $post_image            = escape($_FILES['image']['name']);
            $post_image_temp       = escape($_FILES['image']['tmp_name']);
            $post_content          = escape($_POST['post_content']);
            $post_tags             = escape($_POST['post_tags']);

        move_uploaded_file($post_image_temp, "../images/$post_image");

        if(empty($post_image)) {
        
            $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
            $select_image = mysqli_query($connection,$query);
                
            while($row = mysqli_fetch_array($select_image)) {
                
               $post_image = $row['post_image'];
            }
        }

    $post_title = mysqli_real_escape_string($connection, $post_title);
            
            $query = "UPDATE posts SET ";
            $query .="post_title            = '{$post_title}', ";
            $query .="post_category_id      = '{$post_category_id}', ";
            $query .="post_date             =  now(), ";
            $query .="post_user             = '{$post_user}', ";
            $query .="post_status           = '{$post_status}', ";
            $query .="post_tags             = '{$post_tags}', ";
            $query .="post_content          = '{$post_content}', ";
            $query .="post_image            = '{$post_image}' ";
            $query .= "WHERE post_id        = {$the_post_id} ";
        
            $update_post = mysqli_query($connection,$query);
            
            confirmQuery($update_post);
            
            echo "<div class='alert alert-success' role='alert'><b>Post updated!</b> 
            <a href='../post.php?p_id={$the_post_id}'>View Post </a> or <a href='posts.php'>Edit More Posts</a></div>";
    }
?>

<form action="" method="post" enctype="multipart/form-data">
<!-- ecntype is for sending different form data -->
    <div class="row"> 
        <div class="col-12 col-md-8">
            <div class="form-group">
                <label for="title">Title:</label>
                <input value="<?php echo $post_title;?>" type="text" class="form-control" name="post_title">
            </div>
                <div class="row"> 
                    <div class="col-6 col-sm-4">
                        <div class="form-group">
                            <label for="users">Categories:</label>
                            <select name="post_category" id="" class="form-control">
                            <?php 
                                // Category dropdown
                                $query = "SELECT * FROM categories ";
                                $select_categories = mysqli_query($connection , $query);

                                confirmQuery($select_categories);

                                while ($row     = mysqli_fetch_assoc($select_categories)) {
                                    $cat_id     = $row['cat_id'];
                                    $cat_title  = $row['cat_title'];  

                                    if ($cat_id == $post_category_id) {
                                        echo "<option selected value='{$cat_id}'>{$cat_title}</option> ";
                                    } else {
                                        echo "<option value='{$cat_id}'>{$cat_title}</option>";
                                    }
                                }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-6 col-sm-4">
                        <div class="form-group">
                            <!-- Users (was Author) dropdown -->
                            <label for="users">Users:</label>
                            <select name="post_user" id="" class="form-control">

                            <?php //get current user
                                echo "<option selected value='{$post_user}'>{$post_user}</option>";
                            ?> 
                            <?php 
                                $query = "SELECT * FROM users ";
                                $select_users = mysqli_query($connection , $query);

                                confirmQuery($select_users);

                                while ($row     = mysqli_fetch_assoc($select_users)) {
                                    $user_id    = $row['user_id'];
                                    $username   = $row['username'];  

                                    echo "<option value='{$username}'>{$username}</option>";
                                }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-6 col-sm-4"> 
                        <div class="form-group">
                            <!-- Post status dropdown -->
                            <label for="users">Post status:</label>  
                            <select name="post_status" id="" class="form-control">
                                <option value='<?php echo $post_status;?>'><?php echo $post_status;?></option>
                            <?php 
                                if ($post_status == 'published') {
                                    echo "<option value='draft'>Draft</option>";
                                }else {
                                    echo "<option value='published'>Published</option>";
                                }
                            ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-12 col-md-12">
                            <div class="form-group">
                                <!-- Tags -->
                                <label for="post_tags">Tags:</label>
                                <input value="<?php echo $post_tags;?>" type="text" class="form-control" name="post_tags">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-4">
                    <div class="form-group">
                        <!-- Current image -->
                        <label for="post_image">Current image:</label>
                        <img class="img-responsive" src="../images/<?php echo $post_image;?>" alt="">
                    </div>
                    
                    <div class="form-group">
                        <!-- Upload new image -->
                        <label for="post_image">Select new image:</label>
                        <input  type="file" name="image" class="form-control">
                    </div>
            </div>
    </div>
    <div class="form-group">
        <label for="post_content">Content:</label>
        <textarea type="text" class="form-control" name="post_content" id="body" cols="30" rows="10"><?php echo $post_content; // str_repace to void CKEditor showing \r\n instead empty line  //<?php echo str_replace('\r\n', '</br>', $post_content); ?></textarea>
        
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_post" value="Update post">
    </div>
</form>

