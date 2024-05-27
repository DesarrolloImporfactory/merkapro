<?php

$tienda = $_GET['tienda'];


session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
    header("location: ../../login.php");
    exit;
}
$marketplace_url = $_SERVER['HTTP_HOST'];
$marketplace_url = str_replace(["www.", ".com"], "", $marketplace_url);

// Compara en minúsculas para evitar problemas de sensibilidad a mayúsculas y minúsculas
if (strtolower($marketplace_url) !== "merkapro.ec" && strtolower($marketplace_url) !== 'localhost') {
    header("location: ../../login.php");
    exit;
}
/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
require_once "../funciones.php"; //Contiene funcion que conecta a la base de datos

//Inicia Control de Permisos
include "../permisos.php";

$user_id = $_SESSION['id_users'];
$_SESSION['tienda'] = $tienda;

get_cadena($user_id);
$modulo = "Wallets";
permisos($modulo, $cadena_permisos);



$datos = "SELECT DISTINCT numero_factura, fecha, cliente, estado_guia, estado_pedido, total_venta, valor_cobrado, valor_pendiente, precio_envio, costo, monto_recibir FROM cabecera_cuenta_pagar WHERE tienda = '$tienda'";
$datos_query = mysqli_query($conexion, $datos);
$rw = mysqli_fetch_array($datos_query);

$valor_pendiente = get_row('cabecera_cuenta_pagar', 'valor_pendiente', 'numero_factura', $id_factura);
$tiendaN = str_replace('https://', '', $tienda);
$tiendaN = str_replace('http://', '', $tiendaN);
$tiendaN = str_replace('.imporsuit.com', '', $tiendaN);
$tiendaN = strtoupper($tiendaN);

?>

<?php require 'includes/header_start.php'; ?>


<?php require 'includes/header_end.php'; ?>

<div id="wrapper">

    <?php require 'includes/menu.php'; ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->

    <div class="modal fade" id="tiendaModal" tabindex="-1" aria-labelledby="tiendaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tiendaModalLabel">Información de la Tienda</h5>
                    <button type="button" class="btn-close" onclick="cerrarModal()" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="boody">
                    <!-- Aquí va el contenido que quieras mostrar en el modal -->
                    <p id="modalContent">Aquí va la información de la tienda.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary " onclick="cerrarModal()" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
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
                                    Pagar de Wallet
                                </h3>
                                <div class="portlet-widgets">
                                    <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                                    <span class="divider"></span>
                                    <a data-toggle="collapse" data-parent="#accordion1" href="#bg-primary"><i class="ion-minus-round"></i></a>
                                    <span class="divider"></span>
                                    <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div id="bg-primary" class="panel-collapse collapse show">
                                <div class="portlet-body">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <?php
                                            include "../modal/agregar_abono_wallet.php";
                                            include "../modal/agregar_deuda_wallet.php";
                                            ?>
                                            <div class="col-lg-12 col-md-6">
                                                <div class="widget-bg-color-icon card-box">
                                                    <div class="bg-icon bg-icon-purple pull-left">
                                                        <i class="ti-user text-purple"></i>
                                                    </div>
                                                    <div class="text-right">
                                                        <h5 class="text-dark"><b class="counter"> <span class="text-link" onclick="abrirModalTienda('<?php echo $tiendaN; ?>')"> <?php echo $tienda; ?></span></b></h5>
                                                        <a class='btn btn-primary waves-effect waves-light btn-sm m-b-5' href="wallet.php" title="Regresar a la wallet"><i class="fa fa-reply"></i> Regresar
                                                        </a>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                            <div id="widgets"></div>

                                        </div>
                                        <div class="col-lg-8">
                                            <div class="panel panel-color panel-info">
                                                <div class="panel-body">
                                                    <form class="form-horizontal" role="form" id="datos_cotizacion">
                                                        <div class="form-group row">
                                                            <div class="col-xs-4">

                                                            </div>
                                                            <div class="col-xs-3">
                                                                <div id="loader" class="text-left"></div>
                                                            </div>
                                                            <div class="col-xs-2">
                                                                <div class="btn-group pull-center">
                                                                    <?php if ($permisos_ver == 1) { ?>
                                                                        <button type="button" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#add-stock"><i class="fa fa-plus"></i> Abono</button>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-2">
                                                                <div class="btn-group pull-center">
                                                                    <?php if ($permisos_ver == 1) { ?>
                                                                        <button type="button" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#remove-stock"><i class="fa fa-minus"></i> Deuda</button>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-xs-2">
                                                                <div class="btn-group pull-center">
                                                                    <?php if ($permisos_ver == 1) { ?>
                                                                        <button type="button" onclick="reporte();" class="btn btn-default waves-effect waves-light" title="Imprimir"><i class='fa fa-print'></i></button>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <div class="col-md-12" align="center">
                                                        <div id="resultados_ajax"></div>
                                                        <div class="clearfix"></div>
                                                        <div class='outer_div'></div><!-- Carga los datos ajax -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div id="detalles"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div id="facturas"></div>
                                        </div>
                                    </div>

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
<script src="../../js/ver_pagar_wallet.js"></script>
<script>
    function reporte() {
        var id_factura = '<?php echo $id_factura; ?>';
        var tienda = '<?php echo $tienda; ?>';
        var daterange = $('#range').val();
        VentanaCentrada('../pdf/documentos/reporte_pagos_wallet.php?id_factura=' + id_factura + '&tienda=' + tienda + '&daterange=' + daterange, 'Reporte', '', '800', '600', 'true');
    }
</script>
<?php require 'includes/footer_end.php'
?>