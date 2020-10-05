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
      'password' => a
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
 *  Parameters:
 *      $user_name string
 *      $user_job string
 *      $user_phone string
 *      $user_address string
 *      $user_id string
 *
 *  Description: редактировать профиль
 *
 *  Return value: boolean
**/

function update_common_user_information($user_name, $user_job, $user_phone, $user_address, $user_id) {
  $pdo = new PDO("mysql:host=localhost;dbname=marlin-newcourse-1", "root", "");
  $sql_common_information = "UPDATE `users` SET user_name = :user_name, user_job = :user_job, user_phone = :user_phone, user_address = :user_address WHERE `users`.`id` = :user_id";
  $sql_prepared = $pdo->prepare($sql_common_information);
  $common_information = [
    ':user_name' => $user_name,
    ':user_job' => $user_job,
    ':user_phone' => $user_phone,
    ':user_address' => $user_address,
    ':user_id' => $user_id
  ];
  $sql_prepared->execute($common_information);
}


/**
*
*   Parameters:
*      $user_status string
*      $user_id string
*
*   Description: обнавляем информацию о статусе пользователя
*
*  Return value: boolean
*
**/
function update_user_status($user_status, $user_id) {
  $pdo = new PDO("mysql:host=localhost;dbname=marlin-newcourse-1", "root", "");
  $sql_status_information = "UPDATE `users` SET user_status = :user_status WHERE `users`.`id` = :user_id";
  $sql_prepared = $pdo->prepare($sql_status_information);
  $status_information = [
    ':user_status' => $user_status,
    ':user_id' => $user_id
  ];
  $sql_prepared->execute($status_information);
}

/**
 *  Parameters:
 *      $image array
 *
 *  Description: загрузить аватар
 *
 *  Return value: null | string (path)
 *
 **/
 
function upload_avatar($image, $user_id) {
  $tmp_array = explode('.', $image['name']);
  
  $new_image_name = 'avatar'.uniqid().'.'.$tmp_array[1];
  move_uploaded_file($image['tmp_name'], 'img/avatars/'.$new_image_name);
  $pdo = new PDO("mysql:host=localhost;dbname=marlin-newcourse-1", "root", "");
  $sql_image = "UPDATE `users` SET user_avatar = :image WHERE `users`.`id` = :user_id";
  $slq_image_prepared = $pdo->prepare($sql_image);
  $arr_image = [
    ':image' => $new_image_name,
    ':user_id' => $user_id
  ];
  $slq_image_prepared->execute($arr_image);
}

/**
 *  Parameters:
 *      $vk string
 *      $telegram string
 *      $instagram string
 *
 *  Description: добавить ссылки на социальные сети
 *
 *  Return value: null
 *
 **/
 
function update_social_links($vk, $telegram, $instagram, $user_id) {
  $pdo = new PDO("mysql:host=localhost;dbname=marlin-newcourse-1", "root", "");
  $sql_social_information = "UPDATE `users` SET user_vk = :user_vk, user_telegram = :user_telegram, user_instagram = :user_instagram WHERE `users`.`id` = :user_id";
  $sql_prepared = $pdo->prepare($sql_social_information);
  $social_information = [
    ':user_vk' => $vk,
    ':user_telegram' => $telegram,
    ':user_instagram' => $instagram,
    ':user_id' => $user_id
  ];
  $sql_prepared->execute($social_information);
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

/**
*   Parameters:
*     $logged_user_id int
*     $edit_user_id int
*
*   Description: проверить, автор ли текущий авторизованный пользователь
*
*   Return value: boolean
*
**/

function is_author($logged_user_id, $edit_user_id) {
  return $logged_user_id == $edit_user_id;
}

/**
*   Parameters:
*      $user_id int
*   Description: получать пользователя по id
*
*   Return value: array
**/

function get_user_by_id($id) {
  $pdo = new PDO("mysql:host=localhost;dbname=marlin-newcourse-1", "root", "");
  $sql = "SELECT * FROM users WHERE id=:id";
  $statement = $pdo->prepare($sql);
  $statement->execute(['id' => $id]);
  $user = $statement->fetch(PDO::FETCH_ASSOC);
  return $user;
}

/**
*   Parameters:
*      $user_id int
*      $email string
*      $password string
*
*   Description: редактировать входные данные: email или password
*
*   Return value: null | boolean
*
**/
function edit_credentials($email, $password, $user_id) {
  $pdo = new PDO("mysql:host=localhost;dbname=marlin-newcourse-1", "root", "");
  $sql_security_update = "UPDATE `users` SET email = :user_email, password = :user_password WHERE `users`.`id` = :user_id";
  $sql_prepared = $pdo->prepare($sql_security_update);
  $security_information = [
    ':user_email' => $email,
    ':user_password' => password_hash($password, PASSWORD_DEFAULT),
    ':user_id' => $user_id
  ];
  $sql_prepared->execute($security_information);
}


/**
 *   Description: Получить все виды значений статуса пользователя
 *
 *   Return value: array
 *
**/
function get_all_user_status_types() {
  $pdo = new PDO("mysql:host=localhost;dbname=marlin-newcourse-1", "root", "");
  $sql = "SELECT status_key, status_value FROM user_status";
  $statement = $pdo->prepare($sql);
  $statement->execute();
  $all_status = $statement->fetchAll(PDO::FETCH_ASSOC);
  return $all_status;
}

