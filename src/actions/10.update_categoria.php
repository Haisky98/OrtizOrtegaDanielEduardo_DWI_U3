<?php
include_once('../class/09.class_autorizacion.php');
requiere_admin();
header('Content-Type: application/json; charset=utf-8');


include_once('../class/03.class_cat_categorias.php');
$objeto_categoria = new class_cat_categorias();

$id_categoria = trim($_POST['id_categoria'] ?? '');
$nombre = trim($_POST['nombre'] ?? '');
$estatus = isset($_POST['estatus']) ? (int)$_POST['estatus'] : 1;

// Validaciones
if ($id_categoria === '' || !is_numeric($id_categoria)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'El ID de la categoría es obligatorio y numérico']);
    exit;
}

if ($nombre === '') {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'El nombre de la categoría es obligatorio']);
    exit;
}

// Ejecutar actualización
$resultado = $objeto_categoria->update_categoria($id_categoria, $nombre, $estatus);

if ($resultado === 1) {
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Categoría actualizada correctamente'
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'No se pudo actualizar la categoría o no hubo cambios'
    ]);
}
