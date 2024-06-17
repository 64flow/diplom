<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Панель администратора</title>
<?php require "style.php";
require "h2.php"?>
<?php
require_once "pdo.php";
session_start();

$host = 'aws-0-eu-central-1.pooler.supabase.com';
$dbname = 'postgres';
$user = 'postgres.dstcxgfoqwifnystedpz';
$password = '###';
$port = 5432;

try {
    $db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;options='--client_encoding=UTF8'", $user, $password);

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL statement
// Prepare SQL statement
$stmt = $db->prepare("INSERT INTO workers (second_name, name, third_name, birthdate, post, employment_status, login, password, code_word)
                     VALUES (:second_name, :name, :third_name, :birthdate, :post, :employment_status, :login, :password, :code_word)");

// Assign values to the parameters
$second_name = $_POST['second_name'];
$name = $_POST['name'];
$third_name = $_POST['third_name'];
$birthdate = $_POST['birthdate'];
$post = $_POST['post'];
$login = $_POST['login'];
$password = $_POST['password'];
$code_word = $_POST['code_word'];
$employment_status = FALSE;

// Хэширование пароля и кодового слова
$password_hash = password_hash($password, PASSWORD_DEFAULT);
$code_word_hash = password_hash($code_word, PASSWORD_DEFAULT);

// Bind values to the parameters
$stmt->bindParam(':second_name', $second_name);
$stmt->bindParam(':name', $name);
$stmt->bindParam(':third_name', $third_name);
$stmt->bindParam(':birthdate', $birthdate);
$stmt->bindParam(':post', $post);
$stmt->bindParam(':employment_status', $employment_status, PDO::PARAM_BOOL);
$stmt->bindParam(':login', $login);
$stmt->bindParam(':password', $password_hash);
$stmt->bindParam(':code_word', $code_word_hash);

    // Execute statement
    $stmt->execute();

    echo '<script type="text/javascript"> alert("Работник успешно добавлен.");</script>';
    echo '<script type="text/javascript">window.location.href = "./employees.php" </script>';
} catch (PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}
?>
