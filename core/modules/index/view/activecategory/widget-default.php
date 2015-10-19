<?php

$cat = CategoryData::getById($_GET["id"]);
$cat->active();

Core::redir("index.php?view=categories");
?>