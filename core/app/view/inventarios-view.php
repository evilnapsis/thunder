<?php 
if(isset($_GET["opt"]) && $_GET['opt']=="all"):
?>




<section class="">
<?php
$data["posts"]=ProductData::getAll();
?>

                    <!--<a href="./inventarioreport.php" class="btn btn-success" target="_blank">Descargar</a>--><br><br>

 <div class="card">
                  <div class="card-header">
                    <strong>Inventario</strong>
                  </div>
                  <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary">
                            <div class="box-body">
                                    <table class="table datatable table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Serie</th>
                                                <th>Categoria</th>
                                                <th>Existencia</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($data["posts"] as $post):

$in = InventarioData::countByPT($post->id,1)->tot;
$out = InventarioData::countByPT($post->id,2)->tot;
$q = $in- $out;
                                            ?>
                                            <tr>
                                                <td><?=$post->name ;?></td>
                                                <td><?=$post->serie ;?></td>
                                                <td><?php if($post->category_id){ echo CategoryData::getById($post->category_id)->name ;} ?></td>

                                                <td><?=$q ;?></td>
                                                <td style="width:170px;">
                                                    <!--
                                                <a href="./?view=inventarios&opt=edit&id=<?=$post->id;?>" class="btn btn-sm btn-warning"><i class="bi-pencil"></i></a>
                                            
                                                <a href="./?action=inventarios&opt=del&id=<?=$post->id;?>" class="btn btn-sm btn-danger"><i class="bi-trash"></i></a>
                                            -->
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

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="allin"):?>
<section class="">
<?php
$data["posts"]=InventarioData::getAllBy("tipo_operacion",1);
?>


 <div class="card">
                  <div class="card-header">
<div class="row">
    <div class="col-md-6">
                    <strong>Inventario (Entradas)</strong>
    </div>
    <div class="col-md-6">
        <a href=""></a>
<!-- <a href="./inventarios.php?opt=in" id="link_report" class="btn btn-success btn-sm" target="_blank">Descargar</a>-->

    </div>
</div>

                  </div>
                  <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary">
                            <div class="box-body">
                                    <table class="table datatable table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Cantidad</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($data["posts"] as $post):

$product = ProductData::getById($post->product_id);
                                            ?>
                                            <tr>
                                                <td><?=$product->name ;?></td>
                                                <td><?=$post->q ;?></td>
                                                <td style="width:170px;">
                                                    <!--
                                                <a href="./?view=inventarios&opt=edit&id=<?=$post->id;?>" class="btn btn-sm btn-warning"><i class="bi-pencil"></i></a>
                                            
                                                <a href="./?action=inventarios&opt=del&id=<?=$post->id;?>" class="btn btn-sm btn-danger"><i class="bi-trash"></i></a>
                                            -->
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

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="allout"):?>
<section class="">
<?php
$data["posts"]=InventarioData::getAllBy("tipo_operacion",2);
?>


 <div class="card">
                  <div class="card-header">
<div class="row">
    <div class="col-md-6">
                    <strong>Inventario (Salidas)</strong>
    </div>
    <div class="col-md-6">
        <a href=""></a>
<!--<a href="./inventarios.php?opt=out" id="link_report" class="btn btn-success btn-sm" target="_blank">Descargar</a>-->

    </div>
</div>
                  </div>
                  <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary">
                            <div class="box-body">
                                    <table class="table datatable table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>Serie</th>
                                                <th>Nombre</th>
                                                <th>Cantidad</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($data["posts"] as $post):

$product = ProductData::getById($post->product_id);
                                            ?>
                                            <tr>
                                                <td><?=$product->serie ;?></td>
                                                <td><?=$product->name ;?></td>
                                                <td><?=$post->q ;?></td>
                                                <td style="width:170px;">
                                                    <!--
                                                <a href="./?view=inventarios&opt=edit&id=<?=$post->id;?>" class="btn btn-sm btn-warning"><i class="bi-pencil"></i></a>
                                            
                                                <a href="./?action=inventarios&opt=del&id=<?=$post->id;?>" class="btn btn-sm btn-danger"><i class="bi-trash"></i></a>
                                            -->
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

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="newin"):?>
            <!-- Breadcrumb-->



<section class="">

                <div class="row">
                    <div class="col-lg-6">


<!-- Inicio de card -->
 <div class="card">
                  <div class="card-header">
                    <strong>Agregar Existencias (Entrada)</strong>
                  </div>
                  <div class="card-body">



                    <div class="row">
                      <div class="col-sm-12">

                        <form role="form" method="post" action="./?action=inventarios&opt=addin" enctype="multipart/form-data">
                            <!--
                            <div class="form-group">
                                <label>Imagen (480x480)</label>
                                <input type="file" name="image">
                            </div>
                        -->


            <div class="form-group">
                                <label>Producto</label>
      <select name="product_id" required class="form-control" required>
        <option value="">-- SELECCIONE --</option>
        <?php foreach(ProductData::getAll() as $k):?>
          <option value="<?php echo $k->id; ?>"><?php echo $k->name; ?></option>
        <?php endforeach; ?>
      </select>

                            </div>




                            <div class="form-group">
                                <label>Cantidad</label>
                                <input type="number     " name="q" required class="form-control" placeholder="Cantidad">
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

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="newout"):?>
            <!-- Breadcrumb-->



<section class="">

                <div class="row">
                    <div class="col-lg-6">


<!-- Inicio de card -->
 <div class="card">
                  <div class="card-header">
                    <strong>Quitar Existencias (Salida)</strong>
                  </div>
                  <div class="card-body">



                    <div class="row">
                      <div class="col-sm-12">

                        <form role="form" method="post" action="./?action=inventarios&opt=addout" enctype="multipart/form-data">
                            <!--
                            <div class="form-group">
                                <label>Imagen (480x480)</label>
                                <input type="file" name="image">
                            </div>
                        -->


            <div class="form-group">
                                <label>Producto</label>
      <select name="product_id" required class="form-control" required>
        <option value="">-- SELECCIONE --</option>
        <?php foreach(ProductData::getAll() as $k):?>
          <option value="<?php echo $k->id; ?>"><?php echo $k->name; ?></option>
        <?php endforeach; ?>
      </select>

                            </div>




                            <div class="form-group">
                                <label>Cantidad</label>
                                <input type="number     " name="q" required class="form-control" placeholder="Cantidad">
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
$user = TipoServicioData::getById($_GET["id"]);
?>


                <div class="row">
                    <div class="col-lg-8">
 <div class="card">
                  <div class="card-header">
                    <strong>Modificar Tipo de Servicio</strong>
                  </div>
                  <div class="card-body">
                    <p class="alert alert-info">Es importante marcar el campo "Es Contrato" en los Servicios tipo Contrato.</p>
                        <form role="form" method="post" action="./?action=inventarios&opt=update" enctype="multipart/form-data">

                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="name" value="<?=$user->name;?>" class="form-control" placeholder="Nombre">
                            </div>
                            <div class="form-group">
                                <label>Tipo de Toma</label>

      <select name="tipo_toma_id" required class="form-control" required>
        <option value="">-- SELECCIONE --</option>
        <?php foreach(TipoTomaData::getAll() as $k):?>
          <option value="<?php echo $k->id; ?>" <?php if($user->tipo_toma_id==$k->id){ echo "selected";}?>><?php echo $k->name; ?></option>
        <?php endforeach; ?>
      </select>

                            </div>
                            <div class="form-group">
                                <label>Es Contrato</label>

      <select name="es_contrato" required class="form-control" required>
        <option value="0">NO</option>
        <option value="1">SI</option>
      </select>

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