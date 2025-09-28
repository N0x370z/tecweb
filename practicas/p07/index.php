<?php
include "src/funciones.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica 7 - PHP</title>
</head>
<body>
    <h1>Práctica 7</h1>

    <!-- Ejercicio 1 -->
    <h2>1. Múltiplo de 5 y 7 (GET)</h2>
    <?php
    if (isset($_GET['numero'])) {
        $n = $_GET['numero'];
        echo esMultiploDe5y7($n) ? "$n es múltiplo de 5 y 7" : "$n no es múltiplo de 5 y 7";
    } else {
        echo "Pasa un número con ?numero=...";
    }
    ?>

    <!-- Ejercicio 2 -->
    <h2>2. Secuencia impar-par-impar</h2>
    <?php
    $res = generarSecuencia();
    echo "<pre>";
    print_r($res["matriz"]);
    echo "</pre>";
    echo "{$res['totalNumeros']} números obtenidos en {$res['iteraciones']} iteraciones";
    ?>

    <!-- Ejercicio 3 -->
    <h2>3. Múltiplo con while/do-while (GET)</h2>
    <?php
    if (isset($_GET['divisor'])) {
        $d = $_GET['divisor'];
        $w = encontrarMultiploWhile($d);
        $dw = encontrarMultiploDoWhile($d);
        echo "WHILE encontró {$w['numero']} en {$w['intentos']} intentos <br>";
        echo "DO-WHILE encontró {$dw['numero']} en {$dw['intentos']} intentos <br>";
    } else {
        echo "Pasa un número con ?divisor=...";
    }
    ?>

    <!-- Ejercicio 4 -->
    <h2>4. Arreglo ASCII a-z</h2>
    <table border="1">
        <tr><th>Código</th><th>Letra</th></tr>
        <?php
        foreach (arregloAscii() as $k => $v) {
            echo "<tr><td>$k</td><td>$v</td></tr>";
        }
        ?>
    </table>

    <!-- Ejercicio 5 -->
    <h2>5. Formulario Edad y Sexo (POST)</h2>
    <form method="post">
        Edad: <input type="number" name="edad" required><br>
        Sexo:
        <select name="sexo" required>
            <option value="femenino">Femenino</option>
            <option value="masculino">Masculino</option>
        </select><br>
        <input type="submit" value="Enviar">
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edad"]) && isset($_POST["sexo"])) {
        echo verificarPersona($_POST["edad"], $_POST["sexo"]);
    }
    ?>

    <!-- Ejercicio 6 -->
    <h2>6. Parque Vehicular</h2>
    <form method="get">
        Matrícula: <input type="text" name="matricula">
        <input type="submit" value="Buscar">
    </form>
    <?php
    if (isset($_GET['matricula'])) {
        $auto = buscarAuto($_GET['matricula']);
        if ($auto) {
            echo "<pre>";
            print_r($auto);
            echo "</pre>";
        } else {
            echo "No se encontró la matrícula.";
        }
    }

    echo "<h3>Todos los autos:</h3>";
    echo "<pre>";
    print_r(parqueVehicular());
    echo "</pre>";
    ?>
</body>
</html>

