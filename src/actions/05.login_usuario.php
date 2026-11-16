<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

include_once('../class/02.class_usuarios.php');
$objeto_usuarios = new class_usuarios();

$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

// 1. Validar campos obligatorios
if ($email === '' || $password === '') {
    http_response_code(422);
    echo json_encode([
        'success' => false, 
        'error' => 'Faltan datos obligatorios (email y password)'
    ]);
    exit;
}

// 2. Ejecutar el login
$resultado = $objeto_usuarios->get_usuario($email, $password);

// 3. Evaluar la respuesta de la función
if (is_object($resultado)) {
    // Login exitoso
    $_SESSION['id_usuario'] = $resultado->id_usuario;
    $_SESSION['nombre'] = $resultado->nombre;
    $_SESSION['email'] = $resultado->email;
    $_SESSION['id_rol'] = $resultado->id_rol;

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Inicio de sesión exitoso',
        'data' => $resultado
    ]);
} elseif ($resultado === "inactive") {
    // Cuenta inactiva (estatus = 0)
    http_response_code(403); // Prohibido / Cuenta inactiva
    echo json_encode([
        'success' => false,
        'error' => 'Tu cuenta está inactiva. Por favor, contacta al administrador.'
    ]);
} else {
    // Correo no encontrado o contraseña incorrecta
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'error' => 'Correo electrónico o contraseña incorrectos'
    ]);
}