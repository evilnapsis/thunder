<?php if(isset($_GET['opt']) && $_GET['opt']=="add"){

	$dri = DriverData::getBy("licencia",$_POST["licencia"]);
	$dri = DriverData::getBy("licencia",$_POST["licencia"]);

	if($dri==null){
	$client = new DriverData();
	$client->curp = $_POST['curp'];
	$client->name = $_POST['name'];
	$client->address = $_POST['address'];
	$client->licencia = $_POST['licencia'];
	$client->tipo_licencia = $_POST['tipo_licencia'];
	$client->expire_at = $_POST['expire_at'];
	$client->add();
	}else{
		Core::alert("Error Licencia Repetida!");
	}
	Core::redir("./?view=drivers&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="update"){

	$client = DriverData::getById($_POST["id"]);
	$client->name = $_POST['name'];
	$client->address = $_POST['address'];
	$client->licencia = $_POST['licencia'];
	$client->tipo_licencia = $_POST['tipo_licencia'];
	$client->expire_at = $_POST['expire_at'];

	$client->update();
	Core::redir("./?view=drivers&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="del"){

	$client = DriverData::getById($_GET["id"]);
	$client->del();
	Core::redir("./?view=drivers&opt=all");

}
?>