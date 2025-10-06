<?php
// Mostrar errores en desarrollo
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Obtener parámetro id
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Conexión a base de datos
$link = mysqli_connect("localhost", "root", "JoshelinLun407", "marketzone");

// Verificar conexión
if (!$link) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Establecer charset
mysqli_set_charset($link, "utf8");

// Consulta SQL - busca producto por ID
$sql = "SELECT * FROM productos WHERE id = {$id}";
$result = mysqli_query($link, $sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Producto por ID</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f5f5f5; }
        h1 { text-align: center; }
        .producto { background-color: white; padding: 20px; border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 0 auto; max-width: 600px; }
        .producto img { max-width: 200px; display: block; margin: 10px auto; }
        .campo { margin: 10px 0; }
        .campo strong { color: #333; }
    </style>
</head>
<body>
    <h1>Resultado de búsqueda por ID</h1>
    <div class="producto">
    <?php
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo '<div class="campo"><strong>ID:</strong> ' . htmlspecialchars($row['id']) . '</div>';
        echo '<div class="campo"><strong>Nombre:</strong> ' . htmlspecialchars($row['nombre']) . '</div>';
        echo '<div class="campo"><strong>Marca:</strong> ' . htmlspecialchars($row['marca']) . '</div>';
        echo '<div class="campo"><strong>Modelo:</strong> ' . htmlspecialchars($row['modelo']) . '</div>';
        echo '<div class="campo"><strong>Precio:</strong> $' . number_format($row['precio'], 2) . '</div>';
        echo '<div class="campo"><strong>Unidades:</strong> ' . htmlspecialchars($row['unidades']) . '</div>';
        echo '<div class="campo"><strong>Detalles:</strong> ' . htmlspecialchars($row['detalles']) . '</div>';
        echo '<div class="campo"><img src="' . htmlspecialchars($row['imagen']) . '" alt="' . htmlspecialchars($row['nombre']) . '" /></div>';
    } else {
        echo "<p>No se encontró ningún producto con ID = {$id}</p>";
    }
    mysqli_close($link);
    ?>
    </div>
</body>
</html>

