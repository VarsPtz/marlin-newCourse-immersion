<?php
/**
 *   Parameters:
 *       string - $email
 *   Description: поиск пользователя по эл. адресу
 *
 *   Return value: array
**/

function get_user_by_email($email) {
  $sql = "SELECT * FROM users WHERE email=:email";
  $statement = $pdo->prepare($sql);
  $statement->execute(['email' => $email]);
  $mail_is_already_registered = $statement->fetch(PDO::FETCH_ASSOC);
  
  if(!empty($mail_is_already_registered)) {
    $message = "Этот эл. адрес уже занят другим пользователем.";
    $_SESSION['danger'] = $message;
    
    header("Location: /page_register.php");
    exit;
  }
};

/**
 *
 *   Parameters:
 *      string - $email
 *      string - $password
 *   Description: добавить пользователя в БД
 *
 *   Return value: int (user_id)
 **/

function add_user($email, $password) {};

/**
 *   Parameters:
 *      string - $name (ключ)
 *      string - $message (значение, текст сообщения)
 *   Description: подготовить флеш сообщение
 *
 *   Return value: null
 **/

function set_flash_message($name, $message) {};

/**
 *   Parameters:
 *     string - $name (ключ)
 *   Description: вывести флеш сообщение
 *
 *   Return value: null
 *
 **/

function display_flash_message($name) {};
  
  /**
   *   Parameters:
   *      string - $path
   *
   *   Description: перенаправить на другую страницу
   *
   *   Return value: null
   **/

function redirect_to($path) {};

function security_clean_data($data) {
  $data = trim($data);
  $data = htmlspecialchars($data);
  return $data;
}

