<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "pdo.php";
require_once "lib/tfpdf/tfpdf.php";

// Подключение к базе данных
$host = 'aws-0-eu-central-1.pooler.supabase.com';
$dbname = 'postgres';
$user = 'postgres.dstcxgfoqwifnystedpz';
$password = '6412diploM!';
$port = 5432;
$condition =$_POST['con_filter'];
$plane_filter =$_POST['plane_filter'];
$family_filter =$_POST['family_filter'];

try {
    $db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;options='--client_encoding=UTF8'", $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Получаем параметры фильтрации из URL

    // Формируем SQL запрос с учетом фильтров
    $condition = isset($_POST['con_filter']) ? $_POST['con_filter'] : '';
    $plane_filter = isset($_POST['plane_filter']) ? $_POST['plane_filter'] : '';
    $family_filter = isset($_POST['family_filter']) ? $_POST['family_filter'] : '';
    
    // Формируем SQL запрос с учетом всех фильтров
    $sql = "SELECT id, name, family_type, general_condition, fuel_type, fuel_max, fuel_current FROM airplanes WHERE 1 = 1";
    
    $params = []; // Массив для хранения параметров для передачи в execute
    
    // Добавляем условия фильтрации в SQL запрос, если фильтры были указаны
    if (!empty($condition)) {
        $sql .= " AND general_condition = ?";
        $params[] = $condition; // Добавляем значение в массив параметров
    }
    
    if (!empty($plane_filter)) {
        $sql .= " AND name = ?";
        $params[] = $plane_filter; // Добавляем значение в массив параметров
    }
    
    if (!empty($family_filter)) {
        $sql .= " AND family_type = ?";
        $params[] = $family_filter; // Добавляем значение в массив параметров
    }
    
    // Подготавливаем запрос
    $stmt = $db->prepare($sql);
    
    // Выполняем запрос с передачей параметров
    $stmt->execute($params);
    // Получаем данные из базы данных
    $plinf = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Создаем новый PDF
    $pdf = new tFPDF('L', 'mm', 'A3');
    $pdf->AddPage();
    
    $pdf->AddFont('DejaVuSans', '', 'DejaVuSans.ttf', true);
    $pdf->SetFont('DejaVuSans', '', 16);
    // Создаем таблицу
    $width = 30; // Установите нужную ширину изображения
    $height = 30; // Установите нужную высоту изображения
    $pdf->SetTitle('Список самолётов');
    $pdf->Write(15, 'Список самолётов, числящихся в авиапарке, согласно выбранным параметрам');
    $imagePath = 'pics/jTx69nkrc.png'; // Укажите путь к вашему изображению
    $pdf->Image($imagePath, 340, 20, $width, $height);
    $pdf->Ln(15);
    $header = array('№ самолёта', 'Название', 'Семейство', 'Общее состояние', 'Тип топлива', 'Объем топливных баков', 'Заполненность баков');
    $pdf->SetFont('DejaVuSans', '', 12);
    $pdf->Cell(30, 10, '№ самолёта', 1);
    $pdf->Cell(40, 10, 'Название', 1);
    $pdf->Cell(40, 10, 'Семейство', 1);
    $pdf->Cell(45, 10, 'Общее состояние', 1);
    $pdf->Cell(30, 10, 'Тип топлива', 1);
    $pdf->Cell(60, 10, 'Объем топливных баков', 1);
    $pdf->Cell(60, 10, 'Заполненность баков', 1);
    $pdf->Ln();
    $pdf->SetFont('DejaVuSans', '', 10);
    // Добавляем данные из базы данных в таблицу
    foreach ($plinf as $plane) {
        $proc = ($plane['fuel_current'] / $plane['fuel_max']) * 100;

        $pdf->Cell(30, 10, $plane['id'], 1);
        $pdf->Cell(40, 10, $plane['name'], 1);
        $pdf->Cell(40, 10, $plane['family_type'], 1);
        $pdf->Cell(45, 10, $plane['general_condition'], 1);
        $pdf->Cell(30, 10, $plane['fuel_type'], 1);
        $pdf->Cell(60, 10, $plane['fuel_max'] . ' л.', 1);
        $pdf->Cell(60, 10, $proc . '%', 1);
        $pdf->Ln();
    }
    $pdf->SetFont('DejaVuSans', '', 10);
    $today = new DateTime();
    $today = $today->format('Y-m-d H:i');
    $content2 ="


На момент: $today ознакомлен.

Подпись: _________________________ .  

Директор  по управлению авиапарком: ____________________________________  (ФИО). 


";

// Добавление содержимого в PDF документ
$pdf->MultiCell(0, 5, $content2);
    // Выводим PDF в браузер или сохраняем его в файл
    $pdf->Output('report1.pdf', 'I');
} catch (PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}
?>
