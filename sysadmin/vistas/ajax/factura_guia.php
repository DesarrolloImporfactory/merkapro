<?php
include("../db.php");
include("../php_conexion.php");
include("../funciones.php");
$id_pedido = $_POST['id_factura'];


$sql = "select * from facturas_cot where id_factura=$id_pedido";
$resultado = mysqli_query($conexion, $sql);

while ($row = mysqli_fetch_array($resultado)) {
    $identificacion = get_row('guia_laar', 'identificacionD', 'id_pedido', $id_pedido);

    $nombre_cliente = $row['nombre'];
    $telefono_cliente = $row['telefono'];
    $direccion_cliente = $row['c_principal'] . ' ' . $row['c_secundaria'];

    $sql_cliente = "select * from clientes where fiscal_cliente='$identificacion'";
    //echo $sql_cliente;
    $resultado_cliente = mysqli_query($conexion, $sql_cliente);
    if ($resultado_cliente) {
        $num_rows = mysqli_num_rows($resultado_cliente);
        if ($num_rows > 0) {

            while ($cliente = mysqli_fetch_array($resultado_cliente)) {
                $nombre_cliente = $cliente['nombre_cliente'];
                $telefono_cliente = $cliente['telefono_cliente'];
                $identificacion = $cliente['fiscal_cliente'];
                $id_cliente= $cliente['id_cliente'];
                $correo_cliente= $cliente['email_cliente'];
            }
        } else {
            $insertar_cliente_sql = "INSERT INTO `clientes` (`nombre_cliente`, `fiscal_cliente`, `telefono_cliente`, `email_cliente`, `direccion_cliente`, `status_cliente`, `date_added`, `razon_social`, `nombre_contacto`, `telefono_contacto`, `cargo_contacto`, `observaciones`, `dias_credito`, `giro_negocio`, `ciudad`) "
                    . "VALUES ('$nombre_cliente', '$identificacion', '$telefono', '.', '$direccion', '1', '2024-03-20 04:49:22.000000', '.', '.', '.', '.', '.', '1', '.', '.');";
           // echo $insertar_cliente_sql;
            $insertar_cliente = mysqli_query($conexion, $insertar_cliente_sql);
            $id_cliente = mysqli_insert_id($conexion);
            $correo_cliente= get_row('clientes', 'email_cliente', 'id_cliente', $id_cliente);
            $telefono_cliente= get_row('clientes', 'telefono_cliente', 'id_cliente', $id_cliente);
// La consulta no devolvió resultados para este cliente
        }
    }
}
?>
<style>
    .image-bn {
        filter: grayscale(100%);
        transition: filter 0.3s ease; /* Animación suave */
    }

    .image-bn:hover {
        filter: grayscale(0%);
    }
    .formulario {
    border-radius: 25px; /* O un valor alto para garantizar bordes completamente redondeados */
}
</style>
<div style="background-color: #fdfdfe" class="card-box">
    <div class="widget-chart">
        <div class="editar_factura" class='col-md-12' style="margin-top:10px"></div>

        <form role="form" id="datos_factura">
            <input id="id_vendedor" name="id_vendedor" type='hidden' value="1">
<div id="outer_comprobante"></div>

            <div class="row">
              
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fiscal">RUC/Cedula</label>
                        <input type="text" class="form-control formulario" autocomplete="off" id="rnc1" name="rnc1" minlength="10" tabindex="2" maxlength="13" value="<?php echo $identificacion; ?>">
                        
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                         <label for="fiscal">Nombre Cliente</label>
                        <input type="text" id="nombre_cliente" class="form-control formulario" required value="<?php echo $nombre_cliente; ?>" tabindex="2">
                        <!--span class="input-group-btn">
                                <button type="button" class="btn waves-effect waves-light btn-success" data-toggle="modal" data-target="#nuevoCliente"><li class="fa fa-plus"></li></button>
                        </span-->
                        <input id="id_cliente1" name="id_cliente1" type='hidden' value="<?php echo $id_cliente; ?>">
                    </div>
                </div>
            </div>
            
                       
                        <input type="hidden" class="form-control formulario" autocomplete="off" id="cotizacion"  name="cotizacion" value="<?php echo $id_pedido; ?>" readonly>
                 
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fiscal">Correo</label>
                        <input type="text" class="form-control formulario" autocomplete="off" id="correo_cliente" name="correo_cliente"   value="<?php echo $correo_cliente; ?>">
                        
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fiscal">Telefono</label>
                        <input type="text" class="form-control formulario" autocomplete="off" id="telefono_cliente" name="telefono_cliente"   value="<?php echo $telefono_cliente; ?>">
                        
                    </div>
                </div>
                

            </div>
                        <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="fiscal">Direccion</label>
                        <input type="text" class="form-control formulario" autocomplete="off" id="direccion_cliente" name="direccion_cliente"   value="<?php echo $direccion_cliente; ?>">
                        
                    </div>
                </div>
            </div>
            

 
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="condiciones">Pago</label>
                        <select class="form-control input-sm condiciones formulario" id="condiciones" name="condiciones" onchange="showDiv(this)">
                            <option value="1">Efectivo</option>
                            <option value="4">Crédito</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div id="resultados3"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="condiciones">Forma de Pago</label>
                        <select class="form-control formulario" id="formaPago" name="formaPago" required="required">
                            <option value="01">SIN UTILIZACION DEL SISTEMA FINANCIERO</option>
                            <option value="15">COMPENSACIÓN DE DEUDAS</option>
                            <option value="16">TARJETA DE DÉBITO</option>
                            <option value="17">DINERO ELECTRÓNICO</option>
                            <option value="18">TARJETA PREPAGO</option>
                            <option value="19">TARJETA DE CRÉDITO</option>
                            <option value="20">OTROS CON UTILIZACION DEL SISTEMA FINANCIERO</option>
                            <option value="21">ENDOSO DE TÍTULOS</option>

                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="condiciones">Plazo D&iacute;as</label>
                        <input type="number" class="form-control formulario" id="plazodias" name="plazodias" value="1" required="required">
                    </div>
                </div>
            </div>

            <div class="row">
                
                <div class="col-md-6">
                    <button type="button" class="btn btn-primary waves-effect waves-light formulario" onclick="guardar_cotizacion()"><span class="ti-shopping-cart-full"></span>Guardar Facturar</button>
                </div>
            </div>
        </form>

    </div>
</div>

<script>
        // Cuando el valor del input cambie
        $('#rnc1').on('input', function() {
            // Obtener el valor del input
            var nuevoRNC = $(this).val();
            id_cliente=$('#id_cliente1').val();
            //alert();
            // Enviar el nuevo RNC al servidor mediante AJAX
            $.ajax({
                url: '../ajax/actualizar_rcn.php', // Ruta del archivo PHP que procesará la actualización
                type: 'POST',
                data: { rnc: nuevoRNC, id_cliente:id_cliente, }, // Datos a enviar al servidor
                success: function(response) {
                    // Manejar la respuesta del servidor (puede ser un mensaje de éxito o error)
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Manejar errores de la petición AJAX
                    console.error(xhr.responseText);
                }
            });
        });
        
        $('#correo_cliente').on('input', function() {
            // Obtener el valor del input
            var nuevoRNC = $(this).val();
            id_cliente=$('#id_cliente1').val();
            //alert();
            // Enviar el nuevo RNC al servidor mediante AJAX
            $.ajax({
                url: '../ajax/actualizar_correo_cliente.php', // Ruta del archivo PHP que procesará la actualización
                type: 'POST',
                data: { rnc: nuevoRNC, id_cliente:id_cliente, }, // Datos a enviar al servidor
                success: function(response) {
                    // Manejar la respuesta del servidor (puede ser un mensaje de éxito o error)
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Manejar errores de la petición AJAX
                    console.error(xhr.responseText);
                }
            });
        });
        
        $('#direccion_cliente').on('input', function() {
            // Obtener el valor del input
            var nuevoRNC = $(this).val();
            id_cliente=$('#id_cliente1').val();
            //alert();
            // Enviar el nuevo RNC al servidor mediante AJAX
            $.ajax({
                url: '../ajax/actualizar_direccion_cliente.php', // Ruta del archivo PHP que procesará la actualización
                type: 'POST',
                data: { rnc: nuevoRNC, id_cliente:id_cliente, }, // Datos a enviar al servidor
                success: function(response) {
                    // Manejar la respuesta del servidor (puede ser un mensaje de éxito o error)
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Manejar errores de la petición AJAX
                    console.error(xhr.responseText);
                }
            });
        });
        
        $('#telefono_cliente').on('input', function() {
            // Obtener el valor del input
            var nuevoRNC = $(this).val();
            id_cliente=$('#id_cliente1').val();
            //alert();
            // Enviar el nuevo RNC al servidor mediante AJAX
            $.ajax({
                url: '../ajax/actualizar_telefono_cliente.php', // Ruta del archivo PHP que procesará la actualización
                type: 'POST',
                data: { rnc: nuevoRNC, id_cliente:id_cliente, }, // Datos a enviar al servidor
                success: function(response) {
                    // Manejar la respuesta del servidor (puede ser un mensaje de éxito o error)
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Manejar errores de la petición AJAX
                    console.error(xhr.responseText);
                }
            });
        });
        
        function guardar_cotizacion() {
    //alert()
    $('#btn_guardar').attr("disabled", true);
    var id_cliente = $("#id_cliente1").val();
    var cotizacion = $("#cotizacion").val();
    var factura = $("#factura").val();
    //alert(factura)
    var id_comp = $("#id_comp").val();
    var tip_doc = 1;
    var trans = $("#trans").val();
    
    var formaPago = $("#formaPago").val();
    var plazodias = $("#plazodias").val();
    
    var condiciones = $("#condiciones").val();
    var resibido = $("#resibido").val();
    if (id_cliente == "") {
        $.Notification.notify('error', 'bottom center', 'NOTIFICACIÓN', 'SELECCIONAR UN CLIENTE VALIDO')
        $("#nombre_cliente").focus();
        $('#btn_guardar').attr("disabled", false);
        return false;
    }
    parametros = {
        'id_cliente': id_cliente,
        'cotizacion': cotizacion,
        'factura': factura,
        'id_comp': id_comp,
        'tip_doc': tip_doc,
        'trans': trans,
        'condiciones': condiciones,
        'formaPago': formaPago,
        'plazodias': plazodias,
        'resibido': resibido
    };
    $.ajax({
        type: "POST",
        url: "../ajax/guardar_venta_cot.php",
        data: parametros,
        beforeSend: function(objeto) {
            $("#resultados_ajaxf").html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(datos) {
          setTimeout(function() {
            window.location.href = 'bitacora_ventas.php';
        }, 3000); // 3000 milisegundos = 3 segundos
        }
    });
    event.preventDefault();
};
    </script>