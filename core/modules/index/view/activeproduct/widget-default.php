<?php

$cat = ProductData::getById($_GET["id"]);
$cat->active();

Core::redir("index.php?view=products");
?>