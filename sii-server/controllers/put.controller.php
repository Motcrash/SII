<?php

require_once "models/put.model.php";

class PutController{

    public function modificarDatos($tabla, $datos){
        $respuesta = PutModel::modificarDatos($tabla, $datos);

        echo json_encode($respuesta, http_response_code($respuesta["status"]));

    }
}