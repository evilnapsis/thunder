<?php 
if(isset($_GET["opt"]) && $_GET['opt']=="all"):
    $cat = CatSeguridadData::getById($_GET['id'])
?>
<section class="">
<?php
$data["posts"]=ServicioSeguridadData::getAllBy("cat_seguridad_id",$_GET['id']);
?>


 <div class="card">
                  <div class="card-header">
                    <strong><?php echo $cat->name; ?></strong>
                  </div>
                  <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                    <a href="./?view=serviciosseguridad&opt=new&id=<?php echo $cat->id; ?>" class="btn btn-secondary">Nuevo Servicio (<?php echo $cat->name; ?>)</a><br><br>
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
                                                    
                                                <a href="./?view=serviciosseguridad&opt=edit&id=<?=$post->id;?>" class="btn btn-sm btn-warning"><i class="bi-pencil"></i></a>
                                            
                                                <a href="./?action=serviciosseguridad&opt=del&id=<?=$post->id;?>" class="btn btn-sm btn-danger"><i class="bi-trash"></i></a>
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

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="new"):

        $cat = CatSeguridadData::getById($_GET['id'])
?>
            <!-- Breadcrumb-->



<section class="">

                <div class="row">
                    <div class="col-lg-6">


<!-- Inicio de card -->
 <div class="card">
                  <div class="card-header">
                    <strong>Nuevo Servicio (<?php echo $cat->name; ?>)</strong>
                  </div>
                  <div class="card-body">



                    <div class="row">
                      <div class="col-sm-12">

                        <form role="form" method="post" action="./?action=serviciosseguridad&opt=add" enctype="multipart/form-data">
                            <input type="hidden" name="cat_seguridad_id" value="<?php echo $cat->id; ?>">
                            <!--
                            <div class="form-group">
                                <label>Imagen (480x480)</label>
                                <input type="file" name="image">
                            </div>
                        -->
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="name" class="form-control" placeholder="Nombre">
                            </div>






                            <div class="form-group">
                                <label>Precio</label>
                                <input type="text" name="price" class="form-control" placeholder="Precio">
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
<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="edit"):


?>


<section class="">
<?php
$user = ServicioSeguridadData::getById($_GET["id"]);
$cat = CatSeguridadData::getById($user->cat_seguridad_id);
?>


                <div class="row">
                    <div class="col-lg-8">
 <div class="card">
                  <div class="card-header">
                    <strong>Modificar Servicio (<?php echo $cat->name; ?>)</strong>
                  </div>
                  <div class="card-body">
                        <form role="form" method="post" action="./?action=serviciosseguridad&opt=update" enctype="multipart/form-data">

                            <input type="hidden" name="cat_seguridad_id" value="<?php echo $cat->id; ?>">
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