<?php if(isset($_GET['opt']) && $_GET['opt']=="add"){

	$client = new CorteAguaData();
	$client->amount_start = $_POST['amount_start'];
	$client->user_id = $_SESSION['user_id'];
	$client->add();
	$_SESSION["corte_iniciado"]=1;
	Core::redir("./?view=cortesagua&opt=new");

}
if(isset($_GET['opt']) && $_GET['opt']=="update"){

	$client = CorteAguaData::getById($_POST["id"]);
	$client->amount_start = $_POST['amount_start'];
	$client->amount_end = $_POST['amount_end'];

	$client->update();
	Core::redir("./?view=cortesagua&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="finish"){

	$client = CorteAguaData::getById($_POST["id"]);
	$client->amount_end = $_POST['amount_end'];
	$_SESSION["corte_finalizado"]=1;
	$client->finish();
	Core::redir("./?view=cortesagua&opt=new");

}
if(isset($_GET['opt']) && $_GET['opt']=="del"){
	try{
	$client = CorteAguaData::getById($_GET["id"]);
	$_SESSION['deleted_item']=1;
	$client->del();
}catch(Exception $e){
	$_SESSION['deleted_item']=0;
		Core::alert("Error. No se puede Eliminar!");
	}
	Core::redir("./?view=cortesagua&opt=all");

}
?>