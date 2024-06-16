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
<body>
<div class="center">
<form action="report.php" method="post" target="_blank">
<input type="hidden" id="id_filter" name="id_filter" value="">
<input type="hidden" id="name_filter" name="name_filter" value="">
<input type="hidden" id="start_date_filter" name="start_date_filter" value="">
<input type="hidden" id="end_date_filter" name="end_date_filter" value="">
<input type="hidden" id="plane_id_filter" name="plane_id_filter" value="">
<input type="hidden" id="plane_filter" name="plane_filter" value="">
<input type="hidden" id="workers_filter" name="workers_filter" value="">
<input type="hidden" id="status_filter" name="status_filter" value="">
<input type="hidden" id="part_id" name="part_id" value="">
<input type="hidden" id="part_name" name="part_name" value="">
<input type="hidden" id="part_type" name="part_type" value="">
    <input type="submit" value="Распечатать отчёт о работах" class="button-white">
</form>
</div>


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

$sql = "SELECT w.id AS work_id, w.name AS work_name, w.part_id, p.name AS part_name, p.type AS part_type, a.name AS plane_name, w.start_date, w.finish_date, w.plane_id,
string_agg(wr.second_name || ' ' || wr.name || ' ' || wr.third_name, ', ') AS workers,
BOOL_OR(g.status) AS status
FROM works w
LEFT JOIN aircraft_parts p ON w.part_id = p.id
JOIN airplanes a ON w.plane_id = a.id
JOIN guide g ON w.id = g.work_id
JOIN workers wr ON g.worker_id = wr.id
GROUP BY w.id, p.name, p.type, a.name;";

$stmt = $db->query($sql);
$wk = $stmt->fetchAll();







$sql_plane_ids = "SELECT DISTINCT plane_id FROM works ORDER BY plane_id";
$stmt_plane_ids = $db->query($sql_plane_ids);
$plane_ids = $stmt_plane_ids->fetchAll(PDO::FETCH_COLUMN);

$sql_ids = "SELECT DISTINCT id FROM works ORDER BY id";
$stmt_ids = $db->query($sql_ids);
$ids = $stmt_ids->fetchAll(PDO::FETCH_COLUMN);

$sql_names = "SELECT DISTINCT name FROM works ORDER BY name";
$stmt_names = $db->query($sql_names);
$names = $stmt_names->fetchAll(PDO::FETCH_COLUMN);

$sql_parts = "SELECT name FROM aircraft_parts ORDER BY name";
$stmt_parts = $db->query($sql_parts);
$parts = $stmt_parts->fetchAll(PDO::FETCH_ASSOC);

$sql_planes = "SELECT DISTINCT name FROM airplanes ORDER BY name";
$stmt_planes = $db->query($sql_planes);
$planes = $stmt_planes->fetchAll(PDO::FETCH_COLUMN);

$sql_part_id = "SELECT DISTINCT part_id FROM works ORDER BY part_id";
$stmt_part_id = $db->query($sql_part_id);
$part_id = $stmt_part_id->fetchAll(PDO::FETCH_COLUMN);

$sql_part_name = "SELECT DISTINCT name FROM aircraft_parts ORDER BY name";
$stmt_part_name = $db->query($sql_part_name);
$part_name = $stmt_part_name->fetchAll(PDO::FETCH_COLUMN);

$sql_part_type = "SELECT DISTINCT type FROM aircraft_parts ORDER BY type";
$stmt_part_type = $db->query($sql_part_type);
$part_type = $stmt_part_type->fetchAll(PDO::FETCH_COLUMN);

$sql_statuses = "SELECT DISTINCT status FROM guide ORDER BY status";
$stmt_statuses = $db->query($sql_statuses);
$statuses = $stmt_statuses->fetchAll(PDO::FETCH_COLUMN);

$sql_workers = "SELECT DISTINCT CONCAT(wr.second_name, ' ', wr.name, ' ', wr.third_name) AS worker
                FROM works w
                JOIN guide g ON w.id = g.work_id
                JOIN workers wr ON g.worker_id = wr.id
                ORDER BY worker";
$stmt_workers = $db->query($sql_workers);
$workers = $stmt_workers->fetchAll(PDO::FETCH_COLUMN);

echo "<table class='parts-table'>";
echo "<tr class='header-row'><th>Идентификатор</th><th>Название</th><th>Дата начала работы</th><th>Дата окончания работы</th><th>Идентификатор самолёта</th><th>Название самолёта</th><th>Выполняли</th><th>Статус работы</th><th>Идентификатор детали</th><th>Название</th><th>Тип детали</th></tr>";
echo "<tr class='filter-row'>";
echo "<td><select id='id-filter' name='id_filter' onchange='filterTable()'>";
echo "<option value=''>Все идентификаторы</option>";
foreach ($ids as $id) {
    echo "<option value='$id'>$id</option>";
}
echo "</select></td>";
echo "<td><select id='name-filter' name='name_filter' onchange='filterTable()'>";
echo "<option value=''>Все названия</option>";
foreach ($names as $name) {
    echo "<option value='$name'>$name</option>";
}
echo "</select></td>";
echo "<td>Работы начатые после: <input type='date' id='start-date-filter' name='start_date_filter' onchange='filterTable()'></td>";
echo "<td>Работы законченые до: <input type='date' id='end-date-filter' name='end_date_filter' onchange='filterTable()'></td>";
echo "<td><select id='plane-id-filter' name='plane_id_filter' onchange='filterTable()'>";
echo "<option value=''>Все самолёты</option>";
foreach ($plane_ids as $plane_id) {
    echo "<option value='$plane_id'>$plane_id</option>";
}
echo "</select></td>";
echo "<td><select id='plane-filter' name='plane_filter' onchange='filterTable()'>";
echo "<option value=''>Все самолёты</option>";
foreach ($planes as $plane) {
    echo "<option value='$plane'>$plane</option>";
}
echo "</select></td>";
echo "<td><select id='workers-filter' name='workers_filter' onchange='filterTable()'>";
echo "<option value=''>Все исполнители</option>";
foreach ($workers as $worker) {
    echo "<option value='$worker'>$worker</option>";
}
echo "</select></td>";
echo "<td><select id='status-filter' name='status_filter' onchange='filterTable()'>";
echo "<option value=''>Все статусы</option>";

foreach ($statuses as $status) {
    $status_text = $status === null ? 'null' : ($status ? 'true' : 'false');
    $status_name = $status === null ? 'В процессе' : ($status ? 'Успешно завершена' : 'Не выполнена');
    echo "<option value='$status_text'>$status_name</option>";
}

echo "</select></td>";
echo "<td><select id='part-id' name='part_id' onchange='filterTable()'>";
echo "<option value=''>Все идентификаторы</option>";
foreach ($part_id as $id) {
    echo "<option value='$id'>$id</option>";
}
echo "</select></td>";
echo "<td><select id='part-name' name='part_name' onchange='filterTable()'>";
echo "<option value=''>Все детали</option>";
foreach ($part_name as $name) {
    echo "<option value='$name'>$name</option>";
}
echo "</select></td>";
echo "<td><select id='part-type' name='part_type' onchange='filterTable()'>";
echo "<option value=''>Все типы детали</option>";
foreach ($part_type as $type) {
    echo "<option value='$type'>$type</option>";
}
echo "</select></td>";
echo "</tr>";


foreach ($wk as $row) {
   
    $rowClass = ($row['status'] == 'true') ? 'green' : 'red';
    echo "<tr class='$rowClass'>";
    echo "<td>" . $row['work_id'] . "</td>";
    echo "<td>" . $row['work_name'] . "</td>";
    echo "<td>" . $row['start_date'] . "</td>";
    echo "<td>" . $row['finish_date'] . "</td>";
    if($row['plane_id']!= null){
    echo "<td>" . $row['plane_id'] . "</td>";}
    else{
      echo "<td>Самолёт был списан</td>";
    }
    echo "<td>" . $row['plane_name'] . "</td>";
    echo "<td>" . $row['workers'] . "</td>";
    if ($row['status'] === null) {
        echo "<td>В процессе</td>";
    } elseif ($row['status'] === true) {
        echo "<td>Успешно завершена</td>";
    } elseif ($row['status'] === false) {
        echo "<td>Не выполнена</td>";
    }
    if ($row['part_id'] === null) {
        echo "<td>Данная работа проводится не с деталями</td>"; // Оставить пустым, если нет детали
        echo "<td>Данная работа проводится не с деталями</td>";
        echo "<td>Данная работа проводится не с деталями</td>";
    } else {
        echo "<td>" . $row['part_id'] . "</td>";
        $guideptid=$row['part_id'];
        if(empty($row['part_name'])&&empty($row['part_type'])){
          $sql45 = "SELECT part_name, part_type FROM guide WHERE part_id =  $guideptid";
          $stmt = $db->query($sql45);
          $guide = $stmt->fetch();
          echo "<td>" .  $guide['part_name'] . "</td>"; // Добавить название детали
          echo "<td>" .  $guide['part_type'] . "</td>"; // Добавить тип детали
        }
        else{
        echo "<td>" . $row['part_name'] . "</td>"; // Добавить название детали
        echo "<td>" . $row['part_type'] . "</td>"; // Добавить тип детали
        }
    }
    echo "</tr>";
   
}
echo "<tr id='no-data-message' style='display: none;'><td colspan='7'>Данные о работах отсутствуют</td></tr>";
echo "</table>";



} catch (PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}
?>
<script>
function filterTable() {
  let filterId = document.getElementById('id-filter').value;
  let filterName = document.getElementById('name-filter').value;
  let filterStartDate = document.getElementById('start-date-filter').value;
  let filterEndDate = document.getElementById('end-date-filter').value;
  let filterPlaneId = document.getElementById('plane-id-filter').value;
  let filterPlane = document.getElementById('plane-filter').value; // Добавить фильтр по самолетам
  let filterWorkers = document.getElementById('workers-filter').value;
  let filterStatus = document.getElementById('status-filter').value;
  let filterPartId = document.getElementById('part-id').value; // Добавить фильтр по идентификатору детали
  let filterPartName = document.getElementById('part-name').value; // Добавить фильтр по названию детали
  let filterPartType = document.getElementById('part-type').value; // Добавить фильтр по типу детали
  let tableRows = document.querySelectorAll('.parts-table tr:not(.filter-row, .header-row)');

  document.getElementById('id_filter').value = filterId;
document.getElementById('name_filter').value = filterName;
document.getElementById('start_date_filter').value = filterStartDate;
document.getElementById('end_date_filter').value = filterEndDate;
document.getElementById('plane_id_filter').value = filterPlaneId;
document.getElementById('plane_filter').value = filterPlane;
document.getElementById('workers_filter').value = filterWorkers;
document.getElementById('status_filter').value = filterStatus;
document.getElementById('part_id').value = filterPartId;
document.getElementById('part_name').value = filterPartName;
document.getElementById('part_type').value = filterPartType;

  let showingRows = 0;
  for (let row of tableRows) {
    let idCell = row.cells[0];
    let nameCell = row.cells[1];
    let startDateCell = row.cells[2];
    let endDateCell = row.cells[3];
    let planeIdCell = row.cells[4];
    let planeCell = row.cells[5]; // Добавить ячейку для самолета
    let workersCell = row.cells[6];
    let statusCell = row.cells[7];
    let partIdCell = row.cells[8]; // Добавить ячейку для идентификатора детали
    let partNameCell = row.cells[9]; // Добавить ячейку для названия детали
    let partTypeCell = row.cells[10]; // Добавить ячейку для типа детали

    let showRow = true;

    if (filterId && idCell.textContent != filterId) {
      showRow = false;
    }
    if (filterName && nameCell.textContent != filterName) {
      showRow = false;
    }
    if (filterStartDate && startDateCell.textContent < filterStartDate) {
      showRow = false;
    }
    if (filterEndDate && endDateCell.textContent > filterEndDate) {
      showRow = false;
    }
    if (filterPlaneId && planeIdCell.textContent != filterPlaneId) {
      showRow = false;
    }
    if (filterPlane && planeCell.textContent != filterPlane) { // Добавить фильтр по самолетам
      showRow = false;
    }
    if (filterWorkers && workersCell.textContent.indexOf(filterWorkers) === -1) {
      showRow = false;
    }
    if (filterStatus) {
      let statusText = statusCell.textContent.toLowerCase();
      if (filterStatus === 'true' && statusText !== 'успешно завершена') {
        showRow = false;
      }
      if (filterStatus === 'false' && statusText !== 'не выполнена') {
        showRow = false;
      }
      if (filterStatus === 'null' && statusText !== 'в процессе') {
        showRow = false;
      }
    }
    if (filterPartId && partIdCell.textContent != filterPartId) { // Добавить фильтр по идентификатору детали
      showRow = false;
    }
    if (filterPartName && partNameCell.textContent != filterPartName) { // Добавить фильтр по названию детали
      showRow = false;
    }
    if (filterPartType && partTypeCell.textContent != filterPartType) { // Добавить фильтр по типу детали
      showRow = false;
    }

    if (showRow) {
      row.style.display = '';
      showingRows++;
    } else {
      row.style.display = 'none';
    }

  let noDataMessage = document.getElementById('no-data-message');
  if (showingRows === 0) {
    noDataMessage.style.display = 'block';
  } else {
    noDataMessage.style.display = 'none';
  }}
}

// Вызов функции фильтрации при загрузке страницы
filterTable();

// Вызов функции фильтрации при изменении любого фильтра
let filters = document.querySelectorAll('.filter-row select, .filter-row input');
for (let filter of filters) {
  filter.addEventListener('change', filterTable);
}

document.querySelector('.button-white').addEventListener('click', function() {
  let filters = document.querySelectorAll('.filter-row select, .filter-row input');
  for (let filter of filters) {
    let filterName = filter.name.replace('_filter', '');
    let filterValue = filter.value;
    document.getElementById(filterName).value = filterValue;
  }
  document.querySelector('form').submit();
});


</script>


</body>
</html>
