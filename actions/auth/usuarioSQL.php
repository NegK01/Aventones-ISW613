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

        $stmt = $this->conn->prepare("
            INSERT INTO usuarios 
            (id_rol, cedula, nombre, apellido, nacimiento, correo, telefono, fotografia, contraseña, id_estado)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "issssssssi",
            $rol,
            $cedula,
            $nombre,
            $apellido,
            $nacimiento,
            $correo,
            $telefono,
            $foto,
            $password,
            $estado
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al registrar usuario: " . $stmt->error);
        }

        $stmt->close();
    }
}
