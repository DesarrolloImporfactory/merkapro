<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
//Archivo de funciones PHP
require_once "../funciones.php";
require_once "../funciones_destino.php";
$get_data = file_get_contents('php://input');
$get_data = json_decode($get_data, true);
$motorizado = $get_data["motorizado"];
$guia_fast = $get_data["guia_fast"];

$sql = "INSERT INTO `motorizado_guia` (empleado_id, guia_fast) VALUES ('$motorizado', '$guia_fast')";
echo $sql;
$result = $conexion->query($sql);
if ($result) {
    echo json_encode(array('success' => 1, 'msg' => 'ok'));
} else {
    echo json_encode(array('success' => 0, 'msg' => 'Error al asignar motorizado'));
}
