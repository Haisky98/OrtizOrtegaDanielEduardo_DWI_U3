<?php
include_once('../class/09.class_autorizacion.php');
requiere_admin();
include_once('../class/02.class_usuarios.php');
$objeto_read_usuarios = new class_usuarios();

$read_usuarios = $objeto_read_usuarios->get_all_usuarios();
unset($objeto_read_usuarios);

echo json_encode(['data' =>$read_usuarios ?: []]);

?>
