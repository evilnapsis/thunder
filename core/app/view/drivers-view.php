<?php 
if(isset($_GET["opt"]) && $_GET['opt']=="all"):
?>
<section class="">
<?php
$data["posts"]=DriverData::getAll();
?>
 <div class="card">
                  <div class="card-header">
                    <strong>Conductores</strong>
                  </div>
                  <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                    <a href="./?view=drivers&opt=new" class="btn btn-secondary">Nuevo Conductor</a>
                    <a href="./driverreport.php" class="btn btn-success" target="_blank">Descargar</a><br><br>
                        <div class="box box-primary">
                            <div class="box-body">
                                    <table class="table datatable table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Direccion</th>
                                                <th>Licencia</th>
                                                <th>Tipo Licencia</th>
                                                <th>Vencimiento</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($data["posts"] as $post):?>
                                            <tr>
                                                <td><?=$post->name ;?></td>
                                                <td><?=$post->address ;?></td>
                                                <td><?=$post->licencia ;?></td>
                                                <td><?=$post->tipo_licencia ;?></td>
                                                <td><?=$post->expire_at ;?></td>
                                                <td style="width:170px;">
                                                    
                                                <a href="./?view=drivers&opt=edit&id=<?=$post->id;?>" class="btn btn-sm btn-warning"><i class="bi-pencil"></i></a>
 <?php if(Core::$user->kind==1 || Core::$user->kind==2 || Core::$user->kind==3):?>                                         
                                            
                                                <a id="delitem-<?=$post->id;?>" class="btn btn-sm btn-danger"><i class="bi-trash"></i></a>

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
    window.location = "./?action=drivers&opt=del&id=<?=$post->id;?>";
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
            <!-- Breadcrumb-->



<section class="">

                <div class="row">
                    <div class="col-lg-8">


<!-- Inicio de card -->
 <div class="card">
                  <div class="card-header">
                    <strong>Nuevo Conductor</strong>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-12">


                        <form role="form" id="search_contrato">
<div class="row">
    <div class="col-md-6">
                                    <div class="form-group">
                                <label># Id , nombre, Curp del Cliente <a type="button" class="btn btn-link" data-coreui-toggle="modal" data-coreui-target="#exampleModal">
  (Nuevo Ciudadano)
</a></label>
                                <input type="text" name="code" required class="form-control" placeholder="# Curp o nombre">
                            </div>
    </div>
    <div class="col-md-6">
        <br>
                            <button type="submit" class="btn btn-primary">Buscar Cliente</button>
    </div>
</div>

                            
                        </form>
<script type="text/javascript">
    $("#search_contrato").submit(function(e){
        e.preventDefault();
        $.get("./?action=buscarclientejson",$("#search_contrato").serialize(), function(data){
           // console.log(data);

            result = JSON.parse(data);
            //alert(result.curp);
            if(result!=""){
                $("#dri_curp").val(result.curp);
                $("#dri_name").val(result.name+" "+result.name2+" "+result.lastname+" "+result.lastname2);
                $("#dri_address").val(result.address);

            }else{
                alert("No hay resultados");
            }


        });
    });
    </script>


                        <form role="form" method="post" action="./?action=drivers&opt=add" enctype="multipart/form-data">
                            <!--
                            <div class="form-group">
                                <label>Imagen (480x480)</label>
                                <input type="file" name="image">
                            </div>
                        -->



                           <div class="form-group">
                                <label>CURP</label>
                                <input type="text" required readonly name="curp" id="dri_curp" class="form-control" placeholder="CURP">
                            </div>


                            <div class="form-group">
                                <label>Nombre Completo</label>
                                <input type="text" name="name" id="dri_name" class="form-control" placeholder="Nombre Completo">
                            </div>

                            <div class="form-group">
                                <label>Direccion</label>
                                <input type="text" name="address" id="dri_address" class="form-control" placeholder="Direccion">
                            </div>
                            <div class="form-group">
                                <label># Licencia</label>
                                <input type="text" name="licencia" required class="form-control" placeholder="# Licencia">
                            </div>                            
                            <div class="form-group">
                                <label>Tipo de Licencia</label>
                                <input type="text" name="tipo_licencia" required class="form-control" placeholder="Tipo de Licencia">
                            </div>
<div class="form-group">
                                <label>Fecha de Vencimiento</label>
                                <input type="date" name="expire_at" required class="form-control" placeholder="Fecha de Vencimiento">
                            </div>
<br>
                            <button type="submit" class="btn btn-primary">Agregar Conductor</button>

                        </form>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo Ciudadano</h1>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
 <form role="form" method="post" id="addciudadano" enctype="multipart/form-data">

<div class="row">
    <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="name" id="ciuda_name" class="form-control" placeholder="Nombre">
                            </div>
    </div>
    <div class="col-md-6">

                            <div class="form-group">
                                <label>Nombre 2</label>
                                <input type="text" name="name2" id="ciuda_name2" class="form-control" placeholder="Nombre 2">
                            </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
                            <div class="form-group">
                                <label>Apellido Paterno</label>
                                <input type="text" name="lastname" id="ciuda_lastname" class="form-control" placeholder="Apellidos">
                            </div>
    </div>
    <div class="col-md-6">
                            <div class="form-group">
                                <label>Apellido Materno</label>
                                <input type="text" name="lastname2" id="ciuda_lastname2" class="form-control" placeholder="Apellidos">
                            </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
<div class="form-group">
                                <label>Fecha de nacimiento:</label>
                                <input type="date" name="fecha_nacimiento" class="form-control" id="ciuda_fecha_nacimiento" placeholder="Fecha de nacimiento:">
                            </div>
    </div>
    <div class="col-md-6">
<div class="form-group">
                                <label>CURP</label>
                                <input type="text" name="curp" id="ciuda_curp" required class="form-control" placeholder="CURP">
                            </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
 <div class="form-group">
                                <label>Clave de elector</label>
                                <input type="text" name="clave_elector" id="ciuda_clave_elector" class="form-control" placeholder="Clave de elector">
                            </div>    
    </div>
    <div class="col-md-6">
 <div class="form-group">
                                <label>Ocupacion</label>
                                <input type="text" name="trabajo_nombre" id="ciuda_trabajo_nombre" class="form-control" placeholder="Ocupacion">
                            </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
<div class="form-group">
                                <label>Domicilio</label>
                                <input type="text" name="address" id="ciuda_address" class="form-control" placeholder="Domicilio">
                            </div>
    </div>
    <div class="col-md-6">
<div class="form-group">
                                <label>Telefono</label>
                                <input type="text" name="phone" id="ciuda_phone" class="form-control" placeholder="Telefono">
                            </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
 <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email" id="ciuda_email" class="form-control" placeholder="Email">
                            </div>
    </div>
    <div class="col-md-6">
                            <div class="form-group">
                                <label>Estado</label>
                                <input type="text" name="estado" id="ciuda_estado" class="form-control" placeholder="Estado">
                            </div>
    </div>
</div>

                            <div class="form-group">
                                <label>Municipio</label>
                                <input type="text" id="ciuda_municipio" name="municipio" class="form-control" placeholder="Municipio">
                            </div>
                            <div class="form-group">
                                <label>Colonia / Localidad</label>
                                <input type="text" name="colonia" id="ciuda_colonia" class="form-control" placeholder="Colonia / Localidad">
                            </div>
                            <!--
                            <div class="form-group">
                                <label>Foto garantia</label>
                                <input type="file" name="img_garantia" class="form-control" placeholder="Foto garantia">
                            </div>  
                        -->
                            <div class="form-group">
                                <label>Referencia Domiciliaria</label>
                                <input type="text" id="ciuda_address_ref" name="address_ref" class="form-control" placeholder="Referencia Domiciliaria">
                            </div>
                           
                           <!-- <div class="form-group">
                                <label>Ubicacion URL GPS</label>
                                <input type="text" name="url_gps" class="form-control" placeholder="Ubicacion URL GPS">
                            </div>
                        -->
                        <br>
                            <button type="submit" class="btn btn-primary">Agregar Ciudadano</button>

                        </form>

      </div>


    </div>
  </div>
</div> 
<script type="text/javascript">
    $("#addciudadano").submit(function(e){
        e.preventDefault();
        $.post("./?action=clients&opt=addajax",$("#addciudadano").serialize(), function(data){
            if(data=="error_curp"){
//                alert("Debes ingresar la CURP!");
                  Swal.fire({ title: "Error!", text: "Debes ingresar la curp", icon: "error" });

            }else if(data=="curp_repetido"){
//                alert("Error, la CURP que intentas agregar ya existe!");
                  Swal.fire({ title: "Error!", text: "La CURP que intentas agregar ya existe!", icon: "error" });

            }else if(data=="clave_repetida"){
//                alert("Error, la Clave de Elector que intentas agregar ya existe!");
                  Swal.fire({ title: "Error!", text: "Error, la Clave de Elector que intentas agregar ya existe!", icon: "error" });

            }else{
               // alert(data);
  Swal.fire({ title: data, text: data, icon: "success" });
                $("#ciuda_name").val("");
                $("#ciuda_name2").val("");
                $("#ciuda_lastname").val("");
                $("#ciuda_lastname2").val("");
                $("#ciuda_fecha_nacimiento").val("");
                $("#ciuda_curp").val("");
                $("#ciuda_clave_elector").val("");
                $("#ciuda_trabajo_nombre").val("");
                $("#ciuda_address").val("");
                $("#ciuda_phone").val("");
                $("#ciuda_email").val("");
                $("#ciuda_estado").val("");
                $("#ciuda_municipio").val("");
                $("#ciuda_colonia").val("");
                $("#ciuda_address_ref").val("");
            }

        });
    });
</script>
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


<section class="">
<?php
$user = DriverData::getById($_GET["id"]);
?>


                <div class="row">
                    <div class="col-lg-8">
 <div class="card">
                  <div class="card-header">
                    <strong>Modificar Conductor</strong>
                  </div>
                  <div class="card-body">
                        <form role="form" method="post" action="./?action=drivers&opt=update" enctype="multipart/form-data">

                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="name" value="<?=$user->name;?>" class="form-control" placeholder="Nombre">
                            </div>

                            <div class="form-group">
                                <label>Direccion</label>
                                <input type="text" name="address"  value="<?=$user->address;?>"  class="form-control" placeholder="Direccion">
                            </div>
                            <div class="form-group">
                                <label># Licencia</label>
                                <input type="text" name="licencia"   value="<?=$user->licencia;?>" class="form-control" placeholder="# Licencia">
                            </div>
                   
                            <div class="form-group">
                                <label>Tipo de Licencia</label>
                                <input type="text" name="tipo_licencia"  value="<?=$user->tipo_licencia;?>" class="form-control" placeholder="Tipo de Licencia">
                            </div>
<div class="form-group">
                                <label>Fecha de Vencimiento</label>
                                <input type="date" name="expire_at"  value="<?=$user->expire_at;?>" class="form-control" placeholder="Fecha de Vencimiento">
                            </div>

<br>
                            <input type="hidden" name="id" value="<?=$user->id;?>">
                            <button type="submit" class="btn btn-primary">Actualizar</button>

                        </form>
                    </div>
                </div>

                    </div>

                </div>
                <!-- /.row -->
<br><br><br><br><br>
</section>
<?php endif; ?>