<?php
$current = CutData::getCurrent();

if($current==null){
	$cut = new CutData();
	$cut->add();
}else{
	setcookie("cut","therecurrent");
}
	print "<script>window.location='index.php?view=cuts';</script>";

?>