<?php
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    //Archivo de funciones PHP
    include "../funciones.php";

    $sql_guias = "SELECT estado_guia FROM guia_laar where guia_laar !=''";

    $query_guias = mysqli_query($conexion, $sql_guias);

    $por_recolectar = 0;
    $recolectado = 0;
    $en_bodega = 0;
    $en_transito = 0;
    $zona_entrega   = 0;
    $entregado = 0;
    $anulado = 0;
    $devolucion = 0;
    $facturado = 0;
    $novedad = 0;

    while ($row = mysqli_fetch_array($query_guias)) {
        $estado_guia = $row['estado_guia'];
        switch ($estado_guia) {
            case '2':
                $por_recolectar++;
                break;
            case '3':
                $recolectado++;
                break;
            case '4':
                $en_bodega++;
                break;
            case '5':
                $en_transito++;
                break;
            case '6':
                $zona_entrega++;
                break;
            case '7':
                $entregado++;
                break;
            case '8':
                $anulado++;
                break;
            case '9':
                $devolucion++;
                break;
            case '10':
                $facturado++;
                break;
            case '14':
                $novedad++;
                break;
        }
    }

            
    $datos_pastel = array(
        array('Estado', 'Cantidad'),
        array('Por recolectar', $por_recolectar),
        array('Recolectado', $recolectado),
        array('En bodega', $en_bodega),
        array('En tránsito', $en_transito),
        array('Zona de entrega', $zona_entrega),
        array('Entregado', $entregado),
        array('Anulado', $anulado),
        array('Devolución', $devolucion),
        array('Facturado', $facturado),
        array('Novedad', $novedad),
    );

    echo json_encode($datos_pastel);
}
