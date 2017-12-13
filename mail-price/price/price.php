<?php
/**
 * Created by PhpStorm.
 * User: Natalia
 * Date: 10.12.2017
 * Time: 15:27
 */
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'itruck';

$link = mysqli_connect($db_host, $db_user, $db_password, $db_name);
if (!$link) {
    die('<p style="color:red">'.mysqli_connect_errno().' - '.mysqli_connect_error().'</p>');
}

echo "<p>Мы подключились к базе данных!</p>";

$result_set = $link->query('SELECT * FROM products;');

$to_price = array();
while ($row = $result_set->fetch_assoc()) {
    array_push($to_price, $row);
}
$result_set->close();
$link->close();

print_r($to_price);

require_once 'Classes' . DIRECTORY_SEPARATOR . 'PHPExcel.php';

//Первый лист
$obj = new PHPExcel();
$obj->setActiveSheetIndex(0);
$obj->createSheet();
$active_sheet = $obj->getActiveSheet();
$active_sheet->setTitle("Общий прайс");
$obj->getDefaultStyle()->getFont()->setName('Times New Roman');
$obj->getDefaultStyle()->getFont()->setSize(8);
$active_sheet->getColumnDimension('A')->setWidth(12);
$active_sheet->getColumnDimension('B')->setWidth(28);
$active_sheet->getColumnDimension('C')->setWidth(30);
$active_sheet->getColumnDimension('D')->setWidth(60);
$active_sheet->getColumnDimension('E')->setWidth(20);
$active_sheet->getColumnDimension('F')->setWidth(27);
$active_sheet->getColumnDimension('G')->setWidth(15);
$active_sheet->getColumnDimension('H')->setWidth(15);
$active_sheet->getColumnDimension('I')->setWidth(15);
$active_sheet->getColumnDimension('J')->setWidth(20);
$active_sheet->getColumnDimension('K')->setWidth(20);
$active_sheet->getColumnDimension('L')->setWidth(20);
$active_sheet->getColumnDimension('M')->setWidth(18);

$iDrowing = new PHPExcel_Worksheet_Drawing();
$iDrowing->setPath('logo.png');
$iDrowing->setCoordinates('B1');
$iDrowing->setResizeProportional(false);
$iDrowing->setWidth(200);
$iDrowing->setHeight(190);
$iDrowing->setWorksheet($active_sheet);

$active_sheet->setShowGridlines(false);


$active_sheet->mergeCells('D2:E2');
$active_sheet->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$active_sheet->getRowDimension(10)->setRowHeight(50);
$active_sheet->setCellValue('D2', 'Сделать заказ можно по телефонам:');
$active_sheet->mergeCells('F2:K2');
$active_sheet->mergeCells('F3:K3');
$active_sheet->mergeCells('F4:K4');
$active_sheet->mergeCells('F5:K5');
$active_sheet->mergeCells('F6:K6');
$active_sheet->setCellValue('F2', "+380999843330    Григор Дмитрий - Центр");
$active_sheet->setCellValue('F3', '+380509819847    Зленко Феодосий - Восток');
$active_sheet->setCellValue('F4', '+380979989908    Ковальчук Сергей - Запад');
$active_sheet->setCellValue('F5', '+380507790119    Филатов Сергей - Центр. Запад');
$active_sheet->setCellValue('F6', '+380503433811    Дженждеро Евгений - Юг');
$active_sheet->mergeCells('D8:k8');
$active_sheet->setCellValue('D8', 'Правила расчета цен на ЦМК шины бренда OTANI  смотреть на листе "Правила расчета цены ЦМК OTANI"');
$active_sheet->mergeCells('D9:E9');
$active_sheet->setCellValue('D9', 'Cкидка за предоплату 2%');
$active_sheet->getRowDimension(11)->setRowHeight(40);
$active_sheet->setCellValue('A11', "Артикул");
$active_sheet->setCellValue('B11', "Тип");
$active_sheet->setCellValue('C11', "Применение/Сезон");
$active_sheet->setCellValue('D11', "Полное наименование");
$active_sheet->setCellValue('E11', "Бренд");
$active_sheet->setCellValue('F11', "Модель");
$active_sheet->setCellValue('G11', "Ширина");
$active_sheet->setCellValue('H11', "Высота");
$active_sheet->setCellValue('I11', "Диаметр");
$active_sheet->setCellValue('J11', "Индекс нагрузки");
$active_sheet->setCellValue('K11', "Индекс скорости");
$active_sheet->setCellValue('L11', "Наличие");
$active_sheet->setCellValue('M11', "Цена");

$row_start = 12;
$i = 0;
foreach ($to_price as $item) {
    $row_next = $row_start + $i;
    $active_sheet->setCellValue('A'.$row_next, $item['id']);
    $active_sheet->setCellValue('B'.$row_next, $item['category1']);
    $active_sheet->setCellValue('C'.$row_next, $item['category2']);
    $active_sheet->setCellValue('D'.$row_next, $item['name']);
    $active_sheet->setCellValue('E'.$row_next, $item['brand']);
    $active_sheet->setCellValue('F'.$row_next, $item['model']);
    $active_sheet->setCellValue('G'.$row_next, $item['height']);
    $active_sheet->setCellValue('H'.$row_next, $item['width']);
    $active_sheet->setCellValue('I'.$row_next, $item['diam']);
    $active_sheet->setCellValue('J'.$row_next, $item['ind_n']);
    $active_sheet->setCellValue('K'.$row_next, $item['ind_s']);
    $active_sheet->setCellValue('L'.$row_next, $item['nal']);
    $active_sheet->setCellValue('M'.$row_next, $item['mail-price']);
    $i++;
}

$style_wrap = array(
    'borders'=>array(
        'allborders'=>array(
            'style'=>PHPExcel_Style_Border::BORDER_THIN)));
$active_sheet->getStyle('A11:M'.($i+11))->applyFromArray($style_wrap);
$active_sheet->getStyle('M11:M'.($i+11))->getNumberFormat()->setFormatCode('#,##0');

$header_wrap = array(
    'font'  => array(
        'bold'  => true,
        'size'  => 8,
        'name'  => 'Verdana'),
);

$text_wrap = array(
    'font'  => array(
        'bold'  => true,
        'italic'  => true,
        'size'  => 9,
        'name'  => 'Verdana',
        'color' => array('rgb' => 'FF0000')),
);

$active_sheet->getStyle('A11:M11')->applyFromArray($header_wrap);
$active_sheet->getStyle('D2')->applyFromArray($header_wrap);
$active_sheet->getStyle('F2:F6')->applyFromArray($header_wrap);
$active_sheet->getStyle('D8:D9')->applyFromArray($text_wrap);
$active_sheet->getStyle('A11:M11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$active_sheet
    ->getStyle('A11:M11')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setRGB('778899');



header("Content-Type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename=mail-price.xls");

$writer = PHPExcel_IOFactory::createWriter($obj, 'Excel5');
$writer->save('php://output');

exit();