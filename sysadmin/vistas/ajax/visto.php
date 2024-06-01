<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
require_once "../funciones.php"; //Contiene funcion que conecta a la base de datos

$data = file_get_contents("php://input");
parse_str($data, $data);

$id_cabecera = $data['id_cabecera'];

$select = "SELECT * FROM cabecera_cuenta_pagar WHERE id_cabecera = '$id_cabecera'";
$result = mysqli_query($conexion, $select);
$rw = mysqli_fetch_array($result);
date_default_timezone_set('America/Guayaquil');
$monto_recibir = $rw['monto_recibir'];
$tienda = $rw['tienda'];
$guia_laar = $rw['guia_laar'];
if (isset($rw['proveedor'])) {
    $proveedor = $rw['proveedor'];
} else {
    $proveedor = NULL;
}

$update = "UPDATE cabecera_cuenta_pagar SET visto = 1, valor_pendiente=0 WHERE id_cabecera = '$id_cabecera'";
$resultado = mysqli_query($conexion, $update);

$update_billetera = "UPDATE billeteras SET saldo = ROUND(saldo + '$monto_recibir', 2) WHERE tienda = '$tienda'";
$resultado_billetera = mysqli_query($conexion, $update_billetera);

$select_billetera = "SELECT * FROM billeteras WHERE tienda = '$tienda'";
$result_billetera = mysqli_query($conexion, $select_billetera);
$rw_billetera = mysqli_fetch_array($result_billetera);
$id_billetera = $rw_billetera['id_billetera'];
$fecha = date('Y-m-d H:i:s');
$insert_historial_billetera = "INSERT INTO historial_billetera (id_billetera, monto, tipo, motivo,fecha) VALUES ('$id_billetera', '$monto_recibir', 'Entrada', 'Se acredito el monto de la guia: $guia_laar', '$fecha')";
$resultado_historial_billetera = mysqli_query($conexion, $insert_historial_billetera);

echo mysqli_error($conexion);

if ($proveedor != NULL && $rw["estado_guia"] == 7) {
    $insert_cuenta_pagar = "INSERT INTO cabecera_cuenta_pagar (numero_factura, fecha, cliente, tienda, estado_guia, total_venta, costo, precio_envio, monto_recibir, valor_cobrado, valor_pendiente, guia_laar, visto, cod, proveedor) VALUES ('" . $rw['numero_factura'] . "-P','" . $rw['fecha'] . "','" . $rw['cliente'] . "','" . $rw['proveedor'] . "','7','" . 0 . "','" . 0 . "','" . 0 . "','" . $rw['costo'] . "','" . 0 . "','" . $rw['costo'] . "','" . $guia_laar . "','" . 0 . "','" . $rw['cod'] . "','" . 0 . "')";
    $resultado_cuenta_pagar = mysqli_query($conexion, $insert_cuenta_pagar);
}

/// es referido de alguien 
$sql_referido = "SELECT * FROM plataformas where url_imporsuit = '$tienda'";
$resultado_referido = mysqli_query($conexion, $sql_referido);
$rw_referido = mysqli_fetch_array($resultado_referido);
if (isset($rw_referido['refiere'])) {
    $referido = $rw_referido['refiere'];
} else {
    $referido = NULL;
}

if ($referido != NULL) {
    //buscar la tienda del referido
    $sql_tienda = "SELECT * FROM plataformas where token_referido = '$referido'";
    $resultado_tienda = mysqli_query($conexion, $sql_tienda);
    $rw_tienda = mysqli_fetch_array($resultado_tienda);
    $tienda = $rw_tienda['url_imporsuit'];


    $insert_cuenta_pagar = "INSERT INTO cabecera_cuenta_pagar (numero_factura, fecha, cliente, tienda, estado_guia, total_venta, costo, precio_envio, monto_recibir, valor_cobrado, valor_pendiente, guia_laar, visto, cod, proveedor) VALUES ('" . $rw['numero_factura'] . "-R','" . $rw['fecha'] . "','" . $rw['cliente'] . "','" . $tienda . "','7','" . 0 . "','" . 0 . "','" . 0 . "',0.50,'" . 0 . "','0.50','" . $guia_laar . "','" . 0 . "','" . $rw['cod'] . "','" . 0 . "')";
    $resultado_cuenta_pagar = mysqli_query($conexion, $insert_cuenta_pagar);
}
echo mysqli_error($conexion);
/* 
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

    if ($rw['proveedor'] != "" || !empty($rw['proveedor'])) {
        if ($rw["estado_guia"] == 7) {
            $sql_insert = "INSERT INTO `cabecera_cuenta_pagar`(`numero_factura`, `fecha`, `cliente`, `tienda`, `estado_guia`, `total_venta`, `costo`, `precio_envio`, `monto_recibir`, `valor_cobrado`, `valor_pendiente`, `guia_laar`, `visto`, `cod`, `proveedor`) VALUES ('" . $rw['numero_factura'] . "-P','" . $rw['fecha'] . "','" . $rw['cliente'] . "','" . $rw['proveedor'] . "','7','" . 0 . "','" . 0 . "','" . 0 . "','" . $rw['monto_recibir'] . "','" . 0 . "','" . $rw['monto_recibir'] . "','" . $rw['guia_laar']   . "','" . 0 . "','" . $rw['cod'] . "','" . 0 . "')";
            $resultado_insert = mysqli_query($conexion, $sql_insert);
        }
    }

    
} */
if ($resultado) {
    echo "Visto";
} else {
    echo "Error";
}
