<section class="content">
<?php if(Session::getUID()!=""):?>
<br><div class='row'>
  <div class='col-md-9'>
<div class='btn-group pull-right'>
</div>
<script>
  $("#playtour").click(function(){
  hopscotch.startTour(tour);
  });
</script>
		<div class='f28 roboto' id='title'>Slider</div><br>
<p class='alert alert-info'>Aqui se seleccionan los articulos que se destacaran en el slider principal. Puede Seleccionar entre 3 y 10 articulos que contengan imagen.</p>

<?php 

if(isset($_COOKIE['slideadded'])&&$_COOKIE['slideadded']!=""):
$post = PostData::getById($_COOKIE['slideadded']);
?>
  <p class='alert alert-info'><i class='icon-ok'></i> Se ha agregado en el slider exitosamente la publicacion: <b><?php echo $post->title; ?></b></p>

<?php 
setcookie("slideadded","",time()-18600);
unset($_COOKIE['slideadded']);
endif; ?>

<?php 

if(isset($_COOKIE['slidedeleted'])&&$_COOKIE['slidedeleted']!=""):
$post = PostData::getById($_COOKIE['slidedeleted']);
?>
  <p class='alert alert-info'><i class='icon-trash'></i> Se ha eliminado en el slider exitosamente la publicacion: <b><?php echo $post->title; ?></b></p>

<?php 
setcookie("slidedeleted","",time()-18600);
unset($_COOKIE['slidedeleted']);
endif; ?>


    <br>
<?php
// $posts = PostData::getAllByUser(Session::getUID());
 $posts = PostData::getPosts();
 $slides = 0;
if(count($posts)>0):?>
<div class='posts' id='posts'>
<table class="table table-bordered">
<?php foreach($posts as $post):?>
<tr>
<td><div class='title'><a href='index.php?view=editpost&id=<?php echo $post->id;?>'><?php echo $post->title;?> <?php if($post->image!="") { echo "<i class='icon-picture'></i>";}?></a>
</td>
<td>
<?php if($post->image!=""):$slides++; ?>
<div class='post'>
<?php if($post->is_slide==0):?>
<div class='pull-right'><form method="post" action="index.php?view=addslide">
  <input type='hidden' name='post_id' value="<?php echo $post->id; ?>">
<input type='submit' value="Agregar Slide" class='btn btn-primary'>
</form></div>
<?php else:?>
<div class='pull-right'><form method="post" action="index.php?view=delslide">
  <input type='hidden' name='post_id' value="<?php echo $post->id; ?>">
<input type='submit' value="Eliminar Slide" class='btn btn-danger'>
</form></div>
</div>
<?php endif; ?>
</td>


</tr>
<?php endif; ?>
<?php endforeach;?>
</table>
</div>
<?php else:?>
  <div class='hero-unit' id='noslide'>
    <h2>No hay articulos</h2>
    <p>No has publicado articulos, para empezar una publicacion al haz click en el boton "Nuevo Articulo" en la parte superior.</p>
  </div>
<?php endif; ?>
	</div>
</div>
<?php endif; ?>
<script>
   // Define the tour!
  var tour = {
    id: "hello-hopscotch",
    steps: [
      {
        title: "Control de Slider",
        content: "Desde este sistema podras manejar los slides que se mostraran en la parte superior de la pagina principal.",
        target: "title",
        placement: "bottom",
        showPrevButton: true
      },
      {
        title: "No hay Articulos",
        content: "Debes crear articulos en la seccion de \"Articulos\"",
        target: "noslide",
        placement: "top",
        showPrevButton: true
      },
      {
        title: "Lista de Articulos",
        content: "la listas de articulos validos para agregar como Slide",
        target: "posts",
        placement: "top",
        showPrevButton: true
      }

    ]
  };

  // Start the tour!
  // hopscotch.startTour(tour);
</script>
</section>