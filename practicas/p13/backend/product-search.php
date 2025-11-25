<?php
require_once __DIR__.'/../vendor/autoload.php';
use TECWEB\MYAPI\Read\Read;

$producto = new Read('marketzone');

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $producto->search($search);
}

echo $producto->getData();
?>