<?php
// Incluimos la lógica desde actions para obtener los datos
require_once __DIR__ . '/../actions/get_productos.php';
?>

<!--begin::Toolbar-->
<div class="toolbar mb-5 mb-lg-7" id="kt_toolbar">
    <div class="page-title d-flex flex-column me-3">
        <h1 class="d-flex text-gray-900 fw-bolder fs-3 align-items-center my-1">Catálogo de Productos</h1>
        <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
            <li class="breadcrumb-item text-muted">Dashboard</li>
            <li class="breadcrumb-item text-muted">Tienda</li>
        </ul>
    </div>
</div>
<!--end::Toolbar-->

<!--begin::Row de Cards Dinámicas-->
<div class="row g-5 g-xl-8">
    <?php if (!empty($lista_productos)): ?>
        <?php foreach ($lista_productos as $prod): ?>
            <div class="col-md-6 col-xl-4">
                <div class="card card-flush h-xl-100 d-flex flex-column justify-content-between">
                    <!--begin::Body-->
                    <div class="card-body text-center pt-9 pb-5">
                        
                        <!-- Imagen Grande Centrada -->
                        <div class="mb-7">
                            <img src="<?= !empty($prod['imagen']) ? htmlspecialchars($prod['imagen']) : 'assets/media/products/default.png' ?>" 
                                 alt="<?= htmlspecialchars($prod['nombre']) ?>" 
                                 class="rounded w-200px h-200px object-fit-cover shadow-sm mx-auto d-block" />
                        </div>

                        <!-- Nombre del Producto -->
                        <a href="#" class="text-gray-900 fw-bold fs-3 mb-3 text-hover-primary d-block">
                            <?= htmlspecialchars($prod['nombre']) ?>
                        </a>

                        <!-- Precio y Categoría -->
                        <div class="d-flex justify-content-center align-items-center flex-wrap gap-2 mb-4">
                            <span class="badge badge-success fs-5 fw-bold px-4 py-2">
                                $<?= number_format($prod['precio'], 2) ?> MXN
                            </span>
                            <span class="badge badge-light-primary fs-7 px-3 py-2">
                                <?= htmlspecialchars($prod['categoria']) ?>
                            </span>
                        </div>

                        <!-- Stock -->
                        <div class="text-gray-600 fs-6">
                            Stock disponible: <strong class="text-gray-900"><?= $prod['stock'] ?></strong>
                        </div>

                    </div>
                    <!--end::Body-->
                    
                    <!-- Footer con Botón Ver Detalles -->
                    <div class="card-footer border-0 pt-0 pb-7 px-9 text-center">
                        <button class="btn btn-sm btn-light-primary w-100 py-3">Ver Detalles</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="alert alert-warning text-center">
                No hay productos disponibles en este momento.
            </div>
        </div>
    <?php endif; ?>
</div>
<!--end::Row-->