<?php
header('Content-Type: application/json; charset=utf-8');
include_once('../class/02.class_usuarios.php');

$objeto_create_usuario = new class_usuarios();

$nombre = trim($_POST['nombre'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

// 1. Validar que los campos no estén vacíos
if ($nombre === '' || $email === '' || $password === '') {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'Faltan datos obligatorios del usuario']);
    exit;
}

// 2. Validar formato de correo electrónico
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'El formato del correo electrónico no es válido']);
    exit;
}

// 3. Hashear la contraseña de forma segura
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// 4. Llamar al método de la clase para insertar en la base de datos
$resultado = $objeto_create_usuario->create_usuario($nombre, $email, $password_hash);

// 5. Responder según el resultado
if ($resultado === 1) {
    header("Location: ../login.php?registro=exito");
    exit();
} else {
    header("Location: ../registro.php?error=db_error"); // O la ruta de tu formulario de registro
    exit();
}