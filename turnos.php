<?php
//include 'funciones.php';

class Turno
{
    public $_patente;
    public $_fecha;
    public $_marca;
    public $_modelo;
    public $_precio;
    public $_tpoServicio;

    public function __construct($patente,$fecha,$marca,$modelo,$precio,$tiposervicio)
    {
        $this->_patente = $patente;
        $this->_fecha = $fecha; 
        $this->_marca = $marca;
        $this->_modelo = $modelo;
        $this->_precio = $precio;
        $this->_tpoServicio = $tiposervicio;
    }
    public static function sacarTurno($patente,$fecha)
    {
        $archivo = 'turnos.txt';
        $vehaux = vehiculo::buscarXpatente($patente);
        // var_dump($vehaux);
        if(isset($vehaux) && $vehaux != 'no existe patente')
        {
            $arrayT = funciones::Listar($archivo);
            $cupo = sizeof($arrayT);
            if($cupo < 21)
            {
                $turno = new Turno($patente, $fecha, $vehaux->_marca, $vehaux->_modelo, $vehaux->_precio, 'standard');
                funciones::Guardar($turno,$archivo,'a');
                $retorno = 'guardado exitosamente';
            }
            else
            {
                $retorno = 'Se superó el cupo del día';
            }
        }
        else
        {
            $retorno = 'vehiculo no existe, turno no asignado :';
        }
        
        // echo $retorno;
        // var_dump($vehiculo);
        return $retorno;
    }
    public static function tTurnos()
    {
        $archivo = 'turnos.txt';
        $arrayT = funciones::Listar($archivo);
        Turno::generaTabla($arrayT);
        
    }

    private static function generaTabla($arrayT)
    {
        echo "<table>"; // Creas la tabla
        echo "<th>patente</th>";
        echo "<th>fecha</th>";
        echo "<th>marca</th>";
        echo "<th>modelo</th>";
        echo "<th>precio</th>";
        echo "<th>tipoServicio</th>";
        foreach($arrayT as $key => $value)
        {
            if(isset($value->_patente))
            {
                echo "<tr>"; // Por cada fila
                ?>
                <td><?php echo $value->_patente; ?></td>
                <td><?php echo $value->_fecha; ?></td>
                <td><?php echo $value->_marca; ?></td>
                <td><?php echo $value->_modelo; ?></td>
                <td><?php echo $value->_precio; ?></td>
                <td><?php echo $value->_tpoServicio; ?></td>
                <?php
                echo "</tr>"; // Por cada fila
            }
        }
        echo "</table>";
    }

    public static function inscripciones($filtro,$queFiltro)
    {
        if($queFiltro == 'fecha')
        {
            $ListaF =  Turno::buscarXfecha($filtro);
            // var_dump($ListaF);
            if($ListaF != 'no existe filtro')
            {
                Turno::generaTabla($ListaF);
            }
        }
        else
        {
            $ListaF = Turno::buscarXservicio($filtro);
            if($ListaF != 'no existe filtro')
            {
                Turno::generaTabla($ListaF);
            }
        }
        if(!isset($ListaF))
        {
            return 'no hay registros para el filtro indicado';
        }
        else
        {
           return $ListaF;
        }
    }

    private static function buscarXfecha($fecha)
    {
        $archivo = 'turnos.txt';
        $turnos = funciones::Listar($archivo);
        // var_dump($turnos);
        $existe = false;
        $listaFecha = array();
        if(isset($turnos))
        {
            foreach($turnos as $veh => $value)
            {
                if(isset($value->_patente))
                {
                    if($value->_fecha == $fecha)
                    {
                        $existe = true;
                        $turno = new Turno($value->_patente,$value->_fecha,$value->_marca,$value->_modelo,$value->_precio,$value->_tpoServicio);
                        array_push($listaFecha, $turno);
                    }   
                }
            }
        }
        if($existe == false)
        {
            return 'no existe filtro';
        }   
        else
        {
            return $listaFecha;
        }
    }

    private static function buscarXservicio($servicio)
    {
        $archivo = 'turnos.txt';
        $turnos = funciones::Listar($archivo);
        // var_dump($turnos);
        $existe = false;
        $listaServ = array();
        if(isset($turnos))
        {
            foreach($turnos as $veh => $value)
            {
                if(isset($value->_patente))
                {
                    if($value->_tpoServicio == $servicio)
                    {
                        $existe = true;
                        $turno = new Turno($value->_patente,$value->_fecha,$value->_marca,$value->_modelo,$value->_precio,$value->_tpoServicio);
                        array_push($listaServ, $turno);
                    }   
                }
            }
        }
        if($existe == false)
        {
            return 'no existe filtro';
        }   
        else
        {
            return $listaServ;
        }
    }
    //****************************************************************************//
    //********************Metodos de prueba***************************************//  
    //****************************************************************************//
    public static function tTurnos2($response)
    {
        $archivo = 'turnos.txt';
        $arrayT = funciones::Listar($archivo);
        $tablaObt = Turno::generaTablaArray($arrayT,$response);

        return $tablaObt;
    }

    private static function generaTablaArray($arrayT, $response)
    {
        $tabla = array();
        array_push($tabla,'<table>'); // Crear la tabla
        array_push($tabla,"<th>patente</th>");
        array_push($tabla,"<th>fecha</th>");
        array_push($tabla,"<th>marca</th>");
        array_push($tabla,"<th>modelo</th>");
        array_push($tabla,"<th>precio</th>");
        array_push($tabla,"<th>tipoServicio</th>");
        foreach($arrayT as $key => $value)
        {
            if(isset($value->_patente))
            {
                array_push($tabla,"<tr>"); // Por cada fila
                array_push($tabla,'<td>'.$value->_patente.'</td>');
                array_push($tabla,'<td>'.$value->_fecha.'</td>');
                array_push($tabla,'<td>'.$value->_marca.'</td>');
                array_push($tabla,'<td>'.$value->_modelo.'</td>');
                array_push($tabla,'<td>'.$value->_precio.'</td>');
                array_push($tabla,'<td>'.$value->_tpoServicio.'</td>');
                array_push($tabla,"</tr>");
            }
        }
        // $response->getBody()->write($tabla);
        return $tabla;
    }

    
}

?>