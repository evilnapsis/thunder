<?php if(isset($_GET['opt']) && $_GET['opt']=="add"){

	$client = new LicenciaData();
	$client->code = $_POST['code'];
	$client->date_at = $_POST['date_at'];
	$client->client_id = $_POST['client_id'];
	$client->negocio = $_POST['negocio'];
	$client->amount = $_POST['amount'];
	$client->vigencia = $_POST['vigencia'];
	$cx=$client->add();
////
	Core::redir("./?view=licencias&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="update"){

	$client = LicenciaData::getById($_POST["id"]);
	$client->code = $_POST['code'];
//	$client->date_at = $_POST['date_at'];
////	$client->client_id = $_POST['client_id'];
	$client->negocio = $_POST['negocio'];
	$client->amount = $_POST['amount'];
	$client->status = $_POST['status'];
	$client->vigencia = $_POST['vigencia'];
	$client->update();
	Core::redir("./?view=licencias&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="del"){

	$client = LicenciaData::getById($_GET["id"]);
	$client->del();
	Core::redir("./?view=licencias&opt=all");

}
?>