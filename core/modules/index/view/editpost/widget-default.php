<section class="content">
<?php if(Session::getUID()!=""):
$post = PostData::getById($_GET['id']);
?>
<?php if($post!=null):?>
<div class='row'>
<div class='col-md-10'>
<a href='index.php?module=dashboard' class='btn pull-right'><i class='icon-tasks'></i></a>
<h2 class='roboto'><?php echo $post->title; ?> <small>Editar</small></h2>

<form enctype="multipart/form-data" method='post' action='index.php?view=updatepost' class='form-horizontal'  id='form_upload'>


  <div class="control-group" id='title'>
    <label class="control-label" for="inputEmail">* Título</label>
    <div class="controls">
      <input type="text" name='title' id="input_title" style='width:100%;' placeholder="Titulo de la publicacion" value='<?php echo $post->title;?>'>
<span class='help-inline' id='title_control'>* Debes escribir un titulo a la publicacion.</span>
    </div>
  </div>
<?php if($post->image==""):?>
  <div class="control-group">
    <label class="control-label" for="inputEmail"></label>
    <div class="controls">
      <input type="file" name='image' id="inputEmail" placeholder="Email">
      <input type="hidden" name='reference' value='updatepost'>
      <input type="hidden" name='post_id' value='<?php echo $_GET['id']; ?>'>
    </div>
  </div>
<?php else:?>
<br> <img src="storage/images/<?php echo $post->image; ?>" class="img-responsive">
<?php endif; ?>
  <div class="control-group">
    <label class="" for=""></label>
    <div class="controls">
<p class='alert alert-info'>Los campos marcados con asteriscos (*) son obligatorios.</p>
    </div>
  </div>  
  <div class="control-group">
    <div class="controls">

      <input type="hidden" name='post_id' value='<?php echo $_GET['id']; ?>'>
      <button type="submit" class="btn btn-primary">Actualizar Imagen</button>
      <a href="index.php?view=delpost&post_id=<?php echo $_GET["id"]; ?>" class="btn btn-danger">Eliminar Imagen</a>
    </div>
  </div>
</form>
<div class='jumbotron' style='background:url(stardust.png);'>
<center>
<?php if($post->image!=""):?>
<tr>
<div class='post'>
<?php if($post->is_slide==0):?>
<div class=''><form method="post" action="index.php?view=addslide">
  <input type='hidden' name='post_id' value="<?php echo $post->id; ?>">
<input type='submit' value="Agregar Slide" class='btn btn-large btn-primary'>
</form></div>
<?php else:?>
<div class=''><form method="post" action="index.php?view=delslide">
  <input type='hidden' name='post_id' value="<?php echo $post->id; ?>">
<input type='submit' value="Eliminar Slide" class='btn btn-large btn-danger'>
</form></div>
<?php endif; ?>
<?php endif; ?>
  
</div>
</center>
</div></div>
<?php endif;?>
<?php endif;?>

<script type="text/javascript">
  less = {
    env: "development", // or "production"
    async: false,       // load imports async
    fileAsync: false,   // load imports async when in a page under
    // a file protocol
    poll: 1000,         // when in watch mode, time in ms between polls
    functions: {},      // user functions, keyed by name
    dumpLineNumbers: "comments", // or "mediaQuery" or "all"
    relativeUrls: false,// whether to adjust url's to be relative
    // if false, url's are already relative to the
    // entry less file
    rootpath: ":/a.com/"// a path to add on to the start of every url
    //resource
  };
</script>
<script src="//cdnjs.cloudflare.com/ajax/libs/less.js/1.3.3/less.min.js" type="text/javascript"></script>


<script>
title = $("#title");
input_title = $("#input_title");
description = $("#description");
input_description = $("#input_description");
tags = $("#tags");
input_tags = $("#input_tags");

/*input_folio.keypress(function(e){
  if(e.keyCode==48 ||e.keyCode==49 || e.keyCode==50 || e.keyCode==51|| e.keyCode==52|| e.keyCode==53|| e.keyCode==54|| e.keyCode==55|| e.keyCode==56|| e.keyCode==57){

  }else{
  e.preventDefault();    
  }

});*/

      title_control = $("#title_control");
      description_control = $("#description_control");
      tags_control = $("#tags_control");

      title_control.hide();
      description_control.hide();
      tags_control.hide();

$("#form_upload").submit(function(e){

//$("#input_description").val($(".note-editable").html());


    if(input_title.val()==""|| input_description.val()==""|| input_tags.val()==""){
    e.preventDefault();
    if(input_title.val()==""){
      title.addClass("error");
      title_control.show();
    }else{
      title.removeClass("error");
      title_control.hide();
    }

    if(input_description.val()==""){
      description.addClass("error");
      description_control.show();
    }else{
      description.removeClass("error");
      description_control.hide();
    }
    if(input_tags.val()==""){
      tags.addClass("error");
      tags_control.show();
    }else{
      tags.removeClass("error");
      tags_control.hide();
    }

  }

});

</script>
</section>