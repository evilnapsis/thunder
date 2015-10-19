<section class="content-header">
  <h1>Agregar Producto</h1>
</section>
<section class="content">
<div class="row">
	<div class="col-md-12">

<div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"></h3>
                                </div>
                                <div class="box-body table-responsive">		<form class="form-horizontal" method="post" id="addproduct" action="index.php?view=newproduct" role="form">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-3 control-label">Codigo*</label>
    <div class="col-md-8">
      <input type="text" name="code" class="form-control" id="name" placeholder="Codigo del Producto">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-3 control-label">Nombre*</label>
    <div class="col-md-8">
      <input type="text" name="name" class="form-control" required id="name" placeholder="Nombre del Producto">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-3 control-label">Descripcion*</label>
    <div class="col-md-8">
      <textarea name="description" class="form-control" id="name" placeholder="Descripcion del Producto"></textarea>
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-3 control-label">Peparacion*</label>
    <div class="col-md-8">
      <textarea name="preparation" class="form-control" id="name" placeholder="Peparacion del Producto"></textarea>
    </div>
  </div>

  <div class="form-group">
    <label for="inputEmail1" class="col-lg-3 control-label">Precio*</label>
    <div class="col-md-8">
      <input type="text" name="price_out" class="form-control " required id="price_out" placeholder="Precio de salida">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-3 control-label">Duracion*</label>
    <div class="col-md-8">
      <input type="text" name="duration" class="form-control " id="unit" placeholder="Tiempo de preparacion del Producto (mins)">
    </div>
  </div>

  <div class="form-group">
    <label for="inputEmail1" class="col-lg-3 control-label">Unidad*</label>
    <div class="col-md-8">
      <input type="text" name="unit" class="form-control " required id="unit" placeholder="Unidad del Producto">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-3 control-label">Categoria</label>
    <div class="col-md-8">
<select name="category_id" class="form-control " required id="category_id">
  <option value="">-- SELECCIONE CATEGORIA --</option>
<?php foreach(CategoryData::getAll() as $cat):?>
  <option value="<?php echo $cat->id; ?>"><?php echo $cat->name; ?></option>
<?php endforeach; ?>
</select>
    </div>
  </div>
  <div class="form-group">
    <div class="col-lg-offset-3 col-lg-9">
      <div class="checkbox">
        <label>
          <input type="checkbox" name="use_ingredient"> Usar Ingredientes
        </label>
      </div>
    </div>
  </div>



<p class="alert alert-info">* Campor obligatorios: Nombre, Precio, Unidad, Categoria</p>

  <div class="form-group">
    <div class="col-lg-offset-3 col-lg-9">
      <button type="submit" class="btn btn-primary">Agregar Producto</button>
    </div>
  </div>
</form>
</div>
</div>


<br><br><br><br><br><br><br><br><br>
	</div>
</div>
</section>