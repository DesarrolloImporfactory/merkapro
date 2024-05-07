<?php

use Illuminate\Support\Arr;

require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
$tienda = $_POST['tienda'];
if ($tienda != 'local') {

    $archivo_tienda =  $tienda . '/sysadmin/vistas/db1.php';
    $archivo_destino_tienda = "../db_destino_guia.php";
    $contenido_tienda = file_get_contents($archivo_tienda);
    $get_data = json_decode($contenido_tienda, true);
    $ciudadO = $_POST['ciudad'];
    if (file_put_contents($archivo_destino_tienda, $contenido_tienda) !== false) {
        $host_d = $get_data['DB_HOST'];
        $user_d = $get_data['DB_USER'];
        $pass_d = $get_data['DB_PASS'];
        $base_d = $get_data['DB_NAME'];
        // Conexión a la base de datos de la tienda, establece la hora -5 GTM
        date_default_timezone_set('America/Guayaquil');
        $conexion_prove = mysqli_connect($host_d, $user_d, $pass_d, $base_d);
        if (!$conexion_prove) {
            die("Connection failed: " . mysqli_connect_error());
        }
    } else {
        echo "Error al copiar el archivo";
    }
    $sql = "SELECT * FROM `origen_laar`";

    $result = mysqli_query($conexion_prove, $sql);

    $ciudadO = mysqli_fetch_array($result);
    $nombre_remitente = $ciudadO['nombreO'];

    $direccion_remitente = $ciudadO['direccion'];
    $telefono_remitente = $ciudadO['telefono'];
    echo mysqli_error($conexion_prove);

    $sql = "SELECT * FROM ciudad_laar where codigo = '" . $ciudadO['ciudadO'] . "';";
    $result = mysqli_query($conexion_prove, $sql);
    $ciudadO = mysqli_fetch_array($result);
    $ciudad = $ciudadO['nombre'];
} else {
    $sql = "SELECT * FROM `origen_laar`";

    $result = mysqli_query($conexion, $sql);

    $ciudadO = mysqli_fetch_array($result);
    $nombre_remitente = $ciudadO['nombreO'];

    $direccion_remitente = $ciudadO['direccion'];
    $telefono_remitente = $ciudadO['telefono'];
    echo mysqli_error($conexion);

    $sql = "SELECT * FROM ciudad_laar where codigo = '" . $ciudadO['ciudadO'] . "';";
    $result = mysqli_query($conexion, $sql);
    $ciudadO = mysqli_fetch_array($result);
    $ciudad = $ciudadO['nombre'];
}

$result = array(
    "ciudad" => $ciudad,
    "nombre_remitente" => $nombre_remitente,
    "direccion_remitente" => $direccion_remitente,
    "telefono_remitente" => $telefono_remitente
);

echo json_encode($result);
