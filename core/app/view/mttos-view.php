<?php 
if(isset($_GET["opt"]) && $_GET['opt']=="all"):
?>




<section class="">
<?php
$data["posts"]=InstalationData::getAll();
?>


 <div class="card">
                  <div class="card-header">
                    <strong>Servicios</strong>
                  </div>
                  <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                    <a href="./?view=mttos&opt=new" class="btn btn-secondary">Nuevo Servicio</a>
   <!--                 <a href="./mttosreport.php" class="btn btn-success" target="_blank">Descargar</a>
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
                                                <th></th>
                                                <th>Codigo</th>
                                                <th>Fecha</th>
                                                <th>Cliente</th>
                                                <th>Equipo</th>
                                                <th>$ </th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $tot_entrada = $tot_salida =0; foreach($data["posts"] as $post):
                                       ?>
                                            <tr>
                                                <td><a href="./?view=mttos&opt=open&id=<?=$post->id;?>" class="btn btn-sm btn-info"><i class="bi-folder"></i></a></td>
                                                <td><?=$post->code ;?></td>
                                                <td><?=$post->date_at ;?></td>
                                                <td><?php if($post->client_id){ $cli= ClientData::getById($post->client_id) ; echo $cli->name." ".$cli->lastname ;} ?></td>
                                                <td><?php if($post->item_id){ $clit= ItemData::getById($post->item_id) ; echo $clit->name." - ".$clit->serie ;} ?> </td>
                                                <td>$ <?=$post->amount ;?></td>
                                                <td style="width:170px;">
                                                    
                                               <!-- <a href="./?view=mttos&opt=edit&id=<?=$post->id;?>" class="btn btn-sm btn-warning"><i class="bi-pencil"></i></a>-->
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
    window.location = "./?action=mttos&opt=del&id=<?=$post->id;?>";
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
                    <div class="col-lg-8">


<!-- Inicio de card -->
 <div class="card">
                  <div class="card-header">
                    <strong>Nueva Instalacion</strong>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-12">

                        <form role="form" method="post" action="./?action=mttos&opt=add" enctype="multipart/form-data">
                            <!--
                            <div class="form-group">
                                <label>Imagen (480x480)</label>
                                <input type="file" name="image">
                            </div>
                        -->
                            <div class="form-group">
                                <label>Codigo</label>
                                <input type="text" name="code" class="form-control" placeholder="Codigo">
                            </div>
                            <div class="form-group">
                                <label>Fecha</label>
                                <input type="date" name="date_at" class="form-control" placeholder="Fecha">
                            </div>

    <div class="form-group">
                                <label><b>Cliente</b></label>
      
      <select name="client_id" id="client_id"  class="form-control" required>
        <option value="">-- SELECCIONE --</option>
        <?php foreach(ClientData::getAll() as $k):?>
          <option value="<?php echo $k->id; ?>"><?php echo $k->name; ?> - <?php echo $k->lastname; ?></option>
        <?php endforeach; ?>
      </select>
                            </div>                            
    <div class="form-group">
                                <label><b>Unidad Interna</b></label>
      
      <select name="item_extern_id" id="item_intern_id"  class="form-control" required>
        <option value="">-- SELECCIONE --</option>
        <?php foreach(ItemData::getAllIntern() as $k):?>
          <option value="<?php echo $k->id; ?>"><?php echo $k->serie; ?> - <?php echo $k->name; ?></option>
        <?php endforeach; ?>
      </select>
                            </div>

    <div class="form-group">
                                <label><b>Unidad Externa</b></label>
      
      <select name="item_intern_id" id="item_extern_id"  class="form-control" required>
        <option value="">-- SELECCIONE --</option>
        <?php foreach(ItemData::getAllExtern() as $k):?>
          <option value="<?php echo $k->id; ?>"><?php echo $k->serie; ?> - <?php echo $k->name; ?></option>
        <?php endforeach; ?>
      </select>
                            </div>
                            <div class="form-group">
                                <label>Descripcion</label>
                                <input type="text" name="description" class="form-control" placeholder="Descripcion">
                            </div>
                            <div class="form-group">
                                <label>Costo del Servicio</label>
                                <input type="text" name="amount" required required class="form-control" placeholder="Costo del Servicio">
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


<section class="container">
<?php
$user = InstalationData::getById($_GET["id"]);
?>


                <div class="row">
                    <div class="col-lg-12">
 <div class="card">
                  <div class="card-header">
                    <strong>Modificar Producto</strong>
                  </div>
                  <div class="card-body">
                        <form role="form" method="post" action="./?action=mttos&opt=update" enctype="multipart/form-data">
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
                                <label>Categoria de Producto</label>

      <select name="category_id" id="category_id"   class="form-control" >
        <option value="">-- SELECCIONE --</option>
        <?php foreach(CategoryData::getAll() as $k):?>
          <option value="<?php echo $k->id; ?>" <?php if($k->id==$user->category_id){ echo "selected"; }?>><?php echo $k->name; ?></option>
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

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="open"):?>


<section class="">
<?php
$user = InstalationData::getById($_GET["id"]);
?>


                <div class="row">
                    <div class="col-lg-6">
 <div class="card">
                  <div class="card-header">
                    <strong>Datos de la instalacion</strong>
                  </div>
                  <div class="card-body">
                    <p>Fecha de la instalacion: <?php echo $user->date_at; ?></p>
                    <p>Codigo: <?php echo $user->code; ?></p>

                    <p>Cliente: <?php if($user->client_id){ $cli= ClientData::getById($user->client_id) ; echo $cli->name." ".$cli->lastname ;} ?></p>
  <p>Unidad Externa: <?php if($user->item_extern_id){ $clit= ItemData::getById($user->item_extern_id) ; echo $clit->name." - ".$clit->serie ;} ?></p>
  <p> Unidad Interna: <?php if($user->item_intern_id){ $clit= ItemData::getById($user->item_intern_id) ; echo $clit->name." - ".$clit->serie ;} ?></p>

                    <p>Descripcion: <?php echo $user->description; ?></p>

                    <p>Monto del servicio: <?php echo $user->amount; ?></p>




                    </div>
                    <br><br><br><br><br><br><br><br>
                </div>

                    </div>

                </div>
                <!-- /.row -->
<br><br><br><br><br>
</section>
<?php endif; ?>