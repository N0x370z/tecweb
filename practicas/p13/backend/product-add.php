<?php
require_once __DIR__.'/../vendor/autoload.php';
use TECWEB\MYAPI\Create\Create;

$producto = new Create('marketzone');
$productoData = file_get_contents('php://input');

if (!empty($productoData)) {
    $jsonOBJ = json_decode($productoData);
    $producto->add($jsonOBJ);
}

echo $producto->getData();
?>