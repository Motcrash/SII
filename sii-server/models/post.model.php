<?php

require_once "connection.php";
require_once "models/validarSanitizar.php";

class PostModel{

    // *******************************************************************************************
    // CONSTRUIR, PREPARAR EJECUTAR Y REGRESAR EL RESULTADO DEL INSERT
    // *******************************************************************************************
    static public function insertDatos($tabla, $datos){
        $sanitiza = new ValidarSanitizar();

        $tablaArray = array($tabla);
        $llavesArrayIndexado = [];
        //$datosArrayIndexado = array();


        foreach($datos as $llave => $valor){
            array_push($llavesArrayIndexado, $llave);
        }

        // ********************************************************************************
        // Retornos de getVerificarTablasColumnas:
        // 0. Todo bien 
        // 1. Problemas con la tabla RECURSO NO ENCONTRADO
        // 2. Problemas con alguno de los campos
        $regresoVerificar = Connection::getVerificarTablasColumnas($tablaArray, $llavesArrayIndexado); 
        if($regresoVerificar == 1){
            $respuesta = array(
                'status' => 404,
                'titulo' => "Error",
                'mensaje' => "Recurso no localizado"
            );
            return $respuesta;                    
    
        }else if($regresoVerificar == 2){
            $respuesta = array(
                'status' => 400,
                'titulo' => "Error",
                'mensaje' => "Error en la solicitud"
            );
            return $respuesta;                    
        }

        /*****************************************************************************
        Mandarlos a Validar y Sanitizar los datos que llegaron desde el cliente        
        ***************************************************************************/
        $datos = $sanitiza->validarSanitizar($tabla, $datos);


        //En llave va a estra el nombre de la columna
        $columnas = "";
        $parametros = "";
        foreach($datos as $llave=>$valor){
            $columnas .= $llave . ",";

            /*************************************************
            La siguiente línea se utiliza solo si en lugar de:
             - Utilizar la línea 56 se utiliza la 57
             - Utilizar las líneas  62- 66 se utilizan las líneas 68 - 72
            **************************************************/
            $parametros .= ":$llave,";
        }
        $columnas = substr($columnas, 0 ,-1);
        $parametros = substr($parametros, 0 ,-1);

       
        //$sqlInsert = "INSERT INTO $tabla($columnas) VALUES (?, ?, ?, ?, ?, ?)";
        $sqlInsert = "INSERT INTO $tabla($columnas) VALUES ($parametros)";
        
        $conection = Connection::connect();//->prepare();
        $stmt = $conection->prepare($sqlInsert); 

        /*
        $i=1;
        foreach($datos as $llave=>$valor){
            $stmt->bindParam($i, $datos[$llave], PDO::PARAM_STR);
            $i++;
        }
        */
        
        
        foreach($datos as $llave=>$valor){
            $stmt->bindParam(":".$llave, $datos[$llave], PDO::PARAM_STR);
        }

        try{
            if($stmt -> execute()){

                $respuesta = array(
                    'status' => 200,
                    "id"     =>  $conection->lastInsertId(),
                    'titulo' => "Éxito",
                    "mensaje" => "Transaccion realizada con Éxito",
                );
                return $respuesta;

            }
        }catch(PDOException $ex){
            $respuesta = array(
                'status' => 500,
                'titulo' => "Error",
                'mensaje' => "Error en el Servidor"
            );
            return $respuesta;
        }
    }
}