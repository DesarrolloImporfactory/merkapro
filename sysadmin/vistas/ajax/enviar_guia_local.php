<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once "../db.php";
require_once "../php_conexion.php";
require_once "../funciones.php";
require_once "../funciones_destino.php";

// Configuración de la base de datos de destino
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $destino = mysqli_connect('localhost', 'root', '', 'master');
} else {
    $destino = mysqli_connect('localhost', 'imporsuit_marketplace', 'imporsuit_marketplace', 'imporsuit_marketplace');
}

if ($destino->connect_error) {
    die('Error en la conexión a la base de datos de destino: ' . $destino->connect_error);
}

$sql = "SELECT * FROM guia_laar order by id_guia desc limit 1";

$query = mysqli_query($destino, $sql);
$row_cnt = mysqli_num_rows($query);
if ($row_cnt > 0) {
    while ($row = mysqli_fetch_array($query)) {
        $numero_sig = $row['id_guia'] + 1;
        $guia_sistema = 'FAST' . $numero_sig;
    }
} else {
    $guia_sistema = "FAST1";
}
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

$date_added = date("Y-m-d H:i:s");

$sql = "INSERT INTO `guia_laar` (`tienda_venta`, `guia_sistema`, `guia_laar`, `fecha`, `zpl`, `tienda_proveedor`, `url_guia`, `estado_guia`, `id_transporte`) "
    . "VALUES ( '$server_url', '', '', '$date_added', '1.3', '1', '1',1, '2');";

$query = mysqli_query($destino, $sql);

$ultimoid_market = mysqli_insert_id($destino);
$ultimoid = 'FAST' . $ultimoid_market;
$sql_update = "UPDATE `guia_laar` SET `guia_sistema` = '$ultimoid' WHERE `guia_laar`.`id_guia` = $ultimoid_market";
//echo $sql_update;

$query_update = mysqli_query($destino, $sql_update);

//origen
$id_pedido_cot = $_POST['id_pedido_cot'];
$tipo_origen = get_row('facturas_cot', 'drogshipin', 'id_factura', $id_pedido_cot);

//echo $tipo_origen;
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $or_marketplace = 'http://localhost/marketplace/';
} else {
    $or_marketplace = 'https://marketplace.imporsuit.com/';
}
$archivo_origen = $or_marketplace . 'sysadmin/vistas/db1.php';
$contenido = file_get_contents($archivo_origen);
$archivo_destino = '../db_destino_marketplace.php';
if (file_put_contents($archivo_destino, $contenido) !== false) {
} else {
    echo "Error al guardar eddl JSON en el archivo.";
}
require_once "../php_conexion_marketplace_guia.php";

if ($tipo_origen == 1) {
    //echo'asddsa';
    //conexion a marketplace para guardar guia

    ///

    //conexion a marketplace para guardar guia
    $tienda         =  get_row('facturas_cot', 'tienda', 'id_factura', $id_pedido_cot);
    // echo 'entra'.$tienda;


    ///
    // conexion destino
    $archivo_tienda = $tienda . '/sysadmin/vistas/db1.php'; // Nombre del archivo original
    // echo $archivo_tienda;
    $contenido_tienda = file_get_contents($archivo_tienda);
    $archivo_destino_tienda = '../db_destino_guia.php'; // Nombre del archivo de destino
    //echo $archivo_destino_tienda;
    // $origen = fopen($archivo_origen_marketplace, 'r');
    if (file_put_contents($archivo_destino_tienda, $contenido_tienda) !== false) {
        //echo "El JSON se ha guardado correctamente en el archivo.";


    } else {
        echo "Error al guardar eddl JSON en el archivo.";
    }

    require_once "../php_conexion_destino_guia.php";

    $identificacionO = get_row_destino($conexion_destino, 'origen_laar', 'identificacion', 'id_origen', 1);
    $provinciaO = get_row_destino($conexion_destino, 'origen_laar', 'provinciaO', 'id_origen', 1);
    $ciudadO = get_row_destino($conexion_destino, 'origen_laar', 'ciudadO', 'id_origen', 1);
    $nombreO = get_row_destino($conexion_destino, 'origen_laar', 'nombreO', 'id_origen', 1);
    $direccionO = get_row_destino($conexion_destino, 'origen_laar', 'direccion', 'id_origen', 1);
    $refenciaO = get_row_destino($conexion_destino, 'origen_laar', 'referencia', 'id_origen', 1);
    $numeroCasaO = get_row_destino($conexion_destino, 'origen_laar', 'numeroCasa', 'id_origen', 1);
    $telefonoO = get_row_destino($conexion_destino, 'origen_laar', 'telefono', 'id_origen', 1);
    $celularO = get_row_destino($conexion_destino, 'origen_laar', 'celular', 'id_origen', 1);
} else {
    $tienda = $server_url;
    //echo $tienda;
    $identificacionO = get_row('origen_laar', 'identificacion', 'id_origen', 1);
    $provinciaO = get_row('origen_laar', 'provinciaO', 'id_origen', 1);
    $ciudadO = get_row('origen_laar', 'ciudadO', 'id_origen', 1);
    $nombreO = get_row('origen_laar', 'nombreO', 'id_origen', 1);
    $direccionO = get_row('origen_laar', 'direccion', 'id_origen', 1);
    $refenciaO = get_row('origen_laar', 'referencia', 'id_origen', 1);
    $numeroCasaO = get_row('origen_laar', 'numeroCasa', 'id_origen', 1);
    $telefonoO = get_row('origen_laar', 'telefono', 'id_origen', 1);
    $celularO = get_row('origen_laar', 'celular', 'id_origen', 1);
}

//echo $ciudadO;
//echo $celularO;

//destino
$nombre_destino = $_POST['nombre_destino'];
$ciudad_entrega = $_POST['ciudad'];
$direccion = $_POST['direccion'];
//echo $direccion;
$referencia = $_POST['referencia'];
$telefono = $_POST['telefono'];
$celular = $_POST['celular'];
$valorasegurado = $_POST['valorasegurado'];

$numerocasa = $_POST['numerocasa'];
$cod = $_POST['cod'];
$cod_guia = $cod;
$cod = filter_var($cod, FILTER_VALIDATE_BOOLEAN);

$seguro = $_POST['seguro'];
$observacion = $_POST['observacion'];
$costo_envio = $_POST['costo_envio'];

$fechaActual = date("m/y/Y");
//echo $fechaActual;

if ($seguro == 1) {
    $valorasegurado = $valorasegurado;
} else {
    $valorasegurado = 0;
}
$productos_guia = $_POST['productos_guia'];
$cantidad_total = $_POST['cantidad_total'];
//echo $cantidad_total;
$identificacion = $_POST['identificacion'];
$valor_total = $_POST['valor_total'];

$costo_total = $_POST['costo_total'];
if ($tipo_origen == 0) {
    $costo_total = 0;
}
// URL del servicio web al que deseas enviar los datos con el token
$destino_url = "https://fast.imporsuit.com/GenerarGuia/nueva/";
// Datos a enviar en formato JSON al servicio de destino
$cantidad_total_prducto = $cantidad_total;
$cantidad_total = 1;
$productos_guia =  $productos_guia;
$observacion = $observacion . ' -Por: ' . $server_url;
$datos_destino = array(
    "origen" => array(
        "identificacionO" => "$identificacionO",
        "ciudadO" => "$ciudadO",
        "nombreO" => "$nombreO",
        "direccion" => "$direccionO",
        "referencia" => "$refenciaO",
        "numeroCasa" => "$numeroCasaO",
        "postal" => "",
        "telefono" => "$telefonoO",
        "celular" => "$celularO"
    ),
    "destino" => array(
        "identificacionD" => "$identificacion",
        "ciudadD" => "$ciudad_entrega",
        "nombreD" => "$nombre_destino",
        "direccion" => "$direccion",
        "referencia" => "$referencia",
        "numeroCasa" => "$numerocasa",
        "postal" => "",
        "telefono" => "$telefono",
        "celular" => "$celular"
    ),
    "numeroGuia" => "$guia_sistema",
    "tipoServicio" => "201202002002013",
    "noPiezas" => $cantidad_total,
    "peso" => 2,
    "valorDeclarado" => $valorasegurado,
    "contiene" => "$productos_guia",
    "tamanio" => "",
    "cod" => $cod,
    "costoflete" => 0,
    "costoproducto" => $valor_total,
    "tipocobro" => 0,
    "comentario" => "$observacion",
    "fechaPedido" => "$fechaActual",
    "extras" => ""
);

// Configuración de la solicitud cURL para el servicio de destino
$ch = curl_init($destino_url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($datos_destino));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'X-Token-Guia: Zc46Um3cI8Eh9vce6hn9'
));


// Realizar la solicitud cURL al servicio de destino

$response = curl_exec($ch);


// Verificar si hubo errores en la solicitud
if (curl_errno($ch)) {
    echo 'Error en la solicitud cURL para el servicio de destino: ' . curl_error($ch);
}

// Cerrar la conexión cURL
curl_close($ch);



// Puedes trabajar con los datos de respuesta aquí


$id_pedido_cot = $_POST['id_pedido_cot'];



$guia = $guia_sistema;
$url = "https://fast.imporsuit.com/GenerarGuia/descargar/" . $guia_sistema . "/";
//$guia=1;
if (isset($guia)) {
    $sql_update = "UPDATE `facturas_cot` SET `guia_enviada` = '1', transporte='IMPORFAST'  WHERE `id_factura` = $id_pedido_cot";
    //echo $sql_update;
    $query_update = mysqli_query($conexion, $sql_update);

    $date_added = date("Y-m-d H:i:s");
    $sql_insertar_guia = "INSERT INTO `guia_laar` ( `tienda_venta`, `guia_sistema`, `guia_laar`, `fecha`, `zpl`, `tienda_proveedor`, `url_guia`,`id_pedido`, 
            `identificacionO`,`ciudadO`, `nombreO`,
            `direccionO`, `referenciaO`,`numeroCasaO`, 
            `postalO`,`telefonoO`, `celularO`,
            `identificacionD`, `ciudadD`,`nombreD`, 
            `direccionD`,`referenciaD`, `numeroCasaD`,
            `postalD`, `telefonoD`,`celularD`, 
            `tipoServicio`,`noPiezas`, `peso`,
            `valorDeclarado`, `contiene`,`cod` ,
            `costoflete`,`costoproducto`, `tipocobro`,
            `comentario`,`valor_costo`, `estado_guia`, `id_transporte`) 
        VALUES (  '$server_url', '$ultimoid', '$guia', '$date_added', '', '$tienda','$url','$id_pedido_cot',"
        . "'$identificacionO','$ciudadO','$nombreO',"
        . "'$direccionO','$refenciaO','$numeroCasaO',"
        . "'','$telefonoO','$celularO',"
        . "'$identificacion','$ciudad_entrega','$nombre_destino',"
        . "'$direccion','$referencia','$numerocasa',"
        . "'','$telefono','$celular',"
        . "'201202002002013','$cantidad_total','2',"
        . "'$valorasegurado','$productos_guia','$cod_guia','$costo_envio','$valor_total',"
        . "'0','$observacion','$costo_total',1, '2')";
    //echo $sql_insertar_guia;
    $query_insertar = mysqli_query($conexion, $sql_insertar_guia);
    /*
        // Grabar cabecera_cuenta_cobrar
        $id_factura = get_row('facturas_cot', 'id_factura', 'id_factura', $id_pedido_cot);

        $numero_factura         =  get_row('facturas_cot', 'numero_factura', 'id_factura', $id_pedido_cot);
        $estado_pedido =  get_row('facturas_cot', 'estado_factura', 'id_factura', $id_pedido_cot);
        $valor_base = get_row('ciudad_laar', 'precio', 'codigo', $ciudad_entrega);

        $total_guia = get_row('guia_laar', 'costoproducto', 'id_pedido', $id_factura);
        if (get_row('guia_laar', 'cod', 'id_pedido', $id_factura) == 1) {
            $valor_base = $valor_base + ($total_guia * 0.03);
        }
        if (get_row('guia_laar', 'valorDeclarado', 'id_pedido', $id_factura) > 1) {
            $valor_base = $valor_base + (get_row('guia_laar', 'valorDeclarado', 'id_pedido', $id_factura) * 0.01);
        }
        $costo_guia = get_row('guia_laar', 'valor_costo', 'id_pedido', $id_factura);
        $monto_recibir = $total_guia - $valor_base - $costo_guia;
        $sql_cc = "INSERT INTO `cabecera_cuenta_cobrar`(`numero_factura`, `fecha`, `cliente`, `tienda`, `estado_guia`, `estado_pedido`, `total_venta`, `costo`, `precio_envio`, `monto_recibir`) VALUES ('$numero_factura','$date_added','$nombre_destino','$server_url','2','$estado_pedido','$valor_total','$costo_total','$valor_base','$monto_recibir')";

        $query_insertar_cc = mysqli_query($conexion, $sql_cc);
        echo mysqli_error($conexion);
*/

    //ingresar guia destino
    $sql_insertar_guia_destino = "INSERT INTO `guia_laar` ( `tienda_venta`, `guia_sistema`, `guia_laar`, `fecha`, `zpl`, `tienda_proveedor`, `url_guia`,`id_pedido`, 
            `identificacionO`,`ciudadO`, `nombreO`,
            `direccionO`, `referenciaO`,`numeroCasaO`, 
            `postalO`,`telefonoO`, `celularO`,
            `identificacionD`, `ciudadD`,`nombreD`, 
            `direccionD`,`referenciaD`, `numeroCasaD`,
            `postalD`, `telefonoD`,`celularD`, 
            `tipoServicio`,`noPiezas`, `peso`,
            `valorDeclarado`, `contiene`,`cod` ,
            `costoflete`,`costoproducto`, `tipocobro`,
            `comentario`,`valor_costo`, `estado_guia`, `id_transporte`) 
        VALUES (  '$server_url', '$ultimoid', '$guia', '$date_added', '', '$tienda','$url','$id_pedido_cot',"
        . "'$identificacionO','$ciudadO','$nombreO',"
        . "'$direccionO','$refenciaO','$numeroCasaO',"
        . "'','$telefonoO','$celularO',"
        . "'$identificacion','$ciudad_entrega','$nombre_destino',"
        . "'$direccion','$referencia','$numerocasa',"
        . "'','$telefono','$celular',"
        . "'201202002002013','$cantidad_total','2',"
        . "'$valorasegurado','$productos_guia','$cod_guia','$costo_envio','$valor_total',"
        . "'0','$observacion','$costo_total',1, '2')";
    //echo $sql_insertar_guia_destino;
    //echo $tipo_origen;
    if ($tipo_origen == 1) {

        //echo "origen";
        $query_insertar_destino = mysqli_query($conexion_destino, $sql_insertar_guia_destino);
        $id_fact_destino = get_row_destino($conexion_destino, 'facturas_cot', 'id_factura', 'id_factura_origen', $id_pedido_cot);
        // echo $id_fact_destino;
        $sql = "UPDATE facturas_cot SET  estado_factura=1, `guia_enviada`=1, `transporte`='SPEED', `estado_guia_sistema`= 100
                                WHERE id_factura='" . $id_fact_destino . "'";
        // echo $sql;
        $query_update_destino = mysqli_query($conexion_destino, $sql);

        //ingresar guia marketplace

        $sql_insertar_guia_marketplace = "UPDATE `guia_laar` SET 
               `tienda_venta` = '$server_url',`guia_laar` = '$guia',`fecha` = '$date_added',`tienda_proveedor` = '$tienda',`url_guia` = '$url',`id_pedido` = '$id_pedido_cot',
               `identificacionO`= '$identificacionO',`ciudadO`= '$ciudadO', `nombreO`= '$nombreO',
                   `direccionO`= '$direccionO', `referenciaO`= '$refenciaO',`numeroCasaO`= '$numeroCasaO',
                       `postalO`= '$direccionO',`telefonoO`= '$direccionO', `celularO`= '$direccionO',
                  `identificacionD`= '$identificacion', `ciudadD`= '$ciudad_entrega',`nombreD`= '$nombre_destino', 
                      `direccionD`= '$direccion',`referenciaD`= '$referencia', `numeroCasaD`= '$numerocasa',
 `telefonoD`= '$telefono',`celularD`= '$celular',   
      `tipoServicio`= '201202002002013',`noPiezas`= '$cantidad_total', `peso`= '2',
          `valorDeclarado`= '$valorasegurado', `contiene`= '$productos_guia',`cod` = '$cod_guia',
              `costoflete`= '$costo_envio',`costoproducto`= '$valor_total',
                  `comentario`= '$observacion',`valor_costo`= '$costo_total',`estado_guia`= '1', `id_transporte` ='2'  WHERE `guia_laar`.`id_guia` = '$ultimoid_market'
";
        // echo $sql_insertar_guia;
        $query_insertar_marketplace = mysqli_query($conexion_marketplace, $sql_insertar_guia_marketplace);

        $id_fact_marketplace = get_row_destino($conexion_marketplace, 'facturas_cot', 'id_factura', 'id_factura_origen', $id_pedido_cot);
        $sql = "UPDATE facturas_cot SET  estado_factura=1, `guia_enviada`=1, `transporte`='SPEED', `estado_guia_sistema`= 1
                                WHERE id_factura='" . $id_fact_marketplace . "'";
        $query_update_destino = mysqli_query($conexion_marketplace, $sql);
    } else {

        // echo 'asd';
        //ingresar guia marketplace
        $sql_insertar_guia_marketplace = "UPDATE `guia_laar` SET 
               `tienda_venta` = '$server_url',`guia_laar` = '$guia',`fecha` = '$date_added',`tienda_proveedor` = '$tienda',`url_guia` = '$url',`id_pedido` = '$id_pedido_cot',
               `identificacionO`= '$identificacionO',`ciudadO`= '$ciudadO', `nombreO`= '$nombreO',
                   `direccionO`= '$direccionO', `referenciaO`= '$refenciaO',`numeroCasaO`= '$numeroCasaO',
                       `postalO`= '$direccionO',`telefonoO`= '$direccionO', `celularO`= '$direccionO',
                  `identificacionD`= '$identificacion', `ciudadD`= '$ciudad_entrega',`nombreD`= '$nombre_destino', 
                      `direccionD`= '$direccion',`referenciaD`= '$referencia', `numeroCasaD`= '$numerocasa',
 `telefonoD`= '$telefono',`celularD`= '$celular',   
      `tipoServicio`= '201202002002013',`noPiezas`= '$cantidad_total', `peso`= '2',
          `valorDeclarado`= '$valorasegurado', `contiene`= '$productos_guia',`cod` = '$cod_guia',
              `costoflete`= '$costo_envio',`costoproducto`= '$valor_total',
                  `comentario`= '$observacion',`valor_costo`= '$costo_total',`estado_guia`= '1', `id_transporte` ='2'  WHERE `guia_laar`.`id_guia` = '$ultimoid_market'
";
        //            $sql_insertar_guia_marketplace = "INSERT INTO `guia_laar` ( `tienda_venta`, `guia_sistema`, `guia_laar`, `fecha`, `zpl`, `tienda_proveedor`, `url_guia`,`id_pedido`, 
        //            `identificacionO`,`ciudadO`, `nombreO`,
        //            `direccionO`, `referenciaO`,`numeroCasaO`, 
        //            `postalO`,`telefonoO`, `celularO`,
        //            `identificacionD`, `ciudadD`,`nombreD`, 
        //            `direccionD`,`referenciaD`, `numeroCasaD`,
        //            `postalD`, `telefonoD`,`celularD`, 
        //            `tipoServicio`,`noPiezas`, `peso`,
        //            `valorDeclarado`, `contiene`,`cod` ,
        //            `costoflete`,`costoproducto`, `tipocobro`,
        //            `comentario`,`valor_costo`, `estado_guia`) 
        //        VALUES (  '$server_url', '$ultimoid', '$guia', '$date_added', '', '$tienda','$url','$id_pedido_cot',"
        //                . "'$identificacionO','$ciudadO','$nombreO',"
        //                . "'$direccionO','$refenciaO','$numeroCasaO',"
        //                . "'','$telefonoO','$celularO',"
        //                . "'$identificacion','$ciudad_entrega','$nombre_destino',"
        //                . "'$direccion','$referencia','$numerocasa',"
        //                . "'','$telefono','$celular',"
        //                . "'201202002002013','$cantidad_total','2',"
        //                . "'$valorasegurado','$productos_guia','$cod_guia','$costo_envio','$valor_total',"
        //                . "'0','$observacion','$costo_total',2)";
        // echo $sql_insertar_guia_marketplace;
        $query_insertar_marketplace = mysqli_query($conexion_marketplace, $sql_insertar_guia_marketplace);

        $id_fact_marketplace = get_row_destino($conexion_marketplace, 'facturas_cot', 'id_factura', 'id_factura_origen', $id_pedido_cot);
        $sql = "UPDATE facturas_cot SET  estado_factura=2 , `guia_enviada`=1, `transporte`='SPEED', `estado_guia_sistema`= 100
                                WHERE id_factura='" . $id_fact_marketplace . "'";
        $query_update_destino = mysqli_query($conexion_marketplace, $sql);

        $query = "SELECT * FROM detalle_fact_cot WHERE id_factura = $id_pedido_cot";
        //echo $query;
        // Realizar la consulta
        $resultado = mysqli_query($conexion, $query);

        // Verificar si la consulta fue exitosa
        if ($resultado) {
            // Iterar sobre los resultados usando un bucle while
            if ($_SERVER['HTTP_HOST'] == 'localhost') {
                $conexion_marketplace = mysqli_connect('localhost', 'root', '', 'master');
            } else {
                $conexion_marketplace = mysqli_connect('localhost', 'imporsuit_marketplace', 'imporsuit_marketplace', 'imporsuit_marketplace');
            }

            // Verificar si la conexión fue exitosa
            if ($conexion->connect_error) {
                die("Error de conexión: " . $conexion->connect_error);
            }
            while ($fila = mysqli_fetch_assoc($resultado)) {

                $id_producto = $fila['id_producto'];
                // echo $id_producto;
                $drogshipin = get_row('productos', 'drogshipin', 'id_producto', $id_producto);
                $id_marketplace = get_row('productos', 'id_marketplace', 'id_producto', $id_producto);
                $cantidad = $fila['cantidad'];
                if ($drogshipin == 1) {
                    $sql2    = mysqli_query($conexion_marketplace, "select * from productos where id_producto='" . $id_marketplace . "'");
                    $rw      = mysqli_fetch_array($sql2);
                    $old_qty = $rw['stock_producto']; //Cantidad encontrada en el inventario
                    $id_producto_origen = $rw['id_producto_origen'];
                    $new_qty = $old_qty - $cantidad; //Nueva cantidad en el inventario
                    $update  = mysqli_query($conexion_marketplace, "UPDATE productos SET stock_producto='" . $new_qty . "' WHERE id_producto='" . $id_marketplace . "' and inv_producto=0"); //Actualizo la nueva cantidad en el inventario

                    $sql_stock_proveedor    = mysqli_query($conexion_destino, "select * from productos where id_producto='" . $id_producto_origen . "'");
                    $rw_stock_proveedor      = mysqli_fetch_array($sql_stock_proveedor);
                    $old_qty_proveedor = $rw_stock_proveedor['stock_producto'];
                    $new_qty_proveedor = $old_qty_proveedor - $cantidad;
                    $update  = mysqli_query($conexion_destino, "UPDATE productos SET stock_producto='" . $new_qty_proveedor . "' WHERE id_producto='" . $id_producto_origen . "' and inv_producto=0");
                } else {

                    $sql2    = mysqli_query($conexion, "select * from productos where id_producto='" . $id_producto . "'");
                    $rw      = mysqli_fetch_array($sql2);
                    $old_qty = $rw['stock_producto']; //Cantidad encontrada en el inventario
                    $new_qty = $old_qty - $cantidad; //Nueva cantidad en el inventario
                    $update  = mysqli_query($conexion, "UPDATE productos SET stock_producto='" . $new_qty . "' WHERE id_producto='" . $id_producto . "' and inv_producto=0"); //Actualizo la nueva cantidad en el inventario
                    if ($tienda == 'enviado') {
                        $sql2    = mysqli_query($conexion_destino, "select * from productos where id_producto='" . $id_marketplace . "'");
                        $rw      = mysqli_fetch_array($sql2);
                        $old_qty = $rw['stock_producto']; //Cantidad encontrada en el inventario
                        $new_qty = $old_qty - $cantidad; //Nueva cantidad en el inventario
                        $update  = mysqli_query($conexion_destino, "UPDATE productos SET stock_producto='" . $new_qty . "' WHERE id_producto_origen='" . $id_producto . "' and tienda='$server_url' and inv_producto=0"); //Actualizo la nueva cantidad en el inventario   


                    }
                }
            }

            // Liberar el resultado
            mysqli_free_result($resultado);
        } else {
            echo "Error en la consulta: " . mysqli_error($conexion);
        }
    }
    echo 'ok';
}
