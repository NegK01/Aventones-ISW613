<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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

// Aciones publicas que pueden hacer cualquier usuario sin tener valores seteados en su sessionid
// controlador => ['accion/metodo/funcion del controlador']
$publicActions = [
    'auth' => ['login', 'register', 'verifyAccount', 'logout']
];

// Validar si el controlador dado esta en nuestro map
if (!isset($allowedControllers[$controllerName])) {
    http_response_code(400);
    echo json_encode(['error' => 'Controlador no valido']);
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
    echo json_encode(['error' => 'Accion no valida']);
    exit;
}

$isPublicAction = isset($publicActions[$controllerName]) && in_array($action, $publicActions[$controllerName], true);

if (!$isPublicAction && empty($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Sesion expirada']);
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
