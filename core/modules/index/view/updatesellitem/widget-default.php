<?php

// print_r($_POST);

$operation = OperationData::getById($_POST["operation_id"]);
$operation->q = $_POST["q"];
$operation->add_q();

header("Location: index.php?view=onesell&id=".$_POST["sell_id"]);

?>