<?php
if(isset($_GET["product_id"])):
$product = ProductData::getById($_GET["product_id"]);
$operations = OperationData::getAllByProductIdCutIdOficial($product->id,$_GET["cutid"]);
?>
<div class="row">
	<div class="col-md-12">
<a href="index.php?view=cuthistoryn&product_id=<?php echo $_GET["product_id"];?>&cutid=<?php echo $_GET["cutid"]; ?>" class="btn btn-default pull-right btn-lg">Operaciones sin Factura <i class="glyphicon glyphicon-chevron-right"></i></a>
<h1><i class="glyphicon glyphicon-time"></i> Historial</h1>
<h2><?php echo $product->name;; ?> <small>Operaciones con factura</small></h2>
	</div>
	</div>

<div class="row">


	<div class="col-md-4">


	<?php
$itotal = OperationData::GetInputQYesF($product->id,$_GET["cutid"]);

	?>
<div class="jumbotron">
<center>
	<h2>Entradas</h2>
	<h1><?php echo $itotal; ?></h1>
</center>
</div>

<br>
<?php
?>

</div>

	<div class="col-md-4">
	<?php
$total = OperationData::GetQYesF($product->id,$_GET["cutid"]);


	?>
<div class="jumbotron">
<center>
	<h2>Disponibles</h2>
	<h1><?php echo $total; ?></h1>
</center>
</div>
<div class="clearfix"></div>
<br>
<?php
?>

</div>

	<div class="col-md-4">


	<?php
$ototal = -1*OperationData::GetOutputQYesF($product->id,$_GET["cutid"]);

	?>
<div class="jumbotron">
<center>
	<h2>Salidas</h2>
	<h1><?php echo $ototal; ?></h1>
</center>
</div>


<div class="clearfix"></div>
<br>
<?php
?>

</div>






</div>
<div class="row">
	<div class="col-md-12">
		<p class="alert alert-success"> Se esta trabajando sobre el corte iniciado la fecha (AAAA-MM-DD HH:MM:SS): <b><?php echo $cut->created_at; ?></b></p>
		<?php if(count($operations)>0):?>
			<table class="table table-bordered table-hover">
			<thead>
			<th></th>
			<th>Cantidad</th>
			<th>Con factura</th>
			<th>Tipo</th>
			<th>Fecha</th>
			</thead>
			<?php foreach($operations as $operation):?>
			<tr>
			<td></td>
			<td><?php echo $operation->q; ?></td>
			<td>
			<center>
				<?php if($operation->is_oficial==1):?>
					<i class="glyphicon glyphicon-ok-sign"></i>
				<?php else:?>
					<i class="glyphicon glyphicon-remove"></i>
				<?php endif; ?>
			</center>

			</td>
			<td><?php echo $operation->getOperationType()->name; ?></td>
			<td><?php echo $operation->created_at; ?></td>
			</tr>
			<?php endforeach; ?>
			</table>
		<?php endif; ?>
	</div>
</div>

<?php endif; ?>