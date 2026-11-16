<div id="kt_content_container" class="container-xxl py-5">
    <div id="alerta-categorias"></div>
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-7">
        <div><h1 class="fw-bold text-gray-900 mb-2">Catálogo de Categorías</h1><div class="text-muted fs-6">Administra las categorías de tus productos</div></div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_agregar_categoria"><i class="ki-outline ki-plus fs-2"></i>Agregar Categoría</button>
    </div>

    <div class="card card-flush">
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
            <div class="card-title"><div class="d-flex align-items-center position-relative my-1"><i class="ki-outline ki-magnifier fs-3 position-absolute ms-4"></i><input type="text" id="buscar_categoria" class="form-control form-control-solid w-250px ps-12" placeholder="Buscar categoría" /></div></div>
        </div>
        <div class="card-body pt-0">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="tabla_categorias">
                <thead><tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0"><th>ID</th><th>Nombre</th><th>Estatus</th></tr></thead>
                <tbody class="fw-semibold text-gray-600"></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_agregar_categoria" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
        <form id="form_agregar_categoria" action="actions/08.create_categoria.php" method="POST">
            <div class="modal-header"><h2 class="fw-bold">Agregar Categoría</h2><button type="button" class="btn btn-icon btn-sm btn-active-light-primary" data-bs-dismiss="modal"><i class="ki-outline ki-cross fs-1"></i></button></div>
            <div class="modal-body py-10 px-lg-17">
                <label class="required form-label">Nombre de la Categoría</label>
                <input type="text" name="nombre" class="form-control" placeholder="Ej. Electrónica" required />
                <label class="form-label mt-5">Estatus</label>
                <select name="estatus" class="form-select"><option value="1" selected>Activo</option><option value="0">Inactivo</option></select>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button><button type="submit" id="guardar_categoria" class="btn btn-primary"><span class="indicator-label">Guardar Categoría</span><span class="indicator-progress">Guardando... <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span></button></div>
        </form>
    </div></div>
</div>

<script>
(function () {
    const tabla = $('#tabla_categorias'), formulario = document.getElementById('form_agregar_categoria'), alerta = document.getElementById('alerta-categorias');
    function cargarCategorias() {
        fetch('actions/09.read_categorias.php').then(r => r.json()).then(respuesta => {
            if (!respuesta.success) return;
            const filas = (respuesta.data || []).map(categoria => [categoria.id_categoria, categoria.nombre, String(categoria.estatus) === '1' ? '<span class="badge badge-light-success">Activo</span>' : '<span class="badge badge-light-danger">Inactivo</span>']);
            if ($.fn.DataTable.isDataTable('#tabla_categorias')) tabla.DataTable().clear().rows.add(filas).draw();
            else tabla.DataTable({ data: filas, columns: [{ title: 'ID' }, { title: 'Nombre' }, { title: 'Estatus' }], pageLength: 10, language: { url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' }, columnDefs: [{ targets: 2, orderable: false }] });
        }).catch(error => console.error('Error al cargar categorías:', error));
    }
    $('#buscar_categoria').on('keyup', function () { if ($.fn.DataTable.isDataTable('#tabla_categorias')) tabla.DataTable().search(this.value).draw(); });
    cargarCategorias();
    formulario.addEventListener('submit', function (evento) {
        evento.preventDefault(); const boton = document.getElementById('guardar_categoria'); boton.setAttribute('data-kt-indicator', 'on'); boton.disabled = true;
        fetch(formulario.action, { method: 'POST', body: new FormData(formulario) }).then(r => r.json()).then(respuesta => {
            if (respuesta.success) { bootstrap.Modal.getInstance(document.getElementById('modal_agregar_categoria')).hide(); formulario.reset(); cargarCategorias(); alerta.innerHTML = '<div class="alert alert-success">' + respuesta.message + '</div>'; }
            else alerta.innerHTML = '<div class="alert alert-danger">' + (respuesta.error || 'No se pudo guardar la categoría.') + '</div>';
        }).catch(() => alerta.innerHTML = '<div class="alert alert-danger">Ocurrió un error de conexión con el servidor.</div>').finally(() => { boton.removeAttribute('data-kt-indicator'); boton.disabled = false; });
    });
})();
</script>
