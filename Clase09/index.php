<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once './vendor/autoload.php';
include_once ("usuario.php");
include_once ("AccesoDatos.php");
$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;
$app = new \Slim\App(["settings" => $config]);

$app->group('/validaciones', function () {    
    $this->post('/', function (Request $request, Response $response) { 
        $ArrayDeParametros = $request->getParsedBody();
        $json = json_decode($ArrayDeParametros["usuario_json"]);
        $usuario = new usuario();

        $user = $usuario->ExisteEnBD($json->correo,$json->clave);

        if($user->existe)
        {
            $newResponse = $response->withJson($user,200);
        }
        else
        {
            $obj = new stdClass();
            $obj->mensaje = "No se encontro usuario";
            //$newResponse = $response->withJson("{'mensaje':'No se encontro usuario'}",403);
            $newResponse = $response->withJson($obj,403);
        }
        return $newResponse;
    
    });
});

$app->run();