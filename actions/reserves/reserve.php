<?php
class reserve
{
    private $id_reserva;
    private $id_ride;
    private $id_chofer;
    private $id_cliente;
    private $fecha;
    private $id_estado; // [1= Confirmado] [2= Pendiente] [3= Rechazado] [4= Activo] [5= Inactivo]

    public function __construct($id_ride, $id_chofer, $id_cliente, $fecha, $id_estado = 2, $id_reserva = null)
    {
        $this->id_ride = $id_ride;
        $this->id_chofer = $id_chofer;
        $this->id_cliente = $id_cliente;
        $this->fecha = $fecha;
        $this->id_estado = $id_estado;
        $this->id_reserva = $id_reserva;
    }

    // Getters
    public function getIdReserva()
    {
        return $this->id_reserva;
    }

    public function getIdRide()
    {
        return $this->id_ride;
    }
    public function getIdChofer()
    {
        return $this->id_chofer;
    }

    public function getIdCliente()
    {
        return $this->id_cliente;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getIdEstado()
    {
        return $this->id_estado;
    }
}