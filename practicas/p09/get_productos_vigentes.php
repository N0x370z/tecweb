<?php
header("Content-Type: application/xhtml+xml; charset=utf-8");

// Conexión a base de datos
$link = mysqli_connect("localhost", "root", "JoshelinLun407", "marketzone");

// Verificar conexión
if (!$link) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Establecer charset
mysqli_set_charset($link, "utf8");

// Consulta SQL - filtra por productos NO eliminados (eliminado = 0)
$sql = "SELECT * FROM productos WHERE eliminado = 0";
$result = mysqli_query($link, $sql);

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
    <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />
    <title>Productos Vigentes - MarketZone</title>
    <style type="text/css">
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f5f5f5; }
        h1 { color: #333; text-align: center; padding: 20px; background-color: white;
             border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .info { background-color: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460;
                padding: 15px; border-radius: 4px; margin: 20px 0; }
        table { border-collapse: collapse; width: 100%; background-color: white;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #4CAF50; color: white; font-weight: bold; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        tr:hover { background-color: #f1f1f1; }
        img { max-width: 100px; height: auto; border-radius: 4px; display: block; margin: 0 auto; }
        .sin-imagen { color: #999; font-style: italic; text-align: center; }
        .precio { color: #4CAF50; font-weight: bold; }
        .no-resultados { text-align: center; padding: 40px; color: #666; background-color: white;
                         border-radius: 8px; margin-top: 20px; }
        .total { background-color: white; padding: 15px; margin-top: 20px; border-radius: 4px;
                 font-weight: bold; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .eliminado-no { color: #28a745; font-weight: bold; text-align: center; }
    </style>
</head>
<body>
    <h1>Productos Vigentes (No Eliminados)</h1>
    
    <div class="info">
        <strong>Nota:</strong> Solo se muestran los productos que NO han sido eliminados (eliminado = 0)
    </div>
    
    <?php
    if ($result && mysqli_num_rows($result) > 0) {
        echo '<table>';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Nombre</th>';
        echo '<th>Marca</th>';
        echo '<th>Modelo</th>';
        echo '<th>Precio</th>';
        echo '<th>Unidades</th>';
        echo '<th>Detalles</th>';
        echo '<th>Imagen</th>';
        echo '<th>Eliminado</th>';
        echo '</tr>';
        
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['nombre']) . '</td>';
            echo '<td>' . htmlspecialchars($row['marca']) . '</td>';
            echo '<td>' . htmlspecialchars($row['modelo']) . '</td>';
            echo '<td class="precio">$' . number_format($row['precio'], 2) . '</td>';
            echo '<td>' . htmlspecialchars($row['unidades']) . '</td>';
            echo '<td>' . htmlspecialchars($row['detalles']) . '</td>';
            
            // Manejo inteligente de imágenes
            echo '<td>';
            $imagen = htmlspecialchars($row['imagen']);
            if (!empty($imagen)) {
                // Si la imagen comienza con http:// o https://, usarla tal cual
                if (strpos($imagen, 'http://') === 0 || strpos($imagen, 'https://') === 0) {
                    echo '<img src="' . $imagen . '" alt="' . htmlspecialchars($row['nombre']) . '" />';
                } 
                // Si comienza con img/, agregar la ruta relativa correcta
                else if (strpos($imagen, 'img/') === 0) {
                    // Ajusta esta ruta según tu estructura de carpetas
                    echo '<img src="' . $imagen . '" alt="' . htmlspecialchars($row['nombre']) . '" />';
                }
                // Para cualquier otra ruta
                else {
                    echo '<img src="' . $imagen . '" alt="' . htmlspecialchars($row['nombre']) . '" />';
                }
            } else {
                echo '<span class="sin-imagen">Sin imagen</span>';
            }
            echo '</td>';
            
            echo '<td class="eliminado-no">' . htmlspecialchars($row['eliminado']) . '</td>';
            echo '</tr>';
        }
        
        echo '</table>';
        echo '<div class="total">Total de productos vigentes: ' . mysqli_num_rows($result) . '</div>';
    } else {
        echo '<p class="no-resultados">No hay productos vigentes. Todos los productos han sido eliminados o no hay productos registrados.</p>';
    }
    
    mysqli_close($link);
    ?>
</body>
</html>
