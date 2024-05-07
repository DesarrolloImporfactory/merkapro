<?php

session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
    header("location: ../../login.php");
    exit;
}
$marketplace_url = $_SERVER['HTTP_HOST'];
$marketplace_url = str_replace(["www.", ".com"], "", $marketplace_url);

// Compara en minúsculas para evitar problemas de sensibilidad a mayúsculas y minúsculas
if (strtolower($marketplace_url) !== "marketplace.imporsuit" && strtolower($marketplace_url) !== 'localhost') {
    header("location: ../../login.php");
    exit;
}

/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
//Archivo de funciones PHP
require_once "../funciones.php";
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Wallets";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
$title          = "Wallet";
$wallets         = 1;
$nombre_usuario = get_row('users', 'usuario_users', 'id_users', $user_id);
$id_factura     = $_GET['id_factura'];
$total_pendiente_sql = "select valor_pendiente from cabecera_cuenta_pagar where numero_factura = '$id_factura'";
$total_pendiente_query = mysqli_query($conexion, $total_pendiente_sql);
$total_pendiente = mysqli_fetch_array($total_pendiente_query);

$total_pendiente = $total_pendiente['valor_pendiente'];

if (isset($_GET['id_factura'])) {

    $id_factura     = $_GET['id_factura'];
    $query          = mysqli_query($conexion, "SELECT * FROM cabecera_cuenta_pagar WHERE numero_factura='" . $id_factura . "'");
    $count         = mysqli_num_rows($query);
    echo mysqli_error($conexion);
    if ($count) {
        $rw_factura = mysqli_fetch_array($query);
        $cliente = $rw_factura['cliente'];
        $tienda = $rw_factura['tienda'];
        $estado_factura = $rw_factura['estado_pedido'];
        $total_ventass = $rw_factura['total_venta'];

        $costo = $rw_factura['costo'];
        $precio_envio = $rw_factura['precio_envio'];
        $monto_recibir = $rw_factura['monto_recibir'];
        $fecha = $rw_factura['fecha'];



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
    } else {
        exit;
    }
} else {
    exit;
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

<div id="wrapper" class="forced enlarged">

    <?php require 'includes/menu.php';   // echo $guia_enviada;
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
                    <?php if ($total_pendiente != 0) { ?>
                        <div class="col-lg-12">
                            <div class="portlet">
                                <div class="portlet-heading bg-primary">
                                    <h3 class="portlet-title">
                                        Editar Wallet
                                    </h3>
                                    <div class="portlet-widgets">
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div id="bg-primary" class="panel-collapse collapse show">
                                    <div class="portlet-body">
                                        <div class="row">

                                            <div class="col">

                                                <table class="table table-sm table-striped table-responsive">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">ORDEN</th>
                                                            <th class="text-center">FECHA</th>
                                                            <th class="text-center">CLIENTE</th>
                                                            <th class="text-center">TIENDA</th>
                                                            <th class="text-center">ESTADO</th>
                                                            <th class="text-center">TOTAL</th>
                                                            <th class="text-center">COSTO</th>
                                                            <th class="text-center">ENVIO</th>
                                                            <th class="text-center">MONTO RECIBIR</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-center"><label class="badge badge-purple"> <?php echo $id_factura; ?></label></td>
                                                            <td class="text-center"><?php echo $fecha; ?></td>
                                                            <td class="text-center"><?php echo $cliente; ?></td>
                                                            <td class="text-center"><?php echo $tienda; ?></td>

                                                            <td class="text-center"><span class="badge <?php echo $label_class; ?>"><?php echo $text_estado; ?></span></td>
                                                            <td class="text-center"><?php echo $simbolo_moneda . $total_ventass; ?></td>
                                                            <td class="text-center"><?php echo $simbolo_moneda . $costo; ?></td>
                                                            <td class="text-center"><?php echo $simbolo_moneda . $precio_envio; ?></td>
                                                            <td class="text-center"><?php echo $simbolo_moneda . $monto_recibir; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col">
                                                <form method="post" onsubmit="cambiar_precio(event)">
                                                    <div class="form-group">
                                                        <div class="mb-3">
                                                            <label for="total_ventas">
                                                                Total de Ventas
                                                            </label>
                                                            <input type="text" name="total_ventas" id="total_ventas" class="form-control" value="<?php echo $total_ventass; ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="costoa">
                                                                Costo
                                                            </label>
                                                            <input type="text" name="costoa" id="costoa" class="form-control" value="<?php echo $costo; ?>">
                                                        </div>
                                                        <div class="mb-3">

                                                            <label for="precio">
                                                                Precio de Envio
                                                            </label>
                                                            <input type="text" name="precio" id="precio" class="form-control" value="<?php echo $precio_envio; ?>">
                                                            <input class="btn btn-outline-success w-100 pt-3" type="submit" value="Cambiar precio">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>


                                    </div>
                                    <!-- end row -->

                                </div>

                            </div>
                        </div>
                    <?php
                    } else {

                    ?>

                        <section class="content">
                            <div class="alert alert-danger" align="center">
                                <h3>Acceso denegado! </h3>
                                <p>Esta factura ya ha sido cancelada, no puede ser editada.</p>
                            </div>
                        </section>
                <?php
                    }
                }
                ?>
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
<script type="text/javascript" src="../../js/VentanaCentrada.js"></script>
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
    function cambiar_precio(e) {
        e.preventDefault();
        var precio = $("#precio").val();
        var total_ventas = $("#total_ventas").val();
        var costo = $("#costoa").val();
        var id_factura = '<?php echo $id_factura; ?>';
        $.ajax({
            url: '../ajax/cambiar_precio.php',
            type: 'post',
            data: {
                venta: total_ventas,
                precio: precio,
                costo: costo,
                id_factura: id_factura
            },
            dataType: 'text',
            success: function(response) {
                if (response == 'si') {
                    $.Notification.notify('custom', 'bottom right', 'EXITO!', 'Precio cambiado correctamente')
                    // actualizar_tabla();

                    setTimeout(function() {
                        location.reload();
                    }, 500);
                } else {
                    $.Notification.notify('custom', 'bottom right', 'ERROR!', 'Error al cambiar el precio')
                }
            }
        })

    }
</script>

<?php require 'includes/footer_end.php'
?>