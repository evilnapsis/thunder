<?php 
$ingredients = IngredientData::getAll();
$operations = ProductIngredientData::getAllByProductId($_GET["id"]);
?>
<div class="content">
<h1>Ingredientes</h1>
<?php if(isset($_GET["id"]) && $_GET["id"]!=""):?>

<a data-toggle="modal" href="#myModal" class="btn btn-default"><i class="glyphicon glyphicon-plus-sign"></i> Agregar Ingrediente</a>

  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Agregar Ingrediente</h4>
        </div>
        <div class="modal-body">
         <form class="form-horizontal" method="post" action="index.php?view=addproductingredient" role="form">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Ingrediente</label>
    <div class="col-lg-10">
<select name="ingredient_id" class="form-control" required>
		<option value="">-- INGREDIENTES -- </option>
	<?php foreach($ingredients as $product):?>
		<option value="<?php echo $product->id; ?>" ><?php echo $product->name; ?></option>
	<?php endforeach ; ?>
</select>
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword1" class="col-lg-2 control-label">Cantidad</label>
    <div class="col-lg-10">
      <input type="text" class="form-control" name="q" id="inputPassword1" required placeholder="Cantidad">
    </div>
  </div>
  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <div class="checkbox">
        <label>
          <input type="checkbox" name="is_required"> Es obligatorio
        </label>
      </div>
    </div>
  </div>

  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
    <input type="hidden" name="product_id" value="<?php echo $_GET["id"];?>">
      <button type="submit" class="btn btn-primary">Agregar Producto</button>
    </div>
  </div>
</form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

<br>

<br>
<?php if(count($operations)>0):?>
<table class="table table-bordered table-hover">
	<thead>
		<th>Codigo</th>
		<th>Cantidad</th>
		<th>Nombre del Producto</th>
    <th>Obligatorio</th>
    <th></th>

	</thead>
<?php
	foreach($operations as $operation){
		$product  = $operation->getIngredient();
?>
<tr>
	<td><?php echo $product->code ;?></td>
	<td><?php echo $operation->q ;?></td>
	<td><?php echo $product->name ;?></td>
  <td style="width:100px;"><?php if($product):?> <i class="fa fa-check"></i> <?php endif; ?></td>
  <td style="width:90px;">
    <a class="btn btn-warning btn-xs" data-toggle="modal" href="#updateSell-<?php echo $product->id; ?>"><i class="glyphicon glyphicon-pencil"></i> </a>
<?php if(Session::getUID()):?>
    <a href="index.php?view=delproductingredient&operation_id=<?php echo $operation->id; ?>&sell_id=<?php echo $_GET["id"]; ?>" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> </a>
<?php endif; ?>
  <!-- Button trigger modal -->

  <!-- Modal -->
  <div class="modal fade" id="updateSell-<?php echo $product->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Actualizar: <?php echo $product->name ;?></h4>
        </div>
        <div class="modal-body">
<form class="form-horizontal" method="post" action="index.php?view=updateproductingredient" role="form">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Producto</label>
    <div class="col-lg-10">
      <input type="text" class="form-control" id="inputEmail1" placeholder="Producto" value="<?php echo $product->name ;?>">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword1" class="col-lg-2 control-label">Cantidad</label>
    <div class="col-lg-10">
      <input type="text" class="form-control" id="inputPassword1" name="q" placeholder="Cantidad" value="<?php echo $operation->q ;?>">
    </div>
  </div>
  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <div class="checkbox">
        <label>
          <input type="checkbox" name="is_required"> Es obligatorio
        </label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
    <input type="hidden" name="ingredient_id" value="<?php echo $product->id; ?>">
    <input type="hidden" name="operation_id" value="<?php echo $operation->id; ?>">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Actualizar</button>
    </div>
  </div>
</form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  </td>
</tr>
<?php
	}
	?>
</table>
<?php else:?>
  <p class="alert alert-warning">No hay ingredientes</p>
<?php endif; ?>
<?php endif; ?>
</div>