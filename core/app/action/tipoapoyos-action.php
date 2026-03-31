<?php if(isset($_GET['opt']) && $_GET['opt']=="add"){

	$client = new TipoApoyoData();
	$client->name = $_POST['name'];

	$client->add();
	Core::redir("./?view=tipoapoyos&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="update"){

	$client = TipoApoyoData::getById($_POST["id"]);
	$client->name = $_POST['name'];

	$client->update();
	Core::redir("./?view=tipoapoyos&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="del"){

	$client = TipoApoyoData::getById($_GET["id"]);
	$client->del();
	Core::redir("./?view=tipoapoyos&opt=all");

}
?>