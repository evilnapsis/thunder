<?php

if(isset($_SESSION['cobro_list'])){

$n = $_GET['cnt'];
$list = $_SESSION['cobro_list'];

if(count($list)==1){
	unset($_SESSION['cobro_list']);
}else{
	$newdata = array();
	$cnt=0;
	foreach($list as $li){
		if($n!=$cnt){
		$newdata[] = $li;
		}
		$cnt++;
	}

	$_SESSION["cobro_list"] = $newdata;
}

}

Core::redir("./?view=cobrosagua&opt=new");
?>