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

$id_pedido = $_POST['id_pedido'] ?? '';
$estatus = $_POST['estatus'] ?? '';

// Validaciones
if ($id_pedido === '' || !is_numeric($id_pedido)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'El ID del pedido es obligatorio y numérico']);
    exit;
}

if ($estatus === '' || !is_numeric($estatus)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'El nuevo estatus es obligatorio y numérico']);
    exit;
}

$estatus = (int)$estatus;
if (!in_array($estatus, [1, 2, 3, 4], true)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'El estatus del pedido no es válido']);
    exit;
}

// Un cliente solo puede modificar sus propios pedidos.
$id_usuario_filtro = in_array((int)($_SESSION['id_rol'] ?? 3), [1, 2], true) ? null : $_SESSION['id_usuario'];
$pedido_actual = $objeto_pedido->get_pedido_with_detalles($id_pedido, $id_usuario_filtro);
if (!$pedido_actual) {
    http_response_code(404);
    echo json_encode(['success' => false, 'error' => 'Pedido no encontrado o no pertenece al usuario']);
    exit;
}

// El cliente solo puede confirmar o cancelar pedidos pendientes.
if ((int)($_SESSION['id_rol'] ?? 3) == 3 && ((int)$pedido_actual->estatus !== 1 || $estatus !== 4)) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Solo puedes cancelar pedidos pendientes']);
    exit;
}

if ($estatus === 2 && trim((string)($pedido_actual->domicilio ?? '')) === '') {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'El cliente debe registrar su domicilio antes de confirmar el pedido']);
    exit;
}

// Ejecutar actualización de estatus
$resultado = $objeto_pedido->update_estatus_pedido($id_pedido, $estatus);

if ($resultado === 1) {
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Estatus del pedido actualizado correctamente'
    ]);
} elseif ($resultado === -1) {
    http_response_code(409);
    echo json_encode(['success' => false, 'error' => 'No hay stock suficiente para confirmar el pedido']);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'No se pudo actualizar el estatus del pedido'
    ]);
}
