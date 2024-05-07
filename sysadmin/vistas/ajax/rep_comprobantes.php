<?php
include "is_logged.php"; //Archivo comprueba si el usuario esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
#require_once "../libraries/inventory.php"; //Contiene funcion que controla stock en el inventario
//Inicia Control de Permisos
include "../permisos.php";
//Archivo de funciones PHP
require_once "../funciones.php";
$user_id = $_SESSION['id_users'];
$action  = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    $daterange      = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['range'], ENT_QUOTES)));
    $estado_factura = strval($_REQUEST['estado_factura']);
    //$employee_id    = intval($_REQUEST['employee_id']);
    //$tables         = "facturas_ventas,  users";
    //$sWhere         = "users.id_users=facturas_ventas.id_users_factura";
    /*if ($employee_id > 0) {
        $sWhere .= " and facturas_ventas.id_vendedor = '" . $employee_id . "' ";
    }*/
    $sWheref = '';
    $sWherel = '';
    $sWherec = '';
    $sWhered = '';
    $sWhereg = '';
    $sWherer = '';
    if (!empty($daterange)) {
        list($f_inicio, $f_final)                    = explode(" - ", $daterange); //Extrae la fecha inicial y la fecha final en formato espa?ol
        list($dia_inicio, $mes_inicio, $anio_inicio) = explode("/", $f_inicio); //Extrae fecha inicial
        $fecha_inicial                               = "$anio_inicio-$mes_inicio-$dia_inicio 00:00:00"; //Fecha inicial formato ingles
        list($dia_fin, $mes_fin, $anio_fin)          = explode("/", $f_final); //Extrae la fecha final
        $fecha_final                                 = "$anio_fin-$mes_fin-$dia_fin 23:59:59";
        if ($estado_factura == 'F') {
            $sql = "
                SELECT COUNT(*) AS numrows
                FROM facturas_ventas 
                INNER JOIN clientes ON clientes.id_cliente = facturas_ventas.id_cliente
                WHERE facturas_ventas.fecha_factura between '$fecha_inicial' and '$fecha_final'
                order by facturas_ventas.id_factura 
             ";
        }elseif($estado_factura == 'LC'){
            $sql = "
                SELECT COUNT(*) AS numrows
                 FROM liquidacioncompra
                INNER JOIN clientes ON clientes.id_cliente = liquidacioncompra.id_cliente
                WHERE liquidacioncompra.fechaEmision between '$fecha_inicial' and '$fecha_final' 
                order by liquidacioncompra.id_factura";
        }elseif($estado_factura == 'NC'){
            $sql = "
                SELECT COUNT(*) AS numrows
                FROM notacredito
                INNER JOIN clientes ON clientes.id_cliente = notacredito.id_cliente
                WHERE notacredito.fechaEmision between '$fecha_inicial' and '$fecha_final' 
                order by notacredito.id_factura";
        }elseif($estado_factura == 'ND'){
            $sql = "
                SELECT COUNT(*) AS numrows
                 FROM notadebito20
                INNER JOIN clientes ON clientes.id_cliente = notadebito20.id_cliente
                WHERE notadebito20.fechaEmision between '$fecha_inicial' and '$fecha_final'
                order by notadebito20.id_factura";
        }elseif($estado_factura == 'GR'){
            $sql = "
                SELECT COUNT(*) AS numrows
                 FROM guia
                INNER JOIN clientes ON clientes.id_cliente = guia.id_cliente
                WHERE guia.fecha_factura between '$fecha_inicial' and '$fecha_final' 
                order by guia.id_factura";
        }elseif($estado_factura == 'CR'){
            $sql = "
                SELECT COUNT(*) AS numrows
                FROM retencion20
                INNER JOIN clientes ON clientes.id_cliente = retencion20.id_cliente
                WHERE retencion20.fechaEmision between '$fecha_inicial' and '$fecha_final' 
                order by retencion20.id_factura";
        }else{

            $sql = "(
                SELECT COUNT(*) AS numrows
                FROM facturas_ventas 
                INNER JOIN clientes ON clientes.id_cliente = facturas_ventas.id_cliente
                $sWheref
             )
             UNION ALL
             (
                SELECT COUNT(*) AS numrows
                 FROM liquidacioncompra
                INNER JOIN clientes ON clientes.id_cliente = liquidacioncompra.id_cliente
                $sWherel
             )
             UNION ALL
             (
                SELECT COUNT(*) AS numrows
                 FROM notacredito
                INNER JOIN clientes ON clientes.id_cliente = notacredito.id_cliente
                $sWherec
             )
             UNION ALL
             (
                SELECT COUNT(*) AS numrows
                 FROM notadebito20
                INNER JOIN clientes ON clientes.id_cliente = notadebito20.id_cliente
                $sWhered
             )
             UNION ALL
             (
                SELECT COUNT(*) AS numrows
                 FROM guia
                INNER JOIN clientes ON clientes.id_cliente = guia.id_cliente
                $sWhereg
             )
             UNION ALL
             (
                SELECT COUNT(*) AS numrows
                FROM retencion20
                INNER JOIN clientes ON clientes.id_cliente = retencion20.id_cliente
                $sWherer
             );";
        }
        //$sWhere .= " and facturas_ventas.fecha_factura between '$fecha_inicial' and '$fecha_final' ";
    }
    
    include 'pagination.php'; //include pagination file
    //pagination variables
    $page      = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page  = 100; //how much records you want to show
    $adjacents = 4; //gap between pages after number of adjacents
    $offset    = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    //$sql = "SELECT count(*) AS numrows FROM $tables where $sWhere ";
    
    $numrows = 0;
    $count_query = mysqli_query($conexion, $sql);
    if ($count_query->num_rows > 0) {
        while ($obj = mysqli_fetch_object($count_query)) {
            //var_dump ( $obj->numrows);
            $numrows += intval($obj->numrows);
        }
    } else {
        echo mysqli_error($conexion);
    }
    //var_dump($numrows);die;
    $total_pages = ceil($numrows / $per_page);
    $reload      = '../rep_comprobantes.php';
    //main query to fetch the data
    //echo "SELECT $campos FROM  $tables where $sWhere LIMIT $offset,$per_page";
    //$query = mysqli_query($conexion, "SELECT $campos FROM  $tables where $sWhere LIMIT $offset,$per_page");
    if ($estado_factura == 'F') {
         if(!empty($daterange)){
            $wheref = "WHERE facturas_ventas.fecha_factura between '$fecha_inicial' and '$fecha_final'";
         }else{
            $wheref = '';
         }
        $sqlquery = "
            SELECT id_factura,numero_factura,clientes.nombre_cliente,facturas_ventas.fecha_factura as fecha_factura,facturas_ventas.monto_factura,'Factura_Venta' AS  Comprobante,facturas_ventas.estado_factura
            FROM facturas_ventas 
            INNER JOIN clientes ON clientes.id_cliente = facturas_ventas.id_cliente
            $wheref
            order by facturas_ventas.id_factura LIMIT $offset,$per_page
         ";
         
    }elseif($estado_factura == 'LC'){
        if(!empty($daterange)){
            $wherel = "WHERE liquidacioncompra.fechaEmision between '$fecha_inicial' and '$fecha_final'";
         }else{
            $wherel = '';
         }

        $sqlquery = "
            SELECT id_factura,numero_factura,clientes.nombre_cliente,liquidacioncompra.fechaEmision as fecha_factura,liquidacioncompra.monto_factura,'Liquidacion_Compra' AS  Comprobante,liquidacioncompra.estado_factura
             FROM liquidacioncompra
            INNER JOIN clientes ON clientes.id_cliente = liquidacioncompra.id_cliente
            $wherel 
            order by liquidacioncompra.id_factura LIMIT $offset,$per_page";
            //var_dump($sqlquery);die;
    }elseif($estado_factura == 'NC'){
        if(!empty($daterange)){
            $wherec = "WHERE notacredito.fechaEmision between '$fecha_inicial' and '$fecha_final'";
         }else{
            $wherec = '';
         }
        $sqlquery = "
            SELECT id_factura,numero_factura,clientes.nombre_cliente,notacredito.fechaEmision as fecha_factura,notacredito.monto_factura,'Nota_Credito' AS  Comprobante,notacredito.estado_factura
            FROM notacredito
            INNER JOIN clientes ON clientes.id_cliente = notacredito.id_cliente
            $wherec
            order by notacredito.id_factura LIMIT $offset,$per_page";
    }elseif($estado_factura == 'ND'){
        if(!empty($daterange)){
            $whered = "WHERE notadebito20.fechaEmision between '$fecha_inicial' and '$fecha_final'";
         }else{
            $whered = '';
         }
        $sqlquery = "
            SELECT id_factura,numero_factura,clientes.nombre_cliente,notadebito20.fechaEmision as fecha_factura,notadebito20.monto_factura,'Nota_Debito' AS  Comprobante,notadebito20.estado_factura
             FROM notadebito20
            INNER JOIN clientes ON clientes.id_cliente = notadebito20.id_cliente
            $whered
            order by notadebito20.id_factura LIMIT $offset,$per_page";
    }elseif($estado_factura == 'GR'){
        if(!empty($daterange)){
            $whereg = "WHERE guia.fecha_factura between '$fecha_inicial' and '$fecha_final'";
         }else{
            $whereg = '';
         }
        $sqlquery = "
            SELECT id_factura,numero_factura,clientes.nombre_cliente,guia.fecha_factura as fecha_factura,guia.monto_factura,'Guia_Remision' AS  Comprobante,guia.estado_factura
             FROM guia
            INNER JOIN clientes ON clientes.id_cliente = guia.id_cliente
            $whereg 
            order by guia.id_factura LIMIT $offset,$per_page";
    }elseif($estado_factura == 'CR'){
        if(!empty($daterange)){
            $wherer = "WHERE retencion20.fechaEmision between '$fecha_inicial' and '$fecha_final'";
         }else{
            $wherer = '';
         }
        $sqlquery = "
            SELECT id_factura,numero_factura,clientes.nombre_cliente,retencion20.fechaEmision as fecha_factura,retencion20.monto_factura,'Retencion' AS  Comprobante,retencion20.estado_factura
            FROM retencion20
            INNER JOIN clientes ON clientes.id_cliente = retencion20.id_cliente
            $wherer 
            order by retencion20.id_factura LIMIT $offset,$per_page";
            //var_dump($sqlquery);die;
    }else{

        $sqlquery = "(
            SELECT id_factura,numero_factura,clientes.nombre_cliente,facturas_ventas.fecha_factura,facturas_ventas.monto_factura,'Factura_Venta' AS  Comprobante,facturas_ventas.estado_factura
            FROM facturas_ventas 
            INNER JOIN clientes ON clientes.id_cliente = facturas_ventas.id_cliente
            $sWheref
         )
         UNION ALL
         (
            SELECT id_factura,numero_factura,clientes.nombre_cliente,liquidacioncompra.fechaEmision,liquidacioncompra.monto_factura,'Liquidacion_Compra' AS  Comprobante,liquidacioncompra.estado_factura
             FROM liquidacioncompra
            INNER JOIN clientes ON clientes.id_cliente = liquidacioncompra.id_cliente
            $sWherel
         )
         UNION ALL
         (
            SELECT id_factura,numero_factura,clientes.nombre_cliente,notacredito.fechaEmision,notacredito.monto_factura,'Nota_Credito' AS  Comprobante,notacredito.estado_factura
             FROM notacredito
            INNER JOIN clientes ON clientes.id_cliente = notacredito.id_cliente
            $sWherec
         )
         UNION ALL
         (
            SELECT id_factura,numero_factura,clientes.nombre_cliente,notadebito20.fechaEmision,notadebito20.monto_factura,'Nota_Debito' AS  Comprobante,notadebito20.estado_factura
             FROM notadebito20
            INNER JOIN clientes ON clientes.id_cliente = notadebito20.id_cliente
            $sWhered
         )
         UNION ALL
         (
            SELECT id_factura,numero_factura,clientes.nombre_cliente,guia.fecha_factura,guia.monto_factura,'Guia_Remision' AS  Comprobante,guia.estado_factura
             FROM guia
            INNER JOIN clientes ON clientes.id_cliente = guia.id_cliente
            $sWhereg
         )
         UNION ALL
         (
            SELECT id_factura,numero_factura,clientes.nombre_cliente,retencion20.fechaEmision,retencion20.monto_factura,'Retencion' AS  Comprobante,retencion20.estado_factura
            FROM retencion20
            INNER JOIN clientes ON clientes.id_cliente = retencion20.id_cliente
            $sWherer
         ) LIMIT $offset,$per_page ;";
    }
    $query = mysqli_query($conexion, $sqlquery);
    //loop through fetched data

    if ($numrows > 0) {
        ?>
        <div class="table-responsive">
            <table class="table table-condensed table-hover table-striped table-sm">
                <tr>
                    <th class='text-center'>Comprobante</th>
                    <th class='text-center'>Comprobante Nº</th>
                    <th>Cliente</th>
                    <th class='text-center'>Fecha </th>
                    <th class='text-center'>Estado Factura </th>
                    <th class='text-left'>Total </th>
                </tr>
                <?php
        $finales = 0;
        while ($row = mysqli_fetch_array($query)) {
            $factura           = $row['numero_factura'];
            $date_added        = $row['fecha_factura'];
            $user_fullname     = $row['nombre_cliente'];
            $total             = $row['monto_factura'];
            $comprobante       = $row['Comprobante'];
            //$subtotal          = $row['monto_factura'];
            //$id_cliente        = $row['id_cliente'];
            //$id_vendedor        = $row['id_vendedor'];
            $estado_factura    = $row['estado_factura'];
            //$sql               = mysqli_query($conexion, "select * from clientes where id_cliente='" . $id_cliente . "'");
            //$rw                = mysqli_fetch_array($sql);
            //$cliente           = $rw['nombre_cliente'];
            //$dias_credito           = $rw['dias_credito'];
            $date_added=Date($date_added);
            $date=Date("Y-m-d H:i:s");
            
            $date1 = new DateTime($date_added);
             date_default_timezone_set('America/Guayaquil');
            $date2 = new DateTime("now");
            $diff = $date1->diff($date2);
// 38 minutes to go [number is variable]

// passed means if its negative and to go means if its positive

            //$diff = $date->diff($date_added);
            
            //echo $date;
            list($date, $hora) = explode(" ", $date_added);
            list($Y, $m, $d)   = explode("-", $date);
            $fecha             = $d . "-" . $m . "-" . $Y;
            $finales++;
            $simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
            //$nombre_vendedor = get_row('users', 'CONCAT(nombre_users, " ", apellido_users)', 'id_users', $id_vendedor);
             if ($estado_factura == 0) {
                $text_estado = "Anulada";
                $label_class = 'badge-warning';
                
            }
            if ($estado_factura == 1) {
                $text_estado = "Pagada";
                $label_class = 'badge-success';
                
            } 
             if ($estado_factura == 2) {
                $text_estado = "Pendiente";
                $label_class = 'badge-danger';
                
            }
            ?>
                    <tr> 
                        <td class='text-center'><label class='badge badge-success'><?php echo $comprobante; ?></label></td>
                        <td class='text-center'><label class='badge badge-purple'><?php echo $factura; ?></label></td>
                        <td><?php echo $user_fullname; ?></td>
                        <td class='text-center'><?php echo $fecha; ?></td>
                        <td class='text-center'><span class="badge <?php echo $label_class; ?>"><?php echo $text_estado; ?></span></td>
                        <?php
                    /*if($diff->days>$dias_credito){
                                        $label_dias = 'badge-danger';

                    }else{
                        $label_dias = 'badge-success';
                    }*/
                        ?>
                        <!--<td class='text-center'><span class="badge <?php echo $label_dias; ?>"><?php echo $diff->days ;?></span></td>
                       
                        <td><?php echo $user_fullname; ?></td>
                         
                        <td><?php echo $nombre_vendedor; ?></td>-->
                        <td class='text-left'><b><?php echo $simbolo_moneda . '' . number_format($total, 2); ?></b></td>
                    </tr>
                    <?php }?>
                </table>
            </div>

            <div class="box-footer clearfix" align="right">

                <?php
$inicios = $offset + 1;
        $finales += $inicios - 1;
        echo "Mostrando $inicios al $finales de $numrows registros";
        echo paginate($reload, $page, $total_pages, $adjacents);?>

            </div>

            <?php
}
}
?>

