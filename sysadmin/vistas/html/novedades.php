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
$modulo = "Categorias";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
$title     = "Categorias";
$pacientes = 1;
?>


<?php require 'includes/header_start.php'; ?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<style>
    .caja {
        padding-left: 40px !important;
        padding-right: 40px !important;
        border-radius: 0.5rem !important;
        background-color: white;
    }

    .btn-excel {
        background-color: #1b6d41;
        color: white;
    }

    .btn-solucion {
        background-color: #FFD100;
        color: white;
    }

    hr {
        border: none;
        /* Quita el borde predeterminado */
        height: 2px;
        /* Ajusta el grosor de la línea */
        background-color: #000;
        /* Ajusta el color de la línea */
        margin: 20px 0;
        /* Ajusta el espaciado vertical de la línea */
    }

    .formulario {
        width: 40%;
    }
</style>
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
            <div class="container d-flex flex-column">
                <div>
                    <h1>Historial de Novedades</h1>
                </div>
                <div class="modal fade" id="novedad" tabindex="-1" aria-labelledby="novedadLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="novedadLabel">Novedad</h5>
                                <button type="button" class="btn-close" onclick="" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="boody">
                                <!-- Aquí va el contenido que quieras mostrar en el modal -->
                                <p id="modalContent">Aquí va la información de la tienda.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" onclick="" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="detalleNovedad" tabindex="-1" aria-labelledby="detalleNovedadLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detalleNovedadLabel">Novedades</h5>
                                <button type="button" class="btn-close" onclick="" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="boody_detail">
                                <!-- Aquí va el contenido que quieras mostrar en el modal -->
                                <p id="modalContent">Aquí va la información de la tienda.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" onclick="" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="caja d-flex flex-column">
                    <div class="d-flex flex-row">
                        <div class="container" style="margin: 0; padding-left: 0;">
                            <h4>Seleccione fecha de inicio:</h4>
                            <div class="input-group date" id="datepickerInicio">
                                <input type="text" class="form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="container" style="padding-left: 15px;">
                            <h4>Seleccione fecha de fin:</h4>
                            <div class="input-group date" id="datepickerFin">
                                <input type="text" class="form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <div class="d-flex flex-row justify-content-start">
                                <div class="form-check mr-3">
                                    <input type="checkbox" class="form-check-input" id="impuestos">
                                    <label class="form-check-label" for="impuestos">Filtrar por Fecha de la orden</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="impuestos">
                                    <label class="form-check-label" for="impuestos">Filtrar por Fecha de Solución</label>
                                </div>
                            </div>
                            <div class="form-check mt-2 d-flex flex-row-reverse">
                                <div>
                                    <input type="checkbox" class="form-check-input" id="impuestos">
                                    <label class="form-check-label" for="impuestos">Filtrar por Fecha de Novedad</label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="d-flex flex-row">
                        <div class="d-flex flex-column" style="width: 100%;">
                            <div class="d-flex flex-row justify-content-start">
                                <div style="width: 100%;">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label" style="padding-left: 0;">Tienda</label>
                                    <div>
                                        <select class="form-control" name="alineacion_titulo" id="alineacion_titulo">
                                            <option value="1">Izquierda </option>
                                            <option value="2">Centro </option>
                                            <option value="3">Derecha </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div style="width: 100%;">
                                <label for="inputPassword3" class="col-sm-2 col-form-label" style="padding-left: 0;">Ciudad</label>
                                <div>
                                    <select class="form-control" name="alineacion_titulo" id="alineacion_titulo">
                                        <option value="1">Izquierda </option>
                                        <option value="2">Centro </option>
                                        <option value="3">Derecha </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div style="width: 100%;">
                            <label style="padding-left: 20px;" for="inputPassword3" class="col-sm-2 col-form-label">Estado</label>
                            <div style="padding-left: 20px;">
                                <select class="form-control" name="alineacion_titulo" id="alineacion_titulo">
                                    <option value="1">Izquierda </option>
                                    <option value="2">Centro </option>
                                    <option value="3">Derecha </option>
                                </select>
                            </div>
                        </div>
                        <div style="width: 100%;">
                            <label style="padding-left: 20px;" for="inputPassword3" class="col-sm-2 col-form-label">Departamento</label>
                            <div style="padding-left: 20px;">
                                <select class="form-control" name="alineacion_titulo" id="alineacion_titulo">
                                    <option value="1">Izquierda </option>
                                    <option value="2">Centro </option>
                                    <option value="3">Derecha </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div style="padding-top: 20px;">
                        <button type="button" class="btn btn-excel"><i class='bx bxs-spreadsheet'></i> Descargar en Excel</button>
                    </div>

                    <hr />

                    <div class="table-responsive" style="padding-top: 20px;">
                        <table class="table table-sm table-striped">
                            <tr class="info">

                                <th class="text-center">Orden</th>
                                <th class="text-center"># de Guia</th>
                                <th class="text-center">Transportadora</th>
                                <th class="text-center">Medida tomada</th>
                                <th class="text-center">Cliente</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Novedad</th>
                                <th class="text-center">Solución</th>
                                <th class="text-center">Tracking</th>

                            </tr>
                            <?php
                            $sql   = "SELECT * FROM  novedades";
                            //echo $sql;
                            $query = mysqli_query($conexion, $sql);
                            while ($row = mysqli_fetch_array($query)) {
                                $id_novedad     = $row['id_novedad'];
                                $numero_guia       = $row['guia_novedad'];
                                $cliente       = $row['cliente_novedad'];
                                $estado       = $row['estado_novedad'];
                                $novedad  = $row['novedad'];
                                $solucion  = $row['solucion_novedad'];
                                $tracking  = $row['tracking'];

                            ?>


                                <tr>
                                    <td class="text-center"><span class="badge badge-purple"><?php echo $id_novedad; ?></span></td>

                                    <td class="text-center"><?php echo $numero_guia; ?></td>


                                    <?php if (strpos($numero_guia, "MKP")  === 0) { ?>
                                        <td class="bg-warning text-center text-white">LAAR</td>
                                    <?php } else if (strpos($numero_guia, "FAST") === 0) { ?>
                                        <td class="bg-danger text-center text-white">SPEED</td>
                                    <?php } else if (is_numeric($numero_guia)) { ?>
                                        <td class="bg-success text-center text-white">SERVIENTREGA</td>
                                    <?php } ?>


                                    <td class="text-center"><?php if ($solucion === NULL || empty($solucion)) {
                                                                echo "---";
                                                            } else {
                                                                echo $solucion;
                                                            } ?></td>

                                    <td class="text-center"><?php echo $cliente ?></td>

                                    <td class="text-center"><?php echo $estado; ?></td>

                                    <td class="text-center">
                                        <?php if (strpos($numero_guia, "MKP") === 0) {
                                            echo "<button type='button' class='btn btn-sm btn-primary *:not(.disabled)' data-toggle='modal' data-target='#detalleNovedad' data-id='$id_novedad' data-guia='$numero_guia'>Ver detalle</button>";
                                        } else {
                                            echo $novedad;
                                        } ?>

                                    </td>

                                    <td class="text-center">
                                        <?php
                                        if (strpos($numero_guia, "MKP")  === 0) {
                                            $btncolor = "btn-warning";
                                            $transporte = "LAAR";
                                        } else if (strpos($numero_guia, "FAST") === 0) {
                                            $btncolor = "btn-danger";
                                            $transporte = "SPEED";
                                        } else if (is_numeric($numero_guia)) {
                                            $btncolor = "btn-success";
                                            $transporte = "SERVIENTREGA";
                                        }
                                        ?>

                                        <button type="button" class="btn btn-sm <?php echo $btncolor; ?>" data-toggle="modal" data-target="#novedad" data-id="<?php echo htmlspecialchars($id_novedad); ?>" data-guia="<?php echo htmlspecialchars($numero_guia); ?>" data-cliente="<?php echo htmlspecialchars($cliente); ?>" data-estado="<?php echo htmlspecialchars($estado); ?>" data-novedad="<?php echo htmlspecialchars($novedad); ?>" data-solucion="<?php echo htmlspecialchars($solucion); ?>" data-tracking="<?php echo htmlspecialchars($tracking); ?>" data-transporte="<?php echo htmlspecialchars($transporte); ?>">
                                            <i class='bx bxs-shield-plus'> </i> Solución
                                        </button>

                                    </td>

                                    <td class="text-center">
                                        <a target="_blank" href="<?php echo $tracking; ?>" class="btn btn-sm  btn-warning">Ver tracking</a>
                                    </td>

                                </tr>
                            <?php
                            }
                            ?>
                        </table>
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
    <!-- Todo el codigo js aqui -->
    <!-- ============================================================== -->
    <script type="text/javascript" src="../../js/caracteristicas_entrega.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".UpperCase").on("keypress", function() {
                $input = $(this);
                setTimeout(function() {
                    $input.val($input.val().toUpperCase());
                }, 50);
            })
        })

        $(document).ready(function() {
            // Inicializa el datepicker de fecha de inicio
            $('#datepickerInicio input').datepicker({
                format: "dd/mm/yyyy",
                language: "es",
                autoclose: true,
                todayHighlight: true
            }).on('changeDate', function(selected) {
                var minDate = new Date(selected.date.valueOf());
                $('#datepickerFin input').datepicker('setStartDate', minDate);
            });

            // Inicializa el datepicker de fecha de fin
            $('#datepickerFin input').datepicker({
                format: "dd/mm/yyyy",
                language: "es",
                autoclose: true,
                todayHighlight: true
            });

            // Manejador para abrir el calendario al hacer clic en el ícono
            $('.input-group-text').click(function() {
                $(this).parent().prev('input').datepicker('show');
            });
        });
    </script>
    <script>
        $(document).on('click', '[data-toggle="modal"]', function(event) {
            event.stopImmediatePropagation(); // Detiene la propagación del evento
            var button = $(this); // Botón que activó el modal
            var modalId = button.data('target'); // El ID del modal a abrir

            var modalElement = $(modalId);
            var modalData = modalElement.data('bs.modal');

            // Verifica si el modal está en transición
            if (!modalData || !modalData._isTransitioning) {
                modalElement.modal('show');
            } else {
                // Si el modal está en transición, espera un poco y luego intenta abrirlo
                setTimeout(function() {
                    if (!modalData._isTransitioning) {
                        modalElement.modal('show');
                    }
                }, 300); // Ajusta este tiempo si es necesario
            }
        });

        $('#detalleNovedad').on("show.bs.modal", function(event) {
            var button = $(event.relatedTarget); // Botón que activó el modal
            var id = button.data('id');
            var guia = button.data('guia');

            $.ajax({
                type: 'POST',
                url: '../ajax/detalle_novedad.php', // Cambia esto por la URL de tu endpoint
                data: {
                    id: id,
                    guia: guia
                },
                success: function(response) {
                    // Aquí puedes manejar la respuesta del servidor
                    $('#boody_detail').html(response);
                },
                error: function() {
                    alert('Error al cargar los datos');
                }
            });
        })

        $('#novedad').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Botón que activó el modal
            var id = button.data('id');
            var guia = button.data('guia');
            var cliente = button.data('cliente');
            var estado = button.data('estado');
            var novedad = button.data('novedad');
            var solucion = button.data('solucion');
            var tracking = button.data('tracking');
            var transporte = button.data('transporte');

            var camposAdicionales = "";
            if (tracking.includes("laar")) {
                camposAdicionales = '<div><input type="text" class="form-control" name="ciudad" /> </div> ' +
                    '<div><input type="text" class="form-control" name="direccion" /> </div> ' +
                    '<div><input type="text" class="form-control" name="telefono" /> </div> ' +
                    '<div><input type="text" class="form-control" name="celular" /> </div> ' +
                    '<div><input type="text" class="form-control" name="c_principal" /> </div> ' +
                    '<div><input type="text" class="form-control" name="c_secundaria" /> </div> ' +
                    '<div><input type="text" class="form-control" name="numeracion" /> </div> ' +
                    '<div><input type="text" class="form-control" name="referencia" /> </div> ' +
                    '<div><input type="text" class="form-control" name="observacion" /> </div> ' +
                    '<div><input type="text" class="form-control" name="novedad" placeholder="Solución a la novedad" /> </div>';

            } else if (tracking.includes("servientrega")) {
                camposAdicionales = '<div><input type="text" class="form-control" name="observacion" placeholder="Ingrese nueva novedad"></div>'
            }

            var modal = $(this);
            modal.find('.modal-title').text('Novedad para la guía ' + guia);
            modal.find('#modalContent').html(
                '<div class="d-flex flex-row justify-content-between">' +
                '<div>' +
                '<strong>ID:</strong> ' + id +
                '<br><strong>Cliente:</strong> ' + cliente +
                '<br><strong>Estado:</strong> ' + estado +
                '<br><strong>Transportadora:</strong> ' + button.data('transporte') +
                '<br><strong>Novedad:</strong> ' + novedad +
                '<br><strong>Solución:</strong> ' + solucion +
                '<br><strong>Tracking:</strong> <a href="' + tracking + '" target="_blank">Ver tracking</a>' +
                '</div>' +
                ' <div style="border-left:1px solid #000;height:200px"></div> ' +
                '<div class="formulario">' +
                '<form id="updateNovedadForm">' +
                '<input type="hidden" name="guia" value="' + guia + '">' +
                '<input type="hidden" name="transporte" value="' + button.data('transporte') + '">' +
                '<strong>Actualizar Novedad:</strong>' +
                camposAdicionales +
                '<div><button type="submit" class="btn w-100 btn-primary mt-2">Enviar</button></div>' +
                '</form>' +
                '</div>' +
                '</div>'
            );
            if (tracking.includes("fenix")) {
                let formData = new FormData();
                formData.append('guia', guia);

                $.ajax({
                    type: 'POST',
                    url: '../ajax/consultar_guia_laar.php', // Cambia esto por la URL de tu endpoint
                    data: formData,
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false, // To send DOMDocument or non processed data file it is set to false
                    success: function(response) {
                        // Aquí puedes manejar la respuesta del servidor
                        let data = JSON.parse(response);
                        data = data.destino
                        modal.find('#modalContent').html(
                            '<div class="d-flex flex-row justify-content-between">' +
                            '<div>' +
                            '<strong>ID:</strong> ' + id +
                            '<br><strong>Cliente:</strong> ' + cliente +
                            '<br><strong>Estado:</strong> ' + estado +
                            '<br><strong>Transportadora:</strong> ' + button.data('transporte') +
                            '<br><strong>Novedad:</strong> ' + novedad +
                            '<br><strong>Solución:</strong> ' + solucion +
                            '<br><strong>Tracking:</strong> <a href="' + tracking + '" target="_blank">Ver tracking</a>' +
                            '</div>' +
                            ' <div style="border-left:1px solid #000;height:200px"></div> ' +
                            '<div class="formulario d-flex flex-column">' +
                            '<form id="updateNovedadForm">' +
                            '<input type="hidden" name="guia" value="' + guia + '">' +
                            '<input type="hidden" name="transporte" value="' + button.data('transporte') + '">' +
                            '<strong>Actualizar Novedad:</strong>' +
                            '<div><label for="inputPassword3" class="col-sm-2 text-nowrap col-form-label">Nombre</label></div> ' +
                            '<div><input type="text" class="form-control" name="nombre" value="' + data.nombre + '" /> </div> ' +
                            '<div><label for="inputPassword3" class="col-sm-2 text-nowrap col-form-label">Ciudad</label></div> ' +
                            '<div><input type="text" class="form-control" name="ciudad" value="' + data.ciudad + '" /> </div> ' +
                            '<div><label for="inputPassword3" class="col-sm-2 text-nowrap col-form-label">Calle Principal</label></div>' +
                            '<div><input type="text" class="form-control" name="direccion" value="' + data.c_principal + '" /> </div> ' +
                            '<div><label for="inputPassword3" class="col-sm-2 text-nowrap col-form-label">Calle Secundaria</label></div>' +
                            '<div><input type="text" class="form-control" name="direccion1" value="' + data.c_secundaria + '" /> </div> ' +
                            '<div><label for="inputPassword3" class="col-sm-2 text-nowrap col-form-label">Teléfono</label></div>' +
                            '<div><input type="text" class="form-control" name="telefono" value="' + data.telefono + '" /> </div> ' +
                            '<div><label for="inputPassword3" class="col-sm-2 text-nowrap col-form-label">Celular</label></div>' +
                            '<div><input type="text" class="form-control" name="celular" value="' + data.telefono + '" /> </div> ' +
                            '<div><label for="inputPassword3" class="col-sm-2 text-nowrap col-form-label">Numeración</label></div>' +
                            '<div><input type="text" class="form-control" name="numeracion" value="' + data.numeracion + '" /> </div> ' +
                            '<div><label for="inputPassword3" class="col-sm-2 text-nowrap col-form-label">Referencia</label></div>' +
                            '<div><input type="text" class="form-control" name="referencia" value="' + data.referencia + '" /> </div> ' +
                            '<div><label for="inputPassword3" class="col-sm-2 text-nowrap col-form-label">Observación</label></div>' +
                            '<div><input type="text" class="form-control" name="observacion" value="' + data.observacion + '" /> </div> ' +
                            '<hr />' +
                            '<strong>Actualizar Novedad:</strong>' +
                            '<div><input type="text" class="form-control" name="novedad" placeholder="Solución a la novedad" /> </div>' +
                            '<div><button type="submit" class="btn w-100 btn-primary mt-2">Enviar</button></div>' +
                            '</form>' +
                            '</div>' +
                            '</div>'
                        );

                    },
                });
            }
        });





        $(document).ready(function() {
            // Manejar el envío del formulario
            $(document).on('submit', '#updateNovedadForm', function(e) {
                e.preventDefault(); // Previene el comportamiento por defecto del formulario
                var formData = $(this).serialize(); // Serializa los datos del formulario

                $.ajax({
                    type: 'POST',
                    url: '../ajax/gestion_novedades.php', // Cambia esto por la URL de tu endpoint
                    data: formData,
                    success: function(response) {
                        // Aquí puedes manejar la respuesta del servidor
                        alert('Datos enviados correctamente');
                        $('#novedad').modal('hide'); // Cierra el modal
                    },
                    error: function() {
                        alert('Error al enviar los datos');
                    }
                });
            });
        });
    </script>


    <?php require 'includes/footer_end.php'
    ?>