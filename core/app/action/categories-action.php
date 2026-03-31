<?php
if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
	if(count($_POST)>0){
		$grade = new CategoryData();
		$grade->name = $_POST["name"];
		$grade->add();
		setcookie("gradeadded",$_POST["name"]);
		header("Location: index.php?view=categories&opt=all");
	}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
	if(count($_POST)>0){
		$user = CategoryData::getById($_POST["user_id"]);
		$user->name = $_POST["name"];
		$user->update();
		setcookie("gradeupdated",$_POST["name"]);
		header("Location: index.php?view=categories&opt=all");
	}
}
else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
	$grade = CategoryData::getById($_GET["id"]);
	$name = $grade->name;
	$grade->del();
	setcookie("gradedeleted",$name);
	header("Location: index.php?view=categories&opt=all");
}
?>