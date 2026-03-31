<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
	if(count($_POST)>0){
		$product = new IngredientData();
		$product->code = $_POST["code"];
		$product->name = $_POST["name"];
		$product->price_out = $_POST["price_out"];
		$product->unit = $_POST["unit"];
		$product->user_id = $_SESSION['user_id'];
		$product->add();
		header("Location: index.php?view=ingredients&opt=all");
	}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
	if(count($_POST)>0){
		$product = IngredientData::getById($_POST["ingredient_id"]);
		$product->code = $_POST["code"];
		$product->name = $_POST["name"];
		$product->price_out = $_POST["price_out"];
		$product->unit = $_POST["unit"];
		$product->user_id = $_SESSION['user_id'];
		$product->update();
		header("Location: index.php?view=ingredients&opt=all");
	}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$product = IngredientData::getById($_GET["id"]);
	$product->del();
	header("Location: index.php?view=ingredients&opt=all");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="addtore"){
	if(count($_POST)>0){
		if(!isset($_SESSION["reabastecer"])){
			$product = array("product_id"=>$_POST["product_id"],"q"=>$_POST["q"]);
			$_SESSION["reabastecer"] = array($product);
		}else{
			$found = false;
			$cart = $_SESSION["reabastecer"];
			$index=0;
			foreach($cart as $c){
				if($c["product_id"]==$_POST["product_id"]){
					$found=true;
					break;
				}
				$index++;
			}
			if($found==true){
				$q1 = $cart[$index]["q"];
				$q2 = $_POST["q"];
				$cart[$index]["q"]=$q1+$q2;
				$_SESSION["reabastecer"] = $cart;
			}else{
				$nc = count($cart);
				$product = array("product_id"=>$_POST["product_id"],"q"=>$_POST["q"]);
				$cart[$nc] = $product;
				$_SESSION["reabastecer"] = $cart;
			}
		}
		header("Location: index.php?view=ingredients&opt=re");
	}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="clearre"){
	if(isset($_GET["product_id"])){
		$cart=$_SESSION["reabastecer"];
		if(count($cart)==1){
			unset($_SESSION["reabastecer"]);
		}else{
			$ncart = array();
			foreach($cart as $c){
				if($c["product_id"]!=$_GET["product_id"]){
					$ncart[]= $c;
				}
			}
			$_SESSION["reabastecer"] = $ncart;
		}
	}else{
		unset($_SESSION["reabastecer"]);
	}
	header("Location: index.php?view=ingredients&opt=re");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="processre"){
	if(isset($_SESSION["reabastecer"]) && count($_SESSION["reabastecer"])>0){
		$cart = $_SESSION["reabastecer"];
		foreach($cart as $c){
			$op = new Operation2Data();
			$op->ingredient_id = $c["product_id"];
			$op->operation_type_id = 1; // 1 = entrada
			$op->sell_id = "NULL";
			$op->q = $c["q"];
			$op->add();
		}
		unset($_SESSION["reabastecer"]);
		header("Location: index.php?view=ingredients&opt=inventory");
	}
}
?>
