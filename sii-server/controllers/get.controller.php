<?php

require_once "models/get.model.php";

class GetController{

    /* **********************************************
    JUNTAR TODO
    *************************************************/    
    public function getUsuario($id_usuario){
        echo($id_usuario);
        $respuesta = GetModel::getUsuario($id_usuario);
        echo json_encode($respuesta); 
    }
    public function getDatos($tablesArray, $columnas, $relCamposArray, 
                            $linkToArray, $operadorRelToArray,$valueToArray, $operadorLogicoToArray, 
                            $orderByArray, $orderModeArray, 
                            $startAt, $endAt){

        $respuesta = GetModel::getDatos($tablesArray, $columnas, $relCamposArray, 
                                    $linkToArray, $operadorRelToArray,$valueToArray, $operadorLogicoToArray, 
                                    $orderByArray, $orderModeArray, 
                                    $startAt, $endAt);

        echo json_encode($respuesta, http_response_code($respuesta["status"])); 

        //$JSON = json_encode($respuesta, http_response_code($respuesta["status"])); 
        //return $JSON;
        
        //Con la línea 23 y el return de la 24 no funciona
    }

}