<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
$data = file_get_contents("php://input");
$protocolo = "";
if (isset($_SERVER['HTTPS'])) {
    $protocolo = "https";
} else {
    $protocolo = "http";
}
$server_url =  $protocolo . '://' . $_SERVER['HTTP_HOST'];

parse_str($data, $datos);

require_once "../db.php";
require_once "../php_conexion.php";
require_once "../funciones.php";

$numero_factura = $datos['numero_factura'];

$nf = $numero_factura;

$prove_temp = get_row("facturas_cot", "tienda", "numero_factura", $numero_factura);
if ($prove_temp == null) {
    $prove_temp = $server_url;
}
$id_factura_origen = get_row("facturas_cot", "id_factura_origen", "numero_factura", $numero_factura);
if ($server_url != "https://merkapro.ec") $id_factura_origen = get_row("facturas_cot", "id_factura", "numero_factura", $numero_factura);
$archivo_tienda = $prove_temp . '/sysadmin/vistas/db1.php';
$archivo_destino_tienda = "../db_destino_guia.php";
$contenido_tienda = file_get_contents($archivo_tienda);
$get_data = json_decode($contenido_tienda, true);
$host_d = $get_data['DB_HOST'];
$user_d = $get_data['DB_USER'];
$pass_d = $get_data['DB_PASS'];
$base_d = $get_data['DB_NAME'];

$conexionAX = mysqli_connect($host_d, $user_d, $pass_d, $base_d);
$sql = "SELECT * from facturas_cot fc inner join detalle_fact_cot dc on fc.numero_factura = dc.numero_factura INNER join productos p on p.id_producto = dc.id_producto where fc.id_factura = '$id_factura_origen'";
if ($server_url != "https://merkapro.ec") {
    $query = mysqli_query($conexion, $sql);
    $query2 = mysqli_query($conexion, $sql);
} else {
    $query = mysqli_query($conexionAX, $sql);
    $query2 = mysqli_query($conexionAX, $sql);
}

$rw = mysqli_fetch_array($query);
$count = 0;
if ($rw["guia_enviada"] == 1) {
    $sql_guia = "SELECT * from guia_laar where id_pedido = '$id_factura_origen'";
    if ($server_url != "https://merkapro.ec") {
        $query_guia = mysqli_query($conexion, $sql_guia);
    } else {
        $query_guia = mysqli_query($conexionAX, $sql_guia);
    }
    $rw_guia = mysqli_fetch_array($query_guia);

    $rw["cod"] = @$rw_guia["cod"];
    $rw["tienda"] = get_row("facturas_cot", "tienda", "numero_factura", $nf);
    $rw["guia"] = @$rw_guia["guia_laar"];
}

$provincia = get_row("provincia_laar", "provincia", "codigo_provincia", $rw["provincia"]);

if (
    isset($_SERVER['HTTPS']) &&
    ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
    $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'
) {
    $protocol = 'https://';
} else {
    $protocol = 'http://';
}
$dominio_actual = $protocol . $_SERVER['HTTP_HOST'];


?>


<div id="Modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Detalles de factura</h4>
            </div>
            <div class="modal-body grid-cot">
                <div class="fs-7 w-35">
                    <span>Orden para: <?php echo $rw["nombre"] ?></span> <br>
                    <span>Dirección: <?php echo $rw["c_principal"] . " " . $rw["c_secundaria"] . " - " . $provincia  ?></span> <br>
                    <span>Teléfono: <?php echo $rw["telefono"] ?></span>
                </div>
                <div class="text-right">
                    <span># Orden: <?php echo $nf ?></span> <br>
                    <span>Fecha: <?php echo $rw["fecha_factura"] ?></span> <br>
                    <?php if ($rw["guia_enviada"] == 1) {
                        if ($dominio_actual == "https://merkapro.ec") {
                            $transportista = get_row("guia_laar", "id_transporte", "tienda_venta ='" . $rw["tienda"] . "' and id_pedido", $rw["id_factura"]);
                            $cod = $rw["cod"];
                        } else {
                            $transportista = get_row("guia_laar", "id_transporte", "tienda_venta ='" . $dominio_actual . "' and id_pedido", $rw["id_factura"]);
                            $cod = $rw["cod"];
                        }

                        if ($transportista == 1) {
                            $transportista = "Laar Courier";
                        } else {
                            $transportista = "Motorizado";
                        }
                    ?>
                        <span>Compañia de envío: <?php echo $transportista ?></span> <br>

                        <span>Tipo de envio: <?php if ($cod == 1) {
                                                    echo "Con recaudo";
                                                } else {
                                                    echo "Sin recaudo";
                                                } ?> </span>
                    <?php } else {
                        echo "<span>Compañia de envío: Guia no enviada</span> <br>";
                        echo "<span>Tipo de envio: Guia no enviada</span>";
                    } ?>

                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Factura</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio del Producto</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($rws = mysqli_fetch_array($query2)) {
                                $count += floatval($rws["cantidad"] * $rws["precio_venta"]);

                                echo '
                                <tr>
                                <td>' . $nf . ' </td>
                                <td> ' . $rws["nombre_producto"] . '</td>
                                <td> ' . number_format(floatval($rws["cantidad"]), 2) . '</td>
                                <td> ' . number_format(floatval($rws["precio_venta"]), 2) . '</td>
                                <td> ' . number_format(floatval($rws["cantidad"] * $rws["precio_venta"]), 2) . '</td>
                                </tr>
                                ';
                            }
                            ?>

                        </tbody>
                    </table>
                    <h4>Historial de estados</h4>
                    <div class="table-responsive">

                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Estado</th>
                                    <th>Fecha</th>

                                </tr>
                            </thead>
                            <tbody id="estados_laar_guias">
                                <?php echo '
                                    <script>
                                    async function cargar_estado(guia) {
                                        const estados = document.getElementById("estados_laar_guias");
                                        await fetch("https://api.laarcourier.com:9727/guias/" + guia)
                                            .then(response => response.json())
                                            .then(data => {
                                                var trackingInfo = data.tracking;
                                                // Iterar sobre las claves del objeto "tracking"
                                                for (var key in trackingInfo) {
                                                    if (trackingInfo.hasOwnProperty(key)) {
                                                        var status = trackingInfo[key];
                                                        let badge = "";
                                                        if (key === "2.00") {
                                                            badge = "badge badge-purple";
                                                        }
                                                        if (key === "3.00") {
                                                            badge = "badge badge-purple";
                                                        }
                                                        if (key === "4.00") {
                                                            badge = "badge badge-danger";
                                                        }
                                                        if (key === "5.00") {
                                                            badge = "badge badge-warning";
                                                        }
                                                        if (key === "6.00") {
                                                            badge = "badge badge-warning";
                                                        }
                                                        if (key === "7.00") {
                                                            badge = "badge badge-success";
                                                        }
                                                        if (key === "8.00") {
                                                            badge = "badge badge-warning";
                                                        }
                                                        if (key === "9.00") {
                                                            badge = "badge badge-warning";
                                                        }
                                                        if (key === "10.00") {
                                                            badge = "badge badge-warning";
                                                        }
                                                        if (key === "11.00") {
                                                            badge = "badge badge-warning";
                                                        }
                                                        if (key === "12.00") {
                                                            badge = "badge badge-warning";
                                                        }
                                                        if (key === "13.00") {
                                                            badge = "badge badge-warning";
                                                        }
                                                        if (key === "14.00") {
                                                            badge = "badge badge-warning";
                                                        }

                                                        if(status.nombre === "Entregado" && status.fecha === null){
                                                            continue;
                                                        }
                                                        
                                                        if(status.nombre === "Anulado" && status.fecha === null){
                                                            continue;
                                                        }

                                                        if(status.nombre ==="Con Novedad" && status.fecha === null){
                                                            status.fecha = data.novedades[0].fechaNovedad;
                                                        }


                                                        if(status.fecha === null){
                                                            status.fecha = "Sin fecha";
                                                        }
                            
                                                        estados.innerHTML += `
                                                                                <tr>
                                                                                <td><span class="${badge}">${status.nombre}</span></td>
                                                                                    <td>${status.fecha}</td>
                                                                                </tr>
                                                                                `
                            
                                                    }
                                                }
                                            })
                                            .catch(error => console.log(error));
                                    }
                                </script>
                                    ';
                                if (isset($rw['guia'])) {

                                    echo '
                                        <script> cargar_estado("' . $rw['guia'] . '") </script>
                                        ';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>