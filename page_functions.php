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
   *   Description: Получить всех пользователей
   *
   *   Return value: array
   **/
  
  function get_users() {
    $pdo = new PDO("mysql:host=localhost;dbname=marlin-newcourse-1", "root", "");
    $sql = "SELECT * FROM users";
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $users = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $users;
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
  
  $user = get_user_by_email($email);
  
  if(empty($user)) {
    set_flash_message('danger', "Пользователь с таким email не зарегистрирован.");
    return false;
  }
  
  if(!password_verify($password, $user['password'])) {
    set_flash_message('danger', "Пароли не совпадают.");
    return false;
    //redirect_to('page_login');
  }
  
  if (!empty($_POST['login_remember']) || $_POST['login_remember'] == 'on') {
    setcookie("user_id", $user['id'], time() + 2592000);//one month
    //setcookie("user_email", $user['email'], time() + 2592000); // - Не получается передать два параметра в одну куку
  } else {
    setcookie("user_id", '', time() - 2592000);
    //setcookie("user_email", '', time() - 2592000);
  }
  
  $_SESSION['user_id'] = $user['id'];
  $_SESSION['login_in'] = 'true';
  
  if ($user['role'] == 'admin') {
    $_SESSION['is_admin'] = 'true';
  } else {
    $_SESSION['is_admin'] = 'false';
  }
  
  return true;
}


/**
*
*     Desripion: Проверка авторизован ли пользоватeль
*
*     Return value: bool
**/

function is_not_logged_in() {
  return !isset($_SESSION['login_in']) && $_SESSION['login_in'] != 'true';
}
  
  
/**
 *
 *     Desripion: Проверка пользоватeль admin или нет
 *
 *     Return value: bool
 **/
 
function is_admin() {
  return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 'true';
}


function print_data($data) {
  echo '<pre>';
  var_dump($data);
  echo '</pre>';
  die();
}