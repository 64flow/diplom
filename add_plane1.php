<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Панель администратора</title>
<?php require "style.php";
require "h2.php"?>
<?php
require_once "pdo.php";
session_start();

$host = 'aws-0-eu-central-1.pooler.supabase.com';
$dbname = 'postgres';
$user = 'postgres.dstcxgfoqwifnystedpz';
$password = '6412diploM!';
$port = 5432;

try {
    $db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;options='--client_encoding=UTF8'", $user, $password);

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $plane = $_POST['name'];
if ($plane == 'Boeing 777'){
    // Prepare SQL statement
    $stmt = $db->prepare("INSERT INTO airplanes (name, family_type, general_condition, fuel_type, fuel_max, fuel_current) VALUES (:name, :family_type, :general_condition, :fuel_type, :fuel_max, :fuel_current)");
$stmt->bindParam(':name', $plane);
$stmt->bindParam(':family_type', $family_type);
$stmt->bindParam(':general_condition', $general_condition);
$stmt->bindParam(':fuel_type', $fuel_type);
$stmt->bindParam(':fuel_max', $fuel_max);
$stmt->bindParam(':fuel_current', $fuel_current);

// Assign values to the parameters
$family_type = 'Boeing';
$general_condition = 'Превосходное';
$fuel_type = 'Керосин';
$fuel_max = 181280;
$fuel_current = 0;

// Execute statement
$stmt->execute();
}
if ($plane == 'Boeing 747'){
    // Prepare SQL statement
    $stmt = $db->prepare("INSERT INTO airplanes (name, family_type, general_condition, fuel_type, fuel_max, fuel_current) VALUES (:name, :family_type, :general_condition, :fuel_type, :fuel_max, :fuel_current)");
$stmt->bindParam(':name', $plane);
$stmt->bindParam(':family_type', $family_type);
$stmt->bindParam(':general_condition', $general_condition);
$stmt->bindParam(':fuel_type', $fuel_type);
$stmt->bindParam(':fuel_max', $fuel_max);
$stmt->bindParam(':fuel_current', $fuel_current);

// Assign values to the parameters
$family_type = 'Boeing';
$general_condition = 'Превосходное';
$fuel_type = 'Керосин';
$fuel_max = 210423;
$fuel_current = 0;

// Execute statement
$stmt->execute();
}
if ($plane == 'Cessna 402'){
    // Prepare SQL statement
    $stmt = $db->prepare("INSERT INTO airplanes (name, family_type, general_condition, fuel_type, fuel_max, fuel_current) VALUES (:name, :family_type, :general_condition, :fuel_type, :fuel_max, :fuel_current)");
$stmt->bindParam(':name', $plane);
$stmt->bindParam(':family_type', $family_type);
$stmt->bindParam(':general_condition', $general_condition);
$stmt->bindParam(':fuel_type', $fuel_type);
$stmt->bindParam(':fuel_max', $fuel_max);
$stmt->bindParam(':fuel_current', $fuel_current);

// Assign values to the parameters
$family_type = 'Cessna';
$general_condition = 'Превосходное';
$fuel_type = 'Бензин';
$fuel_max = 1090;
$fuel_current = 0;

// Execute statement
$stmt->execute();
}
if ($plane == 'Airbus A330'){
    // Prepare SQL statement
    $stmt = $db->prepare("INSERT INTO airplanes (name, family_type, general_condition, fuel_type, fuel_max, fuel_current) VALUES (:name, :family_type, :general_condition, :fuel_type, :fuel_max, :fuel_current)");
$stmt->bindParam(':name', $plane);
$stmt->bindParam(':family_type', $family_type);
$stmt->bindParam(':general_condition', $general_condition);
$stmt->bindParam(':fuel_type', $fuel_type);
$stmt->bindParam(':fuel_max', $fuel_max);
$stmt->bindParam(':fuel_current', $fuel_current);

// Assign values to the parameters
$family_type = 'Airbus';
$general_condition = 'Превосходное';
$fuel_type = 'Керосин';
$fuel_max = 157000;
$fuel_current = 0;

// Execute statement
$stmt->execute();
}
if ($plane == 'Airbus A320'){
    // Prepare SQL statement
    $stmt = $db->prepare("INSERT INTO airplanes (name, family_type, general_condition, fuel_type, fuel_max, fuel_current) VALUES (:name, :family_type, :general_condition, :fuel_type, :fuel_max, :fuel_current)");
$stmt->bindParam(':name', $plane);
$stmt->bindParam(':family_type', $family_type);
$stmt->bindParam(':general_condition', $general_condition);
$stmt->bindParam(':fuel_type', $fuel_type);
$stmt->bindParam(':fuel_max', $fuel_max);
$stmt->bindParam(':fuel_current', $fuel_current);

// Assign values to the parameters
$family_type = 'Airbus';
$general_condition = 'Превосходное';
$fuel_type = 'Керосин';
$fuel_max = 30030;
$fuel_current = 0;

// Execute statement
$stmt->execute();
}
if ($plane == 'ATR 42'){
    // Prepare SQL statement
    $stmt = $db->prepare("INSERT INTO airplanes (name, family_type, general_condition, fuel_type, fuel_max, fuel_current) VALUES (:name, :family_type, :general_condition, :fuel_type, :fuel_max, :fuel_current)");
$stmt->bindParam(':name', $plane);
$stmt->bindParam(':family_type', $family_type);
$stmt->bindParam(':general_condition', $general_condition);
$stmt->bindParam(':fuel_type', $fuel_type);
$stmt->bindParam(':fuel_max', $fuel_max);
$stmt->bindParam(':fuel_current', $fuel_current);

// Assign values to the parameters
$family_type = 'ATR';
$general_condition = 'Превосходное';
$fuel_type = 'Керосин';
$fuel_max = 8850;
$fuel_current = 0;

// Execute statement
$stmt->execute();
}
if ($plane == 'ATR 72'){
    // Prepare SQL statement
    $stmt = $db->prepare("INSERT INTO airplanes (name, family_type, general_condition, fuel_type, fuel_max, fuel_current) VALUES (:name, :family_type, :general_condition, :fuel_type, :fuel_max, :fuel_current)");
$stmt->bindParam(':name', $plane);
$stmt->bindParam(':family_type', $family_type);
$stmt->bindParam(':general_condition', $general_condition);
$stmt->bindParam(':fuel_type', $fuel_type);
$stmt->bindParam(':fuel_max', $fuel_max);
$stmt->bindParam(':fuel_current', $fuel_current);

// Assign values to the parameters
$family_type = 'ATR';
$general_condition = 'Превосходное';
$fuel_type = 'Керосин';
$fuel_max = 10280;
$fuel_current = 0;

// Execute statement
$stmt->execute();
}
if ($plane == 'Beechcraft King Air'){
    // Prepare SQL statement
    $stmt = $db->prepare("INSERT INTO airplanes (name, family_type, general_condition, fuel_type, fuel_max, fuel_current) VALUES (:name, :family_type, :general_condition, :fuel_type, :fuel_max, :fuel_current)");
$stmt->bindParam(':name', $plane);
$stmt->bindParam(':family_type', $family_type);
$stmt->bindParam(':general_condition', $general_condition);
$stmt->bindParam(':fuel_type', $fuel_type);
$stmt->bindParam(':fuel_max', $fuel_max);
$stmt->bindParam(':fuel_current', $fuel_current);

// Assign values to the parameters
$family_type = 'Beechcraft';
$general_condition = 'Превосходное';
$fuel_type = 'Керосин';
$fuel_max = 3039;
$fuel_current = 0;

// Execute statement
$stmt->execute();
}
if ($plane == 'Beechcraft Baron'){
    // Prepare SQL statement
    $stmt = $db->prepare("INSERT INTO airplanes (name, family_type, general_condition, fuel_type, fuel_max, fuel_current) VALUES (:name, :family_type, :general_condition, :fuel_type, :fuel_max, :fuel_current)");
$stmt->bindParam(':name', $plane);
$stmt->bindParam(':family_type', $family_type);
$stmt->bindParam(':general_condition', $general_condition);
$stmt->bindParam(':fuel_type', $fuel_type);
$stmt->bindParam(':fuel_max', $fuel_max);
$stmt->bindParam(':fuel_current', $fuel_current);

// Assign values to the parameters
$family_type = 'Beechcraft';
$general_condition = 'Превосходное';
$fuel_type = 'Бензин';
$fuel_max = 560;
$fuel_current = 0;

// Execute statement
$stmt->execute();
}
if ($plane == 'Bombardier CRJ700'){
    // Prepare SQL statement
    $stmt = $db->prepare("INSERT INTO airplanes (name, family_type, general_condition, fuel_type, fuel_max, fuel_current) VALUES (:name, :family_type, :general_condition, :fuel_type, :fuel_max, :fuel_current)");
$stmt->bindParam(':name', $plane);
$stmt->bindParam(':family_type', $family_type);
$stmt->bindParam(':general_condition', $general_condition);
$stmt->bindParam(':fuel_type', $fuel_type);
$stmt->bindParam(':fuel_max', $fuel_max);
$stmt->bindParam(':fuel_current', $fuel_current);

// Assign values to the parameters
$family_type = 'Bombardier';
$general_condition = 'Превосходное';
$fuel_type = 'Керосин';
$fuel_max = 14400;
$fuel_current = 0;

// Execute statement
$stmt->execute();
}
if ($plane == 'Bombardier Q400'){
    // Prepare SQL statement
    $stmt = $db->prepare("INSERT INTO airplanes (name, family_type, general_condition, fuel_type, fuel_max, fuel_current) VALUES (:name, :family_type, :general_condition, :fuel_type, :fuel_max, :fuel_current)");
$stmt->bindParam(':name', $plane);
$stmt->bindParam(':family_type', $family_type);
$stmt->bindParam(':general_condition', $general_condition);
$stmt->bindParam(':fuel_type', $fuel_type);
$stmt->bindParam(':fuel_max', $fuel_max);
$stmt->bindParam(':fuel_current', $fuel_current);

// Assign values to the parameters
$family_type = 'Bombardier';
$general_condition = 'Превосходное';
$fuel_type = 'Керосин';
$fuel_max =  11360;
$fuel_current = 0;

// Execute statement
$stmt->execute();
}
if ($plane == 'Embraer ERJ'){
    // Prepare SQL statement
    $stmt = $db->prepare("INSERT INTO airplanes (name, family_type, general_condition, fuel_type, fuel_max, fuel_current) VALUES (:name, :family_type, :general_condition, :fuel_type, :fuel_max, :fuel_current)");
$stmt->bindParam(':name', $plane);
$stmt->bindParam(':family_type', $family_type);
$stmt->bindParam(':general_condition', $general_condition);
$stmt->bindParam(':fuel_type', $fuel_type);
$stmt->bindParam(':fuel_max', $fuel_max);
$stmt->bindParam(':fuel_current', $fuel_current);

// Assign values to the parameters
$family_type = 'Embraer';
$general_condition = 'Превосходное';
$fuel_type = 'Керосин';
$fuel_max =  10580;
$fuel_current = 0;

// Execute statement
$stmt->execute();
}
echo '<script type="text/javascript"> alert("Самолёт успешно добавлен.");</script>';
echo '<script type="text/javascript">window.location.href = "./planes.php" </script>';
} catch (PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}
?>
