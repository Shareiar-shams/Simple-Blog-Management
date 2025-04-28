<?php
  session_start();

  if(!(isset($_SESSION['email'])))
  {
      header("location:login.php");
  }
  else
  {
      $name = $_SESSION['name'];
      $email = $_SESSION['email'];
  }
?>


<?php function section(){ 
    include 'components/tag_data.php';
  } 
  include('layout.php');
?>
    
