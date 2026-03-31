<?php 
if(isset($_GET["opt"]) && $_GET["opt"]=="sell"):
?>
<section class="content-header">
		<h1>Venta</h1>
</section>
<section class="content">
<div class="row">
	<div class="col-md-12">
<div class="card mb-4 border-primary">
	<div class="card-header bg-primary text-white">
		<h5 class="mb-0"><i class="bi bi-search me-2"></i> Realizar Venta</h5>
	</div>
	<div class="card-body">
		<?php if(isset($_SESSION["sell_errors"])): ?>
			<div class="alert alert-danger shadow-sm border-0 mb-4" role="alert">
				<div class="d-flex border-bottom border-danger border-opacity-25 pb-2 mb-2">
					<i class="bi bi-exclamation-octagon-fill fs-4 me-2 text-danger"></i>
					<h5 class="alert-heading mb-0 text-danger fw-bold">Error de Inventario</h5>
				</div>
				<ul class="mb-0 small text-danger">
					<?php foreach($_SESSION["sell_errors"] as $error): ?>
						<li><?php echo $error; ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php unset($_SESSION["sell_errors"]); endif; ?>
		<p class="mb-2"><b>Buscar producto por nombre o por codigo:</b></p>
		<form method="get" action="index.php">
		<div class="row g-2">
			<div class="col-md-9">
				<input type="hidden" name="view" value="sell">
				<input type="hidden" name="opt" value="sell">
				<input type="text" name="product" class="form-control" placeholder="Escriba el nombre o código..." autofocus required value="<?php echo isset($_GET["product"]) ? $_GET["product"] : ""; ?>">
			</div>
			<div class="col-md-3">
				<button type="submit" class="btn btn-primary w-100"><i class="bi bi-search me-1"></i> Buscar</button>
			</div>
		</div>
		</form>
	</div>
</div>

<?php if(isset($_GET["product"])):?>
	<?php
$products = ProductData::getActiveLike($_GET["product"]);
if(count($products)>0){
	?>
<div class="card mb-4 border-info">
	<div class="card-header bg-info text-white">
		<h5 class="mb-0 text-white"><i class="bi bi-list-check me-2"></i> Resultados de la Búsqueda</h5>
	</div>
	<div class="card-body p-0">
		<div class="table-responsive">
			<table class="table table-bordered table-hover mb-0">
				<thead class="table-secondary text-white">
					<tr>
						<th>Codigo</th>
						<th>Nombre</th>
						<th>Unidad</th>
						<th>Precio</th>
						<th>Cantidad</th>
						<th>Acción</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($products as $product): ?>
						<tr>
							<form method="post" action="index.php?action=sell&opt=addtocart">
								<td style="width:100px;"><?php echo $product->code; ?></td>
								<td><?php echo $product->name; ?></td>
								<td><?php echo $product->unit; ?></td>
								<td><b>$<?php echo number_format($product->price_out,2); ?></b></td>
								<td style="width:150px;">
									<input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
									<input type="number" step="any" class="form-control form-control-sm" required name="q" placeholder="Cant." value="1">
								</td>
								<td style="width:180px;">
									<button type="submit" class="btn btn-sm btn-primary w-100 text-white"><i class="bi bi-cart-plus me-1"></i> Agregar</button>
								</td>
							</form>
						</tr>
					<?php endforeach;?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php
}else { echo "<div class='alert alert-warning'><i class='bi bi-exclamation-triangle me-2'></i> No hay resultados en la busqueda.</div>"; }
?>
<?php endif; ?>

<!-- Carrito de compras -->
<?php if(isset($_SESSION["cart"]) && count($_SESSION["cart"])>0):
$total = 0;
?>
<div class="card mb-4 border-success">
	<div class="card-header bg-success text-white">
		<h5 class="mb-0"><i class="bi bi-cart-check me-2"></i> Lista de Venta Actual</h5>
	</div>
	<div class="card-body">
		<form method="post" action="index.php?action=sell&opt=process" id="process">
			<div class="row g-3 mb-4">
				<div class="col-lg-3">
					<label for="personas" class="form-label fw-bold">Personas</label>
					<div class="input-group">
						<span class="input-group-text bg-light"><i class="bi bi-people"></i></span>
						<input type="number" min="1" value="1" name="q" id="personas" class="form-control" placeholder="1" required>
					</div>
				</div>
				<div class="col-lg-3">
					<label for="mesa" class="form-label fw-bold">Mesa</label>
					<div class="input-group">
						<span class="input-group-text bg-light"><i class="bi bi-grid-3x3-gap"></i></span>
						<select class="form-select" required name="mesa" id="mesa">
							<option value="">-- MESA --</option>
							<?php foreach(ItemData::getAll() as $item):?>
								<option value="<?php echo $item->id; ?>"> <?php echo $item->name; ?> </option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="col-lg-3">
					<label for="mesero" class="form-label fw-bold">Mesero</label>
					<div class="input-group">
						<span class="input-group-text bg-light"><i class="bi bi-person-badge"></i></span>
						<select class="form-select" id="mesero" name="mesero_id" required>
							<option value="">-- MESERO --</option>
							<?php foreach (Userdata::getAllMeseros() as $mesero):?>
								<option value="<?php echo $mesero->id; ?>"> <?php echo $mesero->name." ".$mesero->lastname; ?> </option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="col-lg-3 d-flex align-items-end">
					<button class="btn btn-success w-100 shadow-sm" type="submit"><i class="bi bi-check2-circle me-1"></i> Finalizar Venta</button>
				</div>
			</div>
		</form>

		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead class="table-light">
					<tr>
						<th>Codigo</th>
						<th>Cant.</th>
						<th>Unidad</th>
						<th>Producto</th>
						<th>P. Unitario</th>
						<th>P. Total</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($_SESSION["cart"] as $p):
				$product = ProductData::getById($p["product_id"]);
				?>
				<tr>
					<td><?php echo $product->code; ?></td>
					<td><?php echo $p["q"]; ?></td>
					<td><?php echo $product->unit; ?></td>
					<td><?php echo $product->name; ?></td>
					<td>$<?php echo number_format($product->price_out,2); ?></td>
					<td class="fw-bold text-primary">$<?php  $pt = $product->price_out*$p["q"]; $total +=$pt; echo number_format($pt,2); ?></td>
					<td style="width:50px;">
						<a href="index.php?action=sell&opt=clearcart&product_id=<?php echo $product->id; ?>" class="btn btn-sm btn-outline-danger shadow-sm"><i class="bi bi-x-lg"></i></a>
					</td>
				</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<div class="row mt-4 align-items-center">
			<div class="col-md-6">
				<a href="index.php?action=sell&opt=clearcart" class="btn btn-outline-danger" onclick="return confirm('¿Seguro que desea vaciar el carrito?')"><i class="bi bi-trash me-1"></i> Cancelar Venta</a>
			</div>
			<div class="col-md-6">
				<div class="card border-primary ms-auto shadow-sm" style="max-width: 300px;">
					<div class="card-body p-2 d-flex justify-content-between align-items-center">
						<span class="fs-4 fw-bold text-secondary">TOTAL:</span>
						<span class="fs-3 fw-bold text-primary">$<?php echo number_format($total,2); ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>

</div>
	</div>
</section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="all"):
$products = SellData::getAll();
?>
<section class="content">
	<div class="card mb-4 border-primary">
		<div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
			<h5 class="mb-0"><i class="bi bi-clock-history me-2"></i> Historial de Ventas</h5>
			<div class="btn-group btn-group-sm shadow-sm">
				<a href="index.php?view=sell&opt=all&t=0" class="btn btn-light <?php echo (isset($_GET['t']) && $_GET['t']=='0') ? 'active fw-bold border-primary' : ''; ?>">
					<i class="bi bi-clock me-1 text-warning"></i> Pendientes
				</a>
				<a href="index.php?view=sell&opt=all&t=1" class="btn btn-light <?php echo (isset($_GET['t']) && $_GET['t']=='1') ? 'active fw-bold border-success' : ''; ?>">
					<i class="bi bi-check2-circle me-1 text-success"></i> Finalizados
				</a>
				<a href="index.php?view=sell&opt=all" class="btn btn-light <?php echo !isset($_GET['t']) ? 'active fw-bold border-dark' : ''; ?>">
					<i class="bi bi-collection me-1 text-primary"></i> Todos
				</a>
			</div>
		</div>
		<div class="card-body">
			<?php 
			$products = [];
			if(!isset($_GET["t"])){
				$products = SellData::getAll();
			} else if(isset($_GET["t"]) && $_GET["t"]=="0") {
				$products = SellData::getAllUnApplied();
			} else if(isset($_GET["t"]) && $_GET["t"]=="1") {
				$products = SellData::getAllApplied();
			}

			if(count($products)>0):?>
				<div class="table-responsive">
					<table class="table table-bordered table-hover datatable nowrap" style="width:100%">
						<thead class="table-light">
							<tr>
								<th>ID</th>
								<th>Mesa</th>
								<th>Mesero</th>
								<th>Total</th>
								<th>Status</th>
								<th>Fecha</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($products as $sell):?>
							<tr>
								<td class="fw-bold">#<?php echo $sell->id;?></td>
								<td><span class="badge bg-secondary">Mesa <?php echo $sell->item_id;?></span></td>
								<td>
									<?php $mesero = UserData::getById($sell->mesero_id); echo $mesero->name." ".$mesero->lastname; ?>
								</td>
								<td class="fw-bold text-success">
									<?php
									$total=0;
									$operations = OperationData::getAllProductsBySellId($sell->id);
									foreach($operations as $operation){
										$product  = $operation->getProduct();
										$total += $operation->q*$product->price_out;
									}
									echo "$ ".number_format($total,2);
									?>			
								</td>
								<td>
									<?php if($sell->is_applied): ?>
										<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Finalizado</span>
									<?php else: ?>
										<span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i> Pendiente</span>
									<?php endif; ?>
								</td>
								<td><?php echo $sell->created_at; ?></td>
								<td>
									<div class="btn-group btn-group-sm">
										<a href="index.php?view=sell&opt=onesell&id=<?php echo $sell->id; ?>" class="btn btn-outline-primary" title="Ver Detalle">
											<i class="bi bi-eye"></i>
										</a>
										<a href="ticket.php?id=<?php echo $sell->id; ?>" target="_blank" class="btn btn-outline-info" title="Imprimir Ticket (Térmico)">
											<i class="bi bi-receipt"></i>
										</a>
										<a href="invoice.php?id=<?php echo $sell->id; ?>" target="_blank" class="btn btn-outline-success" title="Exportar Factura (A4)">
											<i class="bi bi-file-earmark-pdf"></i>
										</a>
									</div>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			<?php else:?>
				<div class="text-center py-5">
					<i class="bi bi-cart-x fs-1 text-muted"></i>
					<h3 class="mt-3">No hay ventas registradas</h3>
					<p class="text-muted">Aún no se han realizado operaciones en el sistema.</p>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="onesell"):
$sell = SellData::getById($_GET["id"]);
$mesero = UserData::getById($sell->mesero_id);
$operations = OperationData::getAllProductsBySellId($_GET["id"]);
$total = 0;
?>
<section class="content">
	<div class="row justify-content-center">
		<div class="col-lg-10 col-xl-8">
			<div class="d-flex align-items-center justify-content-between mb-4">
				<h2 class="mb-0 text-primary fw-bold"><i class="bi bi-receipt-cutoff me-2"></i> Detalle de Venta #<?php echo $sell->id; ?></h2>
				<div class="btn-group shadow-sm">
					<a href="ticket.php?id=<?php echo $sell->id; ?>" target="_blank" class="btn btn-info text-white fw-bold"><i class="bi bi-receipt me-1"></i> Ticket</a>
					<a href="invoice.php?id=<?php echo $sell->id; ?>" target="_blank" class="btn btn-success text-white fw-bold"><i class="bi bi-file-earmark-pdf me-1"></i> Factura A4</a>
					<a href="index.php?view=sell&opt=all" class="btn btn-outline-secondary ms-2 rounded-end"><i class="bi bi-arrow-left me-1"></i> Volver</a>
				</div>
			</div>

			<div class="card shadow-sm border-0 mb-4 overflow-hidden">
				<div class="card-header bg-dark text-white py-3">
					<div class="row align-items-center">
						<div class="col-md-6">
							<span class="text-uppercase small fw-bold opacity-75">Información de Servicio</span>
							<h4 class="mb-0">Mesa: <?php echo $sell->item_id; ?></h4>
						</div>
						<div class="col-md-6 text-md-end mt-2 mt-md-0">
							<span class="text-uppercase small fw-bold opacity-75">Estado de Cuenta</span><br>
							<?php if($sell->is_applied): ?>
								<span class="badge bg-success fs-6 px-3"><i class="bi bi-check-circle me-1"></i> Finalizado</span>
							<?php else: ?>
								<span class="badge bg-warning text-dark fs-6 px-3"><i class="bi bi-clock me-1"></i> Cuenta Abierta</span>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="row g-4 mb-4">
						<div class="col-sm-6">
							<div class="p-3 bg-light rounded-3 h-100">
								<div class="d-flex align-items-center mb-1">
									<i class="bi bi-person-badge text-primary me-2"></i>
									<span class="text-uppercase small fw-bold text-muted">Mesero Responsable</span>
								</div>
								<div class="fs-5 fw-bold"><?php echo $mesero->name." ".$mesero->lastname; ?></div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="p-3 bg-light rounded-3 h-100">
								<div class="d-flex align-items-center mb-1">
									<i class="bi bi-calendar3 text-primary me-2"></i>
									<span class="text-uppercase small fw-bold text-muted">Fecha y Hora</span>
								</div>
								<div class="fs-5 fw-bold"><?php echo $sell->created_at; ?></div>
							</div>
						</div>
					</div>

					<div class="table-responsive">
						<table class="table table-hover align-middle">
							<thead class="table-light">
								<tr>
									<th>Cod.</th>
									<th>Producto</th>
									<th class="text-center">Cant.</th>
									<th class="text-end">P. Unitario</th>
									<th class="text-end">Total x Item</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($operations as $operation): $product = $operation->getProduct(); ?>
							<tr>
								<td class="text-muted small">#<?php echo $product->id ;?></td>
								<td>
									<div class="fw-bold"><?php echo $product->name ;?></div>
									<small class="text-muted"><?php echo $product->unit; ?></small>
								</td>
								<td class="text-center fw-bold text-primary"><?php echo $operation->q ;?></td>
								<td class="text-end">$ <?php echo number_format($product->price_out, 2) ;?></td>
								<td class="text-end fw-bold">$ <?php 
									$subtotal = $operation->q * $product->price_out; 
									$total += $subtotal;
									echo number_format($subtotal, 2); 
								?></td>
							</tr>
							<?php endforeach; ?>
							</tbody>
							<tfoot class="table-light">
								<tr>
									<td colspan="4" class="text-end py-3">
										<span class="fs-4 fw-bold">TOTAL A PAGAR</span>
									</td>
									<td class="text-end py-3">
										<span class="fs-3 fw-bold text-success border-bottom border-success border-2 border-opacity-50 pb-1">
											$ <?php echo number_format($total, 2); ?>
										</span>
									</td>
								</tr>
							</tfoot>
						</table>
					</div>

					<?php if(!$sell->is_applied): ?>
					<div class="mt-4 p-3 border rounded-3 bg-light d-flex justify-content-between align-items-center">
						<div>
							<i class="bi bi-info-circle text-info fs-5 me-2"></i>
							<span>Esta cuenta aún no ha sido registrada como pagada.</span>
						</div>
						<a href="index.php?action=sell&opt=apply&id=<?php echo $sell->id; ?>" class="btn btn-success text-white shadow-sm fw-bold px-4">
							<i class="bi bi-check-lg me-1"></i> Cobrar y Finalizar
						</a>
					</div>
					<?php endif; ?>
				</div>
			</div>
			
			<div class="text-center text-muted small mt-2">
				<i class="bi bi-printer me-1"></i> Imprimir Comprobante no fiscal | Thunder v1.0
			</div>
		</div>
	</div>
</section>
<?php endif; ?>
