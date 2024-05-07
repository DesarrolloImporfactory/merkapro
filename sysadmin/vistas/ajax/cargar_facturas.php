<?php

include 'is_logged.php'; //Archivo comprueba si el usuario esta logueado

$tienda = $_SESSION['tienda'];

/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
require_once "../funciones.php";
//obtiene ?filtro=mayor_menor
$filtro = $_GET['filtro'];
//obtiene ?tienda=tienda
if ($filtro == 'mayor_menor') {
    $consultar = mysqli_query($conexion, "SELECT * FROM `cabecera_cuenta_pagar` where tienda ='$tienda' and valor_pendiente != 0 ORDER BY visto asc;");
} else if ($filtro == 'cero') {
    $consultar = mysqli_query($conexion, "SELECT * FROM `cabecera_cuenta_pagar` where tienda ='$tienda' and valor_pendiente = 0 ORDER BY visto asc;");
} else {
    $consultar = mysqli_query($conexion, "SELECT * FROM `cabecera_cuenta_pagar` where tienda ='$tienda' ORDER BY visto asc;");
}
$rw = mysqli_fetch_array($consultar);
$url_guia = "https://fenix.laarcourier.com/Tracking/Guiacompleta.aspx?guia=";
$url_ticket = "https://api.laarcourier.com:9727/guias/pdfs/DescargarV2?guia=";



if ($filtro == 'mayor_menor') {
    $band = "btn-primary";
    $bandd = "btn-secondary";
} else {
    $band = "btn-secondary";
    $bandd = "btn-primary";
}
?>


<!-- Botones para filtrar registros -->
<div class="btn-group" role="group" aria-label="Basic example">
    <button type="button" class="btn <?php echo $band ?>" onclick="filtrarRegistros('mayor_menor')">Pendientes</button>
    <button type="button" class="btn <?php echo $bandd ?>" onclick="filtrarRegistros('cero')">Pagados</button>
</div>
<div class="table-responsive">
    <table class="table-sm table table-condensed table-hover table-striped ">
        <tr>
            <th><i class="ti-check-box"></i></th>
            <th>Factura</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Tienda</th>
            <th>Venta total</th>
            <th>Costo</th>
            <th>Precio Envio</th>
            <th>Monto a Recibir</th>
            <th>Monto Cobrado</th>
            <th>Monto Pendiente</th>
            <th>Numero Guia</th>
            <th>Guia</th>
            <th>Ticket</th>
            <th>Ver</th>
            <th>Editar</th>
            <th>Devolucion</th>
            <th>Tipo Envio</th>
            <th>Ganancia</th>
            <th>Eliminar</th>
        </tr>
        <?php
        $finales = 0;
        foreach ($consultar as $rws) {
            $finales++;
            if ($rws['valor_pendiente'] == 0) {
                $color_row = 'table-success';
            } elseif ($rws['estado_guia'] == 9) {
                $color_row = 'table-danger';
            } else if ($rws['cod'] == 0) {
                $color_row = 'table-tomato';
            } else {
                $color_row = 'table-warning';
            }
            $direccionDestino = get_row('guia_laar', 'ciudadD', 'guia_laar', $rws['guia_laar']);
            if ($tienda == 'https://yapando.imporsuit.com' || $tienda == 'https://merkatodoec.imporsuit.com') {
                $prove_temp = $tienda;
                $archivo_tienda = $prove_temp . '/sysadmin/vistas/db1.php';
                $archivo_destino_tienda = "../db_destino_guia.php";
                $contenido_tienda = file_get_contents($archivo_tienda);
                $get_data = json_decode($contenido_tienda, true);
                if (file_put_contents($archivo_destino_tienda, $contenido_tienda) !== false) {
                    $host_d = $get_data['DB_HOST'];
                    $user_d = $get_data['DB_USER'];
                    $pass_d = $get_data['DB_PASS'];
                    $base_d = $get_data['DB_NAME'];
                    $conexion_destino = mysqli_connect($host_d, $user_d, $pass_d, $base_d);
                    $opcion_sql = "SELECT * FROM `ciudad_laar` WHERE `codigo` = '$direccionDestino'";
                    $opcion_query = mysqli_query($conexion_destino, $opcion_sql);
                    $opcions = mysqli_fetch_array($opcion_query);
                    $opcion = $opcions['tipo'];
                    $nombre_ciudad =  $opcions['nombre'];
                    if ($nombre_ciudad == "QUITO") $opcion = "LOCAL";
                } else {
                    echo "Error al cargar la base de datos";
                }
            } else {
                $opcion = get_row('ciudad_laar', 'tipo', 'codigo', $direccionDestino);
                $nombre_ciudad = get_row('ciudad_laar', 'nombre', 'codigo', $direccionDestino);
                if ($nombre_ciudad == "QUITO") $opcion = "LOCAL";
            }
            $ti = "";
            switch ($opcion) {
                case 'PRINCIPAL':
                    $tarifa = 2.80;
                    $ti = 'PRINCIPAL';
                    break;
                case 'SECUNDARIO':
                    $tarifa = 2.80;
                    $ti = 'SECUNDARIO';

                    break;
                case 'ESPECIAL':
                    $tarifa = 3.50;
                    $ti = 'ESPECIAL';

                    break;
                case 'ORIENTE':
                    $tarifa = 3.50;
                    $ti = 'ORIENTE';
                    break;
                case 'LOCAL':
                    $tarifa = 2.25;
                    $ti = 'LOCAL';
                    break;
            }

            $url_servi_guia = "https://servientrega-ecuador.appsiscore.com/app/app-cliente/cons_publica.php?guia=" . $rws['guia_laar'];



            $ganancias_imporsuit = $rws['precio_envio'] - (($tarifa * 1.12) * 1.03);
            if ($ganancias_imporsuit > 0) {
                $ganancias_label = "badge badge-success";
            } else {
                $ganancias_label = "badge badge-danger";
            }
        ?>
            <tr class="<?php echo $color_row ?>">
                <td><input type="checkbox" <?php if ($rws['visto'] == 1) echo "checked disabled" ?> onclick="visto('<?php echo $rws['id_cabecera'] ?>')"></td>
                <td class="text-center"><?php echo $rws['numero_factura']; ?></br><?php
                                                                                    $numero_factura = $rws['numero_factura'];
                                                                                    if (get_row('facturas_cot', 'drogshipin', 'numero_factura', $numero_factura) == 0 || get_row('facturas_cot', 'drogshipin', 'numero_factura', $numero_factura) == 4) {
                                                                                        echo '<span class="badge badge-purple">LOCAL</span>';
                                                                                    } else {
                                                                                        echo ' <span class="badge badge-purple">DROPSHIPIN</span>';
                                                                                    } ?></td>
                <td><?php echo $rws['fecha']; ?></td>
                <td><?php echo $rws['cliente']; ?></td>
                <td><?php echo $rws['tienda']; ?></td>
                <td><?php echo $rws['total_venta']; ?></td>
                <td><?php echo $rws['costo']; ?></td>
                <td><?php echo $rws['precio_envio']; ?></td>
                <td><?php echo $rws['monto_recibir']; ?></td>
                <td><?php echo $rws['valor_cobrado']; ?></td>

                <td><?php echo number_format($rws['valor_pendiente'], 2); ?></td>
                <td class="text-center">
                    <?php echo $rws['guia_laar']; ?>
                    <br>
                    <?php if ($rws['cod'] == 1) { ?>
                        <span class="badge badge-purple">Con Recaudo</span>
                    <?php } else { ?>
                        <span class="badge badge-purple">Sin Recaudo</span>
                    <?php } ?>
                </td>
                <td class="text-center">
                    <?php
                    if (is_numeric($rws['guia_laar'])) {
                        echo '<a href="' . $url_servi_guia . '" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-truck"></i></a>';
                    } else {
                        echo '<a href="' . $url_guia . $rws['guia_laar'] . '" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-truck"></i></a>';
                    }
                    ?>
                </td>
                <td class="text-center">
                    <?php
                    if (is_numeric($rws['guia_laar'])) {
                        echo "-";
                    } else {
                        echo '<a href="' . $url_ticket . $rws['guia_laar'] . '" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-receipt"></i></a>';
                    }
                    ?>
                </td>
                <td class="text-center">
                    <button onclick="ver_detalles('<?php echo $rws['numero_factura']; ?>')" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></button>
                </td>
                <td class="text-center">
                    <a href="editar_wallet.php?id_factura=<?php echo $rws['numero_factura']; ?>" class="btn btn-secondary btn-sm"><i class="fa fa-wrench"></i></a>
                </td>
                <td class="text-center">
                    <button onclick="devolucion('<?php echo $rws['guia_laar']; ?>')" class="btn btn-warning btn-sm"><i class="fa fa-rotate-left"></i></button>
                </td>
                <td>
                    <?php echo $ti; ?>
                </td>
                <td>
                    <span class="<?php echo $ganancias_label ?>">

                        <?php echo number_format($ganancias_imporsuit, 2); ?>
                    </span>
                </td>
                <td class="text-center">
                    <button onclick="eliminar('<?php echo $rws['id_cabecera']; ?>')" class="btn btn-danger btn-sm"><i class="ti-brush-alt"></i></button>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>