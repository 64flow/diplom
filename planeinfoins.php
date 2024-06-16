<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
    <?php require "style.php";
    require "h4.php"?>
    <style></style>
</head>
<body>
<div class="center">
<a href="inspector.php" class="button-white">Назад к списку самолётов</a>
</div>
<?php
require_once "pdo.php";
session_start();

$host = 'aws-0-eu-central-1.pooler.supabase.com';
$dbname = 'postgres';
$user = 'postgres.dstcxgfoqwifnystedpz';
$password = '6412diploM!';
$port = 5432;

$plane_id = $_GET['idf'];

try {
    $db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;options='--client_encoding=UTF8'", $user, $password);

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $db->prepare("SELECT id, name, plane_id, family_type, safety_of_the_part, type FROM aircraft_parts WHERE plane_id = :plane_id");
    $stmt->execute([':plane_id' => $plane_id]);
    $part = $stmt->fetchAll(PDO::FETCH_ASSOC);
    function compareSafetyOfThePart($a, $b) {
        if ($a['safety_of_the_part'] == $b['safety_of_the_part']) {
            return 0;
        }
        return ($a['safety_of_the_part'] < $b['safety_of_the_part']) ? -1 : 1; // Изменили местами 1 и -1
    }
    
    // Сортировка массива
    usort($part, 'compareSafetyOfThePart');
  
    echo "<table class='parts-table'>";
    echo "<tr><th>Идентификатор</th><th>Название</th><th>Идентификатор самолёта</th><th>Семейство</th><th>Сохранность детали</th><th>Тип</th><th>Осмотреть и изменить степень сохранности</th></tr>";
    foreach ($part as $pt) {
        $rowClass = '';

    if ($pt['safety_of_the_part'] < 30) {
        $rowClass = 'danger';

    } elseif ($pt['safety_of_the_part'] < 70) {
        $rowClass = 'warning';

    }
    else {
        $rowClass = 'success';
    }

        echo "<tr class='$rowClass'>";
        echo "<td>" . $pt['id'] . "</td>";
        echo "<td>" . $pt['name'] . "</td>";
        echo "<td>" . $pt['plane_id'] . "</td>";
        echo "<td>" . $pt['family_type'] . "</td>";
        echo "<td>" . $pt['safety_of_the_part'] . " %</td>";
        echo "<td>" . $pt['type'] . "</td>";
      
            echo "<td><a href='part_safety.php?id=". $pt['id']. '&plane_id=' . $pt['plane_id']. "' class='button-sp'>Изменить степень сохранности детали</a></td>";
       
        echo "</tr>";
    }
    
    echo "</table>";

} catch (PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}
?>

</body>
</html>
