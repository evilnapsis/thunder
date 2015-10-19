<?php

$grade = CategoryData::getById($_GET["id"]);
$name = $grade->name;
$grade->del();

setcookie("gradedeleted",$name);
header("Location: index.php?view=categories");

?>