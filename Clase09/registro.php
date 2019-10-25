<?php
include_once ("usuario.php");
include_once ("AccesoDatos.php");
$loginData = isset($_POST["usuario_json"]) ? $_POST["usuario_json"] : NULL;

$objeto = json_decode($loginData);
$destino = "./fotos/" . date("Ymd_His") . ".jpg";
        
if(move_uploaded_file($_FILES["foto"]["tmp_name"], $destino) )
{
    $objRetorno = new stdClass();
    $objRetorno->Ok = true;
    $objRetorno->Path = $destino;
}

$usuario = new usuario();

$usuario->nombre = $objeto->nombre;
$usuario->apellido = $objeto->apellido;
$usuario->clave = $objeto->clave;
$usuario->correo = $objeto->correo;
$usuario->perfil = $objeto->perfil;
$usuario->estado = 1;
$usuario->foto = $destino;

$obj = new stdClass();

$obj->FilasAfectadas = $usuario->InsertarElUsuario();

echo json_encode($obj);