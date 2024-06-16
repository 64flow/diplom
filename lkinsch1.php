<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <?php require "style.php";
   ?>
    <style></style>
</head>
<?php
require_once "pdo.php";

session_start();
$host = 'aws-0-eu-central-1.pooler.supabase.com';
$dbname = 'postgres';
$user = 'postgres.dstcxgfoqwifnystedpz';
$password = '6412diploM!';
$port = 5432;
$db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = $_POST['id'];

$second_name = $_POST['second_name'];
$name = $_POST['name'];
$third_name = $_POST['third_name'];
$birthdate = $_POST['birthdate'];
$post = $_POST['post'];
$login = $_POST['login'];
$password = $_POST['password'];
$code_word = $_POST['code_word'];

$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$hashed_code_word = password_hash($code_word, PASSWORD_DEFAULT);

$sql = "UPDATE workers SET second_name = :second_name, name = :name, third_name = :third_name, birthdate = :birthdate, post = :post, login = :login, password = :password, code_word = :code_word WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->bindParam(':second_name', $second_name);
$stmt->bindParam(':name', $name);
$stmt->bindParam(':third_name', $third_name);
$stmt->bindParam(':birthdate', $birthdate);
$stmt->bindParam(':post', $post);
$stmt->bindParam(':login', $login);
$stmt->bindParam(':password', $hashed_password); // Передаем хешированный пароль
$stmt->bindParam(':code_word', $hashed_code_word); // Передаем хешированное кодовое слово



$stmt->execute();
echo '<script type="text/javascript"> alert("Данные успешно обновлены.");</script>';
echo '<script type="text/javascript">window.location.href = "./lkins.php" </script>';
