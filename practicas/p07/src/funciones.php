<?php
// funciones.php

// 1. Verificar si un número es múltiplo de 5 y 7

function esMultiploDe5y7($numero) {
    if ($numero % 5 == 0 && $numero % 7 == 0) {
        return "El número $numero SÍ es múltiplo de 5 y 7";
    } else {
        return "El número $numero NO es múltiplo de 5 y 7";
    }
}

// 2. Generar números hasta secuencia impar-par-impar

function generarSecuencia() {
    $matriz = [];
    $iteraciones = 0;
    do {
        $iteraciones++;
        $fila = [rand(1, 999), rand(1, 999), rand(1, 999)];
        $matriz[] = $fila;
    } while (!($fila[0] % 2 == 1 && $fila[1] % 2 == 0 && $fila[2] % 2 == 1));

    return [
        "matriz" => $matriz,
        "iteraciones" => $iteraciones,
        "totalNumeros" => $iteraciones * 3
    ];
}

// 3. Buscar número aleatorio múltiplo (while y do-while)

function encontrarMultiploWhile($num) {
    $contador = 0;
    while (true) {
        $contador++;
        $aleatorio = rand(1, 1000);
        if ($aleatorio % $num == 0) {
            return ["numero" => $aleatorio, "intentos" => $contador];
        }
    }
}

function encontrarMultiploDoWhile($num) {
    $contador = 0;
    do {
        $contador++;
        $aleatorio = rand(1, 1000);
    } while ($aleatorio % $num != 0);

    return ["numero" => $aleatorio, "intentos" => $contador];
}

// 4. Crear arreglo de ASCII a-z

function arregloAscii() {
    $arreglo = [];
    for ($i = 97; $i <= 122; $i++) {
        $arreglo[$i] = chr($i);
    }
    return $arreglo;
}

?>

