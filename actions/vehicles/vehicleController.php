<?php
require_once __DIR__ . '/vehicle.php';
require_once __DIR__ . '/vehicleSQL.php';
require_once __DIR__ . '/../services/fileUploader.php';


class vehicleController
{
    private $conn;
    private $vehicleSQL;
    private $fileUploader;


    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->vehicleSQL = new vehicleSQL($conn);
        $this->fileUploader = new fileUploader('assets/vehiclePhotos');
    }

    public function insertVehicle()
    {
        // bloquear otros metodos
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Metodo no permitido']);
            return;
        }

        try {
            // Recolectar datos del vehiculo
            $idUser = $_SESSION['user_id'] ?? null;
            $brand = trim($_POST['vehicleBrand'] ?? '');
            $model = trim($_POST['vehicleModel'] ?? '');
            $year = trim($_POST['vehicleYear'] ?? '');
            $color = trim($_POST['vehicleColor'] ?? '');
            $licensePlate = trim($_POST['vehiclePlate'] ?? '');
            $seats = trim($_POST['vehicleSeats'] ?? '');
            $stateInput = strtolower(trim($_POST['vehicleStatus'] ?? 'activo')); // Por defecto Activo

            //Cambiar de texto a id el estado
            $estadoMap = [
                'activo' => 4,
                'inactivo' => 5,
            ];
            $stateId = $estadoMap[$stateInput] ?? 4; // Por defecto Activo (4) por si llega un texto no esperado

            // Validar datos
            if (empty($idUser) || empty($licensePlate) || empty($color) || empty($brand) || empty($model) || empty($year) || empty($seats)) {
                throw new Exception('Todos los campos son obligatorios');
            }

            // Asientos mayor a 0
            if (!is_numeric($seats) || intval($seats) <= 0) {
                throw new Exception('La capacidad debe ser un numero mayor a 0');
            }

            // Procesar imagen
            $photoPath = null;
            if (!empty($_FILES['vehiclePhoto']) && $_FILES['vehiclePhoto']['error'] === UPLOAD_ERR_OK) {
                $photoPath = $this->fileUploader->upload($_FILES['vehiclePhoto']);
            }

            // Crear objeto Vehicle
            $vehicle = new Vehicle(
                $idUser,
                $licensePlate,
                $color,
                $brand,
                $model,
                $year,
                $seats,
                $photoPath,
                $stateId
            );

            // Insertar vehiculo en la base de datos
            $this->vehicleSQL->insertar($vehicle);

            echo json_encode(['success' => 'Vehiculo registrado correctamente. Redirigiendo...']);
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

    public function eliminarVehiculo()
    {
        // bloquear otros metodos
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Metodo no permitido']);
            return;
        }

        try {
            // Obtener id del vehiculo
            $vehicleId = $_POST['vehicleId'] ?? null;

            if (empty($vehicleId)) {
                throw new Exception('ID de vehiculo es requerido');
            }

            // Eliminar vehiculo
            $this->vehicleSQL->eliminar($vehicleId);

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

    public function updateVehicle()
    {
        // bloquear otros metodos
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Metodo no permitido']);
            return;
        }

        try {
            // Recolectar datos del vehiculo
            $vehicleId = trim($_POST['vehicleId'] ?? '');
            $idUser = $_SESSION['user_id'] ?? null;
            $brand = trim($_POST['vehicleBrand'] ?? '');
            $model = trim($_POST['vehicleModel'] ?? '');
            $year = trim($_POST['vehicleYear'] ?? '');
            $color = trim($_POST['vehicleColor'] ?? '');
            $licensePlate = trim($_POST['vehiclePlate'] ?? '');
            $seats = trim($_POST['vehicleSeats'] ?? '');
            $stateInput = strtolower(trim($_POST['vehicleStatus'] ?? 'activo')); // Por defecto Activo

            //Cambiar de texto a id el estado
            $estadoMap = [
                'activo' => 4,
                'inactivo' => 5,
            ];
            $statusId = $estadoMap[$stateInput] ?? 4; // Por defecto Activo (4) por si llega un texto no esperado

            // Validar datos
            if (empty($vehicleId)) {
                throw new Exception('ID del vehiculo es requerido');
            }

            if (empty($idUser) || empty($licensePlate) || empty($color) || empty($brand) || empty($model) || empty($year) || empty($seats)) {
                throw new Exception('Todos los campos son obligatorios');
            }

            // Asientos mayor a 0
            if (!is_numeric($seats) || intval($seats) <= 0) {
                throw new Exception('La capacidad debe ser un numero mayor a 0');
            }

            // Procesar imagen
            $photoPath = null;
            if (!empty($_FILES['vehiclePhoto']) && $_FILES['vehiclePhoto']['error'] === UPLOAD_ERR_OK) {
                $photoPath = $this->fileUploader->upload($_FILES['vehiclePhoto']);
            }

            // Crear objeto Vehicle
            $vehicle = new Vehicle(
                $idUser,
                $licensePlate,
                $color,
                $brand,
                $model,
                $year,
                $seats,
                $photoPath,
                $statusId,
                $vehicleId
            );

            // Actualizar vehiculo en la base de datos
            $this->vehicleSQL->actualizar($vehicle);

            echo json_encode(['success' => 'Vehiculo editado correctamente. Redirigiendo...']);
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

    public function mostrarVehiculos()
    {
        // Obtener el id del usuario desde la sesion global
        $idUser = $_SESSION['user_id'] ?? null;

        try {
            if (empty($idUser)) {
                throw new Exception('Usuario no autenticado');
            }

            // Obtener vehiculos del usuario
            $vehiculos = $this->vehicleSQL->obtenerVehiculosPorIdUsuario($idUser);

            echo json_encode([
                'success'  => true,
                'vehicles' => $vehiculos,
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

    public function mostrarVehiculo()
    {
        // bloquear otros metodos
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Metodo no permitido']);
            return;
        }

        $vehicleId = trim($_POST['vehicleId'] ?? '');

        try {
            if (empty($vehicleId)) {
                throw new Exception('ID del vehiculo es requerido');
            }

            // Obtener los detalles del vehiculo por ID
            $vehiculo = $this->vehicleSQL->obtenerVehiculoPorId($vehicleId);

            if (!$vehiculo) {
                throw new Exception('Vehiculo no encontrado');
            }

            echo json_encode([
                'success' => true,
                'vehicle' => $vehiculo,
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
