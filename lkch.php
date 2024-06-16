<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php require "style.php";
    require "h3.php";?>
    <style></style>
</head>
<body>
<?php
require_once "pdo.php";
session_start();
$host = 'aws-0-eu-central-1.pooler.supabase.com';
$dbname = 'postgres';
$user = 'postgres.dstcxgfoqwifnystedpz';
$password = '6412diploM!';
$port = 5432;

$db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;options='--client_encoding=UTF8'", $user, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
  
    try {
        $sql = "SELECT id, second_name, name, third_name, birthdate, post, login, password, code_word FROM workers WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $worker = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($worker) {
            echo "
<main>
    <div class='container1'>
    <h1>Редактирование личных данных</h1>
    <form action='lkch1.php' method='post' onsubmit='return validateAge()'>
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
        <input type='hidden' name='post' value='{$worker['post']}'>
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
    } catch (PDOException $e) {
        echo "Ошибка подключения: " . $e->getMessage();
    }
}
?>
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
            alert("Ваш возраст должен быть не менее 18 лет");
            return false;
        }
        return true;
    }
</script>
</body>
</html>