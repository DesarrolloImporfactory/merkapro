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
//Finaliza Control de Permisos
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q      = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $sTable = "facturas_cot, clientes, users";
    $sWhere = "";
    $sWhere .= " WHERE estado_factura = 8 and  facturas_cot.id_cliente=clientes.id_cliente and facturas_cot.id_vendedor=users.id_users";
    if ($_GET['q'] != "") {
        $sWhere .= " and  (facturas_cot.nombre like '%$q%' or facturas_cot.numero_factura like '%$q%')";
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
                    <th>TIENDA</th>
                    <th>Telefono</th>
                    <th>Localidad</th>


                    <th>Direccion</th>

                    <th align="center">Estado Guia</th>
                    <th>Estado Pedido</th>
                    <th class='text-center'>Total</th>
                    <th></th>

                </tr>
                <?php
                while ($row = mysqli_fetch_array($query)) {
                    $id_factura       = $row['id_factura'];
                    $numero_factura   = $row['numero_factura'];
                    $fecha            = date("d/m/Y", strtotime($row['fecha_factura']));
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

                    if ($estado_factura == 1) {
                        $text_estado = "INGRESADA";
                        $label_class = 'badge-success';
                    } else {
                        $text_estado = "CREDITO";
                        $label_class = 'badge-danger';
                    }

                    switch ($estado_factura) {

                        case 1:
                            $text_estado = "Confirmar";
                            $label_class = 'badge-success';
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
                            $label_class = 'badge-warning';
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
                            $estado_guia = 'NO ENVIADA';
                            if ($drogshipin == 1 || $drogshipin == 3) {
                                $tipo_ped = $tienda;
                            } else {
                                $tipo_ped = 'LOCAL';
                            }
                            echo $tipo_ped; ?></td>
                        <td><?php echo $telefono; ?></td>

                        <td><?php echo '<strong>' . $provincia . '</strong>' . '<br>' . $ciudad_cot; ?></td>
                        <td><?php echo $direccion; ?></td>

                        <td align="center"><?php
                                            if (($guia_enviada == 1 && $estado_factura != 0) || $drogshipin == 3) {
                                                if ($drogshipin == 3) {
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
                                                    $guia_numero = get_row_destino($conexion_destino, 'guia_laar', 'guia_laar', 'id_pedido', $id_factura_origen);
                                                    echo $guia_numero;
                                                    $id_factura_guia = $id_factura_origen;
                                                    //  $guia_numero = get_row('guia_laar', 'guia_laar', 'id_pedido', $id_factura); 
                                                } else {
                                                    $guia_numero = get_row('guia_laar', 'guia_laar', 'id_pedido', $id_factura);
                                                }

                                                $url = 'https://api.laarcourier.com:9727/guias/' . $guia_numero;

                                                $curl = curl_init($url);

                                                // Establecer opciones para la solicitud cURL
                                                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                                curl_setopt($curl, CURLOPT_HTTPHEADER, [
                                                    'Accept: application/json'
                                                ]);

                                                // Realizar la solicitud GET
                                                $response = curl_exec($curl);

                                                // Verificar si hubo algún error en la solicitud
                                                if ($response === false) {
                                                    echo 'Error en la solicitud: ' . curl_error($curl);
                                                } else {
                                                    // Procesar la respuesta
                                                    $data = json_decode($response, true);
                                                    print_r($data);
                                                    if ($data !== null && isset($data['estadoActualCodigo'])) {
                                                        // Imprimir el estadoActual
                                                        //echo 'Estado Actual: ' . $data['estadoActual'];
                                                        echo $data["estadoActualCodigo"];
                                                        switch ($data['estadoActualCodigo']) {
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
                                                                $span_estado = 'badge-purple';
                                                                $estado_guia = 'Por recolectar';
                                                                break;
                                                            case '6':
                                                                $span_estado = 'badge-purple';
                                                                $estado_guia = 'Por recolectar';
                                                                break;
                                                            case '7':
                                                                $span_estado = 'badge-purple';
                                                                $estado_guia = 'Anulada';
                                                                break;
                                                            case '8':
                                                                $span_estado = 'badge-danger';
                                                                $estado_guia = 'Anulada';
                                                                break;
                                                            case '14':
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
                                                                echo "i es igual a 2";
                                                                break;
                                                        }
                                                        $estado_guia = get_row('estado_courier', 'alias', 'codigo', $data['estadoActualCodigo']);
                                                    } else {
                                                        echo 'No se pudo obtener el estadoActual';
                                                    }
                                                }

                                                // Cerrar la sesión cURL
                                                curl_close($curl);
                                                if ($drogshipin == 3) {
                                                    $url = get_row('guia_laar', 'url_guia', 'id_pedido', $id_factura_origen);
                                                    $traking = "https://fenix.laarcourier.com/Tracking/Guiacompleta.aspx?guia=" . get_row('guia_laar', 'guia_laar', 'id_pedido', $id_factura_origen);
                                                } else {
                                                    $url = get_row('guia_laar', 'url_guia', 'id_pedido', $id_factura);
                                                    $traking = "https://fenix.laarcourier.com/Tracking/Guiacompleta.aspx?guia=" . get_row('guia_laar', 'guia_laar', 'id_pedido', $id_factura);
                                                }


                                                echo $data["estadoActualCodigo"];

                                            ?>
                                <a style="cursor: pointer;" href="<?php echo $url; ?>" target="blank"><span class="badge <?php echo $span_estado; ?>"><?php echo $estado_guia; ?></span></a><BR>
                                <a style="cursor: pointer;" href="<?php echo $url; ?>" target="blank"><span class=""><?php echo $guia_numero; ?></span></a><BR>
                                <a style="cursor: pointer;" href="<?php echo $traking; ?>" target="blank"><img width="40px" src="../../img_sistema/rastreo.png" alt="" /></a>

                            <?php
                                            } else {
                                                if ($estado_factura == 0) {
                                                    echo 'GUIA ANULADA';
                                                } else {
                                                    echo 'NO ENVIADA';
                                                }
                                            } ?>
                        </td>
                        <td>
                            <select onchange="obtener_datos('<?php echo $id_factura; ?>')" id="estado_sistema<?php echo $id_factura; ?>" class='form-control <?php echo $label_class; ?>' name='mod_estado' id='mod_estado'>
                                <option value="">-- Selecciona --</option>
                                <?php
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
                                        <a class="dropdown-item" href="editar_cotizacion.php?id_factura=<?php echo $id_factura; ?>"><i class='fa fa-edit'></i> Editar</a>
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