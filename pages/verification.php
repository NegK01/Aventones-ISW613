<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventones - Verificacion</title>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/utilities.css">
    <link rel="stylesheet" href="../css/components/header.css">
    <link rel="stylesheet" href="../css/components/buttons.css">
    <link rel="stylesheet" href="../css/sections/auth.css">
    <link rel="stylesheet" href="../css/pages/verification.css">
</head>

<body>
    <div class="app-container">
        <header class="nav-bar">
            <div class="nav-logo">
                <h1>Aventones</h1>
            </div>
        </header>

        <main class="main-content">
            <section id="verification" class="active section auth-section">
                <div class="verification-container">
                    <div id="verification-icon" class="verification-icon"></div>
                    <h2 id="verification-message" class="verification-text">Toca el boton para verificar tu cuenta</h2>
                    <button id="verify-btn" class="btn btn-primary verification-button">Activar cuenta</button>
                </div>
            </section>
        </main>
    </div>

    <script src="../js/auth/verification.js"></script>
</body>

</html>