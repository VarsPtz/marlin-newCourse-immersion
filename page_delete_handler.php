<?php
  session_start();
  require_once "page_functions.php";
  
  if (is_not_logged_in()) {
    redirect_to('page_login');
  }
  
  $logged_user_id = $_SESSION['user_id'];
  $edit_user_id = $_GET['id'];
  
  if (!is_admin()) {
    if (!is_author($logged_user_id, $edit_user_id)) {
      set_flash_message('danger', 'Можно редактировать только свой профиль.');
      redirect_to('users');
    }
  }
  
  $user_avatar_name = has_image($edit_user_id);
  
  if ($user_avatar_name) {
    delete_file("img/avatars/".$user_avatar_name);
  };
  
  delete_user($edit_user_id);
  
  if ($logged_user_id == $edit_user_id) {
    unset($_SESSION['user_id']);
    session_destroy();
    redirect_to('page_register');
  }
  
  set_flash_message('success', 'Пользователь удалён');
  redirect_to('users');
  
?>