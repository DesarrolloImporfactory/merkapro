<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
$ciudad_origen = $_POST['ciudad_origen'];
$ciudad_destino = $_POST['ciudad_destino'];
$provincia_destino = $_POST['provincia_destino'];
$precio_total = $_POST['precio_total'];
$destino = $ciudad_destino . "-" . $provincia_destino;
require_once "../../sysadmin/vistas/db.php";
require_once "../../sysadmin/vistas/php_conexion.php";

$sql = "SELECT * FROM `ciudad_cotizacion` WHERE `ciudad` like '$ciudad_destino%'";


$result = mysqli_query($conexion, $sql);

$row = mysqli_fetch_array($result);

$tieneCobertura = $row['cobertura_servientrega'];
if ($tieneCobertura == 1) {
   echo json_encode(array("trayecto" => $row['trayecto_servientrega']));
} else {
   echo json_encode(array("trayecto" => "x"));
}
