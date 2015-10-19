<?php
$spent = SpentData::getById($_GET["id"]);
// print_r($spent);
 $spent->del();
 Core::redir("index.php?view=spents");
// print "<script>w</script>";

?>