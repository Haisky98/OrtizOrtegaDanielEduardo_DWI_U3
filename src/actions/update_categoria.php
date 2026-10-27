<?php
session_start();
require_once __DIR__ . '/../class/class_categorias.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
    exit();
}

$id_categoria = intval($_POST['id_categoria'] ?? 0);
$nombre       = trim($_POST['nombre'] ?? '');
$estatus      = intval($_POST['estatus'] ?? 1);

if ($id_categoria <= 0 || empty($nombre)) {
    header("Location: ../index.php?modulo=categorias&error=datos_invalidos");
    exit();
}

$categoriaObj = new class_cat_categorias();
$resultado = $categoriaObj->actualizar_categoria($id_categoria, $nombre, $estatus);

if ($resultado['bool']) {
    header("Location: ../index.php?modulo=categorias&status=update_exito");
} else {
    header("Location: ../index.php?modulo=categorias&error=db_error");
}
exit();