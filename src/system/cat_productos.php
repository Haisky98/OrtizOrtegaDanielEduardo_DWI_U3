<!--begin::Toolbar-->
<div class="toolbar mb-5 mb-lg-7" id="kt_toolbar">
    <div class="page-title d-flex flex-column me-3">
        <h1 class="d-flex text-gray-900 fw-bolder fs-3 align-items-center my-1">Catálogo / Gestión de Productos</h1>
        <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
            <li class="breadcrumb-item text-muted">Dashboard</li>
            <li class="breadcrumb-item text-muted">Productos</li>
        </ul>
    </div>
    <!-- Botón superior para agregar producto que abre el modal -->
    <div class="d-flex align-items-center gap-2 gap-lg-3">
        <button type="button" class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#kt_modal_agregar_producto">
            <i class="ki-duotone ki-plus fs-2"></i> Agregar producto
        </button>
    </div>
</div>
<!--end::Toolbar-->

<!--begin::Card-->
<div class="card card-flush">
    <div class="card-header pt-7">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-gray-800">Listado de Productos</span>
            <span class="text-gray-400 mt-1 fw-semibold fs-6">Administra los productos del sistema</span>
        </h3>
    </div>
    <div class="card-body pt-0">
        <!--begin::Table-->
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_productos">
            <thead>
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th class="min-w-100px">Acciones</th> <!-- Primera columna: Acciones -->
                    <th class="min-w-50px">Imagen</th>
                    <th class="min-w-150px">Nombre</th>
                    <th class="min-w-100px">Categoría</th>
                    <th class="min-w-100px">Precio</th>
                    <th class="min-w-70px">Stock</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 fw-semibold">
                <?php if (!empty($lista_productos)): ?>
                    <?php foreach ($lista_productos as $prod): ?>
                        <tr>
                            <!-- Columna 1: Acciones (Editar / Eliminar) -->
                            <td>
                                <button type="button" class="btn btn-icon btn-light-primary btn-sm me-1" title="Editar" 
                                        onclick="prepararEdicion(<?= htmlspecialchars(json_encode($prod)) ?>)">
                                    <i class="ki-duotone ki-pencil fs-4"><span class="path1"></span><span class="path2"></span></i>
                                </button>
                                <form action="actions/delete_producto.php" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                                    <input type="hidden" name="id_producto" value="<?= $prod['id_producto'] ?>">
                                    <button type="submit" class="btn btn-icon btn-light-danger btn-sm" title="Eliminar">
                                        <i class="ki-duotone ki-trash fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                    </button>
                                </form>
                            </td>
                            <!-- Imagen -->
                            <td>
                                <img src="<?= !empty($prod['imagen']) ? htmlspecialchars($prod['imagen']) : 'assets/media/products/default.png' ?>" 
                                     alt="" class="w-50px h-50px rounded object-fit-cover shadow-sm" />
                            </td>
                            <!-- Nombre -->
                            <td class="fw-bold text-gray-800"><?= htmlspecialchars($prod['nombre']) ?></td>
                            <!-- Categoría -->
                            <td>
                                <span class="badge badge-light-primary"><?= htmlspecialchars($prod['categoria'] ?? 'Sin Categoría') ?></span>
                            </td>
                            <!-- Precio -->
                            <td class="text-success fw-bold">$<?= number_format($prod['precio'], 2) ?> MXN</td>
                            <!-- Stock -->
                            <td>
                                <span class="badge <?= $prod['stock'] > 0 ? 'badge-light-success' : 'badge-light-danger' ?>">
                                    <?= $prod['stock'] ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">No hay productos registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <!--end::Table-->
    </div>
</div>
<!--end::Card-->

<!--begin::Modal - Agregar Producto-->
<div class="modal fade" id="kt_modal_agregar_producto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <form class="form" action="actions/insert_producto.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h2 class="fw-bold">Agregar Nuevo Producto</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body py-10 px-lg-17">
                    <!-- Nombre -->
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Nombre del Producto</label>
                        <input type="text" class="form-control form-control-solid" placeholder="Ej. Teclado Mecánico" name="nombre" required />
                    </div>
                    <!-- Descripción -->
                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-semibold mb-2">Descripción</label>
                        <textarea class="form-control form-control-solid" rows="3" name="descripcion" placeholder="Especificaciones técnicas..."></textarea>
                    </div>
                    <!-- Precio y Stock -->
                    <div class="row g-9 mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Precio ($ MXN)</label>
                            <input type="number" step="0.01" class="form-control form-control-solid" placeholder="0.00" name="precio" required />
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Stock</label>
                            <input type="number" class="form-control form-control-solid" placeholder="0" name="stock" required />
                        </div>
                    </div>
                    <!-- Categoría -->
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Categoría</label>
                        <select name="id_categoria" class="form-select form-select-solid" required>
                            <option value="">Seleccione una categoría...</option>
                            <?php foreach ($lista_categorias as $cat): ?>
                                <option value="<?= $cat['id_categoria'] ?>"><?= htmlspecialchars($cat['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- Imagen -->
                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-semibold mb-2">Fotografía del Producto</label>
                        <input type="file" class="form-control form-control-solid" name="imagen" accept="image/*" />
                    </div>
                </div>
                <div class="modal-footer flex-center">
                    <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Producto</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal-->