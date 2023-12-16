<?php
	require_once "controllers/post.controller.php";
	//$table Esta variable biene de routes    

	//Agarramos la cadena JSON que nos envia el cliente
    $postBodyJSON = file_get_contents("php://input");


	//Crearmos un arreglo asociativo con el JSON que llego
    //El true es para que sea un arreglo asociativo
    $datos = json_decode($postBodyJSON, true); 

	$response = new PostController();

	// **********************************************************
	// Verificamos si es una peticion para registrar USUARIOS
	// Aunque la operacion en la B de D es un UPDATE vamos a utilizar
	// el método POST
	// *********************************************************

	if(isset($_GET["registro"]) && $_GET["registro"] == true){
		$subFijo   = $_GET['subFijo'] ?? "usuario";
		return $response->postRegistro($table, $datos, $subFijo);
	}else if(isset($_GET["login"]) && $_GET["login"] == true){
		$subFijo   = $_GET['subFijo'] ?? "usuario";
		return $response->postLogin($table, $datos, $subFijo);
	}else{
		// *********************************************************
		// Solicitamos respuesta del controlador para insertar datos
		// *********************************************************
		return $response->insertDatos($table, $datos);
	}
	

	
	