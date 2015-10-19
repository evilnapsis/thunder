<div class="row">
	<div class="col-md-4">
	<?php 
  //ob_start();
	$u = UserData::getById(Session::getUID());

	echo "<h2>".$u->name." ".$u->lastname."</h2>"; ?>
	<br>
		<div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">&nbsp;</h3>
            </div>
        	<div class="list-group">
					<a href='index.php?view=security' class='list-group-item'><i class="glyphicon glyphicon-chevron-right"></i> Seguridad y privacidad</a>
			</div>
        </div>
	</div>
	<div class="col-md-8">
	<h2>Cambiar Contraseñaa</h2>
  <?php 
  setcookie("password_not_updated","");
//print_r($_COOKIE);
  if(isset($_COOKIE['password_not_updated'])):?>
        <div class="alert alert-danger">
        <p>La contraseña actual es incorrecta. Error no se pudo cambiar la contraseña.</p>
        </div>
      <?php setcookie("password_not_updated","",time()-18600);
       endif; ?>
<br>	<form class="form-horizontal" id="changepasswd" method="post" action="index.php?view=changepasswd" role="form">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Contraseña Actual</label>
    <div class="col-lg-10">
      <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña Actual">
    </div>
  </div>

  <div class="form-group">
    <label for="inputPassword1" class="col-lg-2 control-label">Nueva Contraseña</label>
    <div class="col-lg-10">
      <input type="password" class="form-control"  id="newpassword" name="newpassword" placeholder="Nueva Contraseña">
    </div>
  </div>

  <div class="form-group">
    <label for="inputPassword1" class="col-lg-2 control-label">Confirmar Nueva Contraseña</label>
    <div class="col-lg-10">
      <input type="password" class="form-control" id="confirmnewpassword" name="confirmnewpassword" placeholder="Confirmar Nueva Contraseña">
    </div>
  </div>



  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <button type="submit" class="btn btn-success btn-lg">Cambiar Contraseña</button>
    </div>
  </div>
</form>

<script>
$("#changepasswd").submit(function(e){
	if($("#password").val()=="" || $("#newpassword").val()=="" || $("#confirmnewpassword").val()==""){
		e.preventDefault();
		alert("No debes dejar espacios vacios.");

	}else{
		if($("#newpassword").val() == $("#confirmnewpassword").val()){
//			alert("Correcto");			
		}else{
			e.preventDefault();
			alert("Las nueva contraseña no coincide con la confirmacion.");
		}
	}
});

</script>
	</div>
</div>
<br><br><br><br><br><br><br><br><br>