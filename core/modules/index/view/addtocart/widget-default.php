<?php

if(!isset($_SESSION["cart"])){


	$product = array("product_id"=>$_POST["product_id"],"q"=>$_POST["q"]);
	$_SESSION["cart"] = array($product);


	$cart = $_SESSION["cart"];

///////////////////////////////////////////////////////////////////
		$num_succ = 0;
		$process=false;
		$errors = array();
		foreach($cart as $c){

			///
				$num_succ++;

		}
///////////////////////////////////////////////////////////////////

if($num_succ==count($cart)){
	$process = true;
}
if($process==false){
	unset($_SESSION["cart"]);
$_SESSION["errors"] = $errors;
	?>	
<script>
	window.location="index.php?view=sell";
</script>
<?php
}




}else {

$found = false;
$cart = $_SESSION["cart"];
$index=0;






$can = true;

if($can==false){
$_SESSION["errors"] = $errors;
	?>	
<script>
	window.location="index.php?view=sell";
</script>
<?php
}
?>

<?php
if($can==true){
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
}

if($found==false){
    $nc = count($cart);
	$product = array("product_id"=>$_POST["product_id"],"q"=>$_POST["q"]);
	$cart[$nc] = $product;
	$_SESSION["cart"] = $cart;
}

}
}
 print "<script>window.location='index.php?view=sell';</script>";
// unset($_SESSION["cart"]);

?>