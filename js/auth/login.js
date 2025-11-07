const correoInput = document.getElementById('login-email');
const passwordInput = document.getElementById('login-password');
const form = document.getElementById('login-form');
const messageBox = document.getElementById('form-message');
const submitButton = document.getElementById('form-submit');

// obtener el parametro de correo de la URL para autocompletar el campo
const params = new URLSearchParams(window.location.search);
const correoParam = params.get('email');
if (correoParam) {
    correoInput.value = correoParam;
    passwordInput.focus();
} else {
    correoInput.focus();
}

// agregar listener para cuando se haga submit en el formulario de login, verificar credenciales y redireccionar a la pagina correspondiente segun el rol
form.addEventListener('submit', async (event) => {
    event.preventDefault();

    const formData = new FormData(form);
    const url = '../actions/handler.php?controller=auth&action=login';

    try {
        submitButton.disabled = true;

        const response = await fetch(url, {
            method: 'POST',
            body: formData,
        });

        const result = await response.json();

        if (!result.success) {
            mostrarMessage('error', result.error);
            return;
        }

        mostrarMessage('success', result.success);

        let ruta = "";
        if (result.idRole == 1) { // Admin
            ruta = '../pages/adminDashboard.php';
        } else { // Chofer o Pasajero
            ruta = '../index.php';
        }

        setTimeout(() => {
            window.location.href = ruta;
        }, 1200);
    } catch (error) {
        console.error(error);
        mostrarMessage('fatal', error.message);
    } finally {
        submitButton.disabled = false;
    }
});
