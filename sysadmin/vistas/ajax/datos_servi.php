<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "../db.php";
require_once "../php_conexion.php";
$ciudad = $_POST['origen_texto'];
$destino = $_POST['destino_c'];
$provincia = $_POST['provincia'];

$sql = "SELECT * FROM `ciudad_cotizacion` WHERE `ciudad` like '$ciudad%' ";

$result = mysqli_query($conexion, $sql);
$row = mysqli_fetch_array($result);



$codigo_servientrega = $row['codigo_ciudad_servientrega'];

$sql = "SELECT * FROM `ciudad_cotizacion` WHERE `ciudad` like '$destino%' AND `provincia` like '$provincia%'";
$result = mysqli_query($conexion, $sql);
$row = mysqli_fetch_array($result);

$codigo_servientrega_destino = $row['codigo_ciudad_servientrega'];

echo json_encode(array("codigo" => $codigo_servientrega_destino, "codigo_origen" => $codigo_servientrega));
