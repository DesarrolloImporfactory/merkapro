<?php

require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
require_once "../funciones.php"; //Contiene funcion que conecta a la base de datos

$data = file_get_contents("php://input");
parse_str($data, $data);

$id_cabecera = $data['id_cabecera'];

$consulta = "SELECT * FROM cabecera_cuenta_pagar WHERE id_cabecera = '$id_cabecera'";
$resultado = mysqli_query($conexion, $consulta);
$rw = mysqli_fetch_array($resultado);
$visto = $rw['visto'];
$cod = $rw['cod'];

if ($cod == 0 || $cod == 2 || $cod == 3 || $cod == 1) {
    $es_proveedor = "SELECT * FROM cabecera_cuenta_pagar WHERE id_cabecera = '$id_cabecera'";

    $guia_laar = $rw['guia_laar'];
    $costo = $rw['costo'];
    $tienda = $rw['tienda'];
    if ($visto == 1) {
        $visto = 0;
    } else {
        $visto = 1;
    }

    $consulta = "UPDATE cabecera_cuenta_pagar SET visto = '$visto' WHERE id_cabecera = '$id_cabecera'";
    $resultado = mysqli_query($conexion, $consulta);

    $consultar_cod = "SELECT * from guia_laar where guia_laar = '$guia_laar'";
    $resultado_cod = mysqli_query($conexion, $consultar_cod);
    $rw_cod = mysqli_fetch_array($resultado_cod);
    $tienda_proveedor = $rw_cod['tienda_proveedor'];

    $consultar_cabecera = "SELECT * from cabecera_cuenta_pagar where guia_laar = 'PROVEEDOR' and tienda = '$tienda_proveedor'";
    $resultado_cabecera = mysqli_query($conexion, $consultar_cabecera);
    $rw_cabecera = mysqli_fetch_array($resultado_cabecera);
    if (!empty($rw_cabecera)) {
        $monto_recibir = $rw_cabecera['monto_recibir'];
        $valor_pendiente = $rw_cabecera['valor_pendiente'];
        $mt_recibir = $monto_recibir + $costo;
        $vl_pendiente = $valor_pendiente + $costo;
        if ($rw['estado_guia'] != 9) {
            $update_cabecera = "UPDATE cabecera_cuenta_pagar SET monto_recibir = '$mt_recibir', valor_pendiente = '$vl_pendiente' WHERE guia_laar = 'PROVEEDOR' and tienda = '$tienda_proveedor'";
            $resultado_update = mysqli_query($conexion, $update_cabecera);
        }
    }
    $consultar_cabecera = "SELECT * from cabecera_cuenta_pagar where guia_laar = 'REFERIDO' and tienda = '$tienda_proveedor'";
    $resultado_cabecera = mysqli_query($conexion, $consultar_cabecera);
    $rw_cabecera = mysqli_fetch_array($resultado_cabecera);
    if (!empty($rw_cabecera)) {
        $monto_recibir = $rw_cabecera['monto_recibir'];
        $valor_pendiente = $rw_cabecera['valor_pendiente'];
        $mt_recibir = $monto_recibir + 0.5;
        $vl_pendiente = $valor_pendiente + 0.5;
        if ($rw['estado_guia'] != 9) {

            $update_cabecera = "UPDATE cabecera_cuenta_pagar SET monto_recibir = '$mt_recibir', valor_pendiente = '$vl_pendiente' WHERE guia_laar = 'REFERIDO' and tienda = '$tienda_proveedor'";
            $resultado_update = mysqli_query($conexion, $update_cabecera);
        }
    }
}
if ($resultado) {
    echo "Visto";
} else {
    echo "Error";
}
