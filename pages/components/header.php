<header class="nav-bar">
    <div class="nav-logo">
        <img
            src="https://cdn.pixabay.com/photo/2014/04/03/00/41/race-car-309123_640.png"
            alt="Aventones Logo" />
        <h1>Aventones</h1>
    </div>
    <ul class="nav-menu">
        <li><a href="/Proyecto-1/index.php" class="<?= $activePage === 'inicio' ? 'active' : '' ?>">Inicio</a></li>
        <li><a href="/Proyecto-1/pages/rides.php" class="<?= $activePage === 'rides' ? 'active' : '' ?>">Rides</a></li>
        <li><a href="/Proyecto-1/pages/vehicles.php" class="<?= $activePage === 'vehicles' ? 'active' : '' ?>">Vehículos</a></li>
        <li><a href="/Proyecto-1/pages/reservations.php" class="<?= $activePage === 'reservations' ? 'active' : '' ?>">Reservas</a></li>
        <li><a href="/Proyecto-1/pages/profile.php" class="<?= $activePage === 'profile' ? 'active' : '' ?>">Perfil</a></li>
    </ul>
</header>