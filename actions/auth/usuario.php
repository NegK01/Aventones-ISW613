<?php
class usuario
{
    private $rol; // [1=Administrador] [2=Pasajero] [3=Chofer] 
    private $cedula;
    private $nombre;
    private $apellido;
    private $nacimiento;
    private $correo;
    private $telefono;
    private $passwordHash;
    private $foto;
    private $estado; // [1= Confirmado] [2= Pendiente] [3= Rechazado] [4= Activo] [5= Inactivo]
    private $token;

    public function __construct($rol = 2, $cedula, $nombre, $apellido, $nacimiento, $correo, $telefono, $passwordHash, $foto = null, $estado = 2, $token) 
    {
        $this->rol = $rol;
        $this->cedula = $cedula;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->nacimiento = $nacimiento;
        $this->correo = $correo;
        $this->telefono = $telefono;
        $this->passwordHash = $passwordHash;
        $this->foto = $foto;
        $this->estado = $estado;
        $this->token = $token;
    }

    // Getters
    public function getRol()
    {
        return $this->rol;
    }

    public function getCedula()
    {
        return $this->cedula;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function getNacimiento()
    {
        return $this->nacimiento;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    public function getFoto()
    {
        return $this->foto;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function getToken()
    {
        return $this->token;
    }
}
