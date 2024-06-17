<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

</head>
<body>

<?php require "style.php";
require "h3.php"?>
<div class="center">
<div class='card1 style="width: 30%; background-color: white; padding: 20px;"'>

    <h1>Текущая работа</h1>

</div>
</div>
<?php
require_once "pdo.php";
session_start();

$host = 'aws-0-eu-central-1.pooler.supabase.com';
$dbname = 'postgres';
$user = 'postgres.dstcxgfoqwifnystedpz';
$password = '###';
$port = 5432;

$id=$_SESSION['uid'];

$db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;options='--client_encoding=UTF8'", $user, $password);

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql1 = "SELECT id, finish_date FROM works";
    $stmt = $db->query($sql1);
    $works = $stmt->fetchAll();
    
    foreach ($works as $work) {
        $work_id = $work['id'];
        $finish_date = DateTime::createFromFormat('Y-m-d H:i:s', $work['finish_date']);
    
        $today = new DateTime();
        $today = $today->format('Y-m-d H:i:s');
    
        if ($today > $finish_date->format('Y-m-d H:i:s')) {
            $sql2 = "UPDATE workers SET employment_status = FALSE, work_id = NULL WHERE work_id = ?";
            $stmt = $db->prepare($sql2);
            $stmt->execute([$work_id]);
    
            $sql5 = "SELECT status FROM guide WHERE work_id = ? AND status IS NOT TRUE";
            $stmt = $db->prepare($sql5);
            $stmt->execute([$work_id]);
            $gui = $stmt->fetchAll();
    
            if ($gui) {
                foreach ($gui as $row) {
                    if ($row['status'] === null) {
                        $sql4 = "UPDATE guide SET status = FALSE WHERE work_id = ?";
                        $stmt = $db->prepare($sql4);
                        $stmt->execute([$work_id]);
                    }
                }
            }
        }
    }

    $sql = "SELECT id, second_name, name, third_name, birthdate, post, employment_status, work_id, login, password, code_word FROM workers WHERE id = $id";
    $stmt = $db->query($sql);
    $emp = $stmt->fetch();
    

    $idw=$emp['work_id'];
    if($idw == null){
        echo "<div class='center'>
        <div class='card1 $cardClass'>
        <h2>У вас отсутсвуют работы на текущий момент</h2>
        </div>
        </div>
        ";
    }else{
        $sql7 = "SELECT works.*, parts.name AS part_name, airplanes.name AS plane_name 
        FROM works 
        LEFT JOIN aircraft_parts AS parts ON works.part_id = parts.id 
        LEFT JOIN airplanes AS airplanes ON works.plane_id = airplanes.id 
        WHERE works.id = $idw";

$stmt = $db->query($sql7);
$works = $stmt->fetchAll();

foreach ($works as $work) {
   if ($work['name'] == 'Ремонт детали') {
       echo "
       <div class='center'>
           <div class='card1 $cardClass'>
               <div class='list-item'>Название: " . $work['name'] . "</div>
               <div class='list-item'>Начать не позднее: " . $work['start_date'] . "</div>
               <div class='list-item'>Завершить не позднее: " . $work['finish_date'] . "</div>
               <div class='list-item'>№ самолёта: " . $work['plane_id'] . " - " . $work['plane_name'] . "</div>
               <div class='list-item'>№ детали: " . $work['part_id'] . " - " . $work['part_name'] . "</div>

               <a href='repair_worker.php?id=" . $work['id'] . "&part_id=" . $work['part_id'] . "' class='button-green'>Деталь была отремонтирована</a>
           </div>
       </div>";
   }elseif($work['name']=='Замена детали'){
        echo "
        <div class='center'>
        <div class='card1 $cardClass'>

            <div class='list-item'>Название: " . $work['name'] . "</div>
            <div class='list-item'>Начать не позднее: " . $work['start_date'] . "</div>
            <div class='list-item'>Завершить не позднее: " . $work['finish_date'] . "</div>
            <div class='list-item'>№ самолёта: " . $work['plane_id'] . " - " . $work['plane_name'] . "</div>
            <div class='list-item'>№ детали: " . $work['part_id'] . " - " . $work['part_name'] . "</div>
            <a href='replace_worker.php?id=".$work['id']."&part_id=".$work['part_id']."' class='button-green'>Деталь была заменена</a>

            </div>
        </div>
    ";
    }elseif($work['name']=='Заправка'){
        echo "
        <div class='center'>
        <div class='card1 $cardClass'>
            <div class='list-item'>Название: ".$work['name']."</div>
            <div class='list-item'>Начать не позднее: ".$work['start_date']."</div>
            <div class='list-item'>Завершить не позднее: ".$work['finish_date']."</div>
            <div class='list-item'>№ самолёта: " . $work['plane_id'] . " - " . $work['plane_name'] . "</div>
            
        
            <a href='refill_worker.php?id=".$work['id']."&plane_id=".$work['plane_id']."' class='button-green'>Заправить</a>

            </div>
        </div>
    ";
    }
    elseif($work['name']=='Противообледенительная обработка'){
        echo "
        <div class='center'>
        <div class='card1 $cardClass'>
            <div class='list-item'>Название: ".$work['name']."</div>
            <div class='list-item'>Начать не позднее: ".$work['start_date']."</div>
            <div class='list-item'>Завершить не позднее: ".$work['finish_date']."</div>
            <div class='list-item'>№ самолёта: " . $work['plane_id'] . " - " . $work['plane_name'] . "</div>
            
        
            <a href='ice_worker.php?id=".$work['id']."&plane_id=".$work['plane_id']."' class='button-green'>Противообледенительная обработка выполнена</a>

            </div>
        </div>
    ";
    }
}
}
    ?></body>
