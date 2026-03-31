<div class="row g-4 mb-4">
    <!-- Active Tables Widget -->
    <div class="col-sm-6 col-xl-3">
        <div class="card text-white bg-primary shadow-sm h-100">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <div class="fs-4 fw-semibold"><?php echo count(SellData::getAllUnApplied()); ?></div>
                    <div>Mesas Activas</div>
                </div>
                <div class="fs-1 opacity-25">
                    <i class="bi bi-grid-3x3-gap"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 text-end">
                <a href="index.php?view=sell&opt=all" class="btn btn-sm btn-light text-primary fw-bold">Ver Ventas</a>
            </div>
        </div>
    </div>

    <!-- Products Widget -->
    <div class="col-sm-6 col-xl-3">
        <div class="card text-white bg-success shadow-sm h-100">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <div class="fs-4 fw-semibold"><?php echo count(ProductData::getAllActive()); ?></div>
                    <div>Productos Activos</div>
                </div>
                <div class="fs-1 opacity-25">
                    <i class="bi bi-box-seam"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 text-end">
                <a href="index.php?view=products&opt=all" class="btn btn-sm btn-light text-success fw-bold">Gestionar</a>
            </div>
        </div>
    </div>

    <!-- Ingredients Widget -->
    <div class="col-sm-6 col-xl-3">
        <div class="card text-white bg-info shadow-sm h-100">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <div class="fs-4 fw-semibold"><?php echo count(IngredientData::getAllActive()); ?></div>
                    <div>Ingredientes</div>
                </div>
                <div class="fs-1 opacity-25">
                    <i class="bi bi-egg-fried"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 text-end">
                <a href="index.php?view=ingredients&opt=all" class="btn btn-sm btn-light text-info fw-bold">Inventario</a>
            </div>
        </div>
    </div>

    <!-- Categories Widget -->
    <div class="col-sm-6 col-xl-3">
        <div class="card text-white bg-warning shadow-sm h-100">
            <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <div class="fs-4 fw-semibold"><?php echo count(CategoryData::getAll()); ?></div>
                    <div>Categorías</div>
                </div>
                <div class="fs-1 opacity-25 text-dark">
                    <i class="bi bi-tags"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 text-end">
                <a href="index.php?view=categories&opt=all" class="btn btn-sm btn-light text-warning fw-bold">Organizar</a>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-dark fw-bold"><i class="bi bi-graph-up-arrow me-2 text-primary"></i> Ventas de los últimos 30 días</h5>
                <span class="badge bg-light text-dark border">Histórico Mensual</span>
            </div>
            <div class="card-body">
                <div style="height: 300px;">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$labels = [];
$data = [];
for($i=29;$i>=0;$i--){
    $date = date("Y-m-d", strtotime("-$i days"));
    $labels[] = date("d M", strtotime($date));
    $data[] = SellData::getTotalByDate($date);
}
?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Ventas ($)',
                data: <?php echo json_encode($data); ?>,
                backgroundColor: 'rgba(46, 204, 113, 0.1)',
                borderColor: 'rgba(46, 204, 113, 1)',
                borderWidth: 3,
                pointBackgroundColor: 'rgba(46, 204, 113, 1)',
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)' },
                    ticks: {
                        callback: function(value) { return '$' + value; }
                    }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
});
</script>

<div class="row g-4">
    <!-- Monitor de Mesas -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3 d-flex align-items-center">
                <h5 class="mb-0 text-primary fw-bold"><i class="bi bi-grid-3x3-gap me-2"></i> Estado de Mesas</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Número de Mesa</th>
                                <th>Ventas Pendientes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach(ItemData::getAll() as $item): ?>
                            <tr>
                                <td><span class="fw-bold">Mesa <?php echo $item->name; ?></span></td>
                                <td>
                                    <?php $sells = SellData::getAllUnAppliedByItemId($item->id); ?>
                                    <?php if(count($sells)>0): ?>
                                        <div class="d-flex flex-wrap gap-1">
                                            <?php foreach($sells as $s): ?>
                                                <a href="index.php?view=sell&opt=onesell&id=<?php echo $s->id;?>" class="btn btn-sm btn-outline-primary shadow-sm">
                                                    <i class="bi bi-receipt me-1"></i> ID: <?php echo $s->id; ?>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="badge bg-light text-dark border"><i class="bi bi-check2-all me-1 text-success"></i> Disponible</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Rendimiento de Meseros -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-success fw-bold"><i class="bi bi-person-badge me-2"></i> Ventas de Meseros (Hoy)</h5>
            </div>
            <div class="card-body">
                <?php $meseros = UserData::getAllMeseros(); ?>
                <?php if(count($meseros)>0): ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach($meseros as $mesero): 
                            $sells_m = SellData::getAllDayliByMesero($mesero->id);
                            $total_m = 0;
                            if(count($sells_m)>0){ foreach($sells_m as $sell_m){ $total_m += $sell_m->total;} }
                        ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-0 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="avatar bg-light border p-2 rounded-circle me-3">
                                    <i class="bi bi-person text-secondary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold"><?php echo $mesero->name." ".$mesero->lastname; ?></h6>
                                    <small class="text-muted">Mesero</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-success fs-5">$ <?php echo number_format($total_m,2); ?></div>
                                <a href="index.php?view=reportbymesero&mesero_id=<?php echo $mesero->id; ?>" class="btn btn-link btn-sm text-decoration-none p-0">Ver historial</a>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <div class="alert alert-warning">No hay meseros registrados.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
