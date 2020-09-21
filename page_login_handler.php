<?php
  session_start();
  require_once "page_functions.php";
  
  $email = security_clean_data($_POST['login_email']);
  $password = $_POST['login_password'];
  
  if (login($email, $password)) {
    redirect_to('users');
  } else {
    redirect_to('page_login');
  }
  
?>