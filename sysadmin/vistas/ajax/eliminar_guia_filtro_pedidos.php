<?php
// Datos de autenticación
require_once "../db.php";
require_once "../php_conexion.php";

$numero_factura = $_POST['numero_factura'];
$sql = "UPDATE facturas_cot SET  estado_guia_sistema=8 WHERE numero_factura='" . $numero_factura . "'";
$query_update = mysqli_query($conexion, $sql);
echo 'ok';
