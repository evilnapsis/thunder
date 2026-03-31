<?php 
if(isset($_GET["opt"]) && $_GET['opt']=="all"):
?>




<section class="">
<?php
$data["posts"]=ContratoAguaData::getAll();



?>


 <div class="card">
                  <div class="card-header">
                    <strong>Contratos de Agua</strong>
                  </div>
                  <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
<form class="row g-3" id="filter_form">
  <div class="col-auto">
                    <a href="./?view=contratosagua&opt=new" class="btn btn-secondary">Nuevo Contrato</a>
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
<a href="./contratosaguareport.php" id="link_report" class="btn btn-success" target="_blank">Descargar</a>
  </div>

</form>
<script type="text/javascript">
    $("#date_start").change(function(){
        val1 = $("#date_start").val();
        val2 = $("#date_end").val();

        if(val1!="" && val2!=""){
        link = $("#link_report").attr("href","./contratosaguareport.php?start="+val1+"&end="+val2);       
        //alert(val1);
        $.get("./?action=gettablecontratosagua",$("#filter_form").serialize(), function(data){
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
        link = $("#link_report").attr("href","./contratosaguareport.php?start="+val1+"&end="+val2);       
        //alert(val2);

        $.get("./?action=gettablecontratosagua",$("#filter_form").serialize(), function(data){
            $("#filter_table").html(data);
        $(".datatable").DataTable({"pageLength":25,"language": {
        url: './vendors/datatables/esmx.json',
    }});
        });

        }
    });

</script>

                        <div class="box box-primary">
                            <div class="box-body">
                                <div id="filter_table">
                                    <table class="table datatable table-bordered table-hover table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th># Contrato</th>
                                                <th>Cliente</th>
                                                <th>Tipo de Contrato</th>
<th>Monto</th>
                                                <th>Desc.</th>
                                                <th>Iva</th>
                                                <th>Total</th>
                                                <th>Fecha</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                            $total = 0;
                                            $total_desc = 0;
                                            $iva = 0;
                                            $totaliva = 0;
                                            $totaltot =0;
                                            $totaldesc=0;
                                            $totaltotal=0;

                                        foreach($data["posts"] as $post):
                                                
                                                $total= $post->amount; 
                                                $total_desc = $post->descuento;
                                                $subt1 = $post->amount * ($post->descuento/100);
                                                $subt2 = $post->amount - $subt1;
                                                $subt3 = $subt2 * ($post->iva / 100);
                                                $subt4 = $subt2 + $subt3 ;
                                                $totaliva = $subt3;
                                                $totaltot  = $subt4;
                                                $totaldesc = $subt1;
                                                                                                $totaltotal+=$totaltot;

                                            $user = ClientData::getById($post->client_id);
                                            ?>
                                            <tr>
                                                <td><?=$post->code ;?></td>
                                                <td><?=$user->name." ".$user->lastname." ".$user->lastname2 ;?></td>
                                                <td><?php if($post->tipo_contrato==1){
                                                    echo "Domestico";
                                                } 
                                                else if($post->tipo_contrato==2){
                                                    echo "Comercial";
                                                }else if($post->tipo_contrato==3){
                                                    echo "Industrial";
                                                }

                                            ?></td>
                                                <td>$ <?=$total ;?></td>
                                                <td>$ <?=$totaldesc ;?></td>
                                                <td>$ <?=$totaliva ;?></td>
                                                <td>$ <?=$totaltot ;?></td>
                                                <td><?=$post->date_at ;?></td>

                                                <td style="width:270px;">
                                                    
                                                <a href="./contratoagua2.php?id=<?=$post->id;?>" target="_blank" class="btn btn-sm btn-info"><i class="bi-file-text"></i> Contrato</a>
                                                <a href="./?view=contratosagua&opt=edit&id=<?=$post->id;?>" class="btn btn-sm btn-warning"><i class="bi-pencil"></i></a>
                                            
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
    window.location = "./?action=contratosagua&opt=del&id=<?=$post->id;?>";
  } else if(result.isDenied){
    Swal.fire("Operacion cancelada!", "", "info");
  }
});

    });
</script>
                
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                        </tbody>
                                    </table>
                                    <h1>Total: $ <?php echo number_format($totaltotal, "2",".",","); ?></h1>

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
$last = ContratoAguaData::getLast();
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
                    <strong>Nuevo Contrato (Agua)</strong>
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
                        <form role="form" method="post" action="./?action=contratosagua&opt=add" enctype="multipart/form-data">
                            <!--
                            <div class="form-group">
                                <label>Imagen (480x480)</label>
                                <input type="file" name="image">
                            </div>
                        -->
                            <div class="form-group">
                                <label>Cliente </label>
      <select name="client_id" id="client_list" required class="form-control" required>
        <option value="">-- SELECCIONE --</option>
      </select>
                            </div>
                            <div class="form-group">
                                <label># contrato</label>
                                <input type="text" readonly value="<?php echo $code; ?>" name="code" class="form-control" placeholder="# contrato">
                            </div>

                            <div class="form-group">
                                <label>Fecha</label>
                                <input type="date" value="<?php echo date("Y-m-d"); ?>" <?php if(Core::$user->kind==9):?>readonly<?php endif;?> name="date_at" class="form-control" placeholder="Fecha">
                            </div>

                            <div class="form-group">
                                <label>Tarifa</label>
                                <input type="text" value="35" name="tarifa" class="form-control" placeholder="Tarifa">
                            </div>

                            <div class="form-group">
                                <label>Diametro de la toma (MM)</label>
                                <input type="text" value="15" name="diametro" class="form-control" placeholder="Diametro de la toma">
                            </div>
                            <div class="form-group">
                                <label><b>Periodo (Inicial)</b></label>
      
      <select name="periodo_id" required class="form-control" required>
        <option value="">-- SELECCIONE --</option>
        <?php foreach(PeriodoData::getAll() as $k):?>
          <option value="<?php echo $k->id; ?>"><?php echo $k->name; ?></option>
        <?php endforeach; ?>
      </select>
                            </div>
                            <div class="form-group">
                                <label>Tipo de Toma / Contrato</label>
      <select name="tipo_contrato" id="tipo_contrato_id" required class="form-control" required>
        <option value="">-- SELECCIONE --</option>
<?php foreach(TipoTomaData::getAll() as $tt):
    $tipo_servicio = TipoServicioData::getByToma($tt->id);

    ?>
<option value="<?php echo $tt->id; ?>"><?php echo $tt->name." - $ ".$tipo_servicio->price; ?></option>
<?php endforeach; ?>
      </select>


                            </div>
<script type="text/javascript">
    $("#tipo_contrato_id").change(function(){
        $.get("./?action=gettipotoma","id="+$("#tipo_contrato_id").val(),function(data){
            console.log(data);
            $("#amount").val(data);
            $("#total").val(data);
        });
    });
</script>
                            <div class="form-group">
                                <label><b>Monto</b></label>
                                <input type="text" value="0" required readonly name="amount" id="amount" class="form-control" placeholder="Monto">
                            </div>
<div class="form-group">
                                <label><b>Descuento %%</b></label>
      <select name="descuento" id="descuento" required class="form-control" required>
        <option value="0">-- SELECCIONE --</option>
<?php foreach(DescuentoData::getAll() as $k):?>
<option value="<?php echo $k->name; ?>"><?php echo $k->name; ?></option>
<?php endforeach; ?>
      </select>
                            </div>

                            <div class="form-group">
                                <label><b>Incluir IVA 16% ?</b></label>
      <select name="iva" id="iva" required class="form-control" required>
        <option value="0">NO</option>
<option value="16">SI</option>

      </select>
                            </div>

                            <div class="form-group">
                                <label><b>Total a Pagar</b></label>
                                <input type="text" value="" required readonly name="total" id="total" class="form-control" placeholder="Total a pagar">
                            </div>
                                <div class="form-group">
                                <label><b>Forma de Pago</b></label>
      
      <select name="forma_pago_id" required class="form-control" required>
        <?php foreach(FormaPagoData::getAll() as $k):?>
          <option value="<?php echo $k->id; ?>"><?php echo $k->name; ?></option>
        <?php endforeach; ?>
      </select>
                            </div>
                            <div class="form-group">
                                <label>Descripcion</label>
                                <textarea name="description" class="form-control" placeholder="Descripcion"></textarea>
                            </div>


<script>
    $("#descuento").change(function(){
        val= $("#amount").val();
        iva= $("#iva").val();
        if(val>0){
        desc= $("#descuento").val();

        tot = val - (val * desc/100);
        $("#total").val(tot + (tot * iva /100));

        }else{
            alert("Debes elegir un Concepto de Pago!")
        }
    });

    $("#iva").change(function(){
        val= $("#amount").val();
        iva= $("#iva").val();
        if(val>0){
        desc= $("#descuento").val();

        tot = val - (val * desc/100);
        $("#total").val(tot + (tot * iva /100));

        }else{
            alert("Debes elegir un Concepto de Pago!")
        }
    });


</script>
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


<section class="">
<?php
$user = ContratoAguaData::getById($_GET["id"]);
$cli = ClientData::getById($user->client_id);
?>


                <div class="row">
                    <div class="col-lg-8">
 <div class="card">
                  <div class="card-header">
                    <strong>Modificar Contrato (Agua)</strong>
                  </div>
                  <div class="card-body">
                        <form role="form" method="post" action="./?action=contratosagua&opt=update" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Folio</label>
                                <input type="text" name="code" readonly value="<?=$user->code;?>" class="form-control" placeholder="Folio">
                            </div>
                            <div class="form-group">
                                <label>Cliente</label>
                                <input type="text" name="client" readonly value="<?=$cli->name." ".$cli->name2." ".$cli->lastname." ".$cli->lastname2;?>" class="form-control" placeholder="Cliente">
                            </div>
                            <div class="form-group">
                                <label>Fecha</label>
                                <input type="date" name="date_at" value="<?=$user->date_at;?>" class="form-control" placeholder="Fecha">
                            </div>


                            <div class="form-group">
                                <label>Diametro</label>
                                <input type="text" name="diametro" value="<?=$user->diametro;?>" class="form-control" placeholder="Diametro">
                            </div>
                            <div class="form-group">
                                <label>Tarifa</label>
                                <input type="text" name="tarifa" value="<?=$user->tarifa;?>" class="form-control" placeholder="Tarifa">
                            </div>
                            <div class="form-group">
                                <label>Descripcion</label>
                                <textarea name="description" class="form-control" placeholder="Descripcion"><?=$user->description;?></textarea>
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