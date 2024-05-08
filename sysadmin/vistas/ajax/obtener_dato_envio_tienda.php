<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require "../db.php";
require "../php_conexion.php";

$id_pedido = $_POST['id_pedido'];
$sql = "SELECT * FROM facturas_cot where id_factura= '$id_pedido' ";
$result = mysqli_query($conexion, $sql);
$data = mysqli_fetch_array($result);
$tienda  = $data['tienda'];

if (empty($data['tienda'])) {
    $tienda = "https://" . $_SERVER['SERVER_NAME'];
}

echo $tienda;
