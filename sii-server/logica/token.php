<?php
// *****************************************************************************
// Libreria para generar el token
// y Usar la clase JWT
require_once "vendor/autoload.php";
//De carpeta Firebase me posiciono en la caprpeta JWT y utilizo la clase JWT
use Firebase\JWT\JWT;

class Token{

    // *****************************************************
    // GENERAR TOKEN DE AUTENTIFICACIÓN
    // ****************************************************
    public static function jwt($id, $email, $subFijo){
        $time = time();
        $payload = array(
            "iat" => $time, //Hora en la que se genera el Token
            "exp" => $time + (60 * 60), //Tiempo en el que expirara el token en este ejemplo dura 1 hora
            "data" => [
                "id" => $id,
                "email" => $email
            ]
        );

        //"exp" => $time + (60 * 60 * 24), //Tiempo en el que expirara el token en este ejemplo dura 1 dia
        //"exp" => $time + 60, //Tiempo en el que expirara el token en este ejemplo dura 1 minuto
        //"exp" => $time + (60 * 10), //Tiempo en el que expirara el token en este ejemplo dura 10 minutos

        //ejecuto el método static de JWT  para que me genere el token
        $jwt = JWT::encode($payload, "fghjkl23456jkkjhl",'HS512');
        //La variable $jwt ya contiene el token y es la que vamos a subir a la B de D

        $data = array(
            "token_".$subFijo     => $jwt,
            "token_exp_".$subFijo => $payload["exp"]
        );

        return $data;

    }    
}