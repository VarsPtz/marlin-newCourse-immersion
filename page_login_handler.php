<?php
  session_start();
  require_once "page_functions.php";
  
  $email = security_clean_data($_POST['login_email']);
  $password = $_POST['login_password'];
  
  $user = get_user_by_email($email);
  
  if(empty($user)) {
    set_flash_message('danger', "Пользователь с таким email не зарегистрирован.");
    redirect_to('page_login');
  }

  if(!password_verify($password, $user['password'])) {
    set_flash_message('danger', "Пароли не совпадают.");
    redirect_to('page_login');
  }
  
  
  if (!empty($_POST['login_remember']) || $_POST['login_remember'] == 'on') {
    setcookie("user_id", $user['id'], time() + 2592000);//one month
    //setcookie("user_email", $user['email'], time() + 2592000); // - Не получается передать два параметра в одну куку
  } else {
    setcookie("user_id", '', time() - 2592000);
    //setcookie("user_email", '', time() - 2592000);
  }
  
  redirect_to('users');
?>