<?php if(isset($_GET['opt']) && $_GET['opt']=="add"){

	$client = new MttoData();
	$client->code = $_POST['code'];
	$client->date_at = $_POST['date_at'];
	$client->client_id = $_POST['client_id'];
	$client->item_id = $_POST['item_id']!=""?$_POST['item_id']:"NULL";
	$client->amount = $_POST['amount'];
	$client->description = $_POST['description'];
	$client->add();
	Core::redir("./?view=mttos&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="update"){

	$client = MttoData::getById($_POST["id"]);
	$client->code = $_POST['code'];
	$client->date_at = $_POST['date_at'];
	$client->client_id = $_POST['client_id'];
	$client->item_id = $_POST['item_id']!=""?$_POST['item_id']:"NULL";
	$client->description = $_POST['description'];
	$client->amount = $_POST['amount'];

	$client->update();
	Core::redir("./?view=mttos&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="del"){
try{
	$client = MttoData::getById($_GET["id"]);
	$client->del();
		$_SESSION['deleted_item']=1;
	}	
catch(Exception $e){
		unset($_SESSION['deleted_item']);
		Core::alert("No se puede eliminar");

	}
	Core::redir("./?view=mttos&opt=all");

}
?>