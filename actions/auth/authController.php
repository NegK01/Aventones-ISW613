<?php
require_once __DIR__ . '/usuario.php';
require_once __DIR__ . '/usuarioSQL.php';
require_once __DIR__ . '/../services/fileUploader.php';
require_once __DIR__ . '/../services/mailService.php';

class authController
{
    private $conn;
    private $usuarioSQL;
    private $fileuUploader;
    private $mailService;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->usuarioSQL = new usuarioSQL($conn);
        $this->fileuUploader = new fileUploader(__DIR__ . '/../../assets/userPhotos');
        $this->mailService = new mailService();
    }

    public function register()
    {
        // bloquear otros metodos
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
            $passwordConfirm = $_POST['password-confirmation'] ?? '';
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
                throw new Exception('La contrasena debe tener al menos 3 caracteres');
            }
            if ($password !== $passwordConfirm) {
                throw new Exception('Las contrasenas no coinciden');
            }

            // Procesar imagen
            $photoPath = null;
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $photoPath = $this->fileuUploader->upload($_FILES['photo']);
            }

            // Crear objeto usuario
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            //Se genera token para verificar cuenta
            $token = bin2hex(random_bytes(16));

            // Crear el objeto usuario
            $usuario = new Usuario(
                $role,
                $id,
                $name,
                $lastname,
                $birthdate,
                $email,
                $phone,
                $passwordHash,
                $photoPath,
                $estado,
                $token
            );

            // insertar el usuario en la base de datos
            $this->usuarioSQL->insertar($usuario);

            if ($this->mailService !== null) {
                $this->mailService->sendVerificationMail($usuario);
            }

            echo json_encode(['success' => 'Usuario registrado correctamente']);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        } finally {
            $this->conn->close();
        }
    }

    public function verifyAccount()
    {
        // bloquear otros metodos
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            echo json_encode(['error' => 'Metodo no permitido']);
            return;
        }

        try {
            //Se recolecta el token de la url
            $token = trim($_GET['token'] ?? '');

            if (empty($token)) {
                throw new Exception('No se envio ningun token');
            }

            $emailObtenido = $this->usuarioSQL->changeStatus($token);

            if ($emailObtenido) {
                echo json_encode([
                    'success' => true,
                    'email' => $emailObtenido
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'error' => 'No se encontro el token enviado'
                ]);
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        } finally {
            $this->conn->close();
        }
    }

    public function login()
    {
        // bloquear otros metodos
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Metodo no permitido']);
            return;
        }

        try {
            // pasar el email a lower y trim para quitar los espacios en blanco
            $email = strtolower(trim($_POST['email'] ?? ''));
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                throw new Exception('Todos los campos son obligatorios');
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Correo invalido');
            }

            $usuario = $this->usuarioSQL->obtenerUserPorCorreo($email);
            if ($usuario === null) {
                throw new Exception('Credenciales incorrectas');
            }

            if ((int) $usuario['id_estado'] !== 4) {
                throw new Exception('Cuenta no activa. Verifica tu correo.');
            }

            if (!password_verify($password, $usuario['contrasena'])) {
                throw new Exception('Credenciales incorrectas');
            }

            // cada vez que se inicie una sesion exitosa, vamos a regenerar el session id del user, esto solo es una practica para evitar la suplantacion de identidad
            session_regenerate_id(true);

            $_SESSION['user_id'] = (int) $usuario['id_usuario'];
            $_SESSION['role'] = (int) $usuario['id_rol'];

            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        } finally {
            $this->conn->close();
        }
    }

    public function logout()
    {
        // bloquear otros metodos
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            echo json_encode(['error' => 'Metodo no permitido']);
            return;
        }

        session_destroy();

        $this->conn->close();

        header('Location: /Proyecto-1/pages/login.php');
    }
}
