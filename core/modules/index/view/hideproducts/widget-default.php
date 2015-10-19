<section class="content-header">
		<h1>Productos Inactivos</h1>	
</section>
<section class="content">
<div class="row">

	<div class="col-md-3">
	<br>
		<div class="panel panel-default">
			<div class="panel-heading">
	<b>&nbsp;</b>
			</div>
<div class="list-group">

<a href='index.php?view=products' class='list-group-item'><span class='pull-right'><i class='glyphicon glyphicon-chevron-right'></i></span><i class='glyphicon glyphicon-glass'></i> Productos</a>

</div>

		</div>
	</div>
	<div class="col-md-9">
		<div class="clearfix"></div>


<?php

$products = ProductData::getAllUnActive();
if(count($products)>0){

	?>

<div class="clearfix"></div>
<div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"></h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-primary btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body table-responsive">
                                <table class="table table-bordered table-hover datatable">
	<thead>
		<th>Codigo</th>
		<th>Nombre</th>
		<th>Categoria</th>
		<th>Precio</th>
		<th></th>
	</thead>
	<?php foreach($products as $product):?>
	<tr>
		<td><?php echo $product->id; ?></td>
		<td><?php echo $product->name; ?></td>
		<td><?php echo $product->cname; ?></td>
		<td><?php echo $product->price_out; ?></td>
		<td style="width:90px;">
		<a href="index.php?view=activeproduct&id=<?php echo $product->id; ?>" title="Activar Producto" class="btn tip btn-sm btn-default"><i class="glyphicon glyphicon-thumbs-up"></i></a>
		<a href="index.php?view=editproduct&id=<?php echo $product->id; ?>" title="Editar Producto" class="btn tip btn-sm btn-warning"><i class="glyphicon glyphicon-pencil"></i></a>
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