<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Панель администратора</title>
</head>
<?php require "style.php";
require "h4.php"?>


<body>

<style>
       .no-data-message {
    width: 50%;
    font-size: 24px;
    text-align: center;
    padding: 10px;
    margin-top: 20px;
    background-color: #ff0000; /* красный цвет фона */
    color: #ffffff; /* белый цвет текста */
    margin: 0 auto; /* автоматическое центрирование по горизонтали */
}

    </style>
<br>

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
    $sql_planes = "SELECT DISTINCT name FROM airplanes";
$stmt_planes = $db->query($sql_planes);
$plane_names = $stmt_planes->fetchAll(PDO::FETCH_COLUMN);

$sql_families = "SELECT DISTINCT family_type FROM airplanes";
$stmt_families = $db->query($sql_families);
$families = $stmt_families->fetchAll(PDO::FETCH_COLUMN);
$sql_planes = "SELECT DISTINCT name FROM airplanes";
$stmt_planes = $db->query($sql_planes);
$plane_names = $stmt_planes->fetchAll(PDO::FETCH_COLUMN);


echo '<div class="center" style="display: flex; gap: 10px;">';
echo '<select id="con-filter" name="con_filter" onchange="filterTable()" style="width: 200px;">';
echo '<option value="">Все состояния</option>';
echo '<option value="Превосходное">Превосходное</option>';
echo '<option value="Хорошее">Хорошее</option>';
echo '<option value="Требует ремонта">Требует ремонта</option>';
echo '</select>';

echo '<select id="plane-filter" name="plane_filter" onchange="filterTable()" style="width: 200px;">';
echo '<option value="">Все самолеты</option>';
foreach ($plane_names as $name) {
    echo '<option value="' . $name . '">' . $name . '</option>';
}
echo '</select>';

echo '<select id="family-filter" name="family_filter" onchange="filterTable()" style="width: 200px;">';
echo '<option value="">Все семейства</option>';
foreach ($families as $family) {
    echo '<option value="' . $family . '">' . $family . '</option>';
}
echo '</select>';
echo '</div>';
echo '<div class="center" style="margin-top: 20px;">';
echo '</div>';

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
    
        
    
    $sql = "SELECT id, name, family_type, general_condition, fuel_type, fuel_max, fuel_current FROM airplanes";
    if (!empty($_GET['condition'])) {
        $condition = $_GET['condition'];
        $sql .= " WHERE general_condition = '$condition'";
    }
    $stmt = $db->query($sql);
    $plinf = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<div style='width: 100%;'>";
    foreach ($plinf as $plane) {
        $proc = ($plane['fuel_current'] / $plane['fuel_max']) * 100;
        $cardClass = '';
    
        if ($plane['general_condition'] == 'Превосходное') {
            if ($proc > 75) {
                $cardClass = 'green-border';
            } elseif ($proc > 30) {
                $cardClass = 'yellow-border';
            } else {
                $cardClass = 'red-border';
            }
        } elseif ($plane['general_condition'] == 'Хорошее') {
            if ($proc > 30) {
                $cardClass = 'yellow-border';
            } else {
                $cardClass = 'red-border';
            }
        } elseif ($plane['general_condition'] == 'Требует ремонта') {
            $cardClass = 'red-border';
        }
        if($proc<100){
        echo "
            <div class='card1 $cardClass'>
                <div class='list-item'>Название: ".$plane['name']."</div>
                <div class='list-item'>Семейство: ".$plane['family_type']."</div>
                <div class='list-item'>Общее состояние: ".$plane['general_condition']."</div>
                <div class='list-item'>Тип топлива: ".$plane['fuel_type']."</div>
                <div class='list-item'>Объем топливных баков: ".$plane['fuel_max']." л.</div>
                <div class='list-item'>Заполненность баков: ".$proc."%</div>
                
                <a href='fuelins.php?idf=".$plane['id']."' class='button-sp'>Осмотреть и изменить количество топлива</a>
                <a href='planeinfoins.php?idf=".$plane['id']."' class='button-green'>Подробнее</a>
    
            </div>
        ";}
        else{
            echo "
            <div class='card1 $cardClass'>
                <div class='list-item'>Название: ".$plane['name']."</div>
                <div class='list-item'>Семейство: ".$plane['family_type']."</div>
                <div class='list-item'>Общее состояние: ".$plane['general_condition']."</div>
                <div class='list-item'>Тип топлива: ".$plane['fuel_type']."</div>
                <div class='list-item'>Объем топливных баков: ".$plane['fuel_max']." л.</div>
                <div class='list-item'>Заполненность баков: ".$proc."%</div>
                <div class='center'>
                <a href='fuelins.php?idf=".$plane['id']."' class='button-sp'>Осмотреть и изменить количество топлива</a>
                <a href='planeinfoins.php?idf=".$plane['id']."' class='button-green'>Подробнее</a>
                </div>
            </div>
        ";
        }
    }
    echo "</div>";
    
} catch (PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}
?>

<script>
function filterTable() {
    let filterCon = document.getElementById('con-filter').value;
    let planeFilter = document.getElementById('plane-filter').value;
    let familyFilter = document.getElementById('family-filter').value;

    let cards = document.querySelectorAll('.card1');
    let dataFound = false; // Флаг, указывающий на наличие найденных данных

    // Присваиваем стиль inline-block для карточек
    for (let card of cards) {
        card.style.display = 'inline-block';
    }

    // Фильтрация карточек
    for (let card of cards) {
        let condition = card.querySelector('.list-item:nth-child(3)').textContent.split(':')[1].trim();
        let planeName = card.querySelector('.list-item:nth-child(1)').textContent.split(':')[1].trim();
        let family = card.querySelector('.list-item:nth-child(2)').textContent.split(':')[1].trim();

        if ((filterCon === "" || condition === filterCon) &&
            (planeFilter === "" || planeName === planeFilter) &&
            (familyFilter === "" || family === familyFilter)) {
            card.style.display = 'inline-block';
            dataFound = true; // Если хотя бы одно совпадение найдено, изменяем флаг
        } else {
            card.style.display = 'none';
        }
    }

    // Если не найдено ни одного совпадения, добавляем сообщение "Данные отсутствуют"
    if (!dataFound) {
        let noDataMessage = document.querySelector('.no-data-message');
        if (!noDataMessage) { // Добавляем сообщение только если оно еще не было добавлено
            noDataMessage = document.createElement('div');
            noDataMessage.textContent = 'Данные отсутствуют';
            noDataMessage.classList.add('no-data-message');
            document.body.appendChild(noDataMessage);
        }
    } else {
        // Если были найдены совпадения, удаляем сообщение "Данные отсутствуют", если оно существует
        let existingMessage = document.querySelector('.no-data-message');
        if (existingMessage) {
            existingMessage.parentNode.removeChild(existingMessage);
        }
    }
}

// Вызываем функцию фильтрации при загрузке страницы и при изменении фильтра
document.addEventListener('DOMContentLoaded', filterTable);

let container = document.getElementById('con-filter').parentNode;
let filters = container.querySelectorAll('select, input');

for (let filter of filters) {
    filter.addEventListener('change', filterTable);
}


</script>
</body>
</html>
