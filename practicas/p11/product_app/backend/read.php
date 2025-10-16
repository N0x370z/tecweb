<?php
    include_once __DIR__.'/database.php';

    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $data = array();
    // Compatibilidad: si llega un id exacto, mantener soporte previo retornando arreglo con 0 o 1 elementos
    if( isset($_POST['id']) && $_POST['id'] !== '' ) {
        $id = $conexion->real_escape_string($_POST['id']);
        $sql = "SELECT * FROM productos WHERE id = '{$id}'";
        if ( $result = $conexion->query($sql) ) {
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $item = array();
                foreach($row as $key => $value) {
                    $item[$key] = utf8_encode($value);
                }
                $data[] = $item;
            }
            $result->free();
        } else {
            die('Query Error: '.mysqli_error($conexion));
        }
        $conexion->close();
        echo json_encode($data, JSON_PRETTY_PRINT);
        exit;
    }

    // Nueva búsqueda flexible por término parcial en nombre, marca o detalles
    if ( isset($_POST['q']) ) {
        $q = trim($_POST['q']);
        $q = $conexion->real_escape_string($q);
        $like = "%{$q}%";
        $sql = "SELECT * FROM productos WHERE eliminado = 0 AND (nombre LIKE '{$like}' OR marca LIKE '{$like}' OR detalles LIKE '{$like}')";
        if ( $result = $conexion->query($sql) ) {
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $item = array();
                foreach($row as $key => $value) {
                    $item[$key] = utf8_encode($value);
                }
                $data[] = $item;
            }
            $result->free();
        } else {
            die('Query Error: '.mysqli_error($conexion));
        }
        $conexion->close();
    }

    // SE HACE LA CONVERSIÓN DE ARRAY A JSON (ahora siempre arreglo)
    echo json_encode($data, JSON_PRETTY_PRINT);
?>