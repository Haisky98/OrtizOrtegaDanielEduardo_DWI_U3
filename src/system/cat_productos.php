<?php
require_once __DIR__ . '/../actions/get_productos.php';
require_once __DIR__ . '/../class/03.class_cat_categorias.php';

$catObj = new class_cat_categorias();
$resCat = $catObj->obtener_categorias();
$lista_categorias = ($resCat['bool'] && !empty($resCat['data'])) ? $resCat['data'] : [];
?>

<!--begin::Toolbar-->
<div class="toolbar mb-5 mb-lg-7" id="kt_toolbar">
    <div class="page-title d-flex flex-column me-3">
        <h1 class="d-flex text-gray-900 fw-bolder fs-3 align-items-center my-1">Catálogo / Gestión de Productos</h1>
        <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
            <li class="breadcrumb-item text-muted">Dashboard</li>
            <li class="breadcrumb-item text-muted">Productos</li>
        </ul>
    </div>
    <div class="d-flex align-items-center gap-2 gap-lg-3">
        <button type="button" class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#kt_modal_producto" id="btn_nuevo_producto">
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
            <span class="text-gray-400 mt-1 fw-semibold fs-6">Administra los productos de forma asíncrona</span>
        </h3>
    </div>
    <div class="card-body pt-0">
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_productos">
            <thead>
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th class="min-w-100px">Acciones</th>
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
                            <td>
                                <button type="button" class="btn btn-icon btn-light-primary btn-sm me-1 btn-editar" 
                                        data-prod='<?= htmlspecialchars(json_encode($prod), ENT_QUOTES, 'UTF-8') ?>' title="Editar">
                                    <i class="ki-duotone ki-pencil fs-4"><span class="path1"></span><span class="path2"></span></i>
                                </button>
                                <button type="button" class="btn btn-icon btn-light-danger btn-sm btn-eliminar" 
                                        data-id="<?= $prod['id_producto'] ?>" title="Eliminar">
                                    <i class="ki-duotone ki-trash fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                </button>
                            </td>
                            <td>
                                <img src="<?= !empty($prod['imagen']) ? htmlspecialchars($prod['imagen']) : 'assets/media/products/default.png' ?>" 
                                     alt="" class="w-50px h-50px rounded object-fit-cover shadow-sm" />
                            </td>
                            <td class="fw-bold text-gray-800"><?= htmlspecialchars($prod['nombre']) ?></td>
                            <td>
                                <span class="badge badge-light-primary"><?= htmlspecialchars($prod['categoria'] ?? 'Sin Categoría') ?></span>
                            </td>
                            <td class="text-success fw-bold">$<?= number_format($prod['precio'], 2) ?> MXN</td>
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
    </div>
</div>
<!--end::Card-->

<!--begin::Modal - Registrar / Editar Producto-->
<div class="modal fade" id="kt_modal_producto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <!-- Formulario único para Insertar / Actualizar por AJAX -->
            <form id="form_producto" enctype="multipart/form-data">
                <input type="hidden" name="id_producto" id="modal_id_producto" value="">
                <input type="hidden" name="imagen_actual" id="modal_imagen_actual" value="">
                
                <div class="modal-header">
                    <h2 class="fw-bold" id="modal_titulo">Agregar Nuevo Producto</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body py-10 px-lg-17">
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Nombre del Producto</label>
                        <input type="text" class="form-control form-control-solid" name="nombre" id="modal_nombre" required />
                    </div>
                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-semibold mb-2">Descripción</label>
                        <textarea class="form-control form-control-solid" rows="3" name="descripcion" id="modal_descripcion"></textarea>
                    </div>
                    <div class="row g-9 mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Precio ($ MXN)</label>
                            <input type="number" step="0.01" class="form-control form-control-solid" name="precio" id="modal_precio" required />
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="required fs-6 fw-semibold mb-2">Stock</label>
                            <input type="number" class="form-control form-control-solid" name="stock" id="modal_stock" required />
                        </div>
                    </div>
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">Categoría</label>
                        <select name="id_categoria" id="modal_id_categoria" class="form-select form-select-solid" required>
                            <option value="">Seleccione una categoría...</option>
                            <?php foreach ($lista_categorias as $cat): ?>
                                <option value="<?= $cat['id_categoria'] ?>"><?= htmlspecialchars($cat['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-semibold mb-2">Fotografía del Producto</label>
                        <input type="file" class="form-control form-control-solid" name="imagen" accept="image/*" />
                    </div>
                </div>
                <div class="modal-footer flex-center">
                    <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btn_guardar_modal">Guardar Producto</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal-->

<!--begin::JavaScript de control AJAX (Frontend SPA)-->
<script>
$(document).ready(function() {
    
    // 1. Limpiar modal al hacer clic en "Agregar producto"
    $('#btn_nuevo_producto').on('click', function() {
        $('#form_producto')[0].reset();
        $('#modal_id_producto').val('');
        $('#modal_imagen_actual').val('');
        $('#modal_titulo').text('Agregar Nuevo Producto');
        $('#btn_guardar_modal').text('Guardar Producto');
    });

    // 2. Cargar datos en el modal al hacer clic en Editar
    $('.btn_editar').on('click', function() {
        const prod = $(this).data('prod');
        
        $('#modal_id_producto').val(prod.id_producto);
        $('#modal_nombre').val(prod.nombre);
        $('#modal_descripcion').val(prod.descripcion);
        $('#modal_precio').val(prod.precio);
        $('#modal_stock').val(prod.stock);
        $('#modal_id_categoria').val(prod.id_categoria);
        $('#modal_imagen_actual').val(prod.imagen);
        
        $('#modal_titulo').text('Editar Producto: ' + prod.nombre);
        $('#btn_guardar_modal').text('Actualizar Producto');
        
        // Mostrar modal mediante Bootstrap
        $('#kt_modal_producto').modal('show');
    });

    // 3. Enviar formulario por AJAX (Inserta o Actualiza dinámicamente)
    $('#form_producto').on('submit', function(e) {
        e.preventDefault();
        
        const idProd = $('#modal_id_producto').val();
        // Dependiendo si hay ID, apuntamos al action de update o insert
        const actionUrl = idProd ? 'actions/update_producto.php' : 'actions/insert_producto.php';
        
        const formData = new FormData(this);

        $.ajax({
            url: actionUrl,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                // Cerrar modal
                $('#kt_modal_producto').modal('hide');
                
                // Recargar dinámicamente la vista en el contenedor #principal usando tu lógica de menu.js
                // O recargar el contenido de productos via AJAX
                $('#principal').load('system/cat_productos.php', function() {
                    // Notificación o feedback visual opcional
                });
            },
            error: function() {
                alert('Ocurrió un error al procesar la solicitud.');
            }
        });
    });

    // 4. Eliminar producto por AJAX
    $('.btn_eliminar').on('click', function() {
        if (!confirm('¿Estás seguro de eliminar este producto?')) return;

        const id_producto = $(this).data('id');

        $.ajax({
            url: 'actions/delete_producto.php',
            type: 'POST',
            data: { id_producto: id_producto },
            success: function(response) {
                // Refrescar contenedor #principal
                $('#principal').load('system/cat_productos.php');
            },
            error: function() {
                alert('Error al intentar eliminar el producto.');
            }
        });
    });

});
</script>