<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventones - Perfil</title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/utilities.css">
    <link rel="stylesheet" href="../css/components/header.css">
    <link rel="stylesheet" href="../css/components/buttons.css">
    <link rel="stylesheet" href="../css/components/forms.css">
    <link rel="stylesheet" href="../css/sections/profile.css">
</head>

<body>
    <div class="app-container">
        <?php
        $activePage = 'profile';
        include 'components/header.php';
        ?>
        <main class="main-content">
            <div class="section">
                <div class="section-header">
                    <h2 class="section-title">Mi Perfil</h2>
                </div>
                <div class="profile-header">
                    <div class="profile-image">
                        <div class="profile-image-placeholder">JD</div>
                    </div>
                    <div>
                        <h3>Juan Doe</h3>
                        <p>Chofer</p>
                    </div>
                </div>
                <div class="section-content">
                    <form class="form">
                        <div class="form-row">
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="profile-firstname">Nombre</label>
                                    <input type="text" id="profile-firstname" class="form-input" value="Juan">
                                </div>
                            </div>
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="profile-lastname">Apellido</label>
                                    <input type="text" id="profile-lastname" class="form-input" value="Doe">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="profile-id">Cédula</label>
                                    <input type="text" id="profile-id" class="form-input" value="1712345678" disabled>
                                </div>
                            </div>
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="profile-birthdate">Fecha de nacimiento</label>
                                    <input type="date" id="profile-birthdate" class="form-input" value="1990-01-01">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="profile-email">Correo electrónico</label>
                                    <input type="email" id="profile-email" class="form-input" value="juan.doe@ejemplo.com">
                                </div>
                            </div>
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="profile-phone">Teléfono</label>
                                    <input type="tel" id="profile-phone" class="form-input" value="0991234567">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="profile-photo">Foto</label>
                            <input type="file" id="profile-photo" class="form-input">
                        </div>
                        <hr style="margin: var(--spacing-lg) 0; border-color: var(--color-border);">
                        <h3 style="margin-bottom: var(--spacing-md);">Cambiar contraseña</h3>
                        <div class="form-row">
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="profile-current-password">Contraseña actual</label>
                                    <input type="password" id="profile-current-password" class="form-input" placeholder="Contraseña actual">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="profile-new-password">Nueva contraseña</label>
                                    <input type="password" id="profile-new-password" class="form-input" placeholder="Nueva contraseña">
                                </div>
                            </div>
                            <div class="form-column">
                                <div class="form-group">
                                    <label class="form-label" for="profile-confirm-password">Confirmar nueva contraseña</label>
                                    <input type="password" id="profile-confirm-password" class="form-input" placeholder="Confirmar nueva contraseña">
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>

</html>