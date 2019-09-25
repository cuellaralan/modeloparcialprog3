<?php
include_once 'funciones.php';

class vehiculo
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
}


?>