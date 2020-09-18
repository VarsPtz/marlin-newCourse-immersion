<?php
 session_start();
 // Example Code by Rahim
 $email = "some@mail.ru";
 $password = "secret";
  
  $pdo = new PDO("mysql:host=localhost;dbname=marlin-newcourse-1", "root", "");
  
  $sql = "SELECT * FROM users WHERE email=:email";
  $statement = $pdo->prepare($sql);
  $statement->execute(["email" => $email]);
  $user = $statement->fetch(PDO::FETCH_ASSOC);
  
  if(!empty($user)) {
    $_SESSION['danger'] = "Этот электронный адрес уже занят другим пользователем";
    header("Location: /page_register.php");
    exit;
  } else {
    echo "Можно зарегистрироваться";
  }
  die;
  
  $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
  
  $statement = $pdo->prepare($sql);
  $statement->execute([
    "email" => $email,
    "password" => password_hash($password, PASSWORD_DEFAULT)
  ]);
  
  $_SESSION["success"] = "Регистрация успешна";
  header("Location: /page_login.php");
  exit();
?>
