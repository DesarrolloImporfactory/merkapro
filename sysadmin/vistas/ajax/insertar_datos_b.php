<?php

$data = file_get_contents("php://input");

// Convertir la cadena de consulta en variables
parse_str($data, $datos);

// Ahora $datos es un array asociativo que contiene los valores
$nombre = $datos['nombre'];
$correo = $datos['correo'];
$telefono = $datos['telefono'];
$banco = $datos['banco'];
$tipo_cuenta = $datos['tipo_cuenta'];
$numero_cuenta = $datos['numero_cuenta'];
$cedula = $datos['cedula'];
if ($banco == "0") {
    echo 'banco';
    exit;
}
if ($tipo_cuenta == "0") {
    echo 'cuenta';
    exit;
}
$marketplace = 'imporsuit_marketplace';
$conexion_marketplace = mysqli_connect('localhost', $marketplace, $marketplace, $marketplace);
$protocolo = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$tienda = $protocolo . $_SERVER['HTTP_HOST'];
$tienda = str_replace('www.', '', $tienda);


$sql = "INSERT INTO `datos_banco_usuarios`(`tipo_cuenta`, `nombre`, `banco`, `cedula`, `correo`, `telefono`, `numero_cuenta`, `tienda`) VALUES ('$tipo_cuenta','$nombre','$banco','$cedula','$correo','$telefono','$numero_cuenta','$tienda')";
$resultado = mysqli_query($conexion_marketplace, $sql);

if ($resultado) {
    echo 'datos';
} else {
    echo 'error';
}
echo mysqli_error($conexion_marketplace);
