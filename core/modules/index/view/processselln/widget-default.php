<?php

if(isset($_SESSION["cartn"])){
	$cart = $_SESSION["cartn"];
	if(count($cart)>0){
/// antes de proceder con lo que sigue vamos a verificar que:
		// haya existencia de productos
		// si se va a facturar la cantidad a facturr debe ser menor o igual al producto facturado en inventario
		$num_succ = 0;
		$process=false;
		$errors = array();
		foreach($cart as $c){

			///
			$q = OperationData::getQNoF($c["product_id"],$cut->id);
			print_r($c);
			echo ">>".$q;
			if($c["q"]<=$q){
				if(isset($_POST["is_oficial"])){
				$qyf =OperationData::getQYesF($c["product_id"],$cut->id); /// son los productos que puedo facturar
				echo $qyf;
				if($c["q"]<=$qyf){
					$num_succ++;
				}else{
				$error = array("product_id"=>$c["product_id"],"message"=>"No hay suficiente cantidad de producto para facturar en inventario.");					
				$errors[count($errors)] = $error;
				}
				}else{
					// si llegue hasta aqui y no voy a facturar, entonces continuo ...
					$num_succ++;
				}
			}else{
				$error = array("product_id"=>$c["product_id"],"message"=>"No hay suficiente cantidad de producto en inventario.");
				$errors[count($errors)] = $error;
			}

		}

if($num_succ==count($cart)){
	$process = true;
}

if($process==false){
$_SESSION["errorsn"] = $errors;
	?>	
<script>
	window.location="index.php?view=selln";
</script>
<?php
}









//////////////////////////////////
		if($process==true){
			$sell = new SellData();
			$s = $sell->add();
		foreach($cart as  $c){
			print_r($c);
			print "<br>";


			$op = new OperationData();
			 $op->product_id = $c["product_id"] ;
			 $op->operation_type_id=OperationTypeData::getByName("salida")->id;
			 $op->sell_id=$s[1];
			 $op->q= $c["q"];
			 $op->cut_id = $cut->id;

			if(isset($_POST["is_oficial"]) && $_POST["is_oficial"]=="1"){
				$op->is_oficial = 1;
			}else{
				$op->is_oficial = 0;				
			}

			$add = $op->add();

			unset($_SESSION["cartn"]);
			setcookie("selled","selled");
		}
////////////////////
print "<script>window.location='index.php?view=onesell&id=$s[1]';</script>";
		}
	}
}



?>
