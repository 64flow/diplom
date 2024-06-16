<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<?php
require "style.php";
require "h3.php";?>

<?php
require_once "pdo.php";
session_start();

$host = 'aws-0-eu-central-1.pooler.supabase.com';
$dbname = 'postgres';
$user = 'postgres.dstcxgfoqwifnystedpz';
$password = '6412diploM!';
$port = 5432;
$plane_id = $_GET['plane_id'];
$work_id = $_GET['id'];

$db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;options='--client_encoding=UTF8'", $user, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT id, name, family_type, general_condition, fuel_type, fuel_max, fuel_current FROM airplanes WHERE id = $plane_id";
$plane_stmt = $db->query($sql);
$plane = $plane_stmt->fetch();
?>

</head>
<body>
<div class="container1">
    <h2>Заправка самолёта: <?php echo htmlspecialchars($plane['name']); ?></h2>
    <form id="refillForm" action="refill_worker1.php?idf=<?php echo urlencode($plane_id); ?>" method="post">
    <input type="hidden" name="idf" value="<?php echo htmlspecialchars($plane_id); ?>">
    <input type="hidden" name="work_id" value="<?php echo htmlspecialchars($work_id); ?>">
        <div class="form-row">
            <label for="fuel">Заправлено литров:</label>
        </div>
        <div class="form-row">
            <input type="number" id="fuel" name="fuel" value="0" min="0" max="<?php echo htmlspecialchars($plane['fuel_max']); ?>" step="0.01" required>
            <p id="fuelError" style="color: red; display: none;">Значение превышает максимальный объём топливных баков топлива.</p>
        </div>
        <button type="submit" class="button-sp">Самолёт был заправлен</button>
    </form>
</div>

<script>
    document.getElementById('refillForm').addEventListener('submit', function(event) {
        var fuelInput = document.getElementById('fuel');
        var maxFuel = <?php echo htmlspecialchars($plane['fuel_max']); ?>;
        var currentFuel = <?php echo htmlspecialchars($plane['fuel_current']); ?>;
        if (parseFloat(fuelInput.value) + currentFuel > maxFuel) {
            event.preventDefault();
            document.getElementById('fuelError').style.display = 'block';
        }
    });
    </script>
</body>
</html>
