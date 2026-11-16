<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

// Validar que exista una sesión activa (o puedes recibir el id_usuario por POST si es un panel de administración)
if (!isset($_SESSION['id_usuario'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'No hay una sesión activa']);
    exit;
}

include_once('../class/02.class_usuarios.php');
$objeto_usuario = new class_usuarios();

// Tomamos el ID de la sesión (o de $_POST['id_usuario'] si un admin edita a otro usuario)
$id_usuario = $_SESSION['id_usuario']; 

$nombre = trim($_POST['nombre'] ?? '');
$email = trim($_POST['email'] ?? '');
$domicilio = trim($_POST['domicilio'] ?? '');
$password = trim($_POST['password'] ?? ''); // Opcional
// Esta pantalla solo edita datos personales; nunca permite cambiar rol o estatus por POST.
$id_rol = $_SESSION['id_rol'];
$estatus = 1;

// Validaciones básicas
if ($nombre === '' || $email === '' || $domicilio === '') {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'El nombre, el email y el domicilio son obligatorios']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'El formato del correo electrónico no es válido']);
    exit;
}

// Ejecutar la actualización
$resultado = $objeto_usuario->update_usuario($id_usuario, $nombre, $email, $password, $id_rol, $estatus, $domicilio);

if ($resultado === 1) {
    // Si actualizó sus propios datos, puedes refrescar las variables de sesión si lo deseas
    $_SESSION['nombre'] = $nombre;
    $_SESSION['email'] = $email;

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Usuario actualizado correctamente'
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'No se pudo actualizar el usuario. Es posible que el correo ya esté en uso.'
    ]);
}
