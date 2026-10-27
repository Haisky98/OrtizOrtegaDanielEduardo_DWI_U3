<?php
session_start();
require_once __DIR__ . '/../class/class_productos.php';

$id_producto = intval($_POST['id_producto'] ?? $_GET['id_producto'] ?? 0);

if ($id_producto <= 0) {
    header("Location: ../index.php?modulo=principal&error=id_invalido");
    exit();
}

$productoObj = new class_productos();
$resultado = $productoObj->eliminar_producto($id_producto);

if ($resultado['bool']) {
    header("Location: ../index.php?modulo=principal&status=delete_exito");
} else {
    header("Location: ../index.php?modulo=principal&error=db_error");
}
exit();