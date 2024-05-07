<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once "../db.php";
require_once "../php_conexion.php";


$get_tienda = $_GET['tienda'];

$conexion_marketplace = mysqli_connect("158.220.107.176", "imporsuit_marketplace", "imporsuit_marketplace", "imporsuit_marketplace");
$tienda = mysqli_query($conexion_marketplace, "SELECT * FROM plataformas WHERE url_imporsuit = '$get_tienda'");
$tienda = mysqli_fetch_array($tienda);

$fullfill = $tienda['full_f'];

if ($fullfill == 1) {
    echo "1";
} else {
    echo "0";
}
