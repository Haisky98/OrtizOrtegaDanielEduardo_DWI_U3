<?php
include_once('../class/09.class_autorizacion.php');
requiere_admin();
header('Content-Type: application/json; charset=utf-8');

include_once('../class/04.class_productos.php');
$objeto_producto = new class_productos();

$id_producto = $_POST['id_producto'] ?? '';

if ($id_producto === '' || !is_numeric($id_producto)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'El ID del producto es obligatorio y numérico']);
    exit;
}

// Ejecutar borrado lógico (estatus = 0)
$resultado = $objeto_producto->delete_producto($id_producto);

if ($resultado === 1) {
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Producto desactivado (eliminado) correctamente'
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'No se pudo desactivar el producto'
    ]);
}
