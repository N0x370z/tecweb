<?php
    // Configuración de la base de datos
    $host = 'localhost';
    $user = 'root';         
    $password = 'JoshelinLun407'; 
    $database = 'marketzone'; // Nombre de tu base de datos
    
    // Crear conexión
    $conexion = new mysqli($host, $user, $password, $database);
    
    // Verificar conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    
    // Establecer charset UTF-8 para caracteres especiales
    $conexion->set_charset("utf8");
?>