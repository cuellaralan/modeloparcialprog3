<?php
include_once 'funciones.php';

class Vehiculo
{
    public $_marca;
    public $_modelo;
    public $_patente;
    public $_precio;

    public function __construct($marca,$modelo,$patente,$precio)
    {
        $this->_marca = $marca;
        $this->_modelo = $modelo;
        $this->_patente = $patente;
        $this->_precio = $precio;
    }

    public function guardarVehiculo($vehiculo)
    {
        $archivo = 'vehiculos.txt';
        var_dump($vehiculo);
        funciones::Guardar($vehiculo,$archivo,'a');
    }

    public static function buscarXmarca($marca)
    {
        $archivo = 'vehiculos.txt';
        $vehiculos = funciones::Listar();
        foreach($vehiculos as $veh)
        {
            //recorrer array y buscar y devolver ocurrencias
        }
    }
}


?>