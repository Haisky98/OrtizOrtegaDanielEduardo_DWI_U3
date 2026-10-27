<?php
require_once __DIR__ . '/class_db.php';

class class_productos extends class_db {

    // Listar todos los productos activos (incluyendo imagen)
    public function listar_productos() {
        $this->set_sql("SELECT p.id_producto, p.nombre, p.descripcion, p.precio, p.stock, p.imagen,
                               c.id_categoria, c.nombre AS categoria, p.estatus 
                        FROM productos p 
                        JOIN cat_categorias c ON p.id_categoria = c.id_categoria 
                        WHERE p.estatus = 1");
        return json_decode($this->ejecutar_query(), true);
    }

    // Insertar producto con imagen
    public function insertar_producto($nombre, $descripcion, $precio, $stock, $id_categoria, $imagen) {
        $this->set_sql("INSERT INTO productos (nombre, descripcion, precio, stock, id_categoria, imagen, estatus) VALUES (?, ?, ?, ?, ?, ?, 1)");
        return json_decode($this->ejecutar_query([$nombre, $descripcion, $precio, $stock, $id_categoria, $imagen]), true);
    }

    // Actualizar producto con imagen
    public function actualizar_producto($id_producto, $nombre, $descripcion, $precio, $stock, $id_categoria, $imagen, $estatus) {
        $this->set_sql("UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, stock = ?, id_categoria = ?, imagen = ?, estatus = ? WHERE id_producto = ?");
        return json_decode($this->ejecutar_query([$nombre, $descripcion, $precio, $stock, $id_categoria, $imagen, $estatus, $id_producto]), true);
    }

    // Eliminar un producto por su ID
    public function eliminar_producto($id_producto) {
        $this->set_sql("UPDATE productos SET estatus = 0 WHERE id_producto = ?");
        return json_decode($this->ejecutar_query([$id_producto]), true);
    }
    
}
?>