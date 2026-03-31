<?php 
if(isset($_GET["opt"]) && $_GET["opt"]=="all"):
		$grades = CategoryData::getAll();
?>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<?php if(isset($_COOKIE["gradeupdated"])):?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<i class="bi bi-check-circle me-2"></i> La categoria <b><?php echo $_COOKIE["gradeupdated"]; ?></b> ha sido actualizada.
					<button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
				</div>
				<?php setcookie("gradeupdated","",time()-18600); endif; ?>

			<?php if(isset($_COOKIE["gradedeleted"])):?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<i class="bi bi-dash-circle me-2"></i> La categoria <b><?php echo $_COOKIE["gradedeleted"]; ?></b> ha sido eliminada.
					<button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
				</div>
				<?php setcookie("gradedeleted","",time()-18600); endif; ?>

			<?php if(isset($_COOKIE["gradeadded"])):?>
				<div class="alert alert-info alert-dismissible fade show" role="alert">
					<i class="bi bi-info-circle me-2"></i> La categoria <b><?php echo $_COOKIE["gradeadded"]; ?></b> ha sido agregada.
					<button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
				</div>
				<?php setcookie("gradeadded","",time()-18600); endif; ?>

			<div class="card mb-4">
				<div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
					<h5 class="mb-0"><i class="bi bi-list-ul me-2"></i> Categorías</h5>
					<button type="button" class="btn btn-sm btn-light shadow-sm text-primary fw-bold px-3" data-coreui-toggle="modal" data-coreui-target="#newCategoryModal">
						<i class="bi bi-plus-circle me-1"></i> Agregar Categoría
					</button>
				</div>
				<div class="card-body">
					<?php if(count($grades)>0):?>
						<div class="table-responsive">
							<table class="table table-bordered table-hover datatable nowrap" style="width:100%">
								<thead class="table-light">
									<tr>
										<th>Nombre</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($grades as $career):?>
										<tr>
											<td><b><?php echo $career->name; ?></b></td>
											<td>
												<div class="btn-group btn-group-sm">
													<a href="index.php?view=categories&opt=edit&id=<?php echo $career->id; ?>" class="btn btn-outline-warning" title="Editar"><i class="bi bi-pencil me-1"></i> Editar</a>
													<a href="javascript:void(0)" id="del-<?php echo $career->id; ?>" class="btn btn-outline-danger" title="Eliminar"><i class="bi bi-trash me-1"></i> Eliminar</a>
												</div>
												<script>
													$("#del-<?php echo $career->id?>").click(function(){
														if(confirm("¿Seguro que desea eliminar esta categoría?")){
															window.location = "index.php?action=categories&opt=del&id=<?php echo $career->id; ?>";
														}
													});
												</script>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					<?php else: ?>
						<div class="alert alert-warning mb-0">
							<i class="bi bi-exclamation-triangle me-2"></i> No hay categorías registradas.
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal Nueva Categoría -->
	<div class="modal fade" id="newCategoryModal" tabindex="-1" aria-labelledby="newCategoryModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content shadow">
				<div class="modal-header bg-success text-white">
					<h5 class="modal-title" id="newCategoryModalLabel"><i class="bi bi-plus-circle me-2"></i> Agregar Categoría</h5>
					<button type="button" class="btn-close btn-close-white" data-coreui-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body py-4">
					<form method="post" action="index.php?action=categories&opt=add">
						<div class="mb-3">
							<label for="category_name" class="form-label fw-bold">Nombre de la Categoría</label>
							<input type="text" class="form-control" name="name" id="category_name" placeholder="Ej. Bebidas, Postres" required>
						</div>
						<div class="text-end mt-4">
							<button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-success text-white"><i class="bi bi-save me-1"></i> Guardar Categoría</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="edit"):
$user = CategoryData::getById($_GET["id"]);
?>
<section class="content">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card mb-4 border-success">
				<div class="card-header bg-success text-white">
					<h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i> Editar Categoría: <?php echo $user->name; ?></h5>
				</div>
				<div class="card-body">
					<form class="form-horizontal" method="post" action="index.php?action=categories&opt=update" role="form">
						<div class="row mb-3">
							<label for="name" class="col-lg-3 col-form-label">Nombre*</label>
							<div class="col-lg-9">
								<input type="text" name="name" value="<?php echo $user->name;?>" class="form-control" id="name" placeholder="Nombre" required>
							</div>
						</div>
						<div class="row mt-4">
							<div class="col-lg-9 offset-lg-3">
								<input type="hidden" name="user_id" value="<?php echo $user->id;?>">
								<button type="submit" class="btn btn-success"><i class="bi bi-arrow-repeat me-1"></i> Actualizar Categoría</button>
								<a href="index.php?view=categories&opt=all" class="btn btn-secondary ms-2"><i class="bi bi-arrow-left me-1"></i> Cancelar</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>