<?php

print_r($_POST);

$spent = new SpentData();
$spent->q = $_POST["q"];
$spent->name = $_POST["name"];
$spent->unit = $_POST["unit"];
$spent->price = $_POST["price_out"];
$spent->category_id = $_POST["category_id"];
$spent->add();

 header("Location: index.php?view=spents");

?>