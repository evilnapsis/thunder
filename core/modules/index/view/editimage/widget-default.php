<?php

$image= ImageData::getById($_GET['id']);

?>
<div style='background:rgba(255,255,255,0.3);'>
<div class='row'>
<div class='span10'>
<a href='index.php?module=viewalbum&alid=<?php echo $image->album_id;?>' class='btn pull-right'><i class='fa fa-arrow-left'></i> Regresar</a>
<h2 class='roboto'><?php echo $image->title;?> <small>Editar imagen</small></h2>
<form enctype="multipart/form-data" method='post' action='add.php' class='form-horizontal'  id='form_upload'>
<center>
<img id='preview' style='width:50%;' src="<?php echo "storage/images/albums/$image->album_id/$image->image"; ?>"></center>
  <div class="control-group">
    <label class="control-label" for="inputEmail"></label>
    <div class="controls">
      <input type="file" name='image' id="inputImage" placeholder="Email">
      <input type="hidden" name='reference' value='updateimage'>
      <input type="hidden" name='image_id' value='<?php echo $_GET['id']; ?>'>

    </div>
  </div>
  <div class="control-group" id='title'>
    <label class="control-label" for="inputEmail">Titulo</label>
    <div class="controls">
      <input type="text" name='title' id="input_title" style='width:100%;' placeholder="Titulo de la imagen" value ="<?php echo $image->title; ?>">
<span class='help-inline' id='title_control'>Debes escribir un titulo al al Bum.</span>
    </div>
  </div>
  <div class="control-group" id='description'>
    <label class="control-label" for="inputPassword">Descripcion</label>
    <div class="controls">
    <textarea name='description' style='width:280px;' class='summernote' id='input_description' placeholder='Descripcion de la imagen'><?php echo $image->description; ?></textarea>
<span class='help-inline' id='description_control'>Debes escribir una descripcion a la imagen.</span>
    </div>
  </div>

<script>
  function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#preview').attr('src', e.target.result);
              console.log(e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#inputImage").change(function(){
    readURL(this);
});
</script>

<div class="form-actions">
  <button type="submit" class="btn btn-primary">Publicar Articulo</button>
  <button type="button" class="btn">Guardar Como Borrador</button>
</div>

</form>
<br><br></div>

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
</div>
<script>
title = $("#title");
input_title = $("#input_title");
description = $("#description");
input_description = $("#input_description");
tags = $("#tags");
input_tags = $("#input_tags");
// $(".note-editable").html()

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
</div>