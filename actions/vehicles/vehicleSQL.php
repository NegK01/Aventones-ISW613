<?php
class vehicleSQL
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function insertar(Vehicle $vehicle)
    {
        $idUsuario = $vehicle->getIdUsuario();
        $placa = $vehicle->getPlaca();
        $color = $vehicle->getColor();
        $marca = $vehicle->getMarca();
        $modelo = $vehicle->getModelo();
        $anio = $vehicle->getAnio();
        $asientos = $vehicle->getAsientos();
        $fotografia = $vehicle->getFotografia();
        $idEstado = $vehicle->getIdEstado();

        $stmt = $this->conn->prepare("
            INSERT INTO vehiculos 
            (id_usuario, placa, color, marca, modelo, anio, asientos, fotografia, id_estado)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "isssssisi",
            $idUsuario,
            $placa,
            $color,
            $marca,
            $modelo,
            $anio,
            $asientos,
            $fotografia,
            $idEstado
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al registrar vehiculo: " . $stmt->error);
        }

        $stmt->close();
    }

    public function actualizar(Vehicle $vehicle)
    {
        $idUsuario = $vehicle->getIdUsuario();
        $placa = $vehicle->getPlaca();
        $color = $vehicle->getColor();
        $marca = $vehicle->getMarca();
        $modelo = $vehicle->getModelo();
        $anio = $vehicle->getAnio();
        $asientos = $vehicle->getAsientos();
        $fotografia = $vehicle->getFotografia();
        $idEstado = $vehicle->getIdEstado();
        $vehicleId = $vehicle->getIdVehiculo();

        $stmt = $this->conn->prepare("
            UPDATE vehiculos SET
            id_usuario = ?,
            placa = ?,
            color = ?,
            marca = ?,
            modelo = ?,
            anio = ?,
            asientos = ?,
            fotografia = ?,
            id_estado = ?
            WHERE id_vehiculo = ?
        ");

        $stmt->bind_param(
            "isssssisii",
            $idUsuario,
            $placa,
            $color,
            $marca,
            $modelo,
            $anio,
            $asientos,
            $fotografia,
            $idEstado,
            $vehicleId
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al editar vehiculo: " . $stmt->error);
        }

        $stmt->close();
    }

    public function eliminar($vehicleId)
    {
        // eliminar logicamente cambiando el estado a inactivo
        $stmt = $this->conn->prepare("
            UPDATE vehiculos SET id_estado = 5 WHERE id_vehiculo = ?
        ");

        $stmt->bind_param("i", $vehicleId);

        if (!$stmt->execute()) {
            throw new Exception("Error al eliminar vehiculo: " . $stmt->error);
        }

        $stmt->close();
    }

    public function obtenerVehiculosPorIdUsuario($userId)
    {
        $stmt = $this->conn->prepare("
        SELECT * FROM vehiculos WHERE id_usuario = ? ORDER BY id_estado ASC, id_vehiculo ASC
        ");

        $stmt->bind_param("i", $userId);

        if (!$stmt->execute()) {
            throw new Exception("Error al obtener vehiculos: " . $stmt->error);
        }

        $result = $stmt->get_result();

        if (!$result) {
            throw new Exception("Error al procesar resultados: " . $stmt->error);
        }

        // Se ocupa el fetch all para obtener todos los registros como un arreglo asociativo, si se usa el fetch assoc solo devuelve una fila y las demas se pierden
        $vehiculos = $result->fetch_all(MYSQLI_ASSOC) ?: [];

        $stmt->close();

        return $vehiculos;
    }

    public function obtenerVehiculoPorId($vehicleId)
    {
        $stmt = $this->conn->prepare("
        SELECT * FROM vehiculos WHERE id_vehiculo = ? 
        ");

        $stmt->bind_param("i", $vehicleId);

        if (!$stmt->execute()) {
            throw new Exception("Error al obtener vehiculo: " . $stmt->error);
        }

        $result = $stmt->get_result();

        if (!$result) {
            throw new Exception("Error al procesar resultados: " . $stmt->error);
        }

        $vehiculo = $result->fetch_assoc() ?: null;

        $stmt->close();

        return $vehiculo;
    }

    public function obtenerCapacidadVehiculo($vehicleId)
    {
        $stmt = $this->conn->prepare("
        SELECT asientos FROM vehiculos WHERE id_vehiculo = ? 
        ");

        $stmt->bind_param("i", $vehicleId);

        if (!$stmt->execute()) {
            throw new Exception("Error al obtener capacidad del vehiculo: " . $stmt->error);
        }

        $result = $stmt->get_result();

        if (!$result) {
            throw new Exception("Error al procesar resultados: " . $stmt->error);
        }

        $vehiculo = $result->fetch_assoc();

        $stmt->close();
        return $vehiculo;
    }
}
