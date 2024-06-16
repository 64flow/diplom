<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Панель администратора</title>

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
    $sql1 = "UPDATE works SET plane_id = NULL WHERE plane_id = :id";
    $stmt = $db->prepare($sql1);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $sql2 = "SELECT id, finish_date FROM works WHERE plane_id IS NULL";
    $stmt = $db->prepare($sql2);
    $stmt->execute();
    $works = $stmt->fetchAll();
    

   
    foreach ($works as $work) {
      $work_id = $work['id'];

      $finish_date = DateTime::createFromFormat('Y-m-d H:i:s', $work['finish_date']);

      $today = new DateTime();
      $today = $today->format('Y-m-d H:i:s');

      if ($today < $finish_date->format('Y-m-d H:i:s')) {
        $sql3 = "UPDATE workers SET employment_status = FALSE, work_id = NULL WHERE work_id = :work_id";
        $stmt = $db->prepare($sql3);
        $stmt->bindParam(':work_id', $work_id);
        $stmt->execute();

        $sql4 = "UPDATE guide SET status = FALSE WHERE work_id = :work_id";
        $stmt = $db->prepare($sql4);
        $stmt->bindParam(':work_id', $work_id);
        $stmt->execute();
      }
    }

    $sql = "DELETE FROM airplanes WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    echo '<script type="text/javascript"> alert("Самолёт успешно удалён.");</script>';
    echo '<script type="text/javascript">window.location.href = "./planes.php" </script>';
  } catch (PDOException $e) {
    echo "Ошибка удаления самолета: " . $e->getMessage();
  }
} else {
    echo '<script type="text/javascript"> alert("Не найден идентификатор самолёта.");</script>';
    echo '<script type="text/javascript">window.location.href = "./planes.php" </script>';
}
?>
