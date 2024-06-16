<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Панель администратора</title>
<?php
require "style.php";
require "h2.php";?>

<?php


require_once "pdo.php";
session_start();

$host = 'aws-0-eu-central-1.pooler.supabase.com';
$dbname = 'postgres';
$user = 'postgres.dstcxgfoqwifnystedpz';
$password = '6412diploM!';
$port = 5432;
$part_id = $_GET['id'];
$plane_id = $_GET['plane_id'];

try {
    $db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;options='--client_encoding=UTF8'", $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
    $sql1 = "SELECT id, name, plane_id, family_type, safety_of_the_part, type FROM aircraft_parts WHERE id = $part_id";
    $stmt = $db->query($sql1);
    $pt = $stmt->fetchAll();
    $sql2 = "SELECT id, finish_date, plane_id FROM works WHERE plane_id = $plane_id AND part_id = $part_id";
    $stmt = $db->query($sql2);
    $works = $stmt->fetchAll();
   
    

    $hasUnfinishedWork = false;
    foreach ($works as $work) {
        $work_id = $work['id'];
        $finish_date = DateTime::createFromFormat('Y-m-d H:i:s', $work['finish_date']);
        $today = new DateTime();
        $sql = "SELECT COUNT(*) FROM guide WHERE work_id = $work_id AND status IS TRUE";
        $stmt = $db->query($sql);
        $completedWorksCount = $stmt->fetchColumn();
    
        // Если сегодняшняя дата меньше даты завершения работы и нет завершенных работ,
        // устанавливаем флаг $hasUnfinishedWork в true и выходим из цикла
        if ($today < $finish_date && $completedWorksCount == 0) {
            $hasUnfinishedWork = true;
            break;
        }
    }
    
    if (!empty($pt)) {
        $pt = $pt[0];
        if ($pt['type']=='Двигатель'||$pt['type']=='Винт') {
            $sql = "SELECT id, second_name, name, third_name, birthdate, post, employment_status, work_id, login, password, code_word FROM workers WHERE post = 'Техник по ремонту двигателей' AND employment_status = FALSE";
            $stmt = $db->query($sql);
            $emp = $stmt->fetchAll();
        }
        elseif($pt['type']=='Шасси'){
            $sql = "SELECT id, second_name, name, third_name, birthdate, post, employment_status, work_id, login, password, code_word FROM workers WHERE post = 'Техник по обслуживанию шасси' AND employment_status = FALSE";
            $stmt = $db->query($sql);
            $emp = $stmt->fetchAll();
        }
        elseif($pt['type']=='Система'){
            $sql = "SELECT id, second_name, name, third_name, birthdate, post, employment_status, work_id, login, password, code_word FROM workers WHERE post = 'Техник по ремонту систем' AND employment_status = FALSE";
            $stmt = $db->query($sql);
            $emp = $stmt->fetchAll();
        }
        elseif($pt['type']=='Фюзеляж'){
            $sql = "SELECT id, second_name, name, third_name, birthdate, post, employment_status, work_id, login, password, code_word FROM workers WHERE post = 'Техник по ремонту фюзеляжей' AND employment_status = FALSE";
            $stmt = $db->query($sql);
            $emp = $stmt->fetchAll();
        }
        elseif($pt['type']=='Руль'){
            $sql = "SELECT id, second_name, name, third_name, birthdate, post, employment_status, work_id, login, password, code_word FROM workers WHERE post = 'Техник по ремонту рулевых элементов' AND employment_status = FALSE";
            $stmt = $db->query($sql);
            $emp = $stmt->fetchAll();
        }
        elseif($pt['type']=='Окно'){
            $sql = "SELECT id, second_name, name, third_name, birthdate, post, employment_status, work_id, login, password, code_word FROM workers WHERE post = 'Техник по ремонту остекления' AND employment_status = FALSE";
            $stmt = $db->query($sql);
            $emp = $stmt->fetchAll();
        }
        elseif($pt['type']=='Салон' || $pt['type']=='Кабина'){
            $sql = "SELECT id, second_name, name, third_name, birthdate, post, employment_status, work_id, login, password, code_word FROM workers WHERE post = 'Специалист по ремонту салона' AND employment_status = FALSE";
            $stmt = $db->query($sql);
            $emp = $stmt->fetchAll();
        }
        elseif($pt['type']=='Связь'){
            $sql = "SELECT id, second_name, name, third_name, birthdate, post, employment_status, work_id, login, password, code_word FROM workers WHERE post = 'Специалист по ремонту систем связи' AND employment_status = FALSE";
            $stmt = $db->query($sql);
            $emp = $stmt->fetchAll();
        }
        elseif($pt['type']=='Бак'){
            $sql = "SELECT id, second_name, name, third_name, birthdate, post, employment_status, work_id, login, password, code_word FROM workers WHERE post = 'Техник по ремонту топливных баков' AND employment_status = FALSE";
            $stmt = $db->query($sql);
            $emp = $stmt->fetchAll();
        }
        elseif($pt['type']=='Навигация'){
            $sql = "SELECT id, second_name, name, third_name, birthdate, post, employment_status, work_id, login, password, code_word FROM workers WHERE post = 'Специалист по ремонту систем навигации' AND employment_status = FALSE";
            $stmt = $db->query($sql);
            $emp = $stmt->fetchAll();
        }
        elseif($pt['type']=='Крыло'){
            $sql = "SELECT id, second_name, name, third_name, birthdate, post, employment_status, work_id, login, password, code_word FROM workers WHERE post = 'Техник по ремонту крыла самолёта' AND employment_status = FALSE";
            $stmt = $db->query($sql);
            $emp = $stmt->fetchAll();
        }
        elseif($pt['type']=='Управление'){
            $sql = "SELECT id, second_name, name, third_name, birthdate, post, employment_status, work_id, login, password, code_word FROM workers WHERE post = 'Техник по ремонту элементов управления' AND employment_status = FALSE";
            $stmt = $db->query($sql);
            $emp = $stmt->fetchAll();
        }
        elseif($pt['type']=='Оперение'){
            $sql = "SELECT id, second_name, name, third_name, birthdate, post, employment_status, work_id, login, password, code_word FROM workers WHERE post = 'Техник по ремонту оперения' AND employment_status = FALSE";
            $stmt = $db->query($sql);
            $emp = $stmt->fetchAll();
        }
        elseif($pt['type']=='Дверь'){
            $sql = "SELECT id, second_name, name, third_name, birthdate, post, employment_status, work_id, login, password, code_word FROM workers WHERE post = 'Техник по ремонту люков' AND employment_status = FALSE";
            $stmt = $db->query($sql);
            $emp = $stmt->fetchAll();
        }}
}
 catch (PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}
?>
</head>
<body>
<div class="center">
<a href="planeinfo.php?idf=<?php echo $plane_id; ?>" class="button-white">Назад к списку деталей самолёта</a>
</div>
<div class="container1">
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $requiredNumberOfEmployees = intval($_POST['required_number_of_empoyees']);
        $selectedWorkers = $_POST['worker'];
        $plane_id = $_POST['idf'];
        $worker_id=$_POST['id'];

        
    } else {
        $requiredNumberOfEmployees = 0;
        $selectedWorkers = [];
    }
    ?>


    <h2>Назначение ремонта детали</h2>
    <form action="repair_part1.php?plane_id=<?php echo urlencode($plane_id); ?>&part_id=<?php echo urlencode($part_id); ?>" method="post">
    <input type="hidden" name="idf" value="">
    
    <div class="form-row">
            <label for="start_date">Начать не позднее:</label>
    </div>
            <div class="form-row">
            <input type="datetime-local" id="start_date" name="start_date" required>
            </div>
            <div class="form-row">
            <label for="finish_date">Закончить не позднее:</label>
            </div>
            <div class="form-row">
            <input type="datetime-local" id="finish_date" name="finish_date" required>
        </div>
        <div class="form-row">
            <label for="required_number_of_empoyees">Необходимое количество сотрудников:</label>
        </div>
            <div class="form-row">
            <input type="number" id="required_number_of_empoyees" name="required_number_of_empoyees" value="<?= $requiredNumberOfEmployees ?>" min="0" required oninput="updateRequiredNumberOfEmployees(this.value)">
        </div>
        <div class="form-row">
            <label for="worker">Выбрать свободных сотрудников:</label>
            <ul>
            <?php foreach ($emp as $employee): ?>
                <li class="checkbox-container">
                    <input type="checkbox" name="worker[]" value="<?= $employee['id'] ?>" id="worker_<?= $employee['id'] ?>" onchange="limitSelection(this, <?= $requiredNumberOfEmployees ?>)" <?= in_array($employee['id'], $selectedWorkers) ? 'checked' : '' ?>>
                    <label for="worker_<?= $employee['id'] ?>"><?= $employee['second_name'] . ' ' . $employee['name'] . ' ' . $employee['third_name'] ?></label>
            </li>
            <?php endforeach; ?>
            </ul>
        </div>
        <br>
        
            <button type="submit" class="button-sp">Назначить ремонт детали</button>
        
    </form>
    
    <script>
const form = document.querySelector('form');
const startDateInput = document.getElementById('start_date');
const finishDateInput = document.getElementById('finish_date');

// Установить текущую дату и время в качестве минимального значения для start_date
startDateInput.min = new Date().toISOString().slice(0, -8);

// Добавить событие на ввод значения start_date
startDateInput.addEventListener('input', function() {
    // Установить минимальное значение для finish_date равным значению start_date
    finishDateInput.min = startDateInput.value;
});
const hasUnfinishedWork = <?php echo json_encode($hasUnfinishedWork); ?>;
// Добавить событие на отправку формы
// Добавить событие на отправку формы
form.addEventListener('submit', function(event) {
    // Преобразовать значения start_date и finish_date в объекты Date
    const startDate = new Date(startDateInput.value);
    const finishDate = new Date(finishDateInput.value);

    // Проверить, чтобы start_date была не ранее текущего момента
    if (startDate < new Date()) {
        alert('Начальная дата не может быть ранее текущего момента');
        event.preventDefault();
        return;
    }

    // Проверить, чтобы finish_date было позже start_date и не совпадало с ней
    if (finishDate <= startDate) {
        alert('Конечная дата должна быть позже начальной даты и не должна совпадать с ней');
        event.preventDefault();
        return;
    }

    // Проверить, чтобы не было незавершенной работы
    if (hasUnfinishedWork) {
        alert('На эту деталь ремонт уже назначен');
        event.preventDefault();
        return;
    }

    // Если все проверки пройдены, отправить форму
    form.submit();
});



function limitSelection(checkbox, requiredNumberOfEmployees) {
    var selectedCheckboxes = document.querySelectorAll('input[name="worker[]"]:checked');
    if (selectedCheckboxes.length > requiredNumberOfEmployees && checkbox.checked) {
        alert("Вы не можете выбрать больше " + requiredNumberOfEmployees + " сотрудников.");
        checkbox.checked = false;
    } else if (selectedCheckboxes.length < requiredNumberOfEmployees && !checkbox.checked) {
        alert("Вы не можете выбрать меньше " + requiredNumberOfEmployees + " сотрудников.");
        checkbox.checked = true;
    }
}

function updateRequiredNumberOfEmployees(value) {
        requiredNumberOfEmployees = parseInt(value);
        var checkboxes = document.querySelectorAll('input[name="worker[]"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.onchange = function() {
                limitSelection(this, requiredNumberOfEmployees);
            };
        });
    }
</script>
</div>
</body>
</html>