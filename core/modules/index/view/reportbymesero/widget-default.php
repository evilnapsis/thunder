<?php
date_default_timezone_set("America/Hermosillo");
$mesero = UserData::getById($_GET["mesero_id"]);
///// por dia
$sellsdayli = SellData::getAllDayliByMesero($mesero->id);
$totaldayli = 0;
foreach ($sellsdayli as $selldayli) {
    $totaldayli += $selldayli->total; 
}
///// totales
$sellstotal = SellData::getAllTotalByMesero($mesero->id);
$totaltotal = 0;
foreach ($sellstotal as $selltotal) {
    $totaltotal += $selltotal->total; 
}

$operations=null;
$category = null;
if(!isset($_GET["cat_id"])){
$operations = OperationData::getAllByDate(date("Y-m-d",time()));
$spents = SpentData::getAllByDate(date("Y-m-d",time()));
}

$sell = 0;
$spent = 0;
$money = 0;
 foreach($operations as $career){ $sell += $career->q*$career->price; }
 foreach($spents as $career){ $spent += $career->price; }
 $money = $sell - $spent;
 ?>



                <section class="content-header">
                       		<h1><?php echo $mesero->name." ".$mesero->lastname; ?> <small>Historial del Mesero</small></h1>
                    
                </section>

<div class="content">
<div class="row">
	<div class="col-md-12">


		<div class="clearfix"></div>
<?php if(count($operations)>0 || count($spents)>0):?>

<div class="row">
                        <div class="col-lg-3 col-lg-offset-6 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>
                                        <b>$ <?php echo number_format($totaldayli,2,".",","); ?></b>
                                    </h3>
                                    <p>
                                        Hoy
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="javascript:void()" class="small-box-footer">
                                    &nbsp;
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                        <b>$ <?php echo number_format($totaltotal,2,".",","); ?></b>
                                    </h3>
                                    <p>
                                        Total
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="javascript:void()" class="small-box-footer">&nbsp;
                                </a>
                            </div>
                        </div><!-- ./col -->


                    </div><!-- /.row -->
                    <div class="row">
<section class="col-lg-12">
                            <!-- Map box -->
                            <div class="box box-primary">
                                <div class="box-header">
                                </div>
                                <div class="box-body">
                                    <div class="table-responsive ">
                                        <!-- .table - Uses sparkline charts-->
<?php
$sells = SellData::getAllDayliByMesero($mesero->id);
?>
<?php if(count($sells)>0):
?>
<table class="table table-striped table-bordered datatable ">
                                            <thead>
                                            <th></th>
                                                <th>Nombre</th>
                                                <th>Total</th>
                                                <th>Fecha</th>
                                            </thead>
<?php foreach($sells as $sell):

?>
                                            <tr>
                                            <td><a href="index.php?view=reportbymesero&mesero_id=<?php echo $mesero->id; ?>" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-chevron-right"></i></a> </td>
                                                <td><?php echo $sell->name; ?></td>
                                                <td>$ <?php echo number_format($sell->total,2,".",","); ?></td>
                                                <td><?php echo date("d-M-Y h:i:s", strtotime($sell->c));?></td>
 
                                            </tr>
                                        <?php endforeach; ?>

                                        </table><!-- /.table -->    
                                        <?php endif; ?>                                
                                        </div>
                                </div><!-- /.box-body-->
                            </div>
                            <!-- /.box -->
</section>
                        
                    </div>
                <?php else:?>
                    <p class="alert alert-warning">No hay datos que mostrar</p>
<?php endif; ?>
<br><br><br><br><br><br><br><br><br><br>
	</div>
</div>
</div>
