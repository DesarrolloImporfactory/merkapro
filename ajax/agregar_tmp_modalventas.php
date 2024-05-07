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
        $cant = $row['cantidad_tmp'] + $cantidad;
        // condicion si el stock e menor que la cantidad requerida
        if ($cant > $row['stock_producto'] and $inv == 0) {
            echo "<script>swal('LA CATIDAD SUPERA AL STOCK', 'INTENTAR NUEVAMENTE', 'error')
            $('#resultados').load('../ajax/agregar_tmp.php');
            </script>";
            exit;
        } else {
            $sql          = "UPDATE tmp_ventas SET cantidad_tmp='" . $cant . "', precio_tmp='" . $precio_venta . "' WHERE id_producto='" . $id . "' and session_id='" . $session_id . "'";
            $query_update = mysqli_query($conexion, $sql);
            //echo "<script> $.Notification.notify('success','bottom center','NOTIFICACIÓN', 'PRODUCTO AGREGADO A LA FACTURA CORRECTAMENTE')</script>";
        }
        // fin codicion cantaidad

    } else {
        // condicion si el stock e menor que la cantidad requerida
        if ($cantidad > $stock and $inv == 0) {
            echo "<script>swal('LA CATIDAD SUPERA AL STOCK', 'INTENTAR NUEVAMENTE', 'error')
             $('#resultados').load('../ajax/agregar_tmp.php');
            </script>";
            exit;
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
                <img src="
                             
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
                <div class="_rsi-modal-line-item-quantity"><?php echo $cantidad; ?></div>

            </div>
            <div class="_rsi-modal-line-item-info">
                <a class="_rsi-modal-line-item-title" href="/products/aquapure?variant=45622098493721"><?php echo $nombre_producto; ?></a>
            </div>
            <div class="_rsi-modal-line-item-final-price"><?php echo $simbolo_moneda . number_format($final_items, 2); ?></div>
            &nbsp;&nbsp;&nbsp;<a href="#" class=' btn btn-danger btn-sm waves-effect waves-light' onclick="eliminar('<?php echo $id_tmp ?>')">x</a>
        </div><br>

    <?php
    }
    $total_factura = $subtotal + $total_impuesto;

    ?>
</div>
<div class="_rsi-build-block _rsi-build-block-totals-summary">
    <div class="_rsi-modal-checkout-lines">
        <div class="_rsi-modal-checkout-line" data-checkout-line="subtotal">
            <span class="_rsi-modal-checkout-line-title">Subtotal</span>
            <span class="_rsi-modal-checkout-line-value"><?php echo $simbolo_moneda . number_format($total_factura, 2); ?></span>
        </div>
        <input type="hidden" name="shipping_rate_priority" value="1">
        <div class="_rsi-modal-checkout-line" data-checkout-line="shipping">
            <span class="_rsi-modal-checkout-line-title">Envío</span><span class="_rsi-modal-checkout-line-value">Gratis</span>
        </div>
        <div class="_rsi-modal-checkout-line" data-checkout-line="total" data-order-total="2999" data-partial-total-for-checkout="2999"><span class="_rsi-modal-checkout-line-title _rsi-modal-checkout-line-value-bigger">Total</span><span class="_rsi-modal-checkout-line-value _rsi-modal-checkout-line-value-bigger"><?php echo $simbolo_moneda . number_format($total_factura, 2); ?></span></div>
    </div>
</div>



<script></script>
<script>
    //alert()

    $("#total_carrito").text(<?php echo $cantidad_total; ?>)
</script>