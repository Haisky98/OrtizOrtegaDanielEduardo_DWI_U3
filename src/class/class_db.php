<?php
date_default_timezone_set('America/Mexico_City');

if (class_exists('class_db') != true) {
    class class_db
    {
        public $db_conn;
        public $db_name;
        public $db_query;

        // Base de Datos (Configurado para Docker)
        public function __construct()
        {
            // Parámetros definidos en tu docker-compose.yml
            $host = 'db';
            $user = 'mi_usuario';
            $passwd = 'mi_password';
            $db = 'proyecto_dwi';

            $this->set_db($host, $user, $passwd, $db);
        }

        public function __destruct()
        {
            $this->close_db();
        }

        public function set_db($host, $user, $passwd, $db)
        {
            if (!isset($this->db_conn)) {
                $this->db_conn = mysqli_connect($host, $user, $passwd, $db);
                $this->db_name = $db;
                if ($this->db_conn) {
                    $this->db_conn->set_charset("utf8mb4");
                }
            }
        }

        public function close_db()
        {
            if (isset($this->db_conn)) {
                mysqli_kill($this->db_conn, $this->db_conn->thread_id);
                mysqli_close($this->db_conn);
            }
        }

        public function set_sql($sql)
        {
            $this->db_query = $sql;
        }

        public function ejecutar_query($params = [])
        {
            if (!$this->db_conn) {
                return json_encode([
                    "bool" => false,
                    "error" => "No hay conexión a la base de datos."
                ]);
            }

            mysqli_set_charset($this->db_conn, "utf8mb4"); // Asegurar codificación correcta

            // Verificar si es una consulta válida
            if (preg_match('/^\s*(INSERT|UPDATE|DELETE|SELECT|SHOW|DESCRIBE|EXPLAIN)\s/i', $this->db_query)) {

                // Preparar la consulta para evitar SQL Injection
                $stmt = $this->db_conn->prepare($this->db_query);

                if ($stmt === false) {
                    return json_encode([
                        "bool" => false,
                        "error" => "Error al preparar la consulta: " . mysqli_error($this->db_conn)
                    ]);
                }

                // Verifica que $params no esté vacío antes de bind_param
                if (!empty($params)) {
                    $tipos = str_repeat("s", count($params)); // Asumimos que todos los valores son strings
                    $stmt->bind_param($tipos, ...$params);
                }

                // Ejecutar la consulta
                if (!$stmt->execute()) {
                    return json_encode([
                        "bool" => false,
                        "error" => "Error al ejecutar consulta: " . $stmt->error
                    ]);
                }

                // Para los casos de INSERT
                if (preg_match('/^\s*INSERT\s/i', $this->db_query)) {
                    return json_encode([
                        "bool" => true,
                        "id_insertado" => $this->db_conn->insert_id
                    ]);
                }

                // Para UPDATE y DELETE
                if (preg_match('/^\s*(UPDATE|DELETE)\s/i', $this->db_query)) {
                    return json_encode([
                        "bool" => true,
                        "filas_afectadas" => $stmt->affected_rows
                    ]);
                }

                // Para SELECT, SHOW, DESCRIBE, EXPLAIN
                if (preg_match('/^\s*(SELECT|SHOW|DESCRIBE|EXPLAIN)\s/i', $this->db_query)) {
                    $result = $stmt->get_result();
                    $data = [];
                    while ($row = mysqli_fetch_assoc($result)) {
                        $data[] = $row;
                    }
                    return json_encode([
                        "bool" => true,
                        "data" => $data
                    ], JSON_UNESCAPED_UNICODE); // Elemental para caracteres especiales
                }

                return json_encode(["bool" => true]);
            }

            return json_encode([
                "bool" => false,
                "error" => "Consulta no válida"
            ]);
        }

        public function throw_ex($error)
        {
            throw new Exception($error);
        }

        public function iniciar_transaccion()
        {
            mysqli_begin_transaction($this->db_conn);
        }

        public function commit()
        {
            mysqli_commit($this->db_conn);
        }

        public function rollback()
        {
            mysqli_rollback($this->db_conn);
        }

        public function get_conexion()
        {
            return $this->db_conn;
        }
    }
}
?>