<div class="row">
	<div class="col-md-8">
	<h1>Agregar Gasto</h1>
	<br><br>
		<form class="form-horizontal" method="post" id="addproduct" action="index.php?view=addspent" role="form">

  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Concepto*</label>
    <div class="col-md-6">
      <input type="text" name="name" class="form-control" id="name" placeholder="Escriba el concepto">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Costo*</label>
    <div class="col-md-6">
      <input type="text" name="price_out" class="form-control" id="price_out" placeholder="Agregar costo">
    </div>
  </div>

<p class="alert alert-info">* Campor obligatorios: Nombre, Costo</p>

  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <button type="submit" class="btn btn-primary">Agregar gasto</button>
    </div>
  </div>
</form>
<script>
  $("#addproduct").submit(function(e){
    if($("#name").val()!=""  && $("#price_out").val()!="" ){

    }else{
    e.preventDefault();
    alert("No debes dejar campos vacios.");
  }

  });
</script>

<br><br><br><br><br><br><br><br><br>
	</div>
</div>