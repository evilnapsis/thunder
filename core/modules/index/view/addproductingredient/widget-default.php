<?php

// print_r($_POST);
$operation = new ProductIngredientData();
$operation->product_id = $_POST["product_id"];
$operation->is_required = 1;
$operation->ingredient_id = $_POST["ingredient_id"];
$operation->q = $_POST["q"];
$operation->is_required = isset($_POST["is_required"]) ? 1 :0 ;
$operation->add();

header("Location: index.php?view=productingredients&id=$_POST[product_id]");
// header("Location: index.php?view=categories");

?>
