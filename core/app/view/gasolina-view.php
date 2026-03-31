<?php 
if(isset($_GET["opt"]) && $_GET['opt']=="all"):
?>




<section class="">
<?php
$data["posts"]=GasolinaData::getAll();
?>


 <div class="card">
                  <div class="card-header">
                    <strong>Control de Gas</strong>
                  </div>
                  <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">

<form class="row g-3" id="filter_form">
  <div class="col-auto">
                    <a href="./?view=gasolina&opt=new" class="btn btn-secondary">Nueva Asignacion de Gas</a>
  </div>
  <div class="col-auto">
    <label for="inputPassword2" class="visually-hidden">Fecha Inicio</label>
    <input type="date" name="date_start" class="form-control" id="date_start" placeholder="Fecha inicio">
  </div>

  <div class="col-auto">
    <label for="inputPassword2" class="visually-hidden">Fecha Fin</label>
    <input type="date" name="date_end" class="form-control" id="date_end" placeholder="Fecha fin">
  </div>
  <!--
  <div class="col-auto">
    <button type="submit" class="btn btn-primary mb-3"><i class="bi-filter"></i> Filtrar</button>
  </div>-->
  <div class="col-auto">
<a href="./gasolinareport.php" id="link_report" class="btn btn-success" target="_blank">Descargar</a>
  </div>

</form>
<script type="text/javascript">
    $("#date_start").change(function(){
        val1 = $("#date_start").val();
        val2 = $("#date_end").val();

        if(val1!="" && val2!=""){
        link = $("#link_report").attr("href","./gasolinareport.php?start="+val1+"&end="+val2);       
        //alert(val1);
        $.get("./?action=gettablegasolina",$("#filter_form").serialize(), function(data){
            $("#filter_table").html(data);
        $(".datatable").DataTable({"pageLength":25,"language": {
        url: './vendors/datatables/esmx.json',
    }});
        });

        }
    });
    $("#date_end").change(function(){
        val1 = $("#date_start").val();
        val2 = $("#date_end").val();

        if(val1!="" && val2!=""){
        link = $("#link_report").attr("href","./gasolinareport.php?start="+val1+"&end="+val2);       
        //alert(val2);

        $.get("./?action=gettablegasolina",$("#filter_form").serialize(), function(data){
            console.log(data);
            $("#filter_table").html(data);
        $(".datatable").DataTable({"pageLength":25,"language": {
        url: './vendors/datatables/esmx.json',
    }});
        });

        }
    });

</script>


                        <div class="box box-primary">
                            <div class="box-body">
                                <div id="filter_table">
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
                                </div>
                        </div>
                        </div>
                    </div>
                </div>
</div>
</div>

                <!-- /.row -->
                </section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="new"):?>
            <!-- Breadcrumb-->



<section class="">

                <div class="row">
                    <div class="col-lg-6">


<!-- Inicio de card -->
 <div class="card">
                  <div class="card-header">
                    <strong>Asignacion de Gas</strong>
                  </div>
                  <div class="card-body">



                    <div class="row">
                      <div class="col-sm-12">

                        <form role="form" method="post" action="./?action=gasolina&opt=add" enctype="multipart/form-data">
                            <!--
                            <div class="form-group">
                                <label>Imagen (480x480)</label>
                                <input type="file" name="image">
                            </div>
                        -->

                            <div class="form-group">
                                <label>Fecha de asignacion</label>
                                <input type="date" name="date_at" class="form-control" placeholder="Fecha de asignacion">
                            </div>



            <div class="form-group">
                                <label>Chofer</label>
      <select name="driver_id" required class="form-control" required>
        <option value="">-- SELECCIONE --</option>
        <?php foreach(DriverData::getAll() as $k):?>
          <option value="<?php echo $k->id; ?>"><?php echo $k->name; ?></option>
        <?php endforeach; ?>
      </select>

                            </div>
            <div class="form-group">
                                <label>Vehiculo</label>
      <select name="car_id" required class="form-control" required>
        <option value="">-- SELECCIONE --</option>
        <?php foreach(CarData::getAll() as $k):?>
          <option value="<?php echo $k->id; ?>"><?php echo $k->placa; ?> - <?php echo $k->name; ?></option>
        <?php endforeach; ?>
      </select>

                            </div>

                            <div class="form-group">
                                <label>Litros</label>
                                <input type="text" name="litros" required class="form-control" placeholder="Litros">
                            </div>
                            <div class="form-group">
                                <label>Descripcion</label>
                                <input type="text" name="description" class="form-control" placeholder="Descripcion">
                            </div>
<br>
                            <button type="submit" class="btn btn-primary">Agregar</button>

                        </form>

                      </div>
                    </div>
                </div>
            </div>
<!-- Fin de la card -->
                    </div>
                    <div class="col-lg-3">


                    </div>
                </div>
                <!-- /.row -->
<br><br><br><br><br>
</section>
<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="edit"):?>


<section class="">
<?php
$user = GasolinaData::getById($_GET["id"]);
?>


                <div class="row">
                    <div class="col-lg-8">
 <div class="card">
                  <div class="card-header">
                    <strong>Modificar Asignacion de Gas</strong>
                  </div>
                  <div class="card-body">
                        <form role="form" method="post" action="./?action=gasolina&opt=update" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Fecha de asignacion</label>
                                <input type="date" name="date_at" value="<?=$user->date_at;?>" class="form-control" placeholder="Fecha de asignacion">
                            </div>


                            <div class="form-group">
                                <label>Chofer</label>

      <select name="driver_id" required class="form-control" required>
        <option value="">-- SELECCIONE --</option>
        <?php foreach(DriverData::getAll() as $k):?>
          <option value="<?php echo $k->id; ?>" <?php if($user->driver_id==$k->id){ echo "selected";}?>><?php echo $k->name; ?></option>
        <?php endforeach; ?>
      </select>

                            </div>
                            <div class="form-group">
                                <label>Vehiculo</label>

      <select name="car_id" required class="form-control" required>
        <option value="">-- SELECCIONE --</option>
        <?php foreach(CarData::getAll() as $k):?>
          <option value="<?php echo $k->id; ?>" <?php if($user->car_id==$k->id){ echo "selected";}?>><?php echo $k->placa; ?> - <?php echo $k->name; ?></option>
        <?php endforeach; ?>
      </select>

                            </div>

                            <div class="form-group">
                                <label>Litros</label>
                                <input type="text" name="litros" value="<?=$user->litros;?>" class="form-control" placeholder="Litros">
                            </div>
                            <div class="form-group">
                                <label>Descripcion</label>
                                <input type="text" name="description" value="<?=$user->description;?>" class="form-control" placeholder="Descripcion">
                            </div>
<br>
                            <input type="hidden" name="id" value="<?=$user->id;?>">
                            <button type="submit" class="btn btn-primary">Actualizar</button>

                        </form>
                    </div>
                </div>

                    </div>

                </div>
                <!-- /.row -->
<br><br><br><br><br>
</section>
<?php endif; ?>