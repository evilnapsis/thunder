<?php
        	$image = PostData::getById($_POST['post_id']);
        	$image->title = $_POST['title'];
        	$image->user_id = Session::getUID();
        	$image->update();
			print "<script>window.location='index.php?view=slider';</script>";
//		}
?>