const correoInput = document.getElementById('login-email');
const passwordInput = document.getElementById('login-password');
const form = document.getElementById('login-form');
const messageBox = document.getElementById('form-message');
const submitButton = document.getElementById('form-submit');

if (!correoInput || !passwordInput || !form || !messageBox || !submitButton) {
    console.warn('Login form no inicializado');
} else {
    const params = new URLSearchParams(window.location.search);
    const correoParam = params.get('email');

    if (correoParam) {
        correoInput.value = correoParam;
        passwordInput.focus();
    } else {
        correoInput.focus();
    }

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

            if (result.success) {
                mostrarMessage('success');
                setTimeout(() => {
                    window.location.href = '../index.php';
                }, 1200);
                return;
            }

            mostrarMessage('error', result.error);
        } catch (error) {
            console.error(error);
            mostrarMessage('fatal', 'No se pudo conectar con el servidor.');
        } finally {
            submitButton.disabled = false;
        }
    });
}

function mostrarMessage(estado, message = null) {
    if (!messageBox) {
        return;
    }

    messageBox.classList.remove('auth-message-error', 'auth-message-success');

    if (estado === 'success') {
        messageBox.textContent = message || 'Inicio de sesion exitoso. Redirigiendo...';
        messageBox.classList.add('auth-message-success');
    } else if (estado === 'error') {
        messageBox.textContent = message || 'Ocurrio un error.';
        messageBox.classList.add('auth-message-error');
    } else if (estado === 'fatal') {
        messageBox.textContent = message || 'Error de conexion con el servidor.';
        messageBox.classList.add('auth-message-error');
    }

    const timeout = estado === 'success' ? 15000 : 5500;
    setTimeout(() => {
        messageBox.textContent = '';
    }, timeout);
}
