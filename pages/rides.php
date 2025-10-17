<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventones - Rides</title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/utilities.css">
    <link rel="stylesheet" href="../css/components/header.css">
    <link rel="stylesheet" href="../css/components/buttons.css">
    <link rel="stylesheet" href="../css/components/forms.css">
    <link rel="stylesheet" href="../css/components/tables.css">
    <link rel="stylesheet" href="../css/components/cards.css">
    <link rel="stylesheet" href="../css/components/badges.css">
</head>

<body>
    <div class="app-container">
        <?php
        $activePage = 'rides';
        include '../components/header.php';
        ?>
        <main class="main-content">
            <div class="section">
                <div class="section-header">
                    <h2 class="section-title">Gestión de Rides</h2>
                </div>
                <div class="section-content">
                    <div class="form-row">
                        <div class="form-column">
                            <input type="text" class="form-input" placeholder="Buscar rides...">
                        </div>
                        <div class="form-column text-right">
                            <button class="btn btn-primary">Crear Nuevo Ride</button>
                        </div>
                    </div>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Nombre del Ride</th>
                                    <th>Origen</th>
                                    <th>Destino</th>
                                    <th>Fecha/Hora</th>
                                    <th>Costo</th>
                                    <th>Asientos</th>
                                    <th>Vehículo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Viaje a la Universidad</td>
                                    <td>Cumbayá</td>
                                    <td>USFQ</td>
                                    <td>18/05/2025 08:00</td>
                                    <td>$2.50</td>
                                    <td>3</td>
                                    <td>Toyota Corolla (2020)</td>
                                    <td>
                                        <div class="table-actions">
                                            <button class="btn btn-secondary">Editar</button>
                                            <button class="btn btn-secondary">Eliminar</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Viaje de regreso a casa</td>
                                    <td>USFQ</td>
                                    <td>Cumbayá</td>
                                    <td>18/05/2025 17:00</td>
                                    <td>$2.50</td>
                                    <td>4</td>
                                    <td>Toyota Corolla (2020)</td>
                                    <td>
                                        <div class="table-actions">
                                            <button class="btn btn-secondary">Editar</button>
                                            <button class="btn btn-secondary">Eliminar</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Viaje al aeropuerto</td>
                                    <td>Centro Norte</td>
                                    <td>Aeropuerto Mariscal Sucre</td>
                                    <td>20/05/2025 10:00</td>
                                    <td>$5.00</td>
                                    <td>2</td>
                                    <td>Honda Civic (2022)</td>
                                    <td>
                                        <div class="table-actions">
                                            <button class="btn btn-secondary">Editar</button>
                                            <button class="btn btn-secondary">Eliminar</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>