<?php if(isset($_GET['opt']) && $_GET['opt']=="add"){

	$client = new TipoServicioData();
	$client->name = $_POST['name'];
	$client->price = $_POST['price'];
	$client->tipo_toma_id = $_POST['tipo_toma_id'];
	$client->es_contrato = $_POST['es_contrato'];

	$client->add();
	Core::redir("./?view=tiposervicios&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="update"){

	$client = TipoServicioData::getById($_POST["id"]);
	$client->name = $_POST['name'];
	$client->price = $_POST['price'];
	$client->tipo_toma_id = $_POST['tipo_toma_id'];
	$client->es_contrato = $_POST['es_contrato'];

	$client->update();
	Core::redir("./?view=tiposervicios&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="del"){
	try{
	$client = TipoServicioData::getById($_GET["id"]);
	$client->del();
	$_SESSION['deleted_item']=1;
	}catch(Exception $e){
		unset($_SESSION['deleted_item']);
		Core::alert("No se puede eliminar");

	}
	Core::redir("./?view=tiposervicios&opt=all");

}
?>