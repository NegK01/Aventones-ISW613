<?php
require_once __DIR__ . '/reserve.php';
require_once __DIR__ . '/reserveSQL.php';
require_once __DIR__ . '/../rides/rideSQL.php';

class reserveController
{
    private $conn;
    private $reserveSQL;
    private $rideSQL;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->reserveSQL = new reserveSQL($conn);
        $this->rideSQL = new rideSQL($conn);
    }

    public function insertReserve()
    {
        // bloquear otros metodos
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Metodo no permitido']);
            return;
        }

        try {

            // Recolectar datos de la reserva
            $idCliente = $_SESSION['user_id'] ?? '';
            $idRole = $_SESSION['idRole'] ?? '';
            $idRide = trim($_POST['rideId'] ?? '');

            // Validar si exiten los datos necesarios
            if (empty($idRide) || empty($idCliente)) {
                throw new Exception('Hubo un problema al conseguir la informacion');
            }

            // Obtener los detalles del ride por ID
            $ride = $this->rideSQL->obtenerRidePorId($idRide);

            $idChofer = $ride['id_usuario'];

            // Validar datos
            if ($idRole == 2) {
                throw new Exception('Un conductor no puede solicitar rides');
            }

            if ($idCliente == $idChofer) {
                throw new Exception('No puede solicitar sus propios rides');
            }

            // Se consigue la fecha actual de la reserva realizada
            date_default_timezone_set('America/Costa_Rica');
            $fecha = date("Y-m-d H:i");

            // Crear objeto Reserve
            $reserve = new reserve(
                $idRide,
                $idChofer,
                $idCliente,
                $fecha
            );

            // Insertar vehiculo en la base de datos
            $this->reserveSQL->insertar($reserve);

            echo json_encode(['success' => 'Reserva del ride hecha correctamente']);

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

    public function updateReserve()
    {
        // bloquear otros metodos
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Metodo no permitido']);
            return;
        }

        try {
            // Recolectar datos de la reserva
            $reserveId = trim($_POST['reserveId'] ?? '');
            $reserveState = trim($_POST['reserveState'] ?? '');

            // Validar datos
            if (empty($reserveId ) || empty($reserveState)) {
                throw new Exception('Hubo un problema al conseguir la informacion');
            }

            // Actualizar vehiculo en la base de datos
            $this->reserveSQL->actualizar($reserveId, $reserveState);

            echo json_encode(['success' => 'Solicitud lograda correctamente']);

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

    public function mostrarReservas()
    {
        // Obtener el id del usuario desde la sesion global
        $idUser = $_SESSION['user_id'] ?? '';
        $userRole = $_SESSION['idRole'] ?? '';

        try {
            if (empty($idUser) || empty($userRole)) {
                throw new Exception('Usuario no autenticado');
            }

            // Obtener las reservas del usuario
            $reserves = $this->reserveSQL->obtenerReservaPorIdUsuario($userRole, $idUser);

            echo json_encode([
                'success'  => true,
                'reserves' => $reserves
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