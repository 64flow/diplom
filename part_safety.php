<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<?php
require "style.php";
require "h4.php";?>

<?php
require_once "pdo.php";
session_start();

$host = 'aws-0-eu-central-1.pooler.supabase.com';
$dbname = 'postgres';
$user = 'postgres.dstcxgfoqwifnystedpz';
$password = '###';
$port = 5432;
$part_id = $_GET['id'];
$plane_id = $_GET['plane_id'];

$db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;options='--client_encoding=UTF8'", $user, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT id, name FROM airplanes WHERE id = $plane_id";
$plane_stmt = $db->query($sql);
$plane = $plane_stmt->fetch();
$sql1 = "SELECT id, name FROM aircraft_parts WHERE id = $part_id";
$part_stmt = $db->query($sql1);
$part = $part_stmt->fetch();
?>

</head>
<body>
<div class="container1">
    <h2>Осмотр и изменение состояния детали: <?php echo htmlspecialchars($part['name']); ?> - <?php echo htmlspecialchars($plane['name']); ?></h2>
    <form id="partForm" action="part_safety1.php?idf=<?php echo urlencode($part_id); ?>" method="post">
    <input type="hidden" name="idff" value="<?php echo htmlspecialchars($part_id); ?>">
    <input type="hidden" name="idf" value="<?php echo htmlspecialchars($plane_id); ?>">
        <div class="form-row">
            <label for="part">Состояние сохранности детали(%):</label>
        </div>
        <div class="form-row">
            <input type="number" id="part" name="part" value="0" min="0" max="100" required>
        </div>
        <button type="submit" class="button-sp">Сохранить результаты осмотра</button>
    </form>
</div>
</body>
</html>
