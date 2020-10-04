<?php
  session_start();
  require_once "page_functions.php";
  
  if (isset($_POST['btn-security-user'])) {
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    $user_id = $_SESSION['edit_user_id'];
    
    $user_from_base = get_user_by_email($user_email);
    
    if ($user_from_base) {
      if ($user_from_base['id'] == $user_id) {
        edit_credentials($user_email, $user_password, $user_id);
        set_flash_message('success', 'Профиль успешно обновлён');
        redirect_to('page_profile');
      }
      set_flash_message('danger', 'Данный email уже занят.');
      redirect_to('security');
    }
    
    edit_credentials($user_email, $user_password, $user_id);
    set_flash_message('success', 'Профиль успешно обновлён');
    redirect_to('page_profile');
  }
?>
