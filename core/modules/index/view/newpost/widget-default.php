<div class="content-header">
  <h1 class='roboto'>Agregar Imagen</h1>
</div>
<section class="content">
<br><div class='row'>
<div class='col-md-8'>
<script>
  $("#playtour").click(function(){
  hopscotch.startTour(tour);
  });
</script>
<form enctype="multipart/form-data" method='post' action='index.php?view=addpost' class='form-horizontal'  id='form_upload'>


  <div class="control-group" id='title'>
    <label class="control-label" for="inputEmail">* T&iacute;tulo</label>
    <div class="controls">
      <input type="text" name='title' required id="input_title" style='width:100%;' class="form-control" placeholder="Titulo de la publicacion">
<span class='help-inline' id='title_control'>Debes escribir un t&iacute;tulo a la publicacion.</span>
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputEmail"></label>
    <div class="controls">
      <input type="file" name='image' class='file-input' required id="input_image" placeholder="Email">
      <input type="hidden" name='reference' value='addpost'>
    </div>
  </div>

  <div class="control-group">
    <label class="" for=""></label>
    <div class="controls">
<p class='alert alert-info'>Los campos marcados con asteriscos (*) son obligatorios.</p>
    </div>
  </div>    

<div class="form-actions">
  <button type="submit" class="btn btn-primary" id='publish'>Publicar Articulo</button>
</div>

</form>
<script>
   // Define the tour!
  var tour = {
    id: "hello-hopscotch",
    steps: [
      {
        title: "Titulo",
        content: "Aqui inserte el titulo de la publicacion",
        target: "input_title",
        placement: "bottom",
        showPrevButton: true
      },
      {
        title: "Description",
        content: "inserte la descripcion de la publicacion.",
        target: "description_c",
        placement: "bottom",
        showPrevButton: true
      },
      {
        title: "Insertar Imagen",
        content: "Inserte una imagen para la publicacion.",
        target: "input_image",
        placement: "bottom",
        showPrevButton: true
      },
      {
        title: "Insetar Etiquetas",
        content: "Insertar etiquetas para la publicacion.",
        target: "input_tags",
        placement: "bottom",
        showPrevButton: true
      },
      {
        title: "Insetar enlace",
        content: "Inserte un enlace en la publicacion.",
        target: "input_link",
        placement: "bottom",
        showPrevButton: true
      },
      {
        title: "Insetar Video",
        content: "Inserte el link de un video de Youtube.",
        target: "input_video",
        placement: "bottom",
        showPrevButton: true
      },
      {
        title: "Seleccionar Categoria",
        content: "Seleccione una categoria para la publicacion.",
        target: "input_category",
        placement: "bottom",
        showPrevButton: true
      },
      {
        title: "Publicar Articulo",
        content: "Click aqui para publicar el articulo",
        target: "publish",
        placement: "bottom",
        showPrevButton: true
      }
    ]
  };

  // Start the tour!
  // hopscotch.startTour(tour);
</script>

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

// $("#input_description").val($(".note-editable").html());

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