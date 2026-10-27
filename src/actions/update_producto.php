<?php
session_start();
require_once __DIR__ . '/../class/class_productos.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
    exit();
}

$id_producto   = intval($_POST['id_producto'] ?? 0);
$nombre        = trim($_POST['nombre'] ?? '');
$descripcion   = trim($_POST['descripcion'] ?? '');
$precio        = floatval($_POST['precio'] ?? 0);
$stock         = intval($_POST['stock'] ?? 0);
$id_categoria  = intval($_POST['id_categoria'] ?? 0);
$estatus       = intval($_POST['estatus'] ?? 1);
$imagen_actual = trim($_POST['imagen_actual'] ?? 'assets/media/products/default.png');

if ($id_producto <= 0 || empty($nombre) || $precio <= 0) {
    header("Location: ../index.php?modulo=principal&error=datos_invalidos");
    exit();
}

$ruta_db = $imagen_actual;

// Si el usuario subió una nueva imagen
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath   = $_FILES['imagen']['tmp_name'];
    $fileName      = $_FILES['imagen']['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

    if (in_array($fileExtension, $allowedExtensions)) {
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $uploadFileDir = __DIR__ . '/../assets/media/products/';
        
        $dest_path = $uploadFileDir . $newFileName;
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $ruta_db = 'assets/media/products/' . $newFileName;
        }
    }
}

$productoObj = new class_productos();
$resultado = $productoObj->actualizar_producto($id_producto, $nombre, $descripcion, $precio, $stock, $id_categoria, $ruta_db, $estatus);

if ($resultado['bool']) {
    header("Location: ../index.php?modulo=principal&status=update_exito");
} else {
    header("Location: ../index.php?modulo=principal&error=db_error");
}
exit();