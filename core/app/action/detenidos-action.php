<?php if(isset($_GET['opt']) && $_GET['opt']=="add"){

	$client = new DetenidoData();
	$client->code = $_POST['code'];
	$client->date_at = $_POST['date_at'];
	$client->time_at = $_POST['time_at'];
	$client->tipo_detencion_id = $_POST['tipo_detencion_id'];
	$client->client_id = $_POST['client_id'];
	$client->motivo = $_POST['motivo'];
	$client->resolucion = $_POST['resolucion'];
	$client->amount = $_POST['amount'];
	$cx=$client->add();
////
	Core::redir("./?view=detenidos&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="update"){

	$client = DetenidoData::getById($_POST["id"]);
	$client->code = $_POST['code'];
//	$client->date_at = $_POST['date_at'];
//	$client->tipo_detencion_id = $_POST['tipo_detencion_id'];
//	$client->client_id = $_POST['client_id'];
	$client->motivo = $_POST['motivo'];
	$client->resolucion = $_POST['resolucion'];
	$client->amount = $_POST['amount'];
	$client->status = $_POST['status'];
	$client->update();
	Core::redir("./?view=detenidos&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="del"){

	$client = DetenidoData::getById($_GET["id"]);
	$client->del();
	Core::redir("./?view=detenidos&opt=all");

}
?>