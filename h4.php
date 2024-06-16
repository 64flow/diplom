<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Веб-приложение для управления техническим обслуживанием и ремонтом воздушных судов</title>
    <link rel="shortcut icon" type="image/x-icon" href="/pics/jTx69nkrc.png">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #0056b3;
            color: #fff;
            padding: 20px 0;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        header h1 {
            margin: 0;
            font-size: 36px;
            color: #fff;
            flex-grow: 1;
            text-align: center;
            margin-right: auto; /* Добавлено свойство margin-right: auto */
        }
        header nav {
            text-align: right;
            margin: 0;
            margin-left: auto; /* Добавлено свойство margin-left: auto */
        }
        header nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 10px;
            font-size: 18px;
            display: inline-block;
            padding: 5px 10px;
            border-radius: 3px;
            text-decoration: none;
        }
        header nav a:hover {
            background-color: #333;
            color: #fff;
        }
        header nav a.logout {
            background-color: #f00;
        }
        header nav a.admin {
            background-color: #fff;
            color: #0056b3;
        }
        header nav a.lk {
            background-color: #008000;
            color: white;
        }
    </style>
</head>
<body>
<header>
        <h1>Страница инспектора</h1>
        <nav>
        <a href="inspector.php" class="admin">На главную</a>
            <a href="lkins.php" class="lk">Личные данные</a>
            
        <a href="logout.php" class="logout">Выйти</a>
        </nav>
    </header>

</body>
</html>
<?php
session_start();
$proverka = $_SESSION['uid'];
if (empty($proverka)){
    echo '<script type="text/javascript"> alert("У вас нет доступа к этой странице");</script>';
    echo '<script>window.location.href = "./logout.php";</script>';
}

