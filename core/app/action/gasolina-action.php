<?php if(isset($_GET['opt']) && $_GET['opt']=="add"){

	$client = new GasolinaData();
	$client->description = $_POST['description'];
	$client->litros = $_POST['litros'];
	$client->car_id = $_POST['car_id'];
	$client->driver_id = $_POST['driver_id'];
	$client->date_at = $_POST['date_at'];

	$client->add();
	Core::redir("./?view=gasolina&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="update"){

	$client = GasolinaData::getById($_POST["id"]);
	$client->description = $_POST['description'];
	$client->litros = $_POST['litros'];
	$client->car_id = $_POST['car_id'];
	$client->driver_id = $_POST['driver_id'];
	$client->date_at = $_POST['date_at'];

	$client->update();
	Core::redir("./?view=gasolina&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="del"){

	$client = GasolinaData::getById($_GET["id"]);
	$client->del();
	Core::redir("./?view=gasolina&opt=all");

}
?>