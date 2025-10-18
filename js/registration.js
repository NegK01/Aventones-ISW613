const driverTab = document.getElementById('driver-tab');
const passengerTab = document.getElementById('passenger-tab');
const registerButton = document.getElementById('register-btn');
let rolEscogido = 0;

// evento de escucha para agregar o remover clase 'active' y mostrar formulario chofer
driverTab.addEventListener('click', () => {
    driverTab.classList.add('active');
    passengerTab.classList.remove('active');
    registerButton.innerText = 'Registrarse como Chofer';
    rolEscogido = 3;

    document.cookie = "rol=3; path=/; max-age=3600"; // dura 1 hora
});

// evento de escucha para agregar o remover clase 'active' y mostrar formulario pasajero
passengerTab.addEventListener('click', () => {
    passengerTab.classList.add('active');
    driverTab.classList.remove('active');
    registerButton.innerText = 'Registrarse como Pasajero';
    rolEscogido = 2;

    document.cookie = "rol=2; path=/; max-age=3600"; // dura 1 hora
});