<?php 

//if(!isset($_SESSION["user_id"])){ Core::redir("./");}
//$user= UserData::getById($_SESSION["user_id"]);
// si el id  del usuario no existe.
//if($user==null){ Core::redir("./");}

if(isset($_GET["opt"]) && $_GET["opt"]=="all"):?>
<section class="">
<div class="row">
	<div class="col-md-12">
		<h1>Inversionistas</h1>
	<a href="./?view=investors&opt=new" class="btn btn-secondary"><i class='bi-person'></i> Nuevo Inversionista</a>
<br><br>
<div class="card">
  <div class="card-body">
		<?php
		$users = UserData::getAllBy("kind",3);
		if(count($users)>0){
			?>
			<div class="box box-primary">
			<table class="table datatable table-bordered datatable table-hover">
			<thead>
                <th style="width: 30px; "></th>
			<th>Nombre completo</th>
			<th>Email</th>
      <th>Saldo</th>
      <th>Status</th>
			<th></th>
			</thead>
			<?php
			foreach($users as $user):
				?>
				<tr>
                    <td style="width: 30px; ">
                        <a href="./?view=investors&opt=open&id=<?php echo $user->id; ?>" class="btn btn-sm btn-secondary"><i class="bi bi-folder"></i></a>
                    </td>
				<td><?php echo $user->name." ".$user->lastname; ?></td>
				<td><?php echo $user->email; ?></td>
        <td>
          <?php 
          //if($user->kind==1){ echo "Administrador"; }
          //else if($user->kind==2){ echo "Usuario normal"; }
          // echo KindData::getById($user->kind)->name;
          ?>
        </td>
        <td><?php if($user->status==1){ echo "Activo";}else { echo "Inactivo"; } ?></td>
				<td style="width:200px;">
				<a href="index.php?view=investors&opt=edit&id=<?php echo $user->id;?>" class="btn btn-warning btn-sm"><i class="bi-pencil"></i></a>
				<a id="delitem-<?php echo $user->id;?>" class="btn btn-danger btn-sm"><i class="bi-trash"></i></a>
  <?php if(Core::$user->kind==1 || Core::$user->kind==2):?>

<script type="text/javascript">

    $("#delitem-<?php echo $user->id?>").click(function(){
Swal.fire({
  title: "Estas seguro que deseas Eliminar ?",
  showCancelButton: true,
  showDenyButton: true,

  confirmButtonText: "Eliminar",
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.isConfirmed) {
    window.location = "./?action=investors&opt=del&id=<?=$user->id;?>";
  } else if(result.isDenied){
    Swal.fire("Operacion cancelada!", "", "info");
  }
});

    });
</script>
<?php endif;?>
				</td>
				</tr>
				<?php

			endforeach; ?>
</table>
</div>
<?php		}else{
			?>
			<p class="alert alert-warning">No hay inversionistas.</p>
			<?php
		}

		?>
	</div>
</div>

	</div>
</div>
</section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="open"):
    $investor = UserData::getById($_GET["id"]);
    $operations= OperationData::getAllByUser($investor->id);
    $incomes = OperationData::getIncomesByUser($investor->id);
    $withdrawals = OperationData::getWithdrawalsByUser($investor->id);
    ?>
<section class="">
<div class="row">
	<div class="col-md-12">
	<h1>Informacion del inversionista</h1>

  <div class="card">
    <div class="card-body">
<p><b>Nombre: </b> <?php echo $investor->name." ".$investor->lastname; ?></p>
<p><b>Email: </b> <?php echo $investor->email."    <b>Telefono: </b>"; ?></p>
<p><b>Saldo: </b> $ <?php echo ($incomes->total-$withdrawals->total); ?></p>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-coreui-toggle="modal" data-coreui-target="#exampleModal">
  Depositar Saldo
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Saldo</h1>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form method="post" action="./?action=operations&opt=addincome">
        <input type="hidden" name="user_id" value="<?php echo $investor->id; ?>">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Descripcion</label>
    <input type="text" name="description" placeholder="Descripcion" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Monto $</label>
    <input type="text" name="amount" placeholder="Monto $" class="form-control" id="exampleInputPassword1">
  </div>
<!--  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div>
-->
  <button type="submit" class="btn btn-primary">Depositar Saldo</button>
</form>
      </div>

    </div>
     </div>
    </div>
<!-- -->
<!-- Button trigger modal -->
<button type="button" class="btn btn-success" data-coreui-toggle="modal" data-coreui-target="#exampleModal2">
  Retirar Saldo
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Retirar Saldo</h1>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form method="post" action="./?action=operations&opt=addwithdrawal">
        <input type="hidden" name="user_id" value="<?php echo $investor->id; ?>">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Descripcion</label>
    <input type="text" name="description" placeholder="Descripcion" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Monto $</label>
    <input type="text" name="amount" placeholder="Monto $" class="form-control" id="exampleInputPassword1">
  </div>
<!--  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div>
-->
  <button type="submit" class="btn btn-success">Retirar Saldo</button>
</form>
      </div>

    </div>
     </div>
    </div>
<!-- -->
</div>
</div>
<br>
<div class="card">
    <div class="card-body">
        <?php if(count($operations)>0):?>
            <table class="table table-bordered table-hover table-condensed">
                <thead>
                    <th></th>
                    <th>Monto</th>
                    <th>Tipo</th>
                    <th>Fecha</th>
                </thead>
                <?php foreach($operations as $op):?>
                    <tr>
                        <td></td>
                        <td>$ <?php echo $op->amount; ?></td>
                        <td>
                            <?php if($op->operation_type==1){ echo "Deposito"; }else if($op->operation_type==2){ echo "Retiro"; }?>
                        </td>
                        <td><?php echo $op->created_at; ?></td>
                    </tr>
                    <?php endforeach; ?>
            </table>
            <?php else:?>
                <p class="alert alert-warning">No hay movimientos.</p>
                <?php endif; ?>
    </div>
</div>

</div>
</div>
</section>
<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="new"):?>
<section class="">
<div class="row">
	<div class="col-md-12">
	<h1>Agregar Inversionista</h1>
	<br>
  <div class="card">
    <div class="card-body">
<form class="form-horizontal" method="post" id="addproduct" action="index.php?action=investors&opt=add" role="form">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
    <div class="col-md-6">
      <input type="text" name="name" class="form-control" id="name" placeholder="Nombre">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Apellido*</label>
    <div class="col-md-6">
      <input type="text" name="lastname" required class="form-control" id="lastname" placeholder="Apellido">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Email*</label>
    <div class="col-md-6">
      <input type="text" name="email" class="form-control" id="email" placeholder="Email">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Contrase&ntilde;a</label>
    <div class="col-md-6">
      <input type="password" name="password" class="form-control" id="inputEmail1" placeholder="Contrase&ntilde;a">
    </div>
  </div>
<input type="hidden" value="3" name="kind">

<br>
  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <button type="submit" class="btn btn-primary">Agregar Inversionista</button>
    </div>
  </div>
</form>
</div>
</div>

</div>
</div>
</section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="edit"):?>
<div class="">
<?php $user = UserData::getById($_GET["id"]);?>
<div class="row">
	<div class="col-md-12">
	<h1>Editar Usuario</h1>
	<br>
		<form class="form-horizontal" method="post" id="addproduct" action="index.php?action=investors&opt=upd" role="form">


  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Nombre*</label>
    <div class="col-md-6">
      <input type="text" name="name" value="<?php echo $user->name;?>" class="form-control" id="name" placeholder="Nombre">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Apellido*</label>
    <div class="col-md-6">
      <input type="text" name="lastname" value="<?php echo $user->lastname;?>" required class="form-control" id="lastname" placeholder="Apellido">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Email*</label>
    <div class="col-md-6">
      <input type="text" name="email" value="<?php echo $user->email;?>" class="form-control" id="email" placeholder="Email">
    </div>
  </div>

  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Contrase&ntilde;a</label>
    <div class="col-md-6">
      <input type="password" name="password" class="form-control" id="inputEmail1" placeholder="Contrase&ntilde;a">
<p class="help-block">La contrase&ntilde;a solo se modificara si escribes algo, en caso contrario no se modifica.</p>
    </div>
  </div>
  <input type="hidden" value="3" name="kind">

  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Status</label>
    <div class="col-md-6">
      <select name="status" class="form-control" required>
        <option value="1" <?php if($user->status==1){ echo "selected"; } ?>>Activo</option>
        <option value="0" <?php if($user->status==0){ echo "selected"; } ?>>Inactivo</option>
      </select>

    </div>
  </div>
  <br><br>
  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
    <input type="hidden" name="user_id" value="<?php echo $user->id;?>">
      <button type="submit" class="btn btn-primary">Actualizar Inversionista</button>
    </div>
  </div>
</form>
	</div>
</div>
</div>
<?php endif; ?>