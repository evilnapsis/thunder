<?php

if(isset($_SESSION["cart"])){
	$cart = $_SESSION["cart"];
	if(count($cart)>0){
/// antes de proceder con lo que sigue vamos a verificar que:
		// haya existencia de productos
		// si se va a facturar la cantidad a facturr debe ser menor o igual al producto facturado en inventario
		$num_succ = 0;
		$process=false;
		$errors = array();
		foreach($cart as $c){
					$num_succ++;
		}

if($num_succ==count($cart)){
	$process = true;
}

if($process==false){
$_SESSION["errors"] = $errors;
	?>	
<script>
	window.location="index.php?view=sell";
</script>
<?php
}









//////////////////////////////////
		if($process==true){
			$sell = new SellData();
			$sell->q = $_POST["q"];
			$sell->mesero_id = $_POST["mesero_id"];
			$sell->item_id = $_POST["mesa"];
			$s = $sell->add();
		foreach($cart as  $c){
			print_r($c);
			print "<br>";


			$op = new OperationData();
			 $op->product_id = $c["product_id"] ;
			 $op->operation_type_id=OperationTypeData::getByName("salida")->id;
			 $op->sell_id=$s[1];
			 $op->q= $c["q"];

			if(isset($_POST["is_oficial"])){
				$op->is_oficial = 1;
			}

			$add = $op->add();

			unset($_SESSION["cart"]);
			setcookie("selled","selled");
		}
////////////////////
print "<script>window.location='index.php?view=onesell&id=$s[1]';</script>";
		}
	}
}



?>
