<div class="content-header">
	<h1>Historial de resumen</h1>
</div>
<section class="content">
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		
<?php

$all = OperationData::getAllDates();

?>
<?php if(count($all)>0):?>
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
		<th></th>
		<th>Fecha</th>
	</thead>
	<?php foreach($all as $a):?>
	<tr>
		<td style="width:50px;">
			<a href="index.php?view=resumebydate&date=<?php echo $a->d; ?>" class="btn btn-xs btn-default"><i class="glyphicon glyphicon-chevron-right"></i> </a>
		</td>
		<td><?php echo date("d \d\\e  M \d\\e\l Y",strtotime($a->created_at));?></td>
	</tr>
	<?php endforeach; ?>
</table>
</div>
</div>
	<?php else: ?>
	<?php endif; ?>
	</div>
</div>
</section>