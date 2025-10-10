<?php
// Datos de conexión a la base de datos
$host = 'localhost';
$user = 'root';
$password = 'JoshelinLun407'; 
$database = 'marketzone';

// Crear conexión
$conexion = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Configurar charset
$conexion->set_charset("utf8");

// DATOS EN CÓDIGO DURO (hardcoded)
$nombre = "Laptop HP Pavilion";
$marca = "HP";
$modelo = "Pavilion 15-eh2001la";
$precio = 15999.99;
$detalles = "Procesador AMD Ryzen 5, 8GB RAM, 256GB SSD";
$unidades = 10;
$imagen = "img/laptop_hp.jpg";

// Query de inserción
$query_insercion = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen) 
                   VALUES ('$nombre', '$marca', '$modelo', $precio, '$detalles', $unidades, '$imagen')";

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <title>Inserción de Producto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 700px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .mensaje {
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .exito {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        .resumen {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .resumen h2 {
            color: #333;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
        }
        .dato {
            margin: 10px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border-left: 3px solid #4CAF50;
        }
        .dato strong {
            color: #555;
            display: inline-block;
            width: 120px;
        }
        .codigo {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 15px;
            margin: 20px 0;
            font-family: 'Courier New', monospace;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <h1>Inserción de Producto con Datos en Código Duro</h1>
    
    <div class="codigo">
        <strong>Query ejecutada:</strong><br>
        <?php echo htmlspecialchars($query_insercion); ?>
    </div>
    
    <?php
    if ($conexion->query($query_insercion) === TRUE) {
        echo '<div class="mensaje exito">';
        echo '<h2>✓ Producto Insertado Exitosamente</h2>';
        echo '<p>El producto ha sido agregado correctamente a la base de datos.</p>';
        echo '</div>';
        
        echo '<div class="resumen">';
        echo '<h2>Datos Insertados</h2>';
        echo '<div class="dato"><strong>ID:</strong> ' . $conexion->insert_id . ' (auto-generado)</div>';
        echo '<div class="dato"><strong>Nombre:</strong> ' . htmlspecialchars($nombre) . '</div>';
        echo '<div class="dato"><strong>Marca:</strong> ' . htmlspecialchars($marca) . '</div>';
        echo '<div class="dato"><strong>Modelo:</strong> ' . htmlspecialchars($modelo) . '</div>';
        echo '<div class="dato"><strong>Precio:</strong> $' . number_format($precio, 2) . ' MXN</div>';
        echo '<div class="dato"><strong>Detalles:</strong> ' . htmlspecialchars($detalles) . '</div>';
        echo '<div class="dato"><strong>Unidades:</strong> ' . $unidades . '</div>';
        echo '<div class="dato"><strong>Imagen:</strong> ' . htmlspecialchars($imagen) . '</div>';
        echo '</div>';
    } else {
        echo '<div class="mensaje error">';
        echo '<h2>❌ Error al Insertar en la Base de Datos</h2>';
        echo '<p>Error: ' . $conexion->error . '</p>';
        echo '</div>';
    }
    
    $conexion->close();
    ?>
</body>
</html>
