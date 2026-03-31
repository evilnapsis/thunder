<?php 
if(isset($_GET["opt"]) && $_GET["opt"]=="all"):
$products = ProductData::getAll();
?>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="card mb-4 border-primary shadow-sm">
				<div class="card-header bg-primary text-white d-flex align-items-center">
					<h5 class="mb-0"><i class="bi bi-file-earmark-bar-graph me-2"></i> Reportes Generales</h5>
				</div>
				<div class="card-body">
					<form method="get" action="index.php">
						<input type="hidden" name="view" value="reports">
						<input type="hidden" name="opt" value="all">
						<div class="row g-3 align-items-end">
							<div class="col-md-4">
								<label class="form-label fw-bold small text-uppercase">Producto</label>
								<select name="product_id" class="form-select">
									<option value="">-- TODOS LOS PRODUCTOS --</option>
									<?php foreach($products as $p):?>
									<option value="<?php echo $p->id;?>" <?php if(isset($_GET["product_id"]) && $_GET["product_id"]==$p->id){ echo "selected"; } ?>><?php echo $p->name;?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="col-md-3">
								<label class="form-label fw-bold small text-uppercase">Fecha Inicio</label>
								<div class="input-group">
									<span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
									<input type="date" name="sd" value="<?php if(isset($_GET["sd"])){ echo $_GET["sd"]; }?>" class="form-control">
								</div>
							</div>
							<div class="col-md-3">
								<label class="form-label fw-bold small text-uppercase">Fecha Fin</label>
								<div class="input-group">
									<span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
									<input type="date" name="ed" value="<?php if(isset($_GET["ed"])){ echo $_GET["ed"]; }?>" class="form-control">
								</div>
							</div>
							<div class="col-md-2">
								<button type="submit" class="btn btn-primary w-100"><i class="bi bi-search me-1"></i> Procesar</button>
							</div>
						</div>
					</form>
				</div>
			</div>

			<?php if(isset($_GET["sd"]) && isset($_GET["ed"]) && $_GET["sd"]!="" && $_GET["ed"]!=""):?>
				<?php 
				$operations = array();
				if($_GET["product_id"]==""){
					$operations = OperationData::getAllByDateOfficial($_GET["sd"],$_GET["ed"]);
				}else{
					$operations = OperationData::getAllByDateOfficialBP($_GET["product_id"],$_GET["sd"],$_GET["ed"]);
				} 
				?>
				<div class="card mb-4">
					<div class="card-header bg-light border-bottom">
						<h6 class="mb-0 fw-bold">Resultados del Reporte</h6>
					</div>
					<div class="card-body">
						<?php if(count($operations)>0):?>
							<div class="table-responsive">
								<table class="table table-bordered table-hover datatable nowrap" style="width:100%">
									<thead class="table-light">
										<tr>
											<th>Id</th>
											<th>Producto</th>
											<th>Cantidad</th>
											<th>Operación</th>
											<th>Fecha</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($operations as $operation):?>
											<tr>
												<td><?php echo $operation->id; ?></td>
												<td class="fw-bold"><?php echo $operation->getProduct()->name; ?></td>
												<td><?php echo $operation->q; ?></td>
												<td>
													<?php if($operation->operation_type_id==1): ?>
														<span class="badge bg-success">Entrada</span>
													<?php else: ?>
														<span class="badge bg-danger">Salida</span>
													<?php endif; ?>
												</td>
												<td><small><?php echo $operation->created_at; ?></small></td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						<?php else: ?>
							<div class="text-center py-5">
								<i class="bi bi-folder-x fs-1 text-muted"></i>
								<h5 class="mt-3">Sin resultados</h5>
								<p class="text-muted">El rango de fechas seleccionado no proporcionó ninguna operación.</p>
							</div>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="by_product"):
$products = ProductData::getAll();
?>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="card mb-4 border-primary">
				<div class="card-header bg-primary text-white">
					<h5 class="mb-0"><i class="bi bi-box-seam me-2"></i> Reporte Detallado por Producto</h5>
				</div>
				<div class="card-body">
					<div class="alert alert-info border-0 shadow-sm d-flex align-items-center mb-4">
						<i class="bi bi-info-circle-fill fs-4 me-3"></i>
						<div>Seleccione un producto del listado para consultar su historial de inventario y movimientos.</div>
					</div>
					<div class="table-responsive">
						<table class="table table-bordered table-hover datatable nowrap" style="width:100%">
							<thead class="table-light">
								<tr>
									<th>Código</th>
									<th>Nombre del Producto</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($products as $product):?>
								<tr>
									<td>#<?php echo $product->id; ?></td>
									<td class="fw-bold"><?php echo $product->name; ?></td>
									<td>
										<a href="index.php?view=reports&opt=product_detail&id=<?php echo $product->id; ?>" class="btn btn-sm btn-outline-primary px-3">
											<i class="bi bi-eye me-1"></i> Ver Reporte
										</a>
									</td>
								</tr>
								<?php endforeach;?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="product_detail"):
$product = ProductData::getById($_GET["id"]);
$operations = OperationData::getAllByProductId($product->id);
?>
<section class="content">
	<div class="card mb-4 border-primary">
		<div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
			<h5 class="mb-0"><i class="bi bi-card-list me-2"></i> Historial Detallado: <?php echo $product->name; ?></h5>
			<a href="index.php?view=reports&opt=by_product" class="btn btn-sm btn-light"><i class="bi bi-arrow-left me-1"></i> Volver</a>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered table-hover datatable nowrap" style="width:100%">
					<thead class="table-light">
						<tr>
							<th>ID</th>
							<th>Cantidad</th>
							<th>Operación</th>
							<th>Fecha</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($operations as $op):?>
						<tr>
							<td><?php echo $op->id; ?></td>
							<td class="fw-bold"><?php echo $op->q; ?></td>
							<td>
								<?php if($op->operation_type_id==1): ?>
									<span class="badge bg-success">Entrada</span>
								<?php else: ?>
									<span class="badge bg-danger">Salida</span>
								<?php endif; ?>
							</td>
							<td><small><?php echo $op->created_at; ?></small></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="by_mesero"):
$meseros = UserData::getAllMeseros();
?>
<section class="content">
	<div class="card mb-4 border-primary">
		<div class="card-header bg-primary text-white">
			<h5 class="mb-0"><i class="bi bi-person-badge me-2"></i> Reporte por Mesero</h5>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered table-hover datatable nowrap" style="width:100%">
					<thead class="table-light">
						<tr>
							<th>Nombre Completo</th>
							<th>Correo Electrónico</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($meseros as $m):?>
						<tr>
							<td class="fw-bold"><?php echo $m->name." ".$m->lastname; ?></td>
							<td><?php echo $m->email; ?></td>
							<td>
								<a href="index.php?view=reports&opt=mesero_detail&mesero_id=<?php echo $m->id; ?>" class="btn btn-sm btn-outline-primary px-3">
									<i class="bi bi-chevron-right me-1"></i> Ver Historial
								</a>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="mesero_detail"):
date_default_timezone_set("America/Hermosillo");
$mesero = UserData::getById($_GET["mesero_id"]);
$sellsdayli = SellData::getAllDayliByMesero($mesero->id);
$totaldayli = 0;
foreach ($sellsdayli as $s) { $totaldayli += $s->total; }
$sellstotal = SellData::getAllTotalByMesero($mesero->id);
$totaltotal = 0;
foreach ($sellstotal as $s) { $totaltotal += $s->total; }
?>
<section class="content">
	<div class="d-flex align-items-center justify-content-between mb-4">
		<h2 class="mb-0 text-primary fw-bold"><?php echo $mesero->name." ".$mesero->lastname; ?> <span class="text-muted small fw-normal">| Perfil del Mesero</span></h2>
		<a href="index.php?view=reports&opt=by_mesero" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i> Volver</a>
	</div>
	
	<div class="row g-4 mb-4">
		<div class="col-md-6 col-lg-4">
			<div class="card border-0 shadow-sm bg-info text-white">
				<div class="card-body d-flex align-items-center">
					<div class="fs-1 me-3 opacity-50"><i class="bi bi-graph-up-arrow"></i></div>
					<div>
						<div class="fs-4 fw-bold text-white">$ <?php echo number_format($totaldayli,2); ?></div>
						<div class="text-uppercase small fw-bold">Ventas de Hoy</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-lg-4">
			<div class="card border-0 shadow-sm bg-success text-white">
				<div class="card-body d-flex align-items-center">
					<div class="fs-1 me-3 opacity-50"><i class="bi bi-currency-dollar"></i></div>
					<div>
						<div class="fs-4 fw-bold text-white">$ <?php echo number_format($totaltotal,2); ?></div>
						<div class="text-uppercase small fw-bold">Total Acumulado</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="card mb-4 border-primary">
		<div class="card-header bg-primary text-white">
			<h5 class="mb-0"><i class="bi bi-table me-2"></i> Resumen de Operaciones</h5>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered table-hover datatable nowrap" style="width:100%">
					<thead class="table-light">
						<tr>
							<th>ID Venta</th>
							<th>Total</th>
							<th>Fecha/Hora</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($sellstotal as $sell): ?>
						<tr>
							<td class="fw-bold">#<?php echo $sell->id; ?></td>
							<td class="text-success fw-bold">$ <?php echo number_format($sell->total,2); ?></td>
							<td><small><?php echo $sell->created_at; ?></small></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>
