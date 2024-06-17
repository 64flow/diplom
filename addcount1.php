<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
    <?php require "style.php";
    require "h2.php";
    $id=$_GET['id'];
    $host = 'aws-0-eu-central-1.pooler.supabase.com';
    $dbname = 'postgres';
    $user = 'postgres.dstcxgfoqwifnystedpz';
    $password = '###';
    $port = 5432;
    $db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;options='--client_encoding=UTF8'", $user, $password);

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM wirehouse WHERE id = $id";
    $stmt = $db->query($sql);
    $service = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
    <style></style>
</head>
<body>
    <main>
        <div class="container">
            <h1>Закупка на склад: <?php echo htmlspecialchars($service['name']); ?>. Семейство: <?php echo htmlspecialchars($service['family_type']); ?></h1>
            <form action="addcount.php?idf=<?php echo urlencode($id); ?>" method="post">
                <div class="form-row">
                    <label for="addcount">Необходимое количество для закупки:</label>
                </div>
                <div class="form-row">
                    <input type="number" id="addcount" name="addcount" value="<?php echo $default_value; ?>" min="0">
                </div>
                <button type="submit">Закупить</button>
            </form>
            <br>
            <a href='wirehouse.php' class='button-green'>Назад на склад деталей</a>
        </div>
    </main>
</body>
</html>
