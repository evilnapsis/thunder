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

$pdf = new FPDF($orientation='P',$unit='mm', array(80,200));
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);    
$pdf->Cell(60,10,'THUNDER',0,1,'C');
$pdf->SetFont('Arial','',10);    
$pdf->Cell(60,5,'Comprobante de Venta',0,1,'C');
$pdf->Ln(3);
$pdf->Cell(60,5,'Ticket: #'.$sell->id,0,1,'L');
$pdf->Cell(60,5,'Fecha: '.$sell->created_at,0,1,'L');
$pdf->Cell(60,5,'Mesa: '.$mesa->name,0,1,'L');
$pdf->Cell(60,5,'Mesero: '.$mesero->name." ".$mesero->lastname,0,1,'L');
$pdf->Ln(3);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,5,'Cant',0,0,'L');
$pdf->Cell(30,5,'Producto',0,0,'L');
$pdf->Cell(20,5,'Total',0,1,'R');
$pdf->Line(10, $pdf->GetY(), 70, $pdf->GetY());
$pdf->SetFont('Arial','',10);

$total = 0;
foreach($operations as $op){
    $product = $op->getProduct();
    $subtotal = $op->q * $product->price_out;
    $total += $subtotal;
    $pdf->Cell(10,5,$op->q,0,0,'L');
    $pdf->Cell(30,5,substr($product->name,0,15),0,0,'L');
    $pdf->Cell(20,5,"$".number_format($subtotal,2),0,1,'R');
}

$pdf->Ln(3);
$pdf->Line(10, $pdf->GetY(), 70, $pdf->GetY());
$pdf->SetFont('Arial','B',12);
$pdf->Cell(40,10,'TOTAL:',0,0,'L');
$pdf->Cell(20,10,"$".number_format($total,2),0,1,'R');

$pdf->Ln(5);
$pdf->SetFont('Arial','I',8);
$pdf->MultiCell(60,5,'Gracias por su consumo. Este ticket no es un comprobante fiscal.',0,'C');

$pdf->Output();
}
?>
