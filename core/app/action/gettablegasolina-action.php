
<?php
$start = $_GET['date_start'];
$end = $_GET['date_end'];
$data["posts"]=GasolinaData::getAllByRange($start, $end);
                                    ?>

                                    <table class="table datatable table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>Chofer</th>
                                                <th>Vehiculo</th>
                                                <th>Litros</th>
                                                <th>Descripcion</th>
                                                <th>Fecha de Asignacion</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $tot=0;foreach($data["posts"] as $post):?>
                                            <tr>
                                                <td><?=DriverData::getById($post->driver_id)->name ;?></td>
                                                <td><?=CarData::getById($post->car_id)->name ;?></td>
                                                <td><?=$post->litros ;?></td>
                                                <td><?=$post->description ;?></td>
                                                <td><?=$post->date_at ;?></td>
                                                <td style="width:170px;">
                                                    
                                                <a href="./?view=gasolina&opt=edit&id=<?=$post->id;?>" class="btn btn-sm btn-warning"><i class="bi-pencil"></i></a>
                                            
 <?php if(Core::$user->kind==1 || Core::$user->kind==2 || Core::$user->kind==3):?>                                         
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
    window.location = "./?action=gasolina&opt=del&id=<?=$post->id;?>";
  } else if(result.isDenied){
    Swal.fire("Operacion cancelada!", "", "info");
  }
});

    });
</script>
<?php $tot+=$post->litros; endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                        </tbody>
                                    </table>
                                    <h1>Total Litros: <?php echo $tot; ?></h1>

