<?php
class usuario
{
    public $id;
    public $nombre;
    public $apellido;
    public $clave;
    public $perfil;
    public $estado;
    public $correo;
    public $foto;

    public function MostrarDatos()
    {
        return $this->id." - ".$this->nombre." - ".$this->apellido." - ".$this->clave." - ".$this->perfil." - ".$this->estado." - ".$this->correo;
    }

    public static function TraerTodosLosUsuarios()
    {    
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT `id`, `nombre`, `apellido`, `clave`, `perfil`, `estado`, `correo`, `foto` FROM `usuarios` WHERE 1");        
        
        $consulta->execute();
        
        $consulta->setFetchMode(PDO::FETCH_INTO, new usuario);                                                

        return $consulta; 
    }

    public function InsertarElUsuario()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO usuarios(nombre, apellido, clave, perfil, estado, correo, foto) VALUES (:nombre,:apellido,:clave,:perfil,:estado,:correo, :foto)");
        
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
        $consulta->bindValue(':correo', $this->correo, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(':perfil', $this->perfil, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_INT);
        $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);

        $consulta->execute();
        return $consulta->rowCount();
    }

    public function ExisteEnBD($correo,$clave)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM `usuarios` WHERE `clave` = :clave && `correo` = :correo");        
        $consulta->bindValue(":clave",$clave,PDO::PARAM_STR);
        $consulta->bindValue(":correo",$correo,PDO::PARAM_STR);
        $consulta->execute();
        $obj = new stdClass();
        if($consulta->rowCount() == 0)
        {
            $obj->existe = false;
        }
        else
        {
            $obj->existe = true;
            $obj->user = $consulta->fetchObject();
        }
        return $obj;
    }

    public static function MostrarTablaUsuarios()
    {
        try
        {
            $user = "root";
            $pass = "";
            $connectionStr = "mysql:host=localhost;dbname=mercado;charset=utf8";

            $db = new PDO($connectionStr,$user,$pass);
            $obj = $db->prepare("SELECT * FROM `usuarios`");
            $obj->execute();

            $table = '<table border="1" style="border-collapse:collapse"><tr><td>ID</td><td>Nombre</td><td>Apellido</td><td>Perfil</td><td>Estado</td><td>Correo</td><td>Foto</td></tr>';
            while($row = $obj->fetch(PDO::FETCH_OBJ))
            {
                $table .= "<tr><td>" . $row->id . "</td><td>" . $row->nombre . "</td><td>" . $row->apellido . "</td><td>" . $row->perfil . "</td><td>" . $row->estado . "</td><td>" . $row->correo . "</td><td><img src='" . $row->foto . "' style='width:100px;height:100px;'></td></tr>";
            }
            $table .= "</table>";
            return $table;
        }
        catch(PDOException $e)
        {
            return $e->getMessage();
        }
    }
}