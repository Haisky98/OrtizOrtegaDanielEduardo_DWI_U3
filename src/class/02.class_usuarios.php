<?php
include_once('00.class_db.php');

class class_usuarios extends class_db {

    function __construct()
    {
        parent::__construct();
    }

    function __destruct()
    {
        parent::__destruct();
    }

    //Create Usuario*******************************************************************
    function create_usuario($nombre, $email, $password)
    {
        $sql = "INSERT INTO usuarios(
                    nombre,
                    email,
                    password,
                    id_rol
                ) VALUES (?, ?, ?, ?)";

        $this->set_sql($sql);

        $params = [
            $nombre,
            $email,
            $password,
            3
        ];

        $json_result = $this->ejecutar_query($params);
        $result = json_decode($json_result, true);

        return (is_array($result) && isset($result['bool']) && $result['bool'] === true) ? 1 : 0;
    }

    //Read Usuarios*******************************************************************************
    function get_all_usuarios()
    {
        $sql = "SELECT * FROM usuarios";
        $this->set_sql($sql);

        $json_result = $this->ejecutar_query([]);
        $result = json_decode($json_result, true);

        if (!$result['bool'] || count($result['data']) == 0) {
            return null;
        }

        $lista = [];
        foreach ($result['data'] as $renglon) {
            $obj = new stdClass();
            $obj->id_usuario = $renglon['id_usuario'];
            $obj->nombre = $renglon['nombre'];
            $obj->email = $renglon['email'];
            $obj->password = $renglon['password'];
            $obj->id_rol = $renglon['id_rol'];
            $obj->estatus = $renglon['estatus'];
            $obj->domicilio = $renglon['domicilio'] ?? '';

            $lista[] = $obj;
        }

        return $lista;
    }
    
    //esta funcion es para mostrar los datos del usuario en perfil
    function get_usuario_by_id($id_usuario)
    {

        $sql = "SELECT * FROM usuarios WHERE id_usuario = ?";
        $this->set_sql($sql);

        $params = [$id_usuario];

        // 2. Pasar directamente $params sin anidar con corchetes extra
        $json_result = $this->ejecutar_query($params);
        $result = json_decode($json_result, true);

        if (!$result['bool'] || count($result['data']) == 0) {
            return null;
        }

        $lista = [];
        foreach ($result['data'] as $renglon) {
            $obj = new stdClass();
            $obj->id_usuario = $renglon['id_usuario'];
            $obj->nombre = $renglon['nombre'] ?? ''; // Agregado por si acaso necesitas el nombre
            $obj->email = $renglon['email'];
            $obj->password = $renglon['password'];
            $obj->id_rol = $renglon['id_rol'];
            $obj->estatus = $renglon['estatus'] ?? 1;
            $obj->domicilio = $renglon['domicilio'] ?? '';

            $lista[] = $obj;
        }

        return $lista;
    }

    // Función para loguear verificando estatus y contraseña hasheada
    function get_usuario($email, $password)
    {
        // 1. Buscamos al usuario solo por su email
        $sql = "SELECT id_usuario, nombre, email, password, id_rol, estatus FROM usuarios WHERE email = ?";
        $this->set_sql($sql);

        $params = [$email];
        $json_result = $this->ejecutar_query($params);
        $result = json_decode($json_result, true);

        // 2. Validar si el usuario existe
        if (!is_array($result) || !isset($result['bool']) || $result['bool'] !== true || empty($result['data'])) {
            return "not_found"; // El correo no está registrado
        }

        $usuario = $result['data'][0];

        // 3. Verificar la contraseña ingresada contra el hash seguro
        if (password_verify($password, $usuario['password'])) {
            
            // 4. Validar si está inactivo (estatus == 0)
            if (isset($usuario['estatus']) && (int)$usuario['estatus'] === 0) {
                return "inactive"; // Cuenta inactiva
            }

            // ¡Todo OK, usuario activo y contraseña correcta! Devolvemos el objeto
            $obj = new stdClass();
            $obj->id_usuario = $usuario['id_usuario'];
            $obj->nombre = $usuario['nombre'];
            $obj->email = $usuario['email'];
            $obj->id_rol = $usuario['id_rol'];
            $obj->estatus = $usuario['estatus'];
            $obj->domicilio = $usuario['domicilio'] ?? '';

            return $obj; 
        }

        // Contraseña incorrecta
        return "wrong_password";
    }

    // Update Usuario**************************************************************************************************
    function update_usuario($id_usuario, $nombre, $email, $password = null, $id_rol = null, $estatus = null, $domicilio = '')
    {
        // Construimos la consulta base
        // Si se proporciona un nuevo password, lo actualizamos; si no, mantenemos el actual
        if (!empty($password)) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE usuarios SET nombre = ?, email = ?, password = ?, id_rol = ?, estatus = ?, domicilio = ? WHERE id_usuario = ?";
            $params = [$nombre, $email, $password_hash, $id_rol, $estatus, $domicilio, $id_usuario];
        } else {
            // Si no se envía contraseña, no la sobreescribimos
            $sql = "UPDATE usuarios SET nombre = ?, email = ?, id_rol = ?, estatus = ?, domicilio = ? WHERE id_usuario = ?";
            $params = [$nombre, $email, $id_rol, $estatus, $domicilio, $id_usuario];
        }

        $this->set_sql($sql);

        $json_result = $this->ejecutar_query($params);
        $result = json_decode($json_result, true);

        // Retorna 1 si se actualizó correctamente, 0 en caso contrario
        return (is_array($result) && isset($result['bool']) && $result['bool'] === true) ? 1 : 0;
    }

    // Delete Usuario (Borrado lógico cambiando estatus a 0)
    function delete_usuario($id_usuario)
    {
        $sql = "UPDATE usuarios SET estatus = 0 WHERE id_usuario = ?";
        $this->set_sql($sql);

        $params = [$id_usuario];

        $json_result = $this->ejecutar_query($params);
        $result = json_decode($json_result, true);

        // Retorna 1 si se desactivó/eliminó correctamente, 0 en caso contrario
        return (is_array($result) && isset($result['bool']) && $result['bool'] === true) ? 1 : 0;
    }

}
?>
