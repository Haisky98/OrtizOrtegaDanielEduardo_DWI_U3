<?php
function responder_no_autorizado(
    $mensaje = 'No tienes permisos para realizar esta acción', $codigo = 403) 
    { http_response_code($codigo); echo json_encode(['success' => false, 'error' => $mensaje]); exit; }

function requiere_sesion() { if (session_status() !== PHP_SESSION_ACTIVE) session_start(); 
    if (!isset($_SESSION['id_usuario'])) responder_no_autorizado('No hay una sesión activa', 401); }

function requiere_admin() { requiere_sesion(); 
    if (!in_array((int)($_SESSION['id_rol'] ?? 0), [1, 2], true)) responder_no_autorizado(); }

function requiere_super_admin() { requiere_sesion(); 
    if ((int)($_SESSION['id_rol'] ?? 0) !== 1) responder_no_autorizado('Solo el super_admin puede realizar esta acción'); }

function puede_modificar_usuario($id_rol_objetivo) 
    { $rol_actual = (int)($_SESSION['id_rol'] ?? 0); $rol_objetivo = (int)$id_rol_objetivo; 
        if ($rol_actual === 1) return true; if ($rol_actual === 2 && $rol_objetivo === 1) return false; return $rol_actual === 2; }
?>
