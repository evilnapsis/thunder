<?php if(isset($_GET['opt']) && $_GET['opt']=="add"){

	$client = new PeriodoData();
	$client->name = $_POST['name'];
	$client->tipo = $_POST['tipo'];

	$client->add();
	Core::redir("./?view=periodos&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="update"){

	$client = PeriodoData::getById($_POST["id"]);
	$client->name = $_POST['name'];
	$client->tipo = $_POST['tipo'];

	$client->update();
	Core::redir("./?view=periodos&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="del"){

try{
	$client = PeriodoData::getById($_GET["id"]);
	$client->del();
		$_SESSION['deleted_item']=1;
	}	
catch(Exception $e){
		unset($_SESSION['deleted_item']);
		Core::alert("No se puede eliminar");

	}
	Core::redir("./?view=periodos&opt=all");

}
?>