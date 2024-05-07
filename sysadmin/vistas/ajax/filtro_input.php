<?php
include 'is_logged.php';
$fechaInicio = $_GET['fecha_inicio'];
$fechaFin =  $_GET['fecha_fin'];
$estado = $_GET['estado'];
require_once "../db.php";
require_once "../php_conexion.php";
require_once "../funciones.php";
$user_id = $_SESSION['id_users'];

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';

$dominio_completo =     $protocol . $_SERVER['HTTP_HOST'];

include "../permisos.php";
get_cadena($user_id);
$modulo = "Wallets";
permisos($modulo, $cadena_permisos);
// Construye la consulta SQL con los filtros
if ($estado == 0 && $fechaInicio != "" && $fechaFin != "") {
    $sql = "SELECT * FROM cabecera_cuenta_pagar WHERE fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND tienda = '$dominio_completo'";
} else if ($estado != 0 && $fechaInicio != "" && $fechaFin != "") {
    $sql = "SELECT * FROM cabecera_cuenta_pagar WHERE fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND estado_pedido = '$estado' AND tienda = '$dominio_completo'";
} else if ($estado != 0 && $fechaInicio == "" && $fechaFin == "") {
    $sql = "SELECT * FROM cabecera_cuenta_pagar WHERE estado_pedido = '$estado' AND tienda = '$dominio_completo'";
} else if ($estado == 0 && $fechaInicio == "" && $fechaFin == "") {
    $sql = "SELECT * FROM cabecera_cuenta_pagar WHERE tienda = '$dominio_completo'";
}

include 'pagination.php'; //include pagination file
//pagination variables  
$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
$per_page = 10; //how much records you want to show
$adjacents  = 4; //gap between pages after number of adjacents
$offset = ($page - 1) * $per_page;
$marketplace_urlCon = "imporsuit_marketplace";
$marketplace_serverPlace    = mysqli_connect('localhost', $marketplace_urlCon, $marketplace_urlCon, $marketplace_urlCon);
//Count the total number of row in your table*/
$count_query = mysqli_query($marketplace_serverPlace, "SELECT count(*) AS numrows FROM cabecera_cuenta_pagar");
if (!$count_query) {
    die('Error en la consulta: ' . mysqli_error($marketplace_serverPlace));
}
$row = mysqli_fetch_array($count_query);
$numrows = $row['numrows'];

$total_pages = ceil($numrows / $per_page);
$reload = '../reportes/wallet.php';

//main query to fetch the data
$sql .= " LIMIT $offset,$per_page";


$resultados = mysqli_query($marketplace_serverPlace, $sql);

if (!$resultados) {
    die('Error en la consulta: ' . mysqli_error($marketplace_serverPlace));
}
// Construye el HTML de la tabla de resultados
$htmlResultados = "";

while ($row = mysqli_fetch_assoc($resultados)) {
    $id_cabecera = $row['id_cabecera'];
    $id_factura = $row['numero_factura'];
    $numero_factura = $row['numero_factura'];
    $fecha = date('d/m/Y', strtotime($row['fecha']));
    $nombre_cliente = $row['cliente'];
    $tienda = $row['tienda'];
    $total_venta = $row['total_venta'];
    $costo = $row['costo'];
    $precio_envio = $row['precio_envio'];
    $monto_recibir = $row['monto_recibir'];
    $estado_factura = $row['estado_pedido'];

    $guia_enviada = $row['guia_enviada'];
    $valor_cobrado = $row['valor_cobrado'];
    $valor_pendiente = $row['valor_pendiente'];
    $id_factura_origen = $row['id_factura_origen'];

    $guia_laar = $row['guia_laar'];


    if ($estado_factura == 1) {
        $text_estado = "INGRESADA";
        $label_class = 'badge-success';
    } else {
        $text_estado = "CREDITO";
        $label_class = 'badge-danger';
    }

    switch ($estado_factura) {
        case 1:
            $text_estado = "Confirmar";
            $label_class = 'badge-success';
            break;
        case 2:
            $text_estado = "Pick y Pack ";
            $label_class = 'badge-info';
            break;
        case 3:
            $text_estado = "Despachado";
            $label_class = 'badge-success';
            break;
        case 4:
            $text_estado = "Zona de entrega ";
            $label_class = 'badge-purple';
            break;
        case 5:
            $text_estado = "Cobrado";
            $label_class = 'badge-warning';
            break;
        case 6:
            $text_estado = "Pagado ";
            $label_class = 'badge-purple';
            break;

        case 7:
            $text_estado = "Liquidado";
            $label_class = 'badge-primary';
            break;
        case 8:
            $text_estado = "Anulado";
            $label_class = 'badge-danger';
            break;
        default:
            echo "Estado no reconocido";
    }

    $simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);

    if ($valor_pendiente == 0) {
        $color_row = "table-success";
    } elseif ($valor_pendiente < 0) {
        $color_row = "table-danger";
    } else {
        $color_row = "table-warning";
    }

    $htmlResultados .= "<tr class='" . $color_row . "'>";
    $htmlResultados .= "<td class='text-center'><label class='badge badge-purple'>" . $id_factura . "</label></td>";
    $htmlResultados .= "<td class='text-center'><label class='badge badge-pink'>" . $guia_laar . "</label></td>";

    $htmlResultados .= "<td class='text-center'>" . $fecha . "</td>";
    $htmlResultados .= "<td class='text-center'>" . $nombre_cliente . "</td>";
    $htmlResultados .= "<td class='text-center'>" . $tienda . "</td>";
    $htmlResultados .= "<td class='text-center'><span class='badge " . $label_class . "'>" . $text_estado . "</span></td>";
    $htmlResultados .= "<td class='text-center'>" . $simbolo_moneda . $total_venta . "</td>";
    $htmlResultados .= "<td class='text-center'>" . $simbolo_moneda . $costo . "</td>";
    $htmlResultados .= "<td class='text-center'>" . $simbolo_moneda . $precio_envio . "</td>";
    $htmlResultados .= "<td class='text-center'>" . $simbolo_moneda . $monto_recibir . "</td>";
    $htmlResultados .= "<td class='text-center'>" . $simbolo_moneda . $valor_cobrado . "</td>";
    $htmlResultados .= "<td class='text-center'>" . $simbolo_moneda . $valor_pendiente . "</td>";
    $htmlResultados .= "<td class='text-center'><button class='btn btn-sm btn-outline-primary' onclick='cargar_recibos('" . $id_cabecera . "')'><i class='ti-receipt'></i></button></td>";
    $htmlResultados .= "</tr>";

    // ... (agrega más columnas según tu estructura de base de datos)
}


// Devuelve los resultados como HTML
echo $htmlResultados;
