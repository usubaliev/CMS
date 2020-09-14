<?php include("delete_modal.php"); ?>
<?php
if (isset($_POST['checkBoxArray'])) {

        foreach ($_POST['checkBoxArray'] as $postValueID) {
        $bulk_options = $_POST['bulk_options'];

        switch ($bulk_options) { 
            
            case 'published':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueID} ";
                $update_to_published_status = mysqli_query($connection, $query);
            break;

            case 'draft':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueID} ";
                $update_to_draft_status = mysqli_query($connection, $query);
            break;

            case 'delete':
                $query = "DELETE FROM posts WHERE post_id = {$postValueID} ";
                $update_to_delete_status = mysqli_query($connection, $query);
            break;

            // CLONE SELECTED POSTS
            case 'clone':
                $query = "SELECT * FROM posts WHERE post_id = '{$postValueID}' ";
                $select_post_query = mysqli_query($connection, $query);

                while($row = mysqli_fetch_array($select_post_query)) {
                    $post_title         = $row['post_title'];
                    $post_category_id   = $row['post_category_id'];
                    $post_date          = $row['post_date'];
                    $post_author        = $row['post_author'];
                    $post_user          = $row['post_user'];
                    $post_status        = $row['post_status'];
                    $post_image         = $row['post_image'];
                    $post_tags          = $row['post_tags'];
                    $post_content       = $row['post_content'];

                    // to avoid table column shifting caused by empty data in cell add
                    if (empty($post_tags)) {
                        $post_tags = 'no entry';
                    }

                    $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_user, post_date, post_image, post_content, post_tags, post_status) ";
                    $query .= "VALUES({$post_category_id}, '{$post_title}', '{$post_author}', '{$post_user}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}') ";
                }
                $copy_query = mysqli_query($connection, $query);

                    if(!$copy_query) {
                        die("QUERY FAILED"  . mysqli_error($connection));
                    }
            break;
        }
    }
}
?>
    <form action="" method="post">
        <table class="table table-bordered table-hover">
        
        <div id="bulkOptionsContainer" class="col-xs-4" style="padding:0 0 20px 0;">
            <select class="form-control" name="bulk_options" id="">
                <option value="">Select...</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
                <option value="clone">Clone</option>
            </select>
        </div>
        
        <div id="bulkOptionsContainr" class="col-xs-4" style="padding:0 0 20px 20px;">
            <input type="submit" name="submit" class="btn btn-warning" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
        </div>  
                <thead>
                    <tr style="background-color:#f5f5f5;">
                        <th><input id="selectAllBoxes" type="checkbox" name=""></th>
                        <th class="text-center">ID</th>
                        <th class="text-center"><i class="fa fa-user fa-lg" title="ID"></i></th>
                        <th class="text-center"><i class="fa fa-flag fa-lg" title="Post Title"></i></th>
                        <th class="text-center"><i class="fa fa-send fa-lg" title="Post Status"></i></th>
                        <th class="text-center"><i class="fa fa-image fa-lg" title="Post Main Image"></i></th>
                        <th class="text-center"><i class="fa fa-folder-open fa-lg" title="Post Category"></i></th>
                        <th class="text-center"><i class="fa fa-tags fa-lg" title="Post Tags"></i></th>
                        <th class="text-center"><i class="fa fa-comments fa-lg" title="Post Comments"></i></th>
                        <th class="text-center"><i class="fa fa-calendar-o fa-lg" title="Post Date"></i></th>
                        <th class="text-center"><i class="fa fa-desktop fa-lg" title="View Post"></i></th>
                        <th class="text-center"><i class="fa fa-edit fa-lg" title="Edit Post"></i></th>
                        <th class="text-center"><i class="fa fa-trash fa-lg" title="Delete Post"></i></th>
                        <th class="text-center"><i class="fa fa-eye fa-lg" title="Post Views"></i></th>
                    </tr>
                </thead>
            <tbody>
<?php  
    
    // show only posts of current user, active session
    //$user = currentUser(); // not working because we joined tables
    
    // JOINING TABLES
    $query = "SELECT posts.post_id, posts.post_author, posts.post_user, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, ";
    $query .= "posts.post_tags, posts.post_comment_count, posts.post_date, posts.post_views_count, categories.cat_id, categories.cat_title ";
    $query .= " FROM posts ";
    $query .= " LEFT JOIN categories ON posts.post_category_id = categories.cat_id ORDER BY posts.post_id DESC";


    $select_posts = mysqli_query($connection , $query);

        while ($row = mysqli_fetch_assoc($select_posts)) {
            $post_id                = $row['post_id'];
            $post_author            = $row['post_author'];
            $post_user              = $row['post_user']; 
            $post_title             = $row['post_title'];
            $post_category_id       = $row['post_category_id'];
            $post_status            = $row['post_status'];
            $post_image             = $row['post_image'];
            $post_tags              = $row['post_tags'];
            $post_comment_count     = $row['post_comment_count'];
            $post_date              = $row['post_date'];
            $post_views_count       = $row['post_views_count'];
            // these are from joined table
            $category_title         = $row['cat_title'];
            $category_id            = $row['cat_id'];
            
            echo "<tr>";
 ?> 
                <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id ?>'></td>
 <?php    
                echo "<td class='text-right'>$post_id</td>";

                // Posts for specific user  
                if (!empty($post_author)) {
                    echo "<td>$post_author</td>";
                } elseif (!empty($post_user)){
                    echo "<td>$post_user</td>";
                }
                
                echo "<td>$post_title</td>";
                
                if ($post_status == 'published') {echo "<td class='text-center text-success'><i class='fa fa-circle fa-lg' title='Published'></td>";} 
                else {echo "<td class='text-center text-info'><i class='fa fa-circle-o fa-lg' title='Draft'></td>";}

                //echo "<td class='text-center'><img width='100' src='../images/$post_image' alt='image' /></td>";

                echo "<td class='text-center'><img width='100' src='../images/" . imagePlaceholder($post_image) . "'" . "/></td>"; 
                
                echo "<td>{$category_title}</td>";
                echo "<td style='font-size:11px;'>$post_tags</td>";

                //New way of counting comments
                $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                $send_comment_query = mysqli_query($connection, $query);

                //Pull out all comments related to the specific post
                $row = mysqli_fetch_array($send_comment_query);
                $comment_id = isset($row['comment_id']); // from stackoverflow to get rid off notices
                $count_comments = mysqli_num_rows($send_comment_query);
            
                echo "<td class='text-center'><a href='post-comments.php?id=$post_id'>$count_comments</a></td>";

                echo "<td class='text-center' style='font-size:11px;'>$post_date</td>";
                echo "<td class='text-center'><a class='btn btn-info btn-sm' href='../post.php?p_id={$post_id}' target='_blank'>View</a></td>";
                echo "<td class='text-center'><a class='btn btn-success btn-sm' href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
?>
                <form action="" method="POST">
                    <input type="hidden" name="post_id" value="<?php echo $post_id ?>">
                    <?php echo '<td class="text-center"><input class="btn btn-danger btn-sm" type="submit" name="delete" value="Delete"></td>';?>
                </form>
<?php
                // post views count
                echo "<td class='text-center'><a onClick=\"javascript: return confirm ('Are you sure to reset views count?');\" href='posts.php?reset={$post_id}'>$post_views_count</a></td>";
                echo "</tr>";
        }
?>
            </tbody>
        </table>
    </form>

<?php 
    // DELETING THE POST
    if (isset($_POST['delete'])) {
        $the_post_id= escape($_POST['post_id']);

        $query = "DELETE FROM posts WHERE post_id = {$the_post_id}";
        $delete_query = mysqli_query($connection , $query);

        header("Location: posts.php"); exit; // Added to update header (addres bar according to Edwins comment)
    }
    // Reseting post views count
    if (isset($_GET['reset'])) {
        $the_post_id= escape($_GET['reset']);

        $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = " . mysqli_real_escape_string($connection , $_GET['reset']) . " ";
        $reset_query = mysqli_query($connection , $query);

        header("Location: posts.php"); 
    }
?>
<script>
    $(document).ready(function() {
        $(".delete_link").on('click', function() {
            var id = $(this).attr("rel");
            var delete_url = "posts.php?delete="+ id +" ";
            $(".modal_del_link").attr("href", delete_url);
            $("#myModal").modal('show');
           
        })
    });
</script>
