<?php

require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos

$sql = "SELECT MAX(id_factura) as id_factura from facturas_cot;";
$result = mysqli_query($conexion, $sql);

if ($result) {
    $row = mysqli_fetch_array($result);
    $id_factura = $row['id_factura'];
    echo $id_factura;
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
}
