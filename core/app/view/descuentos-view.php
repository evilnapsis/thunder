<?php 
if(isset($_GET["opt"]) && $_GET['opt']=="all"):
?>



<section class="container-fluid">
<?php
$data["posts"]=DescuentoData::getAll();
?>


 <div class="card">
                  <div class="card-header">
                    <strong>Descuentos</strong>
                  </div>
                  <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                    <a href="./?view=descuentos&opt=new" class="btn btn-secondary">Nuevo Descuento</a><br><br>
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
                                                <th>Valor</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($data["posts"] as $post):?>
                                            <tr>
                                                <td><?=$post->name ;?></td>
                                                <td style="width:170px;">
                                                    
                                                <a href="./?view=descuentos&opt=edit&id=<?=$post->id;?>" class="btn btn-sm btn-warning"><i class="bi-pencil"></i></a>
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
    window.location = "./?action=descuentos&opt=del&id=<?=$post->id;?>";
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
        <ol class="breadcrumb">
          <li class="breadcrumb-item">Descuentos</li>
          <li class="breadcrumb-item">Nuevo *</li>

        </ol>

<section class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">


<!-- Inicio de card -->
 <div class="card">
                  <div class="card-header">
                    <strong>Nuevo Descuento</strong>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-12">

                        <form role="form" method="post" action="./?action=descuentos&opt=add" enctype="multipart/form-data">
                            <!--
                            <div class="form-group">
                                <label>Imagen (480x480)</label>
                                <input type="file" name="image">
                            </div>
                        -->
                            <div class="form-group">
                                <label>Valor</label>
                                <input type="number" required name="name" class="form-control" placeholder="Valor">
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
        <ol class="breadcrumb">
          <li class="breadcrumb-item">Descuentos</li>
          <li class="breadcrumb-item">Modificar *</li>

        </ol>
<section class="container-fluid">
<?php
$user = DescuentoData::getById($_GET["id"]);
?>


                <div class="row">
                    <div class="col-lg-12">
 <div class="card">
                  <div class="card-header">
                    <strong>Modificar Descuento</strong>
                  </div>
                  <div class="card-body">
                        <form role="form" method="post" action="./?action=descuentos&opt=update" enctype="multipart/form-data">

                            <div class="form-group">
                                <label>Valor</label>
                                <input type="number" required name="name" value="<?=$user->name;?>" class="form-control" placeholder="Valor">
                            </div>



                            <input type="hidden" name="id" value="<?=$user->id;?>">
                            <br>
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