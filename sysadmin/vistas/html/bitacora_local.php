<?php
session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
    header("location: ../../login.php");
    exit;
}

/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
//Inicia Control de Permisos

include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Pedidos";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
$title  = "Ventas";
$ventas = 1;
?>

<?php require 'includes/header_start.php'; ?>

<?php require 'includes/header_end.php'; ?>

<!-- Begin page -->
<div id="wrapper">

    <?php require 'includes/menu.php'; ?>

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
                                    Bítacora de Cotización
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
                                    <?php
                                    include "../modal/eliminar_factura.php";
                                    include "../modal/cambiar_estado_guia.php";

                                    ?>

                                    <form class="form-horizontal" role="form" id="datos_cotizacion">
                                        <div class="form-group row">
                                            <div class="col-md-5">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="q" placeholder="Nombre del cliente o # factura" onkeyup='load(1);'>
                                                    <select onchange="buscar(this.value)" id="tienda_q" class="form-control">
                                                        <option value="0"> Seleccione Tienda </option>
                                                        <?php

                                                        //echo "select * from estado_guia";
                                                        $query_categoria = mysqli_query($conexion, "select distinct tienda from facturas_cot");
                                                        while ($rw = mysqli_fetch_array($query_categoria)) {
                                                        ?>
                                                            <option value="<?php echo $rw['tienda']; ?>"><?php echo $rw['tienda']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select onchange="buscar_estado(this.value)" name="estado_q" class="form-control" id="estado_q">
                                                        <option value="0"> Seleccione Estado </option>
                                                        <?php

                                                        //echo "select * from estado_guia";
                                                        $query_categoria = mysqli_query($conexion, "select * from estado_courier");
                                                        while ($rw = mysqli_fetch_array($query_categoria)) {
                                                        ?>
                                                            <option value="<?php echo $rw['codigo']; ?>"><?php echo $rw['alias']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>

                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-info waves-effect waves-light" onclick='load(1);'>
                                                            <span class="fa fa-search"></span></button>
                                                    </span>
                                                </div>

                                            </div>
                                            <div class="col-md-4">
                                                <span id="loader"></span>
                                            </div>

                                        </div>
                                    </form>
                                    <div class="datos_ajax_delete"></div><!-- Datos ajax Final -->
                                    <div class='outer_div'></div><!-- Carga los datos ajax -->



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
<script type="text/javascript" src="../../js/bitacora_local.js"></script>
<script src="../ajax/js/wallet.js"></script>
<?php require 'includes/footer_end.php'
?>