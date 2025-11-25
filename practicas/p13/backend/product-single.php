<?php
use TECWEB\MYAPI\Products;
require_once __DIR__ . '/myapi/Products.php';

$productos = new Products('marketzone');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $productos->single($id);
}

echo $productos->getData();
?>