<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventones - Vehículos</title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/utilities.css">
    <link rel="stylesheet" href="../css/components/header.css">
    <link rel="stylesheet" href="../css/components/buttons.css">
    <link rel="stylesheet" href="../css/components/forms.css">
    <link rel="stylesheet" href="../css/components/tables.css">
    <link rel="stylesheet" href="../css/components/badges.css">
</head>

<body>
    <div class="app-container">
        <?php
        $activePage = 'vehicles';
        include '../components/header.php';
        ?>
        <main class="main-content">
            <div class="section">
                <div class="section-header">
                    <h2 class="section-title">Mis Vehículos</h2>
                </div>
                <div class="section-content">
                    <div class="form-row">
                        <div class="form-column">
                            <input type="text" class="form-input" placeholder="Buscar vehículos...">
                        </div>
                        <div class="form-column text-right">
                            <button class="btn btn-primary">Agregar Vehículo</button>
                        </div>
                    </div>
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Año</th>
                                    <th>Color</th>
                                    <th>Placa</th>
                                    <th>Capacidad</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Toyota</td>
                                    <td>Corolla</td>
                                    <td>2020</td>
                                    <td>Gris</td>
                                    <td>ABC-1234</td>
                                    <td>5</td>
                                    <td><span class="badge green-badge">Activo</span></td>
                                    <td>
                                        <div class="table-actions">
                                            <button class="btn btn-secondary">Editar</button>
                                            <button class="btn btn-secondary">Eliminar</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Honda</td>
                                    <td>Civic</td>
                                    <td>2022</td>
                                    <td>Azul</td>
                                    <td>XYZ-5678</td>
                                    <td>5</td>
                                    <td><span class="badge green-badge">Activo</span></td>
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