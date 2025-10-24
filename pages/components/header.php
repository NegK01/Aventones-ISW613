<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$isLoggedIn = !empty($_SESSION['user_id']);
?>

<header class="nav-bar">
    <div class="nav-logo">
        <img
            src="https://cdn.pixabay.com/photo/2014/04/03/00/41/race-car-309123_640.png"
            alt="Aventones Logo" />
        <h1>Aventones</h1>
    </div>

    <?php if ($isLoggedIn) : ?>
        <ul class="nav-menu">
            <li><a href="/Proyecto-1/index.php" class="<?= $activePage === 'inicio' ? 'active' : '' ?>">Inicio</a></li>
            <li><a href="/Proyecto-1/pages/rides.php" class="<?= $activePage === 'rides' ? 'active' : '' ?>">Rides</a></li>
            <li><a href="/Proyecto-1/pages/vehicles.php" class="<?= $activePage === 'vehicles' ? 'active' : '' ?>">Vehiculos</a></li>
            <li><a href="/Proyecto-1/pages/reservations.php" class="<?= $activePage === 'reservations' ? 'active' : '' ?>">Reservas</a></li>
            <li class="nav-profile">
                <a href="/Proyecto-1/pages/profile.php" class="<?= $activePage === 'profile' ? 'active' : '' ?>">Perfil</a>
                <ul class="nav-submenu">
                    <a href="/Proyecto-1/pages/profile.php">Editar perfil</a>
                    <a href="/Proyecto-1/actions/handler.php?controller=auth&action=logout">Cerrar sesion</a>
                </ul>
            </li>
        </ul>
    <?php else : ?>
        <?php if ($activePage !== 'none') : ?>
            <div class="nav-actions">
                <a href="/Proyecto-1/pages/login.php" class="btn btn-primary btn-none-decoration">Iniciar Sesión</a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</header>