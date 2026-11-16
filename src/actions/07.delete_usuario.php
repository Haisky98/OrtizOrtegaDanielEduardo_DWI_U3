<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

// Validar que exista una sesión activa
if (!isset($_SESSION['id_usuario'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'No hay una sesión activa']);
    exit;
}

include_once('../class/02.class_usuarios.php');
$objeto_usuario = new class_usuarios();

// ¿Vas a eliminar tu propia cuenta de usuario en sesión o vas a recibir un ID por POST?
// Opción A: Eliminar la cuenta del usuario logueado actualmente:
$id_usuario = $_SESSION['id_usuario'];

// Opción B (Si eres administrador y vas a eliminar a otro usuario mandando su ID por POST):
// $id_usuario = $_POST['id_usuario'] ?? '';
// if ($id_usuario === '') { ... error ... }

// Ejecutar la desactivación/eliminación
$resultado = $objeto_usuario->delete_usuario($id_usuario);

if ($resultado === 1) {
    // Si el usuario eliminó su propia cuenta, cerramos la sesión automáticamente
    if ($id_usuario == $_SESSION['id_usuario']) {
        session_destroy();
    }

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Usuario eliminado o desactivado correctamente'
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'No se pudo eliminar el usuario'
    ]);
}
