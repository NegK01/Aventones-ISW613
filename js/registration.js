const driverTab = document.getElementById('driver-tab');
const passengerTab = document.getElementById('passenger-tab');
const registerButton = document.getElementById('register-btn');
const form = document.getElementById('register-form');
const messageBox = document.getElementById('form-message');

let rolEscogido = 0; //ROLES [3=Chofer] [2=Pasajero]

// obtener el parámetro "role" desde la URL
const params = new URLSearchParams(window.location.search);
const roleParam = parseInt(params.get('role'));

// validar el parametro recibido o dejarlo tal cual
if (roleParam === 2 || roleParam === 3) {
    rolEscogido = roleParam;
} else {
    rolEscogido = 3;
}
cambiarRol(rolEscogido)

// Funcion para actualizar el estado visual
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
}

// Eventos de cambio de pestaña
driverTab.addEventListener('click', () => cambiarRol(3));
passengerTab.addEventListener('click', () => cambiarRol(2));

// Evitamos que el form redireccione a actions/handler.php
form.addEventListener('submit', async (e) => { // funcion asincrona para usar await
    e.preventDefault(); // evitar refrescar la pagina

    // Construir los datos del form
    const formData = new FormData(form);
    const url = `../actions/handler.php?controller=auth&action=register&role=${rolEscogido}`;

    try {
        //preparar la url con todos los datos del form con fetch
        const response = await fetch(url, {
            method: 'POST',
            body: formData,
        });

        // Response actualmente es un objeto crudo de la respuesta HTTP del servidor que enviamos
        const result = await response.json(); // esperar que se convierta la respuesta en un JSON, ocupa await pues el .json es una promesa, por lo que viene del servidor el cual debe leer y procesar la informacion

        if (result.success) {
            mostrarMessage('success');
        } else {
            mostrarMessage('error', result.error);
        }
    } catch (error) {
        mostrarMessage('fatal', error.message);
    }
});

// Metodo para mostrar un mensaje de estado y su error, ademas de limpiar el campo tras 8 segundos en caso de un fallo y 15 segundos en caso de ser exitoso
function mostrarMessage(estado, errorMessage = null) {
    messageBox.classList.remove('auth-message-error', 'auth-message-success');
    if (estado === 'success') {
        messageBox.textContent = 'Registro exitoso. \n Revisa tu email para confirmar tu cuenta.';
        messageBox.classList.add('auth-message-success');
    } else if (estado === 'error') {
        messageBox.textContent = errorMessage || 'Ocurrió un error.';
        messageBox.classList.add('auth-message-error');
    } else if (estado === 'fatal') {
        messageBox.textContent = 'Error de conexion con el servidor.';
        messageBox.classList.add('auth-message-error');
        console.error(errorMessage);
    }

    if (estado !== 'success') {
        setTimeout(() => {
            messageBox.textContent = '';
        }, 5500);
    } else {
        setTimeout(() => {
            messageBox.textContent = '';
        }, 15000);
    }
}
