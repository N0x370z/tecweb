<?php
    include_once __DIR__.'/database.php';

    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $data = array(
        'exists' => false,
        'message' => 'Nombre disponible'
    );
    
    // SE VERIFICA HABER RECIBIDO EL NOMBRE
    if(isset($_GET['nombre'])) {
        $nombre = $_GET['nombre'];
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        
        // Escapar caracteres especiales para prevenir SQL injection
        $nombre = $conexion->real_escape_string($nombre);
        
        // SE REALIZA LA QUERY DE BÚSQUEDA
        // Si hay ID, excluir ese producto de la búsqueda (para modo edición)
        if(!empty($id)) {
            $sql = "SELECT id FROM productos WHERE nombre = '{$nombre}' AND id != {$id} AND eliminado = 0";
        } else {
            $sql = "SELECT id FROM productos WHERE nombre = '{$nombre}' AND eliminado = 0";
        }
        
        if($result = $conexion->query($sql)) {
            // Si encuentra al menos un registro, el nombre ya existe
            if($result->num_rows > 0) {
                $data['exists'] = true;
                $data['message'] = 'El nombre ya está registrado';
            }
            $result->free();
        } else {
            $data['exists'] = false;
            $data['message'] = 'Error al verificar el nombre';
        }
        
        $conexion->close();
    }
    
    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
?>
