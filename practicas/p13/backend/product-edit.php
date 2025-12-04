<?php
require_once __DIR__.'/../vendor/autoload.php';
use TECWEB\MYAPI\Update\Update;

$producto = new Update('marketzone');
$productoData = file_get_contents('php://input');

if (!empty($productoData)) {
    $jsonOBJ = json_decode($productoData);
    if (isset($jsonOBJ->id)) {
        $producto->edit($jsonOBJ);
    }
}

echo $producto->getData();
?>