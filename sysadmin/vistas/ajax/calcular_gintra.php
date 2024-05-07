<?php
require_once "../db.php";
require_once "../php_conexion.php";

$ciudad_origen = $_POST['ciudad'];

$sql = "SELECT * FROM `ciudad_cotizacion` WHERE `ciudad` = '$ciudad_origen'";
$result = mysqli_query($conexion, $sql);

$row = mysqli_fetch_array($result);

$trayecto = $row['trayecto_gintracom'];

$sql = "SELECT * FROM `cobertura_gintracom` WHERE `trayecto` = '$trayecto'";

$result = mysqli_query($conexion, $sql);

$row = mysqli_fetch_array($result);

if (!empty($row)) {
    $valor = $row['precio'];
} else {
    $valor = "x";
}
$valor = array("gintra" => $valor);

echo json_encode($valor);
