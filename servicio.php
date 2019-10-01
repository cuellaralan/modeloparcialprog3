<?php
//include 'funciones.php';

class Servicio
{
    public $_nombre;
    public $_id;
    public $_tipo;
    public $_precio;
    public $_demora;

    public function __construct($nombre,$id,$tipo,$precio,$demora)
    {
        $this->_nombre = $nombre;
        $this->_id = $id; //se guardará la patente del vehiculo que solicitó el servicio
        $this->_tipo = $tipo;
        $this->_precio = $precio;
        $this->_demora = $demora;
    }

    public function guardarServicio($servicio)
    {
        $archivo = 'tiposServicio.txt';
        funciones::Guardar($servicio,$archivo,'a');
        $retorno = 'guardado exitosamente';
        // echo $retorno;
        // var_dump($vehiculo);
        return $retorno;
    }
}