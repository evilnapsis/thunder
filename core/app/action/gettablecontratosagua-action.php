
<?php
$start = $_GET['date_start'];
$end = $_GET['date_end'];
$data["posts"]=ContratoAguaData::getAllByRange($start, $end);
                                    ?>

                                                                       <table class="table datatable table-bordered table-hover table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th># Contrato</th>
                                                <th>Cliente</th>
                                                <th>Tipo de Contrato</th>
<th>Monto</th>
                                                <th>Desc.</th>
                                                <th>Iva</th>
                                                <th>Total</th>
                                                <th>Fecha</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                            $total = 0;
                                            $total_desc = 0;
                                            $iva = 0;
                                            $totaliva = 0;
                                            $totaltot =0;
                                            $totaldesc=0;
                                            $totaltotal=0;

                                        foreach($data["posts"] as $post):
                                                
                                                $total= $post->amount; 
                                                $total_desc = $post->descuento;
                                                $subt1 = $post->amount * ($post->descuento/100);
                                                $subt2 = $post->amount - $subt1;
                                                $subt3 = $subt2 * ($post->iva / 100);
                                                $subt4 = $subt2 + $subt3 ;
                                                $totaliva = $subt3;
                                                $totaltot  = $subt4;
                                                $totaldesc = $subt1;
                                                                                                $totaltotal+=$totaltot;

                                            $user = ClientData::getById($post->client_id);
                                            ?>
                                            <tr>
                                                <td><?=$post->code ;?></td>
                                                <td><?=$user->name." ".$user->lastname." ".$user->lastname2 ;?></td>
                                                <td><?php if($post->tipo_contrato==1){
                                                    echo "Domestico";
                                                } 
                                                else if($post->tipo_contrato==2){
                                                    echo "Comercial";
                                                }else if($post->tipo_contrato==3){
                                                    echo "Industrial";
                                                }

                                            ?></td>
                                                <td>$ <?=$total ;?></td>
                                                <td>$ <?=$totaldesc ;?></td>
                                                <td>$ <?=$totaliva ;?></td>
                                                <td>$ <?=$totaltot ;?></td>
                                                <td><?=$post->date_at ;?></td>

                                                <td style="width:270px;">
                                                    
                                                <a href="./contratoagua2.php?id=<?=$post->id;?>" target="_blank" class="btn btn-sm btn-info"><i class="bi-file-text"></i> Contrato</a>
                                                <a href="./?view=contratosagua&opt=edit&id=<?=$post->id;?>" class="btn btn-sm btn-warning"><i class="bi-pencil"></i></a>
                                            
                                                <a id="delitem-<?=$post->id;?>" class="btn btn-sm btn-danger"><i class="bi-trash"></i></a>
<script type="text/javascript">
<?php if(isset($_SESSION["deleted_item"])):?>
    Swal.fire("Eliminado!", "", "success");
    <?php unset($_SESSION['deleted_item']); endif;?>

    $("#delitem-<?php echo $post->id?>").click(function(){
Swal.fire({
  title: "Estas seguro que deseas Eliminar ?",
  showCancelButton: true,
  showDenyButton: true,

  confirmButtonText: "Eliminar",
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.isConfirmed) {
    window.location = "./?action=contratosagua&opt=del&id=<?=$post->id;?>";
  } else if(result.isDenied){
    Swal.fire("Operacion cancelada!", "", "info");
  }
});

    });
</script>
                
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                        </tbody>
                                    </table>
                                    <h1>Total: $ <?php echo number_format($totaltotal, "2",".",","); ?></h1>