<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
</head>
<?php
require_once "pdo.php";
session_start();

$host = 'aws-0-eu-central-1.pooler.supabase.com';
$dbname = 'postgres';
$user = 'postgres.dstcxgfoqwifnystedpz';
$password = '###';
$port = 5432;
$id = $_GET['idf'];
$addcount = $_POST['addcount'];

try {
    $db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;options='--client_encoding=UTF8'", $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM wirehouse WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    $service = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $oldcount = $service[0]['count'];
   
    $sql1 = "UPDATE wirehouse SET count = ? WHERE id = ?";
    $stmt = $db->prepare($sql1);
    $stmt->execute([$addcount + $oldcount, $id]);
   
    echo '<script type="text/javascript"> alert("Закупка успешно произведена.");</script>';
    echo '<script type="text/javascript">window.location.href = "./wirehouse.php" </script>';
} catch (PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}
?>

