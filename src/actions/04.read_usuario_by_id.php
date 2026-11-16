<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['id_usuario'])) {
    http_response_code(401); // No autorizado
    echo json_encode(['success' => false, 'error' => 'No hay una sesión activa']);
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

include_once('../class/02.class_usuarios.php');
$objeto_read_usuario = new class_usuarios();

$read_usuario = $objeto_read_usuario->get_usuario_by_id($id_usuario);
unset($objeto_read_usuario);

echo json_encode([
    'success' => true,
    'data' => $read_usuario ?: []
]);