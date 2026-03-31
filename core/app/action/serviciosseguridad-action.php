<?php if(isset($_GET['opt']) && $_GET['opt']=="add"){

	$client = new ServicioSeguridadData();
	$client->name = $_POST['name'];
	$client->price = $_POST['price'];
	$client->cat_seguridad_id = $_POST['cat_seguridad_id'];

	$client->add();
	Core::redir("./?view=serviciosseguridad&opt=all&id=".$_POST['cat_seguridad_id']);

}
if(isset($_GET['opt']) && $_GET['opt']=="update"){

	$client = ServicioSeguridadData::getById($_POST["id"]);
	$client->name = $_POST['name'];
	$client->price = $_POST['price'];
	//$client->cat_seguridad_id = $_POST['cat_seguridad_id'];

	$client->update();
	Core::redir("./?view=serviciosseguridad&opt=all&id=".$client->cat_seguridad_id);

}
if(isset($_GET['opt']) && $_GET['opt']=="del"){

	$client = ServicioSeguridadData::getById($_GET["id"]);
	$client->del();
	Core::redir("./?view=serviciosseguridad&opt=all&id=".$client->cat_seguridad_id);

}
?>