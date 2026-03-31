<br><?php
//unset($_SESSION['cobro_list']);
//print_r($_SESSION['cobro_list']);
$cobrolist = $_SESSION['cobro_tesoreria'];
?>

<table class="table table-bordered">
	<thead>
		<th>Servicio</th>
		<th>Periodo</th>
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
		<td><?php $servi = ServicioTesoreriaData::getById($co["servicio_tesoreria_id"]); echo $servi->name; ?></td>
		<td><?php if($co["periodo_id"]!=""){ $peri = PeriodoData::getById($co["periodo_id"]); echo $peri->name;} ?></td>
		<td>$ <?php echo $co["amount"]; ?></td>
		<td>$ <?php echo $descu = $co["amount"]*($co["descuento"]/100); $subt = $co["amount"]-$descu; ?></td>
		<td>$ <?php echo ($subt)*($co["iva"]/100); ?></td>
		<td>$ <?php echo $subt + ($subt * ($co["iva"]) / 100); ?></td>
		<td><a href="./?action=removecobrotesolist&cnt=<?php echo $cnt; ?>&cat=<?php echo $servi->cat_tesoreria_id; ?>" class="btn btn-danger btn-sm"><i class="bi-trash"></i></a></td>
	</tr>
<?php 
$cnt++;
$tot=$tot + $subt + ($subt * ($co["iva"]) / 100);

endforeach; ?>
</table>
<h1>Total a pagar: $ <?php echo number_format($tot,2,".",","); ?></h1>

                            <a href="./?action=cobrostesoreria&opt=add" class="btn btn-primary btn-lg">Agregar Venta</button>
