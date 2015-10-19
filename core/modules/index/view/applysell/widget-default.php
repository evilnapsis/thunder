<?php

$sell = Selldata::getById($_GET["id"]);
$sell->cajero_id = Session::getUID();

$sell2 = new Sell2Data();
$sell2->user_id = $_SESSION["user_id"];
$s = $sell2->add_re_out();

$products = OperationData::getAllProductsBySellId($sell->id);
foreach ($products as $prod) {
	$product = ProductData::getById($prod->product_id);
	if($product->use_ingredient){
		$ingredients = ProductIngredientData::getAllByProductId($prod->product_id);
		foreach($ingredients as $ing){
			$ingredient = IngredientData::getById($ing->ingredient_id);
			$q = Operation2Data::getQYesF($ing->ingredient_id);
			if($q>0){
				$op = new Operation2Data();
				$op->ingredient_id = $ingredient->id ;
				$op->operation_type_id=2; // 2 - salida
				$op->sell_id=$s[1];
				$op->q= $prod->q*$ing->q;

				$add = $op->add();			 		

			}

		}
	}
	# code...
}

// inventariemos



//print_r(expression)


$sell->apply();
// print_r($sell);

header("Location: index.php?view=onesell&id=$_GET[id]");

?>