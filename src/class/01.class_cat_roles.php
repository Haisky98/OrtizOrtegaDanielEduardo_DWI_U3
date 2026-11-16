<?php
include_once('00.class_db.php');

class class_cat_roles extends class_db {

    function __construct()
    {
        parent::__construct();
    }

    function __destruct()
    {
        parent::__destruct();
    }

    // Read Roles
    function get_roles()
    {
        $sql = "SELECT * FROM cat_roles WHERE estatus = 1 ";
        $this->set_sql($sql);

        $json_result = $this->ejecutar_query([]);
        $result = json_decode($json_result, true);

        if (!$result['bool'] || count($result['data']) == 0) {
            return null;
        }

        $lista = [];
        foreach ($result['data'] as $renglon) {
            $obj = new stdClass();
            $obj->id_rol = $renglon['id_rol'];
            $obj->nombre = $renglon['nombre'];
            $obj->estatus = $renglon['estatus'];
            $lista[] = $obj;
        }

        return $lista;
    }
}
?>