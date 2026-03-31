<?php if(isset($_GET['opt']) && $_GET['opt']=="addin"){
	$pro = ProductData::getById($_POST["product_id"]);
	$client = new InventarioData();
	$client->product_id = $_POST['product_id'];
	$client->q = $_POST['q'];
	$client->price_in = $pro->price_in;// $_POST['price_in'];
	$client->price_out = $pro->price_out; //$_POST['price_out'];
	$client->tipo_operacion =1;

	$client->add();
	Core::redir("./?view=inventarios&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="addout"){

	$pro = ProductData::getById($_POST["product_id"]);

$in = InventarioData::countByPT($pro->id,1)->tot;
$out = InventarioData::countByPT($pro->id,2)->tot;
$q = $in- $out;
if($q>=$_POST['q']){
	$client = new InventarioData();
	$client->product_id = $_POST['product_id'];
	$client->q = $_POST['q'];
	$client->price_in = $pro->price_in;// $_POST['price_in'];
	$client->price_out = $pro->price_out; //$_POST['price_out'];
	$client->tipo_operacion =2;

	$client->add();
}else{
	Core::alert("Error: Existencias insuficientes!");
}
	Core::redir("./?view=inventarios&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="update"){


//	Core::redir("./?view=inventarios&opt=all");

}
if(isset($_GET['opt']) && $_GET['opt']=="del"){

	$client = InventarioData::getById($_GET["id"]);
	$client->del();
	Core::redir("./?view=inventarios&opt=all");

}
?>