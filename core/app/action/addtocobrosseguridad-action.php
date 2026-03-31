<?php


if(!isset($_SESSION["cobro_seguridad"])){


	$data = array(
		"date_at"=>$_POST['date_at'],
		"client_id"=>$_POST['client_id'],
		"cat_seguridad_id"=>$_POST['cat_seguridad_id'],
		"servicio_seguridad_id"=>$_POST['servicio_seguridad_id'],
		"amount"=>$_POST['amount'],
		"descuento"=>$_POST['descuento'],
		"iva"=>$_POST['iva'],
		"description"=>$_POST['description'],
		"forma_pago_id"=>$_POST['forma_pago_id'],
	);
	$alldata[]=$data;

	$_SESSION['cobro_seguridad']=$alldata;
}
else {

	$alldata = $_SESSION['cobro_seguridad'];

	$data = array(
		"date_at"=>$_POST['date_at'],
		"client_id"=>$_POST['client_id'],
		"cat_seguridad_id"=>$_POST['cat_seguridad_id'],
		"servicio_seguridad_id"=>$_POST['servicio_seguridad_id'],
		"amount"=>$_POST['amount'],
		"descuento"=>$_POST['descuento'],
		"iva"=>$_POST['iva'],
		"description"=>$_POST['description'],
		"forma_pago_id"=>$_POST['forma_pago_id'],
	);

	$alldata[]=$data;

	$_SESSION['cobro_seguridad']=$alldata;
}



?>