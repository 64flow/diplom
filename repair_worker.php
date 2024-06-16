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
<?php
require_once "pdo.php";
session_start();

$host = 'aws-0-eu-central-1.pooler.supabase.com';
$dbname = 'postgres';
$user = 'postgres.dstcxgfoqwifnystedpz';
$password = '6412diploM!';
$port = 5432;
$work_id=$_GET['id'];
$part_id = $_GET['part_id'];
$db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;options='--client_encoding=UTF8'", $user, $password);

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   

    $sql = "UPDATE guide SET status = TRUE WHERE work_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$work_id]);

    $sql1 = "UPDATE aircraft_parts SET safety_of_the_part = 100 WHERE id = ?";
    $stmt = $db->prepare($sql1);
    $stmt->execute([$part_id]);

    $sql2 = "UPDATE workers SET employment_status = FALSE, work_id = NULL WHERE work_id = ?";
    $stmt = $db->prepare($sql2);
    $stmt->execute([$work_id]);

    echo '<script type="text/javascript"> alert("Работа выполнена.");</script>';
    echo '<script type="text/javascript">window.location.href = "./worker.php" </script>';

    ?>