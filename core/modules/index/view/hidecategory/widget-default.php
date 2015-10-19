<?php

$cat = CategoryData::getById($_GET["id"]);
$cat->hide();

Core::redir("index.php?view=hidecategories");
?>