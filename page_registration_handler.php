<?php
session_start();
//echo '<pre>';
//var_dump($_POST);
//var_dump($_SESSION);
//echo '</pre>';

require_once('page_functions.php');

$email = security_clean_data($_POST['user_email']);
$password = $_POST['user_password'];
//echo $email;
//echo $password;

$pdo = new PDO("mysql:host=localhost;dbname=marlin-newcourse-1", "root", "");

get_user_by_email($email);

$sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
$statement = $pdo->prepare($sql);
$statement->execute(
  [
    'email' => $email,
    'password' => $password
  ]
);

$message = "Пользователь успешно добавлен в БД";
$_SESSION['success'] = $message;

header("Location: /page_register.php");

?>