<?php if(isset($_GET['opt']) && $_GET['opt']=="addincome"){

	$client = new OperationData();
	$client->description = $_POST['description'];
	$client->amount = $_POST['amount'];
    $client->operation_type = 1;
    $client->invoice_id = "NULL";
    $client->invest_id="NULL";
    $client->user_id = $_POST["user_id"];
    $client->status_id=1;
	$client->add();
	Core::redir("./?view=investors&opt=open&id=".$_POST["user_id"]);

}
if(isset($_GET['opt']) && $_GET['opt']=="addwithdrawal"){

	$client = new OperationData();
	$client->description = $_POST['description'];
	$client->amount = $_POST['amount'];
    $client->operation_type = 2;
    $client->invoice_id = "NULL";
    $client->invest_id="NULL";
    $client->user_id = $_POST["user_id"];
    $client->status_id=1;
	$client->add();
	Core::redir("./?view=investors&opt=open&id=".$_POST["user_id"]);

}
if(isset($_GET['opt']) && $_GET['opt']=="add"){

	$client = new OperationData();
	$client->name = $_POST['name'];

	$client->add();
	Core::redir("./?view=operations&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="update"){

	$client = OperationData::getById($_POST["id"]);
	$client->name = $_POST['name'];

	$client->update();
	Core::redir("./?view=operations&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="del"){
try{
	$client = OperationData::getById($_GET["id"]);
	$client->del();
		$_SESSION['deleted_item']=1;
	}	
catch(Exception $e){
		unset($_SESSION['deleted_item']);
		Core::alert("No se puede eliminar");

	}
	Core::redir("./?view=operations&opt=all");

}
?>