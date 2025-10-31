<?php
class vehicle
{
    private $id_vehiculo;
    private $id_usuario;
    private $placa;
    private $color;
    private $marca;
    private $modelo;
    private $anio;
    private $asientos;
    private $fotografia;
    private $id_estado; // [1= Confirmado] [2= Pendiente] [3= Rechazado] [4= Activo] [5= Inactivo]

    public function __construct($id_usuario, $placa, $color, $marca, $modelo, $anio, $asientos, $fotografia = null, $id_estado = 4, $id_vehiculo = null)
    {
        $this->id_usuario = $id_usuario;
        $this->placa = $placa;
        $this->color = $color;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->anio = $anio;
        $this->asientos = $asientos;
        $this->fotografia = $fotografia;
        $this->id_estado = $id_estado;
        $this->id_vehiculo = $id_vehiculo;
    }

    // Getters
    public function getIdVehiculo()
    {
        return $this->id_vehiculo;
    }
    public function getIdUsuario()
    {
        return $this->id_usuario;
    }
    public function getPlaca()
    {
        return $this->placa;
    }
    public function getColor()
    {
        return $this->color;
    }
    public function getMarca()
    {
        return $this->marca;
    }
    public function getModelo()
    {
        return $this->modelo;
    }
    public function getAnio()
    {
        return $this->anio;
    }
    public function getAsientos()
    {
        return $this->asientos;
    }
    public function getFotografia()
    {
        return $this->fotografia;
    }
    public function getIdEstado()
    {
        return $this->id_estado;
    }
}
