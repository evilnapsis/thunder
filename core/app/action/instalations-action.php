<?php if(isset($_GET['opt']) && $_GET['opt']=="add"){

	$intern = ItemData::getById($_POST['item_intern_id']);
	$intern->status=2;
	$intern->update_status();
	$extern = ItemData::getById($_POST['item_extern_id']);
	$extern->status=2;
	$extern->update_status();

	$client = new InstalationData();
	$client->code = $_POST['code'];
	$client->date_at = $_POST['date_at'];
	$client->client_id = $_POST['client_id'];
	$client->item_extern_id = $_POST['item_extern_id']!=""?$_POST['item_extern_id']:"NULL";
	$client->item_intern_id = $_POST['item_intern_id']!=""?$_POST['item_intern_id']:"NULL";
	$client->amount = $_POST['amount'];
	$client->description = $_POST['description'];
	$client->add();
	Core::redir("./?view=instalations&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="update"){

	$client = InstalationData::getById($_POST["id"]);
	$client->code = $_POST['code'];
	$client->date_at = $_POST['date_at'];
	$client->client_id = $_POST['client_id'];
	$client->item_extern_id = $_POST['item_extern_id']!=""?$_POST['item_extern_id']:"NULL";
	$client->item_intern_id = $_POST['item_intern_id']!=""?$_POST['item_intern_id']:"NULL";
	$client->description = $_POST['description'];
	$client->amount = $_POST['amount'];

	$client->update();
	Core::redir("./?view=instalations&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="del"){
try{
	$client = InstalationData::getById($_GET["id"]);
	$client->del();
		$_SESSION['deleted_item']=1;
	}	
catch(Exception $e){
		unset($_SESSION['deleted_item']);
		Core::alert("No se puede eliminar");

	}
	Core::redir("./?view=instalations&opt=all");

}
?>