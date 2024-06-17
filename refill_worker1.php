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
$plane_id = $_POST['idf'];
$work_id = $_POST['work_id'];
$fuel = $_POST['fuel'];

$db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;options='--client_encoding=UTF8'", $user, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Получить текущее значение fuel_current
$sql_current_fuel = "SELECT fuel_current FROM airplanes WHERE id = ?";
$stmt_current_fuel = $db->prepare($sql_current_fuel);
$stmt_current_fuel->execute([$plane_id]);
$current_fuel_row = $stmt_current_fuel->fetch();
$current_fuel = $current_fuel_row['fuel_current'];

// Прибавить новое значение к текущему значению fuel_current
$new_fuel = $current_fuel + $fuel;

// Обновить запись в базе данных с новым значением fuel_current
$sql_update_fuel = "UPDATE airplanes SET fuel_current = ? WHERE id = ?";
$stmt_update_fuel = $db->prepare($sql_update_fuel);
$stmt_update_fuel->execute([$new_fuel, $plane_id]);

// Обновить статус работы в guide
$sql_update_status = "UPDATE guide SET status = TRUE WHERE work_id = ?";
$stmt_update_status = $db->prepare($sql_update_status);
$stmt_update_status->execute([$work_id]);

// Обновить статус сотрудника
$sql_update_worker = "UPDATE workers SET employment_status = FALSE, work_id = NULL WHERE work_id = ?";
$stmt_update_worker = $db->prepare($sql_update_worker);
$stmt_update_worker->execute([$work_id]);

// Вывести сообщение об успешном выполнении заправки и перенаправить на страницу worker.php
echo '<script type="text/javascript"> alert("Заправка выполнена.");</script>';
echo '<script type="text/javascript">window.location.href = "./worker.php" </script>';
?>
