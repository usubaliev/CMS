    <form action="" method="post">
        <label for="cat-title">Rename category</label>

        <?php // EDIT 

            if (isset($_GET['edit'])) {
                $cat_id =   escape( $_GET['edit']);
            
            $query = "SELECT * FROM categories WHERE cat_id = $cat_id ";
            $select_categories_id = mysqli_query($connection , $query);
       
            while ($row = mysqli_fetch_assoc($select_categories_id)) {
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];   
                
        ?>  
            <div class="form-group"><input value ="<?php if(isset($cat_title)){echo $cat_title;}?>" class="form-control" type="text" name="cat_title"></div>

        <?php }} ?>   

        <?php // update a category name query
        if (isset($_POST['update_category'])) {
            $the_cat_title = escape($_POST['cat_title']);

            $stmt = mysqli_prepare($connection, "UPDATE categories SET cat_title = ? WHERE cat_id = ? ");
            mysqli_stmt_bind_param($stmt, 'si', $the_cat_title, $cat_id); // at the line above first ? was 'S'tring and the next ? is a 'I'nteger, so we put 'si'
            mysqli_stmt_execute($stmt);

            // we don't need this one anymore $update_query = mysqli_query($connection,$query); 
            if (!$stmt) {
                die ("QUERY FAILED" . mysqli_error($connection));
            }
            mysqli_stmt_close($stmt);
            redirect("categories.php");
        }
    ?>
        <div class="form-group">
            <input class="btn btn-info" type="submit" name="update_category" value="Rename">
        </div>
    </form>