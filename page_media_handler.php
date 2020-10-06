<?php
  session_start();
  require_once "page_functions.php";
  
  if (isset($_POST['btn-media-user'])) {
    $user_avatar = $_FILES['user_avatar'];
    $user_id = $_SESSION['edit_user_id'];
    upload_avatar($user_avatar, $user_id);
    
    set_flash_message('success', 'Профиль успешно обновлён');
    redirect_to('page_profile');
  }
?>
