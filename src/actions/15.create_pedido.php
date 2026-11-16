<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['id_usuario'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'No hay una sesión activa']);
    exit;
}
include_once('../class/05.class_pedidos.php');
$objeto_pedido = new class_pedidos();

// Tomamos el id_usuario de la sesión actual (o puedes permitir recibirlo por POST si eres admin)
$id_usuario = $_SESSION['id_usuario'];
$total = $_POST['total'] ?? '';

// Los productos pueden recibirse como un string JSON o decodificados. 
// Ejemplo de JSON para Postman: [{"id_producto": 1, "cantidad": 2, "precio": 3482.80}, {"id_producto": 2, "cantidad": 1, "precio": 500.00}]
$productos_json = $_POST['productos'] ?? '';
$productos_array = json_decode($productos_json, true);

// Validaciones básicas
if ($total === '' || !is_numeric($total)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'El total del pedido es obligatorio y numérico']);
    exit;
}

if (!is_array($productos_array) || empty($productos_array)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'El pedido debe incluir al menos un producto válido en formato JSON']);
    exit;
}

// Ejecutar creación del pedido maestro y sus detalles
$resultado = $objeto_pedido->create_pedido($id_usuario, $total, $productos_array);

if ($resultado === 1) {
    http_response_code(201);
    echo json_encode([
        'success' => true,
        'message' => 'Pedido registrado correctamente'
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'No se pudo registrar el pedido'
    ]);
}
