<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once "../db.php";
require_once "../php_conexion.php";
require_once "../funciones.php";
require_once "../funciones_destino.php";

$protocolo = isset($_SERVER['HTTPS']) ? "https" : "http";
$server_url = $protocolo . '://' . $_SERVER['HTTP_HOST'];

$msg = [];
if (isset($_POST['factura']) && isset($_POST['tipo'])) {
    $facturas = is_array($_POST['factura']) ? $_POST['factura'] : [$_POST['factura']];
    $tipo = $_POST['tipo'];
    $guias_impresas = [];
    $productos = [];
    $manifiesto = '';
    $producto = '';
    $fecha_actual = date("d-m-Y");

    foreach ($facturas as $factura) {
        $sql_command = "SELECT * FROM facturas_cot WHERE numero_factura = '$factura'";
        $result = mysqli_query($conexion, $sql_command);
        $row = mysqli_fetch_array($result);

        if ($row['estado_guia_sistema'] == 8) {
            array_push($msg, "guiaanulada");
            continue;
        }

        $id_factura_origen = $row['id_factura_origen'] ?: $row['id_factura'];
        $drogshipin = $row['drogshipin'];
        $tienda = $row['tienda'] ?: $server_url;

        $archivo_tienda = $tienda . '/sysadmin/vistas/db1.php';
        if (file_get_contents($archivo_tienda)) {
            $contenido_tienda = file_get_contents($archivo_tienda);
            $get_data = json_decode($contenido_tienda, true);
        } else {
            array_push($msg, "noexistearchivo");
            continue;
        }

        if ($drogshipin == 4) {
            $sql_command = "SELECT id_transporte FROM guia_laar WHERE id_pedido = '$id_factura_origen' and tienda_venta = '$tienda'";
        } else {
            $sql_command = "SELECT id_transporte FROM guia_laar WHERE id_pedido = '$id_factura_origen'";
        }

        $conexion_destino = mysqli_connect($get_data['DB_HOST'], $get_data['DB_USER'], $get_data['DB_PASS'], $get_data['DB_NAME']);
        if ($conexion_destino === false) {
            echo "Fallo al conectar a MySQL: " . mysqli_connect_error();
            continue;
        }

        $result = mysqli_query($conexion_destino, $sql_command);
        $row2 = mysqli_fetch_array($result);
        if (empty($row2)) {
            array_push($msg, "noexisteguia");
            mysqli_close($conexion_destino);
            continue;
        }

        $id_transporte = $row2['id_transporte'];
        $sql_command = "SELECT * FROM guia_laar g 
                        INNER JOIN facturas_cot f ON g.id_pedido = f.id_factura 
                        INNER JOIN detalle_fact_cot dt ON f.numero_factura = dt.numero_factura 
                        INNER JOIN productos p ON p.id_producto = dt.id_producto 
                        WHERE g.id_pedido = '$id_factura_origen'";

        $result = mysqli_query($conexion, $sql_command);
        while ($row = mysqli_fetch_array($result)) {
            $guia_laar = $row['guia_laar'];
            if (!in_array($guia_laar, $guias_impresas)) {
                array_push($guias_impresas, $guia_laar);
                $ciudad = $row['ciudadD'];
                $ciudad_destino = get_row('ciudad_laar', 'nombre', 'codigo', $ciudad);
                $costo_producto = $row[34];
                $cod = $row[32] == 1 ? 'CON RECAUDO' : 'SIN RECAUDO';
                $transporte = $id_transporte == 1 ? 'Laar Courier' : 'Motorizado';

                $manifiesto .= "
                    <tr>
                        <td>Nro: " . count($guias_impresas) . "</td>
                        <td>Guia: $guia_laar</td>
                        <td>Ciudad Destino: $ciudad_destino</td>
                        <td>Valor de Recaudo: $costo_producto</td>
                        <td>Tipo de logistica: $cod</td>
                    </tr>
                ";
            }

            $id_producto = $row['id_producto'];
            $codigo_producto = $row['codigo_producto'];
            $nombre_producto = $row['nombre_producto'];
            $cantidad = $row['cantidad'];

            if (isset($productos[$id_producto])) {
                $productos[$id_producto]['cantidad'] += $cantidad;
            } else {
                $productos[$id_producto] = [
                    'codigo_producto' => $codigo_producto,
                    'nombre_producto' => $nombre_producto,
                    'cantidad' => $cantidad
                ];
            }
        }

        if (empty($row['impreso'])) {
            $sql_update = "UPDATE facturas_cot SET impreso = 1 WHERE numero_factura = '$factura'";
            mysqli_query($conexion, $sql_update);
        }
    }

    foreach ($productos as $producto_data) {
        $producto .= "
            <tr>
                <td>(ID: {$producto_data['codigo_producto']}) - (SKU: {$producto_data['codigo_producto']}) - {$producto_data['nombre_producto']}</td>
                <td>{$producto_data['cantidad']}</td>
            </tr>
        ";
    }

    $manifiestoT = "
        <table class='section1-table'>
            <tr>
                <td>TRANSPORTADORA</td>
                <td>TRANSPORTADORA: </td>
            </tr>
            <tr>
                <td>RELACION DE GUIAS IMPRESAS</td>
                <td>FECHA MANIFIESTO (DD/MM/YYYY): $fecha_actual</td>
            </tr>
        </table>
        <table class='section2-table'>$manifiesto</table>
        <table class='section3-table'>
            <tr>
                <td>NOMBRE DE AUXILIAR:</td>
            </tr>
            <tr>
                <td>PLACA DEL VEHICULO:</td>
            </tr>
            <tr>
                <td>FIRMA DEL AUXILIAR:</td>
            </tr>
        </table>
    ";

    $productoT = "
        <div class='page-break'></div>
        <table class='products-table'>
            <tr>
                <th>Productos</th>
                <th>FECHA MANIFIESTO (DD/MM/YYYY) $fecha_actual</th>
            </tr>
        </table>
        <table class='products-table-inv'>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>$producto</tbody>
        </table>
    ";

    $devolucion = [
        'manifiesto' => $manifiestoT,
        'producto' => $productoT,
        'guias' => $guias_impresas,
        'msgs' => $msg,
    ];

    echo json_encode($devolucion);
}
