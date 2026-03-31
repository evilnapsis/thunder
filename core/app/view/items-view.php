<?php 
if(isset($_GET["opt"]) && $_GET['opt']=="all"):
    $sec="Todos";
    $data["posts"]=ItemData::getAll();

    if(isset($_GET["sec"]) && $_GET["sec"]!=""){
        if($_GET["sec"]=="extern"){ $sec="Unidad Externa";
$data["posts"]=ItemData::getAllBy("kind",2);

    }
        if($_GET["sec"]=="intern"){ $sec="Unidad Interna";
$data["posts"]=ItemData::getAllBy("kind",1);

    }
    }
?>




<section class="">
<?php
?>


 <div class="card">
                  <div class="card-header">
                    <strong>Aire Acondicionado (<?php echo $sec; ?>)</strong>
                  </div>
                  <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                    <a href="./?view=items&opt=all" class="btn btn-secondary">Ver Todo</a>
                    <a href="./?view=items&opt=all&sec=extern" class="btn btn-secondary">Ver Unidades Externas</a>
                    <a href="./?view=items&opt=all&sec=intern" class="btn btn-secondary">Ver Unidades Internas</a>
                    <a href="./?view=items&opt=new&sec=extern" class="btn btn-secondary">Nueva Unidad Externa</a>
                    <a href="./?view=items&opt=new&sec=intern" class="btn btn-secondary">Nueva Unidad Interna</a>
   <!--                 <a href="./productsreport.php" class="btn btn-success" target="_blank">Descargar</a>
-->
                    <br><br>
                        <div class="box box-primary">
                            <div class="box-body">
<script type="text/javascript">
<?php if(isset($_SESSION["deleted_item"])):?>
    Swal.fire("Eliminado!", "", "success");
    <?php unset($_SESSION['deleted_item']); 
endif;?>
</script>
                                    <table class="table datatable table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>Codigo</th>
                                                <th>Nombre</th>
                                                <th>Serie</th>
                                                <th>Marca</th>
                                                <th>Tipo</th>
                                                <th>Precio Entrada</th>
                                                <th>Precio Salida</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $tot_entrada = $tot_salida =0; foreach($data["posts"] as $post):
$tot_entrada += $post->price_in;
$tot_salida += $post->price_out;
                                       ?>
                                            <tr>
                                                <td><?=$post->code ;?></td>
                                                <td><?=$post->name ;?></td>
                                                <td><?=$post->serie ;?></td>
                                                <td><?php if($post->brand_id){ echo BrandData::getById($post->brand_id)->name ;} ?></td>
                                                <td>
                                                    <?php
if($post->kind==1){ echo "Unidad Interna";}
else if($post->kind==2){ echo "Unidad Externa";}

                                                    ?>
                                                </td>
                                                <td>$ <?=number_format($post->price_in,2,".",",") ;?></td>
                                                <td>$ <?=number_format($post->price_out,2,".",",") ;?></td>
                                                <td>
                                                    <?php
if($post->status==1){ echo "En Stock";}
else if($post->status==2){ echo "Vendido";}

                                                    ?>
                                                </td>

                                                <td style="width:170px;">
                                                    
                                                <a href="./?view=items&opt=edit&id=<?=$post->id;?>" class="btn btn-sm btn-warning"><i class="bi-pencil"></i></a>
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
    window.location = "./?action=items&opt=del&id=<?=$post->id;?>";
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
                   <!--
                    <h1>Total Entrada: $ <?php echo $tot_entrada; ?></h1>
                    <h1>Total Salida: $ <?php echo $tot_salida; ?></h1>
                    -->
        </div>
        </div>
    </div>
</div>
</div>
</div>

                <!-- /.row -->
                </section>

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="new"):
$sec="";
$kind=0;
    if(isset($_GET["sec"]) && $_GET["sec"]!=""){
        if($_GET["sec"]=="extern"){ $sec="Unidad Externa"; $kind=2; }
        if($_GET["sec"]=="intern"){ $sec="Unidad Interna"; $kind=1; }
    }else{
        Core::redir("./?view=items&opt=all");
    }

    ?>
            <!-- Breadcrumb-->



<section class="">

                <div class="row">
                    <div class="col-lg-8">


<!-- Inicio de card -->
 <div class="card">
                  <div class="card-header">
                    <strong>Nuevo Equipo (<?php echo $sec; ?>)</strong>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-12">

                        <form role="form" method="post" action="./?action=items&opt=add" enctype="multipart/form-data">
                            <!--
                            <div class="form-group">
                                <label>Imagen (480x480)</label>
                                <input type="file" name="image">
                            </div>
                        -->
                        <input type="hidden" name="kind" value="<?php echo $kind; ?>">
                            <div class="form-group">
                                <label>Codigo</label>
                                <input type="text" name="code" class="form-control" placeholder="Codigo">
                            </div>
                            <div class="form-group">
                                <label>Codigo de barras</label>
                                <input type="text" name="barcode" class="form-control" placeholder="Codigo de barras">
                            </div>
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="name" required class="form-control" placeholder="Nombre">
                            </div>
                            <div class="form-group">
                                <label>Serie</label>
                                <input type="text" name="serie" class="form-control" placeholder="Serie">
                            </div>
    <div class="form-group">
                                <label><b>Marca</b></label>
      
      <select name="brand_id" id="brand_id"  class="form-control" >
        <option value="">-- SELECCIONE --</option>
        <?php foreach(BrandData::getAll() as $k):?>
          <option value="<?php echo $k->id; ?>"><?php echo $k->name; ?></option>
        <?php endforeach; ?>
      </select>
                            </div>
                            <div class="form-group">
                                <label>Descripcion</label>
                                <input type="text" name="description" class="form-control" placeholder="Descripcion">
                            </div>
                            <div class="form-group">
                                <label>Precio Entrada</label>
                                <input type="text" name="price_in" required class="form-control" placeholder="Precio Entrada">
                            </div>                            <div class="form-group">
                                <label>Precio Salida</label>
                                <input type="text" name="price_out" required class="form-control" placeholder="Precio Salida">
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


<section class="container">
<?php
$user = ItemData::getById($_GET["id"]);
?>


                <div class="row">
                    <div class="col-lg-12">
 <div class="card">
                  <div class="card-header">
                    <strong>Modificar Equipo</strong>
                  </div>
                  <div class="card-body">
                        <form role="form" method="post" action="./?action=items&opt=update" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Codigo</label>
                                <input type="text" name="code" value="<?=$user->code;?>" class="form-control" placeholder="Codigo">
                            </div>
                            <div class="form-group">
                                <label>Codigo de barras</label>
                                <input type="text" name="barcode" value="<?=$user->barcode;?>" class="form-control" placeholder="Codigo de barras">
                            </div>
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="name" value="<?=$user->name;?>" class="form-control" placeholder="Nombre">
                            </div>
                            <div class="form-group">
                                <label>Serie</label>
                                <input type="text" name="serie" value="<?=$user->serie; ?>" class="form-control" placeholder="Serie">
                            </div>
                            <div class="form-group">
                                <label>Marca de Producto</label>

      <select name="brand_id" id="brand_id"   class="form-control" >
        <option value="">-- SELECCIONE --</option>
        <?php foreach(BrandData::getAll() as $k):?>
          <option value="<?php echo $k->id; ?>" <?php if($k->id==$user->brand_id){ echo "selected"; }?>><?php echo $k->name; ?></option>
        <?php endforeach; ?>
      </select>
                  </div>   

                            <div class="form-group">
                                <label>Descripcion</label>
                                <input type="text" name="description"   value="<?=$user->description;?>" class="form-control" placeholder="Descripcion">
                            </div>
                            <div class="form-group">
                                <label>Precio Entrada</label>
                                <input type="text" name="price_in"  value="<?=$user->price_in;?>" class="form-control" placeholder="Precio Entrada">
                            </div>                            <div class="form-group">
                                <label>Precio Salida</label>
                                <input type="text" name="price_out"  value="<?=$user->price_out;?>" class="form-control" placeholder="Precio Salida">
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