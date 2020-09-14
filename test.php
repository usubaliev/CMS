<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<?php 
    echo loggedInuserId();
    
   if (userLikedThisPost(151)) {
        echo "user like it";
    } else {
        echo "User did not like ";
    } 

?>


<div class="row">
    <div class="col-md-4">
            
<?php
    class apple {
        public function __toString() {
            return "green";
        }
    }

        echo "1) ".var_export(substr("pear", 0, 2), true).PHP_EOL;
        echo "2) ".var_export(substr(54321, 0, 2), true).PHP_EOL;
        echo "3) ".var_export(substr(new apple(), 0, 2), true).PHP_EOL;
        echo "4) ".var_export(substr(true, 0, 1), true).PHP_EOL;
        echo "5) ".var_export(substr(false, 0, 1), true).PHP_EOL;
        echo "6) ".var_export(substr("", 0, 1), true).PHP_EOL;
        echo "7) ".var_export(substr(1.2e3, 0, 4), true).PHP_EOL;

        echo substr($row["post_content"], 0 , 220);

        echo substr('post_content', 0, 200);  // abcd
        echo substr('abcdef', 0, 4);  // abcd
?>



    </div>
</div>