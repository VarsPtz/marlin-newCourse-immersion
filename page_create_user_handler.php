<?php
  session_start();
  require_once "page_functions.php";
  
  if (isset($_POST['btn-create-user'])) {
    $email = security_clean_data($_POST['user_email']);
    $user = get_user_by_email($email);
    
    if(!empty($user)) {
      set_flash_message('danger', "Этот эл. адрес уже занят другим пользователем.");
      redirect_to('create_user');
    }
  
    $password = $_POST['user_password'];
    $user_id = add_user($email, $password);
    
    
    
    $user_name = $_POST['user_name'];
    $user_job = $_POST['user_job'];
    $user_phone = $_POST['user_phone'];
    $user_address = $_POST['user_address'];
  
    update_common_user_information($user_name, $user_job, $user_phone, $user_address, $user_id);
    
    $user_status = $_POST['user_status'];
    update_user_status($user_status, $user_id);
    
    $user_vk = $_POST['user_vk'];
    $user_telegram = $_POST['user_telegram'];
    $user_instagram = $_POST['user_instagram'];
    
    $user_avatar = $_FILES['user_avatar'];
    if (!empty($user_avatar)) {
      upload_avatar($user_avatar, $user_id);
    }
    
    update_social_links($user_vk, $user_telegram, $user_instagram, $user_id);
  
    set_flash_message('success', "Пользователь успешно добавлен.");
    redirect_to('users');
  }
?>
