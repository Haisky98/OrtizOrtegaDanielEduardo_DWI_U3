<?php
include_once('00.class_db.php');

class class_productos extends class_db {

    function __construct()
    {
        parent::__construct();
    }

    function __destruct()
    {
        parent::__destruct();
    }

    // 1. CREATE: Crear un nuevo producto
    function create_producto($nombre, $descripcion, $precio, $stock, $imagen, $id_categoria, $estatus = 1)
    {
        // Si no se envía imagen, asignamos la ruta por defecto que marca tu esquema
        if (empty($imagen)) {
            $imagen = 'assets/media/products/default.png';
        }

        $sql = "INSERT INTO productos (nombre, descripcion, precio, stock, imagen, id_categoria, estatus) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $this->set_sql($sql);

        $params = [$nombre, $descripcion, $precio, $stock, $imagen, $id_categoria, $estatus];

        $json_result = $this->ejecutar_query($params);
        $result = json_decode($json_result, true);

        return (is_array($result) && isset($result['bool']) && $result['bool'] === true) ? 1 : 0;
    }

    // 2. READ: Obtener todos los productos (puedes hacer un JOIN con categorías si lo requieres más adelante)
    function get_productos()
    {
        $sql = "SELECT p.id_producto, p.nombre, p.descripcion, p.precio, p.stock, p.imagen, p.id_categoria, c.nombre AS categoria_nombre, p.estatus 
                FROM productos p
                LEFT JOIN cat_categorias c ON p.id_categoria = c.id_categoria";
        $this->set_sql($sql);

        $json_result = $this->ejecutar_query([]);
        $result = json_decode($json_result, true);

        if (!is_array($result) || !isset($result['bool']) || $result['bool'] !== true || empty($result['data'])) {
            return [];
        }

        $lista = [];
        foreach ($result['data'] as $renglon) {
            $obj = new stdClass();
            $obj->id_producto = $renglon['id_producto'];
            $obj->nombre = $renglon['nombre'];
            $obj->descripcion = $renglon['descripcion'];
            $obj->precio = $renglon['precio'];
            $obj->stock = $renglon['stock'];
            $obj->imagen = $renglon['imagen'];
            $obj->id_categoria = $renglon['id_categoria'];
            $obj->categoria_nombre = $renglon['categoria_nombre'];
            $obj->estatus = $renglon['estatus'];

            $lista[] = $obj;
        }

        return $lista;
    }

    // 2.1 READ BY ID: Obtener un producto específico por su ID
    function get_producto_by_id($id_producto)
    {
        $sql = "SELECT p.id_producto, p.nombre, p.descripcion, p.precio, p.stock, p.imagen, p.id_categoria, c.nombre AS categoria_nombre, p.estatus
                FROM productos p
                LEFT JOIN cat_categorias c ON p.id_categoria = c.id_categoria
                WHERE p.id_producto = ?";
        $this->set_sql($sql);

        $params = [$id_producto];
        $json_result = $this->ejecutar_query($params);
        $result = json_decode($json_result, true);

        if (!is_array($result) || !isset($result['bool']) || $result['bool'] !== true || empty($result['data'])) {
            return null;
        }

        $renglon = $result['data'][0];
        $obj = new stdClass();
        $obj->id_producto = $renglon['id_producto'];
        $obj->nombre = $renglon['nombre'];
        $obj->descripcion = $renglon['descripcion'];
        $obj->precio = $renglon['precio'];
        $obj->stock = $renglon['stock'];
        $obj->imagen = $renglon['imagen'];
        $obj->id_categoria = $renglon['id_categoria'];
        $obj->categoria_nombre = $renglon['categoria_nombre'];
        $obj->estatus = $renglon['estatus'];

        return $obj;
    }

    // 3. UPDATE: Actualizar un producto existente
    function update_producto($id_producto, $nombre, $descripcion, $precio, $stock, $imagen, $id_categoria, $estatus)
    {
        // Si no mandan nueva imagen, conservamos la que ya tiene consultándola o manejándola en el action. 
        // Aquí asumimos que se recibe el valor correcto de la imagen.
        $sql = "UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, stock = ?, imagen = ?, id_categoria = ?, estatus = ? WHERE id_producto = ?";
        $this->set_sql($sql);

        $params = [$nombre, $descripcion, $precio, $stock, $imagen, $id_categoria, $estatus, $id_producto];

        $json_result = $this->ejecutar_query($params);
        $result = json_decode($json_result, true);

        return (is_array($result) && isset($result['bool']) && $result['bool'] === true) ? 1 : 0;
    }

    // 4. DELETE (Borrado lógico): Cambiar estatus a 0
    function delete_producto($id_producto)
    {
        $sql = "UPDATE productos SET estatus = 0 WHERE id_producto = ?";
        $this->set_sql($sql);

        $params = [$id_producto];

        $json_result = $this->ejecutar_query($params);
        $result = json_decode($json_result, true);

        return (is_array($result) && isset($result['bool']) && $result['bool'] === true) ? 1 : 0;
    }

}
?>
