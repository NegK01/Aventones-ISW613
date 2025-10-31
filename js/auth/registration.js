const driverTab = document.getElementById('driver-tab');
const passengerTab = document.getElementById('passenger-tab');
const registerButton = document.getElementById('register-btn');
const form = document.getElementById('register-form');
const messageBox = document.getElementById('form-message');

if (!driverTab || !passengerTab || !registerButton || !form || !messageBox) {
    console.warn('Registro no inicializado');
} else {
    let rolEscogido = 3; // ROLES [3=Chofer] [2=Pasajero]

    const params = new URLSearchParams(window.location.search);
    const roleParam = parseInt(params.get('role'), 10);

    if (roleParam === 2 || roleParam === 3) {
        rolEscogido = roleParam;
    }
    cambiarRol(rolEscogido);

    function cambiarRol(rol) {
        if (rol === 3) {
            driverTab.classList.add('active');
            passengerTab.classList.remove('active');
            registerButton.textContent = 'Registrarse como Chofer';
        } else {
            passengerTab.classList.add('active');
            driverTab.classList.remove('active');
            registerButton.textContent = 'Registrarse como Pasajero';
        }
        window.history.replaceState({}, '', `${window.location.pathname}?role=${rol}`);
        rolEscogido = rol;
    }

    driverTab.addEventListener('click', () => cambiarRol(3));
    passengerTab.addEventListener('click', () => cambiarRol(2));

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const formData = new FormData(form);
        const url = `../actions/handler.php?controller=auth&action=register&role=${rolEscogido}`;

        try {
            const response = await fetch(url, {
                method: 'POST',
                body: formData,
            });

            const result = await response.json();

            if (result.success) {
                mostrarMessage('success');
            } else {
                mostrarMessage('error', result.error);
            }
        } catch (error) {
            console.error(error);
            mostrarMessage('fatal', error.message);
        }
    });
}

function mostrarMessage(estado, errorMessage = null) {
    if (!messageBox) {
        return;
    }

    messageBox.classList.remove('message-error', 'message-success');

    if (estado === 'success') {
        messageBox.textContent = 'Registro exitoso. Revisa tu email para confirmar tu cuenta.';
        messageBox.classList.add('message-success');
    } else if (estado === 'error') {
        messageBox.textContent = errorMessage || 'Ocurrio un error.';
        messageBox.classList.add('message-error');
    } else if (estado === 'fatal') {
        messageBox.textContent = 'Error de conexion con el servidor.';
        messageBox.classList.add('message-error');
    }

    const timeout = estado === 'success' ? 15000 : 5500;
    setTimeout(() => {
        if (messageBox) {
            messageBox.textContent = '';
        }
    }, timeout);
}
