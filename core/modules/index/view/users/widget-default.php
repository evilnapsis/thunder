<section class="content-header">
			<h1>Lista de Usuarios</h1>		

</section>
<section class="content">
<div class="row">

	<div class="col-md-12">
	<!-- Single button -->
<div class="btn-group">
  <button type="button" class="btn  btn-default dropdown-toggle" data-toggle="dropdown">
    <i class='glyphicon glyphicon-user'></i> Nuevo Usuario
  </button>
  <ul class="dropdown-menu" role="menu">
<!--    <li><a href="index.php?view=newadmin">Nuevo Administrador</a></li> -->
    <li><a href="index.php?view=newcajero">Nuevo Cajero</a></li>
    <li><a href="index.php?view=newmesero">Nuevo Mesero</a></li>
  </ul>
</div>
<br>

		<?php
		$users = UserData::getAll();
		if(count($users)>0){
			// si hay usuarios
			?>
<div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"></h3>

                                </div>
                                <div class="box-body table-responsive">

			<table class="table table-bordered table-hover datatable">
			<thead>
			<th>Nombre completo</th>
			<th>Email</th>
			<th></th>
			<th></th>
			</thead>
			<?php
			foreach($users as $user){
				?>
				<tr>
				<td><?php echo $user->name." ".$user->lastname; ?></td>
				<td><?php echo $user->email; ?></td>
				<td>
					<?php 
					if($user->is_admin){ echo "Adminsitrador"; }
					else if($user->is_mesero){ echo "Mesero"; }
					else if($user->is_cajero){ echo "Cajero"; }
					?>

				</td>
				<td style="width:90px;">
					<a href="index.php?view=edituser&id=<?php echo $user->id; ?>" class="btn btn-warning btn-sm"><i class="glyphicon glyphicon-pencil"></i></a>
					<a href="index.php?view=deluser&id=<?php echo $user->id; ?>" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash"></i></a>

				</td>
				</tr>
				<?php

			}
			print "</table></div></div>";


		}else{
			// no hay usuarios
		}


		?>


	</div>
</div>
</section>