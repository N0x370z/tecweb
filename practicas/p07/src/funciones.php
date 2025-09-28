<?php
// funciones.php

// 1. Verificar si un número es múltiplo de 5 y 7

function esMultiploDe5y7($numero) {
    return ($numero % 5 == 0 && $numero % 7 == 0);
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

// 5. Verificar edad y sexo

function verificarPersona($edad, $sexo) {
    if ($sexo == "femenino" && $edad >= 18 && $edad <= 35) {
        return "Bienvenida, usted está en el rango de edad permitido.";
    } else {
        return "Lo sentimos, no cumple con los requisitos.";
    }
}

// 6. Parque vehicular

function parqueVehicular() {
    return [
        "ABC1234" => [
            "Auto" => ["marca" => "HONDA", "modelo" => 2020, "tipo" => "camioneta"],
            "Propietario" => ["nombre" => "Ana López", "ciudad" => "Puebla", "direccion" => "Centro"]
        ],
        "XYZ5678" => [
            "Auto" => ["marca" => "MAZDA", "modelo" => 2019, "tipo" => "sedan"],
            "Propietario" => ["nombre" => "Juan Pérez", "ciudad" => "CDMX", "direccion" => "Reforma 123"]
        ],
        "LMN4321" => [
            "Auto" => ["marca" => "TOYOTA", "modelo" => 2021, "tipo" => "hatchback"],
            "Propietario" => ["nombre" => "María Gómez", "ciudad" => "Guadalajara", "direccion" => "Av. Juárez 456"]
        ],
        "JKL8765" => [
            "Auto" => ["marca" => "FORD", "modelo" => 2018, "tipo" => "sedan"],
            "Propietario" => ["nombre" => "Carlos Ruiz", "ciudad" => "Monterrey", "direccion" => "Col. Centro"]
        ],
        "QWE1111" => [
            "Auto" => ["marca" => "CHEVROLET", "modelo" => 2022, "tipo" => "camioneta"],
            "Propietario" => ["nombre" => "Sofía Hernández", "ciudad" => "Querétaro", "direccion" => "5 de Febrero"]
        ],
        "RTY2222" => [
            "Auto" => ["marca" => "NISSAN", "modelo" => 2020, "tipo" => "sedan"],
            "Propietario" => ["nombre" => "Pedro Sánchez", "ciudad" => "Toluca", "direccion" => "Av. Las Torres"]
        ],
        "UIO3333" => [
            "Auto" => ["marca" => "KIA", "modelo" => 2021, "tipo" => "hatchback"],
            "Propietario" => ["nombre" => "Laura Díaz", "ciudad" => "Cancún", "direccion" => "Zona Hotelera"]
        ],
        "PAS4444" => [
            "Auto" => ["marca" => "BMW", "modelo" => 2019, "tipo" => "sedan"],
            "Propietario" => ["nombre" => "Ricardo Torres", "ciudad" => "Puebla", "direccion" => "Los Fuertes"]
        ],
        "DFG5555" => [
            "Auto" => ["marca" => "MERCEDES", "modelo" => 2023, "tipo" => "camioneta"],
            "Propietario" => ["nombre" => "Valeria Romero", "ciudad" => "CDMX", "direccion" => "Polanco"]
        ],
        "HJK6666" => [
            "Auto" => ["marca" => "AUDI", "modelo" => 2020, "tipo" => "sedan"],
            "Propietario" => ["nombre" => "Fernando Aguilar", "ciudad" => "León", "direccion" => "Blvd. Campestre"]
        ],
        "ZXC7777" => [
            "Auto" => ["marca" => "VOLKSWAGEN", "modelo" => 2018, "tipo" => "hatchback"],
            "Propietario" => ["nombre" => "Elena Vargas", "ciudad" => "Mérida", "direccion" => "Centro Histórico"]
        ],
        "BNM8888" => [
            "Auto" => ["marca" => "TESLA", "modelo" => 2022, "tipo" => "sedan"],
            "Propietario" => ["nombre" => "Miguel Castillo", "ciudad" => "Guadalajara", "direccion" => "Av. Vallarta"]
        ],
        "VFR9999" => [
            "Auto" => ["marca" => "HYUNDAI", "modelo" => 2019, "tipo" => "camioneta"],
            "Propietario" => ["nombre" => "Paola Rivera", "ciudad" => "Querétaro", "direccion" => "Col. Centro"]
        ],
        "TGB0000" => [
            "Auto" => ["marca" => "JEEP", "modelo" => 2021, "tipo" => "camioneta"],
            "Propietario" => ["nombre" => "Andrés Flores", "ciudad" => "Monterrey", "direccion" => "San Pedro"]
        ],
        "YHN5550" => [
            "Auto" => ["marca" => "FIAT", "modelo" => 2017, "tipo" => "hatchback"],
            "Propietario" => ["nombre" => "Carmen Morales", "ciudad" => "Toluca", "direccion" => "Col. Universidad"]
        ]
    ];
}

function buscarAuto($matricula) {
    $autos = parqueVehicular();
    return $autos[$matricula] ?? null;
}
?>

