<?php
session_start();

// 1. Limpiar todas las variables de sesión
$_SESSION = array();

// 2. Destruir la cookie de sesión si existe
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 3. Destruir la sesión por completo en el servidor
session_destroy();

// 4. Redirigir al usuario de vuelta a la página de login
header("Location: ../login.php"); // Ajusta la ruta "../login.php" según dónde guardes este archivo
exit;