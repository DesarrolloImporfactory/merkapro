  <?php
    // session_start();
    //include 'sysadmin/vistas/ajax/is_logged.php'; 
    error_reporting(E_ALL);
ini_set('display_errors', '1');
    require_once "sysadmin/vistas/db.php";
    //echo DB_HOST;
    require_once "sysadmin/vistas/php_conexion.php";
    require_once "sysadmin/vistas/funciones.php";
    // echo 'sysadmin/vistas/ajax/banner/'.get_row('perfil', 'banner', 'id_perfil', 1);
    //include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
    /*Inicia validacion del lado del servidor*/
    if ($_SERVER['HTTP_HOST'] == 'localhost') {
        $or_marketplace = 'http://localhost/official/imporsuitv01/';
    } else {
        $or_marketplace = 'https://merkapro.ec/';
    }
    
    $archivo_origen = $or_marketplace . 'sysadmin/vistas/db1.php';
    // echo $archivo_origen;
    $contenido = file_get_contents($archivo_origen);
    //  echo $contenido;
    $archivo_destino = 'sysadmin/vistas/db_destino_marketplace.php'; // Nombre del archivo de destino
    // Obtener el contenido del archivo original
    // $origen = fopen($archivo_origen_marketplace, 'r');
    if (file_put_contents($archivo_destino, $contenido) !== false) {
        //echo "El JSON se ha guardado correctamente en el archivo.";
    } else {
        echo "Error al guardar eddl JSON en el archivo.";
    }
    require_once "sysadmin/vistas/php_conexion_marketplace.php";


    $session = $_POST['session'];
    //echo 'asdasd'.$session;
    if (empty($_POST['session'])) {
        $errors[] = "ID VACIO";
    } else if (!empty($_POST['cliente'])) {
        $session_id     = $session;
        $nombre     = $_POST['nombre'];
        $telefono    = $_POST['telefono'];
        $cedula   = $_POST['cedula'];
        $calle_principal    = $_POST['calle_principal'];
        $calle_secundaria    = $_POST['calle_secundaria'];
        $referencia    = $_POST['referencia'];
        $provincia     = $_POST['provinica'];
        $ciudad     = $_POST['ciudad_entrega'];
        $observacion     = $_POST['observacion'];
        $simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
        $contenido = '';
        $direccion = get_row('provincia_laar', 'provincia', 'codigo_provincia', $provincia) . ' ' . get_row('ciudad_laar', 'nombre', 'codigo', $ciudad) . ' ' . $calle_principal . ' ' . $calle_secundaria . ' ' . $referencia;
        //Comprobamos si hay archivos en la tabla temporal
        // echo "select * from tmp_cotizacion where session_id='" . $session_id . "'";
        $sql_count = mysqli_query($conexion, "select * from tmp_cotizacion where session_id='" . $session_id . "'");
        $count     = mysqli_num_rows($sql_count);
        // escaping, additionally removing everything that could be (html/javascript-) code
        $id_cliente     = intval($_POST['cliente']);
        //echo $id_cliente;
        $id_vendedor    = 1;
        $users          = 1;
        $condiciones    = 1;
        //$numero_factura = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST["factura"], ENT_QUOTES)));
        $validez        = 3;
        $date_added     = date("Y-m-d H:i:s");
        //Operacion de Creditos
        if ($condiciones == 4) {
            $estado = 2;
        } else {
            $estado = 1;
        }
        //echo "select LAST_INSERT_ID(id_factura) as last from facturas_cot order by id_factura desc limit 0,1 ";
        //Seleccionamos el ultimo compo numero_fatura y aumentamos una
        $sql = "SELECT MAX(id_factura) as ultima_factura FROM facturas_cot";
        $resultado = mysqli_query($conexion, $sql);
        if ($resultado) {
            $fila = mysqli_fetch_assoc($resultado);
            $ultima_factura = $fila['ultima_factura'];
            if ($ultima_factura !== null) {
                $id_factura =  $ultima_factura + 1;;
            } else {
                $id_factura = 1;
            }
        } else {
            echo "Error en la consulta: " . mysqli_error($conexion);
        }
        // finde la ultima fatura
        //Control de la  numero_fatura y aumentamos una
        //echo "SELECT RIGHT(numero_factura,6) as factura FROM facturas_cot ORDER BY factura DESC LIMIT 1";
        $query_id = mysqli_query($conexion, "SELECT RIGHT(numero_factura,6) as factura FROM facturas_cot ORDER BY factura DESC LIMIT 1")
            or die('error ' . mysqli_error($conexion));
        $query_id_marketplace = mysqli_query($conexion_marketplace, "SELECT RIGHT(numero_factura,6) as factura FROM facturas_cot ORDER BY id_factura DESC LIMIT 1")
            or die('error ' . mysqli_error($conexion_marketplace));
        $count = mysqli_num_rows($query_id);
        $count_marketplace = mysqli_num_rows($query_id_marketplace);
        if ($count != 0) {

            $data_id = mysqli_fetch_assoc($query_id);
            $factura = $data_id['factura'] + 1;
        } else {
            $sql        = mysqli_query($conexion, "select LAST_INSERT_ID(id_factura) as last from facturas_cot order by id_factura desc limit 0,1 ");
            $rw         = mysqli_fetch_array($sql);
            $id_factura = $rw['last'] + 1;
        }
        if ($count_marketplace != 0) {
            $data_id_marketplace = mysqli_fetch_assoc($query_id_marketplace);
            $factura_marketplace = $data_id_marketplace['factura'] + 1;
            //echo $factura_marketplace;
        } else {
            $factura_marketplace = 1;
        }

        $buat_id = str_pad($factura, 6, "0", STR_PAD_LEFT);
        $factura = "COT-$buat_id";
        $buat_id_market = str_pad($factura_marketplace, 6, "0", STR_PAD_LEFT);
        $factura_marketplace = "COT-$buat_id_market";

        // fin de numero de fatura
        // consulta principal
        $nums          = 1;
        $impuesto      = get_row('perfil', 'impuesto', 'id_perfil', 1);
        $sumador_total = 0;
        $sum_total     = 0;
        $t_iva         = 0;
        //echo  "select * from productos, tmp_cotizacion where drogshipin_tmp=0 and productos.id_producto=tmp_cotizacion.id_producto and tmp_cotizacion.session_id='" . $session_id . "'";
        $sql           = mysqli_query($conexion, "select * from productos, tmp_cotizacion where drogshipin_tmp=0 and productos.id_producto=tmp_cotizacion.id_producto and tmp_cotizacion.session_id='" . $session_id . "'");
        $resultado = mysqli_num_rows($sql);

        if (
            isset($_SERVER['HTTPS']) &&
            ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'
        ) {
            $protocol = 'https://';
        } else {
            $protocol = 'http://';
        }
        $server_url = $protocol . $_SERVER['HTTP_HOST'];

        if ($resultado > 0) {
            while ($row = mysqli_fetch_array($sql)) {
                $id_tmp          = $row["id_tmp"];
                $id_producto     = $row['id_producto'];
                $codigo_producto = $row['codigo_producto'];
                $cantidad        = $row['cantidad_tmp'];
                $drogshipin        = $row['drogshipin_tmp'];
                $desc_tmp        = $row['desc_tmp'];
                $nombre_producto = $row['nombre_producto'];

                $contenido .= ' %3a%0A ' . $nombre_producto . ' x ' . $cantidad;
                $id_marketplace = $row['id_marketplace'];
                $id_producto_origen = $row['id_producto_origen'];
                // control del impuesto por productos.
                if ($row['iva_producto'] == 0) {
                    $p_venta   = $row['precio_tmp'];
                    $p_venta_f = number_format($p_venta, 2); //Formateo variables
                    $p_venta_r = str_replace(",", "", $p_venta_f); //Reemplazo las comas
                    $p_total   = $p_venta_r * $cantidad;
                    $f_items   = rebajas($p_total, $desc_tmp); //Aplicando el descuento
                    /*--------------------------------------------------------------------------------*/
                    $p_total_f = number_format($f_items, 2); //Precio total formateado
                    $p_total_r = str_replace(",", "", $p_total_f); //Reemplazo las comas
                    $sum_total += $p_total_r; //Sumador
                    $t_iva = ($sum_total * $impuesto) / 100;
                    $t_iva = number_format($t_iva, 2, '.', '');
                }
                //end impuesto
                $precio_venta   = $row['precio_tmp'];
                $precio_venta_f = number_format($precio_venta, 2); //Formateo variables
                $precio_venta_r = str_replace(",", "", $precio_venta_f); //Reemplazo las comas
                $precio_total   = $precio_venta_r * $cantidad;
                $final_items    = rebajas($precio_total, $desc_tmp); //Aplicando el descuento
                /*--------------------------------------------------------------------------------*/
                $precio_total_f = number_format($final_items, 2); //Precio total formateado
                $precio_total_r = str_replace(",", "", $precio_total_f); //Reemplazo las comas
                $sumador_total += $precio_total_r; //Sumador
                $contenido .= ' %3a%0A ' . '*Precio: * $' . number_format($precio_venta, 2);
                //Insert en la tabla detalle_factura
                // echo "INSERT INTO detalle_fact_cot VALUES (NULL,'$id_factura','$factura','$id_producto','$cantidad','$desc_tmp','$precio_venta_r','$drogshipin',NULL)";
                //marketplace
                $sql_f_marketplace = "SELECT MAX(id_factura) as ultima_factura FROM facturas_cot";
                $resultado_f_marketplace = mysqli_query($conexion_marketplace, $sql_f_marketplace);
                if ($resultado_f_marketplace) {

                    $fila_marketplace = mysqli_fetch_assoc($resultado_f_marketplace);
                    $ultima_factura_marketplace = $fila_marketplace['ultima_factura'];

                    if ($ultima_factura_marketplace !== null) {
                        $id_factura_marketplace =  $ultima_factura_marketplace + 1;
                        echo $id_factura_marketplace;
                    } else {
                        $id_factura_marketplace = 1;
                    }
                } else {
                    echo "Error en la consulta: " . mysqli_error($conexion_marketplace);
                }
                //$id_producto_marketplace= get_row_guia($conexion_marketplace, $table, $row, $id, $equal);
                // $id_producto_marketplace=get_row_guia('productos', 'id_producto', 'id_producto_origen', $id_producto . " and tienda='" . $server_url . "'");
                // echo 'eee'.$factura_marketplace;
                $insert_detail = mysqli_query($conexion, "INSERT INTO detalle_fact_cot VALUES (NULL,'$id_factura','$factura','$id_producto','$cantidad','$desc_tmp','$precio_venta_r','$drogshipin',NULL)");
                $insert_detail = mysqli_query($conexion_marketplace, "INSERT INTO detalle_fact_cot VALUES (NULL,'$id_factura_marketplace','$factura_marketplace','$id_producto','$cantidad','$desc_tmp','$precio_venta_r','$drogshipin','$id_producto')");
            }
            // Fin de la consulta Principal
            $subtotal      = number_format($sumador_total, 2, '.', '');
            $total_iva     = ($subtotal * $impuesto) / 100;
            $total_iva     = number_format($total_iva, 2, '.', '') - number_format($t_iva, 2, '.', '');
            $total_factura = $subtotal + $total_iva;
            $contenido .= ' %3a%0A ' . '*Total Pedido: * $' . number_format($total_factura, 2);
            //echo "INSERT INTO facturas_cot VALUES (NULL,'$factura','$date_added','$id_cliente','$id_vendedor','$condiciones','$total_factura','$estado','$users','$validez','1')";
            $sql = "INSERT INTO `facturas_cot` ( `numero_factura`, `fecha_factura`, `id_cliente`, `id_vendedor`, `condiciones`, `monto_factura`, `estado_factura`, `id_users_factura`, `validez`, `id_sucursal`, `nombre`, `telefono`, `provincia`, `c_principal`, `ciudad_cot`, `c_secundaria`, `referencia`, `observacion`, `guia_enviada`, `transporte`,  `drogshipin`) "
                . "VALUES ( '$factura', '$date_added', '$id_cliente', '$id_vendedor', '$condiciones', '$total_factura', '$estado', '$users', '$validez', '1', '$nombre', '$telefono', '$provincia', '$calle_principal', '$ciudad', '$calle_secundaria', '$referencia', '$observacion', '0', '', 0); ";
            //echo $sql;

            $insert      = mysqli_query($conexion, $sql);
            $ultimo_id = mysqli_insert_id($conexion);

            $sql_marketplace = "INSERT INTO `facturas_cot` ( `numero_factura`, `fecha_factura`, `id_cliente`, `id_vendedor`, `condiciones`, `monto_factura`, `estado_factura`, `id_users_factura`, `validez`, `id_sucursal`, `nombre`, `telefono`, `provincia`, `c_principal`, `ciudad_cot`, `c_secundaria`, `referencia`, `observacion`, `guia_enviada`, `transporte`, `drogshipin`, `tienda`, `id_factura_origen`) "
                . "VALUES ( '$factura_marketplace', '$date_added', '$id_cliente', '$id_vendedor', '$condiciones', '$total_factura', '$estado', '$users', '$validez', '1', '$nombre', '$telefono', '$provincia', '$calle_principal', '$ciudad', '$calle_secundaria', '$referencia', '$observacion', '0', '', 4,'$server_url','$ultimo_id'); ";
            //echo $sql_marketplace;
            $insert      = mysqli_query($conexion_marketplace, $sql_marketplace);
            // SI ES DROGSHIPDEBE GENERARSE EN EL MARKETPLACE
        }
        //si la venta es drgoshipin
        //require_once "$server_url/marketplace/sysadmin/vistas/db.php";
        // Guardar el contenido descargado en un archivo local
        //require_once "sysadmin/vistas/funciones.php";
        $sql_productos = "SELECT tienda, COUNT(*) as cantidad_productos
FROM productos, tmp_cotizacion
WHERE drogshipin_tmp=1 
    AND productos.id_producto=tmp_cotizacion.id_producto 
    AND tmp_cotizacion.session_id='$session_id'
GROUP BY tienda;";
        // echo $sql_productos;
        $sql_producto_tienda = mysqli_query($conexion, $sql_productos);
        if ($sql_producto_tienda) {
            //echo 'sddsahha'.$session_id;
            while ($row_tienda = mysqli_fetch_assoc($sql_producto_tienda)) {
                //echo 'sddsahha'.$session_id;
                $tienda         = $row_tienda["tienda"];
                //conexion a la base destino
                $archivo_tienda = $tienda . '/sysadmin/vistas/db1.php'; // Nombre del archivo original
                // echo $archivo_tienda;
                $contenido_tienda = file_get_contents($archivo_tienda);
                $archivo_destino_tienda = 'sysadmin/vistas/db_destino.php'; // Nombre del archivo de destino
                // $origen = fopen($archivo_origen_marketplace, 'r');
                if (file_put_contents($archivo_destino_tienda, $contenido_tienda) !== false) {
                    //echo "El JSON se ha guardado correctamente en el archivo.";
                } else {
                    echo "Error al guardar eddl JSON en el archivo.";
                }
                require_once "sysadmin/vistas/php_conexion_destino.php";
                $nums          = 1;
                $impuesto      = get_row('perfil', 'impuesto', 'id_perfil', 1);
                $sumador_total = 0;
                $sum_total     = 0;
                $t_iva         = 0;
                $query_id = mysqli_query($conexion, "SELECT RIGHT(numero_factura,6) as factura FROM facturas_cot ORDER BY factura DESC LIMIT 1")
                    or die('error ' . mysqli_error($conexion));
                $query_id_destino = mysqli_query($conexion_destino, "SELECT RIGHT(numero_factura,6) as factura FROM facturas_cot ORDER BY factura DESC LIMIT 1")
                    or die('error ' . mysqli_error($conexion_destino));

                $query_id_marketplace = mysqli_query($conexion_marketplace, "SELECT RIGHT(numero_factura,6) as factura FROM facturas_cot ORDER BY id_factura DESC LIMIT 1")
                    or die('error ' . mysqli_error($conexion_marketplace));
                $count = mysqli_num_rows($query_id);
                $count_destino = mysqli_num_rows($query_id_destino);
                $count_marketplace = mysqli_num_rows($query_id_marketplace);
                if ($count_marketplace != 0) {
                    $data_id_marketplace = mysqli_fetch_assoc($query_id_marketplace);
                    $factura_marketplace = $data_id_marketplace['factura'] + 1;
                    echo $data_id_marketplace['factura'] + 1;
                } else {
                    $factura_marketplace = 1;
                }
                if ($count_destino != 0) {
                    $data_id_destino = mysqli_fetch_assoc($query_id_destino);
                    $factura_destino = $data_id_destino['factura'] + 1;
                } else {
                    $factura_destino = 1;
                }
                if ($count != 0) {
                    $data_id = mysqli_fetch_assoc($query_id);
                    $factura = $data_id['factura'] + 1;
                } else {
                    $factura = 1;
                }
                $buat_id = str_pad($factura, 6, "0", STR_PAD_LEFT);
                $buat_id_destino = str_pad($factura_destino, 6, "0", STR_PAD_LEFT);
                $buat_id_marketplace = str_pad($factura_marketplace, 6, "0", STR_PAD_LEFT);
                $factura = "COT-$buat_id";
                $factura_destino = "COT-$buat_id_destino";
                $factura_marketplace = "COT-$buat_id_marketplace";
                // $sql_tienda           = mysqli_query($conexion, "select * from productos, tmp_ventas where  tienda=$tienda and drogshipin_tmp=1 and productos.id_producto=tmp_ventas.id_producto and tmp_ventas.session_id='" . $session_id . "'");
                //echo "select * from productos, tmp_ventas where tienda='$tienda' and drogshipin_tmp=1 and productos.id_producto=tmp_ventas.id_producto and tmp_ventas.session_id='" . $session_id . "'";
                $sql           = mysqli_query($conexion, "select * from productos, tmp_cotizacion where tienda='$tienda' and  drogshipin_tmp=1 and productos.id_producto=tmp_cotizacion.id_producto and tmp_cotizacion.session_id='" . $session_id . "'");
                $resultado = mysqli_num_rows($sql);
                if ($resultado > 0) {
                    while ($row = mysqli_fetch_array($sql)) {
                        $id_tmp          = $row["id_tmp"];
                        $id_producto     = $row['id_producto'];
                        $codigo_producto = $row['codigo_producto'];
                        $cantidad        = $row['cantidad_tmp'];
                        $drogshipin        = $row['drogshipin_tmp'];
                        $desc_tmp        = $row['desc_tmp'];
                        $nombre_producto = $row['nombre_producto'];
                        $id_producto_origen = $row['id_producto_origen'];
                        $id_marketplace = $row['id_marketplace'];
                        $tienda = $row['tienda'];
                        $contenido .= ' %3a%0A ' . $nombre_producto . ' x ' . $cantidad;
                        // control del impuesto por productos.
                        if ($row['iva_producto'] == 0) {
                            $p_venta   = $row['precio_tmp'];
                            $p_venta_f = number_format($p_venta, 2); //Formateo variables
                            $p_venta_r = str_replace(",", "", $p_venta_f); //Reemplazo las comas
                            $p_total   = $p_venta_r * $cantidad;
                            $f_items   = rebajas($p_total, $desc_tmp); //Aplicando el descuento
                            /*--------------------------------------------------------------------------------*/
                            $p_total_f = number_format($f_items, 2); //Precio total formateado
                            $p_total_r = str_replace(",", "", $p_total_f); //Reemplazo las comas
                            $sum_total += $p_total_r; //Sumador
                            $t_iva = ($sum_total * $impuesto) / 100;
                            $t_iva = number_format($t_iva, 2, '.', '');
                        }
                        //end impuesto
                        $precio_venta   = $row['precio_tmp'];
                        $precio_venta_f = number_format($precio_venta, 2); //Formateo variables
                        $precio_venta_r = str_replace(",", "", $precio_venta_f); //Reemplazo las comas
                        $precio_total   = $precio_venta_r * $cantidad;

                        $final_items    = rebajas($precio_total, $desc_tmp); //Aplicando el descuento
                        /*--------------------------------------------------------------------------------*/
                        $precio_total_f = number_format($final_items, 2); //Precio total formateado
                        $precio_total_r = str_replace(",", "", $precio_total_f); //Reemplazo las comas
                        $sumador_total += $precio_total_r; //Sumador
                        $contenido .= ' %3a%0A ' . '*Precio: * $' . number_format($precio_venta, 2);
                        //Insert en la tabla detalle_factura
                        // echo "INSERT INTO detalle_fact_cot VALUES (NULL,'$id_factura','$factura','$id_producto','$cantidad','$desc_tmp','$precio_venta_r')";
                        $sql_f = "SELECT MAX(id_factura) as ultima_factura FROM facturas_cot";
                        $resultado_f = mysqli_query($conexion, $sql_f);
                        if ($resultado_f) {
                            $fila = mysqli_fetch_assoc($resultado_f);
                            $ultima_factura = $fila['ultima_factura'];
                            if ($ultima_factura !== null) {
                                $id_factura =  $ultima_factura + 1;;
                            } else {
                                $id_factura = 1;
                            }
                        } else {
                            echo "Error en la consulta: " . mysqli_error($conexion);
                        }
                        $sql_f_destino = "SELECT MAX(id_factura) as ultima_factura FROM facturas_cot";
                        $resultado_f_destino = mysqli_query($conexion_destino, $sql_f_destino);
                        if ($resultado_f_destino) {
                            $fila_destino = mysqli_fetch_assoc($resultado_f_destino);
                            $ultima_factura_destino = $fila_destino['ultima_factura'];
                            if ($ultima_factura_destino !== null) {
                                $id_factura_destino =  $ultima_factura_destino + 1;;
                            } else {
                                $id_factura_destino = 1;
                            }
                        } else {
                            echo "Error en la consulta: " . mysqli_error($conexion_destino);
                        }
                        //marketplace
                        $sql_f_marketplace = "SELECT MAX(id_factura) as ultima_factura FROM facturas_cot";
                        $resultado_f_marketplace = mysqli_query($conexion_marketplace, $sql_f_marketplace);
                        if ($resultado_f_marketplace) {
                            $fila_marketplace = mysqli_fetch_assoc($resultado_f_marketplace);
                            $ultima_factura_marketplace = $fila_marketplace['ultima_factura'];
                            if ($ultima_factura_marketplace !== null) {
                                $id_factura_marketplace =  $ultima_factura_marketplace + 1;;
                            } else {
                                $id_factura_marketplace = 1;
                            }
                        } else {
                            echo "Error en la consulta: " . mysqli_error($conexion_marketplace);
                        }
                        //echo "INSERT INTO detalle_fact_cot VALUES (NULL,'$id_factura','$factura','$id_producto','$cantidad','$desc_tmp','$precio_venta_r','$drogshipin')";
                        $insert_detail = mysqli_query($conexion, "INSERT INTO detalle_fact_cot VALUES (NULL,'$id_factura','$factura','$id_producto','$cantidad','$desc_tmp','$precio_venta_r','$drogshipin','$id_producto_origen')");
                        $insert_detail = mysqli_query($conexion_destino, "INSERT INTO detalle_fact_cot VALUES (NULL,'$id_factura_destino','$factura_destino','$id_producto_origen','$cantidad','$desc_tmp','$precio_venta_r','$drogshipin','$id_producto_origen')");
                        $insert_detail = mysqli_query($conexion_marketplace, "INSERT INTO detalle_fact_cot VALUES (NULL,'$id_factura_marketplace','$factura_marketplace','$id_marketplace','$cantidad','$desc_tmp','$precio_venta_r','$drogshipin','$id_producto_origen')");
                    }
                    // Fin de la consulta Principal
                    $subtotal      = number_format($sumador_total, 2, '.', '');
                    $total_iva     = ($subtotal * $impuesto) / 100;
                    $total_iva     = number_format($total_iva, 2, '.', '') - number_format($t_iva, 2, '.', '');
                    $total_factura = $subtotal + $total_iva;
                    $contenido .= ' %3a%0A ' . '*Total Pedido: * $' . number_format($total_factura, 2);
                    //echo "INSERT INTO facturas_cot VALUES (NULL,'$factura','$date_added','$id_cliente','$id_vendedor','$condiciones','$total_factura','$estado','$users','$validez','1')";
                    $sql = "INSERT INTO `facturas_cot` ( `numero_factura`, `fecha_factura`, `id_cliente`, `id_vendedor`, `condiciones`, `monto_factura`, `estado_factura`, `id_users_factura`, `validez`, `id_sucursal`, `nombre`, `telefono`, `provincia`, `c_principal`, `ciudad_cot`, `c_secundaria`, `referencia`, `observacion`, `guia_enviada`, `transporte`, `drogshipin`, `tienda`) "
                        . "VALUES ( '$factura', '$date_added', '$id_cliente', '$id_vendedor', '$condiciones', '$total_factura', '$estado', '$users', '$validez', '1', '$nombre', '$telefono', '$provincia', '$calle_principal', '$ciudad', '$calle_secundaria', '$referencia', '$observacion', '0', '', 1,'$tienda'); ";
                    // echo $sql;
                    $insert      = mysqli_query($conexion, $sql);
                    $ultimo_id = mysqli_insert_id($conexion);

                    if (
                        isset($_SERVER['HTTPS']) &&
                        ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
                        isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
                        $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'
                    ) {
                        $protocol = 'http://';
                    } else {
                        $protocol = 'http://';
                    }
                    //$image_path = str_replace('../..', 'sysadmin', $image_path);
                    $server_url = $protocol . $_SERVER['HTTP_HOST'];
                    $sql_destino = "INSERT INTO `facturas_cot` ( `numero_factura`, `fecha_factura`, `id_cliente`, `id_vendedor`, `condiciones`, `monto_factura`, `estado_factura`, `id_users_factura`, `validez`, `id_sucursal`, `nombre`, `telefono`, `provincia`, `c_principal`, `ciudad_cot`, `c_secundaria`, `referencia`, `observacion`, `guia_enviada`, `transporte`, `drogshipin`, `tienda`, `id_factura_origen`) "
                        . "VALUES ( '$factura_destino', '$date_added', '$id_cliente', '$id_vendedor', '$condiciones', '$total_factura', '$estado', '$users', '$validez', '1', '$nombre', '$telefono', '$provincia', '$calle_principal', '$ciudad', '$calle_secundaria', '$referencia', '$observacion', '0', '', 3,'$server_url','$ultimo_id'); ";
                    // echo $sql_destino;
                    $insert_destino      = mysqli_query($conexion_destino, $sql_destino);
                    $sql_marketplace = "INSERT INTO `facturas_cot` ( `numero_factura`, `fecha_factura`, `id_cliente`, `id_vendedor`, `condiciones`, `monto_factura`, `estado_factura`, `id_users_factura`, `validez`, `id_sucursal`, `nombre`, `telefono`, `provincia`, `c_principal`, `ciudad_cot`, `c_secundaria`, `referencia`, `observacion`, `guia_enviada`, `transporte`, `drogshipin`, `tienda`, `id_factura_origen`) "
                        . "VALUES ( '$factura_marketplace', '$date_added', '$id_cliente', '$id_vendedor', '$condiciones', '$total_factura', '$estado', '$users', '$validez', '1', '$nombre', '$telefono', '$provincia', '$calle_principal', '$ciudad', '$calle_secundaria', '$referencia', '$observacion', '0', '', 3,'$server_url','$ultimo_id'); ";
                    // echo $sql_marketplace;
                    $insert_destino      = mysqli_query($conexion_marketplace, $sql_marketplace);
                }
            }
        }

        $delete        = mysqli_query($conexion, "DELETE FROM tmp_cotizacion WHERE session_id='" . $session_id . "'");
        //header("Location: ../gracias.php");
        // SI TODO ESTA CORRECTO
        //echo 'funciona';

        echo '<script>window.location.href = "sysadmin/vistas/html/bitacora_cotizacion_new.php";</script>';
    }
    ?>