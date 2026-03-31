<?php if(isset($_GET['opt']) && $_GET['opt']=="add"){

	$client = new InvoiceData();
	$client->code = $_POST['code'];
	$client->invoice = $_POST['invoice'];
	$client->amount = $_POST['amount'];
	$client->time_limit = $_POST['time_limit'];
	$client->description = $_POST['description'];
	$client->status_id = 1;//$_POST['name'];
    $client->user_id = Core::$user->id;     

	$client->add();
	Core::redir("./?view=invoices&opt=all");

}
 if(isset($_GET['opt']) && $_GET['opt']=="addinvest"){

	$client = new InvestData();
	$client->invoice_id = $_POST['invoice_id'];
	$client->amount = $_POST['amount'];
	$client->description = $_POST['description'];
	$client->status_id = 1;//$_POST['name'];
    $client->user_id = Core::$user->id;     

	$client->add();
	Core::redir("./?view=invoices&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="update"){

	$client = InvoiceData::getById($_POST["id"]);
	$client->code = $_POST['code'];
	$client->invoice = $_POST['invoice'];
	$client->amount = $_POST['amount'];
	$client->time_limit = $_POST['time_limit'];
	$client->description = $_POST['description'];

	$client->update();
	Core::redir("./?view=invoices&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="del"){
try{
	$client = InvoiceData::getById($_GET["id"]);
	$client->del();
		$_SESSION['deleted_item']=1;
	}	
catch(Exception $e){
		unset($_SESSION['deleted_item']);
		Core::alert("No se puede eliminar");

	}
	Core::redir("./?view=invoices&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="approve"){
        $client = InvestData::getById($_GET["id"]);
        $client->status_id=2;
        $client->update_status();
            $_SESSION['aprove_item']=1;

        Core::redir("./?view=invoices&opt=all");
    
    }
    if(isset($_GET['opt']) && $_GET['opt']=="finalize"){
        $client = InvoiceData::getById($_GET["id"]);
        $client->status_id=3;
        $client->update_status();
            $_SESSION['finalize_item']=1;

        Core::redir("./?view=invoices&opt=all");
    
    }
?>