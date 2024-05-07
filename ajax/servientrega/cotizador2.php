<?php

require_once "../../sysadmin/vistas/db.php";
require_once "../../sysadmin/vistas/php_conexion.php";


$trayecto = $_POST['trayecto'];

$sql = "SELECT * FROM `cobertura_servientrega` WHERE `tipo_cobertura` like '%$trayecto%'";

$result = mysqli_query($conexion, $sql);

$row = mysqli_fetch_array($result);

echo json_encode(array("precio" => $row['precio']));
