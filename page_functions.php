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
 *      string - $name (ключ)
 *      string - $message (значение, текст сообщения)
 *   Description: подготовить флеш сообщение
 *
 *   Return value: null
 **/

function set_flash_message($name, $message) {
  $_SESSION[$name] = $message;
  //$_SESSION['message'] = $message;
}

/**
 *   Parameters:
 *     string - $name (ключ)
 *   Description: вывести флеш сообщение
 *
 *   Return value: null
 *
 **/

function display_flash_message($name) {
  
  if (isset($_SESSION[$name])) {
    
//    if ($_SESSION[$name] == 'danger') {
//       echo '<div class="alert alert-danger text-dark" role="alert"><strong>Уведомление! </strong>'.$_SESSION['message'].'</div>';
//    }
//
//    if ($_SESSION[$name] == 'success') {
//      echo '<div class="alert alert-success text-dark" role="alert"><strong>Уведомление! </strong>'.$_SESSION['message'].'</div>';
//    }
    
    echo "<div class=\"alert alert-{$name} text-dark\" role=\"alert\">{$_SESSION[$name]}</div>";
    unset($_SESSION['name']);
    //unset($_SESSION['message']);
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

