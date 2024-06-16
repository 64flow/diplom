<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

</head>
<body>

<?php 
require "style.php";
require "h3.php";
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

    $work_id = $_GET['id'];
    $part_id = $_GET['part_id'];

    $sql_select_part = "SELECT name, plane_id, family_type, type FROM aircraft_parts WHERE id = ?";
    $stmt_select_part = $db->prepare($sql_select_part);
    $stmt_select_part->execute([$part_id]);
    $part = $stmt_select_part->fetch();

    $plane_id = $part['plane_id'];
    $ptname = $part['name'];
    $family_type = $part['family_type'];
    $pttype = $part['type'];

    $sql_select_wh = "SELECT name, family_type, count FROM wirehouse WHERE name = ? AND family_type = ?";
    $stmt_select_wh = $db->prepare($sql_select_wh);
    $stmt_select_wh->execute([$ptname, $family_type]);
    $wh = $stmt_select_wh->fetch();

    if (empty($wh) || $wh['count'] == 0) {
        echo '<script type="text/javascript"> alert("В данный момент деталь на складе отсутствует.");</script>';
    } else {
        $newcount = $wh['count'] - 1;

        $sql_insert_part = "INSERT INTO aircraft_parts (name, plane_id, family_type, safety_of_the_part, type) VALUES (?, ?, ?, '100', ?)";
        $stmt_insert_part = $db->prepare($sql_insert_part);
        $stmt_insert_part->execute([$ptname, $plane_id, $family_type, $pttype]);

        $sql_update_wh = "UPDATE wirehouse SET count = ? WHERE name = ? AND family_type = ?";
        $stmt_update_wh = $db->prepare($sql_update_wh);
        $stmt_update_wh->execute([$newcount, $ptname,$family_type]);

        $sql_delete_part = "DELETE FROM aircraft_parts WHERE id = ?";
        $stmt_delete_part = $db->prepare($sql_delete_part);
        $stmt_delete_part->execute([$part_id]);

        $sql_update_workers = "UPDATE workers SET employment_status = FALSE, work_id = NULL WHERE work_id = ?";
        $stmt_update_workers = $db->prepare($sql_update_workers);
        $stmt_update_workers->execute([$work_id]);

        $sql_update_guide = "UPDATE guide SET status = TRUE WHERE work_id = ?";
        $stmt_update_guide = $db->prepare($sql_update_guide);
        $stmt_update_guide->execute([$work_id]);

        echo '<script type="text/javascript"> alert("Работа выполнена.");</script>';
        echo '<script type="text/javascript">window.location.href = "./worker.php" </script>';
    }
} catch (PDOException $e) {
    echo "Ошибка: " . $e->getMessage();
}
?>
