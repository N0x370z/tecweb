<?php
header("Content-Type: application/xhtml+xml; charset=utf-8");

// Recibir datos del formulario
$nombre = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : 'No proporcionado';
$email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : 'No proporcionado';
$telefono = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : 'No proporcionado';
$historia = isset($_POST['story']) ? htmlspecialchars($_POST['story']) : 'No proporcionado';
$color = isset($_POST['color']) ? htmlspecialchars($_POST['color']) : 'No seleccionado';
$talla = isset($_POST['size']) ? htmlspecialchars($_POST['size']) : 'No seleccionada';
$caracteristicas = isset($_POST['features']) ? $_POST['features'] : array();

// Traducir colores
$colores = array(
    'red' => 'red',
    'blue' => 'blue',
    'black' => 'black',
    'silver' => 'silver'
);
$color_ingles = isset($colores[$color]) ? $colores[$color] : $color;

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
    <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />
    <title>Registro Recibido - Concurso Chidos mis Tenis</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            text-align: center;
            color: #333;
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin: 0 0 30px 0;
        }
        h2 {
            color: #333;
            margin-top: 0;
        }
        .contenedor-principal {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }
        .columna-izquierda {
            flex: 1;
        }
        .columna-derecha {
            width: 300px;
        }
        .seccion {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .dato {
            margin: 12px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border-left: 3px solid #4CAF50;
        }
        .dato strong {
            color: #555;
        }
        .diseno-tenis {
            background-color: #9ACD32;
            padding: 20px;
            border-radius: 8px;
            color: #333;
        }
        .diseno-tenis h2 {
            margin-top: 0;
            font-size: 18px;
            border-bottom: 2px solid #7BAA2C;
            padding-bottom: 10px;
        }
        .diseno-tenis ul {
            list-style-type: disc;
            padding-left: 20px;
            margin: 15px 0;
        }
        .diseno-tenis li {
            margin: 8px 0;
            font-weight: bold;
        }
        .diseno-tenis em {
            font-style: italic;
            color: #2c5a0a;
        }
        .certificado {
            text-align: center;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #7BAA2C;
        }
        .certificado img {
            max-width: 100%;
            height: auto;
        }
        .contenedor-boton {
            text-align: center;
            margin-top: 30px;
        }
        a {
            display: inline-block;
            padding: 12px 30px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        a:hover {
            background-color: #45a049;
        }
        @media (max-width: 768px) {
            .contenedor-principal {
                flex-direction: column;
            }
            .columna-derecha {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <h1>¡Gracias por Participar en el Concurso!</h1>
    
    <div class="contenedor-principal">
        <div class="columna-izquierda">
            <div class="seccion">
                <h2>Información Personal</h2>
                <div class="dato"><strong>Nombre:</strong> <?php echo $nombre; ?></div>
                <div class="dato"><strong>E-mail:</strong> <?php echo $email; ?></div>
                <div class="dato"><strong>Teléfono:</strong> <?php echo $telefono; ?></div>
                <div class="dato">
                    <strong>Tu historia:</strong><br />
                    <?php echo nl2br($historia); ?>
                </div>
            </div>
        </div>
        
        <div class="columna-derecha">
            <div class="diseno-tenis">
                <h2>Tu diseño de Tenis (si ganas)</h2>
                <ul>
                    <li>Color: <em><?php echo $color_ingles; ?></em></li>
                    <?php
                    $contador = 1;
                    if (count($caracteristicas) > 0) {
                        foreach ($caracteristicas as $feature) {
                            echo '<li>Característica ' . $contador . ': <em>' . htmlspecialchars($feature) . '</em></li>';
                            $contador++;
                        }
                    }
                    ?>
                    <li>Talla: <em><?php echo $talla; ?></em></li>
                </ul>
                
                <div class="certificado">
                    <a href="http://validator.w3.org/check?uri=referer">
                        <img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" />
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="contenedor-boton">
        <a href="formulario_concurso.html">← Volver al formulario</a>
    </div>
</body>
</html>
