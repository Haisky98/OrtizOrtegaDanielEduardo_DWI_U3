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

$id_pedido = $_REQUEST['id_pedido'] ?? null;

// Administradores pueden consultar todos; clientes solo sus propios pedidos.
$id_usuario_filtro = (($_SESSION['id_rol'] ?? 3) == 1 || ($_SESSION['id_rol'] ?? 3) == 2) ? null : $_SESSION['id_usuario'];

if ($id_pedido) {
    // Si mandan un ID, devolvemos el pedido junto con sus productos (detalle)
    $pedido = $objeto_pedido->get_pedido_with_detalles($id_pedido, $id_usuario_filtro);
    if ($pedido) {
        http_response_code(200);
        echo json_encode(['success' => true, 'data' => $pedido]);
    } else {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Pedido no encontrado']);
    }
} else {
    // Si no mandan ID, listamos todos los pedidos
    $pedidos = $objeto_pedido->get_pedidos($id_usuario_filtro);
    http_response_code(200);
    echo json_encode(['success' => true, 'data' => $pedidos]);
}
