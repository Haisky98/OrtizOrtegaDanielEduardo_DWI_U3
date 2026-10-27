<?php
session_start();
require_once __DIR__ . '/../class/class_usuarios.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validaciones básicas
    if (empty($nombre) || empty($email) || empty($password)) {
        header("Location: ../registro.php?error=campos_vacios");
        exit();
    }

    $usuarioObj = new class_usuarios();

    // Verificar si el correo ya existe
    $resultadoVerificacion = $usuarioObj->obtener_por_email($email);
    if ($resultadoVerificacion['bool'] && !empty($resultadoVerificacion['data'])) {
        header("Location: ../registro.php?error=email_existente");
        exit();
    }

    // Cifrar contraseña (Mecanismo de seguridad requerido)
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $id_rol_cliente = 3; // 3 corresponde a 'cliente' según nuestros catálogos

    // Registrar usuario
    $resultadoRegistro = $usuarioObj->registrar($nombre, $email, $password_hash, $id_rol_cliente);

    if ($resultadoRegistro['bool']) {
        header("Location: ../login.php?registro=exitoso");
        exit();
    } else {
        header("Location: ../registro.php?error=db_error");
        exit();
    }
} else {
    header("Location: ../registro.php");
    exit();
}