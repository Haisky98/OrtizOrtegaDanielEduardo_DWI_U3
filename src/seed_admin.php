<?php
require_once __DIR__ . '/class/class_usuarios.php';

$usuarioObj = new class_usuarios();

$nombre = 'SA_daniel';
$email = 'haisky98@admin.com'; // Correo único requerido para el login
$password_plain = 'Haisky1406';
$id_rol_super_admin = 1; // 1 corresponde a 'super_admin' en cat_roles

// Verificar si ya existe el correo
$existente = $usuarioObj->obtener_por_email($email);
if ($existente['bool'] && !empty($existente['data'])) {
    echo "<h3>El usuario Super Admin ya se encuentra registrado.</h3>";
    exit();
}

// Cifrar la contraseña de forma segura (Mecanismo de seguridad)
$password_hash = password_hash($password_plain, PASSWORD_DEFAULT);

// Registrar en la base de datos
$resultado = $usuarioObj->registrar($nombre, $email, $password_hash, $id_rol_super_admin);

if ($resultado['bool']) {
    echo "<h3>¡Super Admin creado exitosamente!</h3>";
    echo "<p><strong>Usuario / Nombre:</strong> $nombre</p>";
    echo "<p><strong>Email para Login:</strong> $email</p>";
    echo "<p><strong>Contraseña:</strong> $password_plain</p>";
    echo "<br><a href='login.php'>Ir al Login</a>";
} else {
    echo "<h3>Error al crear el Super Admin.</h3>";
}
?>