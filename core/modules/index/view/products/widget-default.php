<section class="content-header">
	<a href="index.php?view=addproduct" class="btn pull-right btn-default"><i class="glyphicon glyphicon-plus-sign"></i> Agregar Producto</a>
		<h1>Productos</h1>
</section>
<section class="content">
<div class="row">


	<div class="col-md-12">
		<div class="clearfix"></div>


<?php
$page = 1;
if(isset($_GET["page"])){
	$page=$_GET["page"];
}
$limit=10;
if(isset($_GET["limit"]) && $_GET["limit"]!="" && $_GET["limit"]!=$limit){
	$limit=$_GET["limit"];
}

$products = ProductData::getAllActive();
if(count($products)>0){

	?>

<div class="clearfix"></div>
<div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"></h3>
                                </div>
                                <div class="box-body table-responsive">
                                <table class="table table-bordered table-hover datatable">
	<thead>
		<th>Codigo</th>
		<th>Nombre</th>
		<th>Precio</th>
		<th></th>
	</thead>
	<?php foreach($products as $product):?>
	<tr>
		<td><?php echo $product->id; ?></td>
		<td><?php echo $product->name; ?></td>
		<td>$ <?php echo number_format($product->price_out,2,".",","); ?></td>
		<td style="width:170px;">
<!--		<a href="index.php?view=hideproduct&id=<?php echo $product->id; ?>" title="Desactivar Producto" class="btn tip btn-sm btn-default"><i class="glyphicon glyphicon-eye-close"></i></a>-->
		<a href="index.php?view=productingredients&id=<?php echo $product->id; ?>" class="btn tip btn-xs btn-default"><i class="glyphicon glyphicon-th-list"></i> Ingredientes</a>
		<a href="index.php?view=editproduct&id=<?php echo $product->id; ?>" title="Editar Producto" class="btn tip btn-xs btn-warning"><i class="glyphicon glyphicon-pencil"></i></a>
		</td>
	</tr>
	<?php endforeach;?>
</table>
</div>
</div>
<div class="clearfix"></div>

	<?php
}else{
	?>
	<div class="jumbotron">
		<h2>No hay productos</h2>
		<p>No se han agregado productos a la base de datos, puedes agregar uno dando click en el boton <b>"Agregar Producto"</b>.</p>
	</div>
	<?php
}

?>
<br><br><br><br><br><br><br><br><br><br>
	</div>
</div>
</section>