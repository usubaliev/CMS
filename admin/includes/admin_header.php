<?php include "../includes/db.php" //$connection ?> 
<?php include "functions.php" ?>
<?php 
// start Output buffering - to send requests at one time not one by one
ob_start(); ?>
<?php session_start(); ?>

<?php  // check USER ROLE. Only admin can login to CMS
    if (!isset($_SESSION['user_role'])) {
        header("Location: ../index.php");
    }  
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>myCMS</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- for GOOGLE CHARTS API -->    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 
</head>
<body>