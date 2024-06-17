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
$password = '###';
$port = 5432;

try {
    $db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;options='--client_encoding=UTF8'", $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Получение фильтров из формы
  // Получение фильтров из формы
  $filterId = isset($_POST['id_filter']) ? $_POST['id_filter'] : '';
  $filterName = isset($_POST['name_filter']) ? $_POST['name_filter'] : '';
  $filterStartDate = isset($_POST['start_date_filter']) ? $_POST['start_date_filter'] : '';
  $filterEndDate = isset($_POST['end_date_filter']) ? $_POST['end_date_filter'] : '';
  $filterPlaneId = isset($_POST['plane_id_filter']) ? $_POST['plane_id_filter'] : '';
  $filterPlane = isset($_POST['plane_filter']) ? $_POST['plane_filter'] : '';
  $filterWorkers = isset($_POST['workers_filter']) ? $_POST['workers_filter'] : '';
  $filterStatus = isset($_POST['status_filter']) ? $_POST['status_filter'] : '';
  $filterPartId = isset($_POST['part_id']) ? $_POST['part_id'] : '';
  $filterPartName = isset($_POST['part_name']) ? $_POST['part_name'] : '';
  $filterPartType = isset($_POST['part_type']) ? $_POST['part_type'] : '';
 
// Построение SQL-запроса с учетом фильтров

$sql = "SELECT * FROM (
    SELECT w.id AS work_id, w.name AS work_name, w.part_id, p.name AS part_name, p.type AS part_type, a.name AS plane_name, w.start_date, w.finish_date, w.plane_id,
        string_agg(wr.second_name || ' ' || wr.name || ' ' || wr.third_name, ', ') AS workers,
        BOOL_OR(g.status) AS status
        FROM works w
        LEFT JOIN aircraft_parts p ON w.part_id = p.id
        JOIN airplanes a ON w.plane_id = a.id
        JOIN guide g ON w.id = g.work_id
        JOIN workers wr ON g.worker_id = wr.id
        WHERE 1=1";

if ($filterId) {
    $sql .= " AND w.id = :filterId";
}

if ($filterName) {
    $sql .= " AND w.name LIKE :filterName";
}

if ($filterStartDate) {
    $sql .= " AND w.start_date >= :filterStartDate";
}

if ($filterEndDate) {
    $sql .= " AND w.finish_date <= :filterEndDate";
}

if ($filterPlaneId) {
    $sql .= " AND w.plane_id = :filterPlaneId";
}

if ($filterPlane) {
    $sql .= " AND a.name LIKE :filterPlane";
}

if ($filterWorkers) {
    $sql .= " AND EXISTS (
        SELECT 1
        FROM guide g
        JOIN workers wr ON g.worker_id = wr.id
        WHERE g.work_id = w.id
        AND (wr.second_name || ' ' || wr.name || ' ' || wr.third_name) LIKE :filterWorkers
    )";
}

if ($filterStatus !== '') {
    if ($filterStatus === 'true') {
        $sql .= " AND status = TRUE";    
    } elseif ($filterStatus === 'false') {
        $sql .= " AND status = FALSE";    
    } elseif ($filterStatus === 'null') {
        $sql .= " AND status IS NULL";    
    }
}


    


if ($filterPartId) {
    $sql .= " AND w.part_id = :filterPartId";
}

if ($filterPartName) {
    $sql .= " AND p.name LIKE :filterPartName";
}

if ($filterPartType) {
    $sql .= " AND p.type LIKE :filterPartType";
}

$sql .= " GROUP BY w.id, p.name, p.type, a.name) subquery";

$stmt = $db->prepare($sql);

if ($filterId) {
    $stmt->bindValue(':filterId', $filterId, PDO::PARAM_INT);
}

if ($filterName) {
    $stmt->bindValue(':filterName', '%' . $filterName . '%', PDO::PARAM_STR);
}

if ($filterStartDate) {
    $stmt->bindValue(':filterStartDate', $filterStartDate, PDO::PARAM_STR);
}

if ($filterEndDate) {
    $stmt->bindValue(':filterEndDate', $filterEndDate, PDO::PARAM_STR);
}

if ($filterPlaneId) {
    $stmt->bindValue(':filterPlaneId', $filterPlaneId, PDO::PARAM_INT);
}

if ($filterPlane) {
    $stmt->bindValue(':filterPlane', '%' . $filterPlane . '%', PDO::PARAM_STR);
}

if ($filterWorkers) {
    $stmt->bindValue(':filterWorkers', '%' . $filterWorkers . '%', PDO::PARAM_STR);
}



if ($filterStatus === true|| $filterStatus===false){
    $stmt->bindValue(':filterStatus', $filterStatus, PDO::PARAM_BOOL);
}elseif($filterStatus === null) {
    $stmt->bindValue(':filterStatus', null, PDO::PARAM_NULL);
}

if ($filterPartId) {
    $stmt->bindValue(':filterPartId', $filterPartId, PDO::PARAM_INT);
}

if ($filterPartName) {
    $stmt->bindValue(':filterPartName', '%' . $filterPartName . '%', PDO::PARAM_STR);
}

if ($filterPartType) {
    $stmt->bindValue(':filterPartType', '%' . $filterPartType . '%', PDO::PARAM_STR);
}

$stmt->execute();
$wk = $stmt->fetchAll();


    // Создание PDF-документа
    $pdf = new tFPDF('L', 'mm', 'A2');
    $pdf->AddPage();
    
    $pdf->AddFont('DejaVuSans', '', 'DejaVuSans.ttf', true);
    
    
    $pdf->SetFont('DejaVuSans', '', 16); // Устанавливаем жирный шрифт
    
    // Заголовок таблицы
    $width = 30; // Установите нужную ширину изображения
    $height = 30; // Установите нужную высоту изображения
    $pdf->SetTitle('Статистика по работам');
    $pdf->Write(15, 'Статистика по работам, согласно выбранным параметрам');
    $imagePath = 'pics/jTx69nkrc.png'; // Укажите путь к вашему изображению
    $pdf->Image($imagePath, 500, 20, $width, $height);
    $pdf->Ln(15);
    $pdf->SetFont('DejaVuSans', '', 10);
    $header = array('№ работы', 'Название', 'Дата начала работы', 'Дата окончания работы', '№ самолёта', 'Название самолёта', 'Выполняли', 'Статус работы', '№ детали', 'Название детали', 'Тип детали');
    $width = array(25, 40, 40, 50, 25, 40, 80, 35, 25, 80, 30);
    
    for ($i = 0; $i < count($header); $i++) {
        $pdf->Cell($width[$i], 10, $header[$i], 1, 0, 'C');
    }
    $pdf->Ln();
    
    // Строки таблицы
    $pdf->SetFont('DejaVuSans', '', 16);
    if (empty($wk)) {
        $pdf->Write(15, 'Данные о работах, согласно выбранным параметрам, отсутствуют');
    } else {
    foreach ($wk as $row) {
        $pdf->SetFont('DejaVuSans', '', 8);
        $max_height = 10;
    
        $workers = explode(', ', $row['workers']);
        $worker_count = count($workers);
        $worker_height = $worker_count * 5;
        if ($worker_height > $max_height) {
            $max_height = $worker_height;
        }
    
        // Умножаем $max_height на $worker_count
        $max_height *= $worker_count;
    
        $pdf->Cell(25, $max_height, $row['work_id'], 1, 0, 'C', false);
        $pdf->Cell(40, $max_height, $row['work_name'], 1, 0, 'C', false);
        $pdf->Cell(40, $max_height, $row['start_date'], 1, 0, 'C', false);
        $pdf->Cell(50, $max_height, $row['finish_date'], 1, 0, 'C', false);
        $pdf->Cell(25, $max_height, $row['plane_id'], 1, 0, 'C', false);
    
        // Сохраняем текущую позицию X для ячейки с работниками и последующих ячеек
        $x_position = $pdf->GetX();
    
        $pdf->Cell(40, $max_height, $row['plane_name'], 1, 0, 'C', false);
    
        // Выводим работников в одной ячейке с переносом строк
        $worker_cell_height = $max_height / $worker_count;
        $worker_text = '';
        
        foreach ($workers as $worker) {
            $worker_text .= $worker . "\n";
        }
        $pdf->SetXY($x_position + 40, $pdf->GetY()); // Сдвигаем ячейку с работниками вправо, чтобы она не накладывалась на plane_name
        $pdf->MultiCell(80, $worker_cell_height, $worker_text, 1, 'C', false);
    
        // Сохраняем текущую позицию Y для следующих ячеек
        $y_position = $pdf->GetY();
        $pdf->SetY($y_position - $max_height);
        $pdf->SetXY($x_position + 120, $pdf->GetY());
    
        // Выводим остальные ячейки
        if ($row['status'] === null) {
            $pdf->Cell(35, $max_height, 'В процессе', 1, 0, 'C', false);
        } elseif ($row['status'] === true) {
            $pdf->Cell(35, $max_height, 'Успешно завершена', 1, 0, 'C', false);
        } elseif ($row['status'] === false) {
            $pdf->Cell(35, $max_height, 'Не выполнена', 1, 0, 'C', false);
        }
        if ($row['part_id'] === null) {
            $pdf->Cell(25, $max_height, 'Нет', 1, 0, 'C', false);
            $pdf->Cell(80, $max_height, 'Нет', 1, 0, 'C', false);
            $pdf->Cell(30, $max_height, 'Нет', 1, 1, 'C', false);
        } else {
            $pdf->Cell(25, $max_height, $row['part_id'], 1, 0, 'C', false);
            $guideptid=$row['part_id'];
            if(empty($row['part_name'])&&empty($row['part_type'])){
                $sql45 = "SELECT part_name, part_type FROM guide WHERE part_id =  $guideptid";
                $stmt = $db->query($sql45);
                $guide = $stmt->fetch();
                $pdf->Cell(80, $max_height, $guide['part_name'], 1, 0, 'C', false);
                $pdf->Cell(30, $max_height, $guide['part_type'], 1, 1, 'C', false);
            }
            else{
            $pdf->Cell(80, $max_height, $row['part_name'], 1, 0, 'C', false);
            $pdf->Cell(30, $max_height, $row['part_type'], 1, 1, 'C', false);
        }
    }
    }
    $pdf->SetFont('DejaVuSans', '', 10);
    $today = new DateTime();
    $today = $today->format('Y-m-d H:i');
    $content2 ="


На момент: $today ознакомлен.

Подпись: _________________________ .  

Директор по техническому обслуживанию: ____________________________________  (ФИО). 


";

// Добавление содержимого в PDF документ
$pdf->MultiCell(0, 5, $content2);
}
    
    // Вывод PDF-документа
    $pdf->Output('report.pdf', 'I');
// Получаем активный лист

} catch (PDOException $e) {
    echo "Ошибка подключения: " . $e->getMessage();
}
