<?php if(isset($_GET['opt']) && $_GET['opt']=="add"){

	$client = new ServicioTesoreriaData();
	$client->name = $_POST['name'];
	$client->price = $_POST['price'];
	$client->cat_tesoreria_id = $_POST['cat_tesoreria_id'];

	$client->add();
	Core::redir("./?view=serviciostesoreria&opt=all&id=".$_POST['cat_tesoreria_id']);

}
if(isset($_GET['opt']) && $_GET['opt']=="update"){

	$client = ServicioTesoreriaData::getById($_POST["id"]);
	$client->name = $_POST['name'];
	$client->price = $_POST['price'];
	//$client->cat_tesoreria_id = $_POST['cat_tesoreria_id'];

	$client->update();
	Core::redir("./?view=serviciostesoreria&opt=all&id=".$client->cat_tesoreria_id);

}
if(isset($_GET['opt']) && $_GET['opt']=="del"){

	$client = ServicioTesoreriaData::getById($_GET["id"]);
	$client->del();
	Core::redir("./?view=serviciostesoreria&opt=all&id=".$client->cat_tesoreria_id);

}
?>