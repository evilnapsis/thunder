<?php 
if(isset($_GET["opt"]) && $_GET['opt']=="all"):
?>




<section class="">
<?php
$data["posts"]=LogData::getAll();
?>


 <div class="card">
                  <div class="card-header">
                    <strong>Bitacora de inicios de sesi&oacute;n</strong>
                  </div>
                  <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary">
                            <div class="box-body">
                                    <table class="table datatable table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>Descripcion</th>
                                                <th>Usuario</th>
                                                <th>Tipo Usuario</th>
                                                <th>Fecha</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($data["posts"] as $post):
                                            $u = UserData::getById($post->user_id);
                                            $k = KindData::getById($u->kind);
                                            ?>
                                            <tr>
                                                <td><?=$post->description ;?></td>
                                                <td><?=$u->name." ".$u->lastname ;?></td>
                                                <td><?=$k->name ;?></td>
                                                <td><?=$post->created_at ;?></td>
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
                <?php endif; ?>