<?php 
if(isset($_GET["opt"]) && $_GET['opt']=="all"):
?>




<section class="">
<?php
$data["posts"]=CobroTesoreriaListData::getAll();
?>
    <?php if(isset($_SESSION["error_caja"])):?>
<script type="text/javascript">
    Swal.fire({
  title: "Eror la caja esta cerrada!",
  icon: "error"
});
</script>
    <?php unset($_SESSION["error_caja"]); endif; ?>

 <div class="card">
                  <div class="card-header">
                    <strong>Tesoreria</strong>
                  </div>
                  <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
<form class="row g-3" id="filter_form">
  <div class="col-auto">
                    <a href="./?view=cobrostesoreria&opt=newstep1" class="btn btn-secondary">Nuevo Cobro</a>
  </div>
  <div class="col-auto">
    <label for="inputPassword2" class="visually-hidden">Categoria</label>
    <select name="cat_tesoreria_id" id="cat_tesoreria_id" class="form-control">
        <option value="">- TODO -</option>
        <?php foreach(CatTesoreriaData::getAll() as $cat): ?>
        <option value="<?php echo $cat->id; ?>"><?php echo $cat->name; ?></option>
        <?php endforeach; ?>
    </select>

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
<a href="./cobrostesoreriareport.php" id="link_report" class="btn btn-success" target="_blank">Descargar</a>
  </div>

</form>
<script type="text/javascript">
    $("#date_start").change(function(){
        val1 = $("#date_start").val();
        val2 = $("#date_end").val();
        val3 = $("#cat_tesoreria_id").val();

        if(val1!="" && val2!=""){
        link = $("#link_report").attr("href","./cobrostesoreriareport.php?start="+val1+"&end="+val2+"&cat="+val2);       
        //alert(val1);
        $.get("./?action=gettablecobrostesoreria",$("#filter_form").serialize(), function(data){
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
        val3 = $("#cat_tesoreria_id").val();

        if(val1!="" && val2!=""){
        link = $("#link_report").attr("href","./cobrostesoreriareport.php?start="+val1+"&end="+val2+"&cat="+val3);       
        //alert(val2);

        $.get("./?action=gettablecobrostesoreria",$("#filter_form").serialize(), function(data){
            console.log(data);
            $("#filter_table").html(data);
        $(".datatable").DataTable({"pageLength":25,"language": {
        url: './vendors/datatables/esmx.json',
    }});
        });

        }
    });
    $("#cat_tesoreria_id").change(function(){
        val1 = $("#date_start").val();
        val2 = $("#date_end").val();
        val3 = $("#cat_tesoreria_id").val();

        //if(val1!="" && val2!=""){
        link = $("#link_report").attr("href","./cobrostesoreriareport.php?start="+val1+"&end="+val2+"&cat="+val3);       
        //alert(val2);

        $.get("./?action=gettablecobrostesoreria",$("#filter_form").serialize(), function(data){
            console.log(data);
            $("#filter_table").html(data);
        $(".datatable").DataTable({"pageLength":25,"language": {
        url: './vendors/datatables/esmx.json',
    }});
        });

        //}
    });
</script>

                        <div class="box box-primary">
                            <div class="box-body">
                                <div id="filter_table">
<script type="text/javascript">
<?php if(isset($_SESSION["deleted_item"])):?>
    Swal.fire("Eliminado!", "", "success");
    <?php unset($_SESSION['deleted_item']); 
endif;?>
</script>
                                    <table class="table datatable table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th># Id</th>
                                                <th>Cliente</th>
                                                <th>Servicio</th>
                                                <th>Tipo de Servicio</th>
                                                <th>Monto</th>
                                                <th>Descuento</th>
                                                <th>Iva</th>
                                                <th>Total</th>
                                                <th>Fecha</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $totaltotal=0; foreach($data["posts"] as $post):
                                            $user = ClientData::getById($post->client_id);
                                            if($user):
                                            $cobros = CobroTesoreriaData::getAllBy("cobro_tesoreria_list_id",$post->id);
                                            $total = 0;
                                            $total_desc = 0;
                                            $iva = 0;
                                            $totaliva = 0;
                                            $totaltot =0;
                                            $totaldesc=0;
                                            foreach($cobros as $cx){ 
                                                $total+= $cx->amount; 
                                                $total_desc+= $cx->descuento;
                                                $subt1 = $cx->amount * ($cx->descuento/100);
                                                $subt2 = $cx->amount - $subt1;
                                                $subt3 = $subt2 * ($cx->iva / 100);
                                                $subt4 = $subt2 + $subt3 ;
                                                $totaliva+= $subt3;
                                                $totaltot += $subt4;
                                                $totaldesc += $subt1;
                                            }
                                                $totaltotal+=$totaltot;
                                            ?>
                                            <tr>
                                                <td>#A000<?=$post->id ;?></td>
                                                <td><?=$user->name." ".$user->lastname." ".$user->lastname2 ;?></td>

                                                <td><?php  if($cobros){ if(count($cobros)>0){ echo CatTesoreriaData::getById(ServicioTesoreriaData::getById($cobros[0]->servicio_tesoreria_id)->cat_tesoreria_id)->name ;}} ?></td>
                                                <td><?php  if($cobros){ if(count($cobros)>0){ echo ServicioTesoreriaData::getById($cobros[0]->servicio_tesoreria_id)->name ;}} ?></td>

                                                <td>$ <?=$total ;?></td>
                                                <td>$ <?=$totaldesc ;?></td>
                                                <td>$ <?=$totaliva ;?></td>
                                                <td>$ <?=$totaltot ;?></td>
                                                <td><?php if($cobros){ if(count($cobros)>0){echo $cobros[0]->date_at ;}}?></td>

                                                <td style="width:270px;">
                                                    
                                                <a href="./tickettesoreria.php?id=<?=$post->id;?>" target="_blank" class="btn btn-sm btn-info"><i class="bi-file-text"></i> Ticket</a>
                                                <!--<a href="./?view=cobrostesoreria&opt=edit&id=<?=$post->id;?>" class="btn btn-sm btn-warning"><i class="bi-pencil"></i></a> -->
                                            
 <?php if(Core::$user->kind==1 || Core::$user->kind==2 || Core::$user->kind==4):?>
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
    window.location = "./?action=cobrostesoreria&opt=del&id=<?=$post->id;?>";
  } else if(result.isDenied){
    Swal.fire("Operacion cancelada!", "", "info");
  }
});

    });
</script>
<?php endif;?>
                                                </td>
                                            </tr>
                                        <?php endif;  endforeach;?>
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

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="newstep1"):?>

<section class="">
<?php
$data["posts"]=CatTesoreriaData::getAll();
?>


<?php
$last = CorteTesoreriaData::getLastByUser(Core::$user->id);
// print_r($last);
?>
   <?php if($last==null):?>
<script type="text/javascript">
 
    Swal.fire({
  title: "La caja esta cerrada no es posible realizar cobros!",
  icon: "error"
});
    </script>

    <?php 
endif; ?>

 <div class="card">
                  <div class="card-header">
                    <strong>Seleccionar Categoria - Tesoreria</strong>
                  </div>
                  <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary">
                            <div class="box-body">
                                    <table class="table datatable table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th># Id</th>
                                                <th>Categoria de Servicios</th>

                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($data["posts"] as $post):


                                            ?>
                                            <tr>
                                                <td>#CT000<?=$post->id ;?></td>
                                                <td><?=$post->name ;?></td>


                                                <td style="width:270px;">
                                                <?php if($last):?>
                                                <a href="./?view=cobrostesoreria&opt=new&cat_tesoreria_id=<?=$post->id;?>" class="btn btn-sm btn-success"> Seleccionar <i class="bi-arrow-right"></i></a> 
                                            <?php endif; ?>
                                            
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                        <?php foreach(CatSeguridadData::getAll() as $post):


                                            ?>
                                            <tr>
                                                <td>#CX000<?=$post->id ;?></td>
                                                <td><?=$post->name ;?></td>


                                                <td style="width:270px;">
                                                    <?php if($last):?>
                                                <a href="./?view=cobrosseguridad&opt=new&cat_seguridad_id=<?=$post->id;?>" class="btn btn-sm btn-success"> Seleccionar <i class="bi-arrow-right"></i></a> 
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
<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="new"):
if(!isset($_GET['cat_tesoreria_id'])){
Core::alert("Debes seleccionar una categoria");
Core::redir("./?view=cobrostesoreria&opt=newstep1");
}
$category = CatTesoreriaData::getById($_GET['cat_tesoreria_id']);
    ?>
            <!-- Breadcrumb-->

<?php
$last = CorteTesoreriaData::getLastByUser(Core::$user->id);
// print_r($last);
?>
   <?php if($last==null):?>
<script type="text/javascript">
 
    Swal.fire({
  title: "La caja esta cerrada no es posible realizar cobros!",
  icon: "error"
});
    </script>

    <?php 
endif; ?>


<section class="">

                <div class="row">
                    <div class="col-lg-9">


<!-- Inicio de card -->
 <div class="card">
                  <div class="card-header">
                    <strong>Nuevo Cobro (Tesoreria)</strong>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-12">

<p class="alert alert-info">Has seleccionado: <b><?php echo $category->name; ?></b></p>

                        <form role="form" id="search_contrato">
<input type="hidden" name="cat_tesoreria_id" value="<?php echo $_GET['cat_tesoreria_id']; ?>">
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
<script>
    $("#search_contrato").submit(function(e){
        e.preventDefault();
        $.get("./?action=buscarcliente",$("#search_contrato").serialize(), function(data){
           // console.log(data);
            $("#formulario2").html(data);

        });
    })

    <?php if(isset($_SESSION['cobro_tesoreria'])):
$a = $_SESSION['cobro_tesoreria'];
//print_r($a[0]);
        ?>
        $.get("./?action=buscarcliente","code=<?php echo $a[0]["client_id"]; ?>&cat_tesoreria_id=<?php echo $a[0]["cat_tesoreria_id"]; ?>", function(data){
            $("#formulario2").html(data);

        });

    <?php endif; ?>

        $.get("./?action=getcobrostesoreria","", function(data2){
            $("#cobro_list").html(data2);
        });
</script>
                        <br>

<div id="formulario2">
    <div class="alert alert-warning">Debe buscar el ID o Folio de contrato</div>
</div>



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
$user = CobroTesoreriaData::getById($_GET["id"]);
?>


                <div class="row">
                    <div class="col-lg-12">
 <div class="card">
                  <div class="card-header">
                    <strong>Modificar Cobro (Agua)</strong>
                  </div>
                  <div class="card-body">
                        <form role="form" method="post" action="./?action=cobrostesoreria&opt=update" enctype="multipart/form-data">

                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="name" value="<?=$user->name;?>" class="form-control" placeholder="Nombre">
                            </div>


                            <div class="form-group">
                                <label>Precio</label>
                                <input type="text" name="price" value="<?=$user->price;?>" class="form-control" placeholder="Precio">
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
<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="showticket"):?>
<script type="text/javascript">
    <?php if(isset($_SESSION["cobro_realizado"])):?>
    Swal.fire({
  title: "Cobro Realizado Exitosamente!",
  icon: "success"
});
    <?php unset($_SESSION['cobro_realizado']); endif; ?>
</script>
    <div class="row">
                    <div class="col-lg-12">
 <div class="card">
                  <div class="card-header">
                    <strong>Imprimir Ticket</strong>
                  </div>
                  <div class="card-body">
<div class="ratio ratio-16x9">

<iframe src="./tickettesoreria.php?id=<?php echo $_GET['id']?>"></iframe>
</div>
                    </div>
                </div>

                    </div>

                </div>
                <!-- /.row -->
<?php endif; ?>