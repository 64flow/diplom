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

try {
    $db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;options='--client_encoding=UTF8'", $user, $password);

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM service_wirehouse";
    $stmt = $db->query($sql);
    $service = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<table class='parts-table'>";
    echo "<tr><th>Тип</th><th>Название</th><th>Количество</th><th>Закупка</th></tr>";
    foreach ($service as $item) {
        $rowClass = '';
        if($item['count']==NULL){
            $rowClass = 'danger';
            $count =0;
        }
        else{
            if($item['count']<1000){
                $rowClass = 'danger';
                $count=$item['count'];
            }
            else{
            $count=$item['count'];
            $rowClass = 'success';}
        }
        echo "<tr class='$rowClass'>";
        echo "<td>" . $item['type'] . "</td>";
        echo "<td>" . $item['name'] . "</td>";
       
        echo "<td>" . $count. " л.</td>";
        echo "<td><a href='addfuel1.php?id=".$item['id']."'' class='button-green'>Закупить</a></td>";
       

    }
    
    
    
} catch (PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}
?>
</body>
</html>
