<?php
include "core/autoload.php";
include "core/app/model/UserData.php";
include "core/app/model/SellData.php";
include "core/app/model/OperationData.php";
include "core/app/model/OperationTypeData.php";
include "core/app/model/ProductData.php";
include "core/app/model/ItemData.php";
include "fpdf/fpdf.php";

session_start();
if(!isset($_SESSION["user_id"])) { die("Acceso denegado"); }

if(isset($_GET["id"])){
$sell = SellData::getById($_GET["id"]);
$operations = OperationData::getAllProductsBySellId($_GET["id"]);
$mesero = UserData::getById($sell->mesero_id);
$mesa = ItemData::getById($sell->item_id);

$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','B',20);    
$pdf->Cell(190,10,'THUNDER RESTAURANTE',0,1,'C');
$pdf->SetFont('Arial','',12);    
$pdf->Cell(190,7,'Comprobante de Venta (Formato A4)',0,1,'C');
$pdf->Ln(10);

// Información de la venta en dos columnas
$pdf->SetFont('Arial','B',12);
$pdf->Cell(95,7,'Datos de la Venta',0,0,'L');
$pdf->Cell(95,7,'Detalles de Servicio',0,1,'L');

$pdf->SetFont('Arial','',11);
$pdf->Cell(30,6,'Ticket #: ',0,0,'L');
$pdf->Cell(65,6,$sell->id,0,0,'L');
$pdf->Cell(30,6,'Mesa: ',0,0,'L');
$pdf->Cell(65,6,$mesa->name,0,1,'L');

$pdf->Cell(30,6,'Fecha: ',0,0,'L');
$pdf->Cell(65,6,$sell->created_at,0,0,'L');
$pdf->Cell(30,6,'Mesero: ',0,0,'L');
$pdf->Cell(65,6,$mesero->name." ".$mesero->lastname,0,1,'L');

$pdf->Ln(10);

// Tabla de productos
$pdf->SetFillColor(232,232,232);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,8,'Cant',1,0,'C',true);
$pdf->Cell(110,8,'Descripcion del Producto',1,0,'C',true);
$pdf->Cell(30,8,'Precio Unit.',1,0,'C',true);
$pdf->Cell(30,8,'Subtotal',1,1,'C',true);

$pdf->SetFont('Arial','',11);
$total = 0;
foreach($operations as $op){
    $product = $op->getProduct();
    $subtotal = $op->q * $product->price_out;
    $total += $subtotal;
    
    $pdf->Cell(20,7,$op->q,1,0,'C');
    $pdf->Cell(110,7,$product->name,1,0,'L');
    $pdf->Cell(30,7,"$".number_format($product->price_out,2),1,0,'R');
    $pdf->Cell(30,7,"$".number_format($subtotal,2),1,1,'R');
}

$pdf->Ln(5);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(130,10,'',0,0);
$pdf->Cell(30,10,'TOTAL:',0,0,'R');
$pdf->Cell(30,10,"$".number_format($total,2),0,1,'R');

$pdf->Ln(20);
$pdf->SetFont('Arial','I',10);
$pdf->MultiCell(190,5,'Este documento es un comprobante de consumo interno realizado en THUNDER RESTAURANTE. No tiene validez como comprobante fiscal (Factura electrónica).',0,'C');

$pdf->Output();
}
?>
