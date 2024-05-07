<?php

//include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado

/* Connect To Database*/
require_once "../sysadmin/vistas/db.php";
require_once "../sysadmin/vistas/php_conexion.php";
//Archivo de funciones PHP
require_once "../sysadmin/vistas/funciones.php";
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}
if (isset($_POST['cantidad'])) {
    $cantidad = $_POST['cantidad'];
}
if (isset($_POST['precio_venta'])) {
    $precio_venta = $_POST['precio_venta'];
}
if (isset($_POST['descripcion_libre'])) {
    $descripcion_libre = $_POST['descripcion_libre'];
}
if (isset($_POST['valor_cantidad'])) {
    $valor_cantidad = $_POST['valor_cantidad'];
} else {
    $valor_cantidad = 1;
}
//echo $descripcion_libre;
if (!empty($id) and !empty($cantidad) and !empty($precio_venta)) {
    // consulta para comparar el stock con la cantidad resibida
    $query = mysqli_query($conexion, "select stock_producto, drogshipin, inv_producto from productos where id_producto = '$id'");
    $rw    = mysqli_fetch_array($query);
    $stock = $rw['stock_producto'];
    $inv   = $rw['inv_producto'];
    $drogshipin_tmp   = $rw['drogshipin'];
    $session_id = $_POST['sesion'];
    //Comprobamos si agregamos un producto a la tabla tmp_compra
    $comprobar = mysqli_query($conexion, "select * from tmp_ventas, productos where productos.id_producto = tmp_ventas.id_producto and tmp_ventas.id_producto='" . $id . "' and tmp_ventas.session_id='" . $session_id . "'");
    if ($row = mysqli_fetch_array($comprobar)) {
        if ($valor_cantidad == 1) {
            $cant = $row['cantidad_tmp'] + 1;
        } else {
            $cant = $row['cantidad_tmp'] - 1;
        }

        // condicion si el stock e menor que la cantidad requerida
        if ($cant > $row['stock_producto'] and $inv == 0) {
            echo "<script>Swal.fire('LA CATIDAD SUPERA AL STOCK', 'INTENTAR NUEVAMENTE', 'error')
            $('#resultados').load('../ajax/agregar_tmp.php');
            </script>";
        } else {
            $sql          = "UPDATE tmp_ventas SET cantidad_tmp='" . $cant . "', precio_tmp='" . $precio_venta . "' WHERE id_producto='" . $id . "' and session_id='" . $session_id . "'";
            $query_update = mysqli_query($conexion, $sql);
            //echo "<script> $.Notification.notify('success','bottom center','NOTIFICACIÓN', 'PRODUCTO AGREGADO A LA FACTURA CORRECTAMENTE')</script>";
        }
        // fin codicion cantaidad

    } else {
        // condicion si el stock e menor que la cantidad requerida
        if ($cantidad > $stock and $inv == 0) {
            echo "<script>Swal.fire('LA CATIDAD SUPERA AL STOCK', 'INTENTAR NUEVAMENTE', 'error')
             $('#resultados').load('../ajax/agregar_tmp.php');
            </script>";
        } else {
            //echo "INSERT INTO tmp_ventas (id_producto,cantidad_tmp,precio_tmp,desc_tmp,session_id, drogshipin_tmp) VALUES ('$id','$cantidad','$precio_venta','0','$session_id','$drogshipin_tmp')";
            $insert_tmp = mysqli_query($conexion, "INSERT INTO tmp_ventas (id_producto,cantidad_tmp,precio_tmp,desc_tmp,session_id, drogshipin_tmp) VALUES ('$id','$cantidad','$precio_venta','0','$session_id','$drogshipin_tmp')");
            // echo "<script> $.Notification.notify('success','bottom center','NOTIFICACIÓN', 'PRODUCTO AGREGADO A LA FACTURA CORRECTAMENTE')</script>";
        }
        // fin codicion cantaidad
    }
}
if (isset($_GET['id'])) //codigo elimina un elemento del array
{
    $id_tmp = intval($_GET['id']);
    $delete = mysqli_query($conexion, "DELETE FROM tmp_ventas WHERE id_tmp='" . $id_tmp . "'");
}
$simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
?>


<div class="_rsi-modal-line-items">
    <?php
    $impuesto       = get_row('perfil', 'impuesto', 'id_perfil', 1);
    $nom_impuesto   = get_row('perfil', 'nom_impuesto', 'id_perfil', 1);
    $sumador_total  = 0;
    $total_iva      = 0;
    $total_impuesto = 0;
    $subtotal       = 0;
    $sql            = mysqli_query($conexion, "select * from productos, tmp_ventas where productos.id_producto=tmp_ventas.id_producto and tmp_ventas.session_id='" . $session_id . "'");
    $cantidad_total = 0;
    while ($row = mysqli_fetch_array($sql)) {
        $id_tmp          = $row["id_tmp"];
        $codigo_producto = $row['codigo_producto'];
        $id_producto     = $row['id_producto'];
        $cantidad        = $row['cantidad_tmp'];
        $desc_tmp        = $row['desc_tmp'];
        $nombre_producto = $row['nombre_producto'];
        $precio = $row['valor3_producto'];
        $image_path           = $row['image_path'];
        $precio_venta   = $row['precio_tmp'];
        $precio_venta_unitario = $precio_venta;
        $precio_venta_f = number_format($precio_venta, 2); //Formateo variables
        $precio_venta_r = str_replace(",", "", $precio_venta_f); //Reemplazo las comas
        $precio_total   = $precio_venta_r * $cantidad;
        $final_items    = rebajas($precio_total, $desc_tmp); //Aplicando el descuento
        /*--------------------------------------------------------------------------------*/
        $impuesto = get_row('perfil', 'impuesto', 'id_perfil', 1);
        $valor = ($impuesto / 100) + 1;
        $precio_venta = $final_items;
        $precio_venta_f = $precio_venta; //Formateo variable
        $precio_venta_r1 = str_replace(",", "", $precio_venta_f); //Reemplazo las comas  
        //PRECIO DESGLOSADO
        $precio_venta_desglosado = $precio_venta_r1 / $valor;
        $impuesto_unitario = $precio_venta_f - $precio_venta_desglosado;
        /*--------*/
        $precio_total_f = number_format($final_items, 2); //Precio total formateado
        $precio_total_r = str_replace(",", "", $precio_total_f); //Reemplazo las comas
        $sumador_total += $precio_venta_desglosado; //Sumador
        $final_items = rebajas($precio_total, $desc_tmp); //Aplicando el descuento
        $subtotal    = number_format($sumador_total, 2, '.', '');
        /*  if ($row['iva_producto'] == 1) {
        $total_iva = $impuesto_unitario;
    } else {
        $total_iva = iva($precio_venta_desglosado);
    }*/
        //$total_impuesto += rebajas($subtotal, $desc_tmp) * $cantidad;
        $total_impuesto = $total_impuesto + $impuesto_unitario;
        $cantidad_total = $cantidad_total + $cantidad;
        $simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
        //echo $total_impuesto.'<br>';
    ?>


        <div class="_rsi-modal-line-item" data-line-item-variant-id="45622098493721">
            <div class="_rsi-modal-line-item-image-container">
                <table style="width: 100%">
                    <tr>
                        <td style="width: 20%">
                            <img style="width: 67px" src="
                             
                              <?php
                                $subcadena = "http";

                                if (strpos(strtolower($image_path), strtolower($subcadena)) === 0) {
                                ?>
    <?php echo  $image_path . '"'; ?>
    <?php
                                } else {
    ?>
    sysadmin/<?php echo str_replace("../..", "", $image_path) ?>" <?php
                                                                }
                                                                    ?> class="_rsi-modal-line-item-image">
                        </td>
                        <td style="width: 10%">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-decrementar" data-id="<?php echo $id_producto; ?>">-</button>
                                </span>
                                <input type="text" name="cantidad[<?php echo $id_producto; ?>]" class="form-control input-cantidad" value="<?php echo $cantidad; ?>" data-id="<?php echo $id_producto; ?>" data-precio="<?php echo $precio_venta_unitario; ?>">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-incrementar" data-id="<?php echo $id_producto; ?>">+</button>
                                </span>
                            </div>
                            <script>
                                $(document).ready(function() {
                                    function actualizarCantidad(id, cantidad, valor_cantidad) {
                                        var precio = $("input[name='cantidad[" + id + "]']").data('precio');
                                        var sesion = $("#session").val();
                                        // Realizar petición AJAX para actualizar cantidad
                                        $.ajax({
                                            url: 'ajax/agregar_tmp_modalventas_1.php',
                                            method: 'POST',
                                            data: {
                                                id: id,
                                                cantidad: cantidad,
                                                precio_venta: precio,
                                                sesion: sesion,
                                                valor_cantidad
                                            },
                                            success: function(response) {
                                                $("#resultados").html(response);
                                                // Actualizar también los totales aquí si es necesario
                                            },
                                            error: function(error) {
                                                console.error(error);
                                            }
                                        });
                                    }

                                    // Asignación de eventos para botones de incrementar y decrementar
                                    $('.btn-decrementar').click(function() {
                                        var id = $(this).data('id');
                                        var inputCantidad = $("input[name='cantidad[" + id + "]']");
                                        var cantidadActual = parseInt(inputCantidad.val());
                                        if (cantidadActual > 1) {
                                            actualizarCantidad(id, cantidadActual - 1, 2);
                                            inputCantidad.val(cantidadActual - 1);
                                        }
                                    });

                                    $('.btn-incrementar').click(function() {
                                        var id = $(this).data('id');
                                        var inputCantidad = $("input[name='cantidad[" + id + "]']");
                                        var cantidadActual = parseInt(inputCantidad.val());
                                        actualizarCantidad(id, cantidadActual + 1, 1);
                                        inputCantidad.val(cantidadActual + 1);
                                    });
                                });
                            </script>
                        </td>
                        <td style="width: 50%">
                            <div class="_rsi-modal-line-item-info">
                                <a class="_rsi-modal-line-item-title" href="/products/aquapure?variant=45622098493721" style="font-size: 15px;"><?php echo $nombre_producto; ?></a>
                            </div>
                        </td>
                        <td style="width: 10%">
                            <div class="_rsi-modal-line-item-final-price"><?php echo $simbolo_moneda . number_format($final_items, 2); ?></div>
                        </td>
                        <td style="width: 10%">
                            &nbsp;&nbsp;&nbsp;<a href="#" class=' btn btn-danger btn-sm waves-effect waves-light' onclick="eliminar('<?php echo $id_tmp ?>')">x</a></td>
                    <tr>
                </table>
            </div><br>

        <?php
    }
    $total_factura = $subtotal + $total_impuesto;

        ?>
        </div>
        <div class="_rsi-build-block _rsi-build-block-totals-summary">
            <div style="background-color: #e8ecef; padding: 10px; " class="_rsi-modal-checkout-lines">
                <table style="width: 100%">

                    <div class="" data-checkout-line="subtotal">
                        <span style="text-align: left" class="">Subtotal</span>
                        <span style="float: right" class=""><?php echo $simbolo_moneda . number_format($total_factura, 2); ?></span>
                    </div>

                    <?php
                    $envioGratis_checkout = get_row('perfil', 'envioGratis_checkout', 'id_perfil', 1);
                    if ($envioGratis_checkout == 1) { ?>
                        <div class="_rsi-modal-checkout-line" data-checkout-line="shipping">
                            <span class="_rsi-modal-checkout-line-title">Envío</span>
                            <strong style="float: right" class="">Gratis</strong>
                        </div>
                    <?php } ?>

                    <hr>
                    <div class="" data-checkout-line="total" data-order-total="2999" data-partial-total-for-checkout="2999">
                        <strong class="">Total</strong><strong style="float: right" class=""><?php echo $simbolo_moneda . number_format($total_factura, 2); ?></strong>
                    </div>
                </table>
            </div>
        </div>
</div>



<script></script>
<script>
    //alert()

    $("#total_carrito").text(<?php echo $cantidad_total; ?>)
</script>