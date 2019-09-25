<?php
use \Psr\Http\Message\RequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require 'vendor/autoload.php';

//api
$config ['displayErrorDetails'] = true;
$config ['addContentLengthHeader']= false; 
$app = new \Slim\App(["settings" => $config]);
// control de datos

// $app->post('/cargarVehiculo/', function (Request $request, Response $response) {
//     // $name = $args['name'];
//     $arrayParam = $request->getParsedBody();
//     var_dump($arrayParam);
//     $response->getBody()->write("Hello, $arrayParam");
//     $newResponse = $response->whitJson($arrayParam,200);
//     return $response;
// });
$app->get('/', function (Request $request, Response $response){
    $response->getBody()->write("Hola bienvenido a la apirest... Ingresa tu nombre");
    return $response;
});

// $app->get('/usuarios[/{name}]', function (Request $request, Response $response, array $args) {
//     $name = $args['name'];
//     $response->getBody()->write("Hello, $name");

//     return $response;
// });

$app->run();
?>