<?php if(isset($_GET['opt']) && $_GET['opt']=="add"){
	$tipo_servicio = TipoServicioData::getByToma($_POST['tipo_contrato']);
$last = CorteAguaData::getLastByUser(Core::$user->id);
if($last){

	$client = new ContratoAguaData();
	$client->code = $_POST['code'];
	$client->tarifa = $_POST['tarifa'];
	$client->diametro = $_POST['diametro'];
	$client->date_at = $_POST['date_at'];
	$client->tipo_contrato = $_POST['tipo_contrato'];
	$client->client_id = $_POST['client_id'];
	$client->description = $_POST['description'];

	$client->amount = $tipo_servicio->price; //$_POST['amount'];
	$client->descuento = $_POST['descuento'];
	$client->iva = $_POST['iva'];
	$client->periodo_id = $_POST['periodo_id'];


	$cx=$client->add();
////
///////////

	$client = new CobroAguaListData();
	$client->code = "";// $_POST['code'];
	$client->contrato_agua = $_POST["code"];
	$client->contrato_agua_id = $cx[1];;
	$client->forma_pago_id = $_POST['forma_pago_id'];
	$client->client_id = $_POST['client_id'];
	$client->corte_id = $last->id;
	$coa=$client->add();


//////////////
	$client = new CobroAguaData();
	$client->code = "";// $_POST['code'];
	$client->date_at = $_POST['date_at'];
	$client->tipo_servicio_id = $tipo_servicio->id;

	$client->contrato_agua = $_POST['code'];
	$client->contrato_agua_id = $cx[1]; //$_POST['contrato_agua_id'];
	$client->amount = $tipo_servicio->price; //$_POST['amount'];
	$client->descuento = $_POST['descuento'];
	$client->iva = $_POST['iva'];

	$client->periodo_id = $_POST['periodo_id'];
	$client->tipo_contrato = $_POST['tipo_contrato'];
	$client->forma_pago_id = $_POST['forma_pago_id'];
	$client->client_id = $_POST['client_id'];
	$client->description = $_POST['description'];
	$client->cobro_agua_list_id = $coa[1];
	$client->corte_id = $last->id;
	$client->add();
}
//////////////

	Core::redir("./?view=contratosagua&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="update"){

	$client = ContratoAguaData::getById($_POST["id"]);
	$client->date_at = $_POST['date_at'];
	$client->diametro = $_POST['diametro'];
	$client->tarifa = $_POST['tarifa'];
	$client->description = $_POST['description'];

	$client->update();
	Core::redir("./?view=contratosagua&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="del"){
	try{
	$client = ContratoAguaData::getById($_GET["id"]);
	$_SESSION['deleted_item']=1;
	$client->del();
	}catch(Exception $e){
		unset($_SESSION['deleted_item']);

//		Core::alert("Error. No se puede Eliminar!".$e->getMessage());
		Core::alert("Error. No se puede Eliminar!");
	}
	Core::redir("./?view=contratosagua&opt=all");

}
?>