<?php
    require_once __DIR__.'/../vendor/autoload.php';
    use TECWEB\MYAPI\Create\Create;

    $producto = new Create('marketzone');
    echo $producto->add( json_decode( json_encode($_POST) ) );
?>