<?php
session_start();

header('Content-Type: application/json; charset=utf-8');

include_once('../class/03.class_cat_categorias.php');
$objeto_categoria = new class_cat_categorias();


$id_categoria = $_REQUEST['id_categoria'] ?? null;

if ($id_categoria) {
    $categoria = $objeto_categoria->get_categoria_by_id($id_categoria);
    if ($categoria) {
        http_response_code(200);
        echo json_encode(['success' => true, 'data' => $categoria]);
    } else {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Categoría no encontrada']);
    }
} else {
    $categorias = $objeto_categoria->get_categorias();
    http_response_code(200);
    echo json_encode(['success' => true, 'data' => $categorias]);
}