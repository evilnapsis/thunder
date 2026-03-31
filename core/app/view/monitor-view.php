<?php if(Core::$user->is_admin):?>
<section class="content">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white d-flex align-items-center justify-content-between py-3">
            <h5 class="mb-0"><i class="bi bi-display me-2"></i> Monitor en Tiempo Real</h5>
            <span class="badge bg-light text-dark"><i class="bi bi-broadcast text-danger me-1"></i> En Vivo</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 15rem;">Identificador (Mesa)</th>
                            <th>Estado y Detalle de Orden</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach(ItemData::getAll() as $career):?>
                        <tr>
                            <td class="bg-light bg-opacity-50">
                                <div class="d-flex align-items-center px-2">
                                    <div class="avatar bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 45px; height: 45px;">
                                        <span class="fw-bold"><?php echo substr($career->name, 0, 3); ?></span>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold"><?php echo $career->name; ?></h6>
                                        <small class="text-muted">ID: #<?php echo $career->id; ?></small>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <?php $sells = SellData::getAllUnAppliedByItemId($career->id); ?>
                                <?php if(count($sells)>0):?>
                                    <?php foreach($sells as $s):
                                        $operations = OperationData::getAllProductsBySellId($s->id);
                                        $mesero = UserData::getById($s->mesero_id);
                                    ?>
                                        <?php if(count($operations)>0):?>
                                            <div class="card border mb-3 shadow-sm overflow-hidden">
                                                <div class="card-header bg-light d-flex justify-content-between align-items-center py-2 px-3 border-bottom-0">
                                                    <div class="d-flex align-items-center">
                                                        <span class="badge bg-warning text-dark me-3"><i class="bi bi-receipt me-1"></i> Venta #<?php echo $s->id; ?></span>
                                                        <span class="text-muted small"><i class="bi bi-person-badge me-1"></i> Mesero: <strong><?php echo $mesero->name." ".$mesero->lastname;?></strong></span>
                                                    </div>
                                                    <a href="./?view=sell&opt=onesell&id=<?php echo $s->id;?>" class="btn btn-sm btn-outline-primary fw-bold rounded-pill">
                                                        <i class="bi bi-eye"></i> Detalle
                                                    </a>
                                                </div>
                                                <div class="card-body p-0">
                                                    <table class="table table-sm table-striped mb-0 small">
                                                        <thead class="table-light opacity-75">
                                                            <tr>
                                                                <th class="ps-3">Producto</th>
                                                                <th class="text-center">Cant.</th>
                                                                <th class="text-center">T. Stimado</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                            $np=0;$nd=0;
                                                            foreach($operations as $operation):
                                                            $product = ProductData::getById($operation->product_id); ?>
                                                                <tr>
                                                                    <td class="ps-3"><?php echo $product->name;?></td>
                                                                    <td class="text-center fw-bold"><?php echo $operation->q;?></td>
                                                                    <td class="text-center text-muted"><?php echo ($product->duration * $operation->q);?> <small>min</small></td>
                                                                </tr>
                                                            <?php
                                                            $np += $operation->q;
                                                            $nd += ($product->duration * $operation->q);
                                                            endforeach; ?>
                                                        </tbody>
                                                        <tfoot class="table-light fw-bold border-top">
                                                            <tr>
                                                                <td class="text-end ps-3">Total Estimado</td>
                                                                <td class="text-center"><?php echo $np;?></td>
                                                                <td class="text-center text-primary"><?php echo $nd;?> <small>min</small></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="bg-light p-3 rounded-3 border-dashed border text-center">
                                        <i class="bi bi-check2-circle text-success fs-5 me-2"></i>
                                        <span class="text-muted small fw-semibold">Sin tareas pendientes en esta mesa</span>
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
