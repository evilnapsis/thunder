<?php
$start = $_GET['date_start'];
$end = $_GET['date_end'];
$data["posts"]=LicenciaData::getAllByRange($start, $end);
// print_r($_GET);
// print_r($data);
?>

<table class="table datatable table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th># Id</th>
                                                <th>Cliente</th>
                                                <th>Negocio</th>
                                                <th>Vigencia</th>
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

                                                <td><?=$post->negocio ;?></td>
                                                <td><?=$post->vigencia ;?></td>

                                                <!-- <td>$ <?=$post->amount ;?></td> -->
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
                                                <a href="./licencia.php?id=<?=$post->id;?>" target="_blank" class="btn btn-sm btn-info"><i class="bi-file-text"></i> Licencia</a>

                                                <a href="./?view=licencias&opt=edit&id=<?=$post->id;?>" class="btn btn-sm btn-warning"><i class="bi-pencil"></i></a>
                                            
  <?php if(Core::$user->kind==1 || Core::$user->kind==2 || Core::$user->kind==4):?>
                                                <a id="delitem-<?=$post->id;?>" class="btn btn-sm btn-danger"><i class="bi-trash"></i></a>

<script type="text/javascript">

    $("#delitem-<?php echo $post->id?>").click(function(){
Swal.fire({
  title: "Estas seguro que deseas Eliminar ?",
  showCancelButton: true,
  showDenyButton: true,

  confirmButtonText: "Eliminar",
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.isConfirmed) {
    window.location = "./?action=licencias&opt=del&id=<?=$post->id;?>";
  } else if(result.isDenied){
    Swal.fire("Operacion cancelada!", "", "info");
  }
});

    });
</script>
<?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                        </tbody>
                                    </table>
