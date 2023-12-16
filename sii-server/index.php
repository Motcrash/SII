<?php
/* ****************************************
  Requerimientos
*******************************************/
require_once "controllers/routers.controller.php";
/*********************************************************
Distintas formas de utilizar la instrucción anterior 
**********************************************************/
/*
require "controllers/routers.controller.php";
include "controllers/routers.controller.php";
include_once "controllers/routers.controller.php";
*/


/*
$allowOrigin = [
  'http://apirestcliente.com'
];

if(in_array($_REQUEST('origin'), $allowOrigin)){
  header('Access-Control-Allow-Origin: http://apirestcliente.com');  
}
*/

//header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Origin: http://itchiisii.com'); 
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, id, idValor');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json');

$index = new RoutersController();
$index->index();


