<?php

//print_r($_GET);

$operation = OperationData::getById($_GET["id"]);
$operation->del();

print "<script>window.location='index.php?view=dayli';</script>";

?>