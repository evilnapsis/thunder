<?php 
if(isset($_GET["opt"]) && $_GET["opt"]=="all"):
		$products = ProductData::getAll();
?>
<section class="content">
<div class="row">

	<div class="col-md-12">
		<div class="clearfix"></div>

<?php
if(count($products)>0){
	?>

<div class="card mb-4">
	<div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
		<h5 class="mb-0"><i class="bi bi-box-seam me-2"></i> Productos</h5>
		<a href="index.php?view=products&opt=new" class="btn btn-sm btn-light shadow-sm text-primary fw-bold px-3">
			<i class="bi bi-plus-circle me-1"></i> Agregar Producto
		</a>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered table-hover datatable nowrap" style="width:100%">
				<thead>
					<tr>
						<th>Codigo</th>
						<th>Nombre</th>
						<th>Precio</th>
						<th>Status</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($products as $product):?>
				<tr>
					<td><?php echo $product->code; ?></td>
					<td><?php echo $product->name; ?></td>
					<td>$ <?php echo number_format($product->price_out,2,".",","); ?></td>
					<td>
						<?php if($product->is_active): ?>
							<span class="badge bg-success">Activo</span>
						<?php else: ?>
							<span class="badge bg-danger">Inactivo</span>
						<?php endif; ?>
					</td>
					<td>
						<div class="btn-group btn-group-sm">
							<a href="index.php?view=productingredients&id=<?php echo $product->id; ?>" class="btn btn-outline-secondary" title="Ingredientes"><i class="bi bi-list-check me-1"></i> Ingredientes</a>
							<a href="index.php?view=products&opt=edit&id=<?php echo $product->id; ?>" class="btn btn-outline-warning" title="Editar"><i class="bi bi-pencil me-1"></i> Editar</a>
							<?php if($product->is_active): ?>
								<a href="index.php?action=products&opt=hide&id=<?php echo $product->id; ?>" class="btn btn-outline-danger" title="Desactivar"><i class="bi bi-eye-slash me-1"></i> Desactivar</a>
							<?php else: ?>
								<a href="index.php?action=products&opt=active&id=<?php echo $product->id; ?>" class="btn btn-outline-primary" title="Activar"><i class="bi bi-eye me-1"></i> Activar</a>
							<?php endif; ?>
						</div>
					</td>
				</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		</div>
	</div>
</div>

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
	</div>
</div>
</section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="new"):?>
<section class="content-header">
  <h1>Agregar Producto</h1>
</section>
<section class="content">
<div class="row">
	<div class="col-md-12">

<div class="card mb-4 border-success">
	<div class="card-header bg-success text-white">
		<h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i> Nuevo Producto</h5>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" id="addproduct" action="index.php?action=products&opt=add" role="form">
			<div class="row mb-3">
				<label for="code" class="col-lg-3 col-form-label">Codigo*</label>
				<div class="col-lg-8">
					<input type="text" name="code" class="form-control" id="code" placeholder="Codigo del Producto" required>
				</div>
			</div>
			<div class="row mb-3">
				<label for="name" class="col-lg-3 col-form-label">Nombre*</label>
				<div class="col-lg-8">
					<input type="text" name="name" class="form-control" required id="name" placeholder="Nombre del Producto">
				</div>
			</div>
			<div class="row mb-3">
				<label for="description" class="col-lg-3 col-form-label">Descripcion*</label>
				<div class="col-lg-8">
					<textarea name="description" class="form-control" id="description" placeholder="Descripcion del Producto" rows="2"></textarea>
				</div>
			</div>
			<div class="row mb-3">
				<label for="preparation" class="col-lg-3 col-form-label">Peparacion*</label>
				<div class="col-lg-8">
					<textarea name="preparation" class="form-control" id="preparation" placeholder="Peparacion del Producto" rows="2"></textarea>
				</div>
			</div>

			<div class="row mb-3">
				<label for="price_out" class="col-lg-3 col-form-label">Precio*</label>
				<div class="col-lg-8">
					<div class="input-group">
						<span class="input-group-text">$</span>
						<input type="text" name="price_out" class="form-control" required id="price_out" placeholder="0.00">
					</div>
				</div>
			</div>
			<div class="row mb-3">
				<label for="duration" class="col-lg-3 col-form-label">Duracion*</label>
				<div class="col-lg-8">
					<div class="input-group">
						<input type="text" name="duration" class="form-control" id="duration" placeholder="30">
						<span class="input-group-text">mins</span>
					</div>
				</div>
			</div>

			<div class="row mb-3">
				<label for="unit" class="col-lg-3 col-form-label">Unidad*</label>
				<div class="col-lg-8">
					<input type="text" name="unit" class="form-control" required id="unit" placeholder="Ej. Unidad, Kg, Litro">
				</div>
			</div>
			<div class="row mb-3">
				<label for="category_id" class="col-lg-3 col-form-label">Categoria*</label>
				<div class="col-lg-8">
					<select name="category_id" class="form-select" required id="category_id">
						<option value="">-- SELECCIONE CATEGORIA --</option>
						<?php foreach(CategoryData::getAll() as $cat):?>
						<option value="<?php echo $cat->id; ?>"><?php echo $cat->name; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-lg-offset-3 col-lg-9">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="use_ingredient" id="use_ingredient">
						<label class="form-check-label" for="use_ingredient">
							Usar Ingredientes
						</label>
					</div>
				</div>
			</div>

			<div class="alert alert-info py-2">
				<small><i class="bi bi-info-circle me-1"></i> Campos obligatorios: Nombre, Precio, Unidad, Categoria</small>
			</div>

			<div class="row mt-4">
				<div class="col-lg-offset-3 col-lg-9">
					<button type="submit" class="btn btn-success"><i class="bi bi-save me-1"></i> Guardar Producto</button>
					<a href="index.php?view=products&opt=all" class="btn btn-secondary shadow-sm ms-2"><i class="bi bi-arrow-left me-1"></i> Cancelar</a>
				</div>
			</div>
		</form>
	</div>
</div>
	</div>
</div>
</section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="edit"):
$product = ProductData::getById($_GET["id"]);
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
<div class="card mb-4 border-success">
	<div class="card-header bg-success text-white">
		<h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i> Editar Producto: <?php echo $product->name; ?></h5>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" id="addproduct" action="index.php?action=products&opt=update" role="form">
			<div class="row mb-3">
				<label for="code" class="col-lg-2 col-form-label">Codigo*</label>
				<div class="col-lg-6">
					<input type="text" name="code" class="form-control" id="code" value="<?php echo $product->code; ?>" placeholder="Codigo del Producto" required>
				</div>
			</div>
			<div class="row mb-3">
				<label for="name" class="col-lg-2 col-form-label">Nombre*</label>
				<div class="col-lg-6">
					<input type="text" name="name" class="form-control" id="name" value="<?php echo $product->name; ?>" placeholder="Nombre del Producto" required>
				</div>
			</div>
			<div class="row mb-3">
				<label for="description" class="col-lg-2 col-form-label">Descripcion</label>
				<div class="col-lg-6">
					<textarea name="description" class="form-control" id="description" placeholder="Descripcion del Producto" rows="2"><?php echo $product->description; ?></textarea>
				</div>
			</div>
			<div class="row mb-3">
				<label for="preparation" class="col-lg-2 col-form-label">Peparacion</label>
				<div class="col-lg-6">
					<textarea name="preparation" class="form-control" id="preparation" placeholder="Peparacion del Producto" rows="2"><?php echo $product->preparation; ?></textarea>
				</div>
			</div>
			<div class="row mb-3">
				<label for="price_out" class="col-lg-2 col-form-label">Precio*</label>
				<div class="col-lg-6">
					<div class="input-group">
						<span class="input-group-text">$</span>
						<input type="text" name="price_out" class="form-control" id="price_out" value="<?php echo $product->price_out; ?>" placeholder="0.00" required>
					</div>
				</div>
			</div>
			<div class="row mb-3">
				<label for="duration" class="col-lg-2 col-form-label">Duracion*</label>
				<div class="col-lg-6">
					<div class="input-group">
						<input type="text" name="duration" class="form-control" id="duration" value="<?php echo $product->duration; ?>" placeholder="30">
						<span class="input-group-text">mins</span>
					</div>
				</div>
			</div>
			<div class="row mb-3">
				<label for="unit" class="col-lg-2 col-form-label">Unidad*</label>
				<div class="col-lg-6">
					<input type="text" name="unit" class="form-control" id="unit" value="<?php echo $product->unit; ?>" placeholder="Unidad del Producto" required>
				</div>
			</div>
			<div class="row mb-3">
				<label for="category_id" class="col-lg-2 col-form-label">Categoria</label>
				<div class="col-lg-6">
					<select name="category_id" class="form-select" id="category_id" required>
						<option value="">-- SELECCIONE CATEGORIA --</option>
						<?php foreach(CategoryData::getAll() as $cat):?>
						<option value="<?php echo $cat->id; ?>" <?php if($product->category_id==$cat->id){ echo "selected";}?>><?php echo $cat->name; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-lg-offset-2 col-lg-6">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" name="use_ingredient" id="use_ingredient_edit" <?php if($product->use_ingredient){ echo "checked";}?>>
						<label class="form-check-label" for="use_ingredient_edit">
							Usar Ingredientes
						</label>
					</div>
				</div>
			</div>

			<div class="alert alert-info py-2">
				<small><i class="bi bi-info-circle me-1"></i> Campos obligatorios: Nombre, Precio de Salida, Unidad</small>
			</div>

			<div class="row mt-4">
				<div class="col-lg-offset-2 col-lg-10">
					<input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
					<button type="submit" class="btn btn-success"><i class="bi bi-arrow-repeat me-1"></i> Actualizar Producto</button>
					<a href="index.php?view=products&opt=all" class="btn btn-secondary shadow-sm ms-2"><i class="bi bi-arrow-left me-1"></i> Cancelar</a>
				</div>
			</div>
		</form>
	</div>
</div>
	</div>
</div>
</section>
<?php endif; ?>