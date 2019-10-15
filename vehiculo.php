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
        $existe = false;
        if(isset($vehiculos))
        {
            foreach($vehiculos as $veh => $value)
            {
                if(isset($value->_patente))
                {
                    // echo($patente);
                    // var_dump($value);
                    if($value->_patente == $patente)
                    {
                        $existe = true;
                        $vehaux = new Vehiculo($value->_marca,$value->_modelo, $value->_patente,$value->_precio, '');
                        echo('</br> patente encontrada </br>');
                        var_dump($vehaux);
                    }   
                }
            }
        }
        else
        {
            echo('</br> Listado vacío </br>');
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
        $archivo = 'vehiculos.txt';
        $arrayVeh = funciones::Listar($archivo);
        $primero = true;
        foreach($arrayVeh as $key => $value)
        {
            if($value->_patente == $patente)
            {
                vehiculo::modificaDatos($value,$marca,$modelo,$precio,$foto);
               
            }
            vehiculo::insertaEnArchivo($value,$primero,$archivo);
            $primero = false;
        }
        
        // }
    }

    public static function modificaDatos($vehiculo,$marca,$modelo,$precio,$foto)
    {
        $vehiculo->_marca = $marca;
        $vehiculo->_modelo = $modelo;
        $vehiculo->_precio = $precio;
        $vehiculo->_foto = $foto;
    }

    public static function insertaEnArchivo($vehiculo,$primero,$archivo)
    {
            if($primero == true)
            {
                $primero = false;
                funciones::Guardar($vehiculo,$archivo,'w');
                
            }
            else{
                funciones::Guardar($vehiculo,$archivo,'a');
            }        
    }

    public static function mostrarTabla()
    {
        $archivo = 'vehiculos.txt';
        $vehiculos = funciones::Listar($archivo);
        // var_dump($vehiculos);
        //titulos tabla
        ?> 
        <table>
        <th>Patente</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Precio</th>
        <th>Imagen</th>
        <?php

        foreach($vehiculos as $key => $value)
        {
            $tagFoto = './foto/'.$value->_foto;
            ?><tr>
            <td> <?php echo($value->_patente) ?> </td>
            <td> <?php echo($value->_marca) ?> </td>
            <td> <?php echo($value->_modelo) ?> </td>
            <td> <?php echo($value->_precio) ?> </td>  
            <td>
            <img src='<?php echo($tagFoto)?>' alt="Foto-Patente" height="60" width="60"/>
            </td>  
            </tr>
            <?php
        }
        ?> 
        </table> 
        <?php
        

    }
}
?>