<section class="content-header">
		<h1>Venta</h1>
</section>
<section class="content">

<div class="row">
	<div class="col-md-12">
                                        
<!--	<a href="index.php?view=selln" class="btn btn-default btn-lg pull-right">Venta sin factura <i class="glyphicon glyphicon-chevron-right"></i></a> -->

	<p><b>Buscar producto por nombre o por codigo:</b></p>
		<form>
		<div class="row">
			<div class="col-md-6">
				<input type="hidden" name="view" value="sell">
				<input type="text" name="product" class="form-control">
			</div>
			<div class="col-md-3">
			<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Buscar</button>
			</div>
		</div>
		</form>


<?php if(isset($_GET["product"])):?>
	<?php
$products = ProductData::getActiveLike($_GET["product"]);
if(count($products)>0){
	?>
<h3>Resultados de la Busqueda</h3>
<table class="table table-bordered table-hover">
	<thead>
		<th>Codigo</th>
		<th>Nombre</th>
		<th>Unidad</th>
		<th>Precio unitario</th>
		<th>Cantidad</th>
		<th style="width:100px;"></th>
	</thead>
	<?php
$products_in_cero=0;
	 foreach($products as $product):
$q= ProductData::getAllActive();
	?>
	<?php 
	if($q>0):?>
		<form method="post" action="index.php?view=addtocart">
	<tr class="<?php if($q<=5){ echo "danger"; }?>">
		<td style="width:80px;"><?php echo $product->id; ?></td>
		<td><?php echo $product->name; ?></td>
		<td><?php echo $product->unit; ?></td>
		<td><b>$<?php echo $product->price_out; ?></b></td>
		<td>
		<input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
		<input type="" class="form-control" required name="q" placeholder="Cantidad de producto ..."></td>
		<td style="width:183px;">
		<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-shopping-cart"></i> Agregar a la venta</button>
		</td>
	</tr>
	</form>
<?php else:$products_in_cero++;
?>
<?php  endif; ?>
	<?php endforeach;?>
</table>
<?php if($products_in_cero>0){ echo "<p class='alert alert-warning'>Se omitieron <b>$products_in_cero productos</b> que no tienen existencias en el inventario. <a href='index.php?module=inventary'>Ir al Inventario</a>"; }?>

	<?php
}else { echo "<p class='alert alert-warning'>No hay resultados en la busqueda.</p>"; }
?>
<br><hr>
<hr><br>
<?php else:
?>

<?php endif; ?>

<?php if(isset($_SESSION["errors"])):?>
<h2>Errores</h2>
<p></p>
<table class="table table-bordered table-hover">
<tr class="danger">
	<th>Codigo</th>
	<th>Producto</th>
	<th>Mensaje</th>
</tr>
<?php foreach ($_SESSION["errors"]  as $error):
$product = ProductData::getById($error["product_id"]);
?>
<tr class="danger">
	<td><?php echo $product->id; ?></td>
	<td><?php echo $product->name; ?></td>
	<td><b><?php echo $error["message"]; ?></b></td>
</tr>

<?php endforeach; ?>
</table>
<?php
unset($_SESSION["errors"]);
 endif; ?>


<!--- Carrito de compras :) -->
<?php if(isset($_SESSION["cart"])):
$total = 0;
?>
<h2>Lista de venta</h2>

<form method="post" action="index.php?view=processsell" class="form-horizontal" id="process">
  <div class="form-group">
    <div class="col-lg-3">
    <label for="inputEmail1" class="control-label">Personas</label>
	<input type="number" min="1" value="1" name="q" id="theq" class="form-control" placeholder="Personas">

    </div>
    <div class="col-lg-3">
    <label for="inputEmail1" class="control-label">No. Mesa</label>
	<select class="form-control" required name="mesa" id="mesa">
			<option value=""> -- No. MESA -- </option>
		<?php foreach(ItemData::getAll() as $item):?>
			<option value="<?php echo $item->id; ?>"> <?php echo $item->name; ?> </option>
		<?php endforeach; ?>
			</select>

    </div>
    <div class="col-lg-3">
    <label for="inputPassword1" class="control-label">Mesero</label>
	<select class="form-control" id="mesero" name="mesero_id" required>
			<option value=""> -- SELECCIONE MESERO-- </option>
		<?php foreach (Userdata::getAllMeseros() as $mesero):?>
			<option value="<?php echo $mesero->id; ?>"> <?php echo $mesero->name." ".$mesero->lastname; ?> </option>
		<?php endforeach; ?>
			</select>
    </div>
    <div class="col-lg-3">
    <label for="inputEmail1" class="control-label">Finalizar</label><br>
        <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-usd"></i><i class="glyphicon glyphicon-usd"></i> Finalizar Venta</button>
        </div>


  </div>
</form>

<div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"></h3>
                                </div>
                                <div class="box-body table-responsive">
<table class="table table-bordered table-hover datatable">
<thead>
	<th style="width:30px;">Codigo</th>
	<th style="width:30px;">Cantidad</th>
	<th style="width:30px;">Unidad</th>
	<th>Producto</th>
	<th style="width:30px;">Precio Unitario</th>
	<th style="width:30px;">Precio Total</th>
	<th ></th>
</thead>
<?php foreach($_SESSION["cart"] as $p):
$product = ProductData::getById($p["product_id"]);
?>
<tr >
	<td><?php echo $product->id; ?></td>
	<td ><?php echo $p["q"]; ?></td>
	<td><?php echo $product->unit; ?></td>
	<td><?php echo $product->name; ?></td>
	<td><b>$ <?php echo number_format($product->price_out); ?></b></td>
	<td><b>$ <?php  $pt = $product->price_out*$p["q"]; $total +=$pt; echo number_format($pt); ?></b></td>
	<td style="width:30px;"><a href="index.php?view=clearcart&product_id=<?php echo $product->id; ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a></td>
</tr>

<?php endforeach; ?>
</table>
</div>
</div>
<h2>Resumen</h2>
<div class="row">
<div class="col-md-6 col-md-offset-6">
<table class="table table-bordered">
<tr>
	<td><p>Subtotal</p></td>
	<td><p><b>$ <?php echo number_format($total*.84); ?></b></p></td>
</tr>
<tr>
	<td><p>IVA</p></td>
	<td><p><b>$ <?php echo number_format($total*.16); ?></b></p></td>
</tr>
<tr>
	<td><p>Total</p></td>
	<td><p><b>$ <?php echo number_format($total); ?></b></p></td>
</tr>

</table>
<div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <div class="checkbox">
        <label>
		<a href="index.php?view=clearcart" class="btn btn-lg btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
        </label>
      </div>
    </div>
  </div>
</form>

</div>
</div>

<br><br><br><br><br>
<?php endif; ?>

</div>
	</div>
</section>