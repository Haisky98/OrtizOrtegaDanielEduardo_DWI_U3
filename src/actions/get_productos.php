<?php
require_once __DIR__ . '/../class/class_productos.php';

$productoObj = new class_productos();
$resultado = $productoObj->listar_productos();

$lista_productos = ($resultado['bool'] && !empty($resultado['data'])) ? $resultado['data'] : [];
?>