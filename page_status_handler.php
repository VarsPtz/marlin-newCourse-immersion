<?php
  session_start();
  require_once "page_functions.php";
  
  if (isset($_POST['btn-status-user'])) {
    $user_status = $_POST['edit_user_status'];
    $user_id = $_SESSION['edit_user_id'];
    
    update_user_status($user_status, $user_id);
    set_flash_message('success', 'Профиль успешно обновлён');
    redirect_to('page_profile');
  }
?>