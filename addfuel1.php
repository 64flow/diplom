<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
    <?php require "style.php";
    require "h2.php";
    $id=$_GET['id'];
    require_once "pdo.php";
session_start();

$host = 'aws-0-eu-central-1.pooler.supabase.com';
$dbname = 'postgres';
$user = 'postgres.dstcxgfoqwifnystedpz';
$password = '6412diploM!';
$port = 5432;


    $db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;options='--client_encoding=UTF8'", $user, $password);

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM service_wirehouse WHERE id = $id";
    $stmt = $db->query($sql);
    $service = $stmt->fetch(PDO::FETCH_ASSOC);?>
    <style></style>
</head>
<body>
    <main>
        <div class="container">
            <h3>Закупка на склад сервиса: <?php echo htmlspecialchars($service['name']); ?> <?php echo htmlspecialchars($service['type']); ?></h3>
            <form action="addfuel.php?idf=<?php echo urlencode($id); ?>" method="post">
                <div class="form-row">
                    <label for="addfuel">Необходимое количество для закупки:</label>
                </div>
                <div class="form-row">
                    <input type="number" id="addfuel" name="addfuel" value="<?php echo $default_value; ?>" min="0" step="any">
                </div>
                <button type="submit">Закупить</button>
            </form>
            <br>
            <a href='fuel.php' class='button-green'>Назад на склад сервиса</a>
        </div>
    </main>
</body>
</html>
