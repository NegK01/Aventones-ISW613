<?php
require_once __DIR__ . '/ride.php';
require_once __DIR__ . '/rideSQL.php';
require_once __DIR__ . '/../vehicles/vehicleSQL.php';


class rideController
{
    private $conn;
    private $rideSQL;
    private $vehicleSQL;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->rideSQL = new rideSQL($conn);
        $this->vehicleSQL = new vehicleSQL($conn);
    }

    public function insertRide()
    {
        // bloquear otros metodos
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Metodo no permitido']);
            return;
        }

        try {
            // Recolectar datos del ride
            $idUsuario = $_SESSION['user_id'] ?? null;
            $idVehiculo = $_POST['id_vehiculo'] ?? null;
            $nombre = trim($_POST['rideName'] ?? null);
            $origen = trim($_POST['origen'] ?? null);
            $destino = trim($_POST['destino'] ?? null);
            $fechaHora = $_POST['fecha_hora'] ?? null;
            $espacios = $_POST['asientos'] ?? null;
            $costo = $_POST['costoAsiento'] ?? null;
            $detalles = trim($_POST['detalles'] ?? null);
            $idEstado = 4; // Estado 'Activo'

            //validar datos 
            if (empty($idUsuario) || empty($idVehiculo) || $idVehiculo === 0 || empty($nombre) || empty($origen) || empty($destino) || empty($fechaHora) || empty($espacios) || empty($costo)) {
                throw new Exception('Todos los campos son obligatorios');
            }

            // Costo mayor a 0
            if (!is_numeric($costo) || floatval($costo) <= 0) {
                throw new Exception('El costo por espacio debe ser un numero mayor a 0');
            }

            // Asientos mayor a 0
            if (!is_numeric($espacios) || intval($espacios) <= 0) {
                throw new Exception('Los espacios disponibles deben ser un numero mayor a 0');
            }

            // Verificar que los espacios disponibles no excedan la capacidad del vehiculo original
            $capacidad = $this->vehicleSQL->obtenerCapacidadVehiculo($idVehiculo);
            $capacidadReal = $capacidad['asientos'] - 1; // Restar 1 para el conductor

            if ($capacidad && $espacios > $capacidadReal) {
                throw new Exception('Los espacios disponibles no pueden ser mayores a la capacidad real del vehiculo, rango disponible: (' . $capacidadReal . ' asientos)');
            }

            // Crear objeto Ride
            $ride = new Ride(
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

            // Insertar el ride en la base de datos
            $this->rideSQL->insertar($ride);
            echo json_encode([
                'success' => 'Ride creado exitosamente. Redirigiendo...'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error'   => $e->getMessage()
            ]);
        } finally {
            $this->conn->close();
        }
    }

    public function updateRide() {
        // bloquear otros metodos
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Metodo no permitido']);
            return;
        }

        try {
            // Recolectar datos del ride
            $rideId = $_POST['rideId'] ?? null;
            $idUsuario = $_SESSION['user_id'] ?? null;
            $idVehiculo = $_POST['id_vehiculo'] ?? null;
            $nombre = trim($_POST['rideName'] ?? null);
            $origen = trim($_POST['origen'] ?? null);
            $destino = trim($_POST['destino'] ?? null);
            $fechaHora = $_POST['fecha_hora'] ?? null;
            $espacios = $_POST['asientos'] ?? null;
            $costo = $_POST['costoAsiento'] ?? null;
            $detalles = trim($_POST['detalles'] ?? null);
            $idEstado = 4; // Estado 'Activo'

            //validar datos 
            if (empty($rideId)) {
                throw new Exception('ID del ride es requerido');
            }

            if (empty($idUsuario) || empty($idVehiculo) || $idVehiculo === 0 || empty($nombre) || empty($origen) || empty($destino) || empty($fechaHora) || empty($espacios) || empty($costo)) {
                throw new Exception('Todos los campos son obligatorios');
            }

            // Costo mayor a 0
            if (!is_numeric($costo) || floatval($costo) <= 0) {
                throw new Exception('El costo por espacio debe ser un numero mayor a 0');
            }

            // Asientos mayor a 0
            if (!is_numeric($espacios) || intval($espacios) <= 0) {
                throw new Exception('Los espacios disponibles deben ser un numero mayor a 0');
            }

            // Verificar que los espacios disponibles no excedan la capacidad del vehiculo original
            $capacidad = $this->vehicleSQL->obtenerCapacidadVehiculo($idVehiculo);
            $capacidadReal = $capacidad['asientos'] - 1; // Restar 1 para el conductor

            if ($capacidad && $espacios > $capacidadReal) {
                throw new Exception('Los espacios disponibles no pueden ser mayores a la capacidad real del vehiculo, rango disponible: (' . $capacidadReal . ' asientos)');
            }

            // Crear objeto Ride
            $ride = new Ride(
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

            // Actualizar el ride en la base de datos
            $this->rideSQL->actualizar($ride);
            echo json_encode([
                'success' => 'Ride editado exitosamente. Redirigiendo...'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error'   => $e->getMessage()
            ]);
        } finally {
            $this->conn->close();
        }
    }

    public function deleteRide() {
        // bloquear otros metodos
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Metodo no permitido']);
            return;
        }

        try {
            // Obtener id del ride
            $rideId = $_POST['rideId'] ?? null;

            if (empty($rideId)) {
                throw new Exception('ID de ride es requerido');
            }

            // Eliminar ride
            $this->rideSQL->eliminar($rideId);

            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error'   => $e->getMessage()
            ]);
        } finally {
            $this->conn->close();
        }
    }

    public function mostrarRides()
    {
        // Obtener el id del usuario desde la sesion global
        $userId = trim($_SESSION['user_id'] ?? null);

        if (empty($userId)) {
            throw new Exception('Usuario no autenticado');
        }

        try {
            $rides = $this->rideSQL->obtenerRidesPorIdUsuario($userId);
            echo json_encode([
                'success' => true,
                'rides'   => $rides
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error'   => $e->getMessage()
            ]);
        } finally {
            $this->conn->close();
        }
    }

    public function mostrarRide()
    {
        // bloquear otros metodos
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Metodo no permitido']);
            return;
        }

        $rideId = trim($_POST['rideId'] ?? '');

        if (empty($rideId)) {
            throw new Exception('ID del ride es requerido');
        }

        try {
            // Obtener los detalles del ride por ID
            $ride = $this->rideSQL->obtenerRidePorId($rideId);

            if (!$ride) {
                throw new Exception('Ride no encontrado');
            }

            // Aprovecharemos para enviar tambien todos los vehiculos del usuario para poblar el select de vehiculos en el formulario de edicion
            $userId = $_SESSION['user_id'] ?? null;
            if (empty($userId)) {
                throw new Exception('Usuario no autenticado');
            }
            $vehiculos = $this->vehicleSQL->obtenerVehiculosPorIdUsuario($userId);

            echo json_encode([
                'success' => true,
                'ride' => $ride,
                'vehicles' => $vehiculos
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error'   => $e->getMessage()
            ]);
        } finally {
            $this->conn->close();
        }
    }

    // Este metodo es para obtener los vehiculos del usuario y mostrarlos en el input de seleccion de vehiculos al momento de crear un ride
    public function mostrarVehiculos()
    {
        // Obtener el id del usuario desde la sesion global
        $userId = $_SESSION['user_id'] ?? null;

        if (empty($userId)) {
            throw new Exception('Usuario no autenticado');
        }

        try {
            // Obtener vehiculos del usuario
            $vehiculos = $this->vehicleSQL->obtenerVehiculosPorIdUsuario($userId);

            echo json_encode([
                'success' => true,
                'vehicles' => $vehiculos
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error'   => $e->getMessage()
            ]);
        } finally {
            $this->conn->close();
        }
    }
}
