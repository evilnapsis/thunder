<?php

$alumn = UserData::getById($_GET["id"]);
$alumn->del();
header("Location: index.php?view=users");


?>