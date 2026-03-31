<?php if(isset($_GET['opt']) && $_GET['opt']=="add"){
//print_r($_POST);
$cobros = $_SESSION["cobro_seguridad"];
$tipo="seguridad";
$last = CorteSeguridadData::getLastByUser(Core::$user->id);
if($last==null){
    $tipo = "tesoreria";
    $last = CorteTesoreriaData::getLastByUser(Core::$user->id);
}


if($last){
	$client = new CobroSeguridadListData();
	$client->code = "";// $_POST['code'];


	$client->cat_seguridad_id = $cobros[0]['cat_seguridad_id'];
	$client->forma_pago_id = $cobros[0]['forma_pago_id'];
	$client->client_id = $cobros[0]['client_id'];
if($tipo=="seguridad"){
	$client->corte_id = $last->id; 
	$client->corte_teso_id = "NULL"; 

}
else if($tipo=="tesoreria"){
	$client->corte_teso_id = $last->id; 
	$client->corte_id = "NULL"; 

}

	$coa=$client->add();
	/*
	$client = new CobroSeguridadData();
	$client->code = "";// $_POST['code'];
	$client->date_at = $_POST['date_at'];

	$client->contrato_agua = $_POST['contrato_agua'];
	$client->contrato_agua_id = $_POST['contrato_agua_id'];
	$client->amount = $_POST['amount'];
	$client->descuento = $_POST['descuento'];
	$client->iva = $_POST['iva'];

	$client->periodo_id = $_POST['periodo_id'];
	$client->servicio_seguridad_id = $_POST['servicio_seguridad_id'];
	$client->tipo_contrato = $_POST['tipo_contrato'];
	$client->client_id = $_POST['client_id'];
	$client->description = $_POST['description'];
	$client->cobro_seguridad_list_id = $coa[1];
	$client->add();
	*/

	foreach($cobros as $cob){
	$client = new CobroSeguridadData();
	$client->code = "";// $_POST['code'];
	$client->date_at = $cob['date_at'];
	$client->amount = $cob['amount'];
	$client->descuento = $cob['descuento'];
	$client->iva = $cob['iva'];

	$client->servicio_seguridad_id = $cob['servicio_seguridad_id'];
	$client->client_id = $cob['client_id'];
	$client->description = $cob['description'];
	$client->forma_pago_id = $cob['forma_pago_id'];
	$client->cobro_seguridad_list_id = $coa[1];

if($tipo=="seguridad"){
	$client->corte_id = $last->id; 
	$client->corte_teso_id = "NULL"; 

}
else if($tipo=="tesoreria"){
	$client->corte_teso_id = $last->id; 
	$client->corte_id = "NULL"; 

}

	$client->add();
	}
	//Core::alert("Cobro Agregado!");
	unset($_SESSION['cobro_seguridad']);
	$_SESSION['cobro_realizado']=1;
//	Core::redir("./?view=cobrosseguridad&opt=all");
	Core::redir("./?view=cobrosseguridad&opt=showticket&id=".$coa[1]);
}else{
	$_SESSION['error_caja']=1;
	Core::redir("./?view=cobrosseguridad&opt=all");

}
}
if(isset($_GET['opt']) && $_GET['opt']=="update"){

	$client = CobroSeguridadData::getById($_POST["id"]);
	$client->code = $_POST['code'];
	$client->date_at = $_POST['date_at'];
	$client->tipo_contrato = $_POST['tipo_contrato'];
	$client->client_id = $_POST['client_id'];
	$client->description = $_POST['description'];

	$client->update();
	Core::redir("./?view=cobrosseguridad&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="del"){


	$client = CobroSeguridadListData::getById($_GET["id"]);

	$listy = CobroSeguridadData::getAllBy("cobro_seguridad_list_id",$client->id);
	foreach($listy as $li){
		$li->del();
	}


	$client->del();
	Core::redir("./?view=cobrosseguridad&opt=all");

}
?>