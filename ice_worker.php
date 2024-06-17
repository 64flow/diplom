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
$plane_id = $_POST['plane_id'];
$work_id = $_GET['id'];


$db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;options='--client_encoding=UTF8'", $user, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Получить текущее значение
$sql_select_count = "SELECT count FROM service_wirehouse WHERE id = 3";
    $stmt_select_count = $db->prepare($sql_select_count);
    $stmt_select_count->execute();
    $ice = $stmt_select_count->fetch();
    
    $current_ice = $ice['count'];
    $new_ice = $current_ice - 100;
    
    $sql_update_count = "UPDATE service_wirehouse SET count = ? WHERE id = 3";
    $stmt_update_count = $db->prepare($sql_update_count);
    $stmt_update_count->execute([$new_ice]);

// Обновить статус работы в guide
$sql_update_status = "UPDATE guide SET status = TRUE WHERE work_id = ?";
$stmt_update_status = $db->prepare($sql_update_status);
$stmt_update_status->execute([$work_id]);

// Обновить статус сотрудника
$sql_update_worker = "UPDATE workers SET employment_status = FALSE, work_id = NULL WHERE work_id = ?";
$stmt_update_worker = $db->prepare($sql_update_worker);
$stmt_update_worker->execute([$work_id]);

// Вывести сообщение об успешном выполнении заправки и перенаправить на страницу worker.php
echo '<script type="text/javascript"> alert("Противообледенительная обработка выполнена.");</script>';
echo '<script type="text/javascript">window.location.href = "./worker.php" </script>';
?>
