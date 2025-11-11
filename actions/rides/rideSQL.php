<?php
class rideSQL
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function insertar(Ride $ride)
    {
        $idUsuario = $ride->getIdUsuario();
        $idVehiculo = $ride->getIdVehiculo();
        $nombre = $ride->getNombre();
        $origen = $ride->getOrigen();
        $destino = $ride->getDestino();
        $fechaHora = $ride->getFechaHora();
        $espacios = $ride->getAsientos();
        $costo = $ride->getCostoAsiento();
        $detalles = $ride->getDetalles();
        $idEstado = $ride->getIdEstado();

        $stmt = $this->conn->prepare("
            INSERT INTO rides 
            (id_usuario, id_vehiculo, nombre, origen, destino, fechaHora, asientos, costoAsiento, detalles, id_estado)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "iissssidsi",
            $idUsuario,
            $idVehiculo,
            $nombre,
            $origen,
            $destino,
            $fechaHora,
            $espacios,
            $costo,
            $detalles,
            $idEstado
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al registrar ride: " . $stmt->error);
        }

        $stmt->close();
    }

    public function actualizar(Ride $ride)
    {
        $idUsuario = $ride->getIdUsuario();
        $idVehiculo = $ride->getIdVehiculo();
        $nombre = $ride->getNombre();
        $origen = $ride->getOrigen();
        $destino = $ride->getDestino();
        $fechaHora = $ride->getFechaHora();
        $espacios = $ride->getAsientos();
        $costo = $ride->getCostoAsiento();
        $detalles = $ride->getDetalles();
        $idEstado = $ride->getIdEstado();
        $rideId = $ride->getIdRide();

        $stmt = $this->conn->prepare("
            UPDATE rides SET 
            id_usuario = ?, 
            id_vehiculo = ?, 
            nombre = ?, 
            origen = ?, 
            destino = ?, 
            fechaHora = ?, 
            asientos = ?, 
            costoAsiento = ?, 
            detalles = ?, 
            id_estado = ?
            WHERE id_ride = ?
        ");
        $stmt->bind_param(
            "iissssidsii",
            $idUsuario,
            $idVehiculo,
            $nombre,
            $origen,
            $destino,
            $fechaHora,
            $espacios,
            $costo,
            $detalles,
            $idEstado,
            $rideId
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al actualizar ride: " . $stmt->error);
        }

        $stmt->close();
    }

    public function eliminar($rideId)
    {
        // eliminar logicamente de la base de datos
        $stmt = $this->conn->prepare("UPDATE rides SET id_estado = 5 WHERE id_ride = ?");
        $stmt->bind_param("i", $rideId);

        if (!$stmt->execute()) {
            throw new Exception("Error al eliminar ride: " . $stmt->error);
        }

        $stmt->close();
    }

    public function obtenerRidesPorIdUsuario($id_usuario)
    {
        $stmt = $this->conn->prepare("SELECT r.*, DATE_FORMAT(r.fechaHora, '%Y-%m-%d %H:%i') AS fechaHoraFormateada, v.marca, v.modelo, v.anio FROM rides r JOIN vehiculos v ON r.id_vehiculo = v.id_vehiculo WHERE r.id_usuario = ? AND r.id_estado = 4");
        $stmt->bind_param("i", $id_usuario);
        
        if (!$stmt->execute()) {
            throw new Exception("Error al obtener rides: " . $stmt->error);
        }

        $result = $stmt->get_result();

        // Se ocupa el fetch all para obtener todos los registros como un arreglo asociativo, si se usa el fetch assoc solo devuelve una fila y las demas se pierden
        $rides = $result->fetch_all(MYSQLI_ASSOC) ?: [];

        $stmt->close();
        return $rides;
    }

    public function obtenerRidePorId($rideId)
    {
        $stmt = $this->conn->prepare("
            SELECT 
                r.*, u.fotografia, u.nombre AS nombreUsuario, u.apellido AS apellidoUsuario, DATE_FORMAT(r.fechaHora, '%Y-%m-%d %H:%i') AS fechaHoraFormateada, v.marca, v.modelo, v.anio, v.color
            FROM 
                rides r 
            JOIN 
                vehiculos v ON r.id_vehiculo = v.id_vehiculo
            JOIN 
                usuarios u ON r.id_usuario = u.id_usuario
            WHERE r.id_ride = ?
        ");

        $stmt->bind_param("i", $rideId);

        if (!$stmt->execute()) {
            throw new Exception("Error al obtener ride: " . $stmt->error);
        }

        $result = $stmt->get_result();

        $ride = $result->fetch_assoc() ?: null;

        $stmt->close();
        return $ride;
    }

    public function obtenerRidesFiltrados($origen, $destino)
    {

        //Se construye paso a paso la consulta sql para tomar en cuenta el caso que el usuario no busque con origen o destino

        //Creamos la consulta base sin condicionales
        $sql = "
            SELECT 
                r.*, DATE_FORMAT(r.fechaHora, '%Y-%m-%d %H:%i') AS fechaHoraFormateada, v.marca, v.modelo, v.anio, v.color
            FROM 
                rides r 
            JOIN 
                vehiculos v ON r.id_vehiculo = v.id_vehiculo
        ";

        if (!empty($origen) && !empty($destino)) {
            //En el caso de que el usuario busque con origen y destino
            $sql .= " WHERE r.origen = ? AND r.destino = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ss", $origen, $destino);

        } else {
            //Caso en que el usuario no busco algo en especifico
            $stmt = $this->conn->prepare($sql);
        }
        
        if (!$stmt->execute()) {
            throw new Exception("Error al obtener rides: " . $stmt->error);
        }

        $result = $stmt->get_result();

        // Se ocupa el fetch all para obtener todos los registros como un arreglo asociativo, si se usa el fetch assoc solo devuelve una fila y las demas se pierden
        $rides = $result->fetch_all(MYSQLI_ASSOC) ?: [];

        $stmt->close();
        return $rides;
    }
}
