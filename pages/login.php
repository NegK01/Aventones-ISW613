<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Aventones - Iniciar Sesión</title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/utilities.css">
    <link rel="stylesheet" href="../css/components/header.css">
    <link rel="stylesheet" href="../css/components/buttons.css">
    <link rel="stylesheet" href="../css/components/forms.css">
    <link rel="stylesheet" href="../css/sections/auth.css">
</head>

<body>
    <div class="app-container">
        <?php
        $activePage = 'inicio';
        include '../components/header.php';
        ?>

        <main class="main-content">
            <section id="login" class="section auth-section">
                <div class="auth-container">
                    <div class="auth-header">
                        <h2>Iniciar Sesión</h2>
                        <p>Ingresa tus credenciales para acceder</p>
                    </div>
                    <form class="form">
                        <div class="form-group">
                            <label class="form-label" for="login-email">Email o Teléfono</label>
                            <input
                                type="text"
                                id="login-email"
                                class="form-input"
                                placeholder="email@ejemplo.com" />
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="login-password">Contraseña</label>
                            <input
                                type="password"
                                id="login-password"
                                class="form-input"
                                placeholder="Contraseña" />
                        </div>
                        <div class="form-group">
                            <button
                                type="submit"
                                class="btn btn-primary"
                                style="width: 100%">
                                Iniciar Sesión
                            </button>
                        </div>
                    </form>
                    <div class="auth-footer">
                        <p>
                            ¿No tienes una cuenta?
                            <a href="register.html" class="auth-link">Regístrate</a>
                        </p>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>

</html>