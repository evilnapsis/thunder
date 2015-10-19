<?php
$product = ProductData::getById($_GET["id"]);
if($product!=null):
?>
<section class="content-header">
    <h1><?php echo $product->name ?> <small>Editar Producto</small></h1>
</section>
<section class="content">
<div class="row">
	<div class="col-md-12">
  <?php if(isset($_COOKIE["prdupd"])):?>
    <p class="alert alert-info">La informacion del producto se ha actualizado exitosamente.</p>
  <?php setcookie("prdupd","",time()-18600); endif; ?>
		<form class="form-horizontal" method="post" id="addproduct" action="index.php?view=updateproduct" role="form">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Codigo*</label>
    <div class="col-md-6">
      <input type="text" name="code" class="form-control" id="name" value="<?php echo $product->code; ?>" placeholder="Codigo del Producto">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
    <div class="col-md-6">
      <input type="text" name="name" class="form-control" id="name" value="<?php echo $product->name; ?>" placeholder="Nombre del Producto">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Descripcion</label>
    <div class="col-md-6">
      <textarea name="description" class="form-control" id="name" placeholder="Descripcion del Producto"><?php echo $product->description; ?></textarea>
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Peparacion</label>
    <div class="col-md-6">
      <textarea name="preparation" class="form-control" id="name" placeholder="Peparacion del Producto"><?php echo $product->preparation; ?></textarea>
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Precio*</label>
    <div class="col-md-6">
      <input type="text" name="price_out" class="form-control" id="price_out" value="<?php echo $product->price_out; ?>" placeholder="Precio">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Duracion*</label>
    <div class="col-md-6">
      <input type="text" name="duration" class="form-control" id="unit" value="<?php echo $product->duration; ?>" placeholder="Tiempo de preparacion del Producto">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Unidad*</label>
    <div class="col-md-6">
      <input type="text" name="unit" class="form-control" id="unit" value="<?php echo $product->unit; ?>" placeholder="Unidad del Producto">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Categoria</label>
    <div class="col-md-6">
<select name="category_id" class="form-control" id="category_id">
  <option value="">-- SELECCIONE CATEGORIA --</option>
<?php foreach(CategoryData::getAll() as $cat):?>
  <option value="<?php echo $cat->id; ?>" <?php if($product->category_id==$cat->id){ echo "selected";}?>><?php echo $cat->name; ?></option>
<?php endforeach; ?>
</select>
    </div>
  </div>
  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-6">
      <div class="checkbox">
        <label>
          <input type="checkbox" name="use_ingredient" <?php if($product->use_ingredient){ echo "checked";}?>> Usar Ingredientes
        </label>
      </div>
    </div>
  </div>
<p class="alert alert-info">* Campor obligatorios: Nombre, Precio de Salida, Unidad</p>

  <div class="form-group">
    <div class="col-lg-offset-3 col-lg-9">
    <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
      <button type="submit" class="btn  btn-success">Actualizar Producto</button>
    </div>
  </div>
</form>
<script>
  $("#addproduct").submit(function(e){
    if($("#name").val()!="" &&  $("#price_out").val()!="" && $("#unit").val()!="" ){

    }else{
    e.preventDefault();
    alert("No debes dejar campos vacios.");
  }

  });
</script>

<br><br><br><br><br><br><br><br><br>
	</div>
</div>
<?php endif; ?>
</section>