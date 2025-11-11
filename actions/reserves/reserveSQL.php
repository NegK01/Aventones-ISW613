<?php
class reserveSQL
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function insertar(reserve $reserve)
    {
        $id_ride = $reserve->getIdRide();
        $id_chofer = $reserve->getIdChofer();
        $id_cliente = $reserve->getIdCliente();
        $fecha = $reserve->getFecha();
        $id_estado = $reserve->getIdEstado();

        // TODO A Mau no le gusto que metiera la validacion de que no pueda hacer la misma reserva en SQL, tons en el siguente proyecto le pongo en codigo, el dice que le da igual pero que estaba incomodo que el index subiera, eso mero dijo. 10-11-2025 Lucas Lopez Rodriguez

        $stmt = $this->conn->prepare("
            INSERT INTO reservas 
            (id_ride, id_chofer, id_cliente, fecha, id_estado)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "iiisi",
            $id_ride,
            $id_chofer,
            $id_cliente,
            $fecha,
            $id_estado
        );

        try {
            $stmt->execute();

        } catch (mysqli_sql_exception $e) {
            // En el caso que sea un error por datos duplicados, para evitar que el usuario haga la misma reserva
            if ($stmt->errno === 1062) {
                throw new Exception("Ya se realizo la solicitud.");
            } else {
                throw new Exception("Error al registrar la reserva: " . $stmt->error);
            }
        }

        $stmt->close();
    }

    public function actualizar($reserveId, $reserveState)
    {

        $stmt = $this->conn->prepare('
            UPDATE reservas SET id_estado = ? WHERE id_reserva = ?
        ');

        $stmt->bind_param(
            "ii",
            $reserveState,
            $reserveId
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al cambiar el estado de la reserva: " . $stmt->error);
        }

        $stmt->close();
    }

    public function obtenerReservaPorIdUsuario($role, $idUser)
    {
        $sql = "
            SELECT 
                re.*, DATE_FORMAT(re.fecha, '%Y-%m-%d %H:%i') AS fechaReserva, ri.nombre AS nombreRide, ri.origen, ri.destino, u.nombre, u.apellido, v.marca, v.modelo, v.anio 
            FROM 
                reservas re 
            JOIN 
                rides ri ON re.id_ride = ri.id_ride 
            JOIN 
                vehiculos v ON ri.id_vehiculo = v.id_vehiculo 
        ";

        switch ($role) {
            case 2:
                // En el caso de ser un usuario chofer
                $sql .= "
                JOIN 
                    usuarios u ON re.id_cliente = u.id_usuario 
                WHERE re.id_chofer = ?
                ";
                
                break;

            case 3:
                // En el caso de ser un usuario cliente
                $sql .= "
                JOIN 
                    usuarios u ON re.id_chofer = u.id_usuario 
                WHERE re.id_cliente = ?
                ";

                break;
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idUser);

        if (!$stmt->execute()) {
            throw new Exception("Error al obtener las reservas: " . $stmt->error);
        }

        $result = $stmt->get_result();

        $reserves = $result->fetch_all(MYSQLI_ASSOC) ?: [];

        $stmt->close();
        return $reserves;
    }
}