<?php

session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
    header("location: ../../login.php");
    exit;
}
require_once "../db.php";
require_once "../php_conexion.php";
require_once "../funciones.php";
include "../permisos.php";
$user_id = $_SESSION['id_users'];
$session_id = session_id();
$pais = get_row('perfil', 'pais', 'id_perfil', 1);
$tienda = $_GET['id'];
if ($tienda == "local") {
    $parametro = "tienda IS NULL OR tienda = '' OR tienda = 'enviado'";
} else {
    $parametro = "tienda = '$tienda'";
}
$producto_importar = 0;
$precio_importar = 0;
if (isset($_GET['id_producto'])) {
    $producto_importar = $_GET['id_producto'];
    $precio_importar = $_GET['precio_importacion'];
    //echo $precio_importar;
}
get_cadena($user_id);
$modulo = "Pedidos";
permisos($modulo, $cadena_permisos);
$title = "Ventas";
$nombre_usuario = get_row('users', 'usuario_users', 'id_users', $user_id);
$destino_marketplace = mysqli_connect("localhost", "imporsuit_marketplace", "imporsuit_marketplace", "imporsuit_marketplace");

?>

<?php require 'includes/header_start.php'; ?>

<?php require 'includes/header_end.php'; ?>

<style>
    .image-bn {
        filter: grayscale(100%);
        transition: filter 0.3s ease;
    }

    .image-bn:hover {
        filter: grayscale(0%);
    }

    .div_seleccion:hover {
        filter: grayscale(0%);
    }

    .formulario {
        border-radius: 25px;

    }

    .formulario_1 {
        border-radius: 25px 25px 0px 25px;
    }
</style>

<div id="wrapper" class="forced enlarged">
    <?php require 'includes/menu.php'; ?>
    <div class="content-page">
        <div class="content">
            <div class="container">
                <?php if ($permisos_ver == 1) {
                ?>
                    <div class="col-lg-12">
                        <div class="portlet">
                            <div class="portlet-heading" style="background-color: #171931;">
                                <h3 class="portlet-title">
                                    Nueva Cotización
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
                                    include "../modal/buscar_productos_ventas.php";
                                    include "../modal/registro_cliente.php";
                                    include "../modal/registro_producto.php";
                                    ?>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="card-box">
                                                <div class="widget-chart">
                                                    <div id="resultados_ajaxf" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->
                                                    <form class="form-horizontal" role="form" id="barcode_form">
                                                        <div class="form-group align-items-md-baseline row">
                                                            <label for="barcode_qty" class="col-md-1 control-label">Cant:</label>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control formulario" id="barcode_qty" value="1" autocomplete="off">
                                                                <input type="hidden" id="parametro" name="parametro" value="<?php echo $parametro; ?>">
                                                                <input type="hidden" id="id_producto_importar" name="id_producto_importar" value="<?php echo $producto_importar; ?>">
                                                                <input type="hidden" id="precio_importar" name="precio_importar" value="<?php echo $precio_importar; ?>">
                                                            </div>
                                                            <label for="condiciones" class="control-label">Codigo:</label>
                                                            <div class="col-md-5" align="left">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control formulario_1" id="barcode" autocomplete="off" tabindex="1" autofocus="true">
                                                                    <span class="input-group-btn">
                                                                        <button type="submit" class="btn btn-default"><span class="fa fa-barcode"></span></button>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button type="button" accesskey="a" class="btn btn-primary waves-effect waves-light formulario" data-toggle="modal" data-target="#buscar">
                                                                    <span class="fa fa-search"></span> Buscar
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <div class="table-responsive">
                                                        <div id="resultados" class='col-md-12' style="margin-top:10px"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="card-box">
                                                <!-- 
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h4>¿Existe el cliente? </h4>
                                                        <div class="form-group">
                                                            <label for="nombre_cliente" class="control-label">Cedula:</label>
                                                            <input type="text" class="form-control formulario" id="nombre_cliente" name="nombre_cliente" placeholder="Cedula del cliente" required>
                                                            <input type="hidden" id="id_cliente" name="id_cliente">
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr> -->

                                                <div class="widget-chart">
                                                    <H5><strong>DATOS DESTINATARIO</strong></H5>
                                                    <form method="post" action="../../../ingresar_pedido_1.php" id="formulario">
                                                        <input type="hidden" id="transp" name="transp">
                                                        <input type="hidden" id="transportadora" name="transportadora">
                                                        <input type="hidden" name="destino_c" id="destino_c">
                                                        <input type="hidden" name="nombre_remitente" id=nombre_remitente>
                                                        <input type="hidden" name="apellido_remitente" id=apellido_remitente>
                                                        <input type="hidden" name="direccion_remitente" id=direccion_remitente>
                                                        <input type="hidden" name="telefono_remitente" id=telefono_remitente>
                                                        <input type="hidden" name="servi_flete" id="servi_flete">
                                                        <input type="hidden" name="servi_seguro" id="servi_seguro">
                                                        <input type="hidden" name="servi_comision" id="servi_comision">
                                                        <input type="hidden" name="servi_impuesto" id="servi_impuesto">
                                                        <input type="hidden" name="servi_otros" id="servi_otros">
                                                        <input type="hidden" name="origen_texto" id="origen_texto">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <span class="help-block">Nombre Destinatario </span>
                                                                <input type="text" class="datos form-control formulario" id="nombred" name="nombre" placeholder="Nombre y Apellido *" required>
                                                                <input type="hidden" class="form-control" id="session" name="session" value="<?php echo $session_id; ?>">
                                                                <input type="hidden" class="form-control" id="cliente" name="cliente" value="1">
                                                            </div>
                                                            <!-- <div class="col-md-4">
                                                                <span class="help-block">Cedula </span>
                                                                <input type="text" class="datos form-control formulario" id="cedula" name="cedula" placeholder="cedula">
                                                            </div> -->
                                                            <div class="col-md-4">
                                                                <span class="help-block">Teléfono </span>
                                                                <input id="telefonod" name="telefono" class="form-control formulario" placeholder="telefono" value="">

                                                            </div>
                                                            <div class="col-md-4">
                                                                <span class="help-block">Provincia </span>
                                                                <select class="datos form-control formulario" onchange="cargar_provincia_pedido()" id="provinica" name="provinica" required disabled>
                                                                    <option value="">Provincia *</option>
                                                                    <?php
                                                                    $sql2 = "select * from provincia_laar where id_pais = $pais";

                                                                    $query2 = mysqli_query($conexion, $sql2);
                                                                    while ($row2 = mysqli_fetch_array($query2)) {

                                                                        $id_prov = $row2['id_prov'];

                                                                        $provincia = $row2['provincia'];
                                                                        $cod_provincia = $row2['codigo_provincia'];

                                                                        // Imprimir la opción con la marca de "selected" si es el valor almacenado
                                                                        echo '<option value="' . $cod_provincia . '">' . $provincia . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row">


                                                            <div class="col-md-4">
                                                                <span class="help-block">Ciudad </span>
                                                                <div id="div_ciudad" onclick="verify()">
                                                                    <select class="datos form-control formulario" id="ciudad_entrega" name="ciudad_entrega" onchange="seleccionarProvincia()" required disabled>
                                                                        <option value="">Ciudad *</option>
                                                                        <?php
                                                                        $sql2 = "select * from ciudad_cotizacion where id_pais='$pais' ";
                                                                        $query2 = mysqli_query($conexion, $sql2);
                                                                        $rowcount = mysqli_num_rows($query2);
                                                                        $i = 1;
                                                                        while ($row2 = mysqli_fetch_array($query2)) {
                                                                            $id_ciudad = $row2['id_cotizacion'];
                                                                            $nombre = $row2['ciudad'];
                                                                            $cod_ciudad = $row2['codigo_ciudad_laar'];
                                                                            $valor_seleccionado = $ciudaddestino;
                                                                            $selected = ($valor_seleccionado == $cod_ciudad) ? 'selected' : '';
                                                                            echo '<option value="' . $cod_ciudad . '>' . $nombre . '</option>';
                                                                        ?>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <!-- <div class="col-md-4">
                                                                <span class="help-block">Sector </span>
                                                                <input type="text" class="datos form-control rounded formulario" id="sector" name="sector" placeholder="Sector">
                                                            </div> -->
                                                            <div class="col-md-4">
                                                                <span class="help-block">Calle principal </span>
                                                                <input type="text" class="datos form-control formulario" id="calle_principal" name="calle_principal" placeholder="Calle Principal *" required>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <span class="help-block">Calle secundaria </span>
                                                                <input type="text" class="datos form-control formulario" id="calle_secundaria" name="calle_secundaria" placeholder="Calle Secundaria *" required>
                                                            </div>
                                                        </div>
                                                        <div class="row">

                                                            <div class="col-md-4">
                                                                <span class="help-block">Numero de casa </span>
                                                                <input id="numerocasa" name="numerocasa" class="form-control formulario" value="">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <span class="help-block">Referencia </span>
                                                                <input type="text" class="datos form-control formulario" id="referencia" name="referencia" placeholder="Referencia *" required>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <span class="help-block">Observaciones para la entrega </span>
                                                                <input type="text" class="datos form-control formulario" id="observacion" name="observacion" placeholder="Referencias Adicionales (Opcional)">
                                                            </div>
                                                            <input type="hidden" id="costo_envio" name="costo_envio">
                                                        </div>
                                                        <div class="row">

                                                        </div>
                                                        <div style="background-color: #F6F6F6" class="card-box mt-3">
                                                            <div class="widget-chart">
                                                                <div class="text-center mb-4">
                                                                    <span class="fs-4 font-bold">
                                                                        Generar Guías
                                                                    </span>
                                                                </div>
                                                                <div class="d-flex justify-content-center flex-wrap">
                                                                    <!-- Envoltura de fila para manejo responsive de columnas -->
                                                                    <div class="row justify-content-center items-center">
                                                                        <!-- Primera Columna -->
                                                                        <div class="col-6 col-md-2">
                                                                            <div id="card3" onclick="seleccionar_transportadora(3)" class="card formulario p-1">
                                                                                <img style="width: 100%;" id="tr3" src="../../img_sistema/servi.png" class="card-img-top formulario image-bn interactive-image" alt="Selecciona Laarcourrier">
                                                                                <div class="card-body" style="text-align: center;">
                                                                                    <strong id="precio_servientrega">---</strong>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Segunda Columna -->
                                                                        <div class="col-6 col-md-2">
                                                                            <div id="card1" onclick="seleccionar_transportadora(1)" class="card formulario p-1 div_imagen">
                                                                                <img style="width: 100%;" id="tr1" src="../../img_sistema/laar.png" class="card-img-top image-bn interactive-image laar_img formulario" alt="Selecciona Servientrega">
                                                                                <div class="card-body" style="text-align: center;">
                                                                                    <strong id="precio_laar">---</strong>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Tercera Columna -->
                                                                        <div class="col-6 col-md-2">
                                                                            <div id="card2" onclick="seleccionar_transportadora(2)" class="card formulario p-1">
                                                                                <img style="width: 100%;" id="tr2" src="../../img_sistema/speed.png" class="card-img-top image-bn interactive-image formulario" alt="Selecciona Guia Local">
                                                                                <div class="card-body" style="text-align: center;">
                                                                                    <strong id="aplica">NO APLICA</strong>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Cuarta Columna -->
                                                                        <div class="col-6 col-md-2">
                                                                            <div id="card4" class="card formulario p-1">
                                                                                <!-- Ajuste de ancho al 100% para consistencia -->
                                                                                <img style="width: 100%;" id="tr4" onclick="seleccionar_transportadora(4)" src="../../img_sistema/gintra.png" class="card-img-top image-bn interactive-image formulario" alt="Selecciona Guia Local">
                                                                                <div class="card-body" style="text-align: center;">
                                                                                    <strong id="precio_gintra">PROXIMAMENTE</strong>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="row justify-content-center items-center mt-3 text-center">
                                                                <div class="col-md-3">
                                                                    <span class="help-block">Recaudo </span>
                                                                    <select onchange="seleccionarProvincia()" id="cod" name="cod" class="form-control">
                                                                        <option value="0">Seleccionar</option>
                                                                        <option value="1" selected>Con Recuado</option>
                                                                        <option value="2">Sin Recaudo </option>
                                                                    </select>
                                                                    <input type="hidden" id="id_pedido_cot_" name="id_pedido_cot">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="asegurar_producto">
                                                                            <input class="formulario" style="width: 20px; height: 20px; margin-top: 25px" type="checkbox" id="asegurar_producto" name="asegurar_producto" value="1">
                                                                            Deseo asegurar la mercadería
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <span class="help-block">Valor a asegurar </span>
                                                                    <input id="valorasegurado" name="valorasegurado" class="form-control" value="" placeholder="Valor a aegurar">
                                                                </div>
                                                            </div>
                                                            <div class="row justify-content-center items-center mt-3 text-center ">
                                                                <?php
                                                                $pais = get_row('perfil', 'pais', 'id_perfil', 1);
                                                                if ($pais == 1) {
                                                                ?>
                                                                    <div class="col-12 col-sm-6 col-md-3 mb-3">

                                                                        <button type="submit" style="width:100%; height: 40px;" role="button" class="btn w-100  btn-success "><span class="texto_boton">Guardar Pedido</span></button>
                                                                    </div>
                                                                    <div class="col-12 col-sm-6 col-md-3 mb-3">
                                                                        <button style="cursor: pointer;" id="generar_guia_btn" type="button" onclick="generar_guia()" class="btn  w-100 btn-danger" disabled>Generar Guía</button>
                                                                    </div>
                                                                    <div class="col-12 col-sm-6 col-md-3 mb-3">
                                                                        <button style="cursor: pointer;" type="button" onclick="calcular_guia()" class="btn w-100  btn-primary">Facturar</button>
                                                                    </div>
                                                            </div>
                                                        <?php
                                                                }
                                                        ?>
                                                        <div class="col-md-6">
                                                            </br>
                                                        </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
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
    </div>

    <?php require 'includes/pie.php'; ?>
</div>

</div>


<?php require 'includes/footer_start.php'
?>

<script type="text/javascript" src="../../js/VentanaCentrada.js"></script>
<script type="text/javascript" src="../../js/cotizacion_nueva_1.js"></script>

<script>
    $(document).ready(function() {
        $("#provinica").select2({
            placeholder: "Selecciona una opción",
            allowClear: true,
        });
    });

    $(document).ready(function() {
        $("#ciudad_entrega").select2({
            placeholder: "Selecciona una opción",
            allowClear: true,
        });
    });



    $(function() {
        $("#nombre_cliente").autocomplete({
            source: "../ajax/autocomplete/clientes.php",
            minLength: 2,
            select: function(event, ui) {
                event.preventDefault();
                $('#id_cliente').val(ui.item.id_cliente);
                $('#nombre_cliente').val(ui.item.nombre_cliente);
                $('#tel1').val(ui.item.fiscal_cliente);
                $('#em').val(ui.item.email_cliente);
                $.Notification.notify('success', 'bottom right', 'EXITO!', 'CLIENTE AGREGADO CORRECTAMENTE')
            }
        });
    });

    $("#nombre_cliente").on("keydown", function(event) {
        if (event.keyCode == $.ui.keyCode.LEFT || event.keyCode == $.ui.keyCode.RIGHT || event.keyCode == $.ui.keyCode.UP || event.keyCode == $.ui.keyCode.DOWN || event.keyCode == $.ui.keyCode.DELETE || event.keyCode == $.ui.keyCode.BACKSPACE) {
            $("#id_cliente").val("");
            $("#tel1").val("");
            $("#em").val("");
        }
        if (event.keyCode == $.ui.keyCode.DELETE) {
            $("#nombre_cliente").val("");
            $("#id_cliente").val("");
            $("#tel1").val("");
            $("#em").val("");
        }
    });
</script>
<!-- FIN -->
<script>
    var sleepSetTimeout_ctrl;

    function verify() {
        if ($("#ciudad_entrega").prop("disabled")) {
            $.Notification.notify('error', 'bottom right', 'ERROR!', 'Debes añadir un producto primero');
        }
    }

    function sleep(ms) {
        clearInterval(sleepSetTimeout_ctrl);
        return new Promise(resolve => sleepSetTimeout_ctrl = setTimeout(resolve, ms));
    }

    function generar_guia() {
        $("#generar_guia_btn").prop("disabled", true);

        let transportadora = $("#transp").val();
        if (transportadora == "") {
            $.Notification.notify('error', 'bottom right', 'ERROR!', 'Debes seleccionar una transportadora')
        }
        if (transportadora === "1") {
            var formulario = document.getElementById('formulario');
            if (document.querySelector("#valorasegurado").value === "") {
                document.querySelector("#valorasegurado").value = 0;
            }

            var data = new FormData(formulario);
            data.append("nombre_destino", document.getElementById('nombred').value);
            data.append("celular", document.getElementById('telefonod').value);
            data.append("direccion", document.getElementById('calle_principal').value + ' ' + document.getElementById('calle_secundaria').value);
            data.append("valor_total", document.getElementById('valor_total_').value)
            data.append("cantidad_total", document.getElementById('cantidad_total').value);
            data.append("costo_total", document.getElementById('costo_total').value);
            data.append("ciudad", document.getElementById('ciudad_entrega').value);
            data.append("productos_guia", document.getElementById('productos_guia').value);
            data.append("identificacion", "0");
            data.append("seguro", document.getElementById('asegurar_producto').value);

            $.ajax({
                url: "../../../ingresar_pedido_1.php",
                type: "POST",
                data: data,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    let [guia, precio] = response.split(',');
                    $('#guia').val(guia);
                    $('#precio').val(precio);
                    $('#modal_vuelto').modal('show');
                    $.ajax({
                        url: '../ajax/calcular_guia.php',
                        type: 'post',
                        data: data,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            $('#resultados').html(response);
                            $.ajax({
                                url: "../ajax/ultimo_pedido.php",
                                type: "POST",
                                data: data,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    $('#id_pedido_cot_').val(response);
                                    data.set('id_pedido_cot', response);
                                    Swal.fire({
                                        icon: "info",
                                        title: "Por favor espere",
                                        text: "Estamos generando la guía",
                                        showConfirmButton: false,
                                        didOpen: () => {
                                            Swal.showLoading();
                                        }
                                    })
                                    $.ajax({
                                        url: "../ajax/enviar_laar.php",
                                        type: "POST",
                                        data: data,
                                        contentType: false,
                                        processData: false,
                                        success: function(response) {
                                            Swal.fire({
                                                icon: "success",
                                                title: "Guía generada",
                                                text: "La guía ha sido generada exitosamente",

                                            }).then(() => {
                                                window.location.href = `./editar_cotizacion_3.php?id_factura=` + $('#id_pedido_cot_').val();
                                            });
                                        }
                                    });
                                }
                            });
                        }
                    });
                }
            });



        }
        if (transportadora === "2") {

            //obtienne el formulario
            var formulario = document.getElementById('formulario');
            //crea un objeto FormData
            if (document.querySelector("#valorasegurado").value === "") {
                document.querySelector("#valorasegurado").value = 0;
            }

            var data = new FormData(formulario);
            data.append("nombre_destino", document.getElementById('nombred').value);
            data.append("celular", document.getElementById('telefonod').value);
            data.append("direccion", document.getElementById('calle_principal').value + ' ' + document.getElementById('calle_secundaria').value);
            data.append("valor_total", document.getElementById('valor_total_').value);
            data.append("cantidad_total", document.getElementById('cantidad_total').value);
            data.append("costo_total", document.getElementById('costo_total').value);
            data.append("ciudad", document.getElementById('ciudad_entrega').value);
            data.append("productos_guia", document.getElementById('productos_guia').value);
            data.append("identificacion", "0");
            data.append("seguro", document.getElementById('asegurar_producto').value);

            // generar el pedido
            $.ajax({
                url: "../../../ingresar_pedido_1.php",
                type: "POST",
                data: data,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    let [guia, precio] = response.split(',');
                    $('#guia').val(guia);
                    $('#precio').val(precio);
                    $('#modal_vuelto').modal('show');
                    $.ajax({
                        url: '../ajax/calcular_guia.php',
                        type: 'post',
                        data: data,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            //alert(response)

                            $('#resultados').html(response);
                            $.ajax({
                                url: "../ajax/ultimo_pedido.php",
                                type: "POST",
                                data: data,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    $('#id_pedido_cot_').val(response);
                                    data.set('id_pedido_cot', response);
                                    $.ajax({
                                        url: "../ajax/enviar_guia_local.php",
                                        type: "POST",
                                        data: data,
                                        contentType: false,
                                        processData: false,
                                        success: function(response) {
                                            console.log(response);
                                            let [guia, precio] = response.split(',');
                                            $('#guia').val(guia);
                                            $('#precio').val(precio);
                                            $('#modal_vuelto').modal('show');
                                            window.location.href = `./editar_cotizacion_3.php?id_factura=` + $('#id_pedido_cot_').val();
                                        }
                                    });
                                }
                            });
                        } // /success function

                    });
                }
            });




        }
        if (transportadora === "3") {
            //obtienne el formulario
            var formulario = document.getElementById('formulario');
            //crea un objeto FormData
            if (document.querySelector("#valorasegurado").value === "") {
                document.querySelector("#valorasegurado").value = 0;
            }
            var data = new FormData(formulario);
            data.append("nombre_destino", document.getElementById('nombred').value);
            data.append("celular", document.getElementById('telefonod').value);
            data.append("direccion", document.getElementById('calle_principal').value + ' ' + document.getElementById('calle_secundaria').value);
            data.append("valor_total", document.getElementById('valor_total_').value);
            data.append("cantidad_total", document.getElementById('cantidad_total').value);
            data.append("costo_total", document.getElementById('costo_total').value);
            data.append("ciudad", document.getElementById('ciudad_entrega').value);
            data.append("productos_guia", document.getElementById('productos_guia').value);
            data.append("identificacion", "0");
            data.append("seguro", document.getElementById('asegurar_producto').value);
            data.append("contenido", document.getElementById('producto_name').textContent) + "x" + document.getElementById('producto_qty').textContent;

            $.ajax({
                url: "../../../ingresar_pedido_1.php",
                type: "POST",
                data: data,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    let [guia, precio] = response.split(',');
                    $('#guia').val(guia);
                    $('#precio').val(precio);
                    $('#modal_vuelto').modal('show');
                    $.ajax({
                        url: '../ajax/calcular_guia.php',
                        type: 'post',
                        data: data,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            $('#resultados').html(response);
                            $.ajax({
                                url: "../ajax/ultimo_pedido.php",
                                type: "POST",
                                data: data,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    $('#id_pedido_cot_').val(response);
                                    data.set('id_pedido_cot', response);
                                    let ciudad_texto = $('#ciudad_entrega option:selected').text();
                                    let destino_texto = $('#destino_c').val();
                                    data.append('ciudad_texto', ciudad_texto);
                                    data.append('destino_texto', destino_texto);
                                    data.append('provincia', $('#provinica  option:selected').text());
                                    $.ajax({
                                        url: "../ajax/datos_servi.php",
                                        type: "POST",
                                        data: data,
                                        contentType: false,
                                        processData: false,
                                        success: function(response) {

                                            let datos_servi = JSON.parse(response);
                                            let codigo = datos_servi["codigo"];
                                            let codigo_origen = datos_servi["codigo_origen"];
                                            data.append('codigo', codigo);
                                            data.append('codigo_origen', codigo_origen);
                                            let esRecaudo = $('#cod').val();
                                            if (esRecaudo == 1) {
                                                $.ajax({
                                                    url: "../../../ajax/servientrega/generar_guia_servientrega_r.php",
                                                    type: "POST",
                                                    data: data,
                                                    contentType: false,
                                                    processData: false,
                                                    success: function(response) {
                                                        let data_se = JSON.parse(response);
                                                        let id_servi = data_se["id"];
                                                        data.append('id_servi', id_servi);
                                                        Swal.fire({
                                                            icon: "info",
                                                            title: "Por favor espere",
                                                            text: "Estamos generando la guía",
                                                            showConfirmButton: false,
                                                            didOpen: () => {
                                                                Swal.showLoading();
                                                            }
                                                        })
                                                        $.ajax({
                                                            url: "../ajax/enviar_servi.php",
                                                            type: "POST",
                                                            data: data,
                                                            contentType: false,
                                                            processData: false,
                                                            success: function(response) {
                                                                Swal.fire({
                                                                    icon: "success",
                                                                    title: "Guía generada",
                                                                    text: "La guía ha sido generada exitosamente",
                                                                    showConfirmButton: true,
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        window.location.href = `./editar_cotizacion_3.php?id_factura=` + $('#id_pedido_cot_').val();
                                                                    }
                                                                })
                                                            }
                                                        })
                                                    }
                                                })
                                            } else if (esRecaudo == 2) {

                                                $.ajax({
                                                    url: "../../../ajax/servientrega/generar_guia_servientrega.php",
                                                    type: "POST",
                                                    data: data,
                                                    contentType: false,
                                                    processData: false,
                                                    success: function(response) {
                                                        let data_se = JSON.parse(response);
                                                        let id_servi = data_se["id"];
                                                        data.append('id_servi', id_servi);
                                                        Swal.fire({
                                                            icon: "info",
                                                            title: "Por favor espere",
                                                            text: "Estamos generando la guía",
                                                            showConfirmButton: false,
                                                            didOpen: () => {
                                                                Swal.showLoading();
                                                            }
                                                        })
                                                        $.ajax({
                                                            url: "../ajax/enviar_servi.php",
                                                            type: "POST",
                                                            data: data,
                                                            contentType: false,
                                                            processData: false,
                                                            success: function(response) {
                                                                Swal.fire({
                                                                    icon: "success",
                                                                    title: "Guía generada",
                                                                    text: "La guía ha sido generada exitosamente",
                                                                    showConfirmButton: true,
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        window.location.href = `./editar_cotizacion_3.php?id_factura=` + $('#id_pedido_cot_').val();
                                                                    }
                                                                })
                                                            }
                                                        })
                                                    }
                                                })
                                            }
                                        }
                                    });
                                }
                            });
                        }

                    });
                }
            });

        }
        if (transportadora === "4") {
            //obtienne el formulario
            var formulario = document.getElementById('formulario');
            //crea un objeto FormData
            if (document.querySelector("#valorasegurado").value === "") {
                document.querySelector("#valorasegurado").value = 0;
            }
            var data = new FormData(formulario);
            data.append("nombre_destino", document.getElementById('nombred').value);
            data.append("celular", document.getElementById('telefonod').value);
            data.append("direccion", document.getElementById('calle_principal').value + ' ' + document.getElementById('calle_secundaria').value);
            data.append("valor_total", document.getElementById('valor_total_').value);
            data.append("cantidad_total", document.getElementById('cantidad_total').value);
            data.append("costo_total", document.getElementById('costo_total').value);
            data.append("ciudad", document.getElementById('ciudad_entrega').value);
            data.append("productos_guia", document.getElementById('productos_guia').value);
            data.append("identificacion", "0");
            data.append("seguro", document.getElementById('asegurar_producto').value);
            data.append("contenido", document.getElementById('producto_name').textContent) + "x" + document.getElementById('producto_qty').textContent;

            $.ajax({
                url: "../../../ingresar_pedido_1.php",
                type: "POST",
                data: data,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    let [guia, precio] = response.split(',');
                    $('#guia').val(guia);
                    $('#precio').val(precio);
                    $('#modal_vuelto').modal('show');
                    $.ajax({
                        url: '../ajax/calcular_guia.php',
                        type: 'post',
                        data: data,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            $('#resultados').html(response);
                            $.ajax({
                                url: "../ajax/ultimo_pedido.php",
                                type: "POST",
                                data: data,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    $('#id_pedido_cot_').val(response);
                                    data.set('id_pedido_cot', response);
                                    let ciudad_texto = $('#ciudad_entrega option:selected').text();
                                    let destino_texto = $('#destino_c').val();
                                    data.append('ciudad_texto', ciudad_texto);
                                    data.append('destino_texto', destino_texto);

                                    $.ajax({
                                        url: "../ajax/generar_gintracom.php",
                                        type: "POST",
                                        data: data,
                                        contentType: false,
                                        processData: false,
                                        success: function(response) {
                                            Swal.fire({
                                                icon: "info",
                                                title: "Por favor espere",
                                                text: "Estamos generando la guía",
                                                showConfirmButton: false,
                                                didOpen: () => {
                                                    Swal.showLoading();
                                                }
                                            })
                                            response = JSON.parse(response);

                                            $id_gintracom = response["guia"];
                                            data.append('id_gintracom', $id_gintracom);
                                            $.ajax({
                                                url: "../ajax/enviar_gintracom.php",
                                                type: "POST",
                                                data: data,
                                                contentType: false,
                                                processData: false,
                                                success: function(response) {
                                                    Swal.fire({
                                                        icon: "success",
                                                        title: "Guía generada",
                                                        text: "La guía ha sido generada exitosamente",
                                                        showConfirmButton: true,
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            window.location.href = `./editar_cotizacion_3.php?id_factura=` + $('#id_pedido_cot_').val();
                                                        }
                                                    })
                                                }
                                            })
                                        }

                                    })
                                }
                            });
                        }

                    });
                }
            });


        }

    }

    if (window.location.search != null) {
        let search_tienda = window.location.search.split("=")[1]
        fetch(`../ajax/verificar_fullfill.php?tienda=${search_tienda}`)
            .then(response => response.text())
            .then(html => {
                if (html == 1) {
                    document.getElementById("aplica").innerHTML = "---"
                }
            })
    }

    function seleccionar_transportadora(id) {
        if ($("#precio_laar").text() === "---" && id === 1) {
            $.Notification.notify('error', 'bottom right', 'ERROR!', 'NO HAY PRECIO DISPONIBLE PARA LAAR')
            return;
        }
        if ($("#precio_servientrega").text() === "---" && id === 3) {
            $.Notification.notify('error', 'bottom right', 'ERROR!', 'NO HAY PRECIO DISPONIBLE PARA SERVIENTREGA')
            return;
        }

        $('.card').css('border', 'none');
        $('.interactive-image').css('filter', 'grayscale(100%)');

        $('#card' + id).css('border', '2px solid #154289');
        $('#tr' + id).css('filter', 'none');
        $('#transp').val(id);
        $('#transportadora').val(id);
        console.log(id);
        if (id === 1) {
            let costo_envio_sin_signo = $('#precio_laar').text();
            costo_envio_sin_signo = costo_envio_sin_signo.replace('$', '');
            $("#costo_envio").val(costo_envio_sin_signo);
        } else if (id === 2) {
            $.Notification.notify('custom', 'bottom right', 'RECUERDA!', 'SPEED REALIZA ENTREGAS EL MISMO DÍA!')
        } else if (id === 3) {

            $("#costo_envio").val($("#precio_servientrega").text());

        }
    }

    function printFactura(id_factura) {
        $('#modal_vuelto').modal('hide');
        if (id_factura) {
            $.ajax({
                url: '../pdf/documentos/imprimir_cotizacion.php',
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
                    mywindow.document.close();
                    mywindow.focus();
                    mywindow.print();
                    mywindow.close();
                }
            });
        }
    }
</script>
<script>
    function obtener_caja(user_id) {
        $(".outer_div3").load("../modal/carga_caja.php?user_id=" + user_id);
    }
</script>
<script>
    function showDiv(select) {
        if (select.value == 4) {
            $("#resultados3").load("../ajax/carga_prima.php");
        } else {
            $("#resultados3").load("../ajax/carga_resibido.php");
        }
    }

    function cargar_provincia_pedido() {
        var id_provincia = $('#provinica option:selected').text();
        $.ajax({
            url: "../ajax/cargar_ciudad_pedido.php",
            type: "POST",
            data: {
                provinica: id_provincia,
            },
            dataType: 'text',
            success: function(data) {
                $('#div_ciudad').html(data);
                actualizarSelect();
            }
        });
    }

    function actualizarSelect() {
        $('#ciudad_entrega').select2('destroy');
        $('#ciudad_entrega').select2({
            placeholder: "Selecciona una opción",
            allowClear: true
        });
    }
</script>

<script>
    function seleccionarProvincia() {
        var id_provincia = $('#ciudad_entrega').val();
        let recaudo = $('#cod').val();

        calcular_guia(recaudo);
        calcular_servi(id_provincia, recaudo);
        calcular_gintra($("#ciudad_entrega option:selected").text(), recaudo);
        /*  $.ajax({
            url: "../ajax/cargar_provincia_pedido.php",
            type: "POST",
            data: {
                ciudad: id_provincia,
            },
            dataType: 'text',
            success: function(data) {
                $('#provinica').val(data).trigger('change');
                $('#provinica option[value=' + data + ']').attr({
                    selected: true
                });
                let precio_total = $('#precio_total').val();


            }
        })
    } */
    }

    $("#ciudad_entrega").select2({
        placeholder: "Selecciona una opción",
        allowClear: true,
    });

    function calcular_servi(id_provincia, recaudo) {
        recaudo = $('#cod').val();
        let ciudadOrigen = ""
        let tienda = window.location.search.split("=")[1];
        $.ajax({
            url: "../ajax/obtener_dato_envio_servi.php",
            type: "POST",
            data: {
                tienda: tienda,
                ciudad: id_provincia,
            },
            success: function(data) {
                let datos_envio = JSON.parse(data);
                ciudadOrigen = datos_envio["ciudad"];
                $('#nombre_remitente').val(datos_envio["nombre_remitente"]);
                $('#direccion_remitente').val(datos_envio["direccion_remitente"]);
                $('#telefono_remitente').val(datos_envio["telefono_remitente"]);
                $("#destino_c").val($('#ciudad_entrega option:selected').text());
                let ciudadDestino = ""
                let ciudad_or = $('#ciudad_entrega option:selected').text();
                let provincia_or = $('#provinica option:selected').text();
                $('#origen_texto').val(ciudadOrigen);
                $.ajax({
                    url: "../../../ajax/servientrega/cotizador3.php",
                    type: "POST",
                    data: {
                        ciudad_origen: ciudadOrigen,
                        ciudad_destino: ciudad_or,
                        provincia_destino: provincia_or,
                        precio_total: $('#valor_total_').val(),
                    },
                    success: function(data) {
                        let parser = new DOMParser();
                        let xmlDoc = parser.parseFromString(data, "text/xml");

                        let resultString = xmlDoc.getElementsByTagName("Result")[0].childNodes[0].nodeValue;

                        let resultDoc = parser.parseFromString(resultString, "text/xml");

                        function getNumericValueFromTag(tagName) {
                            let tag = resultDoc.getElementsByTagName(tagName)[0];
                            if (tag && tag.childNodes.length > 0) {
                                return parseFloat(tag.childNodes[0].nodeValue);
                            } else {
                                return 0;
                            }
                        }
                        let flete = getNumericValueFromTag("flete");
                        let seguro = getNumericValueFromTag("seguro");
                        let valorComision = getNumericValueFromTag("valor_comision");
                        let otros = getNumericValueFromTag("otros");
                        let impuesto = getNumericValueFromTag("impuesto");

                        $('#servi_impuesto').val(impuesto);
                        $('#servi_otros').val(otros);
                        $('#servi_seguro').val(seguro);
                        $('#servi_comision').val(valorComision);
                        $('#servi_flete').val(flete);
                    }

                })
                $.ajax({
                    url: "../ajax/obtener_dato_destino_servi.php",
                    type: "POST",
                    data: {
                        ciudad: id_provincia,
                    },
                    success: function(data) {
                        ciudadDestino = JSON.parse(data);
                        let destino = ciudadDestino["nombre"];
                        let origen = ciudadDestino["provincia"]
                        console.log(ciudadOrigen, destino, origen);
                        let precio_total = $('#valor_total_').val();
                        $.ajax({
                            url: "../../../ajax/servientrega/cotizador1.php",
                            type: "POST",
                            data: {
                                ciudad_origen: ciudadOrigen,
                                ciudad_destino: destino,
                                provincia_destino: origen,
                                precio_total: precio_total,
                            },
                            success: function(data) {
                                let datos = JSON.parse(data);
                                if (datos["trayecto"] !== "x") {
                                    $.ajax({
                                        url: "../../../ajax/servientrega/cotizador2.php",
                                        type: "POST",
                                        data: {
                                            trayecto: datos["trayecto"],
                                        },
                                        success: function(data) {
                                            let datos2 = JSON.parse(data);
                                            let precio = parseFloat(datos2["precio"]);
                                            let total_servi = 0
                                            if (recaudo == 1) {
                                                let valor_total_ = parseFloat($('#valor_total_').val());
                                                total_servi = precio + (valor_total_ * 0.03);
                                            } else {
                                                total_servi = precio;
                                            }
                                            $('#precio_servientrega').text(`$${parseFloat(total_servi).toFixed(2)}`);

                                        }
                                    })
                                } else {
                                    $('#precio_servientrega').text(`NO APLICA`);
                                }
                            }
                        })
                    }
                })
            }
        })
    }

    function calcular_guia(recaudo) {
        recaudo = $('#cod').val();
        let precio_total = $('#valor_total_').val();
        let provinica = $('#provinica').val();
        let ciudad_entrega = $('#ciudad_entrega').val();
        fetch(`../ajax/calcular_guia_new.php?precio_total=${precio_total}&provincia=${provinica}&ciudad_entrega=${ciudad_entrega}&recaudo=${recaudo}`)
            .then(response => response.json())
            .then(html => {
                console.log(html);
                let precio_laar = html["laar"];
                if (html === undefined || html === null || html === "" || html === "null" || html === "undefined" || html === NaN || html === "NaN" || html === "[]" || html.length === 0 || html === 0) {
                    $('#precio_laar').text(`NO APLICA`);
                    $('#costo_envio').val(0);
                } else {
                    $('#precio_laar').text(`$${precio_laar}`);
                    let envio_sin_signo = precio_laar.replace('$', '');
                    $('#costo_envio').val(envio_sin_signo);
                }
                if ($('#ciudad_entrega option:selected').text() == "QUITO") {
                    let precio_speed = $("#precio_laar").text();
                    precio_speed = precio_speed.replace('$', '');
                    let total_speed = parseFloat(precio_speed) + 1;
                    $('#aplica').text(`$5.50`);
                } else
                if ($('#ciudad_entrega option:selected').text() == "VALLE DE LOS CHILLOS") {
                    let precio_speed = $("#precio_laar").text();
                    precio_speed = precio_speed.replace('$', '');
                    let total_speed = parseFloat(precio_speed) + 1;
                    $('#aplica').text(`$6.50`);
                } else
                if ($('#ciudad_entrega option:selected').text() == "CUMBAYA") {
                    let precio_speed = $("#precio_laar").text();
                    precio_speed = precio_speed.replace('$', '');
                    let total_speed = parseFloat(precio_speed) + 1;
                    $('#aplica').text(`$6.50`);
                } else if ($('#ciudad_entrega option:selected').text() == "TUMBACO") {
                    let precio_speed = $("#precio_laar").text();
                    precio_speed = precio_speed.replace('$', '');
                    let total_speed = parseFloat(precio_speed) + 1;
                    $('#aplica').text(`$6.50`);
                } else if ($('#ciudad_entrega option:selected').text() == "PIFO") {
                    let precio_speed = $("#precio_laar").text();
                    precio_speed = precio_speed.replace('$', '');
                    let total_speed = parseFloat(precio_speed) + 1;
                    $('#aplica').text(`$6.50`);
                } else if ($('#ciudad_entrega option:selected').text() == "SANGOLQUI") {
                    let precio_speed = $("#precio_laar").text();
                    precio_speed = precio_speed.replace('$', '');
                    let total_speed = parseFloat(precio_speed) + 1;
                    $('#aplica').text(`$6.50`);
                } else if ($('#ciudad_entrega option:selected').text() == "SAN RAFAEL") {
                    let precio_speed = $("#precio_laar").text();
                    precio_speed = precio_speed.replace('$', '');
                    let total_speed = parseFloat(precio_speed) + 1;
                    $('#aplica').text(`$6.50`);
                } else if ($('#ciudad_entrega option:selected').text() == "CONOCOTO") {
                    let precio_speed = $("#precio_laar").text();
                    precio_speed = precio_speed.replace('$', '');
                    let total_speed = parseFloat(precio_speed) + 1;
                    $('#aplica').text(`$6.50`);
                } else {
                    $('#aplica').text(`NO APLICA`);

                }
            })
        $('#generar_guia_btn').removeAttr('disabled');

    }

    function calcular_gintra(id_ciudad, recaudo) {
        $.ajax({
            url: "../ajax/calcular_gintra.php",
            type: "POST",
            data: {
                ciudad: id_ciudad,
                recaudo: recaudo
            },
            success: function(data) {
                let precio = JSON.parse(data);
                console.log(precio);
                precio = precio["gintra"];
                if (precio === "x") {
                    $('#precio_gintra').text(`NO APLICA`);
                } else {
                    //de texto a numero
                    precio = parseFloat(precio);

                    console.log(precio);
                    if (recaudo == 1) {
                        precio = ($('#valor_total_').val() * 0.03) + precio;
                        precio = precio.toFixed(2);
                        $('#precio_gintra').text(`$${precio}`);
                    } else {
                        $('#precio_gintra').text(`$${precio}`);

                    }
                }
            }
        })

    }
</script>
<?php require 'includes/footer_end.php'
?>