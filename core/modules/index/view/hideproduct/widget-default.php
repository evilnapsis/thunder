<?php

$cat = ProductData::getById($_GET["id"]);
$cat->hide();

Core::redir("index.php?view=hideproducts");
?>