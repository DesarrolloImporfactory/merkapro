<!doctype html>
<?php
session_start();

require_once "sysadmin/PHPMailer/PHPMailer.php";
require_once "sysadmin/PHPMailer/SMTP.php";
require_once "sysadmin/PHPMailer/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

require_once "sysadmin/vistas/db.php";
//echo DB_HOST;
require_once "sysadmin/vistas/php_conexion.php";
require_once "sysadmin/vistas/funciones.php";

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $or_marketplace = 'http://localhost/';
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

// echo 'sysadmin/vistas/ajax/banner/'.get_row('perfil', 'banner', 'id_perfil', 1);
$id_producto = 0;
$pagina = 'gracias';
include './auditoria.php';
include './includes/style.php';
//include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['session'])) {
    $errors[] = "ID VACIO";
} else if (!empty($_POST['cliente'])) {

    $session_id     = $_POST['session'];
    $nombre     = $_POST['nombre'];
    $telefono    = $_POST['telefono'];
    $calle_principal    = $_POST['calle_principal'];
    $calle_secundaria    = $_POST['calle_secundaria'];
    $referencia    = $_POST['referencia'];
    $provincia     = $_POST['provinica'];
    $ciudad     = $_POST['ciudad'];
    $observacion     = $_POST['observacion'];

    $simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
    $contenido = '';
    $pais = get_row('perfil', 'pais', 'id_perfil', 1);
    if ($pais == 1) {
        $direccion = get_row('provincia_laar', 'provincia', 'codigo_provincia', $provincia) . ' ' . get_row('ciudad_cotizacion', 'ciudad', 'id_cotizacion', $ciudad) . ' ' . $calle_principal . ' ' . $calle_secundaria . ' ' . $referencia;
    } else {
        $direccion = get_row('provincia_laar', 'provincia', 'codigo_provincia', $provincia) . ' ' .  $ciudad . ' ' . $calle_principal . ' ' . $calle_secundaria . ' ' . $referencia;
    }

    //Comprobamos si hay archivos en la tabla temporal
    // echo "select * from tmp_ventas where session_id='" . $session_id . "'";
    $sql_count = mysqli_query($conexion, "select * from tmp_ventas where session_id='" . $session_id . "'");
    $count     = mysqli_num_rows($sql_count);

    // escaping, additionally removing everything that could be (html/javascript-) code
    $id_cliente     = intval($_POST['cliente']);
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
    $query_id_marketplace = mysqli_query($conexion_marketplace, "SELECT RIGHT(numero_factura,6) as factura FROM facturas_cot ORDER BY factura DESC LIMIT 1")
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
    } else {
        $factura_marketplace = 1;
    }

    $buat_id = str_pad($factura, 6, "0", STR_PAD_LEFT);
    $factura = "COT-$buat_id";
    // fin de numero de fatura
    // 
    // $buat_id_marketplace = str_pad($factura_marketplace, 6, "0", STR_PAD_LEFT);
    $buat_id_marketplace = str_pad($factura_marketplace, 6, "0", STR_PAD_LEFT);
    $factura_marketplace = "COT-$buat_id_marketplace";
    // consulta principal
    $nums          = 1;
    $impuesto      = get_row('perfil', 'impuesto', 'id_perfil', 1);
    $sumador_total = 0;
    $sum_total     = 0;
    $t_iva         = 0;
    //echo  "select * from productos, tmp_ventas where productos.id_producto=tmp_ventas.id_producto and tmp_ventas.session_id='" . $session_id . "'";
    $sql           = mysqli_query($conexion, "select * from productos, tmp_ventas where drogshipin_tmp=0 and productos.id_producto=tmp_ventas.id_producto and tmp_ventas.session_id='" . $session_id . "'");
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
    //echo $server_url;

    $contenido_productos = "";
    if ($resultado > 0) {
        while ($row = mysqli_fetch_array($sql)) {
            $id_tmp          = $row["id_tmp"];
            $id_producto     = $row['id_producto'];
            $codigo_producto = $row['codigo_producto'];
            $cantidad        = $row['cantidad_tmp'];
            $drogshipin        = $row['drogshipin_tmp'];
            $desc_tmp        = $row['desc_tmp'];
            $nombre_producto = $row['nombre_producto'];
            $contenido_productos .= ' %3a%0A ' . $nombre_producto . ' x ' . $cantidad;
            //echo $contenido;
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
            $sql_f_marketplace = "SELECT MAX(id_factura) as ultima_factura FROM facturas_cot";
            $resultado_f_marketplace = mysqli_query($conexion_marketplace, $sql_f_marketplace);
            if ($resultado_f_marketplace) {

                $fila_marketplace = mysqli_fetch_assoc($resultado_f_marketplace);
                $ultima_factura_marketplace = $fila_marketplace['ultima_factura'];

                if ($ultima_factura_marketplace !== null) {
                    $id_factura_marketplace =  $ultima_factura_marketplace + 1;
                    //  echo $id_factura_marketplace;
                } else {
                    $id_factura_marketplace = 1;
                }
            } else {
                echo "Error en la consulta: " . mysqli_error($conexion_marketplace);
            }
            //Insert en la tabla detalle_factura
            // echo "INSERT INTO detalle_fact_cot VALUES (NULL,'$id_factura','$factura','$id_producto','$cantidad','$desc_tmp','$precio_venta_r')";
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
FROM productos, tmp_ventas 
WHERE drogshipin_tmp=1 
    AND productos.id_producto=tmp_ventas.id_producto 
    AND tmp_ventas.session_id='$session_id'
GROUP BY tienda;";

    // echo $sql_productos;


    $sql_producto_tienda = mysqli_query($conexion, $sql_productos);

    if ($sql_producto_tienda) {

        while ($row_tienda = mysqli_fetch_assoc($sql_producto_tienda)) {
            $tienda         = $row_tienda["tienda"];

            if ($_SERVER['HTTP_HOST'] == 'localhost') {
                $or_marketplace = 'http://localhost/';
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

            $query_id_marketplace = mysqli_query($conexion_marketplace, "SELECT RIGHT(numero_factura,6) as factura FROM facturas_cot ORDER BY factura DESC LIMIT 1")
                or die('error ' . mysqli_error($conexion_marketplace));

            $count = mysqli_num_rows($query_id);
            $count_destino = mysqli_num_rows($query_id_destino);
            $count_marketplace = mysqli_num_rows($query_id_marketplace);

            if ($count_marketplace != 0) {

                $data_id_marketplace = mysqli_fetch_assoc($query_id_marketplace);
                $factura_marketplace = $data_id_marketplace['factura'] + 1;
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
            $sql           = mysqli_query($conexion, "select * from productos, tmp_ventas where tienda='$tienda' and  drogshipin_tmp=1 and productos.id_producto=tmp_ventas.id_producto and tmp_ventas.session_id='" . $session_id . "'");
            $resultado = mysqli_num_rows($sql);
            $contenido_productos = "";
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
                    $contenido_productos .= ' %3a%0A ' . $nombre_producto . ' x ' . $cantidad;
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
                    //$sql_insertar_detalle="INSERT INTO detalle_fact_cot VALUES (NULL,'$id_factura_destino','$factura_destino','$id_producto_origen','$cantidad','$desc_tmp','$precio_venta_r','$drogshipin','$id_producto_origen')";
                    $insert_detail = mysqli_query($conexion_destino, "INSERT INTO detalle_fact_cot VALUES (NULL,'$id_factura_destino','$factura_destino','$id_producto_origen','$cantidad','$desc_tmp','$precio_venta_r','$drogshipin','$id_producto_origen')");
                    // echo "INSERT INTO detalle_fact_cot VALUES (NULL,'$id_factura_marketplace','$factura_marketplace','$id_marketplace','$cantidad','$desc_tmp','$precio_venta_r','$drogshipin','$id_producto_origen')";
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
                    $protocol = 'https://';
                } else {
                    $protocol = 'http://';
                }
                //$image_path = str_replace('../..', 'sysadmin', $image_path);

                $server_url = $protocol . $_SERVER['HTTP_HOST'];

                $sql_destino = "INSERT INTO `facturas_cot` ( `numero_factura`, `fecha_factura`, `id_cliente`, `id_vendedor`, `condiciones`, `monto_factura`, `estado_factura`, `id_users_factura`, `validez`, `id_sucursal`, `nombre`, `telefono`, `provincia`, `c_principal`, `ciudad_cot`, `c_secundaria`, `referencia`, `observacion`, `guia_enviada`, `transporte`, `drogshipin`, `tienda`, `id_factura_origen`) "
                    . "VALUES ( '$factura_destino', '$date_added', '$id_cliente', '$id_vendedor', '$condiciones', '$total_factura', '$estado', '$users', '$validez', '1', '$nombre', '$telefono', '$provincia', '$calle_principal', '$ciudad', '$calle_secundaria', '$referencia', '$observacion', '0', '', 3,'$server_url','$ultimo_id'); ";
                // echo $sql;

                $insert_destino      = mysqli_query($conexion_destino, $sql_destino);



                $sql_marketplace = "INSERT INTO `facturas_cot` ( `numero_factura`, `fecha_factura`, `id_cliente`, `id_vendedor`, `condiciones`, `monto_factura`, `estado_factura`, `id_users_factura`, `validez`, `id_sucursal`, `nombre`, `telefono`, `provincia`, `c_principal`, `ciudad_cot`, `c_secundaria`, `referencia`, `observacion`, `guia_enviada`, `transporte`, `drogshipin`, `tienda`, `id_factura_origen`) "
                    . "VALUES ( '$factura_marketplace', '$date_added', '$id_cliente', '$id_vendedor', '$condiciones', '$total_factura', '$estado', '$users', '$validez', '1', '$nombre', '$telefono', '$provincia', '$calle_principal', '$ciudad', '$calle_secundaria', '$referencia', '$observacion', '0', '', 3,'$server_url','$ultimo_id'); ";
                // echo $sql;

                $insert_destino      = mysqli_query($conexion_marketplace, $sql_marketplace);
            }
        }
    }

    $delete        = mysqli_query($conexion, "DELETE FROM tmp_ventas WHERE session_id='" . $session_id . "'");
    //header("Location: ../gracias.php");
    // SI TODO ESTA CORRECTO
    // enviar correo
    $correo_sql = "SELECT * FROM users where id_users='1'";
    $correo_result = mysqli_query($conexion, $correo_sql);
    $correo = mysqli_fetch_assoc($correo_result);
    $correo = $correo['email_users'];

    if ($correo === "root@admin.com") {
    } else {
        require_once "sysadmin/PHPMailer/Mail_pedido.php";
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug = $smtp_debug;
        $mail->Host = $smtp_host;
        $mail->SMTPAuth = true;
        $mail->Username = $smtp_user;
        $mail->Password = $smtp_pass;
        $mail->Port = 465;
        $mail->SMTPSecure = $smtp_secure;

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->setFrom($smtp_from, $smtp_from_name);
        $mail->addAddress($correo);
        $mail->Subject = 'Nuevo Pedido';
        $mail->Body = $message_body_pedido;


        if ($mail->send()) {
            //echo "Correo enviado";
        } else {
            echo "Error al enviar el correo: " . $mail->ErrorInfo;
        }
    }
}

//comprobacion de destacados
$consultaDestacados = "SELECT COUNT(*) AS total FROM productos WHERE destacado = '1'";
$resultadoDestacados = mysqli_query($conexion, $consultaDestacados);
$filaDestacados = mysqli_fetch_assoc($resultadoDestacados);

if ($filaDestacados['total'] == 0) {
    // No hay productos destacados, así que actualizamos 3 productos aleatoriamente
    $actualizarDestacados = "UPDATE productos SET destacado = '1' ORDER BY RAND() LIMIT 3";
    $resultadoActualizacion = mysqli_query($conexion, $actualizarDestacados);

    if ($resultadoActualizacion) {
        echo "Se han actualizado 3 productos como destacados.";
    } else {
        echo "Hubo un error al actualizar los productos destacados: " . mysqli_error($conexion);
    }
}
?>

<html>
<?php
include './includes/head_1.php';
?>
<link href="css_nuevo/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
<!-- librerias para el carrusel-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<!-- Fin librerias para el carrusel-->

<meta name="theme-color" content="#7952b3">



<link href="css_nuevo/carousel.css" rel="stylesheet" type="text/css" />
</head>

<style>
    html,
    body {
        height: 100%;
        margin: 0;
        padding-bottom: 0 !important;
    }

    body {
        display: flex;
        flex-direction: column;
    }

    main {
        flex: 1 0 auto;
        /* La página principal ocupa el espacio necesario */
    }

    .footer-contenedor {
        flex-shrink: 0;
        /* Esto asegura que el footer no se encoja */
    }

    .owl-carousel .owl-stage-outer {
        margin: 0 auto !important;
    }
</style>

<body>

    <header>
        <nav id="navbarId" style="height: 100px" class="navbar navbar-expand-lg  fixed-top superior ">
            <div class="container">
                <div>
                    <ul class="navbar-nav mr-auto menu_izquierda" style="padding-right: 15px;">
                        <li class="nav-item active">
                            <a class="nav-link texto_cabecera" href="<?php echo $protocol ?>://<?php echo $domain ?>">Inicio <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link texto_cabecera" href="<?php echo $protocol ?>://<?php echo $domain ?>/categoria_1.php">Catálogo</a>
                        </li>
                    </ul>
                </div>
                <!-- Logo en el centro para todas las vistas -->
                <a class="navbar-brand" href="#"><a class="navbar-brand_1" href="<?php echo $protocol ?>://<?php echo $domain ?>"><img id="navbarLogo" class="" style="vertical-align: top; height: 100px; width: 100px;" src="<?php
                                                                                                                                                                                                                                if (empty(get_row('perfil', 'logo_url', 'id_perfil', '1'))) {
                                                                                                                                                                                                                                    echo "assets/img/imporsuit.png";
                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                    echo "sysadmin" . str_replace("../..", "", get_row('perfil', 'logo_url', 'id_perfil', '1'));
                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                ?>" alt="Imagen" /></a></a>

                <button class="navbar-toggler" id="menuButton">
                    <i class="fas fa-bars" style="color: white; text-shadow: 0px 0px 3px #fff;"></i>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navbarResponsive" style="padding-left: 10px; padding-right: 10px; justify-content: flex-end;">
                <!-- Elementos a la izquierda -->
                <ul class="navbar-nav mr-auto menu_derecha" style="padding-right: 15px;">
                    <li class="nav-item active">
                        <a class="nav-link texto_cabecera" href="<?php echo $protocol ?>://<?php echo $domain ?>">Inicio <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link texto_cabecera" href="<?php echo $protocol ?>://<?php echo $domain ?>/categoria_1.php">Catálogo</a>
                    </li>

                </ul>
                <!-- Elementos a la derecha -->
                <ul class="navbar-nav">
                    <form id="searchForm">
                        <div class="search-box">
                            <input type="text" id="searchInput" class="search-input" placeholder="Buscar" required>
                            <button type="submit" class="search-button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <div id="suggestions" class="suggestions-dropdown" style="display: none; background-color: white; border-radius: 0.5rem; padding-left:10px;">
                            <!-- Las sugerencias se insertarán aquí -->
                        </div>
                    </form>

                    <script>
                        // Autocompletar sugerencias
                        document.getElementById('searchInput').addEventListener('input', function() {
                            var inputVal = this.value;

                            // Ocultar sugerencias si no hay valor
                            if (inputVal.length === 0) {
                                document.getElementById('suggestions').style.display = 'none';
                                return;
                            }

                            // Realizar la solicitud AJAX al script PHP para obtener sugerencias
                            fetch('/sysadmin/vistas/ajax/search_index.php', {
                                    method: 'POST',
                                    body: new URLSearchParams('query=' + inputVal)
                                })
                                .then(response => response.json())
                                .then(data => {
                                    var suggestionsContainer = document.getElementById('suggestions');
                                    suggestionsContainer.innerHTML = '';
                                    suggestionsContainer.style.display = 'block';

                                    // Agregar las sugerencias al contenedor
                                    data.forEach(function(item) {
                                        var div = document.createElement('div');
                                        div.innerHTML = item.nombre_producto; // Asumiendo que 'nombre_producto' es lo que quieres mostrar
                                        div.onclick = function() {
                                            // Al hacer clic, se actualiza el input y se redirige
                                            document.getElementById('searchInput').value = this.innerText;
                                            window.location.href = 'producto_1.php?id=' + item.id_producto;
                                        };
                                        suggestionsContainer.appendChild(div);
                                    });
                                })
                                .catch(error => console.error('Error:', error));
                        });

                        // Evento submit del formulario
                        document.getElementById('searchForm').addEventListener('submit', function(event) {
                            event.preventDefault();
                            var searchQuery = document.getElementById('searchInput').value;
                            // Aquí puedes manejar la búsqueda, por ejemplo, redirigir a una página de resultados
                            window.location.href = '/busqueda.php?query=' + encodeURIComponent(searchQuery);
                        });
                    </script>
                </ul>
            </div>

            <script>
                // Obtener el botón y el menú
                var menuButton = document.getElementById('menuButton');
                var menu = document.getElementById('navbarResponsive');

                // Función para alternar la visibilidad del menú
                function toggleMenu() {
                    if (menu.classList.contains('show')) {
                        menu.classList.remove('show');
                    } else {
                        menu.classList.add('show');
                    }
                }

                // Evento click para el botón del menú
                menuButton.onclick = function() {
                    toggleMenu();
                };

                // Opcional: cerrar el menú si se hace clic fuera de él
                window.onclick = function(event) {
                    if (!menu.contains(event.target) && !menuButton.contains(event.target)) {
                        menu.classList.remove('visible');
                    }
                };
            </script>

        </nav>
    </header>
    <main style="background-color: #f9f9f9; padding-top: 100px; padding-bottom:30px;">
        <div class="contenido">
            <div style="text-align: center; font-size: 70px">
                <input type="hidden" id="nombre" name='nombre' value="<?php echo $nombre; ?>">
                <input type="hidden" id="telefono" value="<?php echo $telefono; ?>">
                <input type="hidden" id="direccion" value="<?php echo $direccion; ?>">
                <input type="hidden" id="contenido" value="<?php echo $contenido_productos; ?>">

                <?php
                echo get_row('gracias', 'contenido', 'id_gacias', 1);
                ?>
            </div>
            <div class="container mt-4">
                <h2 style="text-align: center">Productos que te podrian interesar</h2>
                <br>

                <!-- Productos -->
                <div class="owl-carousel owl-theme" style="margin-bottom: 50px; display:flex;">
                    <?php
                    $sql = "SELECT * FROM productos WHERE destacado=1";
                    $query = mysqli_query($conexion, $sql);
                    $num_registros = mysqli_num_rows($query);
                    //echo $num_registros, ' Productos';
                    while ($row = mysqli_fetch_array($query)) {
                        $id_producto          = $row['id_producto'];
                        $codigo_producto      = $row['codigo_producto'];
                        $nombre_producto      = $row['nombre_producto'];
                        $descripcion_producto = $row['descripcion_producto'];
                        $linea_producto       = $row['id_linea_producto'];
                        $med_producto         = $row['id_med_producto'];
                        $id_proveedor         = $row['id_proveedor'];
                        $inv_producto         = $row['inv_producto'];
                        $impuesto_producto    = $row['iva_producto'];
                        $costo_producto       = $row['costo_producto'];
                        $utilidad_producto    = $row['utilidad_producto'];
                        $precio_producto      = $row['valor1_producto'];
                        $precio_mayoreo       = $row['valor2_producto'];
                        $precio_especial      = $row['valor3_producto'];
                        $precio_normal      = $row['valor4_producto'];
                        $stock_producto       = $row['stock_producto'];
                        $stock_min_producto   = $row['stock_min_producto'];
                        $online   = $row['pagina_web'];
                        $status_producto      = $row['estado_producto'];
                        $date_added           = date('d/m/Y', strtotime($row['date_added']));
                        $image_path           = $row['image_path'];
                        $id_imp_producto      = $row['id_imp_producto'];

                    ?>
                        <div class="item">
                            <div class="grid-container">
                                <div class="card" style="border-radius: 1rem; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);">
                                    <!-- Use inline styles or a dedicated class in your stylesheet to set the aspect ratio -->
                                    <div class="img-container" style="aspect-ratio: 1 / 1; overflow: hidden; margin-bottom: -120px"><a href="producto_1.php?id=<?php echo $id_producto ?>">
                                            <img src=" <?php
                                                        $subcadena = "http";

                                                        if (strpos(strtolower($image_path), strtolower($subcadena)) === 0) {
                                                        ?>
                  <?php echo  $image_path . '"'; ?>
                <?php
                                                        } else {
                ?>
                 sysadmin/<?php echo str_replace("../..", "", $image_path) ?>" <?php
                                                                            }
                                                                                ?> src="<?php
                                                                                        $subcadena = "http";

                                                                                        if (strpos(strtolower($image_path), strtolower($subcadena)) === 0) {
                                                                                        ?>
                <?php echo  $image_path . '"'; ?>
                <?php
                                                                                        } else {
                ?>
               sysadmin/<?php echo str_replace("../..", "", $image_path) ?>" <?php
                                                                                        }
                                                                                ?> class="card-img-top mx-auto d-block" alt="Product Name" style="object-fit: cover; width: 55%; height: 55%; margin-top: 10px;">

                                        </a>
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <p class="card-text flex-grow-1"><a href="producto_1.php?id=<?php echo $id_producto ?>" style="text-decoration: none; color:black;"><strong><?php echo $nombre_producto ?></strong></a></p>
                                        <div class="product-footer mb-2">
                                            <div class="d-flex flex-row">
                                                <div>
                                                    <span style="font-size: 15px; color:#4461ed; padding-right: 10px;">
                                                        <strong><?php echo get_row('perfil', 'moneda', 'id_perfil', 1) . number_format($precio_especial, 2); ?></strong>
                                                    </span>
                                                </div>
                                                <div>
                                                    <?php if ($precio_normal > 0) { ?>
                                                        <span class="tachado" style="font-size: 15px; padding-right: 10px;">
                                                            <strong><?php echo get_row('perfil', 'moneda', 'id_perfil', 1) . number_format($precio_normal, 2); ?></strong>
                                                        </span>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <?php if ($precio_normal > 0) { ?>
                                                    <div class="px-2" style="background-color: #4464ec; color:white; border-radius: 0.3rem;">


                                                        <span style="font-size: 15px;"><i class="bx bxs-purchase-tag"></i>
                                                            <strong>AHORRA UN <?php echo number_format(100 - ($precio_especial * 100 / $precio_normal)); ?>%</strong>
                                                        </span>

                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <a style="z-index:2; height: 40px; font-size: 16px" class="btn boton texto_boton mt-2" href="producto_1.php?id=<?php echo $id_producto ?>">Comprar</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php
                    }

                    ?>
                </div>
                <script>
                    $(document).ready(function() {
                        $(".owl-carousel").owlCarousel({
                            loop: false, // Establece a 'true' si quieres que el carrusel sea infinito
                            margin: 10, // Espacio entre elementos (tarjetas)
                            responsive: {
                                0: {
                                    items: 1 // En pantallas muy pequeñas, muestra 1 elemento
                                },
                                576: { // Dispositivos extra pequeños (por ejemplo, teléfonos), se muestra 1 item
                                    items: 2 // En pantallas medianas, muestra 2 elementos
                                },
                                768: { // Dispositivos pequeños (por ejemplo, tablets), se muestran 2 items
                                    items: 2 // En pantallas medianas, muestra 2 elementos
                                },
                                992: { // Dispositivos medianos (por ejemplo, laptops), se muestran 3 items
                                    items: 3 // En pantallas grandes, muestra 3 elementos
                                },
                                1200: { // Dispositivos grandes (por ejemplo, computadoras de escritorio), se muestran 4 items
                                    items: 4 // Aquí le indicas que muestre 4 elementos
                                }
                            },
                            nav: true, // Para mostrar las flechas de navegación
                            navText: [
                                '<i class="fas fa-chevron-left"></i>',
                                '<i class="fas fa-chevron-right"></i>'
                            ] // Puedes personalizar el texto o el HTML de las flechas aquí
                        });
                    });
                </script>
                <!-- Fin Productos -->
            </div>
        </div>
    </main>
    <!-- FOOTER -->
    <!-- Botón flotante para WhatsApp -->
    <?php
    function formatPhoneNumber($number)
    {
        // Eliminar caracteres no numéricos excepto el signo +
        $number = preg_replace('/[^\d+]/', '', $number);

        // Verificar si el número ya tiene el código de país +593
        if (!preg_match('/^\+593/', $number)) {
            // Si el número comienza con 0, quitarlo
            if (strpos($number, '0') === 0) {
                $number = substr($number, 1);
            }
            // Agregar el código de país +593 al inicio del número
            $number = '+593' . $number;
        }

        return $number;
    }

    // Usar la función formatPhoneNumber para imprimir el número formateado
    $telefono = get_row('perfil', 'telefono', 'id_perfil', 1);
    $telefonoFormateado = formatPhoneNumber($telefono);
    ?>

    <?php
    $ws_flotante = get_row('perfil', 'whatsapp_flotante', 'id_perfil', 1);
    if ($ws_flotante == 1) { ?>
        <a href="https://wa.me/<?php echo $telefonoFormateado ?>" class="whatsapp-float" target="_blank"><i class="bx bxl-whatsapp-square ws_flotante"></i></a>
    <?php } ?>

    <footer>
        <?php
        $sql   = "SELECT * FROM  perfil  where id_perfil=1";
        $query = mysqli_query($conexion, $sql);
        while ($row = mysqli_fetch_array($query)) {
            $nombre_empresa       = $row['nombre_empresa'];
            $giro_empresa       = $row['giro_empresa'];
            $telefono       = $row['telefono'];
            $email       = $row['email'];
            $logo_url       = $row['logo_url'];
            $facebook       = $row['facebook'];
            $instagram       = $row['instagram'];
            $tiktok       = $row['tiktok'];

        ?>
            <div class="d-flex flex-column">
                <div class="footer-contenedor">
                    <div class="footer-contenido div-alineado-izquierda">
                        <h4>Acerca de <?php echo $nombre_empresa ?></h4>
                        <img id="navbarLogo" src="sysadmin/<?php echo str_replace("../..", "", $logo_url)
                                                            ?>">
                        <span class="descripcion">
                            <?php echo $giro_empresa ?>
                        </span>
                    </div>
                    <div class="footer-contenido">
                        <h5>Legal</h5>
                        <ul class="lista_legal">
                            <?php
                            $sql   = "SELECT * FROM  politicas_empresa";
                            $query = mysqli_query($conexion, $sql);
                            while ($row = mysqli_fetch_array($query)) {
                                $nombre_politica       = $row['nombre'];
                                $id_politica       = $row['id_politica'];
                            ?>
                                <li><a style="text-decoration: none; color:#5a5a5a" href="<?php echo $protocol ?>://<?php echo $domain ?>/politicas.php?id=<?php echo $id_politica ?>" target="_blank"><?php echo $nombre_politica; ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="footer-contenido">
                        <h5>Siguenos</h5>
                        <div class="redes">
                            <?php if ($facebook  !== "") { ?>
                                <a class="icon-redes" href="<?php echo $facebook ?>">
                                    <img src="https://img.icons8.com/color/48/000000/facebook.png" alt="facebook">
                                </a>
                            <?php } ?>
                            <?php if ($instagram  !== "") { ?>
                                <a class="icon-redes" href="<?php echo $instagram ?>">
                                    <img src="https://img.icons8.com/color/48/000000/instagram-new.png" alt="instagram">
                                </a>
                            <?php } ?>
                            <?php if ($tiktok  !== "") { ?>
                                <a class="icon-redes" href="<?php echo $tiktok ?>">
                                    <img src="https://img.icons8.com/color/48/000000/tiktok.png" alt="tiktok">
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="footer-contenido">
                        <h5>
                            Información de contacto
                        </h5>
                        <span class="descripcion">
                            <span class="icons">
                                <i class='bx bxl-whatsapp ws'></i> <?php echo $telefono ?>
                            </span>
                            <span class="icons">
                                <i class='bx bx-mail-send send'></i><?php echo $email ?>
                            </span>
                        </span>
                    </div>
                <?php } ?>
                </div>
                <div class="text-center p-4 derechos-autor">© 2024 IMPORSUIT S.A. | Todos los derechos reservados.
                </div>
            </div>
    </footer>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="js_nuevo/bootstrap.bundle.min.js" type="text/javascript"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- librerias para el carrusel-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <!-- Fin librerias para el carrusel-->

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.bundle.min.js"></script>

    <script>
        window.onscroll = function() {
            var nav = document.getElementById('navbarId'); // Asegúrate de que el ID coincida con el ID de tu navbar
            var logo = document.getElementById("navbarLogo");
            logo.style.maxHeight = "60px"; // o el tamaño que desees para el logo
            logo.style.maxWidth = "60px"; // o el tamaño que desees para el logo
            if (window.pageYOffset > 100) {
                nav.style.height = "70px";
                // Aquí también puedes cambiar otros estilos si es necesario, como el tamaño del logo o de la fuente
            } else {
                nav.style.height = "100px";
                logo.style.maxHeight = "100px"; // tamaño original del logo
                logo.style.maxWidth = "100px"; // tamaño original del logo
                // Restablece los estilos si el usuario vuelve a la parte superior de la página
            }
        };
    </script>


    <script>
        window.onload = function() {
            //  alert();
            <?php if (get_row('perfil', 'whatsapp', 'id_perfil', '1')) { ?>

                enviar_registro();
            <?php } ?>
        };

        function enviar_registro() {

            //alert($("#contenido").val());
            whatsapp = '%3a%0A' + "<?php echo get_row('perfil', 'whatsapp', 'id_perfil', '1') ?>";

            nombre = '%3a%0A' + '*Nombre:* ' + $("#nombre").val();
            //  alert('entro');
            telefono = '%3a%0A' + '*Celular:* ' + ($("#telefono").val());

            direccion = '%3a%0A' + '*Dirección:* ' + ($("#direccion").val());
            comentario = '%3a%0A' + '*Productos:* ' + ($("#contenido").val());

            //Producto 1%3a* SOLUTION PACK "PRIMEROS FRIOS"%0A*Cantidad%3a*1%20%0A*Precio%3a* %241500%0A%0A*Total*%3a %241500%0A%0APor favor tengan a bien responder para coordinar la entrega.&source=&data=&app_absent=
            variable = 'https://api.whatsapp.com/send?phone=' + <?php
                                                                echo get_row('perfil', 'whatsapp', 'id_perfil', '1');
                                                                ?> + '&text=Nuevo pedido' + nombre + telefono + direccion + comentario;
            window.location.href = variable;

            //window.open(variable,'width=400,height=300,resizable=yes');   


        }
    </script>

    <script>
        let total_venta = <?php echo $total_factura; ?>;
        fbq('track', 'Purchase', {
            value: total_venta,
            currency: 'USD'
        });
    </script>
</body>

</html>