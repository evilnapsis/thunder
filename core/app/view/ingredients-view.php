<?php 
if(isset($_GET["opt"]) && $_GET["opt"]=="all"):
		$products = IngredientData::getAll();
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
		<h5 class="mb-0"><i class="bi bi-egg-fried me-2"></i> Ingredientes</h5>
		<a href="index.php?view=ingredients&opt=new" class="btn btn-sm btn-light shadow-sm text-primary fw-bold px-3">
			<i class="bi bi-plus-circle me-1"></i> Agregar Ingrediente
		</a>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered table-hover datatable nowrap" style="width:100%">
				<thead class="table-light">
					<tr>
						<th>Codigo</th>
						<th>Nombre</th>
						<th>Precio</th>
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
						<div class="btn-group btn-group-sm">
							<a href="index.php?view=ingredients&opt=edit&id=<?php echo $product->id; ?>" class="btn btn-outline-warning" title="Editar"><i class="bi bi-pencil me-1"></i> Editar</a>
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
	<div class="card shadow-sm border-0 mt-4">
		<div class="card-body text-center py-5">
			<div class="mb-4">
				<i class="bi bi-egg-fried text-muted opacity-25" style="font-size: 5rem;"></i>
			</div>
			<h2 class="fw-bold text-dark">No hay ingredientes</h2>
			<p class="text-muted fs-5 mb-4">Tu inventario de ingredientes está vacío.<br>Agrega ingredientes para poder definir las recetas de tus productos.</p>
			<a href="index.php?view=ingredients&opt=new" class="btn btn-lg btn-success text-white shadow-sm px-5 fw-bold">
				<i class="bi bi-plus-circle me-2"></i> Crear Primer Ingrediente
			</a>
		</div>
	</div>
	<?php
}
?>
	</div>
</div>
</section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="new"):?>
<section class="content">
<div class="row justify-content-center">
	<div class="col-md-8">
		<div class="card mb-4 border-success">
			<div class="card-header bg-success text-white">
				<h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i> Nuevo Ingrediente</h5>
			</div>
			<div class="card-body">
				<form class="form-horizontal" method="post" id="addproduct" action="index.php?action=ingredients&opt=add" role="form">
					<div class="row mb-3">
						<label for="code" class="col-lg-3 col-form-label">Codigo*</label>
						<div class="col-lg-8">
							<input type="text" name="code" class="form-control" id="code" placeholder="Codigo del Ingrediente" required>
						</div>
					</div>
					<div class="row mb-3">
						<label for="name" class="col-lg-3 col-form-label">Nombre*</label>
						<div class="col-lg-8">
							<input type="text" name="name" class="form-control" id="name" placeholder="Nombre del Ingrediente" required>
						</div>
					</div>
					<div class="row mb-3">
						<label for="price_out" class="col-lg-3 col-form-label">Precio*</label>
						<div class="col-lg-8">
							<div class="input-group">
								<span class="input-group-text">$</span>
								<input type="text" name="price_out" class="form-control" id="price_out" placeholder="0.00" required>
							</div>
						</div>
					</div>
					<div class="row mb-3">
						<label for="unit" class="col-lg-3 col-form-label">Unidad*</label>
						<div class="col-lg-8">
							<input type="text" name="unit" class="form-control" id="unit" placeholder="Ej. Kg, Litro, Gramo" required>
						</div>
					</div>

					<div class="alert alert-info py-2">
						<small><i class="bi bi-info-circle me-1"></i> Campos obligatorios: Código, Nombre, Precio, Unidad</small>
					</div>

					<div class="row mt-4">
						<div class="col-lg-9 offset-lg-3">
							<button type="submit" class="btn btn-success"><i class="bi bi-save me-1"></i> Guardar Ingrediente</button>
							<a href="index.php?view=ingredients&opt=all" class="btn btn-secondary ms-2"><i class="bi bi-arrow-left me-1"></i> Cancelar</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="edit"):
$product = IngredientData::getById($_GET["id"]);
?>
<section class="content">
<div class="row justify-content-center">
	<div class="col-md-8">
		<div class="card mb-4 border-success">
			<div class="card-header bg-success text-white">
				<h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i> Editar Ingrediente: <?php echo $product->name; ?></h5>
			</div>
			<div class="card-body">
				<form class="form-horizontal" method="post" id="addproduct" action="index.php?action=ingredients&opt=update" role="form">
					<div class="row mb-3">
						<label for="code" class="col-lg-3 col-form-label">Codigo*</label>
						<div class="col-lg-8">
							<input type="text" name="code" value="<?php echo $product->code; ?>" class="form-control" id="code" placeholder="Codigo del Ingrediente" required>
						</div>
					</div>
					<div class="row mb-3">
						<label for="name" class="col-lg-3 col-form-label">Nombre*</label>
						<div class="col-lg-8">
							<input type="text" name="name" value="<?php echo $product->name; ?>" class="form-control" id="name" placeholder="Nombre del Ingrediente" required>
						</div>
					</div>
					<div class="row mb-3">
						<label for="price_out" class="col-lg-3 col-form-label">Precio*</label>
						<div class="col-lg-8">
							<div class="input-group">
								<span class="input-group-text">$</span>
								<input type="text" name="price_out" value="<?php echo $product->price_out; ?>" class="form-control" id="price_out" placeholder="0.00" required>
							</div>
						</div>
					</div>
					<div class="row mb-3">
						<label for="unit" class="col-lg-3 col-form-label">Unidad*</label>
						<div class="col-lg-8">
							<input type="text" name="unit" value="<?php echo $product->unit; ?>" class="form-control" id="unit" placeholder="Ej. Kg, Litro" required>
						</div>
					</div>

					<div class="row mt-4">
						<div class="col-lg-9 offset-lg-3">
							<input type="hidden" name="ingredient_id" value="<?php echo $product->id; ?>">
							<button type="submit" class="btn btn-success"><i class="bi bi-arrow-repeat me-1"></i> Actualizar Ingrediente</button>
							<a href="index.php?view=ingredients&opt=all" class="btn btn-secondary ms-2"><i class="bi bi-arrow-left me-1"></i> Cancelar</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="inventory"):
$products = IngredientData::getAll();
?>
<section class="content">
	<div class="card mb-4 border-primary">
		<div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
			<h5 class="mb-0"><i class="bi bi-box-seam me-2"></i> Inventario de Ingredientes</h5>
			<a href="index.php?view=ingredients&opt=re" class="btn btn-sm btn-light shadow-sm text-primary fw-bold mx-2">
				<i class="bi bi-plus-circle me-1"></i> Abastecer
			</a>
		</div>
		<div class="card-body">
			<?php if(count($products)>0): ?>
				<div class="table-responsive">
					<table class="table table-bordered table-hover datatable nowrap" style="width:100%">
						<thead class="table-light">
							<tr>
								<th>Código</th>
								<th>Nombre</th>
								<th>Unidad</th>
								<th>Disponible</th>
								<th>Estado</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($products as $product):
								$q = Operation2Data::getQYesF($product->id);
								// Asumo un mínimo por defecto si no existe la propiedad, o uso un valor base para alertas
								$min = isset($product->inventary_min) ? $product->inventary_min : 10;
							?>
							<tr>
								<td>#<?php echo $product->code; ?></td>
								<td class="fw-bold"><?php echo $product->name; ?></td>
								<td><span class="badge bg-secondary opacity-75"><?php echo $product->unit; ?></span></td>
								<td class="fw-bold <?php echo ($q <= $min/2) ? 'text-danger' : (($q <= $min) ? 'text-warning' : 'text-success'); ?>">
									<?php echo $q; ?>
								</td>
								<td>
									<?php if($q <= $min/2): ?>
										<span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Muy Bajo</span>
									<?php elseif($q <= $min): ?>
										<span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i> Bajo</span>
									<?php else: ?>
										<span class="badge bg-success text-white"><i class="bi bi-check-circle me-1"></i> Suficiente</span>
									<?php endif; ?>
								</td>
								<td>
									<a href="index.php?view=ingredients&opt=history&product_id=<?php echo $product->id; ?>" class="btn btn-sm btn-outline-info">
										<i class="bi bi-clock-history me-1"></i> Historial
									</a>
								</td>
							</tr>
							<?php endforeach;?>
						</tbody>
					</table>
				</div>
			<?php else: ?>
				<div class="text-center py-5">
					<i class="bi bi-inbox fs-1 text-muted"></i>
					<h4 class="mt-3">No hay ingredientes registrados</h4>
					<p class="text-muted">Agregue ingredientes para comenzar a rastrear su inventario.</p>
				</div>
			<?php endif; ?>
		</div>
</section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="history"):
if(isset($_GET["product_id"])):
$product = IngredientData::getById($_GET["product_id"]);
$operations = Operation2Data::getAllByProductId($product->id);
$itotal = Operation2Data::GetInputQYesF($product->id);
$total = Operation2Data::GetQYesF($product->id);
$ototal = -1 * Operation2Data::GetOutputQYesF($product->id);
?>
<section class="content">
	<div class="d-flex align-items-center justify-content-between mb-4">
		<h2 class="mb-0 text-primary fw-bold"><?php echo $product->name; ?> <span class="text-muted small fw-normal">| Historial de Movimientos</span></h2>
		<a href="index.php?view=ingredients&opt=inventory" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Volver al Inventario</a>
	</div>

	<div class="row g-4 mb-4 text-center">
		<div class="col-md-4">
			<div class="card border-0 shadow-sm bg-success text-white py-3">
				<div class="card-body">
					<div class="text-uppercase small fw-bold opacity-75 mb-1">Entradas Totales</div>
					<div class="display-6 fw-bold"><?php echo $itotal; ?></div>
					<div class="small mt-2"><i class="bi bi-arrow-up-circle"></i> Ingresos acumulados</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card border-0 shadow-sm bg-info text-white py-3">
				<div class="card-body">
					<div class="text-uppercase small fw-bold opacity-75 mb-1">Stock Disponible</div>
					<div class="display-6 fw-bold"><?php echo $total; ?></div>
					<div class="small mt-2"><i class="bi bi-box-seam"></i> Existencia actual</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card border-0 shadow-sm bg-danger text-white py-3">
				<div class="card-body">
					<div class="text-uppercase small fw-bold opacity-75 mb-1">Salidas Totales</div>
					<div class="display-6 fw-bold"><?php echo $ototal; ?></div>
					<div class="small mt-2"><i class="bi bi-arrow-down-circle"></i> Consumo acumulado</div>
				</div>
			</div>
		</div>
	</div>

	<div class="card mb-4 border-primary">
		<div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
			<h5 class="mb-0"><i class="bi bi-clock-history me-2"></i> Log de Transacciones</h5>
		</div>
		<div class="card-body">
			<?php if(count($operations)>0): ?>
				<div class="table-responsive">
					<table class="table table-bordered table-hover datatable nowrap" style="width:100%">
						<thead class="table-light">
							<tr>
								<th>ID</th>
								<th>Cantidad</th>
								<th>Tipo de Movimiento</th>
								<th>Fecha y Hora</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($operations as $operation): ?>
							<tr>
								<td class="text-muted small">#<?php echo $operation->id; ?></td>
								<td class="fw-bold fs-6"><?php echo $operation->q; ?></td>
								<td>
									<?php if($operation->operation_type_id == 1): ?>
										<span class="badge bg-success opacity-75"><i class="bi bi-plus-lg me-1"></i> Entrada</span>
									<?php else: ?>
										<span class="badge bg-danger opacity-75"><i class="bi bi-dash-lg me-1"></i> Salida</span>
									<?php endif; ?>
								</td>
								<td><small class="text-muted"><?php echo $operation->created_at; ?></small></td>
								<td style="width:50px;">
									<button onclick="deleteOperation(<?php echo $operation->id; ?>, <?php echo $product->id; ?>)" class="btn btn-sm btn-outline-danger">
										<i class="bi bi-trash"></i>
									</button>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			<?php else: ?>
				<div class="text-center py-5">
					<i class="bi bi-journal-x fs-1 text-muted"></i>
					<h5 class="mt-3">Sin movimientos registrados</h5>
					<p class="text-muted">Este ingrediente aún no posee entradas ni salidas.</p>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<script>
function deleteOperation(opId, prodId) {
	if(confirm("¿Estás seguro que deseas eliminar este movimiento de inventario?")) {
		window.location = "index.php?action=operations&opt=delete&ref=history&pid="+prodId+"&opid="+opId;
	}
}
</script>
<?php endif; ?>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="re"): ?>
<section class="content">
	<div class="card mb-4 border-primary">
		<div class="card-header bg-primary text-white">
			<h5 class="mb-0"><i class="bi bi-cart-plus me-2"></i> Reabastecer Inventario</h5>
		</div>
		<div class="card-body">
			<p class="mb-2"><b>Buscar ingrediente por nombre o por código:</b></p>
			<form method="get" action="index.php">
				<input type="hidden" name="view" value="ingredients">
				<input type="hidden" name="opt" value="re">
				<div class="row g-2">
					<div class="col-md-9">
						<input type="text" name="product" class="form-control" placeholder="Escriba el nombre o código..." autofocus required value="<?php echo isset($_GET["product"]) ? $_GET["product"] : ""; ?>">
					</div>
					<div class="col-md-3">
						<button type="submit" class="btn btn-primary w-100"><i class="bi bi-search me-1"></i> Buscar</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<?php if(isset($_GET["product"])):
		$products = IngredientData::getLike($_GET["product"]);
		if(count($products)>0):
	?>
	<div class="card mb-4 border-info">
		<div class="card-header bg-info text-white">
			<h5 class="mb-0 text-white"><i class="bi bi-list-task me-2"></i> Resultados de la Búsqueda</h5>
		</div>
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table table-bordered table-hover mb-0 align-middle">
					<thead class="table-secondary">
						<tr>
							<th>Código</th>
							<th>Nombre</th>
							<th>Unidad</th>
							<th>P. Compra</th>
							<th>Stock Actual</th>
							<th style="width: 250px;">Cantidad a Agregar</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($products as $product): 
							$q = Operation2Data::getQYesF($product->id);
						?>
						<form method="post" action="index.php?action=ingredients&opt=addtore">
							<tr>
								<td>#<?php echo $product->code; ?></td>
								<td class="fw-bold"><?php echo $product->name; ?></td>
								<td><span class="badge bg-secondary"><?php echo $product->unit; ?></span></td>
								<td><b>$<?php echo number_format($product->price_in, 2); ?></b></td>
								<td>
									<span class="fw-bold <?php echo ($q <= 5) ? 'text-danger' : 'text-success'; ?>"><?php echo $q; ?></span>
								</td>
								<td>
									<div class="input-group input-group-sm">
										<input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
										<input type="number" step="any" class="form-control" required name="q" placeholder="Cant.">
										<button type="submit" class="btn btn-success text-white"><i class="bi bi-plus-lg me-1"></i> Agregar</button>
									</div>
								</td>
							</tr>
						</form>
						<?php endforeach;?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php endif; endif; ?>

	<?php if(isset($_SESSION["reabastecer"]) && count($_SESSION["reabastecer"]) > 0):
		$total = 0;
	?>
	<div class="card mb-4 border-success shadow-sm">
		<div class="card-header bg-success text-white">
			<h5 class="mb-0"><i class="bi bi-cart-check me-2"></i> Lista de Reabastecimiento</h5>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-hover align-middle">
					<thead class="table-light">
						<tr>
							<th>Cod.</th>
							<th>Cant.</th>
							<th>Unidad</th>
							<th>Producto</th>
							<th class="text-end">P. Unitario</th>
							<th class="text-end">Total</th>
							<th class="text-center">Acción</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($_SESSION["reabastecer"] as $p):
							$product = IngredientData::getById($p["product_id"]);
						?>
						<tr>
							<td>#<?php echo $product->code; ?></td>
							<td class="fw-bold"><?php echo $p["q"]; ?></td>
							<td><?php echo $product->unit; ?></td>
							<td class="fw-bold text-primary"><?php echo $product->name; ?></td>
							<td class="text-end">$<?php echo number_format($product->price_in, 2); ?></td>
							<td class="text-end fw-bold">$<?php 
								$pt = (float)$product->price_in * (float)$p["q"]; 
								$total += $pt; 
								echo number_format($pt, 2); 
							?></td>
							<td class="text-center">
								<a href="index.php?action=ingredients&opt=clearre&product_id=<?php echo $product->id; ?>" class="btn btn-sm btn-outline-danger shadow-sm"><i class="bi bi-x-lg"></i></a>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>

			<div class="row mt-4">
				<div class="col-md-6">
					<a href="index.php?action=ingredients&opt=clearre" class="btn btn-outline-danger" onclick="return confirm('¿Seguro que desea vaciar la lista?')"><i class="bi bi-trash me-1"></i> Cancelar Todo</a>
				</div>
				<div class="col-md-6">
					<div class="card border-primary ms-auto shadow-sm" style="max-width: 350px;">
						<div class="card-body p-3">
							<div class="d-flex justify-content-between mb-2 opacity-75 small fw-bold">
								<span>SUBTOTAL (sin IVA):</span>
								<span>$ <?php echo number_format($total * 0.84, 2); ?></span>
							</div>
							<div class="d-flex justify-content-between mb-2 opacity-75 small fw-bold">
								<span>IVA (16%):</span>
								<span>$ <?php echo number_format($total * 0.16, 2); ?></span>
							</div>
							<hr>
							<div class="d-flex justify-content-between align-items-center">
								<span class="fs-4 fw-bold text-secondary">TOTAL:</span>
								<span class="fs-3 fw-bold text-success">$<?php echo number_format($total, 2); ?></span>
							</div>
							<form method="post" action="index.php?action=ingredients&opt=processre" class="mt-3">
								<button type="submit" class="btn btn-primary w-100 fw-bold py-2 shadow-sm"><i class="bi bi-check2-circle me-1"></i> PROCESAR REABASTECIMIENTO</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>
</section>
<?php endif; ?>
