<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Aventones - Registro</title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/utilities.css">
    <link rel="stylesheet" href="../css/components/header.css">
    <link rel="stylesheet" href="../css/components/buttons.css">
    <link rel="stylesheet" href="../css/components/forms.css">
    <link rel="stylesheet" href="../css/components/tabs.css">
    <link rel="stylesheet" href="../css/sections/auth.css">
</head>

<body>
    <div class="app-container">
        <?php
        $activePage = 'inicio';
        include '../components/header.php'
        ?>

        <!-- Contenido principal -->
        <main class="main-content">
            <section id="register" class="section auth-section">
                <div class="auth-container">
                    <div class="auth-header">
                        <h2>Registro</h2>
                        <p>Crea una nueva cuenta</p>
                    </div>

                    <div class="tabs">
                        <button class="tab active" data-tab="driver-tab">
                            Chofer
                        </button>
                        <button class="tab" data-tab="passenger-tab">
                            Pasajero
                        </button>
                    </div>

                    <!-- Formulario de chofer -->
                    <div id="driver-tab" class="tab-content active">
                        <form class="form">
                            <div class="form-row">
                                <div class="form-column">
                                    <div class="form-group">
                                        <label
                                            class="form-label"
                                            for="driver-firstname">Nombre</label>
                                        <input
                                            type="text"
                                            id="driver-firstname"
                                            class="form-input"
                                            placeholder="Nombre" />
                                    </div>
                                </div>
                                <div class="form-column">
                                    <div class="form-group">
                                        <label
                                            class="form-label"
                                            for="driver-lastname">Apellido</label>
                                        <input
                                            type="text"
                                            id="driver-lastname"
                                            class="form-input"
                                            placeholder="Apellido" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-column">
                                    <div class="form-group">
                                        <label
                                            class="form-label"
                                            for="driver-id">Cédula</label>
                                        <input
                                            type="text"
                                            id="driver-id"
                                            class="form-input"
                                            placeholder="Número de cédula" />
                                    </div>
                                </div>
                                <div class="form-column">
                                    <div class="form-group">
                                        <label
                                            class="form-label"
                                            for="driver-birthdate">Fecha de nacimiento</label>
                                        <input
                                            type="date"
                                            id="driver-birthdate"
                                            class="form-input" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-column">
                                    <div class="form-group">
                                        <label
                                            class="form-label"
                                            for="driver-email">Correo electrónico</label>
                                        <input
                                            type="email"
                                            id="driver-email"
                                            class="form-input"
                                            placeholder="email@ejemplo.com" />
                                    </div>
                                </div>
                                <div class="form-column">
                                    <div class="form-group">
                                        <label
                                            class="form-label"
                                            for="driver-phone">Teléfono</label>
                                        <input
                                            type="tel"
                                            id="driver-phone"
                                            class="form-input"
                                            placeholder="Teléfono" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="driver-photo">Foto</label>
                                <input
                                    type="file"
                                    id="driver-photo"
                                    class="form-input" />
                            </div>

                            <div class="form-row">
                                <div class="form-column">
                                    <div class="form-group">
                                        <label
                                            class="form-label"
                                            for="driver-password">Contraseña</label>
                                        <input
                                            type="password"
                                            id="driver-password"
                                            class="form-input"
                                            placeholder="Contraseña" />
                                    </div>
                                </div>
                                <div class="form-column">
                                    <div class="form-group">
                                        <label
                                            class="form-label"
                                            for="driver-confirm-password">Confirmar contraseña</label>
                                        <input
                                            type="password"
                                            id="driver-confirm-password"
                                            class="form-input"
                                            placeholder="Confirmar contraseña" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                    style="width: 100%">
                                    Registrarse como Chofer
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Formulario de pasajero -->
                    <div id="passenger-tab" class="tab-content">
                        <form class="form">
                            <div class="form-row">
                                <div class="form-column">
                                    <div class="form-group">
                                        <label
                                            class="form-label"
                                            for="passenger-firstname">Nombre</label>
                                        <input
                                            type="text"
                                            id="passenger-firstname"
                                            class="form-input"
                                            placeholder="Nombre" />
                                    </div>
                                </div>
                                <div class="form-column">
                                    <div class="form-group">
                                        <label
                                            class="form-label"
                                            for="passenger-lastname">Apellido</label>
                                        <input
                                            type="text"
                                            id="passenger-lastname"
                                            class="form-input"
                                            placeholder="Apellido" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-column">
                                    <div class="form-group">
                                        <label
                                            class="form-label"
                                            for="passenger-id">Cédula</label>
                                        <input
                                            type="text"
                                            id="passenger-id"
                                            class="form-input"
                                            placeholder="Número de cédula" />
                                    </div>
                                </div>
                                <div class="form-column">
                                    <div class="form-group">
                                        <label
                                            class="form-label"
                                            for="passenger-birthdate">Fecha de nacimiento</label>
                                        <input
                                            type="date"
                                            id="passenger-birthdate"
                                            class="form-input" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-column">
                                    <div class="form-group">
                                        <label
                                            class="form-label"
                                            for="passenger-email">Correo electrónico</label>
                                        <input
                                            type="email"
                                            id="passenger-email"
                                            class="form-input"
                                            placeholder="email@ejemplo.com" />
                                    </div>
                                </div>
                                <div class="form-column">
                                    <div class="form-group">
                                        <label
                                            class="form-label"
                                            for="passenger-phone">Teléfono</label>
                                        <input
                                            type="tel"
                                            id="passenger-phone"
                                            class="form-input"
                                            placeholder="Teléfono" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label
                                    class="form-label"
                                    for="passenger-photo">Foto</label>
                                <input
                                    type="file"
                                    id="passenger-photo"
                                    class="form-input" />
                            </div>

                            <div class="form-row">
                                <div class="form-column">
                                    <div class="form-group">
                                        <label
                                            class="form-label"
                                            for="passenger-password">Contraseña</label>
                                        <input
                                            type="password"
                                            id="passenger-password"
                                            class="form-input"
                                            placeholder="Contraseña" />
                                    </div>
                                </div>
                                <div class="form-column">
                                    <div class="form-group">
                                        <label
                                            class="form-label"
                                            for="passenger-confirm-password">Confirmar contraseña</label>
                                        <input
                                            type="password"
                                            id="passenger-confirm-password"
                                            class="form-input"
                                            placeholder="Confirmar contraseña" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                    style="width: 100%">
                                    Registrarse como Pasajero
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="auth-footer">
                        <p>
                            ¿Ya tienes una cuenta?
                            <a href="login.html" class="auth-link">Iniciar sesión</a>
                        </p>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>

</html>