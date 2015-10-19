<?php
$user = UserData::getById(Session::getUID());
$spents=null;
$category = null;
if(!isset($_GET["cat_id"])){
$spents = SpentData::getAllByDate($_GET["date"]);
}else{
$spents = SpentData::getAllByDateAndCategoryId($_GET["date"],$_GET["cat_id"]);
$category = CategoryData::getById($_GET["cat_id"]);
}
$money = 0;
 foreach($spents as $career){ $money += $career->price; }?>
 <section class="content-header">
	<h1>Gastos <small><?php 
		$months = array("01"=>"Enero","02"=>"Febrero","03"=>"Marzo","04"=>"Abril","05"=>"Mayo","06"=>"Junio","07"=>"Julio","08"=>"Agosto","09"=>"Septiembre","10"=>"Octubre","11"=>"Noviembre","12"=>"Diciembre");
		echo "<b>".date("d", strtotime($_GET["date"]))." de ".$months[(date("m", strtotime($_GET["date"])))]." del ".date("Y", strtotime($_GET["date"]))."</b>";
		?></small></h1>
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
  <a class='list-group-item' href="index.php?view=spentbydate&date=<?php echo $_GET["date"];?>"><?php if($category==null): ?><i class="glyphicon glyphicon-ok"></i> <?php endif; ?>Todas</a>
<?php foreach(CategoryData::getAll() as $cat):?>
  <a class='list-group-item' href="index.php?view=spentbydate&date=<?php echo $_GET["date"];?>&cat_id=<?php echo $cat->id; ?>"><?php if( $category!=null && ($category->id==$cat->id)): ?><i class="glyphicon glyphicon-ok"></i> <?php endif; ?><?php echo $cat->name; ?></a>
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
			<div class="col-md-3"></div>
		</div>
<br>	
</div>
<div class="col-md-4">
<div class="small-box bg-red">
                                <div class="inner">
                                    <h3>
                                        <b>$ <?php echo number_format($money,2,".",","); ?></b>
                                    </h3>
                                    <p>
                                        Gastos
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="javascript:void()" class="small-box-footer">
<?php 
		$months = array("01"=>"Enero","02"=>"Febrero","03"=>"Marzo","04"=>"Abril","05"=>"Mayo","06"=>"Junio","07"=>"Julio","08"=>"Agosto","09"=>"Septiembre","10"=>"Octubre","11"=>"Noviembre","12"=>"Diciembre");
		echo "<b>".date("d", strtotime($_GET["date"]))." de ".$months[(date("m", strtotime($_GET["date"])))]." del ".date("Y", strtotime($_GET["date"]))."</b>";
		?>
 <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>

</div>
</div>


	<?php if(isset($_COOKIE["gradeupdated"])):?>
			<p class="alert alert-success"><i class='glyphicon glyphicon-ok-sign'></i> La categoria <b><?php echo $_COOKIE["gradeupdated"]; ?></b> ha sido actualizada exitosamente.</p>
		<?php 
		setcookie("gradeupdated","",time()-18600);
		endif; ?>

	<?php if(isset($_COOKIE["gradedeleted"])):?>
			<p class="alert alert-danger"><i class='glyphicon glyphicon-minus-sign'></i> La categoria <b><?php echo $_COOKIE["gradedeleted"]; ?></b> ha sido eliminada exitosamente.</p>
		<?php 
		setcookie("gradedeleted","",time()-18600);
		endif; ?>
		<?php if(isset($_COOKIE["gradeadded"])):?>
			<p class="alert alert-info"><i class='glyphicon glyphicon-ok-sign'></i> La categoria <b><?php echo $_COOKIE["gradeadded"]; ?></b> ha sido agregada exitosamente.</p>
		<?php 
		setcookie("gradeadded","",time()-18600);
		endif; ?>
<?php if(count($spents)>0):?>
<div class="box box-solid box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"></h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-primary btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body table-responsive">

<table class="table table-bordered table-hover datatable">
<thead>
	<th>Cant.</th>
	<th>Unidad</th>
	<th>Nombre</th>
	<th>Costo</th>
	<th>Categoria</th>
	<th>Fecha</th>
	<th></th>
</thead>
<?php foreach($spents as $career):?>
<tr>
	<td><?php echo $career->q; ?></td>
	<td><?php echo $career->unit; ?></td>
	<td><b><?php echo $career->concept; ?></b></td>
	<td style="width:170px;"><?php echo " $ ".$career->price; ?></td>
	<td><?php echo $career->name; ?></td>
	<td style="width:170px;"><?php echo $career->created_at; ?></td>
	<td style="width:50px;">
		<a href="#" id="del-<?php echo $career->id; ?>" class="btn btn-sm btn-danger"><i class='glyphicon glyphicon-trash'></i></a>
<script>
	$("#del-<?php echo $career->id?>").click(function(){
		c = confirm("Seguro quieres eliminar ??");
		if(c==true){
			window.location = "index.php?view=delcategory&id=<?php echo $career->id; ?>";
		}
	});
</script>
	</td>
</tr>
<?php endforeach; ?>
</table>
</div>
</div>
<?php else: // no careers ?>
<div class="jumbotron">
	<h2><i class="glyphicon glyphicon-minus-sign"></i> No hay gastos </h2>
</div>
<?php endif; ?>
	</div>
</div>
</section>