<?php
$start = $_GET['date_start'];
$end = $_GET['date_end'];
$data["posts"]=AudienciaData::getAllByRange($start, $end);
// print_r($_GET);
// print_r($data);
?>

<table class="table datatable table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th># Id</th>
                                                <th>Cliente</th>
                                                <th>Tipo de Apoyo Solicitado</th>
                                                <th>Motivo</th>
                                                <th>Cantidad</th>
                                                <th>Status</th>
                                                <th>Fecha</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($data["posts"] as $post):
                                            $user = ClientData::getById($post->client_id);
                                            ?>
                                            <tr>
                                                <td><?=$post->code ;?></td>
                                                <td><?=$user->name." ".$user->lastname." ".$user->lastname2 ;?></td>
                                                <td><?php echo TipoApoyoData::getById($post->tipo_apoyo_id)->name;?></td>

                                                <td><?=$post->motivo ;?></td>

                                                <td>$ <?=$post->amount ;?></td>
                                                <td><?php if($post->status==1){
                                                    echo "Vigente";
                                                } 
                                                else if($post->status==2){
                                                    echo "En Proceso";
                                                }else if($post->status==3){
                                                    echo "Aprobado";
                                                }else if($post->status==4){
                                                    echo "Finalizado";
                                                }else if($post->status==5){
                                                    echo "Cancelado";
                                                }



                                            ?></td>
                                                <td><?=$post->date_at ;?></td>

                                                <td style="width:270px;">
                                                    <a href="./audiencia.php?id=<?php echo $post->id; ?>" class="btn btn-info btn-sm" target="_blank">Imprimir </a>
                                                <a href="./?view=audiencias&opt=edit&id=<?=$post->id;?>" class="btn btn-sm btn-warning"><i class="bi-pencil"></i></a>
                                            
                                                <a href="./?action=audiencias&opt=del&id=<?=$post->id;?>" class="btn btn-sm btn-danger"><i class="bi-trash"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                        </tbody>
                                    </table>
