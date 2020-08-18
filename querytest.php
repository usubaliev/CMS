    <?php include "includes/db.php"; ?>
    <?php include "includes/header.php"; ?>
    <?php include "includes/navigation.php"; ?>
  
    
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-8">
        <h1>QUERY TEST</h1>
    </div>
            
<?php 

$query_string = "SELECT * FROM categories";
$query = mysqli_query($connection, $query_string) or die(mysqli_error());
?>
<ul>
<?php

    while ($row = mysqli_fetch_assoc($query)){
       echo '<li>' , $row['cat_title'], '</li>';
    
}
    ?>


</ul>
</div>










<?php include "includes/sidebar.php" ?>
        <hr>
<?php include "includes/footer.php"; ?>
       
