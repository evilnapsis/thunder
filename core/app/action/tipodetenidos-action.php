<?php if(isset($_GET['opt']) && $_GET['opt']=="add"){

	$client = new TipoDetencionData();
	$client->name = $_POST['name'];

	$client->add();
	Core::redir("./?view=tipodetenidos&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="update"){

	$client = TipoDetencionData::getById($_POST["id"]);
	$client->name = $_POST['name'];

	$client->update();
	Core::redir("./?view=tipodetenidos&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="del"){

	$client = TipoDetencionData::getById($_GET["id"]);
	$client->del();
	Core::redir("./?view=tipodetenidos&opt=all");

}
?>