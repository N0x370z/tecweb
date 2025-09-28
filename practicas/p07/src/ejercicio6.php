<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 6 - Parque Vehicular</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .formulario { border: 1px solid #ccc; padding: 20px; margin: 10px 0; }
        .resultado { border: 1px solid #ddd; padding: 15px; margin: 10px 0; background-color: #f9f9f9; }
        input, select { padding: 8px; margin: 5px; }
        button { padding: 10px 20px; background-color: #007cba; color: white; border: none; cursor: pointer; margin: 5px; }
        button:hover { background-color: #005a87; }
        table { border-collapse: collapse; width: 100%; margin: 10px 0; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .vehiculo { border: 1px solid #bbb; padding: 10px; margin: 10px 0; background-color: #fff; }
        .error { color: red; }
        .print-r { background-color: #f4f4f4; padding: 10px; font-family: monospace; white-space: pre-wrap; }
    </style>
</head>
<body>
    <?php include 'src/funciones.php'; ?>
    
    <h1>Ejercicio 6: Parque Vehicular</h1>
    
    <div class="formulario">
        <h2>Consultar Información Vehicular</h2>
        
        <form method="POST" action="ejercicio6.php">
            <table>
                <tr>
                    <td><label for="accion">Tipo de consulta:</label></td>
                    <td>
                        <select id="accion" name="accion" required>
                            <option value="">Seleccione una opción...</option>
                            <option value="matricula" <?php echo (isset($_POST['accion']) && $_POST['accion'] == 'matricula') ? 'selected' : ''; ?>>
                                Buscar por matrícula
                            </option>
                            <option value="todos" <?php echo (isset($_POST['accion']) && $_POST['accion'] == 'todos') ? 'selected' : ''; ?>>
                                Mostrar todos los vehículos
                            </option>
                            <option value="estructura" <?php echo (isset($_POST['accion']) && $_POST['accion'] == 'estructura') ? 'selected' : ''; ?>>
                                Mostrar estructura del arreglo
                            </option>
                        </select>
                    </td>
                </tr>
                <tr id="matricula-row" style="<?php echo (isset($_POST['accion']) && $_POST['accion'] == 'matricula') ? '' : 'display: none;'; ?>">
                    <td><label for="matricula">Matrícula:</label></td>
                    <td>
                        <input type="text" id="matricula" name="matricula" placeholder="Ej: UBN6338" 
                               value="<?php echo isset($_POST['matricula']) ? strtoupper($_POST['matricula']) : ''; ?>">
                        <small>Formato: LLLNNNN (3 letras + 4 números)</small>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit">Consultar</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    
    <script>
        document.getElementById('accion').addEventListener('change', function() {
            var matriculaRow = document.getElementById('matricula-row');
            if (this.value === 'matricula') {
                matriculaRow.style.display = '';
                document.getElementById('matricula').setAttribute('required', '');
            } else {
                matriculaRow.style.display = 'none';
                document.getElementById('matricula').removeAttribute('required');
            }
        });
    </script>
    
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['accion'])) {
            $accion = $_POST['accion'];
            $parqueVehicular = crearParqueVehicular();
            
            switch ($accion) {
                case 'matricula':
                    if (isset($_POST['matricula']) && !empty($_POST['matricula'])) {
                        $matricula = strtoupper(trim($_POST['matricula']));
                        $vehiculo = buscarVehiculoPorMatricula($parqueVehicular, $matricula);
                        
                        echo "<div class='resultado'>";
                        if ($vehiculo !== null) {
                            echo "<h3>Vehículo encontrado - Matrícula: $matricula</h3>";
                            echo "<div class='vehiculo'>";
                            echo "<h4>Información del Auto:</h4>";
                            echo "<ul>";
                            echo "<li><strong>Marca:</strong> {$vehiculo['Auto']['marca']}</li>";
                            echo "<li><strong>Modelo:</strong> {$vehiculo['Auto']['modelo']}</li>";
                            echo "<li><strong>Tipo:</strong> {$vehiculo['Auto']['tipo']}</li>";
                            echo "</ul>";
                            
                            echo "<h4>Información del Propietario:</h4>";
                            echo "<ul>";
                            echo "<li><strong>Nombre:</strong> {$vehiculo['Propietario']['nombre']}</li>";
                            echo "<li><strong>Ciudad:</strong> {$vehiculo['Propietario']['ciudad']}</li>";
                            echo "<li><strong>Dirección:</strong> {$vehiculo['Propietario']['direccion']}</li>";
                            echo "</ul>";
                            echo "</div>";
                        } else {
                            echo "<p class='error'><strong>No se encontró ningún vehículo con la matrícula: $matricula</strong></p>";
                            echo "<p>Matrículas disponibles: " . implode(', ', array_keys($parqueVehicular)) . "</p>";
                        }
                        echo "</div>";
                    } else {
                        echo "<div class='resultado'>";
                        echo "<p class='error'><strong>Error: Debe ingresar una matrícula.</strong></p>";
                        echo "</div>";
                    }
                    break;
                    
                case 'todos':
                    echo "<div class='resultado'>";
                    echo "<h3>Todos los vehículos registrados (" . count($parqueVehicular) . " vehículos)</h3>";
                    
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>Matrícula</th>";
                    echo "<th>Marca</th>";
                    echo "<th>Modelo</th>";
                    echo "<th>Tipo</th>";
                    echo "<th>Propietario</th>";
                    echo "<th>Ciudad</th>";
                    echo "<th>Dirección</th>";
                    echo "</tr>";
                    
                    foreach ($parqueVehicular as $matricula => $datos) {
                        echo "<tr>";
                        echo "<td><strong>$matricula</strong></td>";
                        echo "<td>{$datos['Auto']['marca']}</td>";
                        echo "<td>{$datos['Auto']['modelo']}</td>";
                        echo "<td>{$datos['Auto']['tipo']}</td>";
                        echo "<td>{$datos['Propietario']['nombre']}</td>";
                        echo "<td>{$datos['Propietario']['ciudad']}</td>";
                        echo "<td>{$datos['Propietario']['direccion']}</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                    break;
                    
                case 'estructura':
                    echo "<div class='resultado'>";
                    echo "<h3>Estructura del arreglo (print_r)</h3>";
                    echo "<div class='print-r'>";
                    echo htmlspecialchars(print_r($parqueVehicular, true));
                    echo "</div>";
                    echo "</div>";
                    break;
            }
        }
    }
    ?>
    
    <div class="formulario">
        <h3>Información del sistema:</h3>
        <ul>
            <li><strong>Total de vehículos registrados:</strong> 15</li>
            <li><strong>Formato de matrícula:</strong> LLLNNNN (3 letras + 4 números)</li>
            <li><strong>Tipos de vehículos:</strong> sedan, hatchback, camioneta</li>
        </ul>
        
        <h4>Matrículas de ejemplo para probar:</h4>
        <ul>
            <li>UBN6338 (Honda Camioneta 2020)</li>
            <li>UBN6339 (Mazda Sedan 2019)</li>
            <li>ABC1234 (Toyota Hatchback 2021)</li>
            <li>DEF5678 (Nissan Sedan 2018)</li>
        </ul>
    </div>
    
    <p><a href="index.php">← Volver al índice</a></p>
</body>
</html>
