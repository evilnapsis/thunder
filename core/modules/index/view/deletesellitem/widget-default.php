<?php

// print_r($_POST);

$operation = OperationData::getById($_GET["operation_id"]);
$operation->del();

header("Location: index.php?view=onesell&id=".$_GET["sell_id"]);

?>