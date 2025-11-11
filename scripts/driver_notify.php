<?php
require_once __DIR__ . '/../common/connection.php';
require_once '../actions/services/mailService.php';
require_once '../actions/auth/usuario.php';

$conn;
$mailService = new mailService();

if ($argc < 2) {
    echo "Usage: php driver_notify.php <minutes>\n";
    exit(1);
}

$minutes = $argv[1];
$reservas = obtenerReservas($conn, $minutes);

function obtenerReservas($conn, $minutes)
{
    $stmt = $conn->prepare("
        SELECT r.id_chofer, r.id_estado, u.correo 
        FROM 
            reservas r 
        JOIN 
            usuarios u ON r.id_chofer = u.id_usuario 
        WHERE 
            r.id_estado = 2 
        AND TIMESTAMPDIFF(MINUTE, r.fecha, NOW()) > ?;
    ");

    $stmt->bind_param(
        "i",
        $minutes
    );

    if (!$stmt->execute()) {
        echo "No se pudo obtener las reservas";
        exit(1);
    }

    $result = $stmt->get_result();
    $reservas = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();

    return $reservas;
}

if (!$reservas) {
    echo "No hay reservas con este limite de tiempo";
    exit(0);
}

foreach ($reservas as $reserva) {
    $mailService->sendNotificationMail($reserva['correo']);
}

$total = count($reservas);
echo "Se han enviado un total de $total emails correctamente";