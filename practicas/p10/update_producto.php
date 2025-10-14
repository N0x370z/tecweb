<?php
// Conexión a MySQL
$link = mysqli_connect("localhost", "root", "JoshelinLun407", "marketzone");

// Chequear conexión
if($link === false){
    die("ERROR: No pudo conectarse con la DB. " . mysqli_connect_error());
}

// Establecer charset
mysqli_set_charset($link, "utf8");

// Verificar que se recibieron datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Obtener y sanitizar datos del formulario
    $id = mysqli_real_escape_string($link, $_POST['id']);
    $nombre = mysqli_real_escape_string($link, $_POST['nombre']);
    $marca = mysqli_real_escape_string($link, $_POST['marca']);
    $modelo = mysqli_real_escape_string($link, $_POST['modelo']);
    $precio = mysqli_real_escape_string($link, $_POST['precio']);
    $detalles = mysqli_real_escape_string($link, $_POST['detalles']);
    $unidades = mysqli_real_escape_string($link, $_POST['unidades']);
    $imagen = mysqli_real_escape_string($link, $_POST['imagen']);
    
    // Si la imagen está vacía, usar imagen por defecto
    if (empty($imagen)) {
        $imagen = 'img/default.png';
    }
    
    // Construir la consulta UPDATE
    $sql = "UPDATE productos SET 
            nombre='$nombre', 
            marca='$marca', 
            modelo='$modelo', 
            precio=$precio, 
            detalles='$detalles', 
            unidades=$unidades, 
            imagen='$imagen' 
            WHERE id=$id";
    
    // Ejecutar la actualización del registro
    if(mysqli_query($link, $sql)){
        echo '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualización Exitosa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 600px;
            width: 100%;
        }
        h1 {
            color: #28a745;
            margin-bottom: 20px;
        }
        .icono-exito {
            font-size: 80px;
            color: #28a745;
            margin-bottom: 20px;
        }
        .info-producto {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: left;
        }
        .info-producto p {
            margin: 8px 0;
            color: #333;
        }
        .info-producto strong {
            color: #667eea;
        }
        .botones {
            margin-top: 30px;
        }
        .btn {
            display: inline-block;
            padding: 12px 25px;
            margin: 5px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: all 0.3s;
        }
        .btn-primary {
            background-color: #667eea;
            color: white;
        }
        .btn-primary:hover {
            background-color: #5568d3;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icono-exito">✅</div>
        <h1>¡Producto Actualizado Exitosamente!</h1>
        
        <div class="info-producto">
            <p><strong>ID:</strong> ' . htmlspecialchars($id) . '</p>
            <p><strong>Nombre:</strong> ' . htmlspecialchars($nombre) . '</p>
            <p><strong>Marca:</strong> ' . htmlspecialchars($marca) . '</p>
            <p><strong>Modelo:</strong> ' . htmlspecialchars($modelo) . '</p>
            <p><strong>Precio:</strong> $' . number_format($precio, 2) . '</p>
            <p><strong>Unidades:</strong> ' . htmlspecialchars($unidades) . '</p>
        </div>
        
        <div class="botones">
            <a href="get_productos_vigentes_v2.php" class="btn btn-primary">Ver Productos Vigentes</a>
            <a href="get_productos_xhtml_v2.php?tope=100" class="btn btn-secondary">Ver Productos por Unidades</a>
        </div>
    </div>
</body>
</html>';
    } else {
        echo '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error en Actualización</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 600px;
            width: 100%;
        }
        h1 {
            color: #dc3545;
            margin-bottom: 20px;
        }
        .icono-error {
            font-size: 80px;
            color: #dc3545;
            margin-bottom: 20px;
        }
        .error-detalle {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
            text-align: left;
            word-wrap: break-word;
        }
        .btn {
            display: inline-block;
            padding: 12px 25px;
            margin-top: 20px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            background-color: #6c757d;
            color: white;
            transition: all 0.3s;
        }
        .btn:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icono-error">❌</div>
        <h1>Error al Actualizar</h1>
        
        <div class="error-detalle">
            <p><strong>No se pudo ejecutar la consulta SQL:</strong></p>
            <p>' . htmlspecialchars($sql) . '</p>
            <p><strong>Error:</strong> ' . mysqli_error($link) . '</p>
        </div>
        
        <a href="javascript:history.back()" class="btn">Volver al Formulario</a>
    </div>
</body>
</html>';
    }
} else {
    echo '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Denegado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }
        h1 {
            color: #ff9800;
            margin-bottom: 20px;
        }
        .icono-advertencia {
            font-size: 80px;
            color: #ff9800;
            margin-bottom: 20px;
        }
        p {
            color: #666;
            font-size: 16px;
            margin: 20px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 25px;
            margin-top: 20px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            background-color: #667eea;
            color: white;
            transition: all 0.3s;
        }
        .btn:hover {
            background-color: #5568d3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icono-advertencia">⚠️</div>
        <h1>Acceso Denegado</h1>
        <p>Este archivo solo puede ser accedido mediante el método POST desde el formulario de edición.</p>
        <a href="get_productos_vigentes_v2.php" class="btn">Ir a Productos</a>
    </div>
</body>
</html>';
}

// Cerrar la conexión
mysqli_close($link);
?>