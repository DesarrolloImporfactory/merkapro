<?php
session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
    header("location: ../../login.php");
    exit;
}

// Al inicio del script
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
//Inicia Control de Permisos
include "../permisos.php";


$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Wallets";
permisos($modulo, $cadena_permisos);

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
                                    Bitacora de Wallet
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
                                    <form id="wallet" role="form" class="form-horizontal">
                                        <div class="form-group row">
                                            <div class="col-md-5">
                                                <div class="input-group mb-2">
                                                    <input type="text" class="form-control" id="q" placeholder="Nombre del cliente o # factura" onkeyup='load(1);'>
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-info waves-effect waves-light" onclick='load(1);'>
                                                            <span class="fa fa-search"></span></button>
                                                    </span>
                                                </div>

                                                <!-- Modal -->
                                                <div class="modal fade" id="recibos" tabindex="-1" aria-labelledby="recibosLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="recibosLabel">Recibos</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="cerrarModal()"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div id="resultados_recibo"></div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" onclick="cerrarModal()" data-bs-dismiss="modal">Cerrar</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-4">
                                                <span id="loader"></span>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="datos_ajax_delete"></div> <!-- Datos ajax Final -->
                                    <div class="outer_div"></div><!-- Datos ajax Final -->
                                    <div class="col-md-4 input-group ">
                                        <label for="numero_q">Numero de facturas a ver: </label>
                                        <select onchange="buscar_numero(this.value)" name="numero_q" class="form-control" id="numero_q">
                                            <option value="10"> 10 </option>
                                            <option value="20"> 20 </option>
                                            <option value="50"> 50 </option>
                                            <option value="100"> 100 </option>

                                        </select>
                                    </div>
                                    <div id="etc">

                                        <div id="proveedor">

                                        </div>
                                        <div class="col-md-4 input-group ">
                                            <label for="numero_q2">Numero de facturas a ver: </label>
                                            <select onchange="buscar_numero2(this.value)" name="numero_q2" class="form-control" id="numero_q2">
                                                <option value="10"> 10 </option>
                                                <option value="20"> 20 </option>
                                                <option value="50"> 50 </option>
                                                <option value="100"> 100 </option>

                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- end row -->


                        </div>

                        <!-- /.box -->


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
        </div>
    </div>
</div>


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
<script>
    function filtrarDatos() {
        // Obtén los valores de los campos de filtro
        var fechaInicio = $('#fecha_inicio').val();
        var fechaFin = $('#fecha_fin').val();
        var estado = $('#estado').val();

        // Realiza la petición Ajax
        $.ajax({
            type: 'GET',
            url: '../ajax/filtro_input.php',
            data: {
                fecha_inicio: fechaInicio,
                fecha_fin: fechaFin,
                estado: estado
            },
            success: function(response) {
                // Actualiza la sección de resultados con la respuesta del servidor
                $('#resultados').html(response);
            },
            error: function(error) {
                console.error('Error en la petición Ajax:', error);
            }
        });
    }

    function cargar_recibos(id_cabecera) {
        $.ajax({
            type: "POST",
            url: "../modal/recibos.php",
            data: "id_cabecera_cpp=" + id_cabecera,
            beforeSend: function(objeto) {
                $("#resultados_ajax").html('<img src="../../img/ajax-loader.gif"> Cargando...');
            },
            success: function(datos) {
                console.log(datos);
                var resultado = document.querySelector('#resultados_recibo');
                resultado.innerHTML = datos;
                $('#recibos').modal('show');
                $("#resultados_recibos").html(datos);
            }
        });
    }
    flatpickr("#start-date", {
        dateFormat: "Y-m-d",
        locale: "es",
        maxDate: "today",
        disableMobile: "true",
    });
    flatpickr("#end-date", {
        dateFormat: "Y-m-d",
        locale: "es",
        maxDate: "today",
        disableMobile: "true",
    });

    function cerrarModal() {
        $('#recibos').modal('hide');
    }

    $('.filtroInput').change(function() {
        filtrarDatos();
    });

    $("#perfil").submit(function(event) {
        $('.guardar_datos').attr("disabled", true);

        var parametros = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "../ajax/editar_origen.php",
            data: parametros,
            beforeSend: function(objeto) {
                $("#resultados_ajax").html('<img src="../../img/ajax-loader.gif"> Cargando...');
            },
            success: function(datos) {
                $("#resultados_ajax").html(datos);
                $('.guardar_datos').attr("disabled", false);
                //desaparecer la alerta
                $(".alert-success").delay(400).show(10, function() {
                    $(this).delay(2000).hide(10, function() {
                        $(this).remove();
                    });
                }); // /.alert

            }
        });
        event.preventDefault();
    })


    $(document).on('change', 'input[type="checkbox"]', function(e) {
        if (this.id == "flotar") {
            if (this.checked) {
                id = 1;
            } else {
                id = 0;
            }
            $.ajax({
                type: "GET",
                url: "../ajax/habilitaproveedor.php",
                data: "id=" + id,
                beforeSend: function(objeto) {
                    $("#resultados").html('<img src="../../img/ajax-loader.gif"> Cargando...');
                },
                success: function(datos) {

                    $("#resultados").html(datos);

                }
            });

        }

    });
</script>

<script type="text/javascript" src="../../js/VentanaCentrada.js"></script>
<script type="text/javascript" src="../../js/bitacora_wallet.js"></script>

<?php require 'includes/footer_end.php'
?>