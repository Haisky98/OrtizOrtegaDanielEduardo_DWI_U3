<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); $es_admin_productos = in_array((int)($_SESSION['id_rol'] ?? 0), [1, 2], true); ?>
<div id="kt_content_container" class="container-xxl py-5">
    <div id="alerta-contenedor"></div>
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-7">
        <div><h1 class="fw-bold text-gray-900 mb-2">Catálogo de Productos</h1><div class="text-muted fs-6">Administra los productos de tu tienda</div></div>
        <?php if ($es_admin_productos): ?><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_agregar_producto"><i class="ki-outline ki-plus fs-2"></i>Agregar Producto</button><?php endif; ?>
    </div>

    <div class="card card-flush">
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
            <div class="card-title"><div class="d-flex align-items-center position-relative my-1"><i class="ki-outline ki-magnifier fs-3 position-absolute ms-4"></i><input type="text" id="buscar_producto" class="form-control form-control-solid w-250px ps-12" placeholder="Buscar producto" /></div></div>
        </div>
        <div class="card-body pt-0">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="tabla_productos">
                <thead><tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0"><th>Producto</th><th>Categoría</th><th>Precio</th><th>Stock</th><th>Estatus</th><th>Acciones</th></tr></thead>
                <tbody class="fw-semibold text-gray-600"></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_editar_producto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"><div class="modal-content">
        <form id="form_editar_producto" action="actions/13.update_producto.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_producto" id="editar_id_producto" />
            <div class="modal-header"><h2 class="fw-bold">Editar Producto</h2><button type="button" class="btn btn-icon btn-sm btn-active-light-primary" data-bs-dismiss="modal"><i class="ki-outline ki-cross fs-1"></i></button></div>
            <div class="modal-body py-10 px-lg-17"><div class="row g-5">
                <div class="col-md-8"><label class="required form-label">Nombre del Producto</label><input type="text" name="nombre" id="editar_nombre" class="form-control" required /></div>
                <div class="col-md-4"><label class="required form-label">Categoría</label><select class="form-select" data-control="select2" data-dropdown-parent="#modal_editar_producto" name="id_categoria" id="editar_categoria" required><option></option></select></div>
                <div class="col-12"><label class="form-label">Descripción</label><textarea name="descripcion" id="editar_descripcion" class="form-control" rows="3"></textarea></div>
                <div class="col-md-4"><label class="required form-label">Precio Unitario</label><input type="number" step="0.01" min="0" name="precio" id="editar_precio" class="form-control" required /></div>
                <div class="col-md-4"><label class="required form-label">Stock</label><input type="number" min="0" name="stock" id="editar_stock" class="form-control" required /></div>
                <div class="col-md-4"><label class="form-label">Estatus</label><select name="estatus" id="editar_estatus" class="form-select"><option value="1">Activo</option><option value="0">Inactivo</option></select></div>
                <div class="col-12"><label class="form-label">Imagen</label><input type="file" name="imagen" class="form-control" accept=".png,.jpg,.jpeg,.webp" /><div class="text-muted fs-7 mt-2">Si no seleccionas una imagen se conservará la actual.</div></div>
            </div></div>
            <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button><button type="submit" id="actualizar_producto" class="btn btn-primary"><span class="indicator-label">Actualizar Producto</span><span class="indicator-progress">Actualizando... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span></button></div>
        </form>
    </div></div>
</div>

<div class="modal fade" id="modal_agregar_producto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"><div class="modal-content">
        <form id="kt_ecommerce_add_product_form" action="actions/11.create_producto.php" method="POST" enctype="multipart/form-data">
            <div class="modal-header"><h2 class="fw-bold">Agregar Producto</h2><button type="button" class="btn btn-icon btn-sm btn-active-light-primary" data-bs-dismiss="modal"><i class="ki-outline ki-cross fs-1"></i></button></div>
            <div class="modal-body py-10 px-lg-17"><div class="row g-5">
                <div class="col-md-8"><label class="required form-label">Nombre del Producto</label><input type="text" name="nombre" class="form-control" required /></div>
                <div class="col-md-4"><label class="required form-label">Categoría</label><select class="form-select" data-control="select2" data-dropdown-parent="#modal_agregar_producto" data-placeholder="Selecciona una categoría" name="id_categoria" id="categoria" required><option></option></select></div>
                <div class="col-12"><label class="form-label">Descripción</label><textarea name="descripcion" class="form-control" rows="3"></textarea></div>
                <div class="col-md-4"><label class="required form-label">Precio Unitario</label><input type="number" step="0.01" min="0" name="precio" class="form-control" required /></div>
                <div class="col-md-4"><label class="required form-label">Stock</label><input type="number" min="0" name="stock" class="form-control" required /></div>
                <div class="col-md-4"><label class="form-label">Estatus</label><select class="form-select" name="estatus"><option value="1" selected>Activo</option><option value="0">Inactivo</option></select></div>
                <div class="col-12"><label class="form-label">Imagen</label><input type="file" name="imagen" class="form-control" accept=".png,.jpg,.jpeg,.webp" /><div class="text-muted fs-7 mt-2">Si no seleccionas una imagen se utilizará la imagen predeterminada.</div></div>
            </div></div>
            <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button><button type="submit" id="kt_ecommerce_add_product_submit" class="btn btn-primary"><span class="indicator-label">Guardar Producto</span><span class="indicator-progress">Guardando... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span></button></div>
        </form>
    </div></div>
</div>

<script>
(function () {
    const esAdmin = <?php echo $es_admin_productos ? 'true' : 'false'; ?>, tabla = $('#tabla_productos'), modal = $('#modal_agregar_producto'), formulario = document.getElementById('kt_ecommerce_add_product_form'), formularioEditar = document.getElementById('form_editar_producto'), alerta = document.getElementById('alerta-contenedor');
    function cargarCategorias() {
        fetch('actions/09.read_categorias.php').then(r => r.json()).then(respuesta => {
            const select = $('#categoria, #editar_categoria'); select.empty().append('<option></option>');
            if (respuesta.success && Array.isArray(respuesta.data)) respuesta.data.forEach(categoria => { if (String(categoria.estatus) === '1') select.append(new Option(categoria.nombre, categoria.id_categoria)); });
            const categoriaSeleccionada = $('#editar_categoria').attr('data-seleccionada');
            if (categoriaSeleccionada) { $('#editar_categoria').val(categoriaSeleccionada).removeAttr('data-seleccionada'); }
            select.trigger('change');
        }).catch(error => console.error('Error al cargar categorías:', error));
    }
    function cargarProductos() {
        fetch('actions/12.read_productos.php').then(r => r.json()).then(respuesta => {
            if (!respuesta.success) return;
            const filas = (respuesta.data || []).map(producto => [
                '<div class="d-flex align-items-center"><div class="symbol symbol-45px me-5"><img src="' + (producto.imagen || 'assets/media/products/default.png') + '" alt="Producto" /></div><div class="d-flex flex-column"><span class="text-gray-800 fw-bold">' + producto.nombre + '</span><span class="text-muted fs-7">ID: ' + producto.id_producto + '</span></div></div>',
                producto.categoria_nombre || 'Sin categoría', '$' + Number(producto.precio).toFixed(2), producto.stock,
                String(producto.estatus) === '1' ? '<span class="badge badge-light-success">Activo</span>' : '<span class="badge badge-light-danger">Inactivo</span>',
                esAdmin ? '<button type="button" class="btn btn-sm btn-light-primary editar-producto" data-id-producto="' + producto.id_producto + '"><i class="ki-outline ki-pencil fs-4"></i>Editar</button>' : ''
            ]);
            if ($.fn.DataTable.isDataTable('#tabla_productos')) tabla.DataTable().clear().rows.add(filas).draw();
            else tabla.DataTable({ data: filas, columns: [{ title: 'Producto' }, { title: 'Categoría' }, { title: 'Precio' }, { title: 'Stock' }, { title: 'Estatus' }, { title: 'Acciones' }], pageLength: 10, language: { url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' }, columnDefs: [{ targets: [0, 4, 5], orderable: false }] });
        }).catch(error => console.error('Error al cargar productos:', error));
    }
    $('#buscar_producto').on('keyup', function () { if ($.fn.DataTable.isDataTable('#tabla_productos')) tabla.DataTable().search(this.value).draw(); });
    if (esAdmin) tabla.on('click', '.editar-producto', function () {
        const id = $(this).data('id-producto');
        fetch('actions/12.read_productos.php?id_producto=' + id).then(r => r.json()).then(respuesta => {
            if (!respuesta.success) return;
            const producto = respuesta.data; $('#editar_id_producto').val(producto.id_producto); $('#editar_nombre').val(producto.nombre); $('#editar_descripcion').val(producto.descripcion); $('#editar_precio').val(producto.precio); $('#editar_stock').val(producto.stock); $('#editar_estatus').val(producto.estatus); $('#editar_categoria').attr('data-seleccionada', producto.id_categoria); bootstrap.Modal.getOrCreateInstance(document.getElementById('modal_editar_producto')).show();
        });
    });
    if (esAdmin) $('#modal_editar_producto').on('shown.bs.modal', cargarCategorias);
    if (esAdmin) modal.on('shown.bs.modal', cargarCategorias);
    cargarProductos();
    if (esAdmin) formulario.addEventListener('submit', function (evento) {
        evento.preventDefault(); const boton = document.getElementById('kt_ecommerce_add_product_submit'); boton.setAttribute('data-kt-indicator', 'on'); boton.disabled = true;
        fetch(formulario.action, { method: 'POST', body: new FormData(formulario) }).then(r => r.json()).then(respuesta => {
            if (respuesta.success) { bootstrap.Modal.getInstance(document.getElementById('modal_agregar_producto')).hide(); formulario.reset(); $('#categoria').val(null).trigger('change'); cargarProductos(); alerta.innerHTML = '<div class="alert alert-success">' + respuesta.message + '</div>'; }
            else alerta.innerHTML = '<div class="alert alert-danger">' + (respuesta.error || 'No se pudo guardar el producto.') + '</div>';
        }).catch(() => alerta.innerHTML = '<div class="alert alert-danger">Ocurrió un error de conexión con el servidor.</div>').finally(() => { boton.removeAttribute('data-kt-indicator'); boton.disabled = false; });
    });
    if (esAdmin) formularioEditar.addEventListener('submit', function (evento) {
        evento.preventDefault(); const boton = document.getElementById('actualizar_producto'); boton.setAttribute('data-kt-indicator', 'on'); boton.disabled = true;
        fetch(formularioEditar.action, { method: 'POST', body: new FormData(formularioEditar) }).then(r => r.json()).then(respuesta => {
            if (respuesta.success) { bootstrap.Modal.getInstance(document.getElementById('modal_editar_producto')).hide(); cargarProductos(); alerta.innerHTML = '<div class="alert alert-success">' + respuesta.message + '</div>'; }
            else alerta.innerHTML = '<div class="alert alert-danger">' + (respuesta.error || 'No se pudo actualizar el producto.') + '</div>';
        }).catch(() => alerta.innerHTML = '<div class="alert alert-danger">Ocurrió un error de conexión con el servidor.</div>').finally(() => { boton.removeAttribute('data-kt-indicator'); boton.disabled = false; });
    });
})();
</script>
