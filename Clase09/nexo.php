<?php
include_once ("AccesoDatos.php");
include_once ("usuario.php");

$op = isset($_POST['op']) ? $_POST['op'] : NULL;
function MostrarTablaUsuarios()
{
    try
    {
        $user = "root";
        $pass = "";
        $connectionStr = "mysql:host=localhost;dbname=mercado;charset=utf8";

        $db = new PDO($connectionStr,$user,$pass);
        $obj = $db->prepare("SELECT `id`, `nombre`, `apellido`, `clave`, `perfil`, `estado`, `correo` FROM `usuarios` WHERE `id`= :id");
        $obj->bindParam(":id",$id,PDO::PARAM_INT);
        $obj->execute();

        $table = '<table border="3" style="border-collapse:collapse"><tr><td>ID</td><td>Nombre</td><td>Apellido</td><td>Perfil</td><td>Estado</td><td>Correo</td></tr>';
        while($row = $obj->fetch(PDO::FETCH_OBJ))
        {
            $table .= "<tr><td>" . $row->id . "</td><td>" . $row->nombre . "</td><td>" . $row->apellido . "</td><td>" . $row->perfil . "</td><td>" . $row->estado . "</td><td>" . $row->correo . "</td></tr>";
        }
        $table .= "</table>";
        echo $table;
    }
    catch(PDOException $e)
    {
        echo($e->getMessage());
    }
}