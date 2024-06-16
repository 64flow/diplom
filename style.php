<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация - Техническое обслуживание и ремонт воздушных судов</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 300px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 100px auto;
            text-align: center;
        }
        h1 {
            color: #333;
            margin-top: 0;
        }
        .list-item {
    display: block;
    text-align: left;
    margin-bottom: 8px;
}
        h2 {
            color: #333;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-top: 10px;
            font-size: 14px;
            color: #555;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 5px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 3px;
            margin-top: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #0069d9;
        }
        p {
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            color: #0069d9;
        }
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
            background-image: url('/pics/1920x1200-px-aircraft-airplane-clouds-sky-1263993.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed; }
        
        .card h2 {
            margin: 0 0 10px 0;
            font-size: 24px;
        }
        .card p {
            margin: 0;
            font-size: 18px;
            color: #555;
        }
        main {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding-top: 50px;
            
        }
        .card {
            width: 43%;
            margin-bottom: 30px;
            margin-right: 25px;
            margin-left: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 4px;
            background-color: #f9f9f9;
            text-align: center;
        }
        .card1 {
    margin-top: 20px;
    margin-right: 20px;
    margin-left: 20px;
    margin-bottom: 20px;
    display: inline-block;
    width: 26%;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 20px;
    border-radius: 4px;
    background-color: #f9f9f9;
    text-align: center;
}

     .button-green {
        margin-top: 10px;
        margin-bottom: 10px;
        margin-left: 10px;
        margin-right: 10px;
    display: inline-block;
    background-color: green;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.button-green:hover {
    background-color: darkgreen; /* или любой другой цвет, который вы хотите использовать при наведении */
    text-decoration: none;
    color: white;
}
.green-border {
    border: 5px solid green;
}
.yellow-border {
    border: 5px solid yellow;
}
.red-border {
    border: 5px solid red;
}
.center {
    display: flex;
    justify-content: center;
    align-items: center;
    padding-top: 10px;
}

.button-white {
    display: inline-block;
    background-color: white;
    color: black;
    margin-top: 10px;
        margin-bottom: 10px;
        margin-left: 10px;
        margin-right: 10px;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.button-white:hover {
    background-color: black;
    color: white;
}
select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    color: #333;
}

select:focus {
    border-color: #007bff;
    outline: none;
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
        .button-sp {
            margin-top: 10px; 
  display: inline-block;
  background-color: #007bff; /* синий цвет фона */
  color: #fff; /* белый цвет текста */
  padding: 10px 20px;
  border-radius: 4px;
  text-decoration: none;
  margin-bottom: 10px;
  margin-right: 10px; /* отступ справа для отделения от кнопки "Удалить" */
  cursor: pointer; /* изменяем курсор при наведении на кнопку */
}

.button-sp:hover {
  background-color: #0069d9; /* более темный синий цвет фона при наведении */
  color: #fff; /* белый цвет текста при наведении */
}

.button-spt {
            margin-top: 10px; 
  display: inline-block;
  background-color: #ff6700; /* синий цвет фона */
  color: #fff; /* белый цвет текста */
  padding: 10px 20px;
  border-radius: 4px;
  text-decoration: none;
  margin-bottom: 10px;
  margin-right: 10px; /* отступ справа для отделения от кнопки "Удалить" */
  cursor: pointer; /* изменяем курсор при наведении на кнопку */
}

.button-spt:hover {
  background-color: #ec5800; /* более темный синий цвет фона при наведении */
  color: #fff; /* белый цвет текста при наведении */
}
.log-sp {
    margin-top: 10px; 
  display: inline-block;
  background-color: #dc3545; /* красный цвет фона */
  color: #fff; /* белый цвет текста */
  padding: 10px 20px;
  border-radius: 4px;
  text-decoration: none;
  cursor: pointer; /* изменяем курсор при наведении на кнопку */
}

.log-sp:hover {
  background-color: #bd2130; /* более темный красный цвет фона при наведении */
  color: #fff; /* белый цвет текста при наведении */
}

/* добавляем отступы между кнопками */
.button-sp + .log-sp {
  margin-left: 10px;
}
.parts-table {
    width: 100%;
    
}

.parts-table th,
.parts-table td {
    
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.parts-table th {
    background-color: #f2f2f2;
    font-weight: bold;
}

.parts-table tr:hover {
    background-color: #fff;
}
.parts-table tr.warning {
    background-color: #ffeb3b; /* Желтый цвет */
}

.parts-table tr.danger {
    background-color: #f44336; /* Красный цвет */
}
.checkbox-container {
    display: flex;
    align-items: center;
    margin-bottom: 5px;
}
.form-row {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    justify-content: center;
}

.form-row label {
    margin-right: 10px;
    font-weight: bold;
    text-align: center;
}

.form-row input[type="datetime-local"],
.form-row input[type="date"],
.form-row input[type="number"] {
    width: 200px;
    padding: 5px;
    font-size: 14px;
    border-radius: 10px;
    
}

.checkbox-container {
    display: flex;
    align-items: center;
    margin-bottom: 5px;
}
.container1 {
    width: 38%;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 35px auto;
            text-align: center;
}

    </style>
</head>