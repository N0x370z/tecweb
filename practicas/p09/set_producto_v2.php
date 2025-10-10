<?php
// Datos de conexión a la base de datos
$host = 'localhost';
$user = 'root';
$password = 'JoshelinLun407';  // CAMBIA ESTO por tu contraseña
$database = 'marketzone';

// Crear conexión
$conexion = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Configurar charset
$conexion->set_charset("utf8");

// Recibir datos del formulario
$nombre = $_POST['nombre'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$precio = $_POST['precio'];
$detalles = $_POST['detalles'];
$unidades = $_POST['unidades'];
$imagen = $_POST['imagen'];

// Validar que no exista un producto con el mismo nombre, marca y modelo
$query_validacion = "SELECT * FROM productos WHERE nombre = '$nombre' AND marca = '$marca' AND modelo = '$modelo'";
$resultado = $conexion->query($query_validacion);

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <title>Resultado del Registro</title>
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
            margin-top: 0;
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
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Resultado del Registro de Producto</h1>
    
    <?php
    if ($resultado->num_rows > 0) {
        // El producto ya existe
        echo '<div class="mensaje error">';
        echo '<h2>❌ Error en el Registro</h2>';
        echo '<p><strong>El producto ya existe en la base de datos.</strong></p>';
        echo '<p>Ya existe un producto con las siguientes características:</p>';
        echo '<ul>';
        echo '<li><strong>Nombre:</strong> ' . htmlspecialchars($nombre) . '</li>';
        echo '<li><strong>Marca:</strong> ' . htmlspecialchars($marca) . '</li>';
        echo '<li><strong>Modelo:</strong> ' . htmlspecialchars($modelo) . '</li>';
        echo '</ul>';
        echo '<p>Por favor, verifica los datos e intenta nuevamente.</p>';
        echo '</div>';
    } else {
        // El producto no existe, proceder con la inserción
        $query_insercion = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen) 
                           VALUES ('$nombre', '$marca', '$modelo', $precio, '$detalles', $unidades, '$imagen')";
        
        if ($conexion->query($query_insercion) === TRUE) {
            echo '<div class="mensaje exito">';
            echo '<h2>✓ Producto Registrado Exitosamente</h2>';
            echo '<p>El producto ha sido agregado correctamente a la base de datos.</p>';
            echo '</div>';
            
            echo '<div class="resumen">';
            echo '<h2>Resumen de Datos Insertados</h2>';
            echo '<div class="dato"><strong>ID:</strong> ' . $conexion->insert_id . '</div>';
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
    }
    
    $conexion->close();
    ?>
    
    <a href="formulario_productos.html">← Registrar otro producto</a>
</body>
</html>
