<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "../db.php";
require_once "../php_conexion.php";
require_once "../funciones.php";

$nombre_remitente = $_POST['nombre_remitente'];
$direccion_remitente = $_POST['direccion_remitente'];
$telefono_remitente = $_POST['telefono_remitente'];
$ciudad_origen = $_POST['origen_texto'];

$nombre_destino = $_POST['nombre_destino'];
$direccion_destino = $_POST['direccion'];
$telefono_destino = $_POST['celular'];
$ciudad_destino = $_POST['ciudad_texto'];

// Iniciar conexión a la base de datos y obtener códigos
$result_origen = mysqli_query($conexion, "SELECT * FROM `ciudad_cotizacion` WHERE `ciudad` = '$ciudad_origen'");
$row_origen = mysqli_fetch_array($result_origen);

$result_destino = mysqli_query($conexion, "SELECT * FROM `ciudad_cotizacion` WHERE `ciudad` = '$ciudad_destino'");
$row_destino = mysqli_fetch_array($result_destino);

$productos_guias = $_POST['productos_guia'];
preg_match_all('/([^\dx]+)x(\d+)/', $productos_guias, $coincidencias, PREG_SET_ORDER);

$resultado_final = [];
foreach ($coincidencias as $producto) {
    $nombre = trim($producto[1]);
    $cantidad = $producto[2];
    $resultado_final[] = "$cantidad * $nombre";
}

$productos_guias = implode(' | ', $resultado_final);
$observacion = $_POST['observacion'];
$fecha = date("Y-m-d H:i:s");
$declarado = $_POST['valor_total'];
$cod = $_POST['cod'];
$con_recaudo = $cod == "1" ? true : false;

$data = array(
    "remitente" => array(
        "nombre" => $nombre_remitente,
        "telefono" => $telefono_remitente,
        "provincia" => $row_origen['codigo_provincia_gintracom'],
        "ciudad" => $row_origen['codigo_ciudad_gintracom'],
        "direccion" => $direccion_remitente
    ),
    "destinatario" => array(
        "nombre" => $nombre_destino,
        "telefono" => $telefono_destino,
        "ciudad" => $row_destino['codigo_ciudad_gintracom'],
        "provincia" => $row_destino['codigo_provincia_gintracom'],
        "direccion" => $direccion_destino
    ),
    "cant_paquetes" => "1",
    "peso_total" => "2.00",
    "documento_venta" => "000" . rand(100000, 999999),
    "observacion" => $observacion,
    "contenido" => $productos_guias,
    "fecha" => $fecha,
    "declarado" => $declarado,
    "con_recaudo" => $con_recaudo
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://ec.gintracom.site/web/import-suite/pedido");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$usuario = "importsuite";
$clave = "ab5b809caf73b2c1abb0e4586a336c3a";
$credenciales = base64_encode($usuario . ":" . $clave);
$headers = array(
    "Content-Type: application/json",
    "Authorization: Basic " . $credenciales
);

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);
print_r($result);
