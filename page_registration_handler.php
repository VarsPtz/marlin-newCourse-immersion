<?php
session_start();
require_once "page_functions.php";
  
  $email = security_clean_data($_POST['user_email']);
  $password = $_POST['user_password'];
  
  $user = get_user_by_email($email);
  
  if(!empty($user)) {
    set_flash_message('danger', "Этот эл. адрес уже занят другим пользователем.");
    redirect_to('page_register');
  }
  
  $_SESSION['user_id'] = add_user($email, $password);
  
  set_flash_message('success', "Регистрация успешна");
  redirect_to('page_login');
?>