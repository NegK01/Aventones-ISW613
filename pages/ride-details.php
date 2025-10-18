<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventones - Detalles del Ride</title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/utilities.css">
    <link rel="stylesheet" href="../css/components/header.css">
    <link rel="stylesheet" href="../css/components/buttons.css">
    <link rel="stylesheet" href="../css/components/tables.css">
    <link rel="stylesheet" href="../css/components/cards.css">
    <link rel="stylesheet" href="../css/pages/ride-details.css">
</head>

<body>
    <div class="app-container">
        <?php
        $activePage = 'details';
        include 'components/header.php';
        ?>
        <main class="main-content">
            <div class="section">
                <div class="section-header">
                    <h2 class="section-title">Detalles del Ride</h2>
                </div>
                <div class="section-content">
                    <div class="ride-details-container">
                        <div class="driver-info">
                            <div class="driver-photo">
                                <img src="#" alt="Driver Photo">
                            </div>
                            <h3>Driver Info</h3>
                            <p class="driver-name">Nombre Completo Conductor</p>
                            <p class="driver-rating">⭐⭐⭐⭐☆</p>
                            <p class="driver-trips">Viajes realizados: 123</p>
                        </div>
                        <div class="ride-info">
                            <h2 class="ride-title">Nombre del Ride</h2>
                            <h3>Información general del viaje</h3>
                            <table class="data-table ride-general-table">
                                <tbody>
                                    <tr>
                                        <th>Origen:</th>
                                        <td>Cumbayá</td>
                                    </tr>
                                    <tr>
                                        <th>Destino:</th>
                                        <td>USFQ</td>
                                    </tr>
                                    <tr>
                                        <th>Fecha/Hora:</th>
                                        <td>18/05/2025 08:00</td>
                                    </tr>
                                    <tr>
                                        <th>Costo por asiento:</th>
                                        <td>$2.50</td>
                                    </tr>
                                    <tr>
                                        <th>Asientos disponibles / totales:</th>
                                        <td>3/4</td>
                                    </tr>
                                    <tr>
                                        <th>Descripción:</th>
                                        <td>Viaje diario a la universidad pasando por el parque central.</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="vehicle-info">
                                <h3>Información del vehículo</h3>
                                <table class="data-table vehicle-info-table">
                                    <tbody>
                                        <tr>
                                            <th>Marca:</th>
                                            <td>Toyota</td>
                                        </tr>
                                        <tr>
                                            <th>Modelo:</th>
                                            <td>Corolla</td>
                                        </tr>
                                        <tr>
                                            <th>Año:</th>
                                            <td>2020</td>
                                        </tr>
                                        <tr>
                                            <th>Color:</th>
                                            <td>Gris</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="action-buttons-container">
                        <a href="../index.php" class="btn btn-secondary back-btn">Regresar</a>
                        <button class="btn btn-primary reserve-btn">Reservar asiento</button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>