<?php
require_once __DIR__.'/../vendor/autoload.php';
use TECWEB\MYAPI\Read\Read;

$producto = new Read('marketzone');

if (isset($_GET['nombre'])) {
    $nombre = $_GET['nombre'];
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $producto->singleByName($nombre, $id);
}

echo $producto->getData();
?>