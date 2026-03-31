<?php 
if(isset($_GET["opt"]) && $_GET['opt']=="all"):
?>



<section class="container-fluid">
<?php
if(Core::$user->kind==1){
    $data["posts"]=InvoiceData::getAll();
}
else if(Core::$user->kind==2){
    $data["posts"]=InvoiceData::getAll();
}
else if(Core::$user->kind==3){
    $data["posts"]=InvoiceData::getAllBy("status_id",2);
}
?>


 <div class="card">
                  <div class="card-header">
                    <strong>Ordenes</strong>
                  </div>
                  <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <?php if(Core::$user->kind==1 || Core::$user->kind==2):?>
                    <a href="./?view=invoices&opt=new" class="btn btn-secondary">Nueva Orden</a><br><br>
                    <?php endif; ?>
                        <div class="box box-primary">
                            <div class="box-body">
<script type="text/javascript">
<?php if(isset($_SESSION["deleted_item"])):?>
    Swal.fire("Eliminado!", "", "success");
    <?php unset($_SESSION['deleted_item']); 
endif;?>
<?php if(isset($_SESSION["aprove_item"])):?>
    Swal.fire("Aprobado!", "", "success");
    <?php unset($_SESSION['aprove_item']); 
endif;?></script>
                                    <table class="table datatable table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>P.O</th>
                                                <th>Factura</th>
                                                <th>Descripcion</th>
                                                <th>Monto</th>
                                                <th>Inversion</th>
                                                <th>Status</th>
                                                <th>Plazo</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($data["posts"] as $post):?>
                                            <tr>
                                                <td><?=$post->code ;?></td>
                                                <td><?=$post->invoice ;?></td>
                                                <td><?=$post->description ;?></td>
                                                <td>$ <?=$post->amount ;?></td>
                                                <td>$ 0</td>
                                                <td><?php if($post->status_id==1):?>
                                                    <span class="badge text-bg-warning">Pendiente</span>
                                                    <?php elseif($post->status_id==2):?>
                                                        <span class="badge text-bg-primary">Aprobado</span>
                                                        <?php elseif($post->status_id==3):?>
                                                        <span class="badge text-bg-success">Finalizado</span>

                                                <?php endif; ?>
                                                </td>
                                                <td><?=$post->time_limit ;?></td>
                                                <td style="width:170px;">
<?php if(Core::$user->kind==3):?>
    <a href="./?view=invoices&opt=invest&id=<?=$post->id;?>" class="btn btn-sm btn-info"><i class="bi-info"></i> Invertir</a>

    <?php endif; ?>
    <?php if(Core::$user->kind==1):?>
                                                <?php if($post->status_id==1):?>
                                                    <a id="approveitem-<?=$post->id;?>" class="btn btn-sm btn-primary"><i class="bi-check"></i> Aprobar</a>
<script type="text/javascript">
    $("#approveitem-<?php echo $post->id?>").click(function(){
Swal.fire({
  title: "Estas seguro que deseas Aprobar esta Orden ?",
  showCancelButton: true,
  showDenyButton: true,

  confirmButtonText: "Aprobar!",
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.isConfirmed) {
    window.location = "./?action=invoices&opt=approve&id=<?=$post->id;?>";
  } else if(result.isDenied){
    Swal.fire("Accion cancelada!", "", "info");
  }
});

    });
</script>
                                                    <?php elseif($post->status_id==2):?>
                                                        <a id="approveitem-<?=$post->id;?>" class="btn btn-sm btn-success"><i class="bi-check"></i> Finalizar</a>
<script type="text/javascript">
    $("#approveitem-<?php echo $post->id?>").click(function(){
Swal.fire({
  title: "Estas seguro que deseas Finalizar esta Orden ?",
  showCancelButton: true,
  showDenyButton: true,

  confirmButtonText: "Finalizar!",
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.isConfirmed) {
    window.location = "./?action=invoices&opt=finelize&id=<?=$post->id;?>";
  } else if(result.isDenied){
    Swal.fire("Accion cancelada!", "", "info");
  }
});

    });
</script>

                                                <?php endif; ?>
<?php endif; ?>
 <?php if(Core::$user->kind==1 || Core::$user->kind==2 ):?>                                         
    <a href="./?view=invoices&opt=edit&id=<?=$post->id;?>" class="btn btn-sm btn-warning"><i class="bi-pencil"></i></a>
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
    window.location = "./?action=invoices&opt=del&id=<?=$post->id;?>";
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
          <li class="breadcrumb-item">Ordenes</li>
          <li class="breadcrumb-item">Nuevo *</li>

        </ol>

<section class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">


<!-- Inicio de card -->
 <div class="card">
                  <div class="card-header">
                    <strong>Nueva Orden</strong>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-12">

                        <form role="form" method="post" action="./?action=invoices&opt=add" enctype="multipart/form-data">
                            <!--
                            <div class="form-group">
                                <label>Imagen (480x480)</label>
                                <input type="file" name="image">
                            </div>
                        -->
                            <div class="form-group">
                                <label>Numero de Orden</label>
                                <input type="text" name="code" required class="form-control" placeholder="Numero de Orden">
                            </div>
                            <div class="form-group">
                                <label>Numero de Factura</label>
                                <input type="text" name="invoice" required class="form-control" placeholder="Numero de Factura">
                            </div>
                            <div class="form-group">
                                <label>Descripcion</label>
                                <input type="text" name="description" required class="form-control" placeholder="Descripcion">
                            </div>
                            <div class="form-group">
                                <label>Monto $</label>
                                <input type="text" name="amount" required class="form-control" placeholder="Monto $">
                            </div>
                            <div class="form-group">
                                <label>Plazo / Fecha Limite</label>
                                <input type="date" name="time_limit" required class="form-control" placeholder="Plazo / Fecha Limite">
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
          <li class="breadcrumb-item">Ordenes</li>
          <li class="breadcrumb-item">Modificar *</li>

        </ol>
<section class="container-fluid">
<?php
$user = InvoiceData::getById($_GET["id"]);
?>


                <div class="row">
                    <div class="col-lg-12">
 <div class="card">
                  <div class="card-header">
                    <strong>Modificar Marca</strong>
                  </div>
                  <div class="card-body">
                        <form role="form" method="post" action="./?action=invoices&opt=update" enctype="multipart/form-data">

                        <div class="form-group">
                                <label>Numero de Orden</label>
                                <input type="text" name="code" value="<?php echo $user->code; ?>" required class="form-control" placeholder="Numero de Orden">
                            </div>
                            <div class="form-group">
                                <label>Numero de Factura</label>
                                <input type="text" name="invoice" value="<?php echo $user->invoice; ?>" required class="form-control" placeholder="Numero de Factura">
                            </div>
                            <div class="form-group">
                                <label>Descripcion</label>
                                <input type="text" name="description" value="<?php echo $user->description; ?>" required class="form-control" placeholder="Descripcion">
                            </div>
                            <div class="form-group">
                                <label>Monto $</label>
                                <input type="text" name="amount" value="<?php echo $user->amount; ?>" required class="form-control" placeholder="Monto $">
                            </div>
                            <div class="form-group">
                                <label>Plazo / Fecha Limite</label>
                                <input type="date" name="time_limit"  value="<?php echo $user->time_limit; ?>" required class="form-control" placeholder="Plazo / Fecha Limite">
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

<?php elseif(isset($_GET["opt"]) && $_GET["opt"]=="invest"):?>
            <!-- Breadcrumb-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">Ordenes</li>
          <li class="breadcrumb-item">Nuevo *</li>

        </ol>

<section class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">

<p class="alert alert-info">Las solicitudes de inversion quedan pendientes de aprobacion por parte de los administradores.</p>
<!-- Inicio de card -->
 <div class="card">
                  <div class="card-header">
                    <strong>Nueva Inversion a la Orden #<?php echo $_GET["id"];?></strong>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-12">

                        <form role="form" method="post" action="./?action=invoices&opt=addinvest" enctype="multipart/form-data">
                            <input type="hidden" name="invoice_id" value="<?php echo $_GET["id"]?>">
                            <!--
                            <div class="form-group">
                                <label>Imagen (480x480)</label>
                                <input type="file" name="image">
                            </div>
                        -->
                            
                            <div class="form-group">
                                <label>Descripcion</label>
                                <input type="text" name="description" required class="form-control" placeholder="Descripcion">
                            </div>
                            <div class="form-group">
                                <label>Monto $</label>
                                <input type="text" name="amount" required class="form-control" placeholder="Monto $">
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
<?php endif; ?>