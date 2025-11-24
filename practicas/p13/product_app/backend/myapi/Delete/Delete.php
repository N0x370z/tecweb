<?php
namespace TECWEB\MYAPI\Delete;

use TECWEB\MYAPI\DataBase;

class Delete extends DataBase {
    
    public function __construct($db, $user='root', $pass='12345678a') {
        parent::__construct($db, $user, $pass);
    }

    public function delete($id) {
        // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
        $data = array(
            'status'  => 'error',
            'message' => 'La consulta falló'
        );
        
        // SE VERIFICA HABER RECIBIDO EL ID
        if( isset($id) ) {
            // SE REALIZA LA QUERY DE ELIMINACIÓN LÓGICA
            $sql = "UPDATE productos SET eliminado=1 WHERE id = {$id}";
            if ( $this->conexion->query($sql) ) {
                $data['status'] =  "success";
                $data['message'] =  "Producto eliminado";
            } else {
                $data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this->conexion);
            }
            $this->conexion->close();
        }
        
        return json_encode($data, JSON_PRETTY_PRINT);
    }
}
?>