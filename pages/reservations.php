<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventones - Reservas</title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/utilities.css">
    <link rel="stylesheet" href="../css/components/header.css">
    <link rel="stylesheet" href="../css/components/buttons.css">
    <link rel="stylesheet" href="../css/components/tables.css">
    <link rel="stylesheet" href="../css/components/tabs.css">
    <link rel="stylesheet" href="../css/components/badges.css">
</head>

<body>
    <div class="app-container">
        <?php
        $activePage = 'reservations';
        include '../components/header.php';
        ?>
        <main class="main-content">
            <div class="section">
                <div class="section-header">
                    <h2 class="section-title">Mis Reservas</h2>
                </div>
                <div class="section-content">
                    <div class="tabs">
                        <button class="tab active" data-tab="active-reservations">Activas</button>
                        <button class="tab" data-tab="past-reservations">Pasadas</button>
                    </div>
                    <div id="active-reservations" class="tab-content active">
                        <div class="table-container">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Ride</th>
                                        <th>Fecha/Hora</th>
                                        <th>Origen</th>
                                        <th>Destino</th>
                                        <th>Chofer</th>
                                        <th>Vehículo</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Viaje a la Universidad</td>
                                        <td>18/05/2025 08:00</td>
                                        <td>Cumbayá</td>
                                        <td>USFQ</td>
                                        <td>Juan Pérez</td>
                                        <td>Toyota Corolla (2020)</td>
                                        <td><span class="badge green-badge">Confirmado</span></td>
                                        <td>
                                            <div class="table-actions">
                                                <a href="ride-details.html" class="btn btn-secondary">Detalles</a>
                                                <button class="btn btn-secondary">Cancelar</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Viaje de regreso a casa</td>
                                        <td>18/05/2025 17:00</td>
                                        <td>USFQ</td>
                                        <td>Cumbayá</td>
                                        <td>Juan Pérez</td>
                                        <td>Toyota Corolla (2020)</td>
                                        <td><span class="badge yellow-badge">Pendiente</span></td>
                                        <td>
                                            <div class="table-actions">
                                                <a href="ride-details.html" class="btn btn-secondary">Detalles</a>
                                                <button class="btn btn-secondary">Cancelar</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="past-reservations" class="tab-content">
                        <div class="table-container">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Ride</th>
                                        <th>Fecha/Hora</th>
                                        <th>Origen</th>
                                        <th>Destino</th>
                                        <th>Chofer</th>
                                        <th>Vehículo</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Viaje a la Universidad</td>
                                        <td>11/05/2025 08:00</td>
                                        <td>Cumbayá</td>
                                        <td>USFQ</td>
                                        <td>Juan Pérez</td>
                                        <td>Toyota Corolla (2020)</td>
                                        <td><span class="badge green-badge">Completado</span></td>
                                        <td>
                                            <div class="table-actions">
                                                <a href="ride-details.html" class="btn btn-secondary">Detalles</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Viaje de regreso a casa</td>
                                        <td>11/05/2025 17:00</td>
                                        <td>USFQ</td>
                                        <td>Cumbayá</td>
                                        <td>Juan Pérez</td>
                                        <td>Toyota Corolla (2020)</td>
                                        <td><span class="badge green-badge">Completado</span></td>
                                        <td>
                                            <div class="table-actions">
                                                <a href="ride-details.html" class="btn btn-secondary">Detalles</a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>