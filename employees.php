
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
<div class="center">
    <a href="add_worker.php" class="button-white">Добавить нового сотрудника</a>
</div>

<?php
require_once "pdo.php";

$host = 'aws-0-eu-central-1.pooler.supabase.com';
$dbname = 'postgres';
$user = 'postgres.dstcxgfoqwifnystedpz';
$password = '6412diploM!';
$port = 5432;

try {
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
    
    $sql = "SELECT id, second_name, name, third_name, birthdate, post, employment_status, work_id, login, password, code_word FROM workers";
    $stmt = $db->query($sql);
    $emp = $stmt->fetchAll();

    for ($i = 0; $i < count($emp); $i++) {
        $zan = $emp[$i]['employment_status'];
        $st = '';
        $cardClass = '';
        if ($zan == 'TRUE') {
            $st = 'Занят';
            $cardClass = 'red-border';
        } else {
            $st = 'Свободен';
            $cardClass = 'green-border';
        }

        $workId = $emp[$i]['work_id'];
        if ($workId !== null) {
            $sql3 = "SELECT name, finish_date FROM works WHERE id = ?";
            $stmt = $db->prepare($sql3);
            $stmt->execute([$workId]);
            $workData = $stmt->fetchAll();

            if (!empty($workData)) {
                $workName = $workData[0]['name'];
                $finishDate = DateTime::createFromFormat('Y-m-d H:i:s', $workData[0]['finish_date']);
                $finishDateFormatted = $finishDate->format('d.m.Y H:i:s');
                $workName .= " (занят до $finishDateFormatted)";
            } else {
                $workName = 'Нет выполняемой работы';
            }
        } else {
            $workName = 'Нет выполняемой работы';
        }
        if ($cardClass =='red-border'){
        echo "
        <div class='card1 $cardClass'>
            <div class='list-item'>Идентификатор: ".$emp[$i]['id']."</div>
            <div class='list-item'>Фамилия: ".$emp[$i]['second_name']."</div>
            <div class='list-item'>Имя: ".$emp[$i]['name']."</div>
            <div class='list-item'>Отчество: ".$emp[$i]['third_name']."</div>
            <div class='list-item'>Дата рождения: ".$emp[$i]['birthdate']."</div>
            <div class='list-item'>Должность: ".$emp[$i]['post']." </div>
            <div class='list-item'>Занятость: ".$st."</div>
            <div class='list-item'>Выполняемая работа: " . htmlspecialchars($workName) . " </div>
            <div class='list-item'>Логин: ".$emp[$i]['login']." </div>
                <a href='workerup.php?id=".$emp[$i]['id']."' class='button-sp'>Редактировать данные сотрудника</a>
                <a href='workdel.php?id=".$emp[$i]['work_id']."' class='button-green'>Снять выполнение задания</a>
                <a href='workerdel.php?id=".$emp[$i]['id']."' class='log-sp'>Уволить сотрудника</a>
            </div>
        ";}
        else{
            echo "
        <div class='card1 $cardClass'>
            <div class='list-item'>Идентификатор: ".$emp[$i]['id']."</div>
            <div class='list-item'>Фамилия: ".$emp[$i]['second_name']."</div>
            <div class='list-item'>Имя: ".$emp[$i]['name']."</div>
            <div class='list-item'>Отчество: ".$emp[$i]['third_name']."</div>
            <div class='list-item'>Дата рождения: ".$emp[$i]['birthdate']."</div>
            <div class='list-item'>Должность: ".$emp[$i]['post']." </div>
            <div class='list-item'>Занятость: ".$st."</div>
            <div class='list-item'>Выполняемая работа: " . htmlspecialchars($workName) . " </div>
            <div class='list-item'>Логин: ".$emp[$i]['login']." </div>
            <br>
            <br>
            <br>
            <br>
                <a href='workerup.php?id=".$emp[$i]['id']."' class='button-sp'>Редактировать данные сотрудника</a>
                <br>
                <a href='workerdel.php?id=".$emp[$i]['id']."' class='log-sp'>Уволить сотрудника</a>
            </div>
        ";

        }
    }
} catch (PDOException $e) {
    echo "Connection error: " . $e->getMessage();
}
?>
