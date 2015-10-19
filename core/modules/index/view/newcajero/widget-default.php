<section class="content-header">
<h1>Nuevo Cajero</h1>
</section>
<section class="content">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"></h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-primary btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body table-responsive"><form class="form-horizontal" method="post" action="index.php?view=adduser" role="form">
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Nombre</label>
    <div class="col-lg-10">
      <input type="text" class="form-control" name="name" id="name" placeholder="Nombre">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Apellidos</label>
    <div class="col-lg-10">
      <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Apellidos">
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Nombre de usuario</label>
    <div class="col-lg-10">
      <input type="text" class="form-control" name="email" id="email" placeholder="Nombre de usuario">
    </div>
  </div>

  <div class="form-group">
    <label for="inputPassword1" class="col-lg-2 control-label">Password</label>
    <div class="col-lg-10">
      <input type="password" class="form-control" name="password" id="password" placeholder="Password">
    </div>
  </div>
  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
    <input type="hidden" name="is_cajero" value="1">
      <button type="submit" class="btn btn-primary">Nuevo Cajero</button>
    </div>
  </div>
</form>
</div>
</div>
</div>
</div>
</section>