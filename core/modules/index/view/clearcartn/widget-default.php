<?php
if(isset($_GET["product_id"])){
	$cart=$_SESSION["cartn"];
	if(count($cart)==1){
	 unset($_SESSION["cartn"]);
	}else{
		$ncart = null;
		$nx=0;
		foreach($cart as $c){
			if($c["product_id"]!=$_GET["product_id"]){
				$ncart[$nx]= $c;
			}
			$nx++;
		}
		$_SESSION["cartn"] = $ncart;
	}

}else{
 unset($_SESSION["cartn"]);
}

print "<script>window.location='index.php?view=selln';</script>";

?>