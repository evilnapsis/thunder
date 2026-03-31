
<?php
$start = $_GET['date_start'];
$end = $_GET['date_end'];
$data["posts"]=CobroAguaListData::getAllByRange($start, $end);
                                    ?>

                                    <table class="table datatable table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th># Id</th>
                                                <th># Contrato</th>
                                                <th>Cliente</th>
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
                                            $cobros = CobroAguaData::getAllBy("cobro_agua_list_id",$post->id);
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
                                                <td><?=$post->contrato_agua ;?></td>
                                                <td><?=$user->name." ".$user->lastname." ".$user->lastname2 ;?></td>

                                                <td><?=TipoServicioData::getById($cobros[0]->tipo_servicio_id)->name ;?></td>

                                                <td>$ <?=$total ;?></td>
                                                <td>$ <?=$totaldesc ;?></td>
                                                <td>$ <?=$totaliva ;?></td>
                                                <td>$ <?=$totaltot ;?></td>
                                                <td><?=$cobros[0]->date_at ;?></td>

                                                <td style="width:270px;">
                                                    
                                                <a href="./ticketagua.php?id=<?=$post->id;?>" target="_blank" class="btn btn-sm btn-info"><i class="bi-file-text"></i> Ticket</a>
                                                <!--<a href="./?view=cobrosagua&opt=edit&id=<?=$post->id;?>" class="btn btn-sm btn-warning"><i class="bi-pencil"></i></a> -->
                                            
                                                <a href="./?action=cobrosagua&opt=del&id=<?=$post->id;?>" class="btn btn-sm btn-danger"><i class="bi-trash"></i></a>
                                                </td>
                                            </tr>
                                        <?php endif; endforeach;?>
                                        </tbody>
                                    </table>
                                  <h1>Total: $ <?php echo number_format($totaltotal, "2",".",","); ?></h1>
                             

