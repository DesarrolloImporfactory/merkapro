<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "../db.php";
require_once "../php_conexion.php";
require_once "../funciones.php";

$id_pedido = $_POST['id_pedido'];
$ciudad = $_POST['ciudad'];
if (isset($id_pedido)) {
    $sql = "SELECT tienda FROM `facturas_cot` WHERE `id_factura` = '$id_pedido'";
    $result = mysqli_query($conexion, $sql);
    $tienda = mysqli_fetch_array($result);
    $tienda = $tienda['tienda'];
    if (empty($tienda)) {
        $tienda = "https://" . $_SERVER['SERVER_NAME'];
    }
    $data = array(
        "tienda" => $tienda,
        "ciudad" => $ciudad
    );
    echo json_encode($data);
} else {
    echo "Error al obtener el id del pedido";
}
