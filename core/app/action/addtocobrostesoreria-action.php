<?php


if(!isset($_SESSION["cobro_tesoreria"])){


	$data = array(
		"date_at"=>$_POST['date_at'],
		"client_id"=>$_POST['client_id'],
		"cat_tesoreria_id"=>$_POST['cat_tesoreria_id'],
		"servicio_tesoreria_id"=>$_POST['servicio_tesoreria_id'],
		"amount"=>$_POST['amount'],
		"descuento"=>$_POST['descuento'],
		"iva"=>$_POST['iva'],
		"periodo_id"=>$_POST['periodo_id'],
		"description"=>$_POST['description'],
		"forma_pago_id"=>$_POST['forma_pago_id'],
	);
	$alldata[]=$data;

	$_SESSION['cobro_tesoreria']=$alldata;
}
else {

	$alldata = $_SESSION['cobro_tesoreria'];

	$data = array(
		"date_at"=>$_POST['date_at'],
		"client_id"=>$_POST['client_id'],
		"cat_tesoreria_id"=>$_POST['cat_tesoreria_id'],
		"servicio_tesoreria_id"=>$_POST['servicio_tesoreria_id'],
		"amount"=>$_POST['amount'],
		"descuento"=>$_POST['descuento'],
		"iva"=>$_POST['iva'],
		"periodo_id"=>$_POST['periodo_id'],
		"description"=>$_POST['description'],
		"forma_pago_id"=>$_POST['forma_pago_id'],
	);

	$alldata[]=$data;

	$_SESSION['cobro_tesoreria']=$alldata;
}



?>