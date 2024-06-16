<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-
scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

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
<a href="planes.php" class="button-white">Назад к списку самолётов</a>
</div>
    <main>
    <div class="container">
    <h1>Добавление нового самолета</h1>
    <form action="add_plane1.php" method="post">
        
        <label for="name">Название самолёта:</label>
        <select name="name" id="name" required>
            <option value="Airbus A330">Airbus A330</option>
            <option value="Airbus A320">Airbus A320</option>
            <option value="ATR 42">ATR 42</option>
            <option value="ATR 72">ATR 72</option>
            <option value="Beechcraft King Air">Beechcraft King Air</option>
            <option value="Beechcraft Baron">Beechcraft Baron</option>
            <option value="Bombardier CRJ700">Bombardier CRJ700</option>
            <option value="Bombardier Q400">Bombardier Q400</option>
            <option value="Boeing 777">Boeing 777</option>
            <option value="Boeing 747">Boeing 747</option>
            <option value="Cessna 402">Cessna 402</option>
            <option value="Embraer ERJ">Embraer ERJ</option>
            
         
            
            
        </select><br>


        <button type="submit">Добавить самолет </button>
        
        
    </form>
    <br>
    
    </main>

</div>
</body>
</html>
