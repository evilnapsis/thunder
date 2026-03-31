<?php if(isset($_GET['opt']) && $_GET['opt']=="add"){
//print_r($_POST);
$cobros = $_SESSION["cobro_list"];
$last = CorteAguaData::getLastByUser(Core::$user->id);
if($last){
	$client = new CobroAguaListData();
	$client->code = "";// $_POST['code'];

	$client->contrato_agua = $cobros[0]['contrato_agua'];
	$client->contrato_agua_id = $cobros[0]['contrato_agua_id'];

	$client->forma_pago_id = $cobros[0]['forma_pago_id'];
	$client->client_id = $cobros[0]['client_id'];
	$client->corte_id = $last->id; 
	$coa=$client->add();
	/*
	$client = new CobroAguaData();
	$client->code = "";// $_POST['code'];
	$client->date_at = $_POST['date_at'];

	$client->contrato_agua = $_POST['contrato_agua'];
	$client->contrato_agua_id = $_POST['contrato_agua_id'];
	$client->amount = $_POST['amount'];
	$client->descuento = $_POST['descuento'];
	$client->iva = $_POST['iva'];

	$client->periodo_id = $_POST['periodo_id'];
	$client->tipo_servicio_id = $_POST['tipo_servicio_id'];
	$client->tipo_contrato = $_POST['tipo_contrato'];
	$client->client_id = $_POST['client_id'];
	$client->description = $_POST['description'];
	$client->cobro_agua_list_id = $coa[1];
	$client->add();
	*/

	foreach($cobros as $cob){
	$client = new CobroAguaData();
	$client->code = "";// $_POST['code'];
	$client->date_at = $cob['date_at'];

	$client->contrato_agua = $cob['contrato_agua'];
	$client->contrato_agua_id = $cob['contrato_agua_id'];
	$client->amount = $cob['amount'];
	$client->descuento = $cob['descuento'];
	$client->iva = $cob['iva'];

	$client->periodo_id = $cob['periodo_id'];
	$client->tipo_servicio_id = $cob['tipo_servicio_id'];
	$client->tipo_contrato = $cob['tipo_contrato'];
	$client->client_id = $cob['client_id'];
	$client->description = $cob['description'];
	$client->forma_pago_id = $cob['forma_pago_id'];
	$client->cobro_agua_list_id = $coa[1];
	$client->corte_id = $last->id; 
	$client->add();
	}
	//Core::alert("Cobro Agregado!");
	unset($_SESSION['cobro_list']);
	$_SESSION['cobro_realizado']=1;
		Core::redir("./?view=cobrosagua&opt=showticket&id=".$coa[1]);

}else{
	$_SESSION['error_caja']=1;
	Core::redir("./?view=cobrosagua&opt=all");

}
}


if(isset($_GET['opt']) && $_GET['opt']=="update"){

	$client = CobroAguaData::getById($_POST["id"]);
	$client->code = $_POST['code'];
	$client->date_at = $_POST['date_at'];
	$client->tipo_contrato = $_POST['tipo_contrato'];
	$client->client_id = $_POST['client_id'];
	$client->description = $_POST['description'];

	$client->update();
	Core::redir("./?view=cobrosagua&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="del"){

	$client = CobroAguaListData::getById($_GET["id"]);

	$cobros = CobroAguaData::getAllBy("cobro_agua_list_id",$_GET["id"]);
	foreach($cobros as $co){ $co->del(); }
	$client->del();

	$_SESSION['deleted_item']=1;

	Core::redir("./?view=cobrosagua&opt=all");

}
?>