<?php if(isset($_GET['opt']) && $_GET['opt']=="add"){

	$client = new BrandData();
	$client->name = $_POST['name'];

	$client->add();
	Core::redir("./?view=brands&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="update"){

	$client = BrandData::getById($_POST["id"]);
	$client->name = $_POST['name'];

	$client->update();
	Core::redir("./?view=brands&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="del"){
try{
	$client = BrandData::getById($_GET["id"]);
	$client->del();
		$_SESSION['deleted_item']=1;
	}	
catch(Exception $e){
		unset($_SESSION['deleted_item']);
		Core::alert("No se puede eliminar");

	}
	Core::redir("./?view=brands&opt=all");

}
?>