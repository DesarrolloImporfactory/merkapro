<?php
# conectare la base de datos
//echo 'asd';
if (isset($send)) {
    $cadena_json = file_get_contents('../../vistas/db_destino.php');
} else {
    $cadena_json = file_get_contents('../db_destino_guia.php');
}
$info = json_decode($cadena_json, true);
// Verifica si la decodificación fue exitosa
if ($info !== null) {
    // Accede a cada valor por su clave
    $DB_HOST = $info['DB_HOST'];
    $DB_USER = $info['DB_USER'];
    $DB_PASS = $info['DB_PASS'];
    $DB_NAME = $info['DB_NAME'];
    //echo $DB_NAME;
    $host_d = $DB_HOST;
    $user_d = $DB_USER;
    $pass_d = $DB_PASS;
    $base_d = $DB_NAME;
} else {
    echo "Error al decodificar el JSON.";
}

$conexion_destino = @mysqli_connect($host_d, $user_d, $pass_d, $base_d);
if (!$conexion_destino) {
    die("imposible conectarse: " . mysqli_error($conexion_destino));
}
if (@mysqli_connect_errno()) {
    die("Conexión falló: " . mysqli_connect_errno() . " : " . mysqli_connect_error());
}
date_default_timezone_set("America/Guayaquil");
mysqli_query($conexion_destino, "SET NAMES utf8");
mysqli_query($conexion_destino, "SET CHARACTER_SET utf8");

function limpiar3($tags)
{
    $tags = strip_tags($tags);
    return $tags;
}

function abrir_conexion($host, $user, $pass, $base)
{
    $cadena_json = file_get_contents('../db_destino_guia.php');
    $info = json_decode($cadena_json, true);
    // Verifica si la decodificación fue exitosa
    if ($info !== null) {
        // Accede a cada valor por su clave
        $DB_HOST = $info['DB_HOST'];
        $DB_USER = $info['DB_USER'];
        $DB_PASS = $info['DB_PASS'];
        $DB_NAME = $info['DB_NAME'];
        //echo $DB_NAME;
        $host_d = $DB_HOST;
        $user_d = $DB_USER;
        $pass_d = $DB_PASS;
        $base_d = $DB_NAME;
    } else {
        echo "Error al decodificar el JSON.";
    }
    $conexion_destino = mysqli_connect($host, $user, $pass, $base);

    if (!$conexion_destino) {
        throw new Exception("Imposible conectarse: " . mysqli_connect_error());
    }

    if (mysqli_connect_errno()) {
        throw new Exception("Conexión falló: " . mysqli_connect_errno() . " : " . mysqli_connect_error());
    }

    date_default_timezone_set("America/Guayaquil");

    if (!mysqli_set_charset($conexion_destino, "utf8")) {
        throw new Exception("Error al establecer el conjunto de caracteres: " . mysqli_error($conexion_destino));
    }

    return $conexion_destino;
}


function cerrar_conexion($conexion_destino)
{
    mysqli_close($conexion_destino);
}
