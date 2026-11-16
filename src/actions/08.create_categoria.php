<?php
include_once('../class/09.class_autorizacion.php');
requiere_admin();
header('Content-Type: application/json; charset=utf-8');

include_once('../class/03.class_cat_categorias.php');
$objeto_categoria = new class_cat_categorias();

$nombre = trim($_POST['nombre'] ?? '');
$estatus = isset($_POST['estatus']) ? (int)$_POST['estatus'] : 1; // Por defecto 1

// Validar que el nombre no esté vacío
if ($nombre === '') {
    http_response_code(422);
    echo json_encode(['success' => false, 'error' => 'El nombre de la categoría es obligatorio']);
    exit;
}

// Ejecutar creación
$resultado = $objeto_categoria->create_categoria($nombre, $estatus);

if ($resultado === 1) {
    http_response_code(201); // Creado exitosamente
    echo json_encode([
        'success' => true,
        'message' => 'Categoría creada correctamente'
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'No se pudo crear la categoría. Es posible que ya exista una con el mismo nombre.'
    ]);
}
