<?php
require_once __DIR__ . '/class_db.php';

class class_cat_roles extends class_db {

    // Obtener todos los roles activos
    public function obtener_roles() {
        $this->set_sql("SELECT id_rol, nombre, estatus FROM cat_roles WHERE estatus = 1");
        return json_decode($this->ejecutar_query(), true);
    }

    // Insertar un nuevo rol (para uso del super_admin)
    public function insertar_rol($nombre) {
        $this->set_sql("INSERT INTO cat_roles (nombre, estatus) VALUES (?, 1)");
        return json_decode($this->ejecutar_query([$nombre]), true);
    }
}
?>