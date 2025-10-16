<?php
    include_once __DIR__.'/database.php';

    // SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
    $producto = file_get_contents('php://input');
    if(!empty($producto)) {
        // SE TRANSFORMA EL STRING DEL JASON A OBJETO
        $jsonOBJ = json_decode($producto);
        header('Content-Type: application/json; charset=utf-8');

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode([ 'ok' => false, 'message' => 'JSON inválido' ]);
            exit;
        }

        // Validación básica en servidor
        $nombre   = isset($jsonOBJ->nombre) ? trim($jsonOBJ->nombre) : '';
        $precio   = isset($jsonOBJ->precio) ? $jsonOBJ->precio : null;
        $unidades = isset($jsonOBJ->unidades) ? $jsonOBJ->unidades : null;
        $modelo   = isset($jsonOBJ->modelo) ? trim($jsonOBJ->modelo) : '';
        $marca    = isset($jsonOBJ->marca) ? trim($jsonOBJ->marca) : '';
        $detalles = isset($jsonOBJ->detalles) ? trim($jsonOBJ->detalles) : '';
        $imagen   = isset($jsonOBJ->imagen) ? trim($jsonOBJ->imagen) : '';

        if ($nombre === '' || $modelo === '' || $marca === '' || $detalles === '' || $imagen === '' || !is_numeric($precio) || !is_numeric($unidades)) {
            echo json_encode([ 'ok' => false, 'message' => 'Datos incompletos o inválidos' ]);
            exit;
        }

        // Escapar datos
        $nombreEsc   = $conexion->real_escape_string($nombre);
        $precioEsc   = $conexion->real_escape_string($precio);
        $unidadesEsc = $conexion->real_escape_string($unidades);
        $modeloEsc   = $conexion->real_escape_string($modelo);
        $marcaEsc    = $conexion->real_escape_string($marca);
        $detallesEsc = $conexion->real_escape_string($detalles);
        $imagenEsc   = $conexion->real_escape_string($imagen);

        // Verificar duplicado por nombre y eliminado = 0
        $sqlCheck = "SELECT id FROM productos WHERE nombre = '{$nombreEsc}' AND eliminado = 0 LIMIT 1";
        if ( $res = $conexion->query($sqlCheck) ) {
            $exists = $res->fetch_array(MYSQLI_ASSOC);
            $res->free();
            if ($exists) {
                echo json_encode([ 'ok' => false, 'message' => 'El producto ya existe (nombre duplicado).' ]);
                $conexion->close();
                exit;
            }
        } else {
            echo json_encode([ 'ok' => false, 'message' => 'Error al verificar duplicado: '.mysqli_error($conexion) ]);
            $conexion->close();
            exit;
        }

        // Insertar producto
        $sqlInsert = "INSERT INTO productos (nombre, precio, unidades, modelo, marca, detalles, imagen, eliminado) VALUES ('{$nombreEsc}', '{$precioEsc}', '{$unidadesEsc}', '{$modeloEsc}', '{$marcaEsc}', '{$detallesEsc}', '{$imagenEsc}', 0)";
        if ( $conexion->query($sqlInsert) ) {
            echo json_encode([ 'ok' => true, 'message' => 'Producto insertado correctamente.' ]);
        } else {
            echo json_encode([ 'ok' => false, 'message' => 'Error al insertar: '.mysqli_error($conexion) ]);
        }
        $conexion->close();
    }
?>