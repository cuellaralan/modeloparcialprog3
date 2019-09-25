<?php
//ar -> manejador
class Funciones
{
    public static function Listar($archivo)
    {
        $ar = fopen($archivo,"r");  
        $miarray = array();
        while(!feof($ar))
        {
            array_push($miarray,json_decode(fgets($ar))); 
        }
        fclose($ar);
    return ($miarray);
    }

    public static function Guardar($objeto,$archivo,$modo)
    {
        $ar = fopen($archivo,$modo); 
        $codificado = json_encode($objeto);
        fwrite($ar,$codificado.PHP_EOL);
        fclose($ar);
    }

    public static function ModificarxID($id,$objeto,$archivo)
    {   
        $array1 = funciones::Listar($archivo);
        //modificar posición de array segun ID
        //llamar a función guardar por C/id del aray retornado por listar
        

    }

    public static function GuardaTemp($origen,$destino,$nomarch)
    {
        setlocale(LC_TIME,"es_RA");
        $fecha = date("Y-m-d");
        $hora = date("H-i-s");
        $extension = funciones::obtengoExt($nomarch);
        $destino = $destino.'_'.$fecha.';'.$hora.$extension;
        move_uploaded_file($origen,$destino);
    }

    public static function obtengoExt($nomarch)
    {
        $cantidad = strlen($nomarch);
        $start = $cantidad - 4 ;
        $ext = substr($nomarch, $start, 4);
        
        return $ext;
    }

    public static function GuardaTemp2($origen,$destino,$nomarch,$legajo)
    {
        $extension = funciones::obtengoExt($nomarch);
        $path= $destino.$legajo.$extension;
        move_uploaded_file($origen,$path);
        return $path;
    }
}

?>