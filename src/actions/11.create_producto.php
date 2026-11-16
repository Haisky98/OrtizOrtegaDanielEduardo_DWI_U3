<?php
include_once('../class/09.class_autorizacion.php');
requiere_admin();
header('Content-Type: application/json; charset=utf-8');

include_once('../class/04.class_productos.php');
$objeto_producto = new class_productos();

$nombre = trim($_POST['nombre'] ?? '');
$descripcion = trim($_POST['descripcion'] ?? '');
$precio = $_POST['precio'] ?? '';
$stock = $_POST['stock'] ?? 0;
$imagen = '';
$id_categoria = $_POST['id_categoria'] ?? '';
$estatus = isset($_POST['estatus']) ? (int)$_POST['estatus'] : 1;

// Validaciones obligatorias
if ($nombre === '' || $precio === '' || $id_categoria === '') {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'El nombre, precio y categoría son obligatorios']);
    exit;
}

if (!is_numeric($precio) || !is_numeric($stock) || !is_numeric($id_categoria)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'Precio, stock e ID de categoría deben ser valores numéricos']);
    exit;
}

// Procesar imagen enviada como archivo
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
        http_response_code(422);
        echo json_encode(['success' => false, 'error' => 'No se pudo recibir la imagen']);
        exit;
    }

    if ($_FILES['imagen']['size'] > 5 * 1024 * 1024) {
        http_response_code(422);
        echo json_encode(['success' => false, 'error' => 'La imagen no debe superar los 5 MB']);
        exit;
    }

    $tipos_permitidos = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $tipo_imagen = (new finfo(FILEINFO_MIME_TYPE))->file($_FILES['imagen']['tmp_name']);
    if (!isset($tipos_permitidos[$tipo_imagen])) {
        http_response_code(422);
        echo json_encode(['success' => false, 'error' => 'El formato de imagen no es válido']);
        exit;
    }

    $directorio_imagenes = __DIR__ . '/../assets/media/products';
    if (!is_dir($directorio_imagenes)) {
        mkdir($directorio_imagenes, 0775, true);
    }
    $nombre_imagen = bin2hex(random_bytes(16)) . '.' . $tipos_permitidos[$tipo_imagen];
    if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio_imagenes . '/' . $nombre_imagen)) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'No se pudo guardar la imagen']);
        exit;
    }
    $imagen = 'assets/media/products/' . $nombre_imagen;
}

// Ejecutar creación
$resultado = $objeto_producto->create_producto($nombre, $descripcion, $precio, $stock, $imagen, $id_categoria, $estatus);

if ($resultado === 1) {
    http_response_code(201);
    echo json_encode([
        'success' => true,
        'message' => 'Producto creado correctamente'
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'No se pudo crear el producto. Verifica que la categoría exista.'
    ]);
}
