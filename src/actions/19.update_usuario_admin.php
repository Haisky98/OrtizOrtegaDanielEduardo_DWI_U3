<?php
include_once('../class/09.class_autorizacion.php'); requiere_super_admin();
header('Content-Type: application/json; charset=utf-8');
include_once('../class/02.class_usuarios.php');
$id = (int)($_POST['id_usuario'] ?? 0); $nombre = trim($_POST['nombre'] ?? ''); $email = trim($_POST['email'] ?? ''); $rol = (int)($_POST['id_rol'] ?? 0); $estatus = (int)($_POST['estatus'] ?? 1); $domicilio = trim($_POST['domicilio'] ?? ''); $password = trim($_POST['password'] ?? '');
if (!$id || $nombre === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || !in_array($rol, [1,2,3], true)) { http_response_code(422); echo json_encode(['success'=>false,'error'=>'Datos de usuario no válidos']); exit; }
$usuario = new class_usuarios(); $resultado = $usuario->update_usuario($id, $nombre, $email, $password, $rol, $estatus, $domicilio);
echo json_encode($resultado === 1 ? ['success'=>true,'message'=>'Usuario actualizado correctamente'] : ['success'=>false,'error'=>'No se pudo actualizar el usuario']);
?>
