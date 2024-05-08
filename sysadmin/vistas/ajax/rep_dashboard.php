<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include "is_logged.php";  // Archivo comprueba si el usuario está logueado
require_once "../db.php";
require_once "../php_conexion.php";
include "../permisos.php";
require_once "../funciones.php";

$user_id = $_SESSION['id_users'];
$action  = $_REQUEST['action'] ?? '';

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';

$dominio_completo =     $protocol . $_SERVER['HTTP_HOST'];

$conexion_marketplace = new mysqli('localhost', 'imporsuit_marketplace', 'imporsuit_marketplace', 'imporsuit_marketplace');

if ($action == 'ajax') {
    $daterange = mysqli_real_escape_string($conexion, strip_tags($_REQUEST['range'], ENT_QUOTES));
    list($f_inicio, $f_final) = explode(" - ", $daterange);
    list($dia_inicio, $mes_inicio, $anio_inicio) = explode("/", $f_inicio);
    $fecha_inicial = "$anio_inicio-$mes_inicio-$dia_inicio 00:00:00";
    list($dia_fin, $mes_fin, $anio_fin) = explode("/", $f_final);
    $fecha_final = "$anio_fin-$mes_fin-$dia_fin 23:59:59";

    $results = [];

    // Total de pedidos
    $query_pedidos = "SELECT * FROM facturas_cot WHERE date(fecha_factura) BETWEEN '$fecha_inicial' AND '$fecha_final'";
    $abonoQuery  = $conexion->query($query_pedidos);
    $total_abono = 0;
    while ($abonoResult = $abonoQuery->fetch_assoc()) {
        $total_abono += $abonoResult['monto_factura'];
    }
    $results['total_pedidos'] = '$ '.number_format($total_abono, 2);

    // Total de ventas
    $query_ventas = "SELECT COUNT(*) as count FROM facturas_cot WHERE date(fecha_factura) BETWEEN '$fecha_inicial' AND '$fecha_final'";
    $res_ventas = mysqli_query($conexion, $query_ventas);
    $row_ventas = mysqli_fetch_assoc($res_ventas);
    $results['total_ventas'] = number_format($row_ventas['count'], 2);
    
    // Total de guias
    $query_guias = "SELECT COUNT(*) as count FROM guia_laar WHERE fecha BETWEEN '$fecha_inicial' AND '$fecha_final'";
    $res_guias = mysqli_query($conexion, $query_guias);
    $row_guias = mysqli_fetch_assoc($res_guias);
    $results['total_guias'] = number_format($row_guias['count'], 2);

    // Consulta general para ventas, guías, recaudos, fletes, y devoluciones
    $query_general = "SELECT 
                        SUM(CASE WHEN numero_factura NOT LIKE 'proveedor%' AND numero_factura NOT LIKE 'referido%' THEN total_venta ELSE 0 END) AS ventas,
                        SUM(valor_pendiente) AS pendiente,
                        SUM(valor_cobrado) AS cobrado,
                        SUM(monto_recibir) AS monto_recibir,
                        (SELECT SUM(precio_envio) FROM cabecera_cuenta_pagar WHERE visto = 1 AND tienda = '$dominio_completo' AND fecha BETWEEN '$fecha_inicial' AND '$fecha_final') AS fletes,
                        (SELECT SUM(monto_recibir) FROM cabecera_cuenta_pagar WHERE visto = 1 AND estado_guia = 9 AND tienda = '$dominio_completo' AND fecha BETWEEN '$fecha_inicial' AND '$fecha_final') AS devoluciones
                    FROM cabecera_cuenta_pagar 
                    WHERE tienda = '$dominio_completo' 
                    AND visto = '1'
                    AND fecha BETWEEN '$fecha_inicial' AND '$fecha_final'";

    $res_general = mysqli_query($conexion_marketplace, $query_general);
    if (!$res_general) {
        die('Error de consulta: ' . mysqli_error($conexion_marketplace));
    }
    $row_general = mysqli_fetch_assoc($res_general);

    $results['total_recaudo'] = number_format($row_general['monto_recibir'], 2);
    $results['total_fletes'] = number_format($row_general['fletes'], 2);
    $results['devoluciones'] = number_format($row_general['devoluciones'], 2);

    echo json_encode($results);
}
