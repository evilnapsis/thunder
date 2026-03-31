<?php if(isset($_GET['opt']) && $_GET['opt']=="add"){

	$c = CarData::getByPlaca($_POST['placa']);
	//print_r($c);
	if($c==null){
	$client = new CarData();
	$client->name = $_POST['name'];
	$client->serie = $_POST['serie'];
	$client->placa = $_POST['placa'];
	$client->marca = $_POST['marca'];
	$client->modelo = $_POST['modelo'];
	$client->anio = $_POST['anio'];
	$client->add();
	}else{
		Core::alert("Error: Numero de placa repetida!");
	}
	Core::redir("./?view=cars&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="update"){

	$client = CarData::getById($_POST["id"]);
	$client->name = $_POST['name'];
	$client->serie = $_POST['serie'];
	$client->placa = $_POST['placa'];
	$client->marca = $_POST['marca'];
	$client->modelo = $_POST['modelo'];
	$client->anio = $_POST['anio'];

	$client->update();
	Core::redir("./?view=cars&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="del"){

	$client = CarData::getById($_GET["id"]);
	$client->del();
	Core::redir("./?view=cars&opt=all");

}
?>