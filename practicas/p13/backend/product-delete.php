<?php
require_once __DIR__.'/../vendor/autoload.php';
use TECWEB\MYAPI\Delete\Delete;

$producto = new Delete('marketzone');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $producto->delete($id);
}

echo $producto->getData();
?>