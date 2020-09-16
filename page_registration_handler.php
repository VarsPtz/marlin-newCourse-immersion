<?php
session_start();
require_once "page_functions.php";
  
  $email = security_clean_data($_POST['user_email']);
  $password = $_POST['user_password'];
  
  if(!empty(get_user_by_email($email))) {
    set_flash_message('danger', "Этот эл. адрес уже занят другим пользователем.");
    redirect_to('page_register');
  }
  
  $_SESSION['user_id'] = add_user($email, $password);
  
  set_flash_message('success', "Пользователь успешно добавлен в БД");
  redirect_to('page_register');

?>