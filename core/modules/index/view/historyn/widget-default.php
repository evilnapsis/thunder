<?php
if(isset($_GET["product_id"])):
$product = ProductData::getById($_GET["product_id"]);
$operations = OperationData::getAllByProductIdCutIdUnOficial($product->id,$cut->id);
?>
<div class="row">
	<div class="col-md-12">
<a href="index.php?view=history&product_id=<?php echo $_GET["product_id"];?>" class="btn btn-default pull-right btn-lg"><i class="glyphicon glyphicon-chevron-left"></i> Operaciones con Factura </a>

<h1><?php echo $product->name;; ?> <small>Operaciones sin factura</small></h1>
	</div>
	</div>

<div class="row">


	<div class="col-md-4">


	<?php
$itotal = OperationData::GetInputQNoF($product->id,$cut->id);

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
$total = OperationData::GetQNoF($product->id,$cut->id);


	?>
<div class="jumbotron">
<center>
	<h2>Disponible</h2>
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
$ototal = -1*OperationData::GetOutputQNoF($product->id,$cut->id);

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
			<th></th>
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
			<td style="width:40px;"><a href="#" id="oper-<?php echo $operation->id; ?>" class="btn tip btn-sm btn-danger" title="Eliminar"><i class="glyphicon glyphicon-trash"></i></a> </td>
			<script>
			$("#oper-"+<?php echo $operation->id; ?>).click(function(){
				x = confirm("Estas seguro que quieres eliminar esto ??");
				if(x==true){
					window.location = "index.php?view=deleteoperation&ref=historyn&pid=<?php echo $operation->product_id;?>&opid=<?php echo $operation->id;?>";
				}
			});

			</script>

			</tr>
			<?php endforeach; ?>
			</table>
		<?php endif; ?>
	</div>
</div>

<?php endif; ?>