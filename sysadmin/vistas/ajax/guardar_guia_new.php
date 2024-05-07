<?php
/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
//Inicia Control de Permisos

$data = file_get_contents("php://input");
parse_str($data, $datos);
$estado = $datos['estado'];
$guia = $datos['guia'];
$cot = $datos['cot'];
$sql = "UPDATE guia_laar SET estado_guia = '$estado' WHERE guia_laar = '$guia'";
$sql_cot = "UPDATE facturas_cot SET estado_guia_sistema = '$estado' WHERE numero_factura = '$cot'";
$result = mysqli_query($conexion, $sql);
$result_cot = mysqli_query($conexion, $sql_cot);
if ($result) {
    echo "1";
} else {
    echo "0";
}
