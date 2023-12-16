<?php

require_once "models/post.model.php";
require_once "models/get.model.php";
require_once "models/put.model.php";
require_once "logica/token.php";

require_once "models/connection.php";

// *****************************************************************************
// Libreria para generar el token
// y Usar la clase JWT
require_once "vendor/autoload.php";
//De carpeta Firebase me posiciono en la caprpeta JWT y utilizo la clase JWT
use Firebase\JWT\JWT;


class PostController
{

    /*************************************************************
    Eliminar espacios en blanco al final y al principio de cada elemento
    de los arreglos 
     **************************************************************/
    function eliminarEspacios($arreglo)
    {
        for ($i = 0; $i < count($arreglo); $i++) {
            $arreglo[$i] = trim($arreglo[$i]);
        }
        return $arreglo;
    }

    public function insertDatos($tabla, $datos)
    {
        $respuesta = PostModel::insertDatos($tabla, $datos);

        echo json_encode($respuesta, http_response_code($respuesta["status"]));
    }

    public function postRegistro($tabla, $datos,  $subFijo)
    {
        $val_pass  = isset($datos["password_" . $subFijo]) ? $datos["password_" . $subFijo] : null;
        $val_email = isset($datos["email_" . $subFijo]) ? $datos["email_" . $subFijo] : null;

        //if(isset($datos["password_" . $subFijo]) && isset($datos["email_" . $subFijo])){
        if ($val_pass != null && $val_email != null) {

            /*******************************************************************************
            Para crear la contraseña encriptada:
            password_hash(nueva, PASSWORD_DEFAULT);
            $nueva: Es la que teclea cunado va a crear la contraseña
            PASSWORD_DEFAULT: Usar el algoritmo bcrypt (predeterminado a partir de PHP 5.5.0). 
            Observe que esta constante está diseñada para cambiar siempre que se añada un algoritmo
            nuevo y más fuerte a PHP. Por esta razón, la longitud del resultado de usar este 
            identificador puede cambiar con el tiempo. Por lo tanto, se recomienda almacenar 
            el resultado en una columna de una base de datos que pueda apliarse a más
            de 60 caracteres (255 caracteres sería una buena elección).
             *******************************************************************************/

            //Generar Password encriptado      
            $passwordEncriptado = password_hash($datos["password_" . $subFijo], PASSWORD_DEFAULT);
            $datos["password_" . $subFijo] = $passwordEncriptado;
            //Guardar password encriptado
            $respuesta = PostModel::insertDatos($tabla, $datos);
            $id = $respuesta["id"];

            //Generar Token
            //Creamos el Token
            $dataToken = Token::jwt($id, $val_email, $subFijo);

            //$regresoGuardarTokeBD = Token::guardarToken($tabla, $dataToken, $subFijo, $id);
            $_SERVER['HTTP_ID'] = "id_" . $subFijo;
            $_SERVER['HTTP_IDVALOR'] = $id;
            $regresoGuardarTokeBD = PutModel::modificarDatos($tabla, $dataToken, $id);

            $datos = array(
                "token"      => $dataToken["token_" . $subFijo],
                "token_exp"  => $dataToken["token_exp_" . $subFijo]
            );

            // ****************************************************************
            $respuesta = array(
                'status' => 200,
                'titulo' => "Éxito",
                'mensaje' => "Usuario Creado con Éxito",
                'datos'   => $datos
            );
        } else {
            $respuesta = array(
                'status' => 400,
                'titulo' => "Error",
                'mensaje' => "Error en la solicitud"
            );
        }
        echo json_encode($respuesta, http_response_code($respuesta["status"]));
    }
    // GABS
    public function postLogin($tabla, $datos,  $subFijo)
    {
        if (isset($datos["pass"]) && isset($datos["id_" . $subFijo])) {

            //Concultar el password de la B de D
            $tablesArray = [$tabla];
            $tablesArray = $this->eliminarEspacios($tablesArray);
            //$columnas = "password_" . $subFijo;
            $columnas = "*";
            $relCamposArray = array();
            $linkToArray = ["id_" . $subFijo];
            $operadorRelToArray = ["="];
            $valueToArray = [$datos["id_" . $subFijo]];
            $operadorLogicoToArray = array();
            $orderByArray = array();
            $orderModeArray = array();
            $startAt = null;
            $endAt = null;

            // **********************************************************
            //Relizar la consulta en la Base de Datos para verificar Que exista passw y correo
            // ***********************************************************
            $respuestaExiste = GetModel::getDatos(
                $tablesArray,
                $columnas,
                $relCamposArray,
                $linkToArray,
                $operadorRelToArray,
                $valueToArray,
                $operadorLogicoToArray,
                $orderByArray,
                $orderModeArray,
                $startAt,
                $endAt
            );

            $status = $respuestaExiste["status"];
            $numReg = $respuestaExiste["numReg"];
            if ($status == "200") {
                if ($numReg == 1) {
                    $datosConsultadosTodosRegistros = $respuestaExiste["datos"];
                    $datosConsultados = $datosConsultadosTodosRegistros[0];

                    $parametroPassword = "pass";
                    $id                = "id_" . $subFijo;
                    $email             = "id_" . $subFijo;

                    $contrasena_BD = $datosConsultados->$parametroPassword;
                    $id            = $datosConsultados->$id;
                    $email         = $datosConsultados->$email;

                    // *******************************************************************************
                    //Verificar si el passwor que capturo el usuario es igual al
                    //Password que esta almacenado en al B de D
                    // ******************************************************************************
                    if ($datos["pass"] === $contrasena_BD) {

                        //Creamos el Token
                        $dataToken = Token::jwt($id, $email, $subFijo);

                        $_SERVER['HTTP_ID'] = "id_" . $subFijo;
                        $_SERVER['HTTP_IDVALOR'] = $id;
                        $regresoGuardarTokeBD = PutModel::modificarDatos($tabla, $dataToken, $id);

                        //Verificamos si hubo exito en la actualizacion del token
                        $numReg = 0;
                        if ($numReg == 1) {
                            $datos = array(
                                "token"      => $dataToken["token_" . $subFijo],
                                "token_exp"  => $dataToken["token_exp_" . $subFijo]
                            );
                            // ****************************************************************
                            $respuesta = array(
                                'status' => 200,
                                'titulo' => "Éxito",
                                'mensaje' => "Password y Contraseña Correctos Token Guardado",
                                'datos'   => $datos
                            );
                            // ***************************************************************
                        } else {
                            // ****************************************************************
                            $respuesta = array(
                                'status' => 200,
                                'titulo' => "Éxito",
                                'mensaje' => "Password y Contraseña Correctos Token No se Guardo",
                            );
                            // ***************************************************************
                        }
                    } else {

                        $respuesta = array(
                            'status' => 400,
                            'titulo' => "Error",
                            'mensaje' => "Password y/o Contraseña Incorrectos"
                        );
                    }
                } else {
                    $respuesta = array(
                        'status' => 400,
                        'titulo' => "Error",
                        'mensaje' => "Password y/o Contraseña Incorrectos"
                    );
                }
            } else {
                $respuesta = array(
                    'status' => 400,
                    'titulo' => "Error",
                    'mensaje' => "Password y/o Contraseña Incorrectos"
                );
            }
        } else {
            $respuesta = array(
                'status' => 400,
                'titulo' => "Error",
                'mensaje' => "Error en la solicitud"
            );
        }
        echo json_encode($respuesta, http_response_code($respuesta["status"]));
    }
    // FINAL GABS


}
