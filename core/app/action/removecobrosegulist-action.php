<?php

if(isset($_SESSION['cobro_seguridad'])){

$n = $_GET['cnt'];
$list = $_SESSION['cobro_seguridad'];

if(count($list)==1){
	unset($_SESSION['cobro_seguridad']);
}else{
	$newdata = array();
	$cnt=0;
	foreach($list as $li){
		if($n!=$cnt){
		$newdata[] = $li;
		}
		$cnt++;
	}

	$_SESSION["cobro_seguridad"] = $newdata;
}

}

Core::redir("./?view=cobrosseguridad&opt=new&cat_seguridad_id=".$_GET["cat"]);
?>