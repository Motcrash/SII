<?php

require_once "models/delete.model.php";

class DeleteController{

    public function eliminarDatos($tabla, $datos){
        $respuesta = PutModel::eliminarDatos($tabla, $datos);

        //$JSON = json_encode($respuesta, http_response_code($respuesta["status"]));
        //return $JSON;

        echo json_encode($respuesta, http_response_code($respuesta["status"]));


    }

}