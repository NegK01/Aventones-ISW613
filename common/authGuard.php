<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// si no hay user_id, manda al index (este guardia solo se encuentra en las paginas privadas)
if (empty($_SESSION['user_id'])) {
    header('Location: /Proyecto-1/pages/login.php');
    exit();
} 

// array de paginas permitidas solo para admin
$adminPages = [
    '/Proyecto-1/pages/adminDashboard.php',
    '/Proyecto-1/pages/adminCreate.php',
];

// array de paginas permitidas solo para conductores
$driverPages = [
    '/Proyecto-1/index.php',
    '/Proyecto-1/pages/rides.php',
    '/Proyecto-1/pages/rideForm.php',
    '/Proyecto-1/pages/rideDetails.php',
    '/Proyecto-1/pages/vehicles.php',
    '/Proyecto-1/pages/vehicleForm.php',
    '/Proyecto-1/pages/reservations.php',
    '/Proyecto-1/pages/profile.php',
];

// array de paginas permitidas solo para pasajeros
$passengerPages = [
    '/Proyecto-1/index.php',
    '/Proyecto-1/pages/reservations.php',
    '/Proyecto-1/pages/profile.php',
    '/Proyecto-1/pages/rideDetails.php',
];

// arreglo de paginas permitidas segun el rol del usuario
$allowedPagesByRole = [
    1 => $adminPages,      // Admin
    2 => $driverPages,     // Conductor
    3 => $passengerPages  // Pasajero
];

// obtiene la ubicacion actual de la pagina despues del dominio
$currentPath = $_SERVER['REQUEST_URI'];

// redireccionar al admin a adminDashboard si intenta acceder a una pagina no permitida, los demas al index
$userRole = $_SESSION['idRole'] ?? null;
if (isset($allowedPagesByRole[$userRole])) {
    $allowedPages = $allowedPagesByRole[$userRole];
    if (!in_array($currentPath, $allowedPages)) {
        if ($userRole === 1) {
            header('Location: /Proyecto-1/pages/adminDashboard.php');
        } else {
            header('Location: /Proyecto-1/index.php');
        }
        exit();
    }
} else {
    // si el rol no es reconocido, redirigir al index
    header('Location: /Proyecto-1/index.php');
    exit();
}