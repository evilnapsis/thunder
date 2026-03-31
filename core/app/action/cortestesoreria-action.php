<?php if(isset($_GET['opt']) && $_GET['opt']=="add"){

	$client = new CorteTesoreriaData();
	$client->amount_start = $_POST['amount_start'];
	$client->user_id = $_SESSION['user_id'];
	$client->add();
	$_SESSION["corte_iniciado"]=1;
	Core::redir("./?view=cortestesoreria&opt=new");

}
if(isset($_GET['opt']) && $_GET['opt']=="update"){

	$client = CorteTesoreriaData::getById($_POST["id"]);
	$client->amount_start = $_POST['amount_start'];
	$client->amount_end = $_POST['amount_end'];

	$client->update();
	Core::redir("./?view=cortestesoreria&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="finish"){

	$client = CorteTesoreriaData::getById($_POST["id"]);
	$client->amount_end = $_POST['amount_end'];
	$_SESSION["corte_finalizado"]=1;
	$client->finish();
	Core::redir("./?view=cortestesoreria&opt=new");

}
if(isset($_GET['opt']) && $_GET['opt']=="del"){

	$client = CorteTesoreriaData::getById($_GET["id"]);
	$client->del();
	$_SESSION['deleted_item']=1;
	Core::redir("./?view=cortestesoreria&opt=all");

}
?>