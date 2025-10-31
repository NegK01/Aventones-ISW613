<?php
require_once __DIR__ . '/../common/authGuard.php';

$vehicleId = $_POST['vehicleId'] ?? null;
$isEditMode = !empty($vehicleId);

$statusOptions = [
    'activo' => 'Activo',
    'inactivo' => 'Inactivo',
];

$pageTitle = $isEditMode ? 'Editar Vehiculo' : 'Agregar Vehiculo';
$submitLabel = $isEditMode ? 'Actualizar Vehiculo' : 'Guardar Vehiculo';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventones - <?php echo $pageTitle ?></title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/utilities.css">
    <link rel="stylesheet" href="../css/components/header.css">
    <link rel="stylesheet" href="../css/components/buttons.css">
    <link rel="stylesheet" href="../css/components/forms.css">
</head>

<body>
    <div class="app-container">
        <?php
        $activePage = 'vehicles';
        include 'components/header.php';
        ?>
        <main class="main-content">
            <div class="section">
                <div class="section-header form-header">
                    <h2 class="section-title"><?php echo $pageTitle ?></h2>
                    <div id="form-message" class="message"></div>
                    <img id="vehicle-image" src="" alt="Imagen representativa de un vehiculo" width="150" class="hidden" style="margin-left: auto;">
                </div>
                <div class="section-content">
                    <form id="vehicle-form" class="form" enctype="multipart/form-data">
                        <?php if ($isEditMode) : ?>
                            <input type="hidden" name="vehicleId" value="<?php echo $vehicleId ?>">
                        <?php endif; ?>
                        <div class="form-row">
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="vehicle-brand">Marca</label>
                                    <input type="text" id="vehicle-brand" name="vehicleBrand" class="form-input" placeholder="Toyota">
                                </div>
                            </div>
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="vehicle-model">Modelo</label>
                                    <input type="text" id="vehicle-model" name="vehicleModel" class="form-input" placeholder="Corolla">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="vehicle-year">Año</label>
                                    <input type="number" id="vehicle-year" name="vehicleYear" class="form-input" min="1990" max="2099" placeholder="2024">
                                </div>
                            </div>
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="vehicle-color">Color</label>
                                    <input type="text" id="vehicle-color" name="vehicleColor" class="form-input" placeholder="Gris">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="vehicle-plate">Placa</label>
                                    <input type="text" id="vehicle-plate" name="vehiclePlate" class="form-input" placeholder="ABC-1234">
                                </div>
                            </div>
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="vehicle-capacity">Capacidad</label>
                                    <input type="number" id="vehicle-capacity" name="vehicleSeats" class="form-input" min="1" placeholder="4">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="vehicle-photo">Fotografia del vehiculo</label>
                                    <input type="file" id="vehicle-photo" name="vehiclePhoto" class="form-input" accept=".jpg, .jpeg, .png">
                                </div>
                            </div>
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="vehicle-status">Estado</label>
                                    <select id="vehicle-status" name="vehicleStatus" class="form-select">
                                        <?php foreach ($statusOptions as $statusValue => $statusLabel) : ?>
                                            <option value="<?php echo $statusValue ?>">
                                                <?php echo $statusLabel ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <a href="vehicles.php" class="btn btn-secondary btn-none-decoration">Cancelar</a>
                            <button id="submit-form-btn" type="submit" class="btn btn-primary"><?php echo $submitLabel ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="../js/mostrarMensaje.js"></script>
    <script src="../js/vehicles/mostrarFotoVehiculo.js"></script>
    <?php if ($isEditMode) : ?>
        <script src="../js/vehicles/vehicleUpdate.js"></script>
    <?php else : ?>
        <script src="../js/vehicles/vehicleCreate.js"></script>
    <?php endif; ?>
</body>

</html>