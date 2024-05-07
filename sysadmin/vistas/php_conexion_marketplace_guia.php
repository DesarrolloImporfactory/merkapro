<?php
# conectare la base de datos
 $cadena_json = file_get_contents('../db_destino_marketplace.php');
$info = json_decode($cadena_json, true);

// Verifica si la decodificación fue exitosa
if ($info !== null) {
    // Accede a cada valor por su clave
    $DB_HOST = $info['DB_HOST'];
    $DB_USER = $info['DB_USER'];
    $DB_PASS = $info['DB_PASS'];
    $DB_NAME = $info['DB_NAME'];

    $host_mp=$DB_HOST;
    $user_mp=$DB_USER;
    $pass_mp=$DB_PASS;
    $base_mp=$DB_NAME;
} else {
    echo "Error al decodificar el JSON.";
 
}
$conexion_marketplace = @mysqli_connect($host_mp, $user_mp, $pass_mp, $base_mp);

    

if (!$conexion_marketplace) {
    die("imposible conectarse: " . mysqli_error($conexion_marketplace));
}
if (@mysqli_connect_errno()) {
    die("Conexión falló: " . mysqli_connect_errno() . " : " . mysqli_connect_error());
}
date_default_timezone_set("America/Guayaquil");
mysqli_query($conexion_marketplace, "SET NAMES utf8");
mysqli_query($conexion_marketplace, "SET CHARACTER_SET utf");

function limpiar2($tags)
{
    $tags = strip_tags($tags);
    return $tags;
}
