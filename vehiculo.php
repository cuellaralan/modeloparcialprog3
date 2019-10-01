<?php
include_once 'funciones.php';

class Vehiculo
{
    public $_marca;
    public $_modelo;
    public $_patente;
    public $_precio;
    public $_foto;

    public function __construct($marca,$modelo,$patente,$precio,$foto)
    {
        $this->_marca = $marca;
        $this->_modelo = $modelo;
        $this->_patente = $patente;
        $this->_precio = $precio;
        $this->_foto = $foto;
    }

    public function guardarVehiculo($vehiculo)
    {
        $archivo = 'vehiculos.txt';
        // var_dump($vehiculo);
        $siguardar = $this->patenteDuplicada($vehiculo->_patente);
        if($siguardar == false)
        {
            funciones::Guardar($vehiculo,$archivo,'a');
            $retorno = 'guardado exitosamente';
        }
        else
        {
            $retorno = 'patente duplicada';
        }
        // echo $retorno;
        // var_dump($vehiculo);
        return $retorno;
    }

    private function patenteDuplicada($patente)
    {
        $archivo = 'vehiculos.txt';
        $vehiculos = funciones::Listar($archivo);
        $existe = false;
        if(isset($vehiculos))
        {
            foreach($vehiculos as $veh => $value)
            {
                // echo ' VEHICULO: '.PHP_EOL;
                // print_r($veh);
                // echo ' valor: '.PHP_EOL;
                // print_r($value);
                if(isset($value->_marca))
                {
                    if($value->_patente == $patente)
                    {
                    $existe = true;
                    break;
                    }   
                }
                else
                {
                    break;
                }
            }
        }   
        return $existe;
    }

    public static function buscarXpatente($patente)
    {
        $archivo = 'vehiculos.txt';
        $vehiculos = funciones::Listar($archivo);
        // var_dump($vehiculos);
        $existe = false;
        if(isset($vehiculos))
        {
            foreach($vehiculos as $veh => $value)
            {
                if(isset($value->_patente))
                {
                    if($value->_patente == $patente)
                    {
                        $existe = true;
                        $vehaux = new Vehiculo($value->_marca,$value->_modelo, $value->_patente,$value->_precio, '');
                    }   
                }
            }
        }
        if($existe == false)
        {
            return 'no existe patente';
        }   
        else
        {
            return $vehaux;
        }
    }

    public static function buscarXmarca($marca)
    {
        $archivo = 'vehiculos.txt';
        $vehiculos = funciones::Listar($archivo);
        $existe = false;
        $arrayVeh = array();
        if(isset($vehiculos))
        {
            foreach($vehiculos as $veh => $value)
            {
                if(isset($value->_marca))
                {
                    if($value->_marca == $marca)
                    {
                        $existe = true;
                        $vehaux = new Vehiculo($value->_marca,$value->_modelo, $value->_patente,$value->_precio);
                        array_push($arrayVeh,$vehaux);
                    }   
                }
                // else
                // {
                //     break;
                // }
            }
        }
        if($existe == false)
        {
            return 'no existe patente';
        }   
        else
        {
            return $arrayVeh;
        }
    }

    public static function modificarVehiculo($patente,$marca,$modelo,$precio,$foto)
    {
        $vehiculo = vehiculo::buscarXpatente($patente);
        if(isset($vehiculo)&& $vehiculo != 'no existe patente')
        {
            echo 'path foto: '.$foto.'<br/>';
            $vehiculo->modificaDatos($marca,$modelo,$precio,$foto);
            $vehiculo->insertaEnArchivo();

        }
    }

    private function modificaDatos($marca,$modelo,$precio,$foto)
    {
        $this->_marca = $marca;
        $this->_modelo = $modelo;
        $this->_precio = $precio;
        $this->_foto = $foto;
    }

    private function insertaEnArchivo()
    {
        $archivo = 'vehiculos.txt';
        $lVehiculos = funciones::Listar($archivo);
        $primero = true;
        foreach($lVehiculos as $key => $value)
        {
            if($value->_patente == $this->_patente)
            {
                $value->_patente = $this->_patente;
                $value->_marca = $this->_marca;
                $value->_modelo = $this->_modelo;
                $value->_precio = $this->_precio;
                $value->_foto = $this->_foto;
            }
            if($primero == true)
            {
                $primero = false;
                funciones::Guardar($value,$archivo,'w');
                echo 'primer guardado'.'<br/>';
            }
            else{
                echo 'segundo guardado'.'<br/>';
                funciones::Guardar($value,$archivo,'a');
            }
        }
    }
}
?>