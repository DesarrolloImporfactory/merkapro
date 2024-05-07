<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
print_r(file_get_contents(('php://input')));

$data = json_decode(file_get_contents('php://input'), true);
print_r($_POST);
$destino_url = "http://" . $_SERVER['HTTP_HOST'] . "/sysadmin/vistas/ajax/texto_plano.php";
file_put_contents($destino_url, $data);