<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-
scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<?php
require_once "pdo.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST")  {
    $host = 'aws-0-eu-central-1.pooler.supabase.com';
    $dbname = 'postgres';
    $user = 'postgres.dstcxgfoqwifnystedpz';
    $passwor = '6412diploM!';
    $port = 5432;
    try {
        $db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;options='--client_encoding=UTF8'", $user, $passwor);

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $login = $_POST['login'];
    $password = $_POST['password']; // Получаем введенный пароль
    $codeword = $_POST['codeword'];

    // Подготовка и выполнение SQL запроса
    $sql = "
        SELECT id, login, password, code_word, role
        FROM (
            SELECT id, post, login, password, code_word, 'admin' AS role FROM admin
            UNION
            SELECT id, post, login, password, code_word, 'worker' AS role FROM workers
            UNION
            SELECT id, post, login, password, code_word, 'inspector' AS role
            FROM workers WHERE post = 'Инспектор состояния воздушного судна'
        ) AS users
        WHERE login = :login
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute([':login' => $login]);
    $user_info = $stmt->fetch();

    // Проверяем соответствие введенного пароля хешированному паролю из базы данных
    if (!$user_info || !password_verify($password, $user_info['password']) || !password_verify($codeword, $user_info['code_word']) ) {
        echo '<script type="text/javascript"> alert("Неверное имя пользователя, пароль или кодовое слово. Пожалуйста, попробуйте снова.");</script>';
        echo '<script>window.location.href = "./index.php";</script>';
    } else {
        $_SESSION['uid'] = $user_info['id'];
        $_SESSION['login'] = $user_info['login'];
        $_SESSION['code'] = $user_info['code_word'];
        $_SESSION['role'] = $user_info['role'];
    
        if ($_SESSION['role'] == 'admin') {
            echo '<script>window.location.href = "./admin.php?id=' . $_SESSION['uid'] . '";</script>';
        } elseif ($_SESSION['role'] == 'worker') {
            echo '<script>window.location.href = "./worker.php?id=' . $_SESSION['uid'] . '";</script>';
        } elseif ($_SESSION['role'] == 'inspector') {
            echo '<script>window.location.href = "./inspector.php?id=' . $_SESSION['uid'] . '";</script>';
        }
    }
    } catch (PDOException $e) {
        echo "Ошибка подключения: " . $e->getMessage();
    }
}
