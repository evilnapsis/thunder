<?php if(isset($_GET['opt']) && $_GET['opt']=="add"){
//print_r($_POST);
$cobros = $_SESSION["cobro_tesoreria"];
$last = CorteTesoreriaData::getLastByUser(Core::$user->id);
if($last){

	$client = new CobroTesoreriaListData();
	$client->code = "";// $_POST['code'];


	$client->cat_tesoreria_id = $cobros[0]['cat_tesoreria_id']!=""?$cobros[0]['cat_tesoreria_id']:"NULL";
	$client->forma_pago_id = $cobros[0]['forma_pago_id'];
	$client->client_id = $cobros[0]['client_id'];
	$client->corte_id= $last->id; 
	$coa=$client->add();
	/*
	$client = new CobroTesoreriaData();
	$client->code = "";// $_POST['code'];
	$client->date_at = $_POST['date_at'];

	$client->contrato_agua = $_POST['contrato_agua'];
	$client->contrato_agua_id = $_POST['contrato_agua_id'];
	$client->amount = $_POST['amount'];
	$client->descuento = $_POST['descuento'];
	$client->iva = $_POST['iva'];

	$client->periodo_id = $_POST['periodo_id'];
	$client->servicio_tesoreria_id = $_POST['servicio_tesoreria_id'];
	$client->tipo_contrato = $_POST['tipo_contrato'];
	$client->client_id = $_POST['client_id'];
	$client->description = $_POST['description'];
	$client->cobro_tesoreria_list_id = $coa[1];
	$client->add();
	*/
	foreach($cobros as $cob){
		//print_r($cob);
	$client = new CobroTesoreriaData();
	$client->code = "";// $_POST['code'];
	$client->date_at = $cob['date_at'];
	$client->amount = $cob['amount'];
	$client->descuento = $cob['descuento'];
	$client->iva = $cob['iva'];
	$client->periodo_id = $cob['periodo_id']!=""?$cob["periodo_id"]:"NULL";

	$client->servicio_tesoreria_id = $cob['servicio_tesoreria_id'];
	$client->client_id = $cob['client_id'];
	$client->description = $cob['description'];
	$client->forma_pago_id = $cob['forma_pago_id'];
	$client->cobro_tesoreria_list_id = $coa[1];
	$client->corte_id= $last->id; 

	$client->add();
	}
	//Core::alert("Cobro Agregado!");
	unset($_SESSION['cobro_tesoreria']);
	$_SESSION['cobro_realizado']=1;
//	Core::redir("./?view=cobrostesoreria&opt=all");
	Core::redir("./?view=cobrostesoreria&opt=showticket&id=".$coa[1]);
}else{
	$_SESSION['error_caja']=1;
	Core::redir("./?view=cobrostesoreria&opt=all");

}

}
if(isset($_GET['opt']) && $_GET['opt']=="update"){

	$client = CobroTesoreriaData::getById($_POST["id"]);
	$client->code = $_POST['code'];
	$client->date_at = $_POST['date_at'];
	$client->tipo_contrato = $_POST['tipo_contrato'];
	$client->client_id = $_POST['client_id'];
	$client->description = $_POST['description'];

	$client->update();
	Core::redir("./?view=cobrostesoreria&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="del"){


	$client = CobroTesoreriaListData::getById($_GET["id"]);

	$listy = CobroTesoreriaData::getAllBy("cobro_tesoreria_list_id",$client->id);
	foreach($listy as $li){
		$li->del();
	}
	$_SESSION['deleted_item']=1;


	$client->del();
	Core::redir("./?view=cobrostesoreria&opt=all");

}
?>