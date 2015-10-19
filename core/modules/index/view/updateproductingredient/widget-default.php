<?php

// print_r($_POST);

$operation = ProductIngredientData::getById($_POST["operation_id"]);
$operation->q = $_POST["q"];
$operation->is_required = isset($_POST["is_required"]) ? 1 :0 ;

$operation->update();

header("Location: index.php?view=productingredients&id=".$operation->product_id);

?>