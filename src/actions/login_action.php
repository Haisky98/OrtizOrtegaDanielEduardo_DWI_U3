<?php
session_start();
require_once __DIR__ . '/../class/class_usuarios.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        header("Location: ../login.php?error=campos_vacios");
        exit();
    }

    $usuarioObj = new class_usuarios();
    $resultado = $usuarioObj->obtener_por_email($email);

    if ($resultado['bool'] && !empty($resultado['data'])) {
        $usuario = $resultado['data'][0];

        // Verificar estatus del usuario (1 = activo, 0 = inactivo)
        if ($usuario['estatus'] == 0) {
            header("Location: ../login.php?error=usuario_inactivo");
            exit();
        }

        // Verificar contraseña de forma segura
        if (password_verify($password, $usuario['password'])) {
            // Guardar datos esenciales en la sesión
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['id_rol'] = $usuario['id_rol'];

            // Redireccionar al index o panel principal
            header("Location: ../index.php");
            exit();
        } else {
            header("Location: ../login.php?error=credenciales_invalidas");
            exit();
        }
    } else {
        header("Location: ../login.php?error=credenciales_invalidas");
        exit();
    }
} else {
    header("Location: ../login.php");
    exit();
}