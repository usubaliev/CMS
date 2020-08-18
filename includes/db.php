<?php ob_start(); ?> 
<?php 
    //$connection = mysqli_connect ('localhost' , 'root' , '' , 'cms');
    //if ($connection) {
    //    echo "connected";
    //}
    // easiest way abowe but better secure way below

    $db['db_host'] = "localhost";
    $db['db_user'] = "root";
    $db['db_pass'] = "";
    $db['db_name'] = "cms";

    foreach ($db as $key => $value) {
       define(strtoupper($key), $value);
    }
    $connection = mysqli_connect (DB_HOST , DB_USER , DB_PASS , DB_NAME);
?>