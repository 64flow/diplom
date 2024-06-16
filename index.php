<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    
</head>
<body>
<?php require "header1.php";
require "style.php" ?>

    <div class="container">
       
        <h2>Вход в систему</h2>
        <form action="auth.php" method="post">
            <label for="login">Имя пользователя:</label>
            <input type="text" id="login" name="login" required>
            <br>
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <label for="codeword">Кодовое слово:</label>
            <input type="text" id="codeword" name="codeword" required>
            <br>
            <button type="submit">Далее</button>
        </form>
       
    </div>
</body>
</html>
