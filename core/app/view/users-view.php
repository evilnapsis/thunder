<?php 
if(isset($_GET["opt"]) && $_GET["opt"]=="all"):
		$users = UserData::getAll();
?>
<section class="content-header">
			<h1>Lista de Usuarios</h1>		
</section>
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card mb-4">
					<div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
						<h5 class="mb-0 text-white"><i class="bi bi-people me-2"></i> Gestión de Usuarios</h5>
						<div class="btn-group shadow-sm">
							<a href="index.php?view=users&opt=new&kind=admin" class="btn btn-sm btn-light text-primary fw-bold border-end border-primary border-opacity-25" title="Nuevo Administrador">
								<i class="bi bi-person-lock me-1"></i> Admin
							</a>
							<a href="index.php?view=users&opt=new&kind=cajero" class="btn btn-sm btn-light text-primary fw-bold border-end border-primary border-opacity-25" title="Nuevo Cajero">
								<i class="bi bi-calculator me-1"></i> Cajero
							</a>
							<a href="index.php?view=users&opt=new&kind=mesero" class="btn btn-sm btn-light text-primary fw-bold" title="Nuevo Mesero">
								<i class="bi bi-person-badge me-1"></i> Mesero
							</a>
						</div>
					</div>
					<div class="card-body">
						<?php if(count($users)>0): ?>
							<div class="table-responsive">
								<table class="table table-bordered table-hover datatable nowrap" style="width:100%">
									<thead class="table-light">
										<tr>
											<th>Nombre completo</th>
											<th>Email</th>
											<th>Tipo</th>
											<th>Acciones</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($users as $user): ?>
											<tr>
												<td><?php echo $user->name." ".$user->lastname; ?></td>
												<td><?php echo $user->email; ?></td>
												<td>
													<span class="badge <?php 
														if($user->is_admin) echo 'bg-dark';
														else if($user->is_mesero) echo 'bg-info';
														else if($user->is_cajero) echo 'bg-primary';
													?> text-white">
														<?php 
														if($user->is_admin) echo "Administrador";
														else if($user->is_mesero) echo "Mesero";
														else if($user->is_cajero) echo "Cajero";
														?>
													</span>
												</td>
												<td>
													<div class="btn-group btn-group-sm">
														<a href="index.php?view=users&opt=edit&id=<?php echo $user->id; ?>" class="btn btn-outline-warning" title="Editar"><i class="bi bi-pencil me-1"></i> Editar</a>
														<a href="index.php?action=users&opt=del&id=<?php echo $user->id; ?>" class="btn btn-outline-danger" title="Eliminar" onclick="return confirm('¿Seguro que desea eliminar este usuario?')"><i class="bi bi-trash me-1"></i> Eliminar</a>
													</div>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						<?php else: ?>
							<div class="alert alert-warning mb-0">
								<i class="bi bi-exclamation-triangle me-2"></i> No se encontraron usuarios registrados.
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="new"): ?>
<section class="content">
	<div class="container-fluid">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card mb-4 border-success">
					<div class="card-header bg-success text-white">
						<h5 class="mb-0">
							<i class="bi bi-person-plus me-2"></i> Nuevo Usuario 
							<?php 
							if($_GET["kind"]=="cajero") echo "(Cajero)";
							else if($_GET["kind"]=="mesero") echo "(Mesero)";
							?>
						</h5>
					</div>
					<div class="card-body">
						<form class="form-horizontal" method="post" action="index.php?action=users&opt=add" role="form">
							<div class="row mb-3">
								<label for="name" class="col-lg-3 col-form-label">Nombre</label>
								<div class="col-lg-9">
									<input type="text" class="form-control" name="name" id="name" placeholder="Nombre" required>
								</div>
							</div>
							<div class="row mb-3">
								<label for="lastname" class="col-lg-3 col-form-label">Apellidos</label>
								<div class="col-lg-9">
									<input type="text" class="form-control" name="lastname" id="lastname" placeholder="Apellidos" required>
								</div>
							</div>
							<div class="row mb-3">
								<label for="username" class="col-lg-3 col-form-label">Nombre de usuario</label>
								<div class="col-lg-9">
									<input type="text" class="form-control" name="username" id="username" placeholder="Nombre de usuario" required>
								</div>
							</div>
							<div class="row mb-3">
								<label for="email" class="col-lg-3 col-form-label">Email</label>
								<div class="col-lg-9">
									<input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
								</div>
							</div>
							<div class="row mb-3">
								<label for="password" class="col-lg-3 col-form-label">Password</label>
								<div class="col-lg-9">
									<input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
								</div>
							</div>
							<div class="row mb-4">
								<label class="col-lg-3 col-form-label fw-bold">Rol del Usuario</label>
								<div class="col-lg-9">
									<div class="btn-group w-100 shadow-sm" role="group" aria-label="Role selection">
										<input type="radio" class="btn-check" name="kind" id="role_admin" value="admin" <?php if(isset($_GET["kind"]) && $_GET["kind"]=="admin") echo "checked";?>>
										<label class="btn btn-outline-primary fw-bold" for="role_admin"><i class="bi bi-person-lock me-1"></i> Admin</label>

										<input type="radio" class="btn-check" name="kind" id="role_cajero" value="cajero" <?php if(isset($_GET["kind"]) && $_GET["kind"]=="cajero") echo "checked";?>>
										<label class="btn btn-outline-primary fw-bold" for="role_cajero"><i class="bi bi-calculator me-1"></i> Cajero</label>

										<input type="radio" class="btn-check" name="kind" id="role_mesero" value="mesero" <?php if(isset($_GET["kind"]) && $_GET["kind"]=="mesero") echo "checked";?>>
										<label class="btn btn-outline-primary fw-bold" for="role_mesero"><i class="bi bi-person-badge me-1"></i> Mesero</label>
									</div>
									<small class="text-muted d-block mt-2"><i class="bi bi-info-circle me-1"></i> Seleccione el rol principal que desempeñará el usuario.</small>
								</div>
							</div>

							<div class="row mt-4">
								<div class="col-lg-9 offset-lg-3">
									<button type="submit" class="btn btn-success"><i class="bi bi-save me-1"></i> Crear Usuario</button>
									<a href="index.php?view=users&opt=all" class="btn btn-secondary ms-2"><i class="bi bi-arrow-left me-1"></i> Cancelar</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="edit"):
$u = UserData::getById($_GET["id"]);
?>
<section class="content">
	<div class="container-fluid">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card mb-4 border-success">
					<div class="card-header bg-success text-white">
						<h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i> Editar Usuario: <?php echo $u->name." ".$u->lastname; ?></h5>
					</div>
					<div class="card-body">
						<form class="form-horizontal" method="post" action="index.php?action=users&opt=update" role="form">
							<div class="row mb-3">
								<label for="name" class="col-lg-3 col-form-label">Nombre</label>
								<div class="col-lg-9">
									<input type="text" class="form-control" name="name" value="<?php echo $u->name; ?>" id="name" placeholder="Nombre" required>
								</div>
							</div>
							<div class="row mb-3">
								<label for="lastname" class="col-lg-3 col-form-label">Apellidos</label>
								<div class="col-lg-9">
									<input type="text" class="form-control" name="lastname" value="<?php echo $u->lastname; ?>" id="lastname" placeholder="Apellidos" required>
								</div>
							</div>

							<div class="row mb-3">
								<label for="email" class="col-lg-3 col-form-label">Email</label>
								<div class="col-lg-9">
									<input type="text" class="form-control" name="email" value="<?php echo $u->email; ?>" id="email" placeholder="Email" required>
								</div>
							</div>

							<div class="row mb-3">
								<label for="password" class="col-lg-3 col-form-label">Nuevo Password</label>
								<div class="col-lg-9">
									<input type="password" class="form-control" name="password" id="password" placeholder="Password">
									<small class="text-muted"><i class="bi bi-info-circle me-1"></i> Dejar en blanco para mantener el actual.</small>
								</div>
							</div>
							<div class="row mb-4">
								<label class="col-lg-3 col-form-label fw-bold">Rol del Usuario</label>
								<div class="col-lg-9">
									<div class="btn-group w-100 shadow-sm" role="group">
										<input type="radio" class="btn-check" name="kind" id="edit_role_admin" value="admin" <?php if($u->is_admin) echo "checked";?>>
										<label class="btn btn-outline-primary fw-bold" for="edit_role_admin"><i class="bi bi-person-lock me-1"></i> Admin</label>

										<input type="radio" class="btn-check" name="kind" id="edit_role_cajero" value="cajero" <?php if($u->is_cajero) echo "checked";?>>
										<label class="btn btn-outline-primary fw-bold" for="edit_role_cajero"><i class="bi bi-calculator me-1"></i> Cajero</label>

										<input type="radio" class="btn-check" name="kind" id="edit_role_mesero" value="mesero" <?php if($u->is_mesero) echo "checked";?>>
										<label class="btn btn-outline-primary fw-bold" for="edit_role_mesero"><i class="bi bi-person-badge me-1"></i> Mesero</label>
									</div>
								</div>
							</div>

							<div class="row mt-4">
								<div class="col-lg-9 offset-lg-3">
									<input type="hidden" name="user_id" value="<?php echo $_GET["id"];?>">
									<button type="submit" class="btn btn-success"><i class="bi bi-arrow-repeat me-1"></i> Actualizar Usuario</button>
									<a href="index.php?view=users&opt=all" class="btn btn-secondary ms-2"><i class="bi bi-arrow-left me-1"></i> Cancelar</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>