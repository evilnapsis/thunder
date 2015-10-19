<?php

// print_r($_POST);
$operation = new OperationData();
$operation->product_id = $_POST["product_id"];
$operation->operation_type_id =1;
$operation->is_oficial =1;
$operation->q = $_POST["q"];
$operation->sell_id = $_POST["sell_id"];
$operation->add();

header("Location: index.php?view=onesell&id=$_POST[sell_id]");
// header("Location: index.php?view=categories");

?>
