<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="addtocart"){
	if(count($_POST)>0){
		if(!isset($_SESSION["cart"])){
			$product = array("product_id"=>$_POST["product_id"],"q"=>$_POST["q"]);
			$_SESSION["cart"] = array($product);
		}else{
			$found = false;
			$cart = $_SESSION["cart"];
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
				$_SESSION["cart"] = $cart;
			}else{
				$nc = count($cart);
				$product = array("product_id"=>$_POST["product_id"],"q"=>$_POST["q"]);
				$cart[$nc] = $product;
				$_SESSION["cart"] = $cart;
			}
		}
		header("Location: index.php?view=sell&opt=sell");
	}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="clearcart"){
	if(isset($_GET["product_id"])){
		$cart=$_SESSION["cart"];
		if(count($cart)==1){
			unset($_SESSION["cart"]);
		}else{
			$ncart = array();
			foreach($cart as $c){
				if($c["product_id"]!=$_GET["product_id"]){
					$ncart[]= $c;
				}
			}
			$_SESSION["cart"] = $ncart;
		}
	}else{
		unset($_SESSION["cart"]);
	}
	header("Location: index.php?view=sell&opt=sell");
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="process"){
	if(isset($_SESSION["cart"]) && count($_SESSION["cart"])>0){
		$cart = $_SESSION["cart"];
		
		// 1. Validar ingredientes obligatorios
		$errors = array();
		foreach($cart as $c){
			$ingredients = ProductIngredientData::getAllByProductId($c["product_id"]);
			foreach($ingredients as $in){
				if($in->is_required){
					$q_needed = $in->q * $c["q"]; // Cantidad necesaria basándose en el producto y su cantidad
					$q_available = Operation2Data::getQYesF($in->ingredient_id);
					if($q_available < $q_needed){
						$ing_data = $in->getIngredient();
						$prod_data = ProductData::getById($c["product_id"]);
						$errors[] = "Stock insuficiente de <b>".$ing_data->name."</b> para preparar <b>".$prod_data->name."</b> (Necesario: $q_needed, Disponible: $q_available)";
					}
				}
			}
		}

		if(count($errors)>0){
			$_SESSION["sell_errors"] = $errors;
			header("Location: index.php?view=sell&opt=sell");
			exit;
		}

		// 2. Procesar Venta
		$sell = new SellData();
		$sell->q = $_POST["q"];
		$sell->mesero_id = $_POST["mesero_id"];
		$sell->item_id = $_POST["mesa"];
		$s = $sell->add();

		foreach($cart as $c){
			// Registrar salida del producto terminado
			$op = new OperationData();
			$op->product_id = $c["product_id"];
			$op->operation_type_id=OperationTypeData::getByName("salida")->id;
			$op->sell_id=$s[1];
			$op->q= $c["q"];
			$op->add();

			// 3. Descontar Ingredientes Automáticamente (incluye opcionales si hay stock)
			$ingredients = ProductIngredientData::getAllByProductId($c["product_id"]);
			if(count($ingredients)>0){
				// Debemos crear un sell2 para asociar los ingredientes ya que operation2 depende de sell2
				$s2 = new Sell2Data();
				$s2->user_id = $_SESSION["user_id"];
				$s2->operation_type_id = 2; // salida
				$res_s2 = $s2->add();

				foreach($ingredients as $in){
					$q_to_deduct = $in->q * $c["q"];
					$op2 = new Operation2Data();
					$op2->ingredient_id = $in->ingredient_id;
					$op2->operation_type_id = 2; // 2 = salida
					$op2->sell_id = $res_s2[1]; // Asociamos al nuevo sell2
					$op2->q = $q_to_deduct;
					$op2->add();
				}
			}
		}

		unset($_SESSION["cart"]);
		setcookie("selled","true");
		header("Location: index.php?view=sell&opt=onesell&id=".$s[1]);
	}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="apply"){
	$sell = SellData::getById($_GET["id"]);
	$sell->cajero_id = $_SESSION["user_id"];
	$sell->apply();
	header("Location: index.php?view=sell&opt=onesell&id=".$_GET["id"]);
}
?>
