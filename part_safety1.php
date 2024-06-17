<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<?php
require_once "pdo.php";
session_start();

$host = 'aws-0-eu-central-1.pooler.supabase.com';
$dbname = 'postgres';
$user = 'postgres.dstcxgfoqwifnystedpz';
$password = '###';
$port = 5432;
$part_id = $_POST['idff'];
$part = $_POST['part'];
$plane_id = $_POST['idf'];

$db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;options='--client_encoding=UTF8'", $user, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Обновить запись в базе данных с новым значением fuel_current
$sql_update_fuel = "UPDATE aircraft_parts SET safety_of_the_part = ? WHERE id = ?";
$stmt_update_fuel = $db->prepare($sql_update_fuel);
$stmt_update_fuel->execute([$part, $part_id]);


// Вывести сообщение об успешном выполнении заправки и перенаправить на страницу worker.php
echo '<script type="text/javascript"> alert("Данные о сохранности детали сохранены.");</script>';
echo '<script type="text/javascript">window.location.href = "./planeinfoins.php?idf='. $plane_id.'"; </script>';

?>
