<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
    <?php require "style.php";
    require "h2.php"?>
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


    $db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;options='--client_encoding=UTF8'", $user, $password);

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if (isset($_GET['id'])) {
  $id = $_GET['id'];

  try {
    $sql2 = "UPDATE workers SET employment_status = FALSE, work_id = NULL WHERE work_id = ?";
    $stmt = $db->prepare($sql2);
    $stmt->execute([$id]);
    $sql = "UPDATE guide SET status = FALSE WHERE work_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);

    echo '<script type="text/javascript"> alert("Сотрудник успешно снят с задания.");</script>';
echo '<script type="text/javascript">window.location.href = "./employees.php" </script>';
  } catch (PDOException $e) {
    echo "Ошибка снятия сотрудника с задания: " . $e->getMessage();
  }
}
?>
