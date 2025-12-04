<?php
use TECWEB\MYAPI\Products;
require_once __DIR__ . '/myapi/Products.php';

$productos = new Products('marketzone');

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $productos->search($search);
}

echo $productos->getData();
?>