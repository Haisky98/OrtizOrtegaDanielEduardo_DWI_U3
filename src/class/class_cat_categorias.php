<?php
require_once __DIR__ . '/class_db.php';

class class_cat_categorias extends class_db {

    // Obtener todas las categorías activas
    public function obtener_categorias() {
        $this->set_sql("SELECT id_categoria, nombre, estatus FROM cat_categorias WHERE estatus = 1");
        return json_decode($this->ejecutar_query(), true);
    }

    // Insertar una nueva categoría
    public function insertar_categoria($nombre) {
        $this->set_sql("INSERT INTO cat_categorias (nombre, estatus) VALUES (?, 1)");
        return json_decode($this->ejecutar_query([$nombre]), true);
    }

    // Actualizar una categoría existente
    public function actualizar_categoria($id_categoria, $nombre, $estatus) {
        $this->set_sql("UPDATE cat_categorias SET nombre = ?, estatus = ? WHERE id_categoria = ?");
        return json_decode($this->ejecutar_query([$nombre, $estatus, $id_categoria]), true);
    }
    
}
?>