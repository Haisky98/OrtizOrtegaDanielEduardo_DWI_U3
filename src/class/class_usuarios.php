<?php
require_once __DIR__ . '/class_db.php';

class class_usuarios extends class_db {

    // Registrar un nuevo usuario (con contraseña encriptada)
    public function registrar($nombre, $email, $password_hash, $id_rol) {
        $this->set_sql("INSERT INTO usuarios (nombre, email, password, id_rol, estatus) VALUES (?, ?, ?, ?, 1)");
        return json_decode($this->ejecutar_query([$nombre, $email, $password_hash, $id_rol]), true);
    }

    // Buscar usuario por correo electrónico (para el Login)
    public function obtener_por_email($email) {
        $this->set_sql("id_usuario, nombre, email, password, id_rol, estatus FROM usuarios WHERE email = ?");
        // Nota: Ajustamos el SELECT completo asegurando la sintaxis
        $this->set_sql("SELECT id_usuario, nombre, email, password, id_rol, estatus FROM usuarios WHERE email = ?");
        return json_decode($this->ejecutar_query([$email]), true);
    }

    // Listar todos los usuarios
    public function listar_usuarios() {
        $this->set_sql("SELECT u.id_usuario, u.nombre, u.email, r.nombre AS rol, u.estatus, u.created_at 
                        FROM usuarios u 
                        JOIN cat_roles r ON u.id_rol = r.id_rol");
        return json_decode($this->ejecutar_query(), true);
    }

    // Actualizar un usuario existente
    public function actualizar_usuario($id_usuario, $nombre, $email, $id_rol, $estatus) {
        $this->set_sql("UPDATE usuarios SET nombre = ?, email = ?, id_rol = ?, estatus = ? WHERE id_usuario = ?");
        return json_decode($this->ejecutar_query([$nombre, $email, $id_rol, $estatus, $id_usuario]), true);
    }
}
?>