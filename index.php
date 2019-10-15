<?php
//composer require slim/slim "^3.12"
use \Psr\Http\Message\RequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require 'vendor/autoload.php';
require 'vehiculo.php';
require 'servicio.php';
require 'turnos.php';

//api
$config ['displayErrorDetails'] = true;
$config ['addContentLengthHeader']= false; 
$app = new \Slim\App(["settings" => $config]);
//upload
$container = $app->getContainer();
$container['upload_directory'] = __DIR__ . '/foto';
// control de datos

$app->post('/cargarVehiculo/', function (Request $request, Response $response) {
    // $name = $args['name'];
    $arrayParam = $request->getParsedBody();
    // var_dump($arrayParam);
    $marca = $arrayParam['marca'];
    $modelo = $arrayParam['modelo'];
    $patente = $arrayParam['patente'];
    $precio = $arrayParam['precio'];
    $response->getBody()->write("Hello, cargarVehiculo".PHP_EOL);
    $gvehiculo = new Vehiculo($marca,$modelo,$patente,$precio,'');
    $gvehiculo->guardarVehiculo($gvehiculo);
    $newResponse = $response->withJson($arrayParam,200);
    return $newResponse;
});

//url de prueba 
$app->get('/', function (Request $request, Response $response){
    $response->getBody()->write("Hola bienvenido a la apirest... Ingresa tu nombre");
    return $response;
});


$app->get('/consultarVehiculo/', function (Request $request, Response $response) {
    $parmqry = $request->getQueryParams();
    // var_dump($parmqry);
    if(isset($parmqry['marca']))
    {
        $marca = $parmqry['marca'];
        $coincidencias = vehiculo::buscarXmarca($marca);
    }
    else
    {
        if(isset($parmqry['patente']))
        {
            $patente = $parmqry['patente'];
            $coincidencias = vehiculo::buscarXpatente($patente);
        }
        else
        {
            if(isset($parmqry['modelo']))
            {
                $modelo = $parmqry['modelo'];
                $coincidencias = vehiculo::buscarXmodelo($modelo);
            }
        }
    }
    // var_dump($coincidencias);
    $newResponse = $response->withJson($coincidencias,200);
    return $newResponse;
});

$app->post('/cargarTipoServicio/', function (Request $request, Response $response) {
    // $name = $args['name'];
    $arrayParam = $request->getParsedBody();
    // var_dump($arrayParam);
    $nombre = $arrayParam['nombre'];
    $id = $arrayParam['id'];
    $tipo = $arrayParam['tipo'];
    $precio = $arrayParam['precio'];
    $demora = $arrayParam['demora'];
    $response->getBody()->write("Hello, cargarServicio".PHP_EOL);
    $pServicio = new Servicio($nombre,$id,$tipo,$precio,$demora);
    $pServicio->guardarServicio($pServicio);
    $newResponse = $response->withJson($arrayParam,200);
    return $newResponse;
});

$app->get('/sacarTurno/', function(Request $request, Response $response){
    $parmqry = $request->getQueryParams();
    var_dump($parmqry);
    $patente = $parmqry['patente'];
    $fecha = $parmqry['fecha'];
    $result = turno::sacarTurno($patente,$fecha);
    $response->getBody()->write($result);
    $newResponse = $response->withJson($result,200);
    return $newResponse;
    // return $result;
});

$app->get('/turnos[/]', function(Request $request, Response $response){
    $result = turno::tTurnos();
    // $newResponse = $result->withJson($result,200);
    return $result;
    // return $result;
});

$app->get('/turnos2[/]', function(Request $request, Response $response){
    $result = turno::tTurnos2($response);
    $newResponse = $response->withJson($result,200);
    return $newResponse;
    // return $result;
});

$app->get('/inscripciones[/]', function(Request $request, Response $response){
    $parmqry = $request->getQueryParams();
    if(isset($parmqry['tpoServicio']))
    {
        $tpoServicio = $parmqry['tpoServicio'];
        $result = turno::inscripciones($tpoServicio,'tipoServicio');
    }
    else
    {
        $fecha = $parmqry['fecha'];
        $result = turno::inscripciones($fecha,'fecha');
    }
    // $newResponse = $result->withJson($result,200);
    return $result;

});

$app->post('/modificarVehiculo[/]', function (Request $request, Response $response) {
    $arrayParam = $request->getParsedBody();
    var_dump($arrayParam);
    $patente = $arrayParam['patente'];
    $marca = $arrayParam['marca'];
    $modelo = $arrayParam['modelo'];
    $precio = $arrayParam['precio'];
    $vehiculo = vehiculo::buscarXpatente($patente);
    // echo($vehiculo);
    //directorio imagenes del servidor 
    $directory = $this->get('upload_directory');
    // echo('uploadFiles'.$directory.'<br/>');
    //obtengo archivos
    $uploadedFiles = $request->getUploadedFiles();
    //una foto
    $unFile = $uploadedFiles['foto'];
    //path de archivo temporal
    $origen = $uploadedFiles["foto"]->file;

    
    if(isset($vehiculo)&& $vehiculo != 'no existe patente')
    {
        var_dump($vehiculo);
        if ($unFile->getError() === UPLOAD_ERR_OK) {
            $path = funciones::GuardaTemp2($unFile,$directory,$patente);
            vehiculo::modificarVehiculo($patente,$marca,$modelo,$precio,$path);
            echo('</br> ***modificado***');
            $resutl = '***vehiculo modificado***';
            $newResponse = $response->withJson($resutl,200);
        }
    }
    else{
        $resutl = 'no existe patente';
        $newResponse = $response->withJson($resutl,200);
    }
     return $newResponse;
});

$app->get('/vehiculos[/]', function(Request $request, Response $response){
    vehiculo::mostrarTabla();
    // $newResponse = $result->withJson($result,200);
    return $response;

});

$app->run();
?>