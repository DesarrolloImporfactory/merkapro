<?php
include 'is_logged.php';
if (empty($_POST['codigo'])) {
    $errors[] = "Código vacío";
} else if (empty($_POST['nombre'])) {
    $errors[] = "Nombre del producto vacío";
} else if ($_POST['linea'] == "") {
    $errors[] = "Selecciona una Linea del producto";
} else if ($_POST['proveedor'] == "") {
    $errors[] = "Selecciona un Proveedor";
}else if (empty($_POST['precio'])) {
    $errors[] = "Precio de venta vacío";
} else if (
    !empty($_POST['codigo']) &&
    !empty($_POST['nombre']) &&
    $_POST['linea'] != "" &&
    $_POST['proveedor'] != "" &&
    !empty($_POST['precio']) &&
    !empty($_POST['minimo'])
) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    //Archivo de funciones PHP  
    require_once "../funciones.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    $codigo      = mysqli_real_escape_string($conexion, (strip_tags($_POST["codigo"], ENT_QUOTES)));
    $nombre      = mysqli_real_escape_string($conexion, (strip_tags($_POST["nombre"], ENT_QUOTES)));
    $descripcion = mysqli_real_escape_string($conexion, (strip_tags($_POST["descripcion"], ENT_QUOTES)));
    $linea       = intval($_POST['linea']);
    $proveedor   = intval($_POST['proveedor']);
    $estado      = 1;
    $impuesto    = 0;
    $inv         = intval($_POST['inv']);
    //$imp              = intval($_POST['id_imp']);
    $costo            = floatval($_POST['costo']);
    $utilidad         = floatval($_POST['utilidad']);
    $precio_venta     = floatval($_POST['precio']);
    $precio_mayoreo   = floatval($_POST['preciom']);
    $precio_especial  = floatval($_POST['precio']);
    @$precio_normal  = floatval($_POST['precion']);
    $stock            = floatval($_POST['stock']);
    $online            = 1;
    $stock_minimo     = floatval($_POST['minimo']);
    $formato    = floatval($_POST['formato']);
    $date_added       = date("Y-m-d H:i:s");
    $users            = intval($_SESSION['id_users']);
    $query_new_insert = '';
    // check if user or email address already exists
    $sql                   = "SELECT * FROM productos WHERE codigo_producto ='" . $codigo . "';";
    $query_check_user_name = mysqli_query($conexion, $sql);
    $query_check_user      = mysqli_num_rows($query_check_user_name);
    if ($query_check_user == true) {
        $sql = "UPDATE productos SET codigo_producto='" . $codigo . "',
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
                                        formato='" . $formato . "',
                                        stock_producto='" . $stock . "',
                                        stock_min_producto='" . $stock_minimo . "'
                                        WHERE codigo_producto='" . $codigo . "'";
        $query_update = mysqli_query($conexion, $sql);
    } else {
        $sql              = "INSERT INTO productos (codigo_producto, nombre_producto, descripcion_producto, id_linea_producto, id_proveedor, inv_producto, iva_producto, estado_producto, costo_producto, utilidad_producto, valor1_producto,valor2_producto,valor3_producto, stock_producto,stock_min_producto, date_added,id_imp_producto, pagina_web, formato, valor4_producto) VALUES ('$codigo','$nombre','$descripcion','$linea','$proveedor','$inv','$impuesto','$estado','$costo','$utilidad','$precio_venta','$precio_mayoreo','$precio_especial','$stock','$stock_minimo','$date_added','0','$online','$formato', '$precio_normal')";
        //echo $sql;
        //echo $formato;
        if ($formato == 3) {

            $imporsuit_db = mysqli_connect("194.163.183.231", 'administrador', '69635201d674bcb6f0897604c7c97cf8', 'suit-imporcomex');
            $url_site = $_SERVER['HTTP_HOST'];
            echo $url_site;
            $sql_usuario = "SELECT * FROM users WHERE url like '%" . $url_site . "%'";
            $query_usuario = mysqli_query($imporsuit_db, $sql_usuario);
            $rw_usuario = mysqli_fetch_array($query_usuario);
            echo mysqli_error($imporsuit_db);
            $users = $rw_usuario['id'];
            $pagina_data = $nombre . "_" . $users;
            $drag_db = mysqli_connect("194.163.183.231", 'administrador', '69635201d674bcb6f0897604c7c97cf8', 'drag');
            $drag_drop_sql = "INSERT INTO pagebuilder__pages (name, title, description, slug, settings, status, user_id) VALUES ('$pagina_data', '$pagina_data', '$descripcion', '$pagina_data', '', 'published', $users)";
            echo $drag_drop_sql;
            $query_drag_drop = mysqli_query($drag_db, $drag_drop_sql);
            echo mysqli_error($drag_db);
        }
        $query_new_insert = mysqli_query($conexion, $sql);
    }
    //Seleccionamos el ultimo compo numero_fatura y aumentamos una
    $sql         = mysqli_query($conexion, "select LAST_INSERT_ID(id_producto) as last from productos order by id_producto desc limit 0,1 ");
    $rw          = mysqli_fetch_array($sql);
    $id_producto = $rw['last'];

    $codigo_pro     = get_row('productos', 'codigo_producto', 'id_producto', $id_producto);


    //$sql2              = "INSERT INTO landing_producto (id_producto_l, codigo_pro) VALUES ($id_producto, '$codigo_pro')";

    //echo $sql2;

    //$query_new_insert2 = mysqli_query($conexion, $sql2);

    //GURDAMOS LAS ENTRADAS EN EL KARDEX
    $saldo_total    = $stock * $costo;
    $sql_kardex     = mysqli_query($conexion, "select * from kardex where producto_kardex='" . $id_producto . "' order by id_kardex DESC LIMIT 1");
    $rww            = mysqli_fetch_array($sql_kardex);
    @$cant_saldo     = $rww['cant_saldo'] + $stock;
    @$saldo_full     = ($rww['total_saldo'] + $saldo_total);
    @$costo_promedio = ($rww['total_saldo'] + $saldo_total) / $cant_saldo;
    @$tipo           = 5;

    guardar_entradas($date_added, $id_producto, $stock, $costo, $saldo_total, $cant_saldo, $costo_promedio, $saldo_full, $date_added, $users, $tipo);

    if ($query_new_insert or $query_update) {
        $messages[] = "Producto ha sido ingresado satisfactoriamente.";
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