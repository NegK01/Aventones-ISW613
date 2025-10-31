const form = document.getElementById('vehicle-form');
const submitBtn = document.getElementById('submit-form-btn');

// Mostrar la foto del vehiculo cuando se utilice el input de fotos
mostrarFotoVehiculo(false);

form.addEventListener('submit', async (event) => {
    event.preventDefault();

    const formData = new FormData(form);
    const url = '../actions/handler.php?controller=vehicles&action=insertVehicle';

    try {
        submitBtn.disabled = true;
        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (!result.success) {
            mostrarMessage('error', result.error);
            return;
        }

        mostrarMessage('success', result.success);
        setTimeout(() => {
            window.location.href = 'vehicles.php';
        }, 1200);

    } catch (error) {
        console.error('No se pudo insertar el vehiculo: ', error);
        mostrarMessage('fatal', error.message);
    } finally {
        submitBtn.disabled = false;
    }
});