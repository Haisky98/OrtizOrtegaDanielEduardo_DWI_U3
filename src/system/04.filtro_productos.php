<div id="kt_content_container" class="container-xxl py-5">
    <div class="d-flex flex-wrap flex-stack mb-7"><div><h1 class="fw-bold text-gray-900 mb-2">Productos por Categoría</h1><div class="text-muted fs-6">Selecciona una categoría para consultar sus productos</div></div><button type="button" id="quitar_filtro" class="btn btn-light-primary d-none"><i class="ki-outline ki-cross fs-2"></i>Quitar filtro</button></div>
    <div id="alerta-filtros"></div>
    <div id="botones_categorias" class="row g-5"><div class="col-12 text-center text-muted py-10">Cargando categorías...</div></div>
    <div id="resultado_productos" class="d-none"><div class="d-flex align-items-center mb-5"><h3 id="titulo_categoria" class="fw-bold text-gray-900 mb-0"></h3></div><div id="cards_productos" class="row g-6 g-xl-9"></div></div>
</div>

<script>
(function () {
    const botones = document.getElementById('botones_categorias'), resultados = document.getElementById('resultado_productos'), cards = document.getElementById('cards_productos'), quitar = document.getElementById('quitar_filtro'), titulo = document.getElementById('titulo_categoria');
    let categorias = [], productos = [];
    function cargarDatos() {
        Promise.all([fetch('actions/09.read_categorias.php').then(r => r.json()), fetch('actions/12.read_productos.php').then(r => r.json())]).then(([respuestaCategorias, respuestaProductos]) => {
            categorias = respuestaCategorias.success && Array.isArray(respuestaCategorias.data) ? respuestaCategorias.data.filter(categoria => String(categoria.estatus) === '1') : [];
            productos = respuestaProductos.success && Array.isArray(respuestaProductos.data) ? respuestaProductos.data.filter(producto => String(producto.estatus) === '1') : [];
            if (!categorias.length) { botones.innerHTML = '<div class="col-12"><div class="alert alert-info">No hay categorías activas registradas.</div></div>'; return; }
            botones.innerHTML = categorias.map(categoria => '<div class="col-sm-6 col-xl-3"><button type="button" class="btn btn-light-primary w-100 h-100 py-8 px-5 categoria-filtro" data-id-categoria="' + categoria.id_categoria + '"><i class="ki-outline ki-element-11 fs-2hx d-block mb-3"></i><span class="fs-4 fw-bold">' + categoria.nombre + '</span></button></div>').join('');
            $('.categoria-filtro').on('click', function () { mostrarProductos($(this).data('id-categoria')); });
        }).catch(error => { console.error('Error al cargar filtros:', error); botones.innerHTML = '<div class="col-12"><div class="alert alert-danger">No se pudieron cargar las categorías.</div></div>'; });
    }
    function mostrarProductos(idCategoria) {
        const categoria = categorias.find(item => String(item.id_categoria) === String(idCategoria));
        const filtrados = productos.filter(producto => String(producto.id_categoria) === String(idCategoria));
        botones.classList.add('d-none'); resultados.classList.remove('d-none'); quitar.classList.remove('d-none'); titulo.textContent = categoria ? categoria.nombre : 'Productos';
        if (!filtrados.length) { cards.innerHTML = '<div class="col-12"><div class="alert alert-info">Esta categoría no tiene productos activos.</div></div>'; return; }
        cards.innerHTML = filtrados.map(producto => '<div class="col-sm-6 col-xl-4"><div class="card card-flush h-100"><div class="card-body p-5"><a href="javascript:;" class="producto-detalle-filtro" data-id-producto="' + producto.id_producto + '"><div class="text-center mb-5"><img src="' + (producto.imagen || 'assets/media/products/default.png') + '" class="mw-100 h-150px object-fit-contain" alt="Producto" /></div><div class="d-flex flex-column"><span class="text-gray-800 fw-bold fs-5">' + producto.nombre + '</span><span class="text-muted fs-7 mt-1">' + (producto.descripcion || 'Sin descripción') + '</span><div class="d-flex justify-content-between align-items-center mt-5"><span class="text-primary fw-bold fs-4">$' + Number(producto.precio || 0).toFixed(2) + '</span><span class="badge badge-light-' + (Number(producto.stock) > 0 ? 'success' : 'danger') + '">' + producto.stock + ' en stock</span></div></div></a></div></div></div>').join('');
        $('.producto-detalle-filtro').on('click', function () { $('#principal').load('system/03.detalle_producto.php?id_producto=' + $(this).data('id-producto')); });
    }
    quitar.addEventListener('click', function () { resultados.classList.add('d-none'); botones.classList.remove('d-none'); quitar.classList.add('d-none'); cards.innerHTML = ''; titulo.textContent = ''; });
    cargarDatos();
})();
</script>
