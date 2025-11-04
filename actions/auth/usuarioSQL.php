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
            (id_rol, cedula, nombre, apellido, nacimiento, correo, telefono, fotografia, contrasena, id_estado, token)
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

    public function actualizar(Usuario $usuario) 
    {
        $id_usuario = $usuario->getId_User();
        $cedula = $usuario->getCedula();
        $nombre = $usuario->getNombre();
        $apellido = $usuario->getApellido();
        $nacimiento = $usuario->getNacimiento();
        $correo = $usuario->getCorreo();
        $telefono = $usuario->getTelefono();
        $foto = $usuario->getFoto();
        $password = $usuario->getPasswordHash();

        //Preparamos los datos que sabemos que siempre vamos a tener
        $stmt = $this->conn->prepare("
            UPDATE usuarios SET 
            cedula = ?, nombre = ?, apellido = ?, nacimiento = ?, correo = ?, telefono = ?, fotografia = ?, contrasena = ? 
            WHERE id_usuario = ?
        ");

        $stmt->bind_param( 
            "ssssssssi", 
            $cedula, 
            $nombre, 
            $apellido, 
            $nacimiento, 
            $correo, 
            $telefono, 
            $foto, 
            $password,
            $id_usuario
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al actualizar el usuario: " . $stmt->error);
        }

        $stmt->close();
    }

    public function obtenerUsuarioPorId($Id_Usuario)
    {
        $stmt = $this->conn->prepare("
            SELECT
                u.id_usuario, u.id_rol, r.nombre AS rol, u.cedula, u.nombre,
                u.apellido, u.nacimiento, u.correo, u.telefono, u.fotografia,
                u.contrasena, u.id_estado, e.nombre AS estado, u.token
            FROM
                usuarios u
            INNER JOIN
                roles r ON u.id_rol = r.id_rol
            INNER JOIN  -- ¡Aquí faltaba el 'INNER JOIN'!
                estados e ON u.id_estado = e.id_estado
            WHERE
                u.id_usuario = ?
            LIMIT 1
        ");

        $stmt->bind_param("i", $Id_Usuario);

        if (!$stmt->execute()) {
            throw new Exception("Error al obtener el usuario: " . $stmt->error);
        }

        $result = $stmt->get_result();

        if (!$result) {
            throw new Exception("Error al encontrar los resultados: " . $stmt->error);
        }

        //obtenemos los valores de el usuario
        $usuario = $result->fetch_assoc() ?: null;

        $stmt->close();
        
        return $usuario;
    }

    public function obtenerUserPorCorreo(string $correo)
    {
        $stmt = $this->conn->prepare("
            SELECT id_usuario, id_rol, contrasena, id_estado
            FROM usuarios
            WHERE correo = ?
            LIMIT 1
        ");
        $stmt->bind_param("s", $correo);

        if (!$stmt->execute()) {
            throw new Exception("Error al obtener el usuario: " . $stmt->error);
        }

        $result = $stmt->get_result();
        // verificamos que el fetch assoc tenga algo sino sera nulo, luego guardamos el resultado en la variable usuarios, que dentro solo tendra las filas de [id_usuario] [id_rol] [contrasena] [id_estado]
        $usuario = $result->fetch_assoc() ?: null;

        $stmt->close();

        return $usuario;
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
