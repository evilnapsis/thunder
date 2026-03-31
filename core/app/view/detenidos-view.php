<?php 
if(isset($_GET["opt"]) && $_GET['opt']=="all"):
?>




<section class="">
<?php
$data["posts"]=DetenidoData::getAll();



?>


 <div class="card">
                  <div class="card-header">
                    <strong>Detenidos</strong>
                  </div>
                  <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                    <!-- <a href="./detenidosreport.php" class="btn btn-success" target="_blank">Descargar</a> -->
<form class="row g-3" id="filter_form">
  <div class="col-auto">
                    <a href="./?view=detenidos&opt=new" class="btn btn-secondary">Nuevo Detenido</a>
  </div>
  <div class="col-auto">
    <label for="inputPassword2" class="visually-hidden">Fecha Inicio</label>
    <input type="date" name="date_start" class="form-control" id="date_start" placeholder="Fecha inicio">
  </div>

  <div class="col-auto">
    <label for="inputPassword2" class="visually-hidden">Fecha Fin</label>
    <input type="date" name="date_end" class="form-control" id="date_end" placeholder="Fecha fin">
  </div>
  <!--
  <div class="col-auto">
    <button type="submit" class="btn btn-primary mb-3"><i class="bi-filter"></i> Filtrar</button>
  </div>-->
  <div class="col-auto">
<a href="./detenidosreport.php" id="link_report" class="btn btn-success" target="_blank">Descargar</a>
  </div>
</form>
<script type="text/javascript">
    $("#date_start").change(function(){
        val1 = $("#date_start").val();
        val2 = $("#date_end").val();

        if(val1!="" && val2!=""){
        link = $("#link_report").attr("href","./detenidosreport.php?start="+val1+"&end="+val2);       
        //alert(val1);
        $.get("./?action=gettabledetenidos",$("#filter_form").serialize(), function(data){
            $("#filter_table").html(data);
        $(".datatable").DataTable({"pageLength":25,"language": {
        url: './vendors/datatables/esmx.json',
    }});
        });

        }
    });
    $("#date_end").change(function(){
        val1 = $("#date_start").val();
        val2 = $("#date_end").val();

        if(val1!="" && val2!=""){
        link = $("#link_report").attr("href","./detenidosreport.php?start="+val1+"&end="+val2);       
        //alert(val2);

        $.get("./?action=gettabledetenidos",$("#filter_form").serialize(), function(data){
            console.log(data);
            $("#filter_table").html(data);
        $(".datatable").DataTable({"pageLength":25,"language": {
        url: './vendors/datatables/esmx.json',
    }});
        });

        }
    });

</script>
                    <br>

                        <div class="box box-primary">
                            <div class="box-body">
                                <div id="filter_table">
                                    <table class="table datatable table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th># Id</th>
                                                <th>Cliente</th>
                                                <th>Tipo de Detencion</th>
                                                <th>Motivo</th>
                                                <th>Multa</th>
                                                <th>Status</th>
                                                <th>Fecha</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $total=0;foreach($data["posts"] as $post):
                                            $user = ClientData::getById($post->client_id);
                                            ?>
                                            <tr>
                                                <td><?=$post->code ;?></td>
                                                <td><?=$user->name." ".$user->lastname." ".$user->lastname2 ;?></td>
                                                <td><?php echo TipoDetencionData::getById($post->tipo_detencion_id)->name;?></td>

                                                <td><?=$post->motivo ;?></td>

                                                <td>$ <?=$post->amount ;?></td>
                                                <td><?php if($post->status==1){
                                                    echo "Vigente";
                                                } 
                                                else if($post->status==2){
                                                    echo "En Proceso";
                                                }else if($post->status==3){
                                                    echo "Aprobado";
                                                }else if($post->status==4){
                                                    echo "Finalizado";
                                                }else if($post->status==5){
                                                    echo "Cancelado";
                                                }



                                            ?></td>
                                                <td><?=$post->date_at ;?></td>

                                                <td style="width:270px;">
                                                    <a href="./detenido.php?id=<?php echo $post->id; ?>" class="btn btn-info btn-sm" target="_blank">Imprimir </a>

                                                <a href="./?view=detenidos&opt=edit&id=<?=$post->id;?>" class="btn btn-sm btn-warning"><i class="bi-pencil"></i></a>
                                            
  <?php if(Core::$user->kind==1 || Core::$user->kind==2 || Core::$user->kind==5):?>
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
    window.location = "./?action=detenidos&opt=del&id=<?=$post->id;?>";
  } else if(result.isDenied){
    Swal.fire("Operacion cancelada!", "", "info");
  }
});

    });
</script>
<?php endif;?>
                                                </td>
                                            </tr>
                                        <?php $total+=$post->amount;  endforeach;?>
                                        </tbody>
                                    </table>
                                    <h1>Total: <?php echo $total; ?></h1>
                                </div>
                        </div>
                        </div>
                    </div>
                </div>
</div>
</div>

                <!-- /.row -->
                </section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="new"):
$last = DetenidoData::getLast();
$code = Core::$contrato_agua_start+1;
if($last!=null){
$code = $last->code+1;
}
    ?>
            <!-- Breadcrumb-->




<section class="">

                <div class="row">
                    <div class="col-lg-6">


<!-- Inicio de card -->
 <div class="card">
                  <div class="card-header">
                    <strong>Detenidos</strong>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-12">
                        <form role="form" id="search_contrato">
<div class="row">
    <div class="col-md-6">
                                    <div class="form-group">
                                <label># Buscar por Id , nombre, Curp del Cliente <a type="button" class="btn btn-link" data-coreui-toggle="modal" data-coreui-target="#exampleModal">
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
        $.get("./?action=buscarclientejsonlist",$("#search_contrato").serialize(), function(data){
           // console.log(data);

            result = JSON.parse(data);
            //alert(result);
            if(result!=""){

                $('#client_list')
    .find('option')
    .remove()
    .end();
                               $("#client_list").append("<option value=''> RESULTADOS: "+result.length+"</option>");

               for(i=0; i < result.length; i++){
                $("#client_list").append("<option value="+result[i].id+">"+result[i].name+" " +result[i].name2+" "+result[i].lastname+" "+result[i].lastname2+"</option>");
               }
              // alert(result)

            }else{
                alert("No hay resultados");
            }


        });
    });
    </script>

<!-- Modal -->
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
//                alert(data);
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
                        <form role="form" method="post" action="./?action=detenidos&opt=add" enctype="multipart/form-data">
                            <!--
                            <div class="form-group">
                                <label>Imagen (480x480)</label>
                                <input type="file" name="image">
                            </div>
                        -->
                            <div class="form-group">
                                <label># Folio</label>
                                <input type="text" readonly value="<?php echo $code; ?>" name="code" class="form-control" placeholder="# Folio">
                            </div>

                            <div class="form-group">
                                <label>Fecha</label>
                                <input type="date" value="<?php echo date("Y-m-d"); ?>" name="date_at" class="form-control" placeholder="Fecha">
                            </div>
                            </div>
                            <div class="form-group">
                                <label>Hora</label>
                                <input type="time"  name="time_at" class="form-control" placeholder="Hora">
                            </div>

                            <div class="form-group">
                                <label>Cliente </label>
      <select name="client_id" id="client_list" required class="form-control" required>
        <option value="">-- SELECCIONE --</option>
        <?php foreach(ClientData::getAll() as $k):?>
          <option value="<?php echo $k->id; ?>"><?php echo $k->name." ".$k->lastname; ?></option>
        <?php endforeach; ?>
      </select>
                            </div>
                            <div class="form-group">
                                <label>Tipo de Detencion*</label>
      <select name="tipo_detencion_id" required class="form-control" required>
        <option value="">-- SELECCIONE --</option>
<?php foreach(TipoDetencionData::getAll() as $tt):

    ?>
<option value="<?php echo $tt->id; ?>"><?php echo $tt->name; ?></option>
<?php endforeach; ?>
      </select>



                            </div>
                            <div class="form-group">
                                <label>Motivo</label>
                                <textarea name="motivo" class="form-control" placeholder="Motivo"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Cantidad/Multa</label>
                                <input type="text" value="" name="amount" class="form-control" placeholder="Cantidad">
                            </div>
                            <div class="form-group">
                                <label>Resolucion</label>
                                <textarea name="resolucion" class="form-control" placeholder="Resolucion"></textarea>
                            </div>
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


<section class="container">
<?php
$user = DetenidoData::getById($_GET["id"]);
$client = ClientData::getById($user->client_id);
?>


                <div class="row">
                    <div class="col-lg-12">
 <div class="card">
                  <div class="card-header">
                    <strong>Detenido</strong>
                  </div>
                  <div class="card-body">
                        <form role="form" method="post" action="./?action=detenidos&opt=update" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Folio</label>
                                <input type="text" name="code" readonly value="<?=$user->code;?>" class="form-control" placeholder="Nombre">
                            </div>
                            <div class="form-group">
                                <label>CURP</label>
                                <input type="text" name="curp" readonly value="<?=$client->curp;?>" class="form-control" placeholder="Nombre">
                            </div>
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="name" readonly value="<?=$client->name." ".$client->name2." ".$client->lastname." ".$client->lastname2;?>" class="form-control" placeholder="Nombre">
                            </div>




                            <div class="form-group">
                                <label>Motivo</label>
                                <textarea name="motivo" class="form-control" placeholder="Motivo"><?=$user->motivo;?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Cantidad </label>
                                <input type="text" value="<?php echo $user->amount;?>" name="amount"  class="form-control" placeholder="Cantidad">
                            </div>
                            <div class="form-group">
                                <label>Resolucion</label>
                                <textarea name="resolucion"  class="form-control" placeholder="Resolucion"><?=$user->resolucion;?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Estatus</label>
                                <select name="status" required class="form-control">
                                    <option value="1" <?php if($user->status==1){ echo "selected"; }?>>Vigente</option>
                                    <option value="2" <?php if($user->status==2){ echo "selected"; }?>>En Proceso</option>
                                    <option value="3" <?php if($user->status==3){ echo "selected"; }?>>Aprobado</option>
                                    <option value="4" <?php if($user->status==4){ echo "selected"; }?>>Finalizado</option>
                                    <option value="5" <?php if($user->status==5){ echo "selected"; }?>>Cancelado</option>
                                </select>

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