<?php

if(Session::getUID()!=""){
	$post = PostData::getById($_GET["post_id"]);
	$post->del();
	print "<script>window.location='index.php?view=slider';</script>";
}

?>