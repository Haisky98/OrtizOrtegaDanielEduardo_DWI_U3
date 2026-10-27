<!--begin::Toolbar-->
<div class="toolbar mb-5 mb-lg-7" id="kt_toolbar">
    <div class="page-title d-flex flex-column me-3">
        <h1 class="d-flex text-gray-900 fw-bolder fs-3 align-items-center my-1">Nuevo Producto</h1>
        <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
            <li class="breadcrumb-item text-muted">Dashboard</li>
            <li class="breadcrumb-item text-muted">Productos</li>
            <li class="breadcrumb-item text-muted">Crear</li>
        </ul>
    </div>
</div>
<!--end::Toolbar-->

<!--begin::Content container-->
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="card-title">Formulario de Registro de Producto</h3>
    </div>
    
    <!-- El formulario apunta a actions/guardar_producto_action.php y acepta archivos -->
    <form action="actions/guardar_producto_action.php" method="POST" enctype="multipart/form-data" class="form">
        <div class="card-body">
            
            <?php if (isset($_GET['status']) && $_GET['status'] == 'exito'): ?>
                <div class="alert alert-success">¡Producto registrado y imagen guardada con éxito!</div>
            <?php elseif (isset($_GET['error'])): ?>
                <div class="alert alert-danger">Error: <?= htmlspecialchars($_GET['error']) ?></div>
            <?php endif; ?>

            <!-- Nombre -->
            <div class="fv-row mb-7">
                <label class="required fw-semibold fs-6 mb-2">Nombre del Producto</label>
                <input type="text" name="nombre" class="form-control form-control-solid" placeholder="Ej. Laptop Gamer" required />
            </div>

            <!-- Descripción -->
            <div class="fv-row mb-7">
                <label class="required fw-semibold fs-6 mb-2">Descripción</label>
                <textarea name="descripcion" class="form-control form-control-solid" rows="3" placeholder="Detalles del producto..." required></textarea>
            </div>

            <div class="row g-7 mb-7">
                <!-- Precio -->
                <div class="col-md-6">
                    <label class="required fw-semibold fs-6 mb-2">Precio ($ MXN)</label>
                    <input type="number" step="0.01" name="precio" class="form-control form-control-solid" placeholder="0.00" required />
                </div>
                <!-- Stock -->
                <div class="col-md-6">
                    <label class="required fw-semibold fs-6 mb-2">Stock Inicial</label>
                    <input type="number" name="stock" class="form-control form-control-solid" placeholder="10" required />
                </div>
            </div>

            <!-- Select Hardcodeado de Categorías -->
            <div class="fv-row mb-7">
                <label class="required fw-semibold fs-6 mb-2">Categoría</label>
                <select name="id_categoria" class="form-select form-select-solid" required>
                    <option value="">Seleccione una categoría...</option>
                    <option value="1">Electrónica y Computación</option>
                    <option value="2">Ropa y Accesorios</option>
                    <option value="3">Hogar y Cocina</option>
                    <option value="4">Videojuegos</option>
                </select>
            </div>

            <!-- Selector de Imagen -->
            <div class="fv-row mb-7">
                <label class="required fw-semibold fs-6 mb-2">Imagen del Producto</label>
                <input type="file" name="imagen" class="form-control form-control-solid" accept="image/*" required />
                <div class="form-text">Formatos permitidos: png, jpg, jpeg.</div>
            </div>

        </div>
        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <button type="submit" class="btn btn-primary">Guardar Producto</button>
        </div>
    </form>
</div>