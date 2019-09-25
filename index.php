<?php
//composer require slim/slim "^3.12"
use \Psr\Http\Message\RequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require 'vendor/autoload.php';
require 'vehiculo.php';

//api
$config ['displayErrorDetails'] = true;
$config ['addContentLengthHeader']= false; 
$app = new \Slim\App(["settings" => $config]);
// control de datos

$app->post('/cargarVehiculo/', function (Request $request, Response $response) {
    // $name = $args['name'];
    $arrayParam = $request->getParsedBody();
    // var_dump($arrayParam);
    $marca = $arrayParam['marca'];
    $modelo = $arrayParam['modelo'];
    $patente = $arrayParam['patente'];
    $precio = $arrayParam['precio'];
    $response->getBody()->write("Hello, cargarVehiculo");
    $gvehiculo = new Vehiculo($marca,$modelo,$patente,$precio);
    $gvehiculo->guardarVehiculo($gvehiculo);
    $newResponse = $response->withJson($arrayParam,200);
    return $newResponse;
});
$app->get('/', function (Request $request, Response $response){
    $response->getBody()->write("Hola bienvenido a la apirest... Ingresa tu nombre");
    return $response;
});


$app->get('/consultarVehiculo/', function (Request $request, Response $response) {
    $parmqry = $request->getQueryParams();
    var_dump($parmqry);
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
    
    // $arrayParam = $request->getParsedBody();
    // var_dump($arrayParam);

    // $marca = $arrayParam['marca'];
    // $modelo = $arrayParam['modelo'];
    // $patente = $arrayParam['patente'];
    // $precio = $arrayParam['precio'];
    // $response->getBody()->write("Hello, cargarVehiculo");
    // $gvehiculo = new Vehiculo($marca,$modelo,$patente,$precio);
    // $gvehiculo->guardarVehiculo($gvehiculo);
    // $newResponse = $response->withJson($arrayParam,200);
    return $newResponse;
});

// $app->get('/usuarios[/{name}]', function (Request $request, Response $response, array $args) {
//     $name = $args['name'];
//     $response->getBody()->write("Hello, $name");

//     return $response;
// });

$app->run();
?>