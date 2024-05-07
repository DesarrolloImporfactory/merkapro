<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
//Archivo de funciones PHP
require_once "../funciones.php";
require_once "../funciones_destino.php";

$sql = "SELECT * FROM `cabecera_cuenta_pagar`";
$query = mysqli_query($conexion, $sql);

while ($row = mysqli_fetch_array($query)) {
    $guia_laar = $row['guia_laar'];
    $update = 'UPDATE cabecera_cuenta_pagar ccp
    INNER JOIN guia_laar g ON ccp.guia_laar = g.guia_laar
    SET ccp.cod = g.cod
    WHERE ccp.guia_laar = "' . $guia_laar . '";';

    mysqli_query($conexion, $update);
}

echo "listo";
