<?php

require_once "../db.php";
require_once "../funciones.php";
require_once "../php_conexion.php";

$guia = $_POST['guia'];

$consulta = "SELECT * FROM guia_laar WHERE guia_laar = '$guia'";
$resultado = mysqli_query($conexion, $consulta);
$guia = mysqli_fetch_assoc($resultado);

$ciudadDestino = $guia['ciudadD'];
$id_pedido = $guia['id_pedido'];

$sql = "SELECT * FROM ciudad_cotizacion WHERE codigo_ciudad_laar = '$ciudadDestino'";
$result = mysqli_query($conexion, $sql);
$ciudad = mysqli_fetch_assoc($result);
if ($ciudad) {
    $ciudadDestino = $ciudad['ciudad'];
} else {
    $ciudadDestino = '';
}


$sql = "SELECT * FROM facturas_cot where id_factura = '$id_pedido'";
$result = mysqli_query($conexion, $sql);
$factura = mysqli_fetch_assoc($result);

$nombre = $factura['nombre'];
$ciudad = $factura['ciudad_cot'];
$telefono = $factura['telefono'];
$celular = $factura['celular'];
$c_prinicpal = $factura['c_principal'];
$c_secundaria = $factura['c_secundaria'];
$numeracion = 0;
$referencia = $factura['referencia'];
$observacion = $factura['observacion'];


$datos = array(
    'guia' => $guia['guia_laar'],
    'destino' => array(
        'ciudad' => $ciudadDestino,
        'nombre' => $nombre,
        'ciudad' => $ciudad,
        'telefono' => $telefono,
        'celular' => $celular,
        'c_principal' => $c_prinicpal,
        'c_secundaria' => $c_secundaria,
        'numeracion' => $numeracion,
        'referencia' => $referencia,
        'observacion' => $observacion
    ),
    'autorizado' => array(
        'nombre' => "IMPORTSUIT",
        'isDevolucion' => false
    )
);


echo json_encode($datos);
