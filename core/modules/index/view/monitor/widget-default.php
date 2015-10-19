<?php
//date_default_timezone_set("America/Hermosillo");
$user = UserData::getById(Session::getUID());
?>



                <section class="content-header">
                       		<h1>Monitor</h1>

                </section>

<div class="content">
<div class="row">
	<div class="col-md-12">


		<div class="clearfix"></div>

                    <div class="row">
<section class="col-lg-12">

<div class="panel panel-default">
                                <div class="panel-heading">
                                        Mesas
                                </div>
<table class="table table-bordered table-hover datatable">
<thead>
    <th>Numero</th>
    <th></th>
</thead>
<?php foreach(ItemData::getAll() as $career):?>
<tr>
    <td><b><?php echo $career->name; ?></b></td>
    <td>
<?php
$sells = SellData::getAllUnAppliedByItemId($career->id);
?>
<?php if(count($sells)>0):?>
    <?php foreach($sells as $s):?>
    <?php 
    $operations = OperationData::getAllProductsBySellId($s->id);
    $mesero = UserData::getById($s->mesero_id);

    ?>
        <?php if(count($operations)>0):?>
            <table class="table table-bordered">
            <tr>
                <td><a href="./?view=onesell&id=<?php echo $s->id;?>" class="btn btn-xs btn-default">Id: <?php echo $s->id; ?></a></td>
                <td>Mesero: <?php echo $mesero->name." ".$mesero->lastname;?></td>
                <td></td>
            </tr>
            <tr>
                <th>Producto</th>
                <th>Cant.</th>
                <th>Tiempo (mins)</th>
            </tr>
                <?php 
                $np=0;$nd=0;
                foreach($operations as $operation):
                $product = ProductData::getById($operation->product_id); ?>
                    <tr>
                        <td><?php echo $product->name;?></td>
                        <td><?php echo $operation->q;?></td>
                        <td><?php echo $product->duration*$operation->q;?></td>
                    </tr>
                <?php
                $np += $operation->q;
                $nd += $operation->q*$product->duration;
                 endforeach; ?>
                    <tr>
                        <td></td>
                        <td><?php echo $np;?></td>
                        <td><?php echo $nd;?></td>
                    </tr>

            </table>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>
    </td>
</tr>
<?php endforeach; ?>
</table>
</div>


</section>
                        
                    </div>
	</div>
</div>
</div>
