<?php
header('Content-Type: application/json; charset=utf-8');

include_once('../class/04.class_productos.php');
$objeto_producto = new class_productos();

$id_producto = $_REQUEST['id_producto'] ?? null;

if ($id_producto) {
    $producto = $objeto_producto->get_producto_by_id($id_producto);
    if ($producto) {
        http_response_code(200);
        echo json_encode(['success' => true, 'data' => $producto]);
    } else {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Producto no encontrado']);
    }
} else {
    $productos = $objeto_producto->get_productos();
    http_response_code(200);
    echo json_encode(['success' => true, 'data' => $productos]);
}