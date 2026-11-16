<?php
include_once('../class/09.class_autorizacion.php');
requiere_admin();
include_once('../class/01.class_cat_roles.php');
$objeto_read_roles = new class_cat_roles();

$read_roles = $objeto_read_roles->get_roles();
unset($objeto_read_roles);

echo json_encode(['data' =>$read_roles ?: []]);

?>
