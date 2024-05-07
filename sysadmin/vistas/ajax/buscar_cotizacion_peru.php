<?php
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


//Finaliza Control de Permisos
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';
$pais= get_row('perfil', 'pais', 'id_perfil', 1);
if ($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q      = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $sTable = "facturas_cot, clientes, users";
    $sWhere = "";
    $sWhere .= " WHERE estado_factura <> 8 and estado_factura <> 7 and facturas_cot.id_cliente=clientes.id_cliente and facturas_cot.id_vendedor=users.id_users";
    if ($_GET['q'] != "") {
        $sWhere .= " and  (facturas_cot.nombre like '%$q%' or facturas_cot.numero_factura like '%$q%')";
    }
    if (@$_GET['tienda'] != "") {
        $tienda    = $_REQUEST['tienda'];
        $sWhere .= " and  tienda='$tienda'";
    }

    $sWhere .= " order by facturas_cot.id_factura desc";
    include 'pagination.php'; //include pagination file
    //pagination variables
    $page      = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page  = 30; //how much records you want to show
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
            <table class="table table-sm table-striped">
                <tr class="info">
                    <th># Orden</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>TIPO</th>
                    <th>TIENDA</th>
                    <th>Telefono</th>
                    <th>Localidad</th>
                    <th>Direccion</th>

                    <th  style="text-align: center;">Estado</th>

                    <th class='text-center'>Total</th>
                    <th></th>
                    <th></th>

                </tr>
                <?php
                while ($row = mysqli_fetch_array($query)) {
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
                    //$ciudad_cot   = get_row('ciudad_laar', 'nombre', 'codigo', $ciudad_cot);

                    $observacion   = $row['observacion'];
                    $direccion   = $row['c_principal'] . ' y ' . $row['c_secundaria'] . '-' . $row['referencia'];
                    $telefono_cliente = $row['telefono_cliente'];
                    $email_cliente    = $row['email_cliente'];
                    $nombre_vendedor  = $row['nombre_users'] . " " . $row['apellido_users'];
                    $estado_factura   = $row['estado_factura'];
                    $guia_enviada   = $row['guia_enviada'];
                    $drogshipin   = $row['drogshipin'];

                    $tienda   = $row['tienda'];
                    $span_estado = '';

                    $id_producto_origen = $row['id_factura_origen'];
                    $existe_guia_sql = "SELECT * FROM guia_laar WHERE id_pedido='" . $id_producto_origen . "'";
                    $existe_guia_query = mysqli_query($conexion, $existe_guia_sql);
                    $existe_guia = mysqli_num_rows($existe_guia_query);
                    //echo $existe_guia;
                    $guia_numero = '';

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

                    <tr>
                        <td><label class='badge badge-purple'><?php echo $numero_factura; ?></label></td>
                        <td><?php echo $fecha; ?></td>
                        <td><?php echo $nombre; ?></td>
                        <td><?php
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
                                    break;

                                case 4:
                                    $tipo_venta_m = 'LOCAL';

                                    break;

                                default:
                                    echo "Estado no reconocido";
                            }
                            echo $tipo_venta_m;
                            ?></td>
                        <td><?php
                            // echo 'sa';
                            switch ($drogshipin) {
                                case 0:
                                    $tipo_ped = $tienda;
                                    break;
                                case 1:
                                    $tipo_ped = $tienda;
                                    break;

                                case 2:
                                    $tipo_ped = $tienda;
                                    break;

                                case 3:
                                    $tipo_ped = $tienda;
                                    break;

                                case 4:
                                    $tipo_ped = $tienda;

                                    break;

                                default:
                                    echo "Estado no reconocido";
                            }

                            echo $tipo_ped; ?></td>
                        <td><?php echo $telefono; ?></td>

                        <td><?php echo '<strong>' . $provincia . '</strong>' . '<br>' . $ciudad_cot; ?></td>
                        <td><?php echo $direccion; ?></td>

                       
                        <td>
                            
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
                           

                        </td>
                        <td class='text-left'><b><?php echo $simbolo_moneda . '' . number_format($total_venta, 2); ?></b></td>


                        <td class="text-center">
                            <div class="btn-group dropdown">
                                <button type="button" class="btn btn-warning btn-sm dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"> <i class='fa fa-cog'></i> <i class="caret"></i> </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <?php if ($permisos_editar == 1) { ?>
                                        <a class="dropdown-item" target="blank" href="editar_cotizacion.php?id_factura=<?php echo $id_factura; ?>"><i class='fa fa-edit'></i> Editar</a>
                                        <!--a class="dropdown-item" href="#" onclick="imprimir_factura('<?php echo $id_factura; ?>');"><i class='fa fa-print'></i> Imprimir</a-->
                                    <?php }
                                    if ($permisos_eliminar == 1) { ?>
                                        <!--<a class="dropdown-item" href="#" data-toggle="modal" data-target="#dataDelete" data-id="<?php echo $row['id_factura']; ?>"><i class='fa fa-trash'></i> Eliminar</a>-->
                                    <?php } ?>
                                    <?php
                                    if ($dominio == 'localhost' || $dominio == 'marketplace.imporsuit.com') {
                                    ?>

                                        <button class="dropdown-item" onclick="wallet('<?php echo $numero_factura ?>')" type="button"><i class="ti-wallet"></i> Cartera</button>


                                    <?php

                                    }
                                    if ($drogshipin == 3) {
                                        if ($guia_numero = 'NO ENVIADA') {
                                        } else {
                                        }
                                    ?>

                                        <button class="dropdown-item" onclick="guia_importar('<?php echo $numero_factura ?>')" type="button"><i class="ti-wallet"></i> Importar Guia</button>
                                    <?php
                                    }

                                    if ($estado_actual_guia_X >= 2 && $estado_actual_guia_X <= 7) {
                                    } else {
                                    ?>
                                        <button class="dropdown-item" onclick="guia_anulada('<?php echo $numero_factura ?>')" type="button"><i class="ti-wallet"></i> Anulada Guia</button>
                                    <?php
                                    }
                                    ?>


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
    }
    //Este else Fue agregado de Prueba de prodria Quitar
    else {
    ?>
        <div class="alert alert-warning alert-dismissible" role="alert" align="center">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Aviso!</strong> No hay Registro de Cotizaciones
        </div>

<?php
    }
    // fin else
}
?>