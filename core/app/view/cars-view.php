<?php 
if(isset($_GET["opt"]) && $_GET['opt']=="all"):
?>




<section class="">
<?php
$data["posts"]=CarData::getAll();
?>


 <div class="card">
                  <div class="card-header">
                    <strong>Vehiculos</strong>
                  </div>
                  <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                    <a href="./?view=cars&opt=new" class="btn btn-secondary">Nuevo Vehiculo</a>
                    <a href="./carsreport.php" class="btn btn-success" target="_blank">Descargar</a>

                    <br><br>
                        <div class="box box-primary">
                            <div class="box-body">
                                    <table class="table datatable table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th># </th>
                                                <th>Auto</th>
                                                <th>Placa</th>
                                                <th>MArca</th>
                                                <th>Modelo</th>
                                                <th>Año</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($data["posts"] as $post):
                                            ?>
                                            <tr>
                                                <td><?=$post->serie ;?></td>
                                                <td><?=$post->name ;?></td>
                                                <td><?=$post->placa ;?></td>

                                                <td><?=$post->marca ;?></td>
                                                <td><?=$post->modelo ;?></td>

                                                <td><?=$post->anio ;?></td>

                                                <td style="width:270px;">
                                                    
                                                <a href="./?view=cars&opt=edit&id=<?=$post->id;?>" class="btn btn-sm btn-warning"><i class="bi-pencil"></i></a>
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
    window.location = "./?action=cars&opt=del&id=<?=$post->id;?>";
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
                    <strong>Nuevo Vehiculo</strong>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-12">

                        <form role="form" method="post" action="./?action=cars&opt=add" enctype="multipart/form-data">
                            <!--
                            <div class="form-group">
                                <label>Imagen (480x480)</label>
                                <input type="file" name="image">
                            </div>
                        -->

                            <div class="form-group">
                                <label>Auto</label>
                                <input type="text" required  name="name" class="form-control" placeholder="Auto">
                            </div>
                            <div class="form-group">
                                <label># Serie</label>
                                <input type="text" required name="serie" class="form-control" placeholder="# Serie">
                            </div>
                            <div class="form-group">
                                <label># Placa</label>
                                <input type="text" required name="placa" class="form-control" placeholder="# Placa">
                            </div>
                            <div class="form-group">
                                <label>Marca</label>
                                <input type="text"  name="marca" class="form-control" placeholder="Marca">
                            </div>
                            <div class="form-group">
                                <label>Modelo</label>
                                <input type="text"  name="modelo" class="form-control" placeholder="Modelo">
                            </div>
                            <div class="form-group">
                                <label>Año</label>
                                <input type="text"  name="anio" class="form-control" placeholder="Año">
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
$user = CarData::getById($_GET["id"]);
?>


                <div class="row">
                    <div class="col-lg-12">
 <div class="card">
                  <div class="card-header">
                    <strong>Modificar Vehiculo</strong>
                  </div>
                  <div class="card-body">
                        <form role="form" method="post" action="./?action=cars&opt=update" enctype="multipart/form-data">


                            <div class="form-group">
                                <label>Auto</label>
                                <input type="text" value="<?=$user->name;?>" required name="name" class="form-control" placeholder="Auto">
                            </div>
                            <div class="form-group">
                                <label># Serie</label>
                                <input type="text" value="<?=$user->serie;?>" required name="serie" class="form-control" placeholder="# Serie">
                            </div>
                            <div class="form-group">
                                <label># Placa</label>
                                <input type="text" value="<?=$user->placa;?>" required name="placa" class="form-control" placeholder="# Placa">
                            </div>
                            <div class="form-group">
                                <label>Marca</label>
                                <input type="text" value="<?=$user->marca;?>"  name="marca" class="form-control" placeholder="Marca">
                            </div>
                            <div class="form-group">
                                <label>Modelo</label>
                                <input type="text" value="<?=$user->modelo;?>"  name="modelo" class="form-control" placeholder="Modelo">
                            </div>
                            <div class="form-group">
                                <label>Año</label>
                                <input type="text" value="<?=$user->anio;?>"  name="anio" class="form-control" placeholder="Año">
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