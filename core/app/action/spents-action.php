<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
	if(count($_POST)>0){
		$spent = new SpentData();
		$spent->q = $_POST["q"];
		$spent->name = $_POST["name"];
		$spent->unit = $_POST["unit"];
		$spent->price = $_POST["price_out"];
		$spent->category_id = $_POST["category_id"];
		$spent->add();
		header("Location: index.php?view=spents&opt=all");
	}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$spent = SpentData::getById($_GET["id"]);
	$spent->del();
	header("Location: index.php?view=spents&opt=all");
}
?>
