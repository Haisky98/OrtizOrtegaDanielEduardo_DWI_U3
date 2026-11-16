<?php $id_producto_detalle = (int)($_GET['id_producto'] ?? 0); ?>
<div id="kt_content_container" class="container-xxl py-5">
    <div id="alerta-detalle"></div>
    <div class="d-flex align-items-center mb-7"><a href="javascript:;" id="volver_catalogo" class="btn btn-light me-5"><i class="ki-outline ki-arrow-left fs-2"></i>Regresar</a><h1 class="fw-bold text-gray-900 mb-0">Detalle del Producto</h1></div>
    <div id="detalle_producto"><div class="card card-flush"><div class="card-body text-center py-15 text-muted">Cargando producto...</div></div></div>
</div>

<script>
(function () {
    const idProducto = <?php echo $id_producto_detalle; ?>;
    const contenedor = document.getElementById('detalle_producto');
    document.getElementById('volver_catalogo').addEventListener('click', function () { $('#principal').load('system/01.cat_productos.php'); });
    if (!idProducto) { contenedor.innerHTML = '<div class="alert alert-danger">No se especificó el producto.</div>'; return; }

    fetch('actions/12.read_productos.php?id_producto=' + encodeURIComponent(idProducto)).then(r => r.json()).then(respuesta => {
        if (!respuesta.success) { contenedor.innerHTML = '<div class="alert alert-danger">' + (respuesta.error || 'Producto no encontrado.') + '</div>'; return; }
        const producto = respuesta.data;
        contenedor.innerHTML = '<div class="card card-flush"><div class="card-body p-9"><div class="row g-10"><div class="col-lg-5"><div class="rounded bg-light d-flex align-items-center justify-content-center p-10"><img src="' + (producto.imagen || 'assets/media/products/default.png') + '" class="mw-100 h-300px object-fit-contain" alt="' + producto.nombre + '" /></div></div><div class="col-lg-7"><div class="mb-5"><span class="badge badge-light-primary mb-3">' + (producto.categoria_nombre || 'Sin categoría') + '</span><h2 class="fw-bold text-gray-900">' + producto.nombre + '</h2><div class="text-muted fs-7">Producto número ' + producto.id_producto + '</div></div><div class="border-bottom mb-5"></div><div class="row g-5 mb-7"><div class="col-sm-6"><span class="text-muted d-block fs-7">Precio</span><span id="precio_producto" class="text-primary fw-bold fs-2">$' + Number(producto.precio).toFixed(2) + ' MXN</span><div class="mt-3"><button type="button" id="cambiar_moneda" class="btn btn-sm btn-light-primary"><i class="ki-outline ki-dollar fs-4"></i>Ver en USD</button></div><span id="precio_dolares" class="text-muted d-block fs-7 mt-2">Usa el botón para convertir el precio.</span></div><div class="col-sm-6"><span class="text-muted d-block fs-7">Disponibilidad</span><span class="badge badge-light-' + (Number(producto.stock) > 0 ? 'success' : 'danger') + ' fs-6 mt-2">' + (Number(producto.stock) > 0 ? producto.stock + ' piezas disponibles' : 'Agotado') + '</span></div></div><div class="mb-7"><h4 class="fw-bold mb-3">Descripción</h4><p class="text-gray-600">' + (producto.descripcion || 'Este producto no tiene una descripción registrada.') + '</p></div><button type="button" id="agregar_carrito" class="btn btn-primary" ' + (Number(producto.stock) <= 0 ? 'disabled' : '') + '><i class="ki-outline ki-handcart fs-2"></i>Agregar al carrito</button><div id="mensaje_carrito" class="text-success mt-3"></div></div></div></div></div>';
        document.getElementById('agregar_carrito').addEventListener('click', function () {
            const carrito = JSON.parse(localStorage.getItem('carrito_productos') || '[]'), existente = carrito.find(item => Number(item.id_producto) === Number(producto.id_producto));
            if (existente) existente.cantidad = Math.min(Number(existente.cantidad) + 1, Number(producto.stock));
            else carrito.push({ id_producto: producto.id_producto, nombre: producto.nombre, precio: Number(producto.precio), imagen: producto.imagen, stock: Number(producto.stock), cantidad: 1 });
            localStorage.setItem('carrito_productos', JSON.stringify(carrito)); document.getElementById('mensaje_carrito').textContent = 'Producto agregado al carrito.';
        });
        let moneda = 'MXN', tasaCambio = null;
        document.getElementById('cambiar_moneda').addEventListener('click', function () {
            const boton = this, precio = document.getElementById('precio_producto'), texto = document.getElementById('precio_dolares');
            if (moneda === 'USD' && tasaCambio) { moneda = 'MXN'; precio.textContent = '$' + Number(producto.precio).toFixed(2) + ' MXN'; boton.innerHTML = '<i class="ki-outline ki-dollar fs-4"></i>Ver en USD'; texto.textContent = 'Usa el botón para convertir el precio.'; return; }
            boton.disabled = true; boton.innerHTML = 'Consultando...';
            fetch('https://api.frankfurter.dev/v2/rate/usd/mxn').then(r => { if (!r.ok) throw new Error('No se pudo consultar el tipo de cambio'); return r.json(); }).then(cambio => { tasaCambio = cambio.rate; moneda = 'USD'; const dolares = Number(producto.precio) / Number(cambio.rate); precio.textContent = '$' + dolares.toFixed(2) + ' USD'; boton.innerHTML = '<i class="ki-outline ki-arrows-loop fs-4"></i>Ver en MXN'; texto.textContent = 'Tipo de cambio: 1 USD = ' + Number(cambio.rate).toFixed(4) + ' MXN (' + cambio.date + ')'; }).catch(() => { boton.innerHTML = '<i class="ki-outline ki-dollar fs-4"></i>Ver en USD'; texto.textContent = 'No se pudo consultar el tipo de cambio.'; }).finally(() => boton.disabled = false);
        });
    }).catch(() => { contenedor.innerHTML = '<div class="alert alert-danger">Ocurrió un error al cargar el producto.</div>'; });
})();
</script>
