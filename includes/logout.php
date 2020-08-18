<?php ob_start(); ?> 
<?php session_start(); ?> 
<?php require_once "../admin/functions.php" ?>
<?php 
      $_SESSION['username']   = null;
      $_SESSION['firstname']  = null;
      $_SESSION['lastname']   = null;
      $_SESSION['user_role']  = null;

      //header("Location: cms/"); 
      redirect("/cms");
?>