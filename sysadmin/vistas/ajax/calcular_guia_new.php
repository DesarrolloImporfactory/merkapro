<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "../db.php";
require_once "../php_conexion.php";
$precio_total = $_GET['precio_total'];
$provincia = $_GET['provincia'];
$ciudad_entrega = $_GET['ciudad_entrega'];
$recaudo = $_GET['recaudo'];
$sql = "SELECT * FROM `ciudad_cotizacion` WHERE id_cotizacion  = '$ciudad_entrega'";
$query = mysqli_query($conexion, $sql);


$row = mysqli_fetch_assoc($query);

if (!empty($row)) {
    $trayecto_laar = $row['trayecto_laar'];
    $sql2 = "SELECT * FROM `cobertura_laar` WHERE tipo_cobertura = '$trayecto_laar'";

    $query2 = mysqli_query($conexion, $sql2);
    $row2 = mysqli_fetch_assoc($query2);
    $respuestas = [];
    if (!empty($row2)) {
        $precio = $row2['precio'];

        $pt = $precio_total;
        if ($recaudo == 1) {
            $precio_total =  $precio;
        } else {
            $precio_total =  $precio;
        }
        $precio_total = number_format($precio_total, 2, '.', '');
        $respuestas["laar"] = $precio_total;
    }
    echo json_encode($respuestas);
}
