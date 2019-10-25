<?php
session_start();
if(!isset($_SESSION["perfil"]))
{
    header("location:./index.html");
}

if($_SESSION["perfil"] == 1)
{
    echo '<a href="mostrar_usuarios.php">Listado usuarios</a><br>';
}

echo '<a href="mostrar_productos.php"> Listado productos</a>';