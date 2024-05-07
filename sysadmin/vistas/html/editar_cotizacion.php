<?php
session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
    header("location: ../../login.php");
    exit;
}
/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
//Archivo de funciones PHP
require_once "../funciones.php";
require_once "../funciones_destino.php";
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Ventas";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
$title          = "Pedidos";
$Ventas         = 1;
$nombre_usuario = get_row('users', 'usuario_users', 'id_users', $user_id);

if (isset($_GET['id_factura'])) {
    $id_factura  = intval($_GET['id_factura']);
    $campos      = "clientes.id_cliente, clientes.nombre_cliente, clientes.fiscal_cliente, clientes.email_cliente, facturas_cot.id_vendedor, facturas_cot.fecha_factura, facturas_cot.condiciones, facturas_cot.validez, facturas_cot.numero_factura, facturas_cot.nombre,facturas_cot.telefono, facturas_cot.provincia,facturas_cot.c_principal,facturas_cot.c_secundaria,facturas_cot.referencia, facturas_cot.observacion, facturas_cot.ciudad_cot, facturas_cot.guia_enviada, facturas_cot.drogshipin, facturas_cot.tienda";
    //echo "select $campos from facturas_cot, clientes where facturas_cot.id_cliente=clientes.id_cliente and id_factura='" . $id_factura . "'";
    $sql_factura = mysqli_query($conexion, "select $campos from facturas_cot, clientes where facturas_cot.id_cliente=clientes.id_cliente and id_factura='" . $id_factura . "'");
    $count       = mysqli_num_rows($sql_factura);
    if ($count == 1) {
        $rw_factura                 = mysqli_fetch_array($sql_factura);
        $id_cliente                 = $rw_factura['id_cliente'];
        $nombre_cliente             = $rw_factura['nombre_cliente'];
        $fiscal_cliente             = $rw_factura['fiscal_cliente'];
        $email_cliente              = $rw_factura['email_cliente'];
        $id_vendedor_db             = $rw_factura['id_vendedor'];
        $fecha_factura              = date("d/m/Y", strtotime($rw_factura['fecha_factura']));
        $condiciones                = $rw_factura['condiciones'];
        $validez                    = $rw_factura['validez'];
        $numero_factura             = $rw_factura['numero_factura'];

        $nombredestino            = $rw_factura['nombre'];
        $provinciadestino             = $rw_factura['provincia'];
        $ciudaddestino             = $rw_factura['ciudad_cot'];
        $guia_enviada             = $rw_factura['guia_enviada'];
        $drogshipin             = $rw_factura['drogshipin'];
        $tienda            = $rw_factura['tienda'];

        $direccion = $rw_factura['c_principal'] . ' ' . $rw_factura['c_secundaria'];
        $referencia = $rw_factura['referencia'];
        $telefono = $rw_factura['telefono'];
        $observacion = $rw_factura['observacion'];
        $numerocasa = $rw_factura['numerocasa'];

        //calcular segun la ciudad
        $valor_base = get_row('ciudad_laar', 'precio', 'codigo', $ciudaddestino);

        // if()
        $valor_base = get_row('ciudad_laar', 'precio', 'codigo', $ciudaddestino);

        if ($guia_enviada == 1) {
            $valor_base = get_row('guia_laar', 'costoflete', 'id_pedido', $id_factura);
        }



        $_SESSION['id_factura']     = $id_factura;
        $_SESSION['numero_factura'] = $numero_factura;
    } else {
        //header("location: facturas.php");
        exit;
    }
} else {
    //header("location: facturas.php");
    exit;
}
//consulta para elegir el comprobante
$query = $conexion->query("select * from comprobantes");
$tipo  = array();
while ($r = $query->fetch_object()) {
    $tipo[] = $r;
}
?>

<?php require 'includes/header_start.php'; ?>

<?php require 'includes/header_end.php'; ?>
<style>
    .stepwizard-step p {
        margin-top: 10px;
    }

    .stepwizard-row {
        display: table-row;
    }

    .stepwizard {
        display: table;
        width: 100%;
        position: relative;
    }

    .stepwizard-step button[disabled] {
        opacity: 1 !important;
        filter: alpha(opacity=100) !important;
    }

    .stepwizard-row:before {
        top: 14px;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 100%;
        height: 1px;
        background-color: #ccc;


    }

    .stepwizard-step {
        display: table-cell;
        text-align: center;
        position: relative;
    }

    .btn-circle {
        width: 30px;
        height: 30px;
        text-align: center;
        padding: 6px 0;
        font-size: 12px;
        line-height: 1.428571429;
        border-radius: 15px;
    }
</style>
<!-- Begin page -->

<div id="wrapper" class="forced enlarged">

    <?php


    require 'includes/menu.php';
    // echo $guia_enviada;
    if ($guia_enviada == 1) {


        @$guia_numero = get_row('guia_laar', 'guia_laar', 'id_pedido', $id_factura);
        $url = 'https://api.laarcourier.com:9727/guias/' . $guia_numero;

        // echo  $url;                       

        $curl = curl_init($url);

        // Establecer opciones para la solicitud cURL
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Accept: application/json'
        ]);

        // Realizar la solicitud GET
        $response = curl_exec($curl);

        // Verificar si hubo algún error en la solicitud
        if ($response === false) {
            echo 'Error en la solicitud: ' . curl_error($curl);
        } else {
            // Procesar la respuesta
            $data = json_decode($response, true);
            if ($data !== null && isset($data['estadoActualCodigo'])) {
                // Imprimir el estadoActual
                //echo 'Estado Actual: ' . $data['estadoActual'];
                switch ($data['estadoActualCodigo']) {
                    case '1':

                        $span_estado = 'badge-danger';
                        $estado_guia = 'Anulado';
                        break;
                    case '2':
                        $span_estado = 'badge-purple';
                        $estado_guia = 'Por recolectar';
                        break;
                    case '3':
                        $span_estado = 'badge-purple';
                        $estado_guia = 'Por recolectar';
                        break;
                    case '4':
                        $span_estado = 'badge-purple';
                        $estado_guia = 'Por recolectar';
                        break;
                    case '5':
                        $span_estado = 'badge-purple';
                        $estado_guia = 'Por recolectar';
                        break;
                    case '6':
                        $span_estado = 'badge-purple';
                        $estado_guia = 'Por recolectar';
                        break;
                    case '7':
                        $span_estado = 'badge-purple';
                        $estado_guia = 'Anulada';
                        break;
                    case '8':
                        $span_estado = 'badge-purple';
                        $estado_guia = 'Anulada';
                        break;
                    case '9':
                        echo "i es igual a 2";
                        break;
                }
            } else {
                // echo 'No se pudo obtener el estadoActual';
            }
        }

        // Cerrar la sesión cURL
        curl_close($curl);
    }
    ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <?php if ($permisos_ver == 1) {
                ?>
                    <div class="col-lg-12">
                        <div class="portlet">
                            <div class="portlet-heading bg-primary">
                                <h3 class="portlet-title">
                                    Editar Pedido
                                </h3>
                                <div class="portlet-widgets">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div id="bg-primary" class="panel-collapse collapse show">
                                <div class="portlet-body">
                                    <?php
                                    include "../modal/buscar_productos_ventas.php";
                                    include "../modal/registro_cliente.php";
                                    include "../modal/registro_producto.php";
                                    include "../modal/caja.php";
                                    ?>
                                    <div class="row">
                                        <input type="hidden" id="pedido_facturar" value="<?php echo $id_factura ?>">
                                        <div class="col-lg-7">
                                            <div class="card-box">

                                                <div class="widget-chart">
                                                    <div id="resultados_ajaxf" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->
                                                    <form class="form-horizontal" role="form" id="barcode_form">
                                                        <input type="hidden" value="<?php echo $valor_base; ?>" id="costo_envio" name="costo_envio">
                                                        <?php if ($guia_enviada != 1) { ?>

                                                            <div class="form-group row">
                                                                <label for="barcode_qty" class="col-md-1 control-label">Cant:</label>
                                                                <div class="col-md-2">
                                                                    <input type="text" class="form-control" id="barcode_qty" value="1" autocomplete="off">
                                                                </div>

                                                                <label for="condiciones" class="control-label">Codigo:</label>
                                                                <div class="col-md-5" align="left">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" id="barcode" autocomplete="off" tabindex="1" autofocus="true">
                                                                        <span class="input-group-btn">
                                                                            <button type="submit" class="btn btn-default"><span class="fa fa-barcode"></span></button>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">

                                                                    <button type="button" accesskey="a" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#buscar">
                                                                        <span class="fa fa-search"></span> Buscar
                                                                    </button>

                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                    </form>


                                                    <div class="table-responsive">
                                                        <div id="resultados" class='col-md-12' style="margin-top:10px"></div>
                                                        <?php if ($guia_enviada == 1) {



                                                        ?>
                                                            <table class="table table-sm table-striped">
                                                                <tr>
                                                                    <th><img width="100px" src="../../img_sistema/logo-dark.png" alt="" /></th>
                                                                    <th></th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Total Venta </th>
                                                                    <td>$<?php $total_guia = get_row('guia_laar', 'costoproducto', 'id_pedido', $id_factura);
                                                                            echo $total_guia; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Costo </th>
                                                                    <td>$<?php $costo_guia = get_row('guia_laar', 'valor_costo', 'id_pedido', $id_factura);
                                                                            echo $costo_guia;
                                                                            ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Precio de Envío </th>
                                                                    <td>$<?php if (get_row('guia_laar', 'cod', 'id_pedido', $id_factura) == 1 && $guia_enviada != 1) {
                                                                                $valor_base = $valor_base + ($total_guia * 0.03);
                                                                            }
                                                                            if (get_row('guia_laar', 'cod', 'id_pedido', $id_factura) == 1 && $guia_enviada == 1) {
                                                                                $valor_base = $valor_base + (get_row('guia_laar', 'valorDeclarado', 'id_pedido', $id_factura) * 0.01);
                                                                            }
                                                                            if (get_row('guia_laar', 'valorDeclarado', 'id_pedido', $id_factura) > 1) {
                                                                                $valor_base = $valor_base + (get_row('guia_laar', 'valorDeclarado', 'id_pedido', $id_factura) * 0.01);
                                                                            }
                                                                            echo $valor_base;
                                                                            ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Comisión de la plataforma </th>
                                                                    <td>$0</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Monto a ganar </th>
                                                                    <td><strong>$<?php
                                                                                    echo $total_guia - $costo_guia - $valor_base;
                                                                                    //echo get_row('guia_laar', 'url_guia', 'id_pedido', $id_factura);
                                                                                    ?></td>
                                                                </tr></strong>
                                                            </table>
                                                        <?php
                                                        }
                                                        ?>
                                                        <!-- Carga los datos ajax -->

                                                        <!--div class="stepwizard">
    <div class="stepwizard-row">
        <div class="stepwizard-step">
            <button type="button" class="btn btn-default btn-circle">1</button>
            <p>Ingresdo</p>
        </div>
        <div class="stepwizard-step">
            <button type="button" class="btn btn-primary btn-circle">2</button>
            <p>Preparado</p>
        </div>
        <div class="stepwizard-step">
            <button type="button" class="btn btn-default btn-circle" disabled="disabled">3</button>
            <p>Impreso</p>
        </div> 
         <div class="stepwizard-step">
            <button type="button" class="btn btn-default btn-circle" disabled="disabled">3</button>
            <p>Impreso</p>
        </div> 
    </div>
</div-->


                                                    </div>

                                                </div>
                                            </div>
                                            <div id="valor_envio">

                                            </div>
                                        </div>

                                        <div class="col-lg-5">

                                            <?php if ($guia_enviada == 1) {
                                                if ($data['estadoActualCodigo'] == '8') {
                                            ?>
                                                    <div class="widget-bg-color-icon card-box">
                                                        <div class="bg-icon bg-icon-danger pull-left">
                                                            <i class="ti-dashboard text-danger"></i>
                                                        </div>
                                                        <div class="text-right">
                                                            <h5 class="text-dark text-center"><b class=" text-danger">Guía Anulada</b></h5>

                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <?php
                                                } else if (strpos($guia_numero, "FAST") === 0) {
                                                    $estadoGuia  = get_row('guia_laar', 'estado_guia', 'id_pedido', $id_factura);
                                                    if ($estadoGuia == 4) {
                                                    ?>
                                                        <div class="widget-bg-color-icon card-box">
                                                            <div class="bg-icon bg-icon-danger pull-left">
                                                                <i class="ti-dashboard text-danger"></i>
                                                            </div>
                                                            <div class="text-right">
                                                                <h5 class="text-dark text-center"><b class=" text-danger">Guía Anulada</b></h5>

                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    <?php
                                                    } else {
                                                        $url = get_row('guia_laar', 'url_guia', 'id_pedido', $id_factura);
                                                        $traking = "https://fast.imporsuit.com/GenerarGuia/visor/" . get_row('guia_laar', 'guia_laar', 'id_pedido', $id_factura);
                                                    ?>
                                                        <form role="form" id="datos_pedido">
                                                            <input type="hidden" id="nombredestino" name="nombredestino" class="form-control" value="<?php echo get_row('guia_laar', 'url_guia', 'id_pedido', $id_factura); ?>">
                                                            <input type="hidden" id="identificacion" name="identificacion" value="">
                                                            <input type="hidden" id="provinica" name="provinica" value="<?php echo get_row('guia_laar', 'url_guia', 'id_pedido', $id_factura); ?>">
                                                            <input type="hidden" id="ciudad_entrega" name="ciudad_entrega" value="<?php echo get_row('guia_laar', 'url_guia', 'id_pedido', $id_factura); ?>">
                                                            <input type="hidden" id="direccion_destino" name="direccion_destino" value="<?php echo get_row('guia_laar', 'url_guia', 'id_pedido', $id_factura); ?>">
                                                            <input type="hidden" id="referencia" name="referencia" value="<?php echo get_row('guia_laar', 'url_guia', 'id_pedido', $id_factura); ?>">
                                                            <input type="hidden" id="telefono" name="telefono" value="<?php echo get_row('guia_laar', 'url_guia', 'id_pedido', $id_factura); ?>">
                                                            <input id="celular" type="hidden" name="celular" value="<?php echo get_row('guia_laar', 'url_guia', 'id_pedido', $id_factura); ?>">
                                                            <input id="numerocasa" type="hidden" name="numerocasa" class="form-control" value="">
                                                            <input id="cod" type="hidden" name="cod">
                                                            <input id="seguro" type="hidden" name="seguro">
                                                            <input id="valorasegurado" type="hidden" name="valorasegurado" class="form-control" placeholder="Valor a aegurar">
                                                            <input type="hidden" id="observacion" name="observacion" class="form-control" value="<?php echo $observacion; ?>">



                                                        </form>
                                                        <div class="row">
                                                            <div align="center" class="col-md-3">
                                                                </br>

                                                                <button> <a style="cursor: pointer;" type="" href="<?php echo $url; ?>" target="blank" class=""><img width="80%" src="../../img_sistema/4.png" alt="" /><br>Imprimir Guía</a></button>
                                                            </div>

                                                            <div align="center" class="col-md-3">
                                                                </br>


                                                                <button style="cursor: pointer;" onclick="anular_guia('<?php echo get_row('guia_laar', 'guia_laar', 'id_pedido', $id_factura); ?>','<?php echo get_row('guia_laar', 'id_pedido', 'id_pedido', $id_factura); ?>')" type="button" href="<?php echo $traking; ?>" target="blank" class=""> <img width="80%" src="../../img_sistema/cancelar.jpeg" alt="" /><br>Cancelar guia</button>
                                                            </div>
                                                            <div align="center" class="col-md-3">
                                                                </br>
                                                                <?php
                                                                if (get_row('facturas_cot', 'facturada', 'id_factura', $id_factura) == 1) {

                                                                ?>

                                                                    <a style="cursor: pointer;" href="bitacora_ventas.php" type="button" href="#" target="blank" class="btn form-control"> <img width="80%" src="../../img_sistema/fac.jpg" alt="" /><br>Ver facturas</a>
                                                                <?php

                                                                } else {


                                                                ?>

                                                                    <button style="cursor: pointer;" onclick="agregar_datos_factura1()" type="button" href="#" target="blank" class=""> <img width="80%" src="../../img_sistema/fac.jpg" alt="" /><br>Facturar</button>
                                                                <?php

                                                                }
                                                                ?>
                                                            </div>

                                                        </div>
                                                        <div style="margin-top: 10px" id="factura_conguia" class="row">

                                                        </div>

                                                    <?php

                                                    }
                                                } else if (is_numeric($guia_numero)) {
                                                    $estadoGuia  = get_row('guia_laar', 'estado_guia', 'id_pedido', $id_factura);
                                                    if ($estadoGuia == 101) {
                                                    ?>
                                                        <div class="widget-bg-color-icon card-box">
                                                            <div class="bg-icon bg-icon-danger pull-left">
                                                                <i class="ti-dashboard text-danger"></i>
                                                            </div>
                                                            <div class="text-right">
                                                                <h5 class="text-dark text-center"><b class=" text-danger">Guía Anulada</b></h5>

                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    <?php
                                                    } else {
                                                        $url = get_row('guia_laar', 'url_guia', 'id_pedido', $id_factura);
                                                        $traking = "https://fast.imporsuit.com/GenerarGuia/visor/" . get_row('guia_laar', 'guia_laar', 'id_pedido', $id_factura);
                                                    ?>
                                                        <form role="form" id="datos_pedido">
                                                            <input type="hidden" id="nombredestino" name="nombredestino" class="form-control" value="<?php echo get_row('guia_laar', 'url_guia', 'id_pedido', $id_factura); ?>">
                                                            <input type="hidden" id="identificacion" name="identificacion" value="">
                                                            <input type="hidden" id="provinica" name="provinica" value="<?php echo get_row('guia_laar', 'url_guia', 'id_pedido', $id_factura); ?>">
                                                            <input type="hidden" id="ciudad_entrega" name="ciudad_entrega" value="<?php echo get_row('guia_laar', 'url_guia', 'id_pedido', $id_factura); ?>">
                                                            <input type="hidden" id="direccion_destino" name="direccion_destino" value="<?php echo get_row('guia_laar', 'url_guia', 'id_pedido', $id_factura); ?>">
                                                            <input type="hidden" id="referencia" name="referencia" value="<?php echo get_row('guia_laar', 'url_guia', 'id_pedido', $id_factura); ?>">
                                                            <input type="hidden" id="telefono" name="telefono" value="<?php echo get_row('guia_laar', 'url_guia', 'id_pedido', $id_factura); ?>">
                                                            <input id="celular" type="hidden" name="celular" value="<?php echo get_row('guia_laar', 'url_guia', 'id_pedido', $id_factura); ?>">
                                                            <input id="numerocasa" type="hidden" name="numerocasa" class="form-control" value="<?php echo $observacion; ?>">
                                                            <input id="cod" type="hidden" name="cod">
                                                            <input id="seguro" type="hidden" name="seguro">
                                                            <input id="valorasegurado" type="hidden" name="valorasegurado" class="form-control" placeholder="Valor a aegurar">
                                                            <input type="hidden" id="observacion" name="observacion" class="form-control" value="<?php echo $observacion; ?>">



                                                        </form>
                                                        <div class="row">
                                                            <div align="center" class="col-md-3">
                                                                </br>

                                                                <button> <a style="cursor: pointer;" type="" href="<?php echo $url; ?>" target="blank" class=""><img width="80%" src="../../img_sistema/4.png" alt="" /><br>Imprimir Guía</a></button>
                                                            </div>

                                                            <div align="center" class="col-md-3">
                                                                </br>


                                                                <button style="cursor: pointer;" onclick="anular_guia('<?php echo get_row('guia_laar', 'guia_laar', 'id_pedido', $id_factura); ?>','<?php echo get_row('guia_laar', 'id_pedido', 'id_pedido', $id_factura); ?>')" type="button" href="<?php echo $traking; ?>" target="blank" class=""> <img width="80%" src="../../img_sistema/cancelar.jpeg" alt="" /><br>Cancelar guia</button>
                                                            </div>
                                                            <div align="center" class="col-md-3">
                                                                </br>
                                                                <?php
                                                                if (get_row('facturas_cot', 'facturada', 'id_factura', $id_factura) == 1) {

                                                                ?>

                                                                    <a style="cursor: pointer;" href="bitacora_ventas.php" type="button" href="#" target="blank" class="btn form-control"> <img width="80%" src="../../img_sistema/fac.jpg" alt="" /><br>Ver facturas</a>
                                                                <?php

                                                                } else {


                                                                ?>

                                                                    <button style="cursor: pointer;" onclick="agregar_datos_factura1()" type="button" href="#" target="blank" class=""> <img width="80%" src="../../img_sistema/fac.jpg" alt="" /><br>Facturar</button>
                                                                <?php

                                                                }
                                                                ?>
                                                            </div>

                                                        </div>
                                                        <div style="margin-top: 10px" id="factura_conguia" class="row">

                                                        </div>

                                                    <?php

                                                    }
                                                } else {

                                                    $url = get_row('guia_laar', 'url_guia', 'id_pedido', $id_factura);
                                                    $traking = "https://fenix.laarcourier.com/Tracking/Guiacompleta.aspx?guia=" . get_row('guia_laar', 'guia_laar', 'id_pedido', $id_factura);
                                                    ?>
                                                    <form role="form" id="datos_pedido">
                                                        <input type="hidden" id="nombredestino" name="nombredestino" class="form-control" value="<?php echo get_row('guia_laar', 'url_guia', 'id_pedido', $id_factura); ?>">
                                                        <input type="hidden" id="identificacion" name="identificacion" value="">
                                                        <input type="hidden" id="provinica" name="provinica" value="<?php echo get_row('guia_laar', 'url_guia', 'id_pedido', $id_factura); ?>">
                                                        <input type="hidden" id="ciudad_entrega" name="ciudad_entrega" value="<?php echo get_row('guia_laar', 'url_guia', 'id_pedido', $id_factura); ?>">
                                                        <input type="hidden" id="direccion_destino" name="direccion_destino" value="<?php echo get_row('guia_laar', 'url_guia', 'id_pedido', $id_factura); ?>">
                                                        <input type="hidden" id="referencia" name="referencia" value="<?php echo get_row('guia_laar', 'url_guia', 'id_pedido', $id_factura); ?>">
                                                        <input type="hidden" id="telefono" name="telefono" value="<?php echo get_row('guia_laar', 'url_guia', 'id_pedido', $id_factura); ?>">
                                                        <input id="celular" type="hidden" name="celular" value="<?php echo get_row('guia_laar', 'url_guia', 'id_pedido', $id_factura); ?>">
                                                        <input id="numerocasa" type="hidden" name="numerocasa" class="form-control" value="">
                                                        <input id="cod" type="hidden" name="cod">
                                                        <input id="seguro" type="hidden" name="seguro">
                                                        <input id="valorasegurado" type="hidden" name="valorasegurado" class="form-control" placeholder="Valor a aegurar">
                                                        <input type="hidden" id="observacion" name="observacion" class="form-control" value="<?php echo $observacion; ?>">



                                                    </form>
                                                    <div class="row">
                                                        <div align="center" class="col-md-3">
                                                            </br>

                                                            <button> <a style="cursor: pointer;" type="" href="<?php echo $url; ?>" target="blank" class=""><img width="80%" src="../../img_sistema/4.png" alt="" /><br>Imprimir Guía</a></button>
                                                        </div>
                                                        <div align="center" class="col-md-3">
                                                            </br>

                                                            <button> <a style="cursor: pointer;" type="button" href="<?php echo $traking; ?>" target="blank" class=""> <img width="80%" src="../../img_sistema/5.png" alt="" /><br>Ver estado</a></button>
                                                        </div>
                                                        <div align="center" class="col-md-3">
                                                            </br>


                                                            <button style="cursor: pointer;" onclick="anular_guia('<?php echo get_row('guia_laar', 'guia_laar', 'id_pedido', $id_factura); ?>','<?php echo get_row('guia_laar', 'id_pedido', 'id_pedido', $id_factura); ?>')" type="button" href="<?php echo $traking; ?>" target="blank" class=""> <img width="80%" src="../../img_sistema/cancelar.jpeg" alt="" /><br>Cancelar guia</button>
                                                        </div>
                                                        <div align="center" class="col-md-3">
                                                            </br>


                                                            <?php
                                                            if (get_row('facturas_cot', 'facturada', 'id_factura', $id_factura) == 1) {

                                                            ?>

                                                                <a style="cursor: pointer;" href="bitacora_ventas.php" type="button" href="#" target="blank" class=""> <img width="80%" src="../../img_sistema/fac.jpg" alt="" /><br>Ver facturas</a>
                                                            <?php
                                                            } else {


                                                            ?>

                                                                <button style="cursor: pointer;" onclick="agregar_datos_factura1()" type="button" href="#" target="blank" class=""> <img width="80%" src="../../img_sistema/fac.jpg" alt="" /><br>Facturar</button>
                                                            <?php

                                                            }
                                                            ?>
                                                        </div>

                                                    </div>


                                                    <div style="margin-top: 10px" id="factura_conguia" class="row">

                                                    </div>

                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <H5><strong>DATOS PARA LA GUIA</strong></H5>
                                                <form role="form" id="datos_pedido">


                                                    <?php if ($_SERVER['HTTP_HOST'] == 'localhost') {
                                                        $destino = new mysqli('localhost', 'root', '', 'master');
                                                    } else {
                                                        $destino = new mysqli('localhost', 'imporsuit_marketplace', 'imporsuit_marketplace', 'imporsuit_marketplace');
                                                    }

                                                    if ($drogshipin == 1) {
                                                        $url_subdominio = $tienda;
                                                    } else {
                                                        $url_subdominio = $_SERVER['HTTP_HOST'];
                                                        $url_subdominio = 'https://imporshop.imporsuit.com';
                                                    }

                                                    //echo 'ads'.$url_subdominio;
                                                    @$full = get_row_destino($destino, 'plataformas', 'full_f', 'url_imporsuit', $url_subdominio);
                                                    //if()
                                                    //echo $full;  
                                                    //
                                                    ?>
                                                    <?php
                                                    if ($full == 1) {
                                                    ?>
                                                        <div class="row">

                                                            <div class="col-md-6">
                                                                <span class="help-block">Tipo de Guia </span>

                                                                <select onchange="tipo_transportadora()" class="datos form-control" id="transportadora" name="transportadora" required>
                                                                    <option value="">Seleccione transportadora</option>
                                                                    <option value="1" selected>Transportadoa Laar</option>
                                                                    <option value="2">Speed</option>


                                                                </select>

                                                            </div>

                                                        </div>
                                                    <?php

                                                    } else {
                                                    ?>
                                                        <input type="hidden" id="transportadora" name="transportadora" value="1">
                                                    <?php
                                                    }
                                                    ?>

                                                    <div class="row">

                                                        <div class="col-md-6">
                                                            <span class="help-block">Nombre Destinatario </span>
                                                            <input id="nombredestino" name="nombredestino" class="form-control" value="<?php echo $nombredestino; ?>">

                                                        </div>

                                                        <div class="col-md-6">
                                                            <span class="help-block">Identificacion </span>
                                                            <input id="identificacion" name="identificacion" class="form-control" placeholder="Ingrese Identificacion" value="">

                                                        </div>

                                                    </div>
                                                    <div class="row">

                                                        <div class="col-md-6">
                                                            <div id="div_ciudad_local">


                                                                <span class="help-block">Provincia </span>
                                                                <select onchange="cargar_provincia_pedido()" class="datos form-control" id="provinica" name="provinica" required>
                                                                    <option value="">Provincia *</option>
                                                                    <?php
                                                                    $sql2 = "select * from provincia_laar ";
                                                                    $query2 = mysqli_query($conexion, $sql2);

                                                                    while ($row2 = mysqli_fetch_array($query2)) {
                                                                        $id_prov = $row2['id_prov'];
                                                                        $provincia = $row2['provincia'];
                                                                        $cod_provincia = $row2['codigo_provincia'];

                                                                        // Obtener el valor almacenado en la tabla orgien_laar
                                                                        $valor_seleccionado = $provinciadestino;

                                                                        // Verificar si el valor actual coincide con el almacenado en la tabla
                                                                        $selected = ($valor_seleccionado == $cod_provincia) ? 'selected' : '';

                                                                        // Imprimir la opción con la marca de "selected" si es el valor almacenado
                                                                        echo '<option value="' . $cod_provincia . '" ' . $selected . '>' . $provincia . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>



                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <span class="help-block">Ciudad </span>
                                                            <div id="div_ciudad">
                                                                <select onchange="calcular_guia()" class="datos form-control" id="ciudad_entrega" name="ciudad_entrega" required>
                                                                    <option value="">Ciudad *</option>
                                                                    <?php
                                                                    $sql2 = "select * from ciudad_laar ";
                                                                    //echo $sql2;
                                                                    $query2 = mysqli_query($conexion, $sql2);

                                                                    $rowcount = mysqli_num_rows($query2);
                                                                    //echo $rowcount;
                                                                    $i = 1;
                                                                    while ($row2 = mysqli_fetch_array($query2)) {
                                                                        $id_ciudad       = $row2['id_ciudad'];
                                                                        $nombre      = $row2['nombre'];
                                                                        $cod_ciudad      = $row2['codigo'];
                                                                        $valor_seleccionado = $ciudaddestino;
                                                                        $selected = ($valor_seleccionado == $cod_ciudad) ? 'selected' : '';

                                                                        // Imprimir la opción con la marca de "selected" si es el valor almacenado
                                                                        echo '<option value="' . $cod_ciudad . '" ' . $selected . '>' . $nombre . '</option>';

                                                                    ?>

                                                                    <?php } ?>
                                                                </select>
                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div class="row">

                                                        <div class="col-md-6">
                                                            <span class="help-block">Dirección </span>
                                                            <input id="direccion_destino" name="direccion_destino" class="form-control" value="<?php echo $direccion; ?>">

                                                        </div>

                                                        <div class="col-md-6">
                                                            <span class="help-block">Referencia </span>
                                                            <input id="referencia" name="referencia" class="form-control" placeholder="Referencia" value="<?php echo $referencia; ?>">

                                                        </div>

                                                    </div>

                                                    <div class="row">

                                                        <div class="col-md-6">
                                                            <span class="help-block">Teléfono </span>
                                                            <input id="telefono" name="telefono" class="form-control" value="<?php echo $telefono; ?>">

                                                        </div>

                                                        <div class="col-md-6">
                                                            <span class="help-block">Celular </span>
                                                            <input id="celular" name="celular" class="form-control" placeholder="Celular" value="<?php echo $telefono; ?>">

                                                        </div>

                                                    </div>
                                                    <div class="row">

                                                        <div class="col-md-6">
                                                            <span class="help-block">Numero de casa </span>
                                                            <input id="numerocasa" name="numerocasa" class="form-control" value="">

                                                        </div>

                                                        <div class="col-md-3">
                                                            <span class="help-block">Recaudo </span>
                                                            <select onchange="calcular_guia()" id="cod" name="cod" class="form-control">
                                                                <option value="0">Seleccionar</option>
                                                                <option value="1" selected>Con Recuado</option>
                                                                <option value="0">Sin Recaudo </option>
                                                            </select>



                                                        </div>

                                                        <div class="col-md-3">
                                                            <span class="help-block">Seguro </span>
                                                            <select onchange="calcular_guia()" id="seguro" name="seguro" class="form-control">
                                                                <option value="">Deseas asegurar la mercadería </option>
                                                                <option value="1">SI</option>
                                                                <option value="0">NO </option>
                                                            </select>
                                                            <input id="valorasegurado" name="valorasegurado" class="form-control" value="" placeholder="Valor a aegurar">



                                                        </div>



                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <span class="help-block">Observaciones para la entrega </span>
                                                            <input id="observacion" name="observacion" class="form-control" value="<?php echo $observacion; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <?php
                                                        $pais = get_row('perfil', 'pais', 'id_perfil', 1);
                                                        if ($pais == 1) {
                                                        ?>
                                                            <div class="col-md-3">
                                                                </br>

                                                                <button style="cursor: pointer;" id="generar_guia_btn" type="button" onclick="generar_guia()" class="btn btn-danger" disabled>Generar Guía</button>

                                                            </div>
                                                            <div class="col-md-3">
                                                                </br>
                                                                <button style="cursor: pointer;" type="button" onclick="calcular_guia()" class="btn btn-primary">Calcular</button>
                                                            </div>
                                                        <?php

                                                        }
                                                        ?>
                                                        <div class="col-md-6">
                                                            </br>


                                                        </div>
                                                    </div>
                                                    <div class="row">

                                                        factura
                                                    </div>
                                                </form>
                                            <?php

                                            }
                                            ?>
                                        </div>



                                    </div>
                                    <!-- end row -->

                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                } else {
                ?>
                    <section class="content">
                        <div class="alert alert-danger" align="center">
                            <h3>Acceso denegado! </h3>
                            <p>No cuentas con los permisos necesario para acceder a este módulo.</p>
                        </div>
                    </section>
                <?php
                }
                ?>

            </div>
            <!-- end container -->
        </div>
        <!-- end content -->

        <?php require 'includes/pie.php'; ?>

    </div>
    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->


</div>
<!-- END wrapper -->

<?php require 'includes/footer_start.php'
?>
<!-- ============================================================== -->
<!-- Todo el codigo js aqui-->
<!-- ============================================================== -->
<script type="text/javascript" src="../../js/VentanaCentrada.js"></script>
<script type="text/javascript" src="../../js/editar_cotizacion.js"></script>
<!-- ============================================================== -->
<!-- Codigos Para el Auto complete de Clientes -->
<script>
    $(function() {
        $("#nombre_cliente").autocomplete({
            source: "../ajax/autocomplete/clientes.php",
            minLength: 2,
            select: function(event, ui) {
                event.preventDefault();
                $('#id_cliente').val(ui.item.id_cliente);
                $('#nombre_cliente').val(ui.item.nombre_cliente);
                $('#rnc').val(ui.item.fiscal_cliente);
                $.Notification.notify('custom', 'bottom right', 'EXITO!', 'CLIENTE AGREGADO CORRECTAMENTE')
            }
        });
    });

    $("#nombre_cliente").on("keydown", function(event) {
        if (event.keyCode == $.ui.keyCode.LEFT || event.keyCode == $.ui.keyCode.RIGHT || event.keyCode == $.ui.keyCode.UP || event.keyCode == $.ui.keyCode.DOWN || event.keyCode == $.ui.keyCode.DELETE || event.keyCode == $.ui.keyCode.BACKSPACE) {
            $("#id_cliente").val("");
            $("#rnc").val("");
            $("#resultados4").load("../ajax/tipo_doc.php");
        }
        if (event.keyCode == $.ui.keyCode.DELETE) {
            $("#nombre_cliente").val("");
            $("#id_cliente").val("");
            $("#rnc").val("");
        }
    });
</script>
<!-- FIN -->
<script>
    // print order function
    function tipo_transportadora() {
        //alert();
        var transportadora = $('#transportadora').val();
        // alert(transportadora)
        //var data = new FormData(formulario);
        if (transportadora == 2) {
            $('#seguro').val(0);
            $('#valorasegurado').attr('disabled', 'disabled');
            $('#seguro').attr('disabled', 'disabled');
        } else {
            $('#valorasegurado').removeAttr('disabled', 'disabled');
            $('#seguro').removeAttr('disabled', 'disabled');
        }

        $.ajax({
            url: "../ajax/cargar_ciudad_transportadora.php", // Url to which the request is send
            type: "POST", // Type of request to be send, called as method
            data: {
                transportadora: transportadora,


            }, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            dataType: 'text', // To send DOMDocument or non processed data file it is set to false
            success: function(data) // A function to be called if request succeeds
            {



                $('#div_ciudad_local').html(data);
                $('#div_ciudad').html('');


            }
        });

    }


    function cargar_provincia_pedido() {

        var id_provincia = $('#provinica').val();
        //alert($('#provinica').val())
        //var data = new FormData(formulario);

        $.ajax({
            url: "../ajax/cargar_ciudad_pedido.php", // Url to which the request is send
            type: "POST", // Type of request to be send, called as method
            data: {
                provinica: id_provincia,


            }, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            dataType: 'text', // To send DOMDocument or non processed data file it is set to false
            success: function(data) // A function to be called if request succeeds
            {



                $('#div_ciudad').html(data);


            }
        });

    }





    function generar_guia(id_factura) {
        $('#generar_guia_btn').prop('disabled', true);
        nombre_destino = $('#nombredestino').val();
        identificacion = $('#identificacion').val();
        ciudad = $('#ciudad_entrega').val();;
        //alert(ciudad);
        direccion_destino = $('#direccion_destino').val(); //CIERRA LA MODAL
        //alert(direccion_destino);
        referencia = $('#referencia').val(); //CIERRA LA MODAL
        telefono = $('#telefono').val(); //CIERRA LA MODAL
        celular = $('#celular').val(); //CIERRA LA MODAL
        observacion = $('#observacion').val(); //CIERRA LA MODAL
        cod = $('#cod').val(); //CIERRA LA MODAL
        seguro = $('#seguro').val(); //CIERRA LA MODAL
        productos_guia = $('#productos_guia').val();
        cantidad_total = $('#cantidad_total').val();
        valor_total = $('#valor_total_').val();
        costo_total = $('#costo_total').val();

        numerocasa = $('#numerocasa').val();
        valor_envio = $('#valor_total_').val();
        valorasegurado = $('#valorasegurado').val();

        id_pedido_cot = $('#id_pedido_cot').val();
        costo_envio = $('#valor_envio2').val();
        var utilidad = valor_envio - costo_total - costo_envio;



        id_factura = 1;

        transportadora = $('#transportadora').val();



        if (utilidad > 0) {
            if (transportadora == 1) {
                url = '../ajax/enviar_laar.php';
                regresar = 0;
            } else {
                url = '../ajax/enviar_guia_local.php';
                regresar = 1;
            }
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    nombre_destino: nombre_destino,
                    ciudad: ciudad,
                    direccion: direccion_destino,
                    referencia: referencia,
                    telefono: telefono,
                    celular: celular,
                    observacion: observacion,
                    cod: cod,
                    seguro: seguro,
                    productos_guia: productos_guia,
                    cantidad_total: cantidad_total,
                    valor_total: valor_total,
                    numerocasa: numerocasa,
                    id_pedido_cot: id_pedido_cot,
                    identificacion: identificacion,
                    costo_total: costo_total,
                    valorasegurado: valorasegurado,
                    costo_envio: costo_envio,

                },
                dataType: 'text',
                success: function(response) {

                    if (response == 'ok') {
                        Swal.fire({
                            title: "¡Generación de guía exitosa!",
                            icon: "success",
                            confirmButtonText: "¡Aceptar!",
                        }).then(() => {
                            if (regresar == 0) {
                                window.location.reload();
                            } else {
                                window.location.href = 'bitacora_cotizacion_new.php';
                            }
                        });
                    } else {
                        //  let objetoJSON = JSON.parse(response);
                        Swal.fire({
                            title: "Oops...",
                            text: response,
                            icon: "error",
                            confirmButtonText: "¡Aceptar!",
                        }).then(() => {
                            window.location.reload();
                        });

                    }

                } // /success function

            }); // /ajax function to fetch the printable order
        } else {
            if (cod == 1) {
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        nombre_destino: nombre_destino,
                        ciudad: ciudad,
                        direccion: direccion_destino,
                        referencia: referencia,
                        telefono: telefono,
                        celular: celular,
                        observacion: observacion,
                        cod: cod,
                        seguro: seguro,
                        productos_guia: productos_guia,
                        cantidad_total: cantidad_total,
                        valor_total: valor_total,
                        numerocasa: numerocasa,
                        id_pedido_cot: id_pedido_cot,
                        identificacion: identificacion,
                        costo_total: costo_total,
                        valorasegurado: valorasegurado,
                        costo_envio: costo_envio,

                    },
                    dataType: 'text',
                    success: function(response) {

                        if (response == 'ok') {
                            Swal.fire({
                                title: "¡Generación de guía exitosa!",
                                icon: "success",
                                confirmButtonText: "¡Aceptar!",
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            //  let objetoJSON = JSON.parse(response);
                            Swal.fire({
                                title: "Oops...",
                                text: response,
                                icon: "error",
                                confirmButtonText: "¡Aceptar!",
                            }).then(() => {
                                window.location.reload();
                            });

                        }

                    } // /success function

                }); // /ajax function to fetch the printable order
            } else {
                Swal.fire({
                    title: "¡El monto a recibir es menor a 0! Por favor verifique los valores",
                    icon: "error",
                    confirmButtonText: "¡Aceptar!",
                }).then(() => {
                    // window.location.reload();
                });
            }
        }
    }

    function anular_guia(guia, id) {

        id_factura = 1;
        if (id_factura = 1) {
            $.ajax({
                url: '../ajax/eliminar_guia.php',
                type: 'post',
                data: {
                    guia: guia,
                    id: id,

                },
                dataType: 'text',
                success: function(response) {

                    if (response == 'ok') {
                        location.reload();
                    } else {
                        alert(response)
                    }

                } // /success function

            }); // /ajax function to fetch the printable order
        } // /if orderId
    }

    function printOrder(id_factura) {
        $('#modal_vuelto').modal('hide'); //CIERRA LA MODAL
        if (id_factura) {
            $.ajax({
                url: '../pdf/documentos/imprimir_venta.php',
                type: 'post',
                data: {
                    id_factura: id_factura
                },
                dataType: 'text',
                success: function(response) {
                    var mywindow = window.open('', 'Stock Management System', 'height=400,width=600');
                    mywindow.document.write('<html><head><title>Facturación</title>');
                    mywindow.document.write('</head><body>');
                    mywindow.document.write(response);
                    mywindow.document.write('</body></html>');
                    mywindow.document.close(); // necessary for IE >= 10
                    mywindow.focus(); // necessary for IE >= 10
                    mywindow.print();
                    mywindow.close();
                } // /success function

            }); // /ajax function to fetch the printable order
        } // /if orderId
    } // /print order function
</script>
<script>
    // print order function
    function printFactura(id_factura) {
        $('#modal_vuelto').modal('hide');
        if (id_factura) {
            $.ajax({
                url: '../pdf/documentos/imprimir_factura_venta.php',
                type: 'post',
                data: {
                    id_factura: id_factura
                },
                dataType: 'text',
                success: function(response) {
                    var mywindow = window.open('', 'Stock Management System', 'height=400,width=600');
                    mywindow.document.write('<html><head><title>Facturación</title>');
                    mywindow.document.write('</head><body>');
                    mywindow.document.write(response);
                    mywindow.document.write('</body></html>');
                    mywindow.document.close(); // necessary for IE >= 10
                    mywindow.focus(); // necessary for IE >= 10
                    mywindow.print();
                    mywindow.close();
                } // /success function

            }); // /ajax function to fetch the printable order
        } // /if orderId
    } // /print order function
</script>
<script>
    function obtener_caja(user_id) {
        $(".outer_div3").load("../modal/carga_caja.php?user_id=" + user_id); //carga desde el ajax
    }

    function showDiv(select) {
        if (select.value == 4) {
            $("#resultados3").load("../ajax/carga_prima.php");
        } else {
            $("#resultados3").load("../ajax/carga_resibido.php");
        }
    }

    function comprobar(select) {
        var rnc = $("#rnc").val();
        id_comp == $("#id_comp").val();
        //alert(id_comp)
        if (select.value == 1 && rnc == '') {
            $.Notification.notify('warning', 'bottom center', 'NOTIFICACIÓN', 'AL CLIENTE SELECCIONADO NO SE LE PUEDE IMPRIR LA FACTURA, NO TIENE RNC/DEDULA REGISTRADO')
            $("#resultados4").load("../ajax/tipo_doc.php");
        } else {
            //$("#resultados3").load("../ajax/carga_resibido.php");
        }
    }

    function agregar_datos_factura1() {

        //alert()
        id_pedido = $("#pedido_facturar").val();
        $.ajax({
            url: '../ajax/factura_guia.php',
            type: 'post',
            data: {
                id_factura: id_pedido
            },
            dataType: 'text',
            success: function(response) {
                $("#factura_conguia").html(response);
                getval(1)
                //$("#load_img")
            } // /success function

        }); // /ajax function to fetch the printable order
    }

    function getval(sel) {
        // alert(sel);
        $.Notification.notify('success', 'bottom center', 'NOTIFICACIÓN', 'CAMBIO DE COMPROBANTE')
        $("#outer_comprobante").load("../ajax/carga_correlativos.php?id_comp=" + sel);

    }
    $(document).ready(function() {
        $(".UpperCase").on("keypress", function() {
            $input = $(this);
            setTimeout(function() {
                $input.val($input.val().toUpperCase());
            }, 50);
        })
    })
</script>

<?php require 'includes/footer_end.php'
?>