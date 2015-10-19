<?php $u = UserData::getById($_GET["id"]);?>
<div class="row">
<div class="col-md-8 col-md-offset-2">
<h2>Editar Usuario</h2>
<form class="form-horizontal" method="post" action="index.php?view=updateuser" role="form">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Nombre</label>
    <div class="col-lg-10">
      <input type="text" class="form-control" name="name" value="<?php echo $u->name; ?>" id="name" placeholder="Nombre">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Apellidos</label>
    <div class="col-lg-10">
      <input type="text" class="form-control" name="lastname" value="<?php echo $u->lastname; ?>" id="lastname" placeholder="Apellidos">
    </div>
  </div>

  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Email</label>
    <div class="col-lg-10">
      <input type="text" class="form-control" name="email" value="<?php echo $u->email; ?>" id="email" placeholder="Email">
    </div>
  </div>

  <div class="form-group">
    <label for="inputPassword1" class="col-lg-2 control-label">Nuevo Password</label>
    <div class="col-lg-10">
      <input type="password" class="form-control" name="password" id="password" placeholder="Password">
    </div>
  </div>

  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <input type="hidden" name="user_id" value="<?php echo $_GET["id"];?>">
      <button type="submit" class="btn btn-default">Editar Usuario</button>
    </div>
  </div>
</form>
</div>
</div>