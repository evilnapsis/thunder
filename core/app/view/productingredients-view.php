<?php 
$ingredients = IngredientData::getAll();
$operations = ProductIngredientData::getAllByProductId($_GET["id"]);
$product_main = ProductData::getById($_GET["id"]);
?>
<section class="content">
	<div class="container-fluid">
		<?php if(isset($_GET["id"]) && $_GET["id"]!=""):?>
		<div class="row">
			<div class="col-md-12">
				<div class="card mb-4 border-primary shadow-sm">
					<div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
						<h5 class="mb-0"><i class="bi bi-list-check me-2"></i> Ingredientes de: <?php echo $product_main->name; ?></h5>
						<div>
							<button type="button" class="btn btn-sm btn-light shadow-sm text-primary fw-bold" data-coreui-toggle="modal" data-coreui-target="#myModal">
								<i class="bi bi-plus-circle me-1"></i> Agregar Ingrediente
							</button>
							<a href="index.php?view=products&opt=all" class="btn btn-sm btn-outline-light ms-2"><i class="bi bi-arrow-left me-1"></i> Volver</a>
						</div>
					</div>
					<div class="card-body">
						<?php if(count($operations)>0):?>
							<div class="table-responsive">
								<table class="table table-bordered table-hover datatable nowrap" style="width:100%">
									<thead class="table-light">
										<tr>
											<th>Codigo</th>
											<th>Nombre del Ingrediente</th>
											<th>Cantidad</th>
											<th class="text-center">Obligatorio</th>
											<th class="text-center">Acciones</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($operations as $operation): $ingredient = $operation->getIngredient(); ?>
										<tr>
											<td><span class="badge bg-secondary opacity-75">#<?php echo $ingredient->code ;?></span></td>
											<td class="fw-bold"><?php echo $ingredient->name ;?></td>
											<td class="text-primary fw-bold"><?php echo $operation->q ;?></td>
											<td class="text-center">
												<?php if($operation->is_required): ?>
													<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Sí</span>
												<?php else: ?>
													<span class="badge bg-light text-dark">No</span>
												<?php endif; ?>
											</td>
											<td class="text-center">
												<div class="btn-group btn-group-sm">
													<button type="button" class="btn btn-outline-warning" data-coreui-toggle="modal" data-coreui-target="#updateSell-<?php echo $operation->id; ?>">
														<i class="bi bi-pencil"></i>
													</button>
													<a href="index.php?action=productingredients&opt=del&operation_id=<?php echo $operation->id; ?>&product_id=<?php echo $_GET["id"]; ?>" class="btn btn-outline-danger" onclick="return confirm('¿Seguro que desea eliminar este ingrediente?')">
														<i class="bi bi-trash"></i>
													</a>
												</div>

												<!-- Modal Actualizar -->
												<div class="modal fade" id="updateSell-<?php echo $operation->id; ?>" tabindex="-1" aria-hidden="true">
													<div class="modal-dialog">
														<div class="modal-content shadow">
															<div class="modal-header bg-warning">
																<h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i> Actualizar Ingrediente</h5>
																<button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
															</div>
															<div class="modal-body text-start">
																<form method="post" action="index.php?action=productingredients&opt=update">
																	<div class="mb-3">
																		<label class="form-label fw-bold">Ingrediente</label>
																		<input type="text" class="form-control bg-light" readonly value="<?php echo $ingredient->name ;?>">
																	</div>
																	<div class="mb-3">
																		<label for="q-<?php echo $operation->id; ?>" class="form-label fw-bold small text-uppercase">Cantidad</label>
																		<input type="number" step="any" class="form-control" name="q" id="q-<?php echo $operation->id; ?>" value="<?php echo $operation->q ;?>" required>
																	</div>
																	<div class="mb-3">
																		<div class="form-check form-switch mt-2">
																			<input class="form-check-input" type="checkbox" name="is_required" id="req-<?php echo $operation->id; ?>" <?php if($operation->is_required) echo "checked";?>>
																			<label class="form-check-label fw-bold text-muted" for="req-<?php echo $operation->id; ?>">Ingrediente obligatorio</label>
																		</div>
																	</div>
																	<div class="text-end mt-4">
																		<input type="hidden" name="product_id" value="<?php echo $_GET["id"]; ?>">
																		<input type="hidden" name="operation_id" value="<?php echo $operation->id; ?>">
																		<button type="button" class="btn btn-light border" data-coreui-dismiss="modal">Cancelar</button>
																		<button type="submit" class="btn btn-warning fw-bold"><i class="bi bi-arrow-repeat me-1"></i> Actualizar</button>
																	</div>
																</form>
															</div>
														</div>
													</div>
												</div>
											</td>
										</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						<?php else: ?>
							<div class="text-center py-5">
								<i class="bi bi-egg-fried fs-1 text-muted"></i>
								<h5 class="mt-3">Sin ingredientes asignados</h5>
								<p class="text-muted small">Este producto aún no tiene una receta definida.</p>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal Agregar -->
		<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content shadow">
					<div class="modal-header bg-success text-white">
						<h5 class="modal-title fw-bold" id="myModalLabel"><i class="bi bi-plus-circle me-2"></i> Agregar Ingrediente</h5>
						<button type="button" class="btn-close btn-close-white" data-coreui-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body py-4">
						<form method="post" action="index.php?action=productingredients&opt=add">
							<div class="mb-3">
								<label for="ingredient_id" class="form-label fw-bold small text-uppercase">Seleccionar Ingrediente</label>
								<select name="ingredient_id" id="ingredient_id" class="form-select shadow-sm" required>
									<option value="">-- INGREDIENTES -- </option>
									<?php foreach($ingredients as $product_item):?>
										<option value="<?php echo $product_item->id; ?>" ><?php echo $product_item->name; ?></option>
									<?php endforeach ; ?>
								</select>
							</div>
							<div class="mb-3">
								<label for="q_add" class="form-label fw-bold small text-uppercase">Cantidad Sugerida</label>
								<input type="number" step="any" class="form-control shadow-sm" name="q" id="q_add" required placeholder="0.00">
							</div>
							<div class="mb-3">
								<div class="form-check form-switch mt-2">
									<input class="form-check-input" type="checkbox" name="is_required" id="is_required_add">
									<label class="form-check-label fw-bold text-muted" for="is_required_add">Marcar como obligatorio</label>
								</div>
							</div>
							<div class="text-end mt-4">
								<input type="hidden" name="product_id" value="<?php echo $_GET["id"];?>">
								<button type="button" class="btn btn-light border" data-coreui-dismiss="modal">Cerrar</button>
								<button type="submit" class="btn btn-success fw-bold px-4 shadow-sm"><i class="bi bi-plus-circle me-1"></i> Agregar a Receta</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>
	</div>
</section>
