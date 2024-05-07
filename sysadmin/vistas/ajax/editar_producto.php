<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['mod_id'])) {
    $errors[] = "ID vacío";
} elseif (empty($_POST['mod_codigo'])) {
    $errors[] = "Codigo vacío";
} else if (empty($_POST['mod_nombre'])) {
    $errors[] = "Nombre del producto vacío";
} else if ($_POST['mod_linea'] == "") {
    $errors[] = "Selecciona una categoria del producto";
} else if ($_POST['mod_proveedor'] == "") {
    $errors[] = "Selecciona un Proveedor";
} else if (empty($_POST['mod_costo'])) {
    $errors[] = "Costo de Producto vacío";
} else if (empty($_POST['mod_precio'])) {
    $errors[] = "Precio de venta vacío";
} else if (empty($_POST['mod_minimo'])) {
    $errors[] = "Stock minimo vacío";
}   else if (
    !empty($_POST['mod_codigo']) &&
    !empty($_POST['mod_nombre']) &&
    $_POST['mod_linea'] != "" &&
    $_POST['mod_proveedor'] != "" &&
    //$_POST['mod_medida'] != "" &&
    !empty($_POST['mod_costo']) &&
    !empty($_POST['mod_precio']) &&
    !empty($_POST['mod_minimo'])
) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    require_once "../funciones.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    $codigo      = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_codigo"], ENT_QUOTES)));
    $nombre      = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_nombre"], ENT_QUOTES)));
    $descripcion = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_descripcion"], ENT_QUOTES)));
    $linea       = intval($_POST['mod_linea']);
    $proveedor   = intval($_POST['mod_proveedor']);
    //$medida          = intval($_POST['mod_medida']);
    $inv      = intval($_POST['mod_inv']);
    $impuesto = 0;
    //$estado   = intval($_POST['mod_estado']);
    //$imp             = intval($_POST['id_imp2']);
    $costo           = floatval($_POST['mod_costo']);
    $utilidad        = floatval($_POST['mod_utilidad']);
    $precio_venta    = floatval($_POST['mod_precio']);
    $precio_mayoreo  = floatval($_POST['mod_preciom']);
    @$precio_especial = floatval($_POST['mod_precio']);
    @$precio_normal = floatval($_POST['mod_precion']);
    $stock           = floatval($_POST['mod_stock']);
    $stock_minimo    = floatval($_POST['mod_minimo']);
    
    $formato    = floatval($_POST['mod_formato']);
    //echo $formato;
    //$online    = $_POST['mod_online'];
    $id_producto     = $_POST['mod_id'];
    $sql             = "UPDATE productos SET codigo_producto='" . $codigo . "',
                                        nombre_producto='" . $nombre . "',
                                        descripcion_producto='" . $descripcion . "',
                                        id_linea_producto='" . $linea . "',
                                        id_proveedor='" . $proveedor . "',
                                        inv_producto='" . $inv . "',
                                        iva_producto='" . $impuesto . "',
                                        costo_producto='" . $costo . "',
                                        utilidad_producto='" . $utilidad . "',
                                        valor1_producto='" . $precio_venta . "',
                                        valor2_producto='" . $precio_mayoreo . "',
                                        valor3_producto='" . $precio_especial . "',
                                        valor4_producto='" . $precio_normal . "',
                                        stock_producto='" . $stock . "',
                                        formato='" . $formato . "',
                                        stock_min_producto='" . $stock_minimo . "'
                                        WHERE id_producto='" . $id_producto . "'";
    //echo $sql;
    $query_update = mysqli_query($conexion, $sql);
    if ($query_update) {
        $messages[] = "Producto ha sido actualizado satisfactoriamente.";
         $tienda      = get_row('productos', 'tienda', 'id_producto', $id_producto);
         if($tienda=='enviado'){
     if (isset($_SERVER['HTTPS']) &&
    ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
    $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'
) {
    $protocol = 'https://';
} else {
    $protocol = 'http://';
}
$server_url = $protocol . $_SERVER['HTTP_HOST'];   

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $destino = new mysqli('localhost', 'root', '', 'master');
} else {
    $destino = new mysqli('localhost', 'imporsuit_marketplace', 'imporsuit_marketplace', 'imporsuit_marketplace');
}

$stock= get_row('productos', 'stock_producto', 'id_producto', $id_producto);
 $update  = mysqli_query($destino, "update productos set stock_producto='$stock',costo_producto='$precio_mayoreo'  where id_producto_origen='$id_producto' and tienda='$server_url' and inv_producto=0"); //Actualizo la nueva cantidad en el inventario
                    
    }
    
    } else {
        $errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($conexion);
    }
} else {
    $errors[] = "Error desconocido.";
}

if (isset($errors)) {

    ?>
    <div class="alert alert-danger" role="alert">
        <strong>Error!</strong>
        <?php
foreach ($errors as $error) {
        echo $error;
    }
    ?>
    </div>
    <?php
}
if (isset($messages)) {

    ?>
    <div class="alert alert-success" role="alert">
        <strong>¡Bien hecho!</strong>
        <?php
foreach ($messages as $message) {
        echo $message;
    }
    ?>
    </div>
    <?php
}

?>