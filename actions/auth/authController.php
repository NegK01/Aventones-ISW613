<?php
require_once __DIR__ . '/usuario.php';
require_once __DIR__ . '/usuarioSQL.php';
require_once __DIR__ . '/../services/fileUploader.php';


class authController
{
    private $conn;
    private $usuarioSQL;
    private $uploader;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->usuarioSQL = new usuarioSQL($conn);
        $this->uploader = new fileUploader(__DIR__ . '/../../assets/userPhotos');
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Metodo no permitido']);
            return;
        }

        try {
            // Recolectar datos del form
            $role = trim($_GET['role'] ?? 2);
            $name = trim($_POST['name'] ?? '');
            $lastname = trim($_POST['lastname'] ?? '');
            $id = trim($_POST['id'] ?? '');
            $birthdate = $_POST['birthdate'] ?? '';
            $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
            $phone = trim($_POST['phone'] ?? '');
            $password = $_POST['password'] ?? '';
            $password_confirm = $_POST['password-confirmation'] ?? '';
            $estado = 2;

            // Validaciones
            if (!in_array($role, ['1', '2', '3'])) {
                throw new Exception('Rol invalido');
            }
            if (empty($name) || empty($lastname) || empty($id) || empty($birthdate) || empty($email) || empty($phone) || empty($password)) {
                throw new Exception('Todos los campos son obligatorios');
            }
            if (!$email) {
                throw new Exception('Correo invalido');
            }
            if (strlen($password) < 3) {
                throw new Exception('La contraseña debe tener al menos 3 caracteres');
            }
            if ($password !== $password_confirm) {
                throw new Exception('Las contraseñas no coinciden');
            }

            // Procesar imagen
            $photoPath = null;
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $photoPath = $this->uploader->upload($_FILES['photo']);
            }

            // Crear objeto usuario
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $usuario = new Usuario($role, $id, $name, $lastname, $birthdate, $email, $phone, $passwordHash, $photoPath, $estado);

            // Guardar en base de datos
            $this->usuarioSQL->insertar($usuario);

            echo json_encode(['success' => 'Usuario registrado correctamente']);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        } finally {
            $this->conn->close();
        }
    }
}
