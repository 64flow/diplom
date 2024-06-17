<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
    <?php require "style.php";
    require "h2.php";?>
    <style></style>
</head>
<body>
<script>
        function validateAge() {
            var birth_date = new Date(document.getElementById("birthdate").value);
            var today = new Date();
            var age = today.getFullYear() - birth_date.getFullYear();
            var m = today.getMonth() - birth_date.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birth_date.getDate())) {
                age--;
            }
            if (age < 18) {
                alert("Сотруднику должно быть не менее 18 лет");
                return false;
            }
            return true;
        }
    </script>
<?php
require_once "pdo.php";
session_start();
$host = 'aws-0-eu-central-1.pooler.supabase.com';
$dbname = 'postgres';
$user = 'postgres.dstcxgfoqwifnystedpz';
$password = '###';
$port = 5432;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['birthdate']) || empty($_POST['birthdate'])) {
        echo '<script type="text/javascript"> alert("Введите дату рождения.");</script>';
        echo '<script type="text/javascript">window.location.href = "./add_worker.php" </script>';
        exit();
    }}

$db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;options='--client_encoding=UTF8'", $user, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  
  try {
    $sql = "SELECT id, second_name, name, third_name, birthdate, post, employment_status, work_id, login, password, code_word FROM workers WHERE id = $id";
    $stmt = $db->query($sql);
    $emp = $stmt->fetchAll();
    if (!empty($emp)) {
        $worker = $emp[0];

        echo "
<main>
    <div class='container1'>
    <h1>Редактирование данных сотрудника</h1>
    <form action='workerup1.php' method='post' onsubmit='return validateAge()'>
    <input type='hidden' name='id' value='{$worker['id']}'>
        <label for='second_name'>Фамилия:</label>
        <input type='text' name='second_name' id='second_name' value='{$worker['second_name']}' required><br>

        <label for='name'>Имя:</label>
        <input type='text' name='name' id='name' value='{$worker['name']}' required><br>

        <label for='third_name'>Отчество:</label>
        <input type='text' name='third_name' id='third_name' value='{$worker['third_name']}' required><br>

        <label for='birthdate'>Дата рождения:</label>
        <div class='form-row'>
        <input type='date' name='birthdate' id='birthdate' value='{$worker['birthdate']}' required><br>
        </div>

        <label for='post'>Должность:</label>
        <select name='post' id='post' required>
        <option value='' disabled selected>Выберите должность</option>
        <option value='Заправщик'" . ($worker['post'] == 'Заправщик' ? ' selected' : '') . ">Заправщик</option>
        <option value='Техник по обслуживанию шасси'" . ($worker['post'] == 'Техник по обслуживанию шасси' ? ' selected' : '') . ">Техник по обслуживанию шасси</option>
        <option value='Специалист по противообледенительной обработке'" . ($worker['post'] == 'Специалист по противообледенительной обработке' ? ' selected' : '') . ">Специалист по противообледенительной обработке</option>
        <option value='Техник по ремонту воздушных судов'" . ($worker['post'] == 'Техник по ремонту воздушных судов' ? ' selected' : '') . ">Техник по ремонту воздушных судов</option>
        <option value='Техник по ремонту двигателей'" . ($worker['post'] == 'Техник по ремонту двигателей' ? ' selected' : '') . ">Техник по ремонту двигателей</option>
        <option value='Инспектор состояния воздушного судна'" . ($worker['post'] == 'Инспектор состояния воздушного судна' ? ' selected' : '') . ">Инспектор состояния воздушного судна</option>
        <option value='Техник по ремонту систем'" . ($worker['post'] == 'Техник по ремонту систем' ? ' selected' : '') . ">Техник по ремонту систем</option>
        <option value='Техник по ремонту фюзеляжей'" . ($worker['post'] == 'Техник по ремонту фюзеляжей' ? ' selected' : '') . ">Техник по ремонту фюзеляжей</option>
        <option value='Техник по ремонту рулевых элементов'" . ($worker['post'] == 'Техник по ремонту рулевых элементов' ? ' selected' : '') . ">Техник по ремонту рулевых элементов</option>
        <option value='Техник по ремонту остекления'" . ($worker['post'] == 'Техник по ремонту остекления' ? ' selected' : '') . ">Техник по ремонту остекления</option>
        <option value='Специалист по ремонту салона'" . ($worker['post'] == 'Специалист по ремонту салона' ? ' selected' : '') . ">Специалист по ремонту салона</option>
        <option value='Специалист по ремонту систем связи'" . ($worker['post'] == 'Специалист по ремонту систем связи' ? ' selected' : '') . ">Специалист по ремонту систем связи</option>
        <option value='Специалист по ремонту систем навигации'" . ($worker['post'] == 'Специалист по ремонту систем навигации' ? ' selected' : '') . ">Специалист по ремонту систем навигации</option>
        <option value='Техник по ремонту крыла самолёта'" . ($worker['post'] == 'Техник по ремонту крыла самолёта' ? ' selected' : '') . ">Техник по ремонту крыла самолёта</option>
        <option value='Техник по ремонту элементов управления'" . ($worker['post'] == 'Техник по ремонту элементов управления' ? ' selected' : '') . ">Техник по ремонту элементов управления</option>
        <option value='Техник по ремонту оперения'" . ($worker['post'] == 'Техник по ремонту оперения' ? ' selected' : '') . ">Техник по ремонту оперения</option>
        <option value='Техник по ремонту люков'" . ($worker['post'] == 'Техник по ремонту люков' ? ' selected' : '') . ">Техник по ремонту люков</option>
            
        </select><br>

        <label for='login'>Логин:</label>
        <input type='text' name='login' id='login' value='{$worker['login']}' required><br>

        <label for='password'>Пароль:</label>
        <input type='password' name='password' id='password' value='{$worker['password']}' required><br>

        <label for='code_word'>Кодовое слово:</label>
        <input type='text' name='code_word' id='code_word' value='{$worker['code_word']}' required><br>

        <button type='submit'>Сохранить изменения</button>
    </form>
    </div>

</main>";
    } else {
        echo "Сотрудник не найден.";
    }

  }catch (PDOException $e) {
    echo "Connection error: " . $e->getMessage();
}
}
?>
</body>
</html>
