<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
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

    <?php require "style.php";
    require "h2.php";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['birthdate']) || empty($_POST['birthdate'])) {
            echo '<script type="text/javascript"> alert("Введите дату рождения.");</script>';
            echo '<script type="text/javascript">window.location.href = "./add_worker.php" </script>';
            exit();
        }}?>
    <style></style>


</head>
<body>
<main>
    <div class="container1">
    <h1>Добавление сотрудника</h1>
    <form action="add_worker1.php" method="post" onsubmit="return validateAge()">
        <label for="second_name">Фамилия:</label>
        <input type="text" name="second_name" id="second_name" required><br>

        <label for="name">Имя:</label>
        <input type="text" name="name" id="name" required><br>

        <label for="third_name">Отчество:</label>
        <input type="text" name="third_name" id="third_name" required><br>

        <label for="birthdate">Дата рождения:</label>
        <div class="form-row">
        <input type="date" name="birthdate" id="birthdate"required><br>
        </div>

        <label for="post">Должность:</label>
        <select name="post" id="post" required>
        <option value="" disabled selected>Выберите должность</option>
            <option value="Заправщик">Заправщик</option>
            <option value="Техник по обслуживанию шасси">Техник по обслуживанию шасси</option>
            <option value="Техник по ремонту двигателей">Техник по ремонту двигателей</option>
            <option value="Инспектор состояния воздушного судна">Инспектор состояния воздушного судна</option>
            <option value="Специалист по противообледенительной обработке">Специалист по противообледенительной обработке</option>
            <option value="Техник по ремонту систем">Техник по ремонту систем</option>
            <option value="Техник по ремонту фюзеляжей">Техник по ремонту фюзеляжей</option>
            <option value="Техник по ремонту рулевых элементов">Техник по ремонту рулевых элементов</option>
            <option value="Техник по ремонту остекления">Техник по ремонту остекления</option>
            <option value="Специалист по ремонту салона">Специалист по ремонту салона</option>
            <option value="Специалист по ремонту систем связи">Специалист по ремонту систем связи</option>
            <option value="Специалист по ремонту систем навигации">Специалист по ремонту систем навигации</option>
            <option value="Техник по ремонту крыла самолёта">Техник по ремонту крыла самолёта</option>
            <option value="Техник по ремонту элементов управления">Техник по ремонту элементов управления</option>
            <option value="Техник по ремонту оперения">Техник по ремонту оперения</option>
            <option value="Техник по ремонту люков">Техник по ремонту люков</option>
            
        </select><br>

        <label for="login">Логин:</label>
        <input type="text" name="login" id="login" required><br>

        <label for="password">Пароль:</label>
        <input type="password" name="password" id="password" required><br>

        <label for="code_word">Кодовое слово:</label>
        <input type="text" name="code_word" id="code_word" required><br>

        <button type="submit">Добавить сотрудника</button>
    </form>
    </div>

</main>
</body>
</html>
