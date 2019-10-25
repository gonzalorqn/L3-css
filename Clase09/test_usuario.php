<?php
include_once ("usuario.php");
include_once ("AccesoDatos.php");

session_start();

$loginData = isset($_POST["usuario_json"]) ? $_POST["usuario_json"] : NULL;

$objeto = json_decode($loginData);

$usuario = new usuario();

$user = $usuario->ExisteEnBD($objeto->correo,$objeto->clave);

if($user->existe)
{
    $_SESSION["perfil"] = $user->user->perfil;
}

echo(json_encode($user));