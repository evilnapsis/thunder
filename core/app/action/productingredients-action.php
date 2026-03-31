<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
	if(count($_POST)>0){
		$operation = new ProductIngredientData();
		$operation->product_id = $_POST["product_id"];
		$operation->ingredient_id = $_POST["ingredient_id"];
		$operation->q = $_POST["q"];
		$operation->is_required = isset($_POST["is_required"]) ? 1 : 0;
		$operation->add();
		header("Location: index.php?view=productingredients&opt=all&id=".$_POST["product_id"]);
	}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
	if(count($_POST)>0){
		$operation = ProductIngredientData::getById($_POST["operation_id"]);
		$operation->q = $_POST["q"];
		$operation->is_required = isset($_POST["is_required"]) ? 1 : 0;
		$operation->update();
		header("Location: index.php?view=productingredients&opt=all&id=".$_POST["product_id"]);
	}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$operation = ProductIngredientData::getById($_GET["operation_id"]);
	$pid = $operation->product_id;
	$operation->del();
	header("Location: index.php?view=productingredients&opt=all&id=".$pid);
}
?>
