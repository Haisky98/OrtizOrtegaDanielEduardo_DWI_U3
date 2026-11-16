<?php
include_once('00.class_db.php');

class class_pedidos extends class_db {

    function __construct()
    {
        parent::__construct();
    }

    function __destruct()
    {
        parent::__destruct();
    }

    // 1. CREATE: Crear pedido maestro y sus detalles usando transacciones
    function create_pedido($id_usuario, $total, $productos_array)
    {
        // Iniciamos la transacción con el método de tu class_db
        $this->iniciar_transaccion();

        try {
            // 1. Insertar la cabecera del pedido
            $sql_pedido = "INSERT INTO pedidos (id_usuario, total, estatus) VALUES (?, ?, 1)";
            $this->set_sql($sql_pedido);
            
            $json_res_pedido = $this->ejecutar_query([$id_usuario, $total]);
            $res_pedido = json_decode($json_res_pedido, true);

            // Validamos que se haya insertado y extraemos el ID usando "id_insertado" que devuelve class_db
            if (!is_array($res_pedido) || !isset($res_pedido['bool']) || $res_pedido['bool'] !== true || !isset($res_pedido['id_insertado'])) {
                $this->rollback();
                return 0; 
            }

            $id_pedido = $res_pedido['id_insertado'];

            // 2. Insertar cada producto en la tabla detalle_pedidos
            foreach ($productos_array as $item) {
                $id_producto = $item['id_producto'];
                $cantidad = $item['cantidad'];
                $precio_unitario = $item['precio'];

                $sql_detalle = "INSERT INTO detalle_pedidos (id_pedido, id_producto, cantidad, precio_unitario) VALUES (?, ?, ?, ?)";
                $this->set_sql($sql_detalle);
                
                $json_res_detalle = $this->ejecutar_query([$id_pedido, $id_producto, $cantidad, $precio_unitario]);
                $res_det = json_decode($json_res_detalle, true);

                // Si algún detalle falla, hacemos rollback para no dejar pedidos huérfanos
                if (!is_array($res_det) || !isset($res_det['bool']) || $res_det['bool'] !== true) {
                    $this->rollback();
                    return 0;
                }
            }

            // Si todo salió perfecto, confirmamos la transacción
            $this->commit();
            return 1;

        } catch (Exception $e) {
            // Si ocurre cualquier excepción, revertimos cambios
            $this->rollback();
            return 0;
        }
    }

    // 2. READ: Obtener todos los pedidos con su usuario
    function get_pedidos($id_usuario = null)
    {
        $sql = "SELECT p.id_pedido, p.id_usuario, u.nombre AS usuario_nombre, p.total, p.estatus, p.fecha_pedido
                FROM pedidos p INNER JOIN usuarios u ON p.id_usuario = u.id_usuario";
        $params = [];
        if ($id_usuario !== null) { $sql .= " WHERE p.id_usuario = ?"; $params[] = $id_usuario; }
        $this->set_sql($sql);

        $json_result = $this->ejecutar_query($params);
        $result = json_decode($json_result, true);

        if (!is_array($result) || !isset($result['bool']) || $result['bool'] !== true || empty($result['data'])) {
            return [];
        }

        $lista = [];
        foreach ($result['data'] as $renglon) {
            $obj = new stdClass();
            $obj->id_pedido = $renglon['id_pedido'];
            $obj->id_usuario = $renglon['id_usuario'];
            $obj->usuario_nombre = $renglon['usuario_nombre'];
            $obj->total = $renglon['total'];
            $obj->estatus = $renglon['estatus'];
            $obj->fecha_pedido = $renglon['fecha_pedido'];

            $lista[] = $obj;
        }

        return $lista;
    }

    // 2.1 READ BY ID: Obtener un pedido y los productos que contiene
    function get_pedido_with_detalles($id_pedido, $id_usuario = null)
    {
        // 1. Datos generales del pedido
        $sql_pedido = "SELECT p.id_pedido, p.id_usuario, u.nombre AS usuario_nombre, u.domicilio, p.total, p.estatus, p.fecha_pedido
                       FROM pedidos p
                       INNER JOIN usuarios u ON p.id_usuario = u.id_usuario
                       WHERE p.id_pedido = ?";
        $params_pedido = [$id_pedido];
        if ($id_usuario !== null) { $sql_pedido .= " AND p.id_usuario = ?"; $params_pedido[] = $id_usuario; }
        $this->set_sql($sql_pedido);
        $res_ped = json_decode($this->ejecutar_query($params_pedido), true);

        if (empty($res_ped['data'])) return null;

        $pedido = $res_ped['data'][0];

        // 2. Productos de ese pedido
        $sql_detalles = "SELECT dp.id_detalle, dp.id_producto, pr.nombre AS producto_nombre, dp.cantidad, dp.precio_unitario 
                         FROM detalle_pedidos dp
                         INNER JOIN productos pr ON dp.id_producto = pr.id_producto
                         WHERE dp.id_pedido = ?";
        $this->set_sql($sql_detalles);
        $res_det = json_decode($this->ejecutar_query([$id_pedido]), true);

        $obj = new stdClass();
        $obj->id_pedido = $pedido['id_pedido'];
        $obj->id_usuario = $pedido['id_usuario'];
        $obj->usuario_nombre = $pedido['usuario_nombre'];
        $obj->domicilio = $pedido['domicilio'] ?? '';
        $obj->total = $pedido['total'];
        $obj->estatus = $pedido['estatus'];
        $obj->fecha_pedido = $pedido['fecha_pedido'];
        $obj->productos = $res_det['data'] ?? [];

        return $obj;
    }

    // 3. UPDATE ESTATUS: Cambiar estado del pedido (ej. 1: Pendiente, 2: Com... / Entregado)
    function update_estatus_pedido($id_pedido, $estatus)
    {
        $this->iniciar_transaccion();
        try {
            $this->set_sql("SELECT estatus FROM pedidos WHERE id_pedido = ?");
            $pedido = json_decode($this->ejecutar_query([$id_pedido]), true);
            if (empty($pedido['data'])) { $this->rollback(); return 0; }

            // El stock se descuenta una sola vez al pasar de pendiente a pagado/enviado.
            if ((int)$estatus === 2 && (int)$pedido['data'][0]['estatus'] === 1) {
                $this->set_sql("SELECT id_producto, cantidad FROM detalle_pedidos WHERE id_pedido = ?");
                $detalles = json_decode($this->ejecutar_query([$id_pedido]), true);
                foreach (($detalles['data'] ?? []) as $detalle) {
                    $this->set_sql("UPDATE productos SET stock = stock - ? WHERE id_producto = ? AND stock >= ?");
                    $resultado_stock = json_decode($this->ejecutar_query([$detalle['cantidad'], $detalle['id_producto'], $detalle['cantidad']]), true);
                    if (!isset($resultado_stock['filas_afectadas']) || (int)$resultado_stock['filas_afectadas'] !== 1) { $this->rollback(); return -1; }
                }
            }

            $this->set_sql("UPDATE pedidos SET estatus = ? WHERE id_pedido = ?");
            $resultado = json_decode($this->ejecutar_query([$estatus, $id_pedido]), true);
            if (!isset($resultado['bool']) || $resultado['bool'] !== true) { $this->rollback(); return 0; }
            $this->commit();
            return 1;
        } catch (Exception $e) { $this->rollback(); return 0; }
    }
}
?>
