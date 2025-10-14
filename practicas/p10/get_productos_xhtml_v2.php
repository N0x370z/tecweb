<?php
header("Content-Type: application/xhtml+xml; charset=utf-8");

// Obtener parámetro tope
$tope = isset($_GET['tope']) ? intval($_GET['tope']) : 0;

// Conexión a base de datos
$link = mysqli_connect("localhost", "root", "JoshelinLun407", "marketzone");

// Verificar conexión
if (!$link) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Establecer charset
mysqli_set_charset($link, "utf8");

// Consulta SQL - filtra por UNIDADES
$sql = "SELECT * FROM productos WHERE unidades <= {$tope}";
$result = mysqli_query($link, $sql);

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
    <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />
    <title>Productos - MarketZone</title>
    <style type="text/css">
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f5f5f5; }
        h1 { color: #333; text-align: center; padding: 20px; background-color: white;
             border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        table { border-collapse: collapse; width: 100%; background-color: white;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #4CAF50; color: white; font-weight: bold; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        tr:hover { background-color: #f1f1f1; }
        img { max-width: 100px; height: auto; border-radius: 4px; }
        .precio { color: #4CAF50; font-weight: bold; }
        .no-resultados { text-align: center; padding: 40px; color: #666; background-color: white;
                         border-radius: 8px; margin-top: 20px; }
        .btn-editar { background-color: #2196F3; color: white; padding: 8px 15px; 
                      text-decoration: none; border-radius: 4px; font-size: 12px;
                      display: inline-block; transition: background-color 0.3s; }
        .btn-editar:hover { background-color: #0b7dda; }
    </style>
    <script type="text/javascript">
        function editarProducto(id, nombre, marca, modelo, precio, detalles, unidades, imagen) {
            // Crear formulario dinámico
            var form = document.createElement("form");
            
            // Campo ID
            var inputId = document.createElement("input");
            inputId.type = 'hidden';
            inputId.name = 'id';
            inputId.value = id;
            form.appendChild(inputId);
            
            // Campo Nombre
            var inputNombre = document.createElement("input");
            inputNombre.type = 'hidden';
            inputNombre.name = 'nombre';
            inputNombre.value = nombre;
            form.appendChild(inputNombre);
            
            // Campo Marca
            var inputMarca = document.createElement("input");
            inputMarca.type = 'hidden';
            inputMarca.name = 'marca';
            inputMarca.value = marca;
            form.appendChild(inputMarca);
            
            // Campo Modelo
            var inputModelo = document.createElement("input");
            inputModelo.type = 'hidden';
            inputModelo.name = 'modelo';
            inputModelo.value = modelo;
            form.appendChild(inputModelo);
            
            // Campo Precio
            var inputPrecio = document.createElement("input");
            inputPrecio.type = 'hidden';
            inputPrecio.name = 'precio';
            inputPrecio.value = precio;
            form.appendChild(inputPrecio);
            
            // Campo Detalles
            var inputDetalles = document.createElement("input");
            inputDetalles.type = 'hidden';
            inputDetalles.name = 'detalles';
            inputDetalles.value = detalles;
            form.appendChild(inputDetalles);
            
            // Campo Unidades
            var inputUnidades = document.createElement("input");
            inputUnidades.type = 'hidden';
            inputUnidades.name = 'unidades';
            inputUnidades.value = unidades;
            form.appendChild(inputUnidades);
            
            // Campo Imagen
            var inputImagen = document.createElement("input");
            inputImagen.type = 'hidden';
            inputImagen.name = 'imagen';
            inputImagen.value = imagen;
            form.appendChild(inputImagen);
            
            // Configurar formulario
            form.method = 'POST';
            form.action = 'formulario_productos_v2.html';
            
            // Enviar formulario
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</head>
<body>
    <h1>Productos con <?php echo $tope; ?> o menos unidades</h1>
    
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
        echo '<th>Editar</th>';
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
            echo '<td><img src="' . htmlspecialchars($row['imagen']) . '" alt="' . htmlspecialchars($row['nombre']) . '" /></td>';
            
            // Botón de editar con JavaScript
            echo '<td>';
            echo '<a href="#" class="btn-editar" onclick="editarProducto(';
            echo '\'' . htmlspecialchars($row['id']) . '\', ';
            echo '\'' . htmlspecialchars($row['nombre']) . '\', ';
            echo '\'' . htmlspecialchars($row['marca']) . '\', ';
            echo '\'' . htmlspecialchars($row['modelo']) . '\', ';
            echo '\'' . htmlspecialchars($row['precio']) . '\', ';
            echo '\'' . htmlspecialchars($row['detalles']) . '\', ';
            echo '\'' . htmlspecialchars($row['unidades']) . '\', ';
            echo '\'' . htmlspecialchars($row['imagen']) . '\'';
            echo '); return false;">Editar</a>';
            echo '</td>';
            
            echo '</tr>';
        }
        
        echo '</table>';
    } else {
        echo '<p class="no-resultados">No se encontraron productos con ' . $tope . ' o menos unidades.</p>';
    }
    
    mysqli_close($link);
    ?>
</body>
</html>