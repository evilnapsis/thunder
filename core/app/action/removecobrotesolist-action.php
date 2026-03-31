<?php

if(isset($_SESSION['cobro_tesoreria'])){

$n = $_GET['cnt'];
$list = $_SESSION['cobro_tesoreria'];

if(count($list)==1){
	unset($_SESSION['cobro_tesoreria']);
}else{
	$newdata = array();
	$cnt=0;
	foreach($list as $li){
		if($n!=$cnt){
		$newdata[] = $li;
		}
		$cnt++;
	}

	$_SESSION["cobro_tesoreria"] = $newdata;
}

}

Core::redir("./?view=cobrostesoreria&opt=new&cat_tesoreria_id=".$_GET["cat"]);
?>