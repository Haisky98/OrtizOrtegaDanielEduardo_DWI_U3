<?php
session_start();
require_once __DIR__ . '/../class/class_categorias.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
    exit();
}

$nombre = trim($_POST['nombre'] ?? '');

if (empty($nombre)) {
    header("Location: ../index.php?modulo=nueva_categoria&error=campos_incompletos");
    exit();
}

$categoriaObj = new class_cat_categorias();
$resultado = $categoriaObj->insertar_categoria($nombre);

if ($resultado['bool']) {
    header("Location: ../index.php?modulo=categorias&status=insert_exito");
} else {
    header("Location: ../index.php?modulo=nueva_categoria&error=db_error");
}
exit();