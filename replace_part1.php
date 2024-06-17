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
$password = '###';
$port = 5432;
$plane_id = $_GET['plane_id'];
$part_id = $_GET['part_id'];

$worker_id = $_POST['worker'];

$start_date = $_POST['start_date'];
$finish_date = $_POST['finish_date'];
$required_number_of_empoyees= $_POST['required_number_of_empoyees'];

try {
    $db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;options='--client_encoding=UTF8'", $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
   

    // Добавляем новую запись в таблицу works
    $sql1 = "INSERT INTO works (name, start_date, finish_date, required_number_of_empoyees, plane_id, part_id)
    VALUES ('Замена детали', ?, ?, ?, ?, ?)";
$stmt = $db->prepare($sql1);
$stmt->execute([$start_date, $finish_date, $required_number_of_empoyees, $plane_id, $part_id]);


    // Получить ID только что добавленной записи
    $work_id = $db->lastInsertId();

    // Обновляем существующие записи в таблице workers
   // Обновляем существующие записи в таблице workers
$sql2 = "UPDATE workers SET work_id = ?, employment_status = TRUE WHERE id IN (" . implode(',', array_fill(0, count($worker_id), '?')) . ")";
$stmt = $db->prepare($sql2);
$params = array_merge([$work_id], $worker_id);
$stmt->execute($params);

$sql4 = "SELECT id, name, type FROM aircraft_parts WHERE id = $part_id";
$stmt = $db->query($sql4);
$pt = $stmt->fetch();
$pttype = $pt['type'];
$ptname = $pt['name'];

$sql3 = "INSERT INTO guide (work_id, worker_id, part_id, part_name, part_type) VALUES (?, ?, ?, ?, ?)";
$stmt = $db->prepare($sql3);
foreach ($worker_id as $id) {
    $stmt->execute([$work_id, $id, $part_id, $ptname, $pttype]);
}
echo '<script type="text/javascript"> alert("Замена детали назначена.");</script>';
echo '<script type="text/javascript">window.location.href = "./planes.php" </script>';


} catch (PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}



?>
