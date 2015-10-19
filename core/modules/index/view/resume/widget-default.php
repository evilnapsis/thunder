<?php
date_default_timezone_set("America/Hermosillo");
$user = UserData::getById(Session::getUID());
$operations=null;
$category = null;
if(!isset($_GET["cat_id"])){
$operations = OperationData::getAllByDate(date("Y-m-d",time()));
$spents = SpentData::getAllByDate(date("Y-m-d",time()));
}else{
$operations = OperationData::getAllByDateAndCategoryId(date("Y-m-d",time()),$_GET["cat_id"]);
$spents = SpentData::getAllByDateAndCategoryId(date("Y-m-d",time()),$_GET["cat_id"]);
$category = CategoryData::getById($_GET["cat_id"]);
}
$sell = 0;
$spent = 0;
$money = 0;
 foreach($operations as $career){ $sell += $career->q*$career->price; }
 foreach($spents as $career){ $spent += $career->price; }
 $money = $sell - $spent;
 ?>
<section class="content-header">
	<h1>Resumen</h1>
<ol class="breadcrumb">
                        <li> Categoria</li>
                        <li class="active"><?php if($category==null){ echo "Todas"; }else { echo $category->name; }?></li>
                    </ol>
</section>
<section class="content">
<div class="row">
<div class="col-md-3">


<div class="panel panel-default">
    <div class="panel-heading">
        Categorias
    </div>
	<div class="list-group">
  <a class='list-group-item' href="index.php?view=resume"><?php if($category==null): ?><i class="glyphicon glyphicon-ok"></i> <?php endif; ?>Todas</a>
<?php foreach(CategoryData::getAll() as $cat):?>
  <a class='list-group-item' href="index.php?view=resume&cat_id=<?php echo $cat->id; ?>"><?php if( $category!=null && ($category->id==$cat->id)): ?><i class="glyphicon glyphicon-ok"></i> <?php endif; ?><?php echo $cat->name; ?></a>
<?php endforeach; ?>
	</div>
</div>
</div>
	<div class="col-md-9">
	<div class="row">
<div class="col-md-8">
		
		<div class="row">
			<div class="col-md-6">

			</div>
			<div class="col-md-3"></div>
			<div class="col-md-3"></a></div>
		</div>
<br>	
  
</div>
<div class="col-md-4">
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>
                                        <b>$ <?php echo number_format($money,2,".",","); ?></b>
                                    </h3>
                                    <p>
                                        Ganancia
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="javascript:void()" class="small-box-footer">
                                    <?php 
		$months = array("01"=>"Enero","02"=>"Febrero","03"=>"Marzo","04"=>"Abril","05"=>"Mayo","06"=>"Junio","07"=>"Julio","08"=>"Agosto","09"=>"Septiembre","10"=>"Octubre","11"=>"Noviembre","12"=>"Diciembre");
		echo "<b>".date("d")." de ".$months[(date("m"))]." del ".date("Y")."</b>";
		?> <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
</div>
</div>


<?php if(count($operations)>0 || count($spents)>0):?>
<div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"></h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-primary btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body no-padding">
<table class="table table-bordered table-hover">
<thead>
	<th>Ventas</th>
	<th>Gastos</th>
	<th>Ganancia</th>
</thead>
<tr>
	<td><?php echo $sell; ?></td>
	<td><?php echo $spent; ?></td>
	<td><b><?php echo $money; ?></b></td>
</tr>
</table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

<?php else: // no careers ?>
<div class="jumbotron">
	<h2><i class="glyphicon glyphicon-minus-sign"></i> No hay datos </h2>
</div>
<?php endif; ?>
	</div>
</div>
</section>