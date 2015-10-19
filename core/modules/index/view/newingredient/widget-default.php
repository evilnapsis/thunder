<section class="content-header">
  <h1>Agregar Ingrediente</h1>
</section>
<section class="content">
<div class="row">
	<div class="col-md-8 col-md-offset-2">

<div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"></h3>
                                </div>
                                <div class="box-body table-responsive">		<form class="form-horizontal" method="post" id="addproduct" action="index.php?view=addingredient" role="form">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-3 control-label">Codigo*</label>
    <div class="col-md-8">
      <input type="text" name="code" class="form-control" id="name" placeholder="Codigo del Ingrediente">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-3 control-label">Nombre*</label>
    <div class="col-md-8">
      <input type="text" name="name" class="form-control" id="name" placeholder="Nombre del Ingrediente">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-3 control-label">Precio*</label>
    <div class="col-md-8">
      <input type="text" name="price_out" class="form-control " id="price_out" placeholder="Precio de salida">
    </div>
  </div>


  <div class="form-group">
    <label for="inputEmail1" class="col-lg-3 control-label">Unidad*</label>
    <div class="col-md-8">
      <input type="text" name="unit" class="form-control " id="unit" placeholder="Unidad del Ingrediente">
    </div>
  </div>



<p class="alert alert-info">* Campor obligatorios: Nombre</p>

  <div class="form-group">
    <div class="col-lg-offset-3 col-lg-9">
      <button type="submit" class="btn btn-primary">Agregar Ingrediente</button>
    </div>
  </div>
</form>
</div>
</div>


<br><br><br><br><br><br><br><br><br>
	</div>
</div>
</section>