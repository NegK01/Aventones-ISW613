<?php
header('Content-Type: application/json'); // importante para fetch
// Require de una vez para no realizar multiples conexiones 
// DIR para encontrar connection.php de donde sea que sea que se llame
require_once __DIR__ . '/../common/connection.php';

if (!$conn) {
    echo json_encode(['error' => 'Conexion a base de datos no disponible.']);
    exit;
}

// Obtener parametros de la URL
$controllerName = $_GET['controller'] ?? '';
$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? null;

// Mapeo de los nombres de las clases
$allowedControllers = [
    'auth'         => 'authController',
    'rides'        => 'rideController',
    'vehicles'     => 'vehicleController',
    'reservations' => 'reservationController',
    'profile'      => 'profileController'
];

// Validar si el controlador dado esta en nuestro map
if (!isset($allowedControllers[$controllerName])) {
    http_response_code(400);
    echo json_encode(['error' => 'Controlador no válido']);
    exit;
}

$className = $allowedControllers[$controllerName];
$controllerFile = __DIR__ . "/{$controllerName}/{$className}.php";

// Buscamos el archivo controlador
if (!file_exists($controllerFile)) {
    http_response_code(500);
    echo json_encode(['error' => "Archivo del controlador no encontrado: {$controllerFile}"]);
    exit;
}

require_once $controllerFile;

// Instanciar controlador y enviar parametro de conexion
$controller = new $className($conn);

// Validar metodo
if (!method_exists($controller, $action)) {
    http_response_code(400);
    echo json_encode(['error' => 'Acción no válida']);
    exit;
}

// Validar si tiene un id y luego ejecutar la accion
try {
    if ($id !== null) {
        $controller->$action($id);
    } else {
        $controller->$action();
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Excepcion de action: ' . $e->getMessage()]);
}
