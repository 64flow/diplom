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
$plane_id = isset($_GET['idf']) ? $_GET['idf'] : '';


$worker_id = $_POST['worker'];

$start_date = $_POST['start_date'];
$finish_date = $_POST['finish_date'];
$required_number_of_empoyees= $_POST['required_number_of_empoyees'];

try {
    $db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;options='--client_encoding=UTF8'", $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
   

    // Добавляем новую запись в таблицу works
    $sql = "INSERT INTO works (name, start_date, finish_date, required_number_of_empoyees, plane_id)
            VALUES ('Заправка', ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->execute([$start_date, $finish_date, $required_number_of_empoyees, $plane_id]);

    // Получить ID только что добавленной записи
    $work_id = $db->lastInsertId();

    // Обновляем существующие записи в таблице workers
   // Обновляем существующие записи в таблице workers
$sql = "UPDATE workers SET work_id = ?, employment_status = TRUE WHERE id IN (" . implode(',', array_fill(0, count($worker_id), '?')) . ")";
$stmt = $db->prepare($sql);
$params = array_merge([$work_id], $worker_id);
$stmt->execute($params);

$sql = "INSERT INTO guide (work_id, worker_id) VALUES (?, ?)";
$stmt = $db->prepare($sql);
foreach ($worker_id as $id) {
    $stmt->execute([$work_id, $id]);
}
echo '<script type="text/javascript"> alert("Заправка назначена.");</script>';
echo '<script type="text/javascript">window.location.href = "./planes.php" </script>';


} catch (PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}



?>