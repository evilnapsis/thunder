<?php


if(!isset($_SESSION["cobro_list"])){


	$data = array(
		"date_at"=>$_POST['date_at'],
		"client_id"=>$_POST['client_id'],
		"tipo_servicio_id"=>$_POST['tipo_servicio_id'],
		"contrato_agua"=>$_POST['contrato_agua'],
		"contrato_agua_id"=>$_POST['contrato_agua_id'],
		"amount"=>$_POST['amount'],
		"descuento"=>$_POST['descuento'],
		"iva"=>$_POST['iva'],
		"periodo_id"=>$_POST['periodo_id'],
		"tipo_contrato"=>$_POST['tipo_contrato'],
		"description"=>$_POST['description'],
		"forma_pago_id"=>$_POST['forma_pago_id'],
	);
	$alldata[]=$data;

	$_SESSION['cobro_list']=$alldata;
}
else {

	$alldata = $_SESSION['cobro_list'];

	$data = array(
		"date_at"=>$_POST['date_at'],
		"client_id"=>$_POST['client_id'],
		"tipo_servicio_id"=>$_POST['tipo_servicio_id'],
		"contrato_agua"=>$_POST['contrato_agua'],
		"contrato_agua_id"=>$_POST['contrato_agua_id'],
		"amount"=>$_POST['amount'],
		"descuento"=>$_POST['descuento'],
		"iva"=>$_POST['iva'],
		"periodo_id"=>$_POST['periodo_id'],
		"tipo_contrato"=>$_POST['tipo_contrato'],
		"description"=>$_POST['description'],
		"forma_pago_id"=>$_POST['forma_pago_id'],
	);

	$alldata[]=$data;

	$_SESSION['cobro_list']=$alldata;
}



?>