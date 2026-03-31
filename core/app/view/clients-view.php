<?php 
if(isset($_GET["opt"]) && $_GET['opt']=="all"):
?>

<section class="">
<?php
$data["posts"]=ClientData::getAll();
if(Core::$user->kind==2){
$data["posts"]=ClientData::getAllBy("user_id", Core::$user->id);

}

?>


 <div class="card">
                  <div class="card-header">
                    <strong>Clientes</strong>
                  </div>
                  <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                                                                <a href="./?view=clients&opt=new" class="btn btn-secondary">Nuevo Cliente</a>
                  <!--  <a href="./clientsreport.php" class="btn btn-success" target="_blank">Descargar</a> -->
                                            <?php if(Core::$user->kind==1):?>

<?php endif; ?>
        <br><br>                                                        
                        <div class="box box-primary">
                            <div class="box-body">
                                    <table class="table datatable table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Empresa</th>
                                                <th>Email</th>
                                                <th>Telefono</th>
                                                <th>Domicilio</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($data["posts"] as $post):?>
                                            <tr>
                                                <td><?=$post->name." ".$post->lastname." ".$post->lastname2;?></td>
                                                <td><?=$post->empresa;?></td>
                                                <td><?=$post->email;?></td>
                                                <td><?=$post->phone;?></td>
                                                <td><?=$post->address;?></td>
                                                <td style="width:200px;">
                                                    



                                                <a href="./?view=clients&opt=instalations&id=<?=$post->id;?>" class="btn btn-sm btn-outline-info"><i class="bi-wrench"></i> Instalaciones</a>
                                                <a href="./?view=clients&opt=addresses&id=<?=$post->id;?>" class="btn btn-sm btn-success"><i class="bi-map"></i> Direcciones</a>
                                                <a href="./?view=clients&opt=edit&id=<?=$post->id;?>" class="btn btn-sm btn-warning"><i class="bi-pencil"></i></a>
<!--                                                <a href="./?action=clients&opt=del&id=<?=$post->id;?>" class="btn btn-sm btn-danger"><i class="bi-trash"></i></a> -->
                <?php if(Core::$user->kind==1 || Core::$user->kind==2 || Core::$user->kind==3 || Core::$user->kind==4||Core::$user->kind==5):?>
                                                <a id="delitem-<?=$post->id;?>" class="btn btn-sm btn-danger"><i class="bi-trash"></i></a>
<script type="text/javascript">
<?php if(isset($_SESSION["deleted_item"])):?>
    Swal.fire("Eliminado!", "", "success");
    <?php unset($_SESSION['deleted_item']); endif;?>

    $("#delitem-<?php echo $post->id?>").click(function(){
Swal.fire({
  title: "Estas seguro que deseas Eliminar ?",
  showCancelButton: true,
  showDenyButton: true,

  confirmButtonText: "Eliminar",
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.isConfirmed) {
    window.location = "./?action=clients&opt=del&id=<?=$post->id;?>";
  } else if(result.isDenied){
    Swal.fire("Operacion cancelada!", "", "info");
  }
});

    });
</script>

                                            <?php endif; ?>
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
</div>

                <!-- /.row -->
                </section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="new"):?>


<section class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">


<!-- Inicio de card -->
 <div class="card">
                  <div class="card-header">
                    <strong>Nuevo Cliente</strong>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-12">

                        <form role="form" method="post" action="./?action=clients&opt=add" enctype="multipart/form-data">
<!--

                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" name="image" class="form-control" placeholder="Image">
                            </div>  
                        -->
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="name" class="form-control" placeholder="Nombre">
                            </div>
                            <div class="form-group">
                                <label>Nombre 2</label>
                                <input type="text" name="name2" class="form-control" placeholder="Nombre 2">
                            </div>
                            <div class="form-group">
                                <label>Apellido Paterno</label>
                                <input type="text" name="lastname" class="form-control" placeholder="Apellidos">
                            </div>
                            <div class="form-group">
                                <label>Apellido Materno</label>
                                <input type="text" name="lastname2" class="form-control" placeholder="Apellidos">
                            </div>

                            <div class="form-group">
                                <label>Empresa</label>
                                <input type="text" name="empresa" class="form-control" placeholder="Empresa">
                            </div>

                            <div class="form-group">
                                <label>Fecha de nacimiento:</label>
                                <input type="date" name="fecha_nacimiento" class="form-control" placeholder="Fecha de nacimiento:">
                            </div>
                            <div class="form-group">
                                <label>CURP</label>
                                <input type="text" name="curp" class="form-control" placeholder="CURP">
                            </div>                           
                            <div class="form-group">
                                <label>Clave de elector</label>
                                <input type="text" name="clave_elector" class="form-control" placeholder="Clave de elector">
                            </div>                           
 
                            <div class="form-group">
                                <label>Ocupacion</label>
                                <input type="text" name="trabajo_nombre" class="form-control" placeholder="Ocupacion">
                            </div>
                            <div class="form-group">
                                <label>Domicilio</label>
                                <input type="text" name="address" class="form-control" placeholder="Domicilio">
                            </div>


                            <div class="form-group">
                                <label>Telefono</label>
                                <input type="text" name="phone" class="form-control" placeholder="Telefono">
                            </div>




                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control" placeholder="Email">
                            </div>
                            <!--
                            <div class="form-group">
                                <label>INE Lado 1</label>
                                <input type="file" name="ine_lado1" class="form-control" placeholder="INE Lado 1">
                            </div>  
                            <div class="form-group">
                                <label>INE Lado 2</label>
                                <input type="file" name="ine_lado2" class="form-control" placeholder="INE Lado 2">
                            </div>  
                            <div class="form-group">
                                <label>Foto comprobante de domicilio</label>
                                <input type="file" name="img_domicilio" class="form-control" placeholder="Foto comprobante de domicilio">
                            </div> 
                        -->
                            <div class="form-group">
                                <label>Estado</label>
                                <input type="text" name="estado" class="form-control" placeholder="Estado">
                            </div>
                            <div class="form-group">
                                <label>Municipio</label>
                                <input type="text" name="municipio" class="form-control" placeholder="Municipio">
                            </div>
                            <div class="form-group">
                                <label>Colonia / Localidad</label>
                                <input type="text" name="colonia" class="form-control" placeholder="Colonia / Localidad">
                            </div>
                            <!--
                            <div class="form-group">
                                <label>Foto garantia</label>
                                <input type="file" name="img_garantia" class="form-control" placeholder="Foto garantia">
                            </div>  
                        -->
                            <div class="form-group">
                                <label>Referencia Domiciliaria</label>
                                <input type="text" name="address_ref" class="form-control" placeholder="Referencia Domiciliaria">
                            </div>
                           
                           <!-- <div class="form-group">
                                <label>Ubicacion URL GPS</label>
                                <input type="text" name="url_gps" class="form-control" placeholder="Ubicacion URL GPS">
                            </div>
                        -->
                        <br>
                            <button type="submit" class="btn btn-primary">Agregar</button>

                        </form>

                      </div>
                    </div>
                </div>
            </div>
<!-- Fin de la card -->
                    </div>
                    <div class="col-lg-3">


                    </div>
                </div>
                <!-- /.row -->
<br><br><br><br><br>
</section>
<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="edit"):?>


<section >
<?php
$user = ClientData::getById($_GET["id"]);
?>


                <div class="row">
                    <div class="col-lg-12">
 <div class="card">
                  <div class="card-header">
                    <strong>Modificar Cliente</strong>
                  </div>
                  <div class="card-body">
                        <form role="form" method="post" action="./?action=clients&opt=update" enctype="multipart/form-data">







                            <div class="row">
                                <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="name" value="<?=$user->name;?>" class="form-control" placeholder="Nombre">
                            </div>                                    
                                </div>
                                <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombre 2</label>
                                <input type="text" name="name2" value="<?=$user->name2;?>" class="form-control" placeholder="Nombre 2">
                            </div>                                    
                                </div>
                                <div class="col-md-6">
                            <div class="form-group">
                                <label>Apellido Paterno</label>
                                <input type="text" name="lastname" value="<?=$user->lastname;?>" class="form-control" placeholder="Apellido Paterno">
                            </div>
                                </div>
                                <div class="col-md-6">
                            <div class="form-group">
                                <label>Apellido Materno</label>
                                <input type="text" name="lastname2" value="<?=$user->lastname2;?>" class="form-control" placeholder="Apellido Materno">
                            </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Empresa</label>
                                <input type="text" name="empresa"  value="<?=$user->empresa;?>" class="form-control" placeholder="Empresa">
                            </div>

                            <div class="form-group">
                                <label>Fecha de nacimiento:</label>
                                <input type="date" name="fecha_nacimiento" value="<?=$user->fecha_nacimiento;?>" class="form-control" placeholder="Fecha de nacimiento:">
                            </div>
                            <div class="form-group">
                                <label>Clave de Elector</label>
                                <input type="text" name="clave_elector" value="<?=$user->clave_elector;?>" class="form-control" placeholder="Clave de Elector">
                            </div>
                            <div class="form-group">
                                <label>CURP</label>
                                <input type="text" name="curp" value="<?=$user->curp;?>" class="form-control" placeholder="CURP">
                            </div>
                            <div class="form-group">
                                <label>Ocupacion</label>
                                <input type="text" name="trabajo_nombre" value="<?=$user->trabajo_nombre;?>" class="form-control" placeholder="Ocupacion">
                            </div>
                            <div class="form-group">
                                <label>Domicilio</label>
                                <input type="text" name="address" value="<?=$user->address;?>" class="form-control" placeholder="Domicilio">
                            </div>
                            <div class="form-group">
                                <label>Referencia Domiciliaria</label>
                                <input type="text" name="address_ref" value="<?php echo $user->address_ref; ?>" class="form-control" placeholder="Referencia Domiciliaria">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                <label>Telefono</label>
                                <input type="text" name="phone" value="<?=$user->phone;?>" class="form-control" placeholder="Telefono">
                            </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email" value="<?=$user->email;?>" class="form-control" placeholder="Email">
                            </div>
                                </div>

                            </div>


                            <div class="form-group">
                                <label>Estado</label>
                                <input type="text" name="estado" value="<?php echo $user->estado; ?>" class="form-control" placeholder="Estado">
                            </div>
                            <div class="form-group">
                                <label>Municipio</label>
                                <input type="text" name="municipio" value="<?php echo $user->municipio; ?>" class="form-control" placeholder="Municipio">
                            </div>
                            <div class="form-group">
                                <label>Colonia / Localidad</label>
                                <input type="text" name="colonia" value="<?php echo $user->colonia; ?>" class="form-control" placeholder="Colonia / Localidad">
                            </div>
                            <br>

                            <input type="hidden" name="id" value="<?=$user->id;?>">
                            <button type="submit" class="btn btn-primary">Actualizar Cliente</button>

                        </form>
                    </div>
                </div>

                    </div>

                </div>
                <!-- /.row -->
<br><br><br><br><br>
</section>
<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="addresses"):?>


<section >
<?php
$user = ClientData::getById($_GET["id"]);
$addresses = AddressData::getAllBy("client_id",$user->id);
?>

                <div class="row">
                    <div class="col-lg-12">
<a href="./?view=clients&opt=all" class="btn btn-success"><i class="bi-arrow-left"></i> Regresar</a><br><br>
 <div class="card">
                  <div class="card-header">
                    <strong><?php echo $user->name." ".$user->lastname; ?> - Agregar Nueva Direccion al Cliente</strong>
                  </div>
                  <div class="card-body">
                        <form role="form" method="post" action="./?action=clients&opt=addaddress" enctype="multipart/form-data">







                            <div class="row">
                                <div class="col-md-6">
                            <div class="form-group">
                                <label>Identificador</label>
                                <input type="text" name="name" required class="form-control" placeholder="Identificador">
                            </div>                                    

                            <div class="form-group">
                                <label>Domicilio</label>
                                <input type="text" name="address" class="form-control" placeholder="Domicilio">
                            </div>
                            <div class="form-group">
                                <label>Referencia Domiciliaria</label>
                                <input type="text" name="address_ref"  class="form-control" placeholder="Referencia Domiciliaria">
                            </div>

                            <div class="form-group">
                                <label>Colonia / Localidad</label>
                                <input type="text" name="colonia"  class="form-control" placeholder="Colonia / Localidad">
                            </div>
                            <div class="form-group">
                                <label>Municipio</label>
                                <input type="text" name="municipio" value="Cardenas"  class="form-control" placeholder="Municipio">
                            </div>

                            <div class="form-group">
                                <label>Estado</label>
                                <input type="text" name="estado" value="Tabasco"  class="form-control" placeholder="Estado">
                            </div>

                            <br>

                            <input type="hidden" name="id" value="<?=$user->id;?>">
                            <button type="submit" class="btn btn-primary">Agregar Direccion</button>

                        </form>
                    </div>
                </div>




                    </div>


                </div>
<br>
 <div class="card">
                  <div class="card-header">
                    <strong><?php echo $user->name." ".$user->lastname; ?> - Direcciones Extra Registradas</strong>
                  </div>
                  <div class="card-body">

<?php if(count($addresses)>0):?>
<table class="table table-bordered">
    <thead>
        <th>Identificador</th>
        <th>Domicilio</th>
        <th>Referencia</th>
        <th>Colonia</th>
        <th>Municipio</th>
        <th>Estado</th>
        <th></th>
    </thead>
<?php foreach($addresses as $addr):?>
    <tr>
        <td><?php echo $addr->name; ?></td>
        <td><?php echo $addr->address; ?></td>
        <td><?php echo $addr->address_ref; ?></td>
        <td><?php echo $addr->colonia; ?></td>
        <td><?php echo $addr->municipio; ?></td>
        <td><?php echo $addr->estado; ?></td>
        <td><a href="./?action=clients&opt=deladdress&id=<?php echo $addr->id; ?>&client_id=<?php echo $user->id; ?>" class="btn btn-danger btn-sm"><i class="bi-trash"></i></a></td>

    </tr>
<?php endforeach;?>
</table>
<?php else:?>
    <p class="alert alert-warning">No hay direcciones extra</p>
<?php endif; ?>
                    </div>
                </div>

<br>




                <!-- /.row -->
<br><br><br><br><br>
</section>
<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="instalations"):?>


<section >
<?php
$user = ClientData::getById($_GET["id"]);
$addresses = InstalationData::getAllBy("client_id",$user->id);
?>

                <div class="row">
                    <div class="col-lg-12">
<a href="./?view=clients&opt=all" class="btn btn-success"><i class="bi-arrow-left"></i> Regresar</a><br><br>




                    </div>


                </div>
<br>
 <div class="card">
                  <div class="card-header">
                    <strong><?php echo $user->name." ".$user->lastname; ?> - Listado de instalaciones</strong>
                  </div>
                  <div class="card-body">

<?php if(count($addresses)>0):?>

                                    <table class="table datatable table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Codigo</th>
                                                <th>Fecha</th>
                                                <th>Cliente</th>
                                                <th>Equipo</th>
                                                <th>$ </th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $tot_entrada = $tot_salida =0; foreach($addresses as $post):
                                       ?>
                                            <tr>
                                                <td><a href="./?view=instalations&opt=open&id=<?=$post->id;?>" class="btn btn-sm btn-info"><i class="bi-folder"></i></a></td>
                                                <td><?=$post->code ;?></td>
                                                <td><?=$post->date_at ;?></td>
                                                <td><?php if($post->client_id){ $cli= ClientData::getById($post->client_id) ; echo $cli->name." ".$cli->lastname ;} ?></td>
                                                <td><?php if($post->item_extern_id){ $clit= ItemData::getById($post->item_extern_id) ; echo $clit->name." - ".$clit->serie ;} ?> <?php if($post->item_intern_id){ $clit= ItemData::getById($post->item_intern_id) ; echo $clit->name." - ".$clit->serie ;} ?></td>
                                                <td>$ <?=$post->amount ;?></td>
                                                <td style="width:170px;">
                                                    
                                               <!-- <a href="./?view=instalations&opt=edit&id=<?=$post->id;?>" class="btn btn-sm btn-warning"><i class="bi-pencil"></i></a>-->
 <?php if(Core::$user->kind==1 || Core::$user->kind==2 || Core::$user->kind==3):?>
                                            
                                               <!-- <a id="delitem-<?=$post->id;?>" class="btn btn-sm btn-danger"><i class="bi-trash"></i></a>-->

<script type="text/javascript">
    $("#delitem-<?php echo $post->id?>").click(function(){
Swal.fire({
  title: "Estas seguro que deseas Eliminar ?",
  showCancelButton: true,
  showDenyButton: true,

  confirmButtonText: "Eliminar",
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.isConfirmed) {
    window.location = "./?action=instalations&opt=del&id=<?=$post->id;?>";
  } else if(result.isDenied){
    Swal.fire("Operacion cancelada!", "", "info");
  }
});

    });
</script>
<?php endif; ?>
                                    </td>
                                </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>

<?php else:?>
    <p class="alert alert-warning">No hay instalaciones</p>
<?php endif; ?>
                    </div>
                </div>

<br>




                <!-- /.row -->
<br><br><br><br><br>
</section>
<?php endif; ?>
