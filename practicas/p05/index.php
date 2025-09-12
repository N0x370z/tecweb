<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Práctica 5</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Determina cuál de las siguientes variables son válidas y explica por qué:</p>
    <p>$_myvar,  $_7var,  myvar,  $myvar,  $var7,  $_element1, $house*5</p>
    <?php
        
	$_myvar = "válida (comienza con guion bajo)";
	$_7var = "válida (comienza con guion bajo, luego número)";
	$myvar = "válida (letra inicial)";
	$var7 = "válida (termina con número)";
	$_element1 = "válida (comienza con guion bajo)";
	// $house*5 = "inválida"; // esta línea daría error
        
        echo '<h4>Respuesta:</h4>';   
    
        echo '<ul>';
        echo '<li>$_myvar es válida porque inicia con guión bajo.</li>';
        echo '<li>$_7var es válida porque inicia con guión bajo.</li>';
        echo '<li>myvar es inválida porque no tiene el signo de dolar ($).</li>';
        echo '<li>$myvar es válida porque inicia con una letra.</li>';
        echo '<li>$var7 es válida porque inicia con una letra.</li>';
        echo '<li>$_element1 es válida porque inicia con guión bajo.</li>';
        echo '<li>$house*5 es inválida porque el símbolo * no está permitido.</li>';
        echo '</ul>';

echo "<h2>Ejercicio 2</h2>";

$a = "ManejadorSQL";
$b = 'MySQL';
$c = &$a;

echo "<h3>Primer bloque</h3>";
echo "a: $a <br>";
echo "b: $b <br>";
echo "c: $c <br>";

$a = "PHP server";
$b = &$a;

echo "<h3>Segundo bloque</h3>";
echo "a: $a <br>";
echo "b: $b <br>";
echo "c: $c <br>";
echo "<p>Explicación: en el segundo bloque, tanto b como c referencian a a, por eso muestran el mismo valor.</p>";

unset($a, $b, $c);

echo "<h2>Ejercicio 3</h2>";

$a = "PHP5";
$z[] = &$a;
$b = "5a version de PHP";
$c = $b * 10; // dará 0 porque $b no es numérico
$a .= $b;
$b *= $c;     // sigue en 0
$z[0] = "MySQL";

echo "<p>a: "; var_dump($a); echo "</p>";
echo "<p>b: "; var_dump($b); echo "</p>";
echo "<p>c: "; var_dump($c); echo "</p>";
echo "<p>z: "; print_r($z); echo "</p>";

unset($a, $b, $c, $z);


echo "<h2>Ejercicio 4</h2>";

$GLOBALS['a'] = "PHP5";
$GLOBALS['z'][] = &$GLOBALS['a'];
$GLOBALS['b'] = "5a version de PHP";
$GLOBALS['c'] = $GLOBALS['b'] * 10;
$GLOBALS['a'] .= $GLOBALS['b'];
$GLOBALS['b'] *= $GLOBALS['c'];
$GLOBALS['z'][0] = "MySQL";

echo "<p>a: "; var_dump($GLOBALS['a']); echo "</p>";
echo "<p>b: "; var_dump($GLOBALS['b']); echo "</p>";
echo "<p>c: "; var_dump($GLOBALS['c']); echo "</p>";
echo "<p>z: "; print_r($GLOBALS['z']); echo "</p>";

unset($GLOBALS['a'], $GLOBALS['b'], $GLOBALS['c'], $GLOBALS['z']);


echo "<h2>Ejercicio 5</h2>";

$a = "7 personas";
$b = (integer) $a;  // toma solo el 7
$a = "9E3";
$c = (double) $a;   // notación científica = 9000

echo "<p>a: $a</p>";
echo "<p>b: $b</p>";
echo "<p>c: $c</p>";


    ?>
</body>
</html>
