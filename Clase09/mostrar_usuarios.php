<?php
require_once __DIR__ . '/vendor/autoload.php';
include_once ("usuario.php");

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML("<h1>Usuarios</h1>");
$mpdf->WriteHTML(usuario::MostrarTablaUsuarios());
$mpdf->Output();