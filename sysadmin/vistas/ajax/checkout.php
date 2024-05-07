<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";

$get_data = json_decode(file_get_contents('php://input'), true);
$id_producto = $get_data['codigo'];

$query = mysqli_query($conexion, "SELECT * FROM productos WHERE id_producto = '$id_producto'");
$row = mysqli_fetch_assoc($query);

$query2 = mysqli_query($conexion, "SELECT * FROM provincia_laar WHERE id_pais = 1 order by provincia asc");
$provincias = [];
while ($row2 = mysqli_fetch_assoc($query2)) {
    $provincias[] = $row2;
}

foreach ($provincias as $key => $value) {
    $query3 = mysqli_query($conexion, "SELECT * FROM ciudad_laar WHERE codigoProvincia = " . $value['codigo_provincia'] . " order by nombre asc");
    $localidades = [];
    while ($row3 = mysqli_fetch_assoc($query3)) {
        $localidades[] = $row3;
    }
    $provincias[$key]['localidades'] = $localidades;
}

$row['provincias'] = $provincias;
echo json_encode($row);
