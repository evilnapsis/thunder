<?php

if(count($_POST)>0){
	$product = new IngredientData();
	$product->code = $_POST["code"];
	$product->name = $_POST["name"];
	$product->price_out = $_POST["price_out"];
	$product->unit = $_POST["unit"];
	$product->user_id = Session::getUID();
	$product->add();
	print "<script>window.location='index.php?view=ingredients';</script>";


}


?>