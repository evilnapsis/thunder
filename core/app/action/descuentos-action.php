<?php if(isset($_GET['opt']) && $_GET['opt']=="add"){

	$client = new DescuentoData();
	$client->name = $_POST['name'];

	$client->add();
	Core::redir("./?view=descuentos&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="update"){

	$client = DescuentoData::getById($_POST["id"]);
	$client->name = $_POST['name'];

	$client->update();
	Core::redir("./?view=descuentos&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="del"){
try{
	$client = DescuentoData::getById($_GET["id"]);
	$client->del();
		$_SESSION['deleted_item']=1;
	}	
catch(Exception $e){
		unset($_SESSION['deleted_item']);
		Core::alert("No se puede eliminar");

	}
	Core::redir("./?view=descuentos&opt=all");

}
?>