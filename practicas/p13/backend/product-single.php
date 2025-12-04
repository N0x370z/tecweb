<?php
require_once __DIR__.'/../vendor/autoload.php';
use TECWEB\MYAPI\Read\Read;

$producto = new Read('marketzone');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $producto->single($id);
}

echo $producto->getData();
?>