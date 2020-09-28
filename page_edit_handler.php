<?php
  session_start();
  require_once "page_functions.php";
  
  if (isset($_POST['btn-edit-user'])) {
    $user_name = $_POST['user_name'];
    $user_job = $_POST['user_job'];
    $user_phone = $_POST['user_phone'];
    $user_address = $_POST['user_address'];
    $user_id = $_SESSION['edit_user_id'];
    update_common_user_information($user_name, $user_job, $user_phone, $user_address, $user_id);
    
    set_flash_message('success', 'Профиль успешно обновлён');
    redirect_to('page_profile');
  }
  
?>
