<?php
    include_once __DIR__.'/database.php';

    // SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
    $producto = file_get_contents('php://input');
    
    if(!empty($producto)) {
        // SE TRANSFORMA EL STRING DEL JSON A OBJETO
        $jsonOBJ = json_decode($producto);
        header('Content-Type: application/json; charset=utf-8');

        // Validar que el JSON sea válido
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(['ok' => false, 'message' => 'ERROR: JSON inválido']);
            exit;
        }

        // ==================== VALIDACIONES DEL SERVIDOR ====================
        
        // Obtener y limpiar datos
        $nombre   = isset($jsonOBJ->nombre) ? trim($jsonOBJ->nombre) : '';
        $precio   = isset($jsonOBJ->precio) ? $jsonOBJ->precio : null;
        $unidades = isset($jsonOBJ->unidades) ? $jsonOBJ->unidades : null;
        $modelo   = isset($jsonOBJ->modelo) ? trim($jsonOBJ->modelo) : '';
        $marca    = isset($jsonOBJ->marca) ? trim($jsonOBJ->marca) : '';
        $detalles = isset($jsonOBJ->detalles) ? trim($jsonOBJ->detalles) : '';
        $imagen   = isset($jsonOBJ->imagen) ? trim($jsonOBJ->imagen) : 'img/default.png';

        // 1. Validar NOMBRE (obligatorio, máximo 100 caracteres)
        if ($nombre === '') {
            echo json_encode(['ok' => false, 'message' => 'ERROR: El nombre es obligatorio']);
            exit;
        }
        if (strlen($nombre) > 100) {
            echo json_encode(['ok' => false, 'message' => 'ERROR: El nombre debe tener máximo 100 caracteres']);
            exit;
        }

        // 2. Validar MARCA (obligatorio, máximo 25 caracteres)
        if ($marca === '' || $marca === 'NA') {
            echo json_encode(['ok' => false, 'message' => 'ERROR: La marca es obligatoria']);
            exit;
        }
        if (strlen($marca) > 25) {
            echo json_encode(['ok' => false, 'message' => 'ERROR: La marca debe tener máximo 25 caracteres']);
            exit;
        }

        // 3. Validar MODELO (obligatorio, máximo 25 caracteres)
        if ($modelo === '' || $modelo === 'XX-000') {
            echo json_encode(['ok' => false, 'message' => 'ERROR: El modelo es obligatorio']);
            exit;
        }
        if (strlen($modelo) > 25) {
            echo json_encode(['ok' => false, 'message' => 'ERROR: El modelo debe tener máximo 25 caracteres']);
            exit;
        }

        // 4. Validar PRECIO (obligatorio, debe ser mayor a 99.99)
        if (!is_numeric($precio)) {
            echo json_encode(['ok' => false, 'message' => 'ERROR: El precio debe ser un número válido']);
            exit;
        }
        $precioNum = floatval($precio);
        if ($precioNum <= 99.99) {
            echo json_encode(['ok' => false, 'message' => 'ERROR: El precio debe ser mayor a 99.99']);
            exit;
        }

        // 5. Validar DETALLES (obligatorio, máximo 250 caracteres)
        if ($detalles === '' || $detalles === 'NA') {
            echo json_encode(['ok' => false, 'message' => 'ERROR: Los detalles son obligatorios']);
            exit;
        }
        if (strlen($detalles) > 250) {
            echo json_encode(['ok' => false, 'message' => 'ERROR: Los detalles deben tener máximo 250 caracteres']);
            exit;
        }

        // 6. Validar UNIDADES (obligatorio, debe ser entero >= 0)
        if (!is_numeric($unidades)) {
            echo json_encode(['ok' => false, 'message' => 'ERROR: Las unidades deben ser un número válido']);
            exit;
        }
        $unidadesNum = intval($unidades);
        if ($unidadesNum < 0) {
            echo json_encode(['ok' => false, 'message' => 'ERROR: Las unidades deben ser mayor o igual a 0']);
            exit;
        }

        // ==================== FIN DE VALIDACIONES ====================

        // Escapar datos para prevenir SQL Injection
        $nombreEsc   = $conexion->real_escape_string($nombre);
        $precioEsc   = $conexion->real_escape_string($precioNum);
        $unidadesEsc = $conexion->real_escape_string($unidadesNum);
        $modeloEsc   = $conexion->real_escape_string($modelo);
        $marcaEsc    = $conexion->real_escape_string($marca);
        $detallesEsc = $conexion->real_escape_string($detalles);
        $imagenEsc   = $conexion->real_escape_string($imagen);

        // ==================== VERIFICACIÓN DE DUPLICADOS ====================
        // VERIFICAR SI EL PRODUCTO YA EXISTE (mismo nombre y eliminado = 0)
        $sqlCheck = "SELECT id, nombre FROM productos WHERE LOWER(TRIM(nombre)) = LOWER('{$nombreEsc}') AND eliminado = 0 LIMIT 1";
        
        if ($res = $conexion->query($sqlCheck)) {
            if ($res->num_rows > 0) {
                $exists = $res->fetch_array(MYSQLI_ASSOC);
                $res->free();
                echo json_encode([
                    'ok' => false, 
                    'message' => 'ERROR: El producto "' . $exists['nombre'] . '" ya existe en la base de datos (ID: ' . $exists['id'] . ')'
                ]);
                $conexion->close();
                exit;
            }
            $res->free();
        } else {
            echo json_encode([
                'ok' => false, 
                'message' => 'ERROR: Error al verificar duplicado: ' . mysqli_error($conexion)
            ]);
            $conexion->close();
            exit;
        }

        // ==================== INSERCIÓN ====================
        // INSERTAR EL PRODUCTO
        $sqlInsert = "INSERT INTO productos (nombre, precio, unidades, modelo, marca, detalles, imagen, eliminado) 
                      VALUES ('{$nombreEsc}', '{$precioEsc}', '{$unidadesEsc}', '{$modeloEsc}', '{$marcaEsc}', '{$detallesEsc}', '{$imagenEsc}', 0)";
        
        if ($conexion->query($sqlInsert)) {
            echo json_encode([
                'ok' => true, 
                'message' => 'ÉXITO: Producto agregado correctamente. ID: ' . $conexion->insert_id
            ]);
        } else {
            echo json_encode([
                'ok' => false, 
                'message' => 'ERROR: No se pudo insertar el producto. ' . mysqli_error($conexion)
            ]);
        }
        
        $conexion->close();
    } else {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => false, 'message' => 'ERROR: No se recibieron datos']);
    }
?>