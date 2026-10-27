<?php
session_start();
require_once __DIR__ . '/../class/class_usuarios.php';

// Validar que la petición sea por método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
    exit();
}

// Recoger y sanitizar los datos del formulario
$id_usuario = intval($_POST['id_usuario'] ?? 0);
$nombre     = trim($_POST['nombre'] ?? '');
$email      = trim($_POST['email'] ?? '');
$id_rol     = intval($_POST['id_rol'] ?? 0);
$estatus    = intval($_POST['estatus'] ?? 1);

// Validaciones básicas
if ($id_usuario <= 0 || empty($nombre) || empty($email) || $id_rol <= 0) {
    header("Location: ../index.php?modulo=admin_usuarios&error=datos_invalidos");
    exit();
}

// Instanciar la clase y ejecutar la actualización
$usuarioObj = new class_usuarios();
$resultado = $usuarioObj->actualizar_usuario($id_usuario, $nombre, $email, $id_rol, $estatus);

// Evaluar el resultado
if ($resultado['bool']) {
    header("Location: ../index.php?modulo=admin_usuarios&status=update_exito");
} else {
    header("Location: ../index.php?modulo=admin_usuarios&error=db_error");
}
exit();