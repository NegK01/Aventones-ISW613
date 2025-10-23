<?php
class usuarioSQL
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function insertar(Usuario $usuario)
    {
        $rol = $usuario->getRol();
        $cedula = $usuario->getCedula();
        $nombre = $usuario->getNombre();
        $apellido = $usuario->getApellido();
        $nacimiento = $usuario->getNacimiento();
        $correo = $usuario->getCorreo();
        $telefono = $usuario->getTelefono();
        $foto = $usuario->getFoto();
        $password = $usuario->getPasswordHash();
        $estado = $usuario->getEstado();
        $token = $usuario->getToken();

        $stmt = $this->conn->prepare("
            INSERT INTO usuarios 
            (id_rol, cedula, nombre, apellido, nacimiento, correo, telefono, fotografia, contraseña, id_estado, token)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "issssssssis",
            $rol,
            $cedula,
            $nombre,
            $apellido,
            $nacimiento,
            $correo,
            $telefono,
            $foto,
            $password,
            $estado,
            $token
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al registrar usuario: " . $stmt->error);
        }

        $stmt->close();
    }

    public function changeStatus(string $token)
    {
        // Obtenemos el correo del usuario
        $stmt = $this->conn->prepare("
        SELECT correo FROM usuarios WHERE token = ? AND id_estado = '2'
        ");
        $stmt->bind_param("s", $token);

        if (!$stmt->execute()) {
            throw new Exception("Error al obtener el correo: " . $stmt->error);
        }

        $result = $stmt->get_result();
        $email = null;

        if ($row = $result->fetch_assoc()) {
            $email = $row['correo'];
        }

        $stmt->close();

        if ($email === null) {
            return null;
        }

        //Consulta sql para cambiar estado y borrar token 
        $stmt = $this->conn->prepare("
        UPDATE usuarios SET id_estado = '4', token = NULL WHERE token = ? AND id_estado = '2'
        ");
        $stmt->bind_param("s", $token);

        if (!$stmt->execute()) {
            throw new Exception("Error al verificar el usuario: " . $stmt->error);
        }

        $stmt->close();

        return $email;
    }
}
