<?php if(isset($_GET['opt']) && $_GET['opt']=="add"){

	$client = new TipoTomaData();
	$client->name = $_POST['name'];

	$client->add();
	Core::redir("./?view=tipotomas&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="update"){

	$client = TipoTomaData::getById($_POST["id"]);
	$client->name = $_POST['name'];

	$client->update();
	Core::redir("./?view=tipotomas&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="del"){
	try{
		$client = TipoTomaData::getById($_GET["id"]);
		$client->del();
		$_SESSION['deleted_item']=1;
	}	
catch(Exception $e){
		unset($_SESSION['deleted_item']);
		Core::alert("No se puede eliminar");

	}
	Core::redir("./?view=tipotomas&opt=all");

}
?>