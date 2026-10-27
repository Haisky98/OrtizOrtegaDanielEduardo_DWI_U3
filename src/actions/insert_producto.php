<?php
session_start();
require_once __DIR__ . '/../class/class_productos.php';

// Validar método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
    exit();
}

$nombre       = trim($_POST['nombre'] ?? '');
$descripcion  = trim($_POST['descripcion'] ?? '');
$precio       = floatval($_POST['precio'] ?? 0);
$stock        = intval($_POST['stock'] ?? 0);
$id_categoria = intval($_POST['id_categoria'] ?? 0);

// Validaciones básicas
if (empty($nombre) || $precio <= 0 || empty($id_categoria)) {
    header("Location: ../index.php?modulo=nuevo_producto&error=campos_incompletos");
    exit();
}

// Ruta por defecto para la imagen
$ruta_db = 'assets/media/products/default.png';

// Procesar imagen si fue cargada
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath   = $_FILES['imagen']['tmp_name'];
    $fileName      = $_FILES['imagen']['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

    if (in_array($fileExtension, $allowedExtensions)) {
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $uploadFileDir = __DIR__ . '/../assets/media/products/';
        
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0755, true);
        }

        $dest_path = $uploadFileDir . $newFileName;
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $ruta_db = 'assets/media/products/' . $newFileName;
        }
    }
}

// Instanciar clase y guardar
$productoObj = new class_productos();
$resultado = $productoObj->insertar_producto($nombre, $descripcion, $precio, $stock, $id_categoria, $ruta_db);

if ($resultado['bool']) {
    header("Location: ../index.php?modulo=principal&status=insert_exito");
} else {
    header("Location: ../index.php?modulo=nuevo_producto&error=db_error");
}
exit();