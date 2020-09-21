<?php
  
/**
 *   Parameters:
 *       string - $email
 *   Description: поиск пользователя по эл. адресу
 *
 *   Return value: array
**/

function get_user_by_email($email) {
  $pdo = new PDO("mysql:host=localhost;dbname=marlin-newcourse-1", "root", "");
  $sql = "SELECT * FROM users WHERE email=:email";
  $statement = $pdo->prepare($sql);
  $statement->execute(['email' => $email]);
  $user = $statement->fetch(PDO::FETCH_ASSOC);
  return $user;
}




/**
 *
 *   Parameters:
 *      string - $email
 *      string - $password
 *   Description: добавить пользователя в БД
 *
 *   Return value: int (user_id)
 **/

function add_user($email, $password) {
  $pdo = new PDO("mysql:host=localhost;dbname=marlin-newcourse-1", "root", "");
  $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
  $statement = $pdo->prepare($sql);
  $statement->execute(
    [
      'email' => $email,
      'password' => password_hash($password, PASSWORD_DEFAULT)
    ]
  );
  
  $sql_find_id = "SELECT id FROM users WHERE email=:email";
  $statement = $pdo->prepare($sql_find_id);
  $statement->execute([
    'email' => $email
  ]);
  
  return $statement->fetch(PDO::FETCH_ASSOC)['id'];
  
}



/**
 *   Parameters:
 *      string - $status (ключ)
 *      string - $message (значение, текст сообщения)
 *   Description: подготовить флеш сообщение
 *
 *   Return value: null
 **/

function set_flash_message($status, $message) {
  $_SESSION['status'] = $status;
  $_SESSION['status_message'] = $message;
}

/**
 *   Parameters:
 *     string - $status (ключ)
 *   Description: вывести флеш сообщение
 *
 *   Return value: null
 *
 **/

function display_flash_message($status) {
  
  if (isset($_SESSION['status'])) {
    
    echo "<div class=\"alert alert-{$status} text-dark\" role=\"alert\">{$_SESSION['status_message']}</div>";
    unset($_SESSION['status']);
    unset($_SESSION['status_message']);
  }
}
  
  /**
   *   Parameters:
   *      string - $path
   *
   *   Description: перенаправить на другую страницу
   *
   *   Return value: null
   **/

function redirect_to($path) {
  header('Location: '.$path.'.php');
  exit();
}

function security_clean_data($data) {
  $data = trim($data);
  $data = htmlspecialchars($data);
  return $data;
}

/**
 *    Parameters:
 *        string: $email
 *        string: $password
 *
 *    Description: авторизовать пользователя
 *
 *    Return value: boolean
 **/

function login($email, $password) {

}

