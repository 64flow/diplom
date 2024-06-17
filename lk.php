<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

</head>
<body>

<?php require "style.php";
require "h3.php"?>
<div class="center">
<div class='card1 style="width: 30%; background-color: white; padding: 20px;"'>
<h1>Личные данные</h1>
</div>
</div>
<?php
require_once "pdo.php";
session_start();

$host = 'aws-0-eu-central-1.pooler.supabase.com';
$dbname = 'postgres';
$user = 'postgres.dstcxgfoqwifnystedpz';
$password = '###';
$port = 5432;
$id=$_SESSION['uid'];
$db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;options='--client_encoding=UTF8'", $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT id, second_name, name, third_name, birthdate, post, employment_status, work_id, login, password, code_word FROM workers WHERE id = $id";
    $stmt = $db->query($sql);
    $emp = $stmt->fetch();
    $zan = $emp['employment_status'];
        $st = '';
        $cardClass = '';
        if ($zan == 'TRUE') {
            $st = 'Занят';
            
        } else {
            $st = 'Свободен';
            
        }
    echo "<div class='center'>
        <div class='card1'>
            
            <div class='list-item'>Фамилия: ".$emp['second_name']."</div>
            <div class='list-item'>Имя: ".$emp['name']."</div>
            <div class='list-item'>Отчество: ".$emp['third_name']."</div>
            <div class='list-item'>Дата рождения: ".$emp['birthdate']."</div>
            <div class='list-item'>Должность: ".$emp['post']." </div>
            <div class='list-item'>Занятость: ".$st."</div>
            <div class='list-item'>Логин: ".$emp['login']." </div>
              
            <a href='lkch.php?id=".$emp['id']."' class='button-sp'>Редактировать данные</a>
               
            </div>
            </div>
        ";
