
const profileForm = document.getElementById("profile-form");
const profileHeader = document.getElementById("profile-header");
const messageBox = document.getElementById("form-message");

const defaultImage =
    "https://img.freepik.com/premium-vector/profile-contact-icon-vector-flat-gradient-color-illustration-art_1108489-10.jpg?semt=ais_hybrid&w=740&q=80";

document.addEventListener("DOMContentLoaded", async (e) => {
    e.preventDefault();
    CargarUsuario();
});

async function CargarUsuario() {
    try {
        //creamos solicitud
        const response = await fetch(
            "../actions/handler.php?controller=auth&action=cargarUsuario"
        );

        if (!response.ok) {
            throw new Error(`HTTP ${response.status}`);
        }

        const data = await response.json();

        if (!data.success || data.user === null) {
            throw new Error(data.error || "Respuesta inválida del servidor");
        }

        const user = data.user;

        profileHeader.querySelector("#image").src =
            user.fotografia || defaultImage;
        profileHeader.querySelector("#title-name").textContent =
            user.nombre + " " + user.apellido || "";
        profileHeader.querySelector("#profile-role").textContent =
            user.rol || "";

        profileForm.querySelector("#profile-firstname").value =
            user.nombre || "";
        profileForm.querySelector("#profile-lastname").value =
            user.apellido || "";
        profileForm.querySelector("#profile-id").value = user.cedula || "";
        profileForm.querySelector("#profile-birthdate").value =
            user.nacimiento || "";
        profileForm.querySelector("#profile-email").value = user.correo || "";
        profileForm.querySelector("#profile-phone").value = user.telefono || "";
    } catch (error) {
        console.error("No se pudo cargar el usuario actual...", error);
    }
}

profileForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    const formData = new FormData(profileForm);
    const url = `../actions/handler.php?controller=auth&action=update`;

    try {
        // esperar una respuesta de la url
        const response = await fetch(url, {
            method: "POST",
            body: formData,
        });

        const result = await response.json();
        
        if (result.success) {
            mostrarMessage("success", result.success);
            CargarUsuario();
        } else {
            mostrarMessage("error", result.error);
        }
    } catch (error) {
        console.error(error);
        mostrarMessage("fatal", error.message);
    }
});

function mostrarMessage(estado, Message = null) {
    if (!messageBox) {
        return;
    }

    messageBox.classList.remove("message-error", "message-success");

    if (estado === "success") {
        messageBox.textContent = Message;
        messageBox.classList.add("message-success");
    } else if (estado === "error") {
        messageBox.textContent = Message || "Ocurrio un error.";
        messageBox.classList.add("message-error");
    } else if (estado === "fatal") {
        messageBox.textContent = "Error de conexion con el servidor.";
        messageBox.classList.add("message-error");
    }

    const timeout = 5500;
    setTimeout(() => {
        if (messageBox) {
            messageBox.textContent = "";
        }
    }, timeout);
}
