<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 5 - Validación de Edad y Sexo</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .formulario { border: 1px solid #ccc; padding: 20px; margin: 10px 0; }
        .resultado { border: 1px solid #ddd; padding: 15px; margin: 10px 0; background-color: #f9f9f9; }
        input, select { padding: 8px; margin: 5px; }
        button { padding: 10px 20px; background-color: #007cba; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #005a87; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <?php include 'src/funciones.php'; ?>
    
    <h1>Ejercicio 5: Validación de Edad y Sexo</h1>
    
    <div class="formulario">
        <h2>Formulario de Validación</h2>
        <p>Ingrese sus datos para verificar si cumple con los criterios:</p>
        <ul>
            <li>Sexo: Femenino</li>
            <li>Edad: Entre 18 y 35 años</li>
        </ul>
        
        <form method="POST" action="ejercicio5.php">
            <table>
                <tr>
                    <td><label for="edad">Edad:</label></td>
                    <td>
                        <input type="number" id="edad" name="edad" min="1" max="120" required 
                               value="<?php echo isset($_POST['edad']) ? $_POST['edad'] : ''; ?>">
                    </td>
                </tr>
                <tr>
                    <td><label for="sexo">Sexo:</label></td>
                    <td>
                        <select id="sexo" name="sexo" required>
                            <option value="">Seleccione...</option>
                            <option value="femenino" <?php echo (isset($_POST['sexo']) && $_POST['sexo'] == 'femenino') ? 'selected' : ''; ?>>
                                Femenino
                            </option>
                            <option value="masculino" <?php echo (isset($_POST['sexo']) && $_POST['sexo'] == 'masculino') ? 'selected' : ''; ?>>
                                Masculino
                            </option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit">Validar</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['edad']) && isset($_POST['sexo'])) {
            $edad = $_POST['edad'];
            $sexo = $_POST['sexo'];
            
            // Validar que los datos no estén vacíos
            if (!empty($edad) && !empty($sexo)) {
                $mensaje = validarEdadSexo($edad, $sexo);
                
                // Determinar el tipo de mensaje para el estilo
                $clase = ($sexo === 'femenino' && $edad >= 18 && $edad <= 35) ? 'success' : 'error';
                
                echo "<div class='resultado'>";
                echo "<h3>Resultado de la validación:</h3>";
                echo "<p class='$clase'><strong>$mensaje</strong></p>";
                echo "<p><strong>Datos ingresados:</strong></p>";
                echo "<ul>";
                echo "<li>Edad: $edad años</li>";
                echo "<li>Sexo: " . ucfirst($sexo) . "</li>";
                echo "</ul>";
                echo "</div>";
            } else {
                echo "<div class='resultado'>";
                echo "<p class='error'><strong>Error: Todos los campos son obligatorios.</strong></p>";
                echo "</div>";
            }
        }
    }
    ?>
    
    <div class="formulario">
        <h3>Casos de prueba sugeridos:</h3>
        <ul>
            <li><strong>Válido:</strong> Edad: 25, Sexo: Femenino</li>
            <li><strong>Inválido (edad):</strong> Edad: 40, Sexo: Femenino</li>
            <li><strong>Inválido (sexo):</strong> Edad: 25, Sexo: Masculino</li>
            <li><strong>Inválido (ambos):</strong> Edad: 16, Sexo: Masculino</li>
        </ul>
    </div>
    
    <p><a href="index.php">← Volver al índice</a></p>
</body>
</html>
