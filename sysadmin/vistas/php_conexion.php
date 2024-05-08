<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set("America/Guayaquil");

# conectare la base de datos
$conexion = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$conexion) {
    die("Imposible conectarse: " . mysqli_connect_error());
}
if (mysqli_connect_errno()) {
    die("Conexión falló: " . mysqli_connect_errno() . " : " . mysqli_connect_error());
}

function limpiar($tags) {
    return strip_tags($tags);
}
