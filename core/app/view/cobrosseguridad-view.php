<?php 
if(isset($_GET["opt"]) && $_GET['opt']=="all"):
?>

<section class="">
<?php
$data["posts"]=CobroSeguridadListData::getAll();
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
                    <strong>Seguridad</strong>
                  </div>
                  <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
<form class="row g-3" id="filter_form">
  <div class="col-auto">
                    <a href="./?view=cobrosseguridad&opt=newstep1" class="btn btn-secondary">Nuevo Cobro</a>
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
<a href="./cobrosseguridadreport.php" id="link_report" class="btn btn-success" target="_blank">Descargar</a>
  </div>

</form>
<script type="text/javascript">
    $("#date_start").change(function(){
        val1 = $("#date_start").val();
        val2 = $("#date_end").val();

        if(val1!="" && val2!=""){
        link = $("#link_report").attr("href","./cobrosseguridadreport.php?start="+val1+"&end="+val2);       
        //alert(val1);
        $.get("./?action=gettablecobrosseguridad",$("#filter_form").serialize(), function(data){
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
        link = $("#link_report").attr("href","./cobrosseguridadreport.php?start="+val1+"&end="+val2);       
        //alert(val2);

        $.get("./?action=gettablecobrosseguridad",$("#filter_form").serialize(), function(data){
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
                                            $cobros = CobroSeguridadData::getAllBy("cobro_seguridad_list_id",$post->id);
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

                                                <td><?php  if($cobros){ if(count($cobros)>0){ echo CatSeguridadData::getById(ServicioSeguridadData::getById($cobros[0]->servicio_seguridad_id)->cat_seguridad_id)->name ;}} ?></td>
                                                <td><?php  if($cobros){ if(count($cobros)>0){ echo ServicioSeguridadData::getById($cobros[0]->servicio_seguridad_id)->name ;}} ?></td>

                                                <td>$ <?=$total ;?></td>
                                                <td>$ <?=$totaldesc ;?></td>
                                                <td>$ <?=$totaliva ;?></td>
                                                <td>$ <?=$totaltot ;?></td>
                                                <td><?php if($cobros){ if(count($cobros)>0){echo $cobros[0]->date_at ;}}?></td>

                                                <td style="width:270px;">
                                                    
                                                <a href="./ticketseguridad.php?id=<?=$post->id;?>" target="_blank" class="btn btn-sm btn-info"><i class="bi-file-text"></i> Ticket</a>
                                                <!--<a href="./?view=cobrosseguridad&opt=edit&id=<?=$post->id;?>" class="btn btn-sm btn-warning"><i class="bi-pencil"></i></a> -->
                                            
                                                <a href="./?action=cobrosseguridad&opt=del&id=<?=$post->id;?>" class="btn btn-sm btn-danger"><i class="bi-trash"></i></a>
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
$data["posts"]=CatSeguridadData::getAll();
?>
<?php
$last = CorteSeguridadData::getLastByUser(Core::$user->id);
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
<?php
$last = CorteSeguridadData::getLastByUser(Core::$user->id);
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
                    <strong>Seleccionar Categoria - Seguridad</strong>
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
                                                <td>#CS000<?=$post->id ;?></td>
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
if(!isset($_GET['cat_seguridad_id'])){
Core::alert("Debes seleccionar una categoria");
Core::redir("./?view=cobrosseguridad&opt=newstep1");
}
$category = CatSeguridadData::getById($_GET['cat_seguridad_id']);
    ?>
            <!-- Breadcrumb-->


<?php
$tipo = "seguridad";
$last = CorteSeguridadData::getLastByUser(Core::$user->id);

if($last==null){
    $tipo = "tesoreria";
    $last = CorteTesoreriaData::getLastByUser(Core::$user->id);
}

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
                    <strong>Nuevo Cobro (Seguridad)</strong>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-12">

<p class="alert alert-info">Has seleccionado: <b><?php echo $category->name; ?></b></p>

                        <form role="form" id="search_contrato">
<input type="hidden" name="cat_seguridad_id" value="<?php echo $_GET['cat_seguridad_id']; ?>">
<div class="row">
    <div class="col-md-6">
                                    <div class="form-group">
                                <label># Id , nombre, Curp del Cliente</label>
                                <input type="text" name="code" required class="form-control" placeholder="# Curp o nombre">
                            </div>
    </div>
    <div class="col-md-6">
        <br>
                            <button type="submit" class="btn btn-primary">Buscar Cliente</button>
    </div>
</div>

                            
                        </form>
                        
<script>
    $("#search_contrato").submit(function(e){
        e.preventDefault();
        $.get("./?action=buscarclientesegu",$("#search_contrato").serialize(), function(data){
           // console.log(data);
            $("#formulario2").html(data);

        });
    })

    <?php if(isset($_SESSION['cobro_seguridad'])):
$a = $_SESSION['cobro_seguridad'];
//print_r($a[0]);
        ?>
        $.get("./?action=buscarclientesegu","code=<?php echo $a[0]["client_id"]; ?>&cat_seguridad_id=<?php echo $a[0]["cat_seguridad_id"]; ?>", function(data){
            $("#formulario2").html(data);

        });

    <?php endif; ?>

        $.get("./?action=getcobrosseguridad","", function(data2){
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
$user = CobroSeguridadData::getById($_GET["id"]);
?>


                <div class="row">
                    <div class="col-lg-12">
 <div class="card">
                  <div class="card-header">
                    <strong>Modificar Cobro (Agua)</strong>
                  </div>
                  <div class="card-body">
                        <form role="form" method="post" action="./?action=cobrosseguridad&opt=update" enctype="multipart/form-data">

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

<iframe src="./ticketseguridad.php?id=<?php echo $_GET['id']?>"></iframe>
</div>
                    </div>
                </div>

                    </div>

                </div>
                <!-- /.row -->
<?php endif; ?>