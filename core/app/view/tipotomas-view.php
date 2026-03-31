<?php 
if(isset($_GET["opt"]) && $_GET['opt']=="all"):
?>




<section class="">
<?php
$data["posts"]=TipoTomaData::getAll();
?>


 <div class="card">
                  <div class="card-header">
                    <strong>Tipos de Tomas</strong>
                  </div>
                  <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                    <a href="./?view=tipotomas&opt=new" class="btn btn-secondary">Nuevo Tipo de Tomas</a><br><br>
                        <div class="box box-primary">
                            <div class="box-body">
                                    <table class="table datatable table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($data["posts"] as $post):?>
                                            <tr>
                                                <td><?=$post->name ;?></td>
                                                <td style="width:170px;">
                                                    
                                                <a href="./?view=tipotomas&opt=edit&id=<?=$post->id;?>" class="btn btn-sm btn-warning"><i class="bi-pencil"></i></a>
                                            
                                                <a id="delitem-<?=$post->id;?>" class="btn btn-sm btn-danger"><i class="bi-trash"></i></a>
<script type="text/javascript">
<?php if(isset($_SESSION["deleted_item"])):?>
    Swal.fire("Eliminado!", "", "success");
    <?php unset($_SESSION['deleted_item']); endif;?>

    $("#delitem-<?php echo $post->id?>").click(function(){
Swal.fire({
  title: "Estas seguro que deseas Eliminar ?",
  showCancelButton: true,
  showDenyButton: true,

  confirmButtonText: "Eliminar",
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.isConfirmed) {
    window.location = "./?action=tipotomas&opt=del&id=<?=$post->id;?>";
  } else if(result.isDenied){
    Swal.fire("Operacion cancelada!", "", "info");
  }
});

    });
</script>
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
                    <strong>Nuevo Tipo de Tomas</strong>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-12">

                        <form role="form" method="post" action="./?action=tipotomas&opt=add" enctype="multipart/form-data">
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
$user = TipoTomaData::getById($_GET["id"]);
?>


                <div class="row">
                    <div class="col-lg-12">
 <div class="card">
                  <div class="card-header">
                    <strong>Modificar Tipo de Tomas</strong>
                  </div>
                  <div class="card-body">
                        <form role="form" method="post" action="./?action=tipotomas&opt=update" enctype="multipart/form-data">

                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="name" value="<?=$user->name;?>" class="form-control" placeholder="Nombre">
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