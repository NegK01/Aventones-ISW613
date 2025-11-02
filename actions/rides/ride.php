<?php
class ride
{
    private $id_ride;
    private $id_usuario;
    private $id_vehiculo;
    private $nombre;
    private $origen;
    private $destino;
    private $fechaHora;
    private $asientos;
    private $costoAsiento;
    private $detalles;
    private $id_estado; // [1= Confirmado] [2= Pendiente] [3= Rechazado] [4= Activo] [5= Inactivo]

    public function __construct($id_usuario, $id_vehiculo, $nombre, $origen, $destino, $fechaHora, $asientos, $costoAsiento, $detalles, $id_estado = 4, $id_ride = null)
    {
        $this->id_ride = $id_ride;
        $this->id_usuario = $id_usuario;
        $this->id_vehiculo = $id_vehiculo;
        $this->nombre = $nombre;
        $this->origen = $origen;
        $this->destino = $destino;
        $this->fechaHora = $fechaHora;
        $this->asientos = $asientos;
        $this->costoAsiento = $costoAsiento;
        $this->detalles = $detalles;
        $this->id_estado = $id_estado;
    }

    // Getters
    public function getIdRide()
    {
        return $this->id_ride;
    }
    public function getIdUsuario()
    {
        return $this->id_usuario;
    }
    public function getIdVehiculo()
    {
        return $this->id_vehiculo;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getOrigen()
    {
        return $this->origen;
    }
    public function getDestino()
    {
        return $this->destino;
    }
    public function getFechaHora()
    {
        return $this->fechaHora;
    }
    public function getAsientos()
    {
        return $this->asientos;
    }
    public function getCostoAsiento()
    {
        return $this->costoAsiento;
    }
    public function getDetalles()
    {
        return $this->detalles;
    }
    public function getIdEstado()
    {
        return $this->id_estado;
    }
}