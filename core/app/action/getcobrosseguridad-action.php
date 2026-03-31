<br><?php
//unset($_SESSION['cobro_list']);
//print_r($_SESSION['cobro_list']);
$cobrolist = $_SESSION['cobro_seguridad'];
?>

<table class="table table-bordered">
	<thead>
		<th>Servicio</th>
		<th>Monto</th>
		<th>Descuento</th>
		<th>Iva</th>
		<th>Total</th>
		<th></th>
	</thead>
<?php 
$tot=0;
$cnt=0;
foreach($cobrolist as $co):
///print_r($co);
	
	?>
	<tr>
		<td><?php $servi =  ServicioSeguridadData::getById($co["servicio_seguridad_id"]); echo $servi->name; ?></td>
		<td>$ <?php echo $co["amount"]; ?></td>
		<td>$ <?php echo $descu = $co["amount"]*($co["descuento"]/100); $subt = $co["amount"]-$descu; ?></td>
		<td>$ <?php echo ($subt)*($co["iva"]/100); ?></td>
		<td>$ <?php echo $subt + ($subt * ($co["iva"]) / 100); ?></td>
		<td><a href="./?action=removecobrosegulist&cnt=<?php echo $cnt; ?>&cat=<?php echo $servi->cat_seguridad_id; ?>" class="btn btn-danger btn-sm"><i class="bi-trash"></i></a></td>
	</tr>
<?php 
$cnt++;
$tot=$tot + $subt + ($subt * ($co["iva"]) / 100);

endforeach; ?>
</table>
<h1>Total a pagar: $ <?php echo number_format($tot,2,".",","); ?></h1>

                            <a href="./?action=cobrosseguridad&opt=add" class="btn btn-primary btn-lg">Agregar Venta</button>
