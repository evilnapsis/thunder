<?php

if(count($_POST)>0){
	$product = new ProductData();
	$product->code = $_POST["code"];
	$product->name = $_POST["name"];

	$product->description = $_POST["description"];
	$product->preparation = $_POST["preparation"];
	$product->use_ingredient = isset($_POST["use_ingredient"]) ? 1 :0 ;


	$product->category_id = $_POST["category_id"];
	$product->price_out = $_POST["price_out"];
	$product->unit = $_POST["unit"];
	$product->duration = $_POST["duration"];
	$product->user_id = Session::getUID();
	$product->add();
	print "<script>window.location='index.php?view=products';</script>";


}


?>