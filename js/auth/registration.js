const driverTab = document.getElementById('driver-tab');
const passengerTab = document.getElementById('passenger-tab');
const registerButton = document.getElementById('register-btn');
const form = document.getElementById('register-form');

cambiarRol(3); // [3 = Driver], [2 = Passenger] 
driverTab.addEventListener('click', () => cambiarRol(3));
passengerTab.addEventListener('click', () => cambiarRol(2));

function cambiarRol(rol) {
    if (rol === 3) {
        driverTab.classList.add('active');
        passengerTab.classList.remove('active');
        registerButton.textContent = 'Registrarse como Chofer';
        form.roleId.value = 3;
    } else {
        passengerTab.classList.add('active');
        driverTab.classList.remove('active');
        registerButton.textContent = 'Registrarse como Pasajero';
        form.roleId.value = 2;
    }
}

form.addEventListener('submit', async (event) => {
    event.preventDefault();

    const formData = new FormData(form);
    const url = `../actions/handler.php?controller=auth&action=register`;

    try {
        const response = await fetch(url, {
            method: 'POST',
            body: formData,
        });

        const result = await response.json();

        if (result.success) {
            mostrarMessage('success', result.success);
        } else {
            mostrarMessage('error', result.error);
        }
    } catch (error) {
        console.error(error);
        mostrarMessage('fatal', error.message);
    }
});

