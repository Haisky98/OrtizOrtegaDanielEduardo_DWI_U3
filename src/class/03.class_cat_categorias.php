<?php
include_once('00.class_db.php');

class class_cat_categorias extends class_db {

    function __construct()
    {
        parent::__construct();
    }

    function __destruct()
    {
        parent::__destruct();
    }

    // 1. CREATE: Crear una nueva categoría
    function create_categoria($nombre, $estatus = 1)
    {
        $sql = "INSERT INTO cat_categorias (nombre, estatus) VALUES (?, ?)";
        $this->set_sql($sql);

        $params = [$nombre, $estatus];

        $json_result = $this->ejecutar_query($params);
        $result = json_decode($json_result, true);

        return (is_array($result) && isset($result['bool']) && $result['bool'] === true) ? 1 : 0;
    }

    // 2. READ: Obtener todas las categorías (o filtrar por estatus si lo deseas)
    function get_categorias()
    {
        $sql = "SELECT id_categoria, nombre, estatus FROM cat_categorias";
        $this->set_sql($sql);

        $json_result = $this->ejecutar_query([]);
        $result = json_decode($json_result, true);

        if (!is_array($result) || !isset($result['bool']) || $result['bool'] !== true || empty($result['data'])) {
            return [];
        }

        $lista = [];
        foreach ($result['data'] as $renglon) {
            $obj = new stdClass();
            $obj->id_categoria = $renglon['id_categoria'];
            $obj->nombre = $renglon['nombre'];
            $obj->estatus = $renglon['estatus'];

            $lista[] = $obj;
        }

        return $lista;
    }

    // 2.1 READ BY ID: Obtener una categoría específica por su ID
    function get_categoria_by_id($id_categoria)
    {
        $sql = "SELECT id_categoria, nombre, estatus FROM cat_categorias WHERE id_categoria = ?";
        $this->set_sql($sql);

        $params = [$id_categoria];
        $json_result = $this->ejecutar_query($params);
        $result = json_decode($json_result, true);

        if (!is_array($result) || !isset($result['bool']) || $result['bool'] !== true || empty($result['data'])) {
            return null;
        }

        $renglon = $result['data'][0];
        $obj = new stdClass();
        $obj->id_categoria = $renglon['id_categoria'];
        $obj->nombre = $renglon['nombre'];
        $obj->estatus = $renglon['estatus'];

        return $obj;
    }

    // 3. UPDATE: Actualizar una categoría existente
    function update_categoria($id_categoria, $nombre, $estatus)
    {
        $sql = "UPDATE cat_categorias SET nombre = ?, estatus = ? WHERE id_categoria = ?";
        $this->set_sql($sql);

        $params = [$nombre, $estatus, $id_categoria];

        $json_result = $this->ejecutar_query($params);
        $result = json_decode($json_result, true);

        return (is_array($result) && isset($result['bool']) && $result['bool'] === true) ? 1 : 0;
    }

}
?>