<?php 
if(isset($_GET["opt"]) && $_GET['opt']=="all"):
?>




<section class="">
<?php
if(Core::$user->kind==1 || Core::$user->kind==2){
$data["posts"]=CorteSeguridadData::getAll();
}else{
$data["posts"]=CorteSeguridadData::getAllBy("user_id",Core::$user->id);

}
?>

 <div class="card">
                  <div class="card-header">
                    <strong>Cortes de Caja (Seguridad)</strong>
                  </div>
                  <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                    <a href="./?view=cortesseguridad&opt=new" class="btn btn-secondary">Nuevo Corte de Caja</a>
                    <!-- <a href="./productsreport.php" class="btn btn-success" target="_blank">Descargar</a> -->
                    <br><br>
                        <div class="box box-primary">
                            <div class="box-body">
                                    <table class="table datatable table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Monto Inicial</th>
                                                <th>Cobros</th>
                                                <th>Monto Final</th>
                                                <th>Diferencia</th>
                                                <th>Status</th>
                                                <th>Fecha Inicial</th>
                                                <th>Fecha Final</th>
                                                <th>Usuario</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($data["posts"] as $post):
$cobros=CobroSeguridadListData::getAllBy("corte_id",$post->id);
$totaltotal=0; 
foreach($cobros as $cobro){
                        $cobros = CobroSeguridadData::getAllBy("cobro_seguridad_list_id",$cobro->id);

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
}
$diferencia=null;
if($post->amount_end!=null){
    $recibido  = $post->amount_start+$totaltotal;
    $entregado = $post->amount_end;
    $diferencia = $entregado - $recibido;
}

                                            ?>
                                            <tr>
                                                <td>
                                                    <a href="./?view=cortesseguridad&opt=open&id=<?php echo $post->id; ?>">#<?php echo $post->id; ?></a>
                                                </td>
                                                <td>$ <?=$post->amount_start!=null?number_format($post->amount_start,2,".",","):0 ;?></td>
                                                <td>$ <?=$post->amount_end!=null?number_format($totaltotal,2,".",","):0 ;?></td>
                                                <td>$ <?=$post->amount_end!=null?number_format($post->amount_end,2,".",","):0 ;?></td>
                                                <td>$ <?=$post->amount_end!=null?number_format($diferencia,2,".",","):0 ;?></td>
                                                <td>
                                                    <?php 
                                                    if($diferencia<0){ echo "<span class='badge text-bg-danger'>Falto dinero</span>";}
                                                    else if($diferencia>0){ echo "<span class='badge text-bg-warning'>Sobro dinero</span>";}
                                                    else { echo "<span class='badge text-bg-primary'>Todo correcto.</span>";}

                                                    ?>
                                                </td>
                                                <td><?=$post->start_at ;?></td>
                                                <td><?=$post->finish_at ;?></td>

                                                <td><?php if($post->user_id){$u = UserData::getById($post->user_id); echo $u->name." ".$u->lastname; }?></td>
                                                <td style="width:170px;">
                                                    <?php if($post->finish_at!=null):?>
                                                <a href="./?view=cortesseguridad&opt=edit&id=<?=$post->id;?>" class="btn btn-sm btn-warning"><i class="bi-pencil"></i></a>
                                            <a href="./cobrosseguridadcorte.php?id=<?php echo $post->id; ?>" id="link_report" class="btn btn-success btn-sm" target="_blank">Descargar</a>

                                                <!--<a href="./?action=cortesseguridad&opt=del&id=<?=$post->id;?>" class="btn btn-sm btn-danger"><i class="bi-trash"></i></a>-->
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
$last = CorteSeguridadData::getLastByUser(Core::$user->id);
    ?>
            <!-- Breadcrumb-->


<script type="text/javascript">
    <?php if(isset($_SESSION["corte_iniciado"])):?>
    Swal.fire({
  title: "Caja Abierta Exitosamente!",
  icon: "success"
});
    <?php unset($_SESSION['corte_iniciado']); endif; ?>
    <?php if(isset($_SESSION["corte_finalizado"])):?>
    Swal.fire({
  title: "Corte Finalizado Exitosamente!",
  icon: "success"
});
    <?php unset($_SESSION['corte_finalizado']); endif; ?>
</script>
<section class="">

<div class="row">
    <div class="col-lg-12">


<!-- Inicio de card -->
 <div class="card">
                  <div class="card-header">
                    <strong>Mi Corte de Caja [Seguridad]</strong>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-12">
<?php if($last!=null):?>
    <p class="alert alert-info">La caja esta abierta, puedes realizar tus ventas, al terminar ingresa tu monto final.</p>
                        <form role="form" method="post" action="./?action=cortesseguridad&opt=finish" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $last->id; ?>">
                            <!--
                            <div class="form-group">
                                <label>Imagen (480x480)</label>
                                <input type="file" name="image">
                            </div>
                        -->
                            <div class="form-group">
                                <label>Monto Inicial</label>
                                <input type="text" name="amount_start" value="<?php echo $last->amount_start; ?>" readonly class="form-control" placeholder="Monto Inicial">
                            </div>
                            <div class="form-group">
                                <label>Monto Final</label>
                                <input type="text" name="amount_end" required class="form-control" placeholder="Monto Final">
                            </div>

<br>
                            <button type="submit" class="btn btn-primary">Cerrar Caja</button>

                        </form>

<h3>COBROS EN ESTE CORTE</h3>
<?php
$data["posts"]=CobroSeguridadListData::getAllBy("corte_id",$last->id);
?>
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
                                        <?php endforeach;?>
                                        </tbody>
                                    </table>
                                    <h1>Total: $ <?php echo number_format($totaltotal, "2",".",","); ?></h1>



<?php else:?>
    <p class="alert alert-warning">La caja esta cerrada, para iniciar ingresa tu monto de caja inicial.</p>
                        <form role="form" method="post" action="./?action=cortesseguridad&opt=add" enctype="multipart/form-data">
                            <!--
                            <div class="form-group">
                                <label>Imagen (480x480)</label>
                                <input type="file" name="image">
                            </div>
                        -->
                            <div class="form-group">
                                <label>Monto Inicial</label>
                                <input type="text" name="amount_start" required class="form-control" placeholder="Monto Inicial">
                            </div>

<br>
                            <button type="submit" class="btn btn-primary">Abrir Caja</button>

                        </form>
<?php endif; ?>
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
$user = CorteSeguridadData::getById($_GET["id"]);
?>


                <div class="row">
                    <div class="col-lg-12">
 <div class="card">
                  <div class="card-header">
                    <strong>Modificar Corte de Caja</strong>
                  </div>
                  <div class="card-body">
                        <form role="form" method="post" action="./?action=cortesseguridad&opt=update" enctype="multipart/form-data">


                            <div class="form-group">
                                <label>Monto Inicial</label>
                                <input type="text" name="amount_start"  value="<?=$user->amount_start;?>" class="form-control" placeholder="Monto Inicial">
                            </div>                            <div class="form-group">
                                <label>Monto Final</label>
                                <input type="text" name="amount_end"  value="<?=$user->amount_end;?>" class="form-control" placeholder="Monto Final">
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
<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="open"):?>

<section class="">
<?php
$user = CorteSeguridadData::getById($_GET["id"]);
?>


                <div class="row">
                    <div class="col-lg-12">
 <div class="card">
                  <div class="card-header">
                    <strong>Ver Corte de Caja</strong>
                  </div>
                  <div class="card-body">
                    <a href="./cobrosseguridadcorte.php?id=<?php echo $user->id; ?>" id="link_report" class="btn btn-success" target="_blank">Descargar</a><br><br>

                        <div role="form" method="post" action="./?action=cortesseguridad&opt=update" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Monto Inicial</label>
                                <input type="text" name="amount_start"  value="<?=$user->amount_start;?>" class="form-control" placeholder="Monto Inicial">
                            </div>                            <div class="form-group">
                                <label>Monto Final</label>
                                <input type="text" name="amount_end"  value="<?=$user->amount_end;?>" class="form-control" placeholder="Monto Final">
                            </div>
                        </div>


<h3>COBROS EN ESTE CORTE</h3>
<?php
$data["posts"]=CobroSeguridadListData::getAllBy("corte_id",$user->id);
?>
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
                                        <?php endforeach;?>
                                        </tbody>
                                    </table>
                                    <h1>Total: $ <?php echo number_format($totaltotal, "2",".",","); ?></h1>

                    </div>
                </div>

                    </div>

                </div>
                <!-- /.row -->
<br><br><br><br><br>
</section>
<?php endif; ?>