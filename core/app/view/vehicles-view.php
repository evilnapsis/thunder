<?php 
if(isset($_GET["opt"]) && $_GET['opt']=="all"):
?>




<section class="">
<?php
$data["posts"]=TipoServicioData::getAll();
?>


 <div class="card">
                  <div class="card-header">
                    <strong>Tipos de Servicio</strong>
                  </div>
                  <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                    <a href="./?view=vehicles&opt=new" class="btn btn-secondary">Nuevo Vehiculo</a><br><br>
                        <div class="box box-primary">
                            <div class="box-body">
                                    <table class="table datatable table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Precio</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($data["posts"] as $post):?>
                                            <tr>
                                                <td><?=$post->name ;?></td>
                                                <td><?=$post->price ;?></td>
                                                <td style="width:170px;">
                                                    
                                                <a href="./?view=vehicles&opt=edit&id=<?=$post->id;?>" class="btn btn-sm btn-warning"><i class="bi-pencil"></i></a>
                                            
                                                <a href="./?action=vehicles&opt=del&id=<?=$post->id;?>" class="btn btn-sm btn-danger"><i class="bi-trash"></i></a>
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
                    <div class="col-lg-8">


<!-- Inicio de card -->
 <div class="card">
                  <div class="card-header">
                    <strong>Nuevo Vehiculo</strong>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-12">

                        <form role="form" method="post" action="./?action=vehicles&opt=add" enctype="multipart/form-data">
                            <!--
                            <div class="form-group">
                                <label>Imagen (480x480)</label>
                                <input type="file" name="image">
                            </div>
                        -->
                            <div class="form-group">
                                <label>Auto</label>
                                <input type="text" name="name" class="form-control" placeholder="Auto">
                            </div>
                            <div class="form-group">
                                <label>No. Serie</label>
                                <input type="text" name="name" class="form-control" placeholder="No. Serie">
                            </div>

                            <div class="form-group">
                                <label>Placa</label>
                                <input type="text" name="name" class="form-control" placeholder="Placa">
                            </div>
                            <div class="form-group">
                                <label>Marca</label>
                                <input type="text" name="price" class="form-control" placeholder="Marca">
                            </div>                            
                            <div class="form-group">
                                <label>Modelo</label>
                                <input type="text" name="price" class="form-control" placeholder="Modelo">
                            </div>
<div class="form-group">
                                <label>Año</label>
                                <input type="text" name="price" class="form-control" placeholder="Año">
                            </div>
<br>
                            <button type="submit" class="btn btn-primary">Agregar Vehiculo</button>

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


<section class="container">
<?php
$user = TipoServicioData::getById($_GET["id"]);
?>


                <div class="row">
                    <div class="col-lg-12">
 <div class="card">
                  <div class="card-header">
                    <strong>Modificar Vehiculo</strong>
                  </div>
                  <div class="card-body">
                        <form role="form" method="post" action="./?action=vehicles&opt=update" enctype="multipart/form-data">

                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="name" value="<?=$user->name;?>" class="form-control" placeholder="Nombre">
                            </div>


                            <div class="form-group">
                                <label>Precio</label>
                                <input type="text" name="price" value="<?=$user->price;?>" class="form-control" placeholder="Precio">
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