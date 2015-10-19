<?php
// removeremos
// un prospecto de venta
$sell =  SellData::getById($_GET["id"]);
$operations = OperationData::getAllProductsBySellId($sell->id);
	$rx = 0;
	foreach($operations as $operation){
		 $operation->del();
	}
	$sell->del();

header("Location: index.php?view=sells");

?>