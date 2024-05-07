<?php

require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos

$data = file_get_contents('php://input');
parse_str($data, $output);

$guia_laar = $output['guia_laar'];

$sql = "SELECT * FROM cabecera_cuenta_pagar WHERE guia_laar = '$guia_laar'";
$resultado = mysqli_query($conexion, $sql);
$rw = mysqli_fetch_array($resultado);

$id_cabecera = $rw['id_cabecera'];

$precio_envio = $rw['precio_envio'];

$tienda = $rw['tienda'];

$archivo_tienda =  $tienda . '/sysadmin/vistas/db1.php';
$archivo_destino_tienda = "../../vistas/db_destino_guia.php";
$contenido_tienda = file_get_contents($archivo_tienda);
$get_data = json_decode($contenido_tienda, true);
if (file_put_contents($archivo_destino_tienda, $contenido_tienda) !== false) {
    $host_d = $get_data['DB_HOST'];
    $user_d = $get_data['DB_USER'];
    $pass_d = $get_data['DB_PASS'];
    $base_d = $get_data['DB_NAME'];
    // Conexión a la base de datos de la tienda, establece la hora -5 GTM
    date_default_timezone_set('America/Guayaquil');
    $conexion_dbs = mysqli_connect($host_d, $user_d, $pass_d, $base_d);
    if (!$conexion) {
        die("Connection failed: " . mysqli_connect_error());
    }
} else {
    echo "Error al copiar el archivo";
}

// select a perfil 
$sql_perfil = "SELECT nodevolucion FROM perfil ;";
$resultado_perfil = mysqli_query($conexion_dbs, $sql_perfil);
$rw_perfil = mysqli_fetch_array($resultado_perfil);
$nodevolucion = $rw_perfil['nodevolucion'];

if ($nodevolucion == 1) {
    $nuevo = 0 - $precio_envio;
} else {
    $nuevo = 0 - $precio_envio - ($precio_envio * 0.25);
}

$nuevo = number_format($nuevo, 2, '.', '');

$sql_update = "UPDATE cabecera_cuenta_pagar SET monto_recibir = '$nuevo', valor_pendiente='$nuevo', estado_guia ='9' WHERE id_cabecera = '$id_cabecera'";
$resultado_update = mysqli_query($conexion, $sql_update);

if ($resultado_update) {
    echo "Actualizado";
} else {
    echo "Error";
}
