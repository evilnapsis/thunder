<?php
if(Session::getUID()!=""){
        $handle = new Upload($_FILES['image']);
            $post = new PostData();
        if ($handle->uploaded) {
            $url = "storage/images/";
            $handle->Process($url);
            $post->image = $handle->file_dst_name;
        }
            $content = "";
            $post->title = $_POST['title'];
            $post->content = "";
            $post->user_id = Session::getUID();
            $x = $post->add();

//            setcookie("postadded",$x[1]);
//            print "<script>window.location='index.php?module=editpost&id=$x[1]';</script>";
            print "<script>window.location='index.php?view=slider';</script>";
}
?>