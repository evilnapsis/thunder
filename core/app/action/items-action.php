<?php if(isset($_GET['opt']) && $_GET['opt']=="add"){

	$client = new ItemData();
	$client->code = $_POST['code'];
	$client->barcode = $_POST['barcode'];
	$client->serie = $_POST['serie'];
	$client->name = $_POST['name'];
	$client->brand_id = $_POST['brand_id']!=""?$_POST['brand_id']:"NULL";
	$client->price_in = $_POST['price_in'];
	$client->price_out = $_POST['price_out'];
	$client->description = $_POST['description'];
	$client->kind = $_POST['kind'];
	$client->add();
	Core::redir("./?view=items&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="update"){

	$client = ItemData::getById($_POST["id"]);
	$client->code = $_POST['code'];
	$client->barcode = $_POST['barcode'];
	$client->serie = $_POST['serie'];
	$client->name = $_POST['name'];
	$client->brand_id = $_POST['brand_id']!=""?$_POST['brand_id']:"NULL";
	$client->price_in = $_POST['price_in'];
	$client->price_out = $_POST['price_out'];
	$client->description = $_POST['description'];

	$client->update();
	Core::redir("./?view=items&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="del"){
try{
	$client = ItemData::getById($_GET["id"]);
	$client->del();
		$_SESSION['deleted_item']=1;
	}	
catch(Exception $e){
		unset($_SESSION['deleted_item']);
		Core::alert("No se puede eliminar");

	}
	Core::redir("./?view=items&opt=all");

}
?>