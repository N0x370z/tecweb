<?php
use TECWEB\MYAPI\Products;
require_once __DIR__ . '/myapi/Products.php';

$productos = new Products('marketzone');

if (isset($_GET['nombre'])) {
    $nombre = $_GET['nombre'];
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $productos->singleByName($nombre, $id);
}

echo $productos->getData();
?>