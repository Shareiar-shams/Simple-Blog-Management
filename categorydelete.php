<?php
  session_start();
  
  require_once 'db.php'; 

  require_once 'app/dashboard-controller.php'; 
  $bot = new Dashboard_Controller();

  $id = $_GET['id'];

  

  $condition = "`id` = $id";
  $sessionData = $bot->delete('categories',$condition);
  if($sessionData !== false)
      $_SESSION['success_message'] = "Category Delete successfully.";
  else
      $_SESSION['error_message'] = "Something want wrong.";

  header("Location: category.php");
  exit();
?>