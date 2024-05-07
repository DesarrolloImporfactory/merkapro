<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
/*-------------------------
Autor: Eduardo Vega
---------------------------*/
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
//Archivo de funciones PHP
require_once "../funciones.php";
require_once "../funciones_destino.php";
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Ventas";

permisos($modulo, $cadena_permisos);
// obtiene el dominio actual
$dominio = $_SERVER['HTTP_HOST'];
// se quitan los espacios en blanco 
$dominio = str_replace(' ', '', $dominio);

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

if (isset($_POST['estado'])) {
    $XD = $_POST['estado'];

    echo $XD;
}

//Finaliza Control de Permisos
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q      = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $sTable = "facturas_cot, clientes, users";
    $sWhere = "";
    $sWhere .= " WHERE facturas_cot.id_cliente=clientes.id_cliente and facturas_cot.id_vendedor=users.id_users";
    if ($_GET['q'] != "") {
        $sWhere .= " and  (facturas_cot.nombre like '%$q%' or facturas_cot.numero_factura like '%$q%')";
    }
    if (@$_GET['tienda'] != "") {
        $tienda    = $_REQUEST['tienda'];
        $sWhere .= " and  tienda='$tienda'";
    }
    if (@$_GET['estado'] != "") {
        $estado    = $_REQUEST['estado'];
        $sWhere .= " and  estado_guia_sistema='$estado'";
    }

    $sWhere .= " order by facturas_cot.id_factura desc";
    include 'pagination.php'; //include pagination file
    //pagination variables
    $page      = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page  = 10; //how much records you want to show
    if ($_GET["numero"]) {
        $per_page  = $_GET["numero"]; //how much records you want to show

    }
    $adjacents = 4; //gap between pages after number of adjacents
    $offset    = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query = mysqli_query($conexion, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
    $row         = mysqli_fetch_array($count_query);
    $numrows     = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload      = '../reportes/facturas.php';
    //main query to fetch the data
    $sql   = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
    //echo $sql;
    $query = mysqli_query($conexion, $sql);

    //loop through fetched data
    if ($numrows > 0) {
        echo mysqli_error($conexion);
?>
        <div class="table-responsive">
            <table class="table table-sm table-striped align-middle">
                <tr class="info">
                    <th class="text-center"><input type="checkbox" onchange="checkall()" name="todos" id="todos"></th>
                    <th class="text-center"># Orden</th>
                    <th class="text-center">Fecha</th>
                    <th class="text-center">Detalle</th>
                    <th class="text-center">Cliente</th>
                    <th class="text-center">Localidad</th>
                    <th class="text-center">Tienda</th>
                    <?php if ($server_url === "https://marketplace.imporsuit.com") { ?>
                        <th class="text-center">Proveedor</th>
                    <?php } ?>
                    <th colspan="2" style="text-align: center;">Estado</th>

                    <th class='text-center'>Impreso</th>
                    <th></th>
                    <th></th>

                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($query)) {
                    $id_factura       = $row['id_factura'];
                    $numero_factura   = $row['numero_factura'];
                    $fecha            = date("d/m/Y h:i:s a ", strtotime($row['fecha_factura']));
                    $nombre_cliente   = $row['nombre_cliente'];
                    $nombre   = $row['nombre'];
                    $id_factura_origen   = $row['id_factura_origen'];

                    $telefono   = $row['telefono'];
                    $id_prvo = $row['provincia'];
                    $estado_factura = $row['estado_factura'];
                    //echo  $id_prvo;
                    $provincia   = get_row('provincia_laar', 'provincia', 'codigo_provincia', $id_prvo);
                    //echo $provincia;
                    $ciudad_cot   = $row['ciudad_cot'];
                    //echo $ciudad_cot;
                    $ciudad_cot   = get_row('ciudad_laar', 'nombre', 'codigo', $ciudad_cot);

                    $observacion   = $row['observacion'];
                    $direccion   = $row['c_principal'] . ' y ' . $row['c_secundaria'] . '-' . $row['referencia'];
                    $telefono_cliente = $row['telefono_cliente'];
                    $email_cliente    = $row['email_cliente'];
                    $nombre_vendedor  = $row['nombre_users'] . " " . $row['apellido_users'];
                    $estado_factura   = $row['estado_factura'];
                    $guia_enviada   = $row['guia_enviada'];
                    $drogshipin   = $row['drogshipin'];

                    $tienda   = $row['tienda'];
                    if ($tienda == null || $tienda == '') {
                        $tienda = $server_url;
                    }
                    $span_estado = '';

                    $id_producto_origen = $row['id_factura_origen'];
                    $existe_guia_sql = "SELECT * FROM guia_laar WHERE id_pedido='" . $id_producto_origen . "'";
                    $existe_guia_query = mysqli_query($conexion, $existe_guia_sql);
                    $existe_guia = mysqli_num_rows($existe_guia_query);
                    //echo $existe_guia;
                    $guia_numero = '';
                    $impreso = $row['impreso'];
                    $estado_guia = '';

                    $estado_actual_guia_X = '';
                    switch ($estado_factura) {

                        case 1:
                            $text_estado = "Confirmar";
                            $label_class = 'badge-warning';
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
                            $label_class = 'badge-primary';
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




                    $total_venta    = $row['monto_factura'];
                    $simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
                ?>
                    <input type="hidden" value="<?php echo $estado_factura; ?>" id="estado<?php echo $id_factura; ?>">
                    <?php
                    $sql_provee = "";
                    switch ($drogshipin) {
                        case 0:
                            $tipo_venta_m = 'LOCAL';
                            break;
                        case 1:
                            $tipo_venta_m = 'DROPSHIPPING';
                            break;

                        case 2:
                            $tipo_venta_m = 'LOCAL';
                            break;

                        case 3:
                            $tipo_venta_m = 'DROPSHIPPING';
                            $prove_temp = $tienda;
                            $archivo_tienda = $prove_temp . '/sysadmin/vistas/db1.php';
                            $archivo_destino_tienda = "../db_destino_guia.php";
                            $contenido_tienda = file_get_contents($archivo_tienda);
                            $get_data = json_decode($contenido_tienda, true);
                            if (file_put_contents($archivo_destino_tienda, $contenido_tienda) !== false) {
                                $sql_provee = "SELECT tienda FROM facturas_cot WHERE id_factura='" . $id_factura_origen . "'";
                                require_once "../php_conexion_destino_guia.php";
                                if ($conexion_destino) {
                                    cerrar_conexion($conexion_destino);
                                }
                                $host_d = $get_data['DB_HOST'];
                                $user_d = $get_data['DB_USER'];
                                $pass_d = $get_data['DB_PASS'];
                                $base_d = $get_data['DB_NAME'];

                                $conexion_destino = abrir_conexion($host_d, $user_d, $pass_d, $base_d);

                                $query_provee = mysqli_query($conexion_destino, $sql_provee);
                                $data = mysqli_fetch_array($query_provee);


                                echo mysqli_error($conexion_destino);
                                if (isset($data[0])) {

                                    $proveedor = $data[0];
                                    $proveedor_url = $proveedor;
                                    $proveedor = str_replace('https://', '', $proveedor);
                                    $proveedor = str_replace('http://', '', $proveedor);
                                    $proveedor = str_replace('.imporsuit.com', '', $proveedor);
                                    $proveedor = strtoupper($proveedor);
                                } else {
                                    $proveedor = "NO ENCONTRADO BUG";
                                }
                            } else {
                                echo "Error al copiar el archivo";
                            }


                            break;

                        case 4:
                            $tipo_venta_m = 'LOCAL';
                            $proveedor = $tienda;
                            $proveedor_url = $proveedor;
                            $proveedor = str_replace('https://', '', $proveedor);
                            $proveedor = str_replace('http://', '', $proveedor);
                            $proveedor = str_replace('.imporsuit.com', '', $proveedor);
                            $proveedor = strtoupper($proveedor);

                            break;

                        default:
                            echo "Estado no reconocido";
                    }
                    list($año, $hora, $apm) = explode(" ", $fecha);
                    $tienda_url = $tienda;

                    $tienda = str_replace('https://', '', $tienda);
                    $tienda = str_replace('http://', '', $tienda);
                    $tienda = str_replace('.imporsuit.com', '', $tienda);
                    $tienda = strtoupper($tienda);

                    ?>
                    <tr class="align-middle">
                        <td class="align-middle"><input type="checkbox" name="item" id="<?php echo $numero_factura; ?>"></td>
                        <td class="align-middle text-center"><label class='badge badge-purple'><?php echo $numero_factura; ?></label><br><span class="fs-xs"><?php echo $tipo_venta_m; ?></span> </td>
                        <td class="text-center align-middle"><span><?php echo $año; ?></span> <br><span><?php echo $hora . " " . $apm; ?> </span></td>
                        <td class="align-middle"> <button onclick="ver_detalle_cot('<?php echo $numero_factura ?>')" class="btn btn-sm btn-outline-primary"> Ver detalle</button> </td>

                        <td style="max-width: 220px;" class="text-center align-middle fs-7"><span class="font-weight-bold"> <?php echo $nombre; ?> </span> <br> <span class=""><?php echo $direccion; ?></span><br> <span><?php echo  "telf: " .  $telefono; ?></span></td>
                        <td class="text-center align-middle"><?php echo '<strong>' . $provincia . '</strong>' . '<br>' . $ciudad_cot; ?></td>
                        <td class="text-center align-middle"><a href="<?php echo $tienda_url; ?>" target="_blank" rel="noopener noreferrer"> <?php echo $tienda; ?></a></td>

                        <?php if ($server_url === "https://marketplace.imporsuit.com") { ?>
                            <td class="text-center align-middle"><a href="<?php echo $proveedor_url; ?>" target="_blank" rel="noopener noreferrer"> <?php echo $proveedor; ?></a></td>
                        <?php } ?>
                        <td class="text-center align-middle" id="estados_laar_<?php echo $numero_factura ?>"><?php
                                                                                                                // echo $drogshipin;
                                                                                                                switch ($drogshipin) {
                                                                                                                    case 0:
                                                                                                                        try {
                                                                                                                            $validar = get_row_guia('guia_laar', 'guia_laar', 'id_pedido', $id_factura);
                                                                                                                            if ($validar != '0') {
                                                                                                                                $guia_numero = get_row_guia('guia_laar', 'guia_laar', 'id_pedido', $id_factura);
                                                                                                                                $url = 'https://api.laarcourier.com:9727/guias/' . $guia_numero;
                                                                                                                            } else {
                                                                                                                                $guia_numero = ''; // Puedes omitir esta línea si no necesitas asignar un valor específico
                                                                                                                                $url = ''; // O asignar un valor específico para el caso sin guía
                                                                                                                            }
                                                                                                                        } catch (Exception $e) {
                                                                                                                        }

                                                                                                                        break;
                                                                                                                    case 1:
                                                                                                                        if ($guia_enviada == 1) {

                                                                                                                            $guia_numero = get_row('guia_laar', 'guia_laar', 'id_pedido', $id_factura);
                                                                                                                            $url = 'https://api.laarcourier.com:9727/guias/' . $guia_numero;

                                                                                                                            // echo $url;
                                                                                                                        } else {
                                                                                                                            $guia_numero = ''; // Puedes omitir esta línea si no necesitas asignar un valor específico
                                                                                                                            $url = ''; // O asignar un valor específico para el caso sin guía
                                                                                                                        }

                                                                                                                        break;
                                                                                                                    case 3:
                                                                                                                        try {
                                                                                                                            $validar = get_row_guia('guia_laar', 'guia_laar', 'id_pedido', $id_factura_origen . " and tienda_venta like '%" . $tienda . "%'");

                                                                                                                            if ($validar != '') {
                                                                                                                                $guia_numero = get_row_guia('guia_laar', 'guia_laar', 'id_pedido', $id_factura_origen . " and tienda_venta like '%" . $tienda . "%'");
                                                                                                                                $url = 'https://api.laarcourier.com:9727/guias/' . $guia_numero;
                                                                                                                            } else {
                                                                                                                                $guia_numero = ''; // Puedes omitir esta línea si no necesitas asignar un valor específico
                                                                                                                                $url = ''; // O asignar un valor específico para el caso sin guía
                                                                                                                            }
                                                                                                                        } catch (Exception $e) {
                                                                                                                        }

                                                                                                                        break;
                                                                                                                    case 4:
                                                                                                                        try {

                                                                                                                            $validar = get_row_guia('guia_laar', 'guia_laar', 'id_pedido', $id_factura_origen . " and tienda_venta like '%" . $tienda . "%'");
                                                                                                                            if ($validar != '') {
                                                                                                                                $guia_numero = get_row_guia('guia_laar', 'guia_laar', 'id_pedido', $id_factura_origen . " and tienda_venta like '%" . $tienda . "%'");
                                                                                                                                $url = 'https://api.laarcourier.com:9727/guias/' . $guia_numero;
                                                                                                                            } else {
                                                                                                                                $guia_numero = ''; // Puedes omitir esta línea si no necesitas asignar un valor específico
                                                                                                                                $url = ''; // O asignar un valor específico para el caso sin guía
                                                                                                                            }
                                                                                                                        } catch (Exception $e) {
                                                                                                                        }
                                                                                                                        break;

                                                                                                                    default:
                                                                                                                        echo "Estado no reconocido";
                                                                                                                }
                                                                                                                if ($guia_numero != '0') {
                                                                                                                    echo "<script> validar_laar('" . $guia_numero . "', '" . $numero_factura . "')</script>";

                                                                                                                    if ($drogshipin == 3 || $drogshipin == 4) {
                                                                                                                        $url = get_row_guia('guia_laar', 'url_guia', 'id_pedido', $id_factura_origen . " and tienda_venta like '%" . $tienda . "%'");

                                                                                                                        $traking = "https://fenix.laarcourier.com/Tracking/Guiacompleta.aspx?guia=" . get_row_guia('guia_laar', 'guia_laar', 'id_pedido', $id_factura_origen . " and tienda_venta like '%" . $tienda . "%'");
                                                                                                                    } else {
                                                                                                                        $url = get_row_guia('guia_laar', 'url_guia', 'id_pedido', $id_factura . " and tienda_venta like '%" . $server_url . "%'");

                                                                                                                        //$url = get_row('guia_laar', 'url_guia', 'id_pedido', $id_factura);

                                                                                                                        $traking = "https://fenix.laarcourier.com/Tracking/Guiacompleta.aspx?guia=" . get_row_guia('guia_laar', 'guia_laar', 'id_pedido', $id_factura . " and tienda_venta like '%" . $server_url . "%'");
                                                                                                                    }
                                                                                                                    $estado_guia_for = get_row('guia_laar', 'estado_guia', 'guia_laar', $guia_numero);
                                                                                                                    if ($estado_guia_for != "0") {

                                                                                                                        switch ($estado_guia_for) {
                                                                                                                            case '1':

                                                                                                                                $span_estado = 'badge-danger';
                                                                                                                                $estado_guia = 'Anulado';
                                                                                                                                break;
                                                                                                                            case '2':
                                                                                                                                $span_estado = 'badge-purple';
                                                                                                                                $estado_guia = 'Por recolectar';
                                                                                                                                break;
                                                                                                                            case '3':
                                                                                                                                $span_estado = 'badge-purple';
                                                                                                                                $estado_guia = 'Por recolectar';
                                                                                                                                break;
                                                                                                                            case '4':
                                                                                                                                $span_estado = 'badge-purple';
                                                                                                                                $estado_guia = 'Por recolectar';
                                                                                                                                break;
                                                                                                                            case '5':
                                                                                                                                $span_estado = 'badge-warning';
                                                                                                                                $estado_guia = 'En Transito';
                                                                                                                                break;
                                                                                                                            case '6':
                                                                                                                                $span_estado = 'badge-purple';
                                                                                                                                $estado_guia = 'Por recolectar';
                                                                                                                                break;
                                                                                                                            case '7':
                                                                                                                                $span_estado = 'badge-purple';
                                                                                                                                $estado_guia = 'Entregado';
                                                                                                                                break;
                                                                                                                            case '8':
                                                                                                                                $span_estado = 'badge-danger';
                                                                                                                                $estado_guia = 'Anulada';
                                                                                                                                break;
                                                                                                                            case '11':
                                                                                                                                $span_estado = 'badge-warning';
                                                                                                                                $estado_guia = 'En Transito';

                                                                                                                                break;
                                                                                                                            case '12':
                                                                                                                                $span_estado = 'badge-warning';
                                                                                                                                $estado_guia = "En Transito";
                                                                                                                                break;

                                                                                                                            case '14':
                                                                                                                                $estado_guia = "Con novedad";
                                                                                                                                $span_estado = 'badge-danger';
                                                                                                                                //$estado_guia = 'Anulada';
                                                                                                                                break;
                                                                                                                            case '16':
                                                                                                                                $span_estado = 'badge-danger';
                                                                                                                                //$estado_guia = 'Anulada';
                                                                                                                                break;
                                                                                                                            case '29':
                                                                                                                                $span_estado = 'badge-danger';
                                                                                                                                //$estado_guia = 'Anulada';
                                                                                                                                break;
                                                                                                                            case '48':
                                                                                                                                $span_estado = 'badge-danger';
                                                                                                                                //$estado_guia = 'Anulada';
                                                                                                                                break;
                                                                                                                            case '9':
                                                                                                                                $span_estado = 'badge-danger';
                                                                                                                                $estado_guia = 'Devuelto';
                                                                                                                                break;
                                                                                                                        }
                                                                                                                    } else {
                                                                                                                        $guia_numero = 'GUIA NO ENVIADA';
                                                                                                                        $traking = '';
                                                                                                                    }
                                                                                                                }
                                                                                                                if (isset($estado_guia_for)) {
                                                                                                                    if ($traking != '') {
                                                                                                                ?>
                                    <a style="cursor: pointer;" href="<?php echo $url; ?>" target="blank"><span class="badge <?php echo $span_estado; ?>"><?php echo $estado_guia; ?></span></a><BR>
                                    <a style="cursor: pointer;" href="<?php echo $url; ?>" target="blank"><span class=""><?php echo $guia_numero; ?></span></a><BR>
                                    <?php

                                    ?>
                                    <a style="cursor: pointer;" href="<?php echo $traking; ?>" target="blank"><img width="40px" src="../../img_sistema/rastreo.png" alt="" /></a>
                                <?php
                                                                                                                    } else {
                                                                                                                        echo '<span class="badge badge-warning text-black">GUIA NO ENVIADA</span>';
                                                                                                                    }
                                ?>


                            <?php
                                                                                                                } else {
                                                                                                                    echo '<span class="badge badge-warning text-black">GUIA NO ENVIADA</span>';
                                                                                                                }
                            ?>
                        </td>
                        <td class="text-center align-middle">
                            <?php if ($drogshipin == 3 || $drogshipin == 4) {

                            ?>
                                <select style="width: 100px" onchange="obtener_datos('<?php echo $id_factura; ?>')" id="estado_sistema<?php echo $id_factura; ?>" class='form-control <?php echo $label_class; ?>' name='mod_estado' id='mod_estado'>
                                    <option value="">-- Selecciona --</option>
                                    <?php
                                    if ($data['estadoActualCodigo'] == 8) {
                                        $sql_anular = "UPDATE facturas_cot SET  estado_factura=8
                                                                            WHERE id_factura='" . $id_factura . "'";
                                        $query_anular = mysqli_query($conexion, $sql_anular);
                                    }
                                    //echo "select * from estado_guia";
                                    $query_categoria = mysqli_query($conexion, "select * from estado_guia_sistema");
                                    while ($rw = mysqli_fetch_array($query_categoria)) {
                                        $selected = ($rw['id_estado'] == $estado_factura) ? 'selected' : '';
                                    ?>
                                        <option value="<?php echo $rw['id_estado']; ?>" <?php echo $selected; ?>><?php echo $rw['estado']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            <?php
                            }

                            ?>

                        </td>
                        <td class='text-center text-primary align-middle'> <?php if ($impreso != null && $impreso != 0) echo '<i class="ti-file"></i>'; ?> </td>


                        <td class="text-center align-middle">
                            <div class="btn-group dropdown">
                                <button type="button" class="btn btn-warning btn-sm dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"> <i class='fa fa-cog'></i> <i class="caret"></i> </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <?php if ($permisos_editar == 1) { ?>
                                        <a class="dropdown-item" target="blank" href="editar_cotizacion.php?id_factura=<?php echo $id_factura; ?>"><i class='fa fa-edit'></i> <?php if ($drogshipin == 3) {
                                                                                                                                                                                    echo "Ver";
                                                                                                                                                                                } else {
                                                                                                                                                                                    echo "Editar";
                                                                                                                                                                                } ?> </a>
                                        <!--a class="dropdown-item" href="#" onclick="imprimir_factura('<?php echo $id_factura; ?>');"><i class='fa fa-print'></i> Imprimir</a-->
                                    <?php }
                                    if ($permisos_eliminar == 1) { ?>
                                        <!--<a class="dropdown-item" href="#" data-toggle="modal" data-target="#dataDelete" data-id="<?php echo $row['id_factura']; ?>"><i class='fa fa-trash'></i> Eliminar</a>-->
                                    <?php } ?>


                                </div>
                            </div>

                        </td>

                    </tr>
                <?php
                }
                ?>
                <tr>
                    <td colspan=10><span class="pull-right"><?php
                                                            echo paginate($reload, $page, $total_pages, $adjacents);
                                                            ?></span></td>
                </tr>
            </table>


        </div>
    <?php
    } else {
    ?>
        <div class="alert alert-warning alert-dismissible" role="alert" align="center">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Aviso!</strong> No hay Registro de Cotizaciones
        </div>

<?php
    }
    // fin else
}
