<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
	if(count($_POST)>0){
		$product = new ProductData();
		$product->code = $_POST["code"];
		$product->name = $_POST["name"];
		$product->description = $_POST["description"];
		$product->preparation = $_POST["preparation"];
		$product->use_ingredient = isset($_POST["use_ingredient"]) ? 1 : 0;
		$product->category_id = $_POST["category_id"];
		$product->price_out = $_POST["price_out"];
		$product->unit = $_POST["unit"];
		$product->duration = $_POST["duration"];
		$product->user_id = $_SESSION["user_id"];
		$product->add();
		header("Location: index.php?view=products&opt=all");
	}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
	if(count($_POST)>0){
		$product = ProductData::getById($_POST["product_id"]);
		$product->name = $_POST["name"];
		$product->code = $_POST["code"];
		$product->description = $_POST["description"];
		$product->preparation = $_POST["preparation"];
		$product->use_ingredient = isset($_POST["use_ingredient"]) ? 1 : 0;
		$product->price_out = $_POST["price_out"];
		$product->unit = $_POST["unit"];
		$product->duration = $_POST["duration"];
		$product->category_id = $_POST["category_id"];
		$product->user_id = $_SESSION["user_id"];
		$product->update();
		setcookie("prdupd","true");
		header("Location: index.php?view=products&opt=edit&id=".$_POST["product_id"]);
	}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="active"){
	$cat = ProductData::getById($_GET["id"]);
	$cat->active();
	header("Location: index.php?view=products&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="hide"){
	$cat = ProductData::getById($_GET["id"]);
	$cat->hide();
	header("Location: index.php?view=products&opt=all");
}
?>