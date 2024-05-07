<?php

require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos

$sql_sin_guia = "SELECT COUNT(*) as no_guia FROM facturas_cot WHERE (guia_enviada IS NULL OR guia_enviada = 0) AND provincia != 17 AND provincia != 22 AND fecha_factura <= DATE_SUB(NOW(), INTERVAL 48 HOUR)";
$result_sin_guia = mysqli_query($conexion, $sql_sin_guia);
$row_sin_guia = mysqli_fetch_array($result_sin_guia);
$no_guia = $row_sin_guia['no_guia'];


$sql_devoluciones = "SELECT COUNT(*) as no_devoluciones FROM facturas_cot WHERE (estado_guia_sistema = 14) AND provincia != 17 AND provincia != 22 AND fecha_factura <= DATE_SUB(NOW(), INTERVAL 48 HOUR)";
