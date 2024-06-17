<?php
/*-------------------------
Autor: Eduardo Vega
---------------------------*/
error_reporting(E_ALL);
ini_set('display_errors', '1');

include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
//Archivo de funciones PHP
require_once "../funciones.php";
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Wallets";
// dominio mas protocolo
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';

$dominio_completo =     $protocol . $_SERVER['HTTP_HOST'];

$dominio_actual = $_SERVER['HTTP_HOST'];

$dominio_actual = str_replace('www.', '', $dominio_actual);
$dominio_actual = str_replace('.com', '', $dominio_actual);
$dominio_actual = str_replace('.net', '', $dominio_actual);

permisos($modulo, $cadena_permisos);
if ($_GET['filtro']) {
    $filtro = $_GET['filtro'];
    if ($filtro == 'mayor_menor') {
        $band = "btn-primary";
        $bandd = "btn-secondary";
    } else {
        $band = "btn-secondary";
        $bandd = "btn-primary";
    }
}
echo $dominio_actual;
//Finaliza Control de Permisos
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if ($dominio_actual == 'merkapro.ec' || $dominio_actual == '77.37.67.232') {

    if ($action == "ajax") {
        // escaping, additionally removing everything that could be (html/javascript-) code
        $q = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
        $sTable = "cabecera_cuenta_pagar ccp";
        $sWhere = "";
        $sWhere .= "";
        if ($_GET['q'] != "") {
            $sWhere .= " and ccp.tienda like '%$q%'";
        }
        $sWhere .= "";

        include 'pagination.php'; //include pagination file
        //pagination variables  
        $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
        $per_page = 10; //how much records you want to show
        if ($_GET["numero"]) {
            $per_page  = $_GET["numero"]; //how much records you want to show

        }
        $adjacents  = 4; //gap between pages after number of adjacents
        $offset = ($page - 1) * $per_page;
        //Count the total number of row in your table*/
        $count_query   = mysqli_query($conexion, "SELECT count(DISTINCT ccp.tienda) AS numrows FROM $sTable  $sWhere");
        $row = mysqli_fetch_array($count_query);
        $numrows = $row['numrows'];
        $total_pages = ceil($numrows / $per_page);
        $reload = '../reportes/wallet.php';
        //main query to fetch the data
        $sql = "SELECT DISTINCT ccp.tienda, (SELECT COUNT(*) FROM cabecera_cuenta_pagar ccp2 WHERE ccp2.tienda = ccp.tienda AND (ccp2.visto = 0 OR ccp2.visto IS NULL)) AS guias_pendientes FROM  $sTable $sWhere order by guias_pendientes DESC LIMIT $offset,$per_page ";
        $query = mysqli_query($conexion, $sql);
        $query = mysqli_fetch_all($query);

        if ($numrows > 0 && $dominio_actual == 'merkapro.ec') {
?>
            <!-- activar modal -->
            <div class="">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#dataUpdate">
                    Actualizar Datos
                </button>
            </div>
            <!-- modal -->

            <div class="modal fade" id="dataUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tiendaModalLabel">Cargar Wallet</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="boody">
                            <div class="relative">
                                <form id="update">
                                    <label for="start-date">Fecha Inicio</label>
                                    <input type="text" id="start-date" name="fecha_desde" class="form-control bg-white border text-dark rounded" placeholder="&#x1F4C5; Fecha Inicio" readonly>
                                    <button type="submit" class="btn btn-primary" id="btnFiltrar">Actualizar</button>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                        <tr class="info">
                            <th class="text-center">Tienda </th>
                            <th class="text-center">Total Venta</th>
                            <th class="text-center">Total Utilidad</th>
                            <th class="text-center">Saldo Pendiente</th>
                            <th class="text-center">Guías Pendientes</th>
                            <th class="text-center">Excel</th>
                            <th colspan="3"></th>
                        </tr>
                    </thead>
                    <tbody id="resultados">

                        <?php
                        foreach ($query as $row) {
                            $tienda = $row[0];
                            $total_venta_sql = "SELECT SUM(subquery.total_venta) as total_ventas, SUM(subquery.total_pendiente) as total_pendiente, SUM(subquery.monto_recibir) as monto_recibir FROM ( SELECT numero_factura, MAX(total_venta) as total_venta, MAX(valor_pendiente) as total_pendiente, MAX(monto_recibir) as monto_recibir FROM cabecera_cuenta_pagar WHERE tienda = '$tienda' and visto = '1' GROUP BY numero_factura ) as subquery;";

                            $query_total_venta = mysqli_query($conexion, $total_venta_sql);
                            $row_total_venta = mysqli_fetch_array($query_total_venta);


                            $total_venta = $row_total_venta['total_ventas'];
                            $total_pendiente = $row_total_venta['total_pendiente'];

                            $total_venta = number_format($total_venta, 2);
                            $total_pendiente = number_format($total_pendiente, 2);

                            $simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);

                            $guias_faltantes = "SELECT COUNT(*) FROM cabecera_cuenta_pagar WHERE tienda = '$tienda' AND (visto = 0 OR visto IS NULL)";
                            $query_guias_faltantes = mysqli_query($conexion, $guias_faltantes);
                            $row_guias_faltantes = mysqli_fetch_array($query_guias_faltantes);
                            $guias_faltantes = $row_guias_faltantes[0];

                            $sql_total_pagos = "SELECT SUM(valor) from pagos where tienda = '$tienda'";
                            $valor_total_pagos_query = mysqli_query($conexion, $sql_total_pagos);
                            $valor_total_pagos_SQL = mysqli_fetch_array($valor_total_pagos_query);
                            $valor_total_pagos = $valor_total_pagos_SQL['SUM(valor)'];

                            $monto_recibir = $row_total_venta['monto_recibir'];
                            if ($valor_total_pagos > $monto_recibir) {
                                $monto_recibir = $valor_total_pagos - $monto_recibir;
                                $monto_recibir *= -1;
                                $monto_recibir = number_format($monto_recibir, 2);
                            } else {
                                $monto_recibir = number_format($monto_recibir, 2);
                            }



                        ?>

                            <tr>
                                <td class="text-center"> <a href="pagar_wallet.php?id_factura=&tienda=<?php echo $tienda ?>"> <?php echo $tienda; ?></a></td>
                                <td class="text-center"><?php echo $simbolo_moneda . $total_venta; ?></td>
                                <td class="text-center"><?php echo $simbolo_moneda . $total_pendiente; ?></td>
                                <td class="text-center"><?php echo $simbolo_moneda . $monto_recibir; ?></td>
                                <td class="text-center"><?php echo $guias_faltantes; ?></td>
                                <td class="text-center">
                                    <!-- descargar excel -->
                                    <div class="container">
                                        <button id="downloadExcel" class="btn btn-success" onclick="descargarExcel('<?php echo $tienda; ?>')">Descargar Excel</button>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group dropdown">
                                        <button type="button" class="btn btn-warning btn-sm dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"> <i class='fa fa-cog'></i> <i class="caret"></i> </button>
                                        <div class="dropdown-menu dropdown-menu-right">

                                            <?php
                                            if ($permisos_eliminar == 1) { ?>
                                                <!--<a class="dropdown-item" href="#" data-toggle="modal" data-target="#dataDelete" data-id="<?php echo $row['id_factura']; ?>"><i class='fa fa-trash'></i> Eliminar</a>-->
                                            <?php } ?>
                                            <a href="pagar_wallet.php?id_factura=&tienda=<?php echo $tienda ?>" class="dropdown-item"> <i class="ti-wallet"></i> Pagar </a>

                                        </div>

                                    </div>

                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    <tr>
                        <td colspan=10><span class="pull-right">
                                <?php
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
    }
} else {
    if ($action == "ajax") {



        // escaping, additionally removing everything that could be (html/javascript-) code
        $sDominio = 'imporsuit_marketplace';
        $conexion_db = mysqli_connect('localhost', $sDominio, $sDominio, $sDominio);
        $q = mysqli_real_escape_string($conexion_db, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
        $sTable = "cabecera_cuenta_pagar";
        $sWhere = "";
        $sWhere .= " WHERE  cabecera_cuenta_pagar.tienda = '$dominio_completo' and visto ='1' ";
        $filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'todos';
        //obtiene ?tienda=tienda
        if ($filtro == 'mayor_menor') {
            $sWhere .= " and valor_pendiente != 0";
        } else if ($filtro == 'cero') {
            $sWhere .= " and valor_pendiente = 0";
        } else {
            $sWhere .= "";
        }


        if ($_GET['q'] != "") {
            $sWhere .= "";
        }
        $sWhere .= "";
        include 'pagination.php'; //include pagination file
        //pagination variables  
        $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
        $per_page = 10; //how much records you want to show
        if (isset($_GET["numero"])) {
            $per_page  = $_GET["numero"]; //how much records you want to show
        }
        $adjacents  = 4; //gap between pages after number of adjacents
        $offset = ($page - 1) * $per_page;
        //Count the total number of row in your table*/
        $count_query   = mysqli_query($conexion_db, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
        $row = mysqli_fetch_array($count_query);
        $numrows = $row['numrows'];
        $total_pages = ceil($numrows / $per_page);
        $reload = '../reportes/wallet.php';
        //main query to fetch the data
        $sql = "SELECT DISTINCT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
        $query = mysqli_query($conexion_db, $sql);
        $simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
        //loop through fetched data

        $total_pendiente_a_la_tienda_sql = "SELECT 
        SUM(CASE WHEN subquery.numero_factura NOT LIKE 'proveedor%' AND subquery.numero_factura NOT LIKE 'referido%' THEN subquery.total_venta ELSE 0 END) AS total_ventas,
        SUM(subquery.total_pendiente) AS total_pendiente, -- Se incluyen todas las facturas
        SUM(CASE WHEN subquery.numero_factura NOT LIKE 'proveedor%' AND subquery.numero_factura NOT LIKE 'referido%' THEN subquery.total_cobrado ELSE 0 END) AS total_cobrado,
        SUM(CASE WHEN subquery.numero_factura NOT LIKE 'proveedor%' AND subquery.numero_factura NOT LIKE 'referido%' THEN subquery.monto_recibir ELSE 0 END) AS monto_recibir
    FROM (
        SELECT 
            numero_factura, 
            MAX(total_venta) AS total_venta, 
            MAX(valor_pendiente) AS total_pendiente, 
            MAX(valor_cobrado) AS total_cobrado, 
            MAX(monto_recibir) AS monto_recibir 
        FROM cabecera_cuenta_pagar 
        WHERE tienda = '$dominio_completo' 
            AND visto = '1'
        GROUP BY numero_factura
    ) AS subquery;";
        $query_total_pendiente_a_la_tienda = mysqli_query($conexion_db, $total_pendiente_a_la_tienda_sql);
        $row_total_pendiente_a_la_tienda = mysqli_fetch_array($query_total_pendiente_a_la_tienda);

        $valor_total_tienda = $row_total_pendiente_a_la_tienda['total_ventas'];
        $total_valor_cobrado = $row_total_pendiente_a_la_tienda['total_cobrado'];
        $total_valor_pendiente = $row_total_pendiente_a_la_tienda['total_pendiente'];
        $total_monto_recibir = $row_total_pendiente_a_la_tienda['monto_recibir'];

        $guias_faltantes = "SELECT COUNT(*) FROM cabecera_cuenta_pagar WHERE tienda = '$dominio_completo' AND (visto = 0 OR visto IS NULL)";
        $query_guias_faltantes = mysqli_query($conexion_db, $guias_faltantes);
        $row_guias_faltantes = mysqli_fetch_array($query_guias_faltantes);
        $guias_faltantes = $row_guias_faltantes[0];

        $sql_total_pagos = "SELECT SUM(valor) from pagos where tienda = '$dominio_completo'";
        $valor_total_pagos_query = mysqli_query($conexion_db, $sql_total_pagos);
        $valor_total_pagos_SQL = mysqli_fetch_array($valor_total_pagos_query);
        $valor_total_pagos = $valor_total_pagos_SQL['SUM(valor)'];

        // ver ganancias como referido y proveedor
        $sql_referidos = "SELECT SUM(monto_recibir) FROM `cabecera_cuenta_pagar` WHERE tienda = '$dominio_completo' and numero_factura like '%-R'";
        $ganancias_referido_query = mysqli_query($conexion_db, $sql_referidos);
        $ganancias_referido_SQL = mysqli_fetch_array($ganancias_referido_query);
        if (empty($ganancias_referido_SQL['SUM(monto_recibir)'])) {
            $ganancias_referido = 0;
        } else {
            $ganancias_referido = $ganancias_referido_SQL['SUM(monto_recibir)'];
        }

        $sql_proveedor = "SELECT SUM(monto_recibir) FROM `cabecera_cuenta_pagar` WHERE tienda = '$dominio_completo' and numero_factura like '%-P'";
        $ganancias_proveedor_query = mysqli_query($conexion_db, $sql_proveedor);
        $ganancias_proveedor_SQL = mysqli_fetch_array($ganancias_proveedor_query);
        if (empty($ganancias_proveedor_SQL['SUM(monto_recibir)'])) {
            $ganancias_proveedor = 0;
        } else {
            $ganancias_proveedor = $ganancias_proveedor_SQL['SUM(monto_recibir)'];
        }
        if ($numrows > 0) { {
            ?>
                <!-- descargar excel -->
                <div class="container">
                    <button id="downloadExcel" class="btn btn-success" onclick="descargarExcel('<?php echo $dominio_completo; ?>')">Descargar Excel</button>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="col-lg-12 col-md-6">
                            <div class="card-box widget-icon">
                                <div>
                                    <i class="mdi mdi-basket text-primary"></i>
                                    <div class="wid-icon-info text-right">
                                        <p class="text-muted m-b-5 font-13 font-bold text-uppercase">MONTO DE VENTA</p>
                                        <h4 class="m-t-0 m-b-5 counter font-bold text-primary"><?php echo $simbolo_moneda . '' . number_format($valor_total_tienda, 2); ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-6">
                            <div class="card-box widget-icon">
                                <div>
                                    <i class="mdi mdi-briefcase-check text-primary"></i>
                                    <div class="wid-icon-info text-right d-flex justify-content-end gap-2">
                                        <div class="">
                                            <p class="text-muted m-b-5 font-13 font-bold text-uppercase">Utilidad como Referido</p>
                                            <h4 class="m-t-0 m-b-5 counter font-bold text-success"><?php echo $simbolo_moneda . '' . number_format($ganancias_referido, 2)  ?></h4>
                                        </div>
                                        <div class="">
                                            <p class="text-muted m-b-5 font-13 font-bold text-uppercase">Utilidad como Proveedor</p>
                                            <h4 class="m-t-0 m-b-5 counter font-bold text-success"><?php echo $simbolo_moneda . '' . number_format($ganancias_proveedor, 2)  ?></h4>
                                        </div>
                                        <div class="">

                                            <p class="text-muted m-b-5 font-13 font-bold text-uppercase">Utilidad Generada</p>
                                            <h4 class="m-t-0 m-b-5 counter font-bold text-primary"><?php echo $simbolo_moneda . '' . number_format($total_monto_recibir, 2); ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-6">
                            <div class="card-box widget-icon">
                                <div>
                                    <i class="mdi mdi-cash-multiple text-success"></i>
                                    <div class="wid-icon-info text-right">
                                        <p class="text-muted m-b-5 font-13 font-bold text-uppercase">TOTAL ABONADO</p>
                                        <h4 class="m-t-0 m-b-5 counter font-bold text-success"><?php echo $simbolo_moneda . '' . number_format($valor_total_pagos, 2); ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $url_ubicacion = $_SERVER["HTTP_HOST"];
                        $sql_deuda = "SELECT SUM(monto_recibir) FROM `cabecera_cuenta_pagar` WHERE tienda = '$dominio_completo' AND `monto_recibir` < 0 AND visto = '1' ORDER by monto_recibir ASC;";
                        $valor_total_pendiente_query = mysqli_query($conexion_db, $sql_deuda);
                        $valor_total_pendiente_SQL = mysqli_fetch_array($valor_total_pendiente_query);
                        $valor_total_pendiente_deuda = $valor_total_pendiente_SQL['SUM(monto_recibir)'];

                        $sql_Ganancia = "SELECT SUM(monto_recibir) FROM `cabecera_cuenta_pagar` WHERE tienda = '$dominio_completo' AND `monto_recibir` > 0 AND visto = '1' ORDER by monto_recibir ASC;";
                        $valor_total_Ganancia_query = mysqli_query($conexion_db, $sql_Ganancia);
                        $valor_total_Ganancia_SQL = mysqli_fetch_array($valor_total_Ganancia_query);
                        $valor_total_Ganancia = $valor_total_Ganancia_SQL['SUM(monto_recibir)'];

                        ?>

                        <div class="col-lg-12 col-md-6">
                            <div class="card-box widget-icon">
                                <div>
                                    <i class="mdi mdi-cash-100 text-success "></i>
                                    <div class="wid-icon-info text-right">
                                        <p class="text-muted m-b-5 font-13 font-bold text-uppercase">Ganacia de Ventas</p>
                                        <h4 class="m-t-0 m-b-5 counter font-bold text-success"><?php echo $simbolo_moneda . '' . number_format($valor_total_Ganancia, 2); ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-6">
                            <div class="card-box widget-icon">
                                <div>
                                    <i class="mdi mdi-exclamation text-danger "></i>
                                    <div class="wid-icon-info text-right">
                                        <p class="text-muted m-b-5 font-13 font-bold text-uppercase">Descuentos de Devolución</p>
                                        <h4 class="m-t-0 m-b-5 counter font-bold text-danger"><?php echo $simbolo_moneda . '' . number_format($valor_total_pendiente_deuda, 2); ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-6">
                            <div class="card-box widget-icon">
                                <div>
                                    <i class="mdi mdi-store text-danger "></i>
                                    <div class="wid-icon-info text-right d-flex justify-content-end gap-2">
                                        <div class="col-4">
                                            &nbsp;
                                        </div>

                                        <?php
                                        $sql_billetera = "SELECT saldo FROM billeteras WHERE tienda = '$dominio_completo'";
                                        $query_billetera = mysqli_query($conexion_db, $sql_billetera);
                                        $row_billetera = mysqli_fetch_array($query_billetera);
                                        $saldo_billetera = $row_billetera['saldo'];
                                        ?>


                                        <div class="">
                                            <p class="text-muted m-b-5 font-13 font-bold text-uppercase">SALDO PENDIENTE A TIENDA</p>
                                            <h4 class="m-t-0 m-b-5 counter font-bold text-danger"><?php echo $simbolo_moneda . '' . number_format($saldo_billetera, 2); ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-6">
                            <div class="card-box widget-icon">
                                <div>
                                    <i class="mdi mdi-receipt text-warnihg "></i>
                                    <div class="wid-icon-info text-right">
                                        <p class="text-muted m-b-5 font-13 font-bold text-uppercase">Guías pendiente de revision</p>
                                        <h4 class="m-t-0 m-b-5 counter font-bold text-warnihg"><?php echo $guias_faltantes ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div id="outerpay">

                        </div>
                    </div>
                </div>
                <!-- Botones para filtrar registros -->
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn <?php echo $band ?>" onclick="filtrarRegistros('mayor_menor')">Pendientes</button>
                    <button type="button" class="btn <?php echo $bandd ?>" onclick="filtrarRegistros('cero')">Pagados</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr class="info">
                                <th class="text-center"># Orden </th>
                                <th class="text-center"># Guia </th>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Cliente</th>
                                <th class="text-center">Tienda</th>
                                <th class="text-center">Estado de la Guia</th>
                                <th class="text-center">Total Venta</th>
                                <th class="text-center">Costo</th>
                                <th class="text-center">Precio de Envio</th>
                                <th class="text-center">Full Fillment</th>
                                <th class="text-center">Monto a recibir</th>
                                <th class="text-center">Valor cobrado</th>
                                <th class="text-center">Valor pendiente</th>
                                <th class="text-center">Recibos</th>
                            </tr>
                        </thead>
                        <tbody id="resultados">
                            <?php
                            while ($row = mysqli_fetch_array($query)) {
                                $id_factura = $row['numero_factura'];
                                $id_cabecera = $row['id_cabecera'];
                                $fecha = date('d/m/Y', strtotime($row['fecha']));
                                $nombre_cliente = $row['cliente'];
                                $tienda = $row[4];
                                $estado_guia = $row['estado_guia'];
                                $total_venta = $row['total_venta'];
                                $costo = $row['costo'];
                                $precio_envio = $row['precio_envio'];
                                $monto_recibir = $row['monto_recibir'];
                                $estado_factura = $row['estado_pedido'];

                                $valor_cobrado = $row['valor_cobrado'];
                                $full = $row['full'];
                                $valor_pendiente = $row['valor_pendiente'];
                                $guia_laar = $row['guia_laar'];

                                $guia_enviada = $row["estado_guia"];

                                $label_class = '';
                                if ($guia_enviada == 7) {
                                    $guia_enviada = "Entregada";
                                    $label_class = 'badge-success';
                                } else if ($guia_enviada == 9) {
                                    $guia_enviada = "Devuelta";
                                    $label_class = 'badge-danger';
                                } else {
                                    $guia_enviada = "En Proceso";
                                    $label_class = 'badge-warning';
                                }

                                $url_laar = "https://fenix.laarcourier.com/Tracking/Guiacompleta.aspx?guia=" . $guia_laar;
                                $drogshipin_sql = "SELECT * FROM facturas_cot WHERE numero_factura = '$id_factura'";
                                $query_drogshipin = mysqli_query($conexion_db, $drogshipin_sql);
                                $row_drogshipin = mysqli_fetch_array($query_drogshipin);

                            ?>
                                <input type="hidden" value="<?php echo $estado_factura; ?>" id="estado<?php echo $id_factura; ?>">

                                <tr class="<?php echo $color_row ?>">
                                    <td class="text-center"><label class="badge badge-purple"> <?php echo $id_factura; ?></label></td>
                                    <td class="text-center"><a href="<?php echo $url_laar; ?>" class="badge badge-pink"> <?php echo $guia_laar; ?> </a> <br> <?php
                                                                                                                                                                $numero_factura = $row['numero_factura'];

                                                                                                                                                                ?></td>
                                    <td class="text-center"><?php echo $fecha; ?></td>
                                    <td class="text-center"><?php echo $nombre_cliente; ?></td>
                                    <td class="text-center"><?php echo $tienda; ?></td>
                                    <td class="text-center"><span class="badge <?php echo $label_class; ?>"><?php echo $guia_enviada; ?></span></td>
                                    <td class="text-center"><?php echo $simbolo_moneda . $total_venta; ?></td>
                                    <td class="text-center"><?php echo $simbolo_moneda . $costo; ?></td>
                                    <td class="text-center"><?php echo $simbolo_moneda . $precio_envio; ?></td>
                                    <td class="text-center"><?php echo $simbolo_moneda . $full; ?></td>
                                    <td class="text-center"><?php echo $simbolo_moneda . $monto_recibir; ?></td>
                                    <td class="text-center"><?php echo $simbolo_moneda . $valor_cobrado; ?></td>
                                    <td class="text-center"><?php echo $simbolo_moneda . $valor_pendiente; ?></td>
                                    <td class="text-center"><button class="btn btn-sm btn-outline-primary" onclick="cargar_recibos('<?php echo $id_cabecera ?>')"><i class="ti-receipt"></i></button></td>

                                </tr>

                            <?php
                            }
                            ?>
                        </tbody>
                        <tr>
                            <td colspan=10><span class="pull-right">
                                    <?php
                                    echo paginate($reload, $page, $total_pages, $adjacents);
                                    ?></span></td>
                        </tr>
                    </table>
                </div>

            <?php
            }
        } else {
            ?>
            <!-- descargar excel -->
            <div class="container">
                <button id="downloadExcel" class="btn btn-success" onclick="descargarExcel('<?php echo $dominio_completo; ?>')">Descargar Excel</button>
            </div>
            <div class="row">

                <div class="col-lg-4">

                    <div class="col-lg-12 col-md-6">
                        <div class="card-box widget-icon">
                            <div>
                                <i class="mdi mdi-basket text-primary"></i>
                                <div class="wid-icon-info text-right">
                                    <p class="text-muted m-b-5 font-13 font-bold text-uppercase">MONTO DE VENTA</p>
                                    <h4 class="m-t-0 m-b-5 counter font-bold text-primary"><?php echo $simbolo_moneda . '' . number_format($valor_total_tienda, 2); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-6">
                        <div class="card-box widget-icon">
                            <div>
                                <i class="mdi mdi-briefcase-check text-primary"></i>
                                <div class="wid-icon-info text-right d-flex justify-content-end gap-2">
                                    <div class="">
                                        <p class="text-muted m-b-5 font-13 font-bold text-uppercase">Utilidad como Referido</p>
                                        <h4 class="m-t-0 m-b-5 counter font-bold text-success"><?php echo $simbolo_moneda . '' . number_format($ganancias_referido, 2)  ?></h4>
                                    </div>
                                    <div class="">
                                        <p class="text-muted m-b-5 font-13 font-bold text-uppercase">Utilidad como Proveedor</p>
                                        <h4 class="m-t-0 m-b-5 counter font-bold text-success"><?php echo $simbolo_moneda . '' . number_format($ganancias_proveedor, 2)  ?></h4>
                                    </div>
                                    <div class="">

                                        <p class="text-muted m-b-5 font-13 font-bold text-uppercase">Utilidad Generada</p>
                                        <h4 class="m-t-0 m-b-5 counter font-bold text-primary"><?php echo $simbolo_moneda . '' . number_format($total_monto_recibir, 2); ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-6">
                        <div class="card-box widget-icon">
                            <div>
                                <i class="mdi mdi-cash-multiple text-success"></i>
                                <div class="wid-icon-info text-right">
                                    <p class="text-muted m-b-5 font-13 font-bold text-uppercase">TOTAL ABONADO</p>
                                    <h4 class="m-t-0 m-b-5 counter font-bold text-success"><?php echo $simbolo_moneda . '' . number_format($total_valor_cobrado, 2); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $url_ubicacion = $_SERVER["HTTP_HOST"];
                    $sql_deuda = "SELECT SUM(valor_pendiente) FROM `cabecera_cuenta_pagar` WHERE tienda = '$dominio_completo' AND `valor_pendiente` < 0 AND visto = '1' ORDER by monto_recibir ASC;";
                    $valor_total_pendiente_query = mysqli_query($conexion_db, $sql_deuda);
                    $valor_total_pendiente_SQL = mysqli_fetch_array($valor_total_pendiente_query);
                    $valor_total_pendiente_deuda = $valor_total_pendiente_SQL['SUM(valor_pendiente)'];

                    $sql_Ganancia = "SELECT SUM(valor_pendiente) FROM `cabecera_cuenta_pagar` WHERE tienda = '$dominio_completo' AND `monto_recibir` > 0 AND visto = '1' ORDER by monto_recibir ASC;";
                    $valor_total_Ganancia_query = mysqli_query($conexion_db, $sql_Ganancia);
                    $valor_total_Ganancia_SQL = mysqli_fetch_array($valor_total_Ganancia_query);
                    $valor_total_Ganancia = $valor_total_Ganancia_SQL['SUM(valor_pendiente)'];

                    ?>

                    <div class="col-lg-12 col-md-6">
                        <div class="card-box widget-icon">
                            <div>
                                <i class="mdi mdi-cash-100 text-success "></i>
                                <div class="wid-icon-info text-right">
                                    <p class="text-muted m-b-5 font-13 font-bold text-uppercase">Ganacia de Ventas</p>
                                    <h4 class="m-t-0 m-b-5 counter font-bold text-success"><?php echo $simbolo_moneda . '' . number_format($valor_total_Ganancia, 2); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-6">
                        <div class="card-box widget-icon">
                            <div>
                                <i class="mdi mdi-exclamation text-danger "></i>
                                <div class="wid-icon-info text-right">
                                    <p class="text-muted m-b-5 font-13 font-bold text-uppercase">Descuentos de Devolución</p>
                                    <h4 class="m-t-0 m-b-5 counter font-bold text-danger"><?php echo $simbolo_moneda . '' . number_format($valor_total_pendiente_deuda, 2); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-6">
                        <div class="card-box widget-icon">
                            <div>
                                <i class="mdi mdi-store text-danger "></i>
                                <div class="wid-icon-info text-right d-flex justify-content-end gap-2">
                                    <div class="col-4">
                                        &nbsp;
                                    </div>

                                    <?php
                                    $sql_billetera = "SELECT * FROM billeteras WHERE tienda = '$dominio_completo'";
                                    $query_billetera = mysqli_query($conexion_db, $sql_billetera);
                                    $row_billetera = mysqli_fetch_array($query_billetera);
                                    if (empty($row_billetera)) {
                                        $saldo_billetera = 0;
                                    } else {
                                        $saldo_billetera = $row_billetera['saldo'];
                                    }
                                    ?>

                                    <div class="">
                                        <p class="text-muted m-b-5 font-13 font-bold text-uppercase">SALDO PENDIENTE A TIENDA</p>
                                        <h4 class="m-t-0 m-b-5 counter font-bold text-danger"><?php echo $simbolo_moneda . '' . number_format($saldo_billetera, 2); ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-6">
                        <div class="card-box widget-icon">
                            <div>
                                <i class="mdi mdi-receipt text-warnihg "></i>
                                <div class="wid-icon-info text-right">
                                    <p class="text-muted m-b-5 font-13 font-bold text-uppercase">Guías pendiente de revision</p>
                                    <h4 class="m-t-0 m-b-5 counter font-bold text-warnihg"><?php echo $guias_faltantes ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div id="outerpay">

                    </div>
                </div>
            </div>


            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn <?php echo $band ?>" onclick="filtrarRegistros('mayor_menor')">Pendientes</button>
                <button type="button" class="btn <?php echo $bandd ?>" onclick="filtrarRegistros('cero')">Pagados</button>
            </div>
            <div class="alert alert-warning alert-dismissible" role="alert" align="center">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Aviso!</strong> No hay Registro de Guias
            </div>

<?php
        }
    }
}
?>


<script>
    function filterData() {
        var fecha = document.getElementById('fecha').value;
        var estado = document.getElementById('estado').value;

        var url = '../ajax/filtro_input.php?fecha_inicio=' + fecha + '&fecha_fin=' + fecha + '&estado=' + estado;
        var ajax = new XMLHttpRequest();
        ajax.open('GET', url, true);
        ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                document.getElementById('resultados').innerHTML = ajax.responseText;
            }
        }
        ajax.send();
    }

    function verProveedor() {
        var url = "../ajax/proveedor.php";
        let tienda = "<?php echo $dominio_completo ?>";

        $.ajax({
            url: url,
            type: "POST",
            data: {
                tienda: tienda,
            },
            success: function(response) {
                $("#proveedor").html(response);
            },
        });
    }

    flatpickr("#start-date", {
        dateFormat: "Y-m-d",
        locale: "es",
        maxDate: "today",
        disableMobile: "true"
    });
    flatpickr("#end-date", {
        dateFormat: "Y-m-d",
        locale: "es",
        maxDate: "today",
        disableMobile: "true"
    });

    verProveedor();

    $("#update").submit(function(e) {
        e.preventDefault();
        var url = "../ajax/cargar_wallet.php";
        $.ajax({
            type: "POST",
            url: url,
            data: $("#update").serialize(),
            success: function(data) {
                $("#result").html(data);
            }
        });
    });

    function filtrarFecha() {
        const buscar_numero2 = document.getElementById('buscar_numero2').value;

    }

    function descargarExcel(tienda) {
        fetch(`../ajax/descargar_excel.php?tienda=${encodeURIComponent(tienda)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.blob();
            })
            .then(blob => {
                console.log(blob);
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = url;
                a.download = 'datos.csv';
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
            })
            .catch(error => {
                alert('Error: ' + error);
            });
    }
</script>