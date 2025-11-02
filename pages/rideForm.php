<?php
require_once __DIR__ . '/../common/authGuard.php';

$rideId = $_POST['rideId'] ?? null;
$isEditMode = !empty($rideId);

$pageTitle = $isEditMode ? 'Editar Ride' : 'Crear Ride';
$submitLabel = $isEditMode ? 'Actualizar Ride' : 'Publicar Ride';
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
        $activePage = 'rides';
        include 'components/header.php';
        ?>
        <main class="main-content">
            <div class="section">
                <div class="section-header form-header">
                    <h2 class="section-title"><?php echo $pageTitle ?></h2>
                    <div id="form-message" class="message"></div>
                </div>
                <div class="section-content">
                    <form id="ride-form" class="form" method="post" action="#">
                        <?php if ($isEditMode) : ?>
                            <input type="hidden" name="rideId" value="<?php echo $rideId ?>">
                        <?php endif; ?>
                        <div class="form-row">
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="ride-name">Nombre del ride</label>
                                    <input type="text" id="ride-name" name="rideName" class="form-input" placeholder="Viaje a la Universidad">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="ride-origin">Lugar de salida</label>
                                    <input type="text" id="ride-origin" name="origen" class="form-input" placeholder="Punto de partida">
                                </div>
                            </div>
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="ride-destination">Lugar de llegada</label>
                                    <input type="text" id="ride-destination" name="destino" class="form-input" placeholder="Punto de llegada">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="ride-datetime">Fecha y hora</label>
                                    <input type="datetime-local" id="ride-datetime" name="fecha_hora" class="form-input"
                                        min="<?php echo date('Y-m-d\TH:i'); ?>"
                                        max="<?php echo date('Y-m-d\TH:i', strtotime('+1 year')); ?>">
                                </div>
                            </div>
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="ride-price">Costo por espacio (USD)</label>
                                    <input type="number" step="0.01" min="0" id="ride-price" name="costoAsiento" class="form-input" placeholder="0.00">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="id_vehiculo">Vehiculo</label>
                                    <select id="id_vehiculo" name="id_vehiculo" class="form-select">
                                        <option value="0" disabled selected>Selecciona un vehiculo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="ride-seats">Espacios disponibles</label>
                                    <input type="number" min="1" id="ride-seats" name="asientos" class="form-input" placeholder="4">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-column">

                            </div>
                            <div class="form-column"></div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="ride-notes">Notas para los pasajeros</label>
                            <textarea id="ride-notes" name="detalles" class="form-input" rows="4" maxlength="250" placeholder="Comparte detalles importantes del viaje"></textarea>
                        </div>
                        <div class="form-group text-right">
                            <a href="rides.php" class="btn btn-secondary btn-none-decoration">Cancelar</a>
                            <button id="submit-ride" type="submit" class="btn btn-primary"><?php echo $submitLabel ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="../js/mostrarMensaje.js"></script>
    <?php if ($isEditMode) : ?>
        <script src="../js/rides/rideUpdate.js"></script>
    <?php else : ?>
        <script src="../js/rides/rideCreate.js"></script>
    <?php endif; ?>
</body>

</html>