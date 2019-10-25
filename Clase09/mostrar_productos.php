<?php
require_once __DIR__ . '/vendor/autoload.php';
include_once ("producto.php");

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML("<h1>Productos</h1>");
$mpdf->WriteHTML(Producto::MostrarTablaProductos());
$mpdf->Output();