<?php

require_once '../db.php';
require_once '../php_conexion.php';
$sql = "SELECT * FROM guia_laar where guia_laar is not null and estado_guia in (7, 9)";
$result = mysqli_query($conexion, $sql);
$req = 00001;
while ($rw = mysqli_fetch_array($result)) {
    $nombre = $rw['nombreD'];
    $guia_laar = $rw['guia_laar'];
    $proveedor = $rw['tienda_proveedor'];
    $tienda_venta = $rw['tienda_venta'];
    $fecha = $rw['fecha'];
    $estado_guia = $rw['estado_guia'];
    $precio_envio = $rw['costoflete'];
    $total_venta = $rw['costoproducto'];
    $costo = $rw['valor_costo'];
    $monto_recibir = $total_venta - $costo - $precio_envio;
    $valor_cobrado = 0;
    $valor_pendiente = $monto_recibir;
    $cod = $rw['cod'];
    $insert_cuenta_pagar = "INSERT INTO cabecera_cuenta_pagar (numero_factura, fecha, cliente, tienda, estado_guia, total_venta, costo, precio_envio, monto_recibir, valor_cobrado, valor_pendiente, guia_laar, visto, cod, proveedor) VALUES ('" . $req . "-P','" . $fecha . "','" . $nombre . "','" . $tienda_venta . "','" . $estado_guia . "','" . $total_venta . "','" . $costo . "','" . $precio_envio . "','" . $monto_recibir . "','" . $valor_cobrado . "','" . $valor_pendiente . "','" . $guia_laar . "','" . 0 . "','" . $cod . "','" . $proveedor . "')";
    $resultado_cuenta_pagar = mysqli_query($conexion, $insert_cuenta_pagar);
    $req++;
}
