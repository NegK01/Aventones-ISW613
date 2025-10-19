<?php
class AuthController {
    private $conn; 

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function register() {
        // Validamos en que register solo se haga con metodo POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Codigo que indica metodo no permitido
            echo json_encode(['error' => 'Metodo no permitido']);
            return;
        }

        // Recibir los datos del formulario
        $role = trim($_GET['role'] ?? 2); //ROLES [3=Chofer] [2=Pasajero]
        $name = trim($_POST['name'] ?? '');
        $lastname = trim($_POST['lastname'] ?? '');
        $id = trim($_POST['id'] ?? '');
        $birthdate = $_POST['birthdate'] ?? '';
        $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
        $phone = trim($_POST['phone'] ?? '');
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password-confirmation'] ?? '';
        $estado = 2; //ESTADOS [1= Confirmado] [2= Pendiente] [3= Rechazado] [4= Activo] [5= Inactivo] 

        // Validaciones
        if (!in_array($role, ['3', '2'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Rol inválido']);
            return;
        }
        if (empty($name) || empty($lastname) || empty($id) || empty($birthdate) || empty($email) || empty($phone) || empty($password) || empty($password_confirm)) {
            http_response_code(400);
            echo json_encode(['error' => 'Todos los campos son obligatorios']);
            return;
        }
        if (strlen($password) < 3) {
            http_response_code(400);
            echo json_encode(['error' => 'La contraseña debe tener al menos 3 caracteres']);
            return;
        }
        if ($password !== $password_confirm) {
            http_response_code(400);
            echo json_encode(['error' => 'Las contraseñas no coinciden.']);
            return;
        }

        // Encriptar la contraseña con md5
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        //password_verify(contra, el hash) para verificar y retorna true o false

        // Guardar la foto
        $photoPath = null;
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../assets/userPhotos/';
            $fileTmpPath = $_FILES['photo']['tmp_name'];
            $fileType = mime_content_type($fileTmpPath);

            // Verificar que el archivo sea de un formato compatible
            if ($fileType !== 'image/jpeg' && $fileType !== 'image/png') {
                echo json_encode(['error' => 'Solo se permiten imagenes JPG o PNG']);
                return;
            }

            // Crear carpeta si no existe
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = uniqid() . '_' . basename($_FILES['photo']['name']);
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
                // Guardamos solo la ruta relativa
                $photoPath = 'assets/userPhotos/' . $fileName;
            } else {
                echo json_encode(['error' => 'Error al subir la foto']);
                return;
            }
        }
        
        // Insertar en la base de datos
        $sql = "INSERT INTO usuarios (id_rol, cedula, nombre, apellido, nacimiento, correo, telefono, fotografia, contraseña, id_estado)
                VALUES ('$role','$id','$name','$lastname','$birthdate','$email','$phone','$photoPath','$passwordHash','$estado')";

        // Ejecutar la query y verificar
        if ($this->conn->query($sql)) {
            // Éxito
            echo json_encode(['success' => 'Usuario registrado correctamente']);
        } else {
            // Error
            echo json_encode(['error' => 'Error al registrar usuario: ' . $this->conn->error]);
        }

        // Cerrar la conexión
        $this->conn->close();
    }
}