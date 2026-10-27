<?php
require_once __DIR__ . '/../class/class_categorias.php';

$categoriaObj = new class_cat_categorias();
$resultado = $categoriaObj->obtener_categorias();

$lista_categorias = ($resultado['bool'] && !empty($resultado['data'])) ? $resultado['data'] : [];
?>