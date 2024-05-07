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
    function nombreImpuestoRetencion($codigo) {
        $codigos = [
            "9" => "Retencion de IVA 10%",
            "10" => "Retencion de IVA 20%",
            "1" => "Retencion de IVA 30%",
            "11" => "Retencion de IVA 50%",
            "2" => "Retencion de IVA 70%",
            "3" => "Retencion de IVA 100%",
            "303" => "Honorarios profesionales y demás pagos por servicios relacionados con el título profesional",
            "304" => "Servicios predomina el intelecto no relacionados con el título profesional",
            "304A" => "Comisiones y demás pagos por servicios predomina intelecto no relacionados con el título profesional",
            "304B" => "Pagos a notarios y registradores de la propiedad y mercantil por sus actividades ejercidas como tales",
            "304C" => "Pagos a deportistas, entrenadores, árbitros, miembros del cuerpo técnico por sus actividades ejercidas como tales",
            "304D" => "Pagos a artistas por sus actividades ejercidas como tales",
            "304E" => "Honorarios y demás pagos por servicios de docencia",
            "307" => "Servicios predomina la mano de obra",
            "308" => "Utilización o aprovechamiento de la imagen o renombre",
            "309" => "Servicios prestados por medios de comunicación y agencias de publicidad",
            "310" => "Servicio de transporte privado de pasajeros o transporte público o privado de carga",
            "311" => "Pagos a través de liquidación de compra (nivel cultural o rusticidad)",
            "312" => "Transferencia de bienes muebles de naturaleza corporal",
            "312A" => "Compra de bienes de origen agrícola, avícola, pecuario, apícola, cunícula, bioacuático, y forestal",
            "312B" => "Impuesto a la Renta único para la actividad de producción y cultivo de palma aceitera",
            "314A" => "Regalías por concepto de franquicias de acuerdo a Ley de Propiedad Intelectual - pago a personas naturales",
            "314B" => "Cánones, derechos de autor,  marcas, patentes y similares de acuerdo a Ley de Propiedad Intelectual – pago a personas naturales",
            "314C" => "Regalías por concepto de franquicias de acuerdo a Ley de Propiedad Intelectual  - pago a sociedades",
            "314D" => "Cánones, derechos de autor,  marcas, patentes y similares de acuerdo a Ley de Propiedad Intelectual – pago a sociedades",
            "319" => "Cuotas de arrendamiento mercantil (prestado por sociedades), inclusive la de opción de compra",
            "320" => "Arrendamiento bienes inmuebles",
            "322" => "Seguros y reaseguros (primas y cesiones)",
            "323" => "Rendimientos financieros pagados a naturales y sociedades  (No a IFIs)",
            "323A" => "Rendimientos financieros: depósitos Cta. Corriente",
            "323B1" => "Rendimientos financieros:  depósitos Cta. Ahorros Sociedades",
            "323E" => "Rendimientos financieros: depósito a plazo fijo  gravados",
            "323E2" => "Rendimientos financieros: depósito a plazo fijo exentos",
            "323F" => "Rendimientos financieros: operaciones de reporto - repos",
            "323G" => "Inversiones (captaciones) rendimientos distintos de aquellos pagados a IFIs",
            "323H" => "Rendimientos financieros: obligaciones",
            "323I" => "Rendimientos financieros: bonos convertible en acciones",
            "323 M" => "Rendimientos financieros: Inversiones en títulos valores en renta fija gravados ",
            "323 N" => "Rendimientos financieros: Inversiones en títulos valores en renta fija exentos",
            "323 O" => "Intereses y demás rendimientos financieros pagados a bancos y otras entidades sometidas al control de la Superintendencia de Bancos y de la Economía Popular y Solidaria",
            "323 P" => "Intereses pagados por entidades del sector público a favor de sujetos pasivos",
            "323Q" => "Otros intereses y rendimientos financieros gravados ",
            "323R" => "Otros intereses y rendimientos financieros exentos",
            "323S" => "Pagos y créditos en cuenta efectuados por el BCE y los depósitos centralizados de valores, en calidad de intermediarios, a instituciones del sistema financiero por cuenta de otras personas naturales y sociedades",
            "323T" => "Rendimientos financieros originados en la deuda pública ecuatoriana",
            "323U" => "Rendimientos financieros originados en títulos valores de obligaciones de 360 días o más para el financiamiento de proyectos públicos en asociación público-privada",
            "324A" => "Intereses y comisiones en operaciones de crédito entre instituciones del sistema financiero y entidades economía popular y solidaria.",
            "324B" => "Inversiones entre instituciones del sistema financiero y entidades economía popular y solidaria",
            "324C" => "Pagos y créditos en cuenta efectuados por el BCE y los depósitos centralizados de valores, en calidad de intermediarios, a instituciones del sistema financiero por cuenta de otras instituciones del sistema financiero",
            "325" => "Anticipo dividendos a residentes o establecidos en el Ecuador",
            "325A" => "Préstamos accionistas, beneficiarios o partícipes residentes o establecidos en el Ecuador",
            "326" => "Dividendos distribuidos que correspondan al impuesto a la renta único establecido en el art. 27 de la LRTI ",
            "327" => "Dividendos distribuidos a personas naturales residentes",
            "328" => "Dividendos distribuidos a sociedades residentes",
            "329" => "Dividendos distribuidos a fideicomisos residentes",
            "330" => "Dividendos gravados distribuidos en acciones (reinversión de utilidades sin derecho a reducción tarifa IR)",
            "331" => "Dividendos exentos distribuidos en acciones (reinversión de utilidades con derecho a reducción tarifa IR) ",
            "332" => "Otras compras de bienes y servicios no sujetas a retención",
            "332B" => "Compra de bienes inmuebles",
            "332C" => "Transporte público de pasajeros",
            "332D" => "Pagos en el país por transporte de pasajeros o transporte internacional de carga, a compañías nacionales o extranjeras de aviación o marítimas",
            "332E" => "Valores entregados por las cooperativas de transporte a sus socios",
            "332F" => "Compraventa de divisas distintas al dólar de los Estados Unidos de América",
            "332G" => "Pagos con tarjeta de crédito ",
            "332H" => "Pago al exterior tarjeta de crédito reportada por la Emisora de tarjeta de crédito, solo RECAP",
            "332I" => "Pago a través de convenio de debito (Clientes IFI`s)",
            "333" => "Enajenación de derechos representativos de capital y otros derechos cotizados en bolsa ecuatoriana",
            "334" => "Enajenación de derechos representativos de capital y otros derechos no cotizados en bolsa ecuatoriana",
            "335" => "Loterías, rifas, apuestas y similares",
            "336" => "Venta de combustibles a comercializadoras",
            "337" => "Venta de combustibles a distribuidores",
            "338" => "Compra local de banano a productor",
            "339" => "Liquidación impuesto único a la venta local de banano de producción propia",
            "340" => "Impuesto único a la exportación de banano de producción propia - componente 1",
            "341" => "Impuesto único a la exportación de banano de producción propia - componente 2",
            "342" => "Impuesto único a la exportación de banano producido por terceros",
            "343" => "Otras retenciones aplicables el 1%",
            "343A" => "Energía eléctrica",
            "343B" => "Actividades de construcción de obra material inmueble, urbanización, lotización o actividades similares",
            "343C" => "Impuesto Redimible a las botellas plásticas - IRBP",
            "344" => "Otras retenciones aplicables el 2%",
            "344A" => "Pago local tarjeta de crédito reportada por la Emisora de tarjeta de crédito, solo RECAP",
            "344B" => "Adquisición de sustancias minerales dentro del territorio nacional",
            "345" => "Otras retenciones aplicables el 8%",
            "346" => "Otras retenciones aplicables a otros porcentajes ",
            "346A" => "Otras ganancias de capital distintas de enajenación de derechos representativos de capital ",
            "346B" => "Donaciones en dinero -Impuesto a la donaciones ",
            "346C" => "Retención a cargo del propio sujeto pasivo por la exportación de concentrados y/o elementos metálicos",
            "346D" => "Retención a cargo del propio sujeto pasivo por la comercialización de productos forestales",
            "500" => "Pago a no residentes - Rentas Inmobiliarias",
            "501" => "Pago a no residentes - Beneficios/Servicios  Empresariales",
            "501A" => "Pago a no residentes - Servicios técnicos, administrativos o de consultoría y regalías",
            "503" => "Pago a no residentes- Navegación Marítima y/o aérea",
            "504" => "Pago a no residentes- Dividendos distribuidos a personas naturales (domicilados o no en paraiso fiscal) o a sociedades sin beneficiario efectivo persona natural residente en Ecuador (ni domiciladas en paraíso fiscal)",
            "504A" => "Pago al exterior - Dividendos a sociedades con beneficiario efectivo persona natural residente en el Ecuador (no domiciliada en paraísos fiscales o regímenes de menor imposición)",
            "504B" => "Pago a no residentes - Dividendos a fideicomisos con beneficiario efectivo persona natural residente en el Ecuador (no domiciliada en paraísos fiscales o regímenes de menor imposición)",
            "504C" => "Pago a no residentes - Dividendos a sociedades domiciladas en paraísos fiscales o regímenes de menor imposición (con o sin beneficiario efectivo persona natural residente en el Ecuador)",
            "504D" => "Pago a no residentes - Dividendos a fideicomisos domiciladas en paraísos fiscales o regímenes de menor imposición (con o sin beneficiario efectivo persona natural residente en el Ecuador)",
            "504E" => "Pago a no residentes - Anticipo dividendos (no domiciliada en paraísos fiscales o regímenes de menor imposición)",
            "504F" => "Pago a no residentes - Anticipo dividendos (domiciliadas en paraísos fiscales o regímenes de menor imposición)",
            "504G" => "Pago a no residentes - Préstamos accionistas, beneficiarios o partìcipes (no domiciladas en paraísos fiscales o regímenes de menor imposición)",
            "504H" => "Pago a no residentes - Préstamos accionistas, beneficiarios o partìcipes (domiciladas en paraísos fiscales o regímenes de menor imposición)",
            "504I" => "Pago a no residentes - Préstamos no comerciales a partes relacionadas  (no domiciladas en paraísos fiscales o regímenes de menor imposición)",
            "504J" => "Pago a no residentes - Préstamos no comerciales a partes relacionadas  (domiciladas en paraísos fiscales o regímenes de menor imposición)",
            "505" => "Pago a no residentes - Rendimientos financieros",
            "505A" => "Pago a no residentes – Intereses de créditos de Instituciones Financieras del exterior",
            "505B" => "Pago a no residentes – Intereses de créditos de gobierno a gobierno",
            "505C" => "Pago a no residentes – Intereses de créditos de organismos multilaterales",
            "505D" => "Pago a no residentes - Intereses por financiamiento de proveedores externos",
            "505E" => "Pago a no residentes - Intereses de otros créditos externos",
            "505F" => "Pago a no residentes - Otros Intereses y Rendimientos Financieros",
            "509" => "Pago a no residentes- Cánones, derechos de autor,  marcas, patentes y similares",
            "509A" => "PPago a no residentes - Regalías por concepto de franquicias",
            "510" => "Pago a no residentes - Otras ganancias de capital distintas de enajenación de derechos representativos de capital ",
            "511" => "Pago a no residentes - Servicios profesionales independientes",
            "512" => "Pago a no residentes - Servicios profesionales dependientes",
            "513" => "Pago a no residentes- Artistas",
            "513A" => "Pago a no residentes - Deportistas",
            "514" => "Pago a no residentes - Participación de consejeros",
            "515" => "Pago a no residentes - Entretenimiento Público",
            "516" => "Pago a no residentes - Pensiones",
            "517" => "Pago a no residentes- Reembolso de Gastos",
            "518" => "Pago a no residentes- Funciones Públicas",
            "519" => "Pago a no residentes - Estudiantes",
            "520A" => "Pago a no residentes - Pago a proveedores de servicios hoteleros y turísticos en el exterior",
            "520B" => "Pago a no residentes - Arrendamientos mercantil internacional",
            "520D" => "Pago a no residentes - Comisiones por exportaciones y por promoción de turismo receptivo",
            "520E" => "Pago a no residentes - Por las empresas de transporte marítimo o aéreo y por empresas pesqueras de alta mar, por su actividad.",
            "520F" => "Pago a no residentes - Por las agencias internacionales de prensa",
            "520G" => "Pago a no residentes - Contratos de fletamento de naves para empresas de transporte aéreo o marítimo internacional",
            "521" => "Pago a no residentes - Enajenación de derechos representativos de capital y otros derechos ",
            "523A" => "Pago a no residentes - Seguros y reaseguros (primas y cesiones)  ",
            "525" => "Pago a no residentes- Donaciones en dinero -Impuesto a la donaciones"
        ];
    
        return isset($codigos[$codigo]) ? utf8_encode($codigos[$codigo]) : "Codigo no registrado";
    }
    $daterange      = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['range'], ENT_QUOTES)));
    //$estado_factura = intval($_REQUEST['estado_factura']);
    //$employee_id    = intval($_REQUEST['employee_id']);
    //$tables         = "facturas_ventas,  users, comprobantes_sri";
    //$campos         = "*";
    //$sWhere         = "users.id_users=facturas_ventas.id_users_factura and facturas_ventas.id_factura = comprobantes_sri.id_factura";
    /*if ($estado_factura > 0) {
        $sWhere .= " and facturas_ventas.estado_factura = '" . $estado_factura . "' ";
    }
    if ($employee_id > 0) {
        $sWhere .= " and facturas_ventas.id_vendedor = '" . $employee_id . "' ";
    }*/
    
    $sWhere = "";
    if (!empty($daterange)) {
        list($f_inicio, $f_final)                    = explode(" - ", $daterange); //Extrae la fecha inicial y la fecha final en formato espa?ol
        list($dia_inicio, $mes_inicio, $anio_inicio) = explode("/", $f_inicio); //Extrae fecha inicial
        $fecha_inicial                               = "$anio_inicio-$mes_inicio-$dia_inicio 00:00:00"; //Fecha inicial formato ingles
        list($dia_fin, $mes_fin, $anio_fin)          = explode("/", $f_final); //Extrae la fecha final
        $fecha_final                                 = "$anio_fin-$mes_fin-$dia_fin 23:59:59";


        $sWhere .= "r.fecha_factura between '$fecha_inicial' and '$fecha_final' ";
    }

    include 'pagination.php'; //include pagination file
    //pagination variables
    $page      = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page  = 100; //how much records you want to show
    $adjacents = 4; //gap between pages after number of adjacents
    $offset    = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query = mysqli_query($conexion, "SELECT count(*) AS numrows FROM impuestocomprobanteretencion20 icr
                                            INNER JOIN retencion20 r ON r.id_factura = icr.id_retencion
                                            WHERE $sWhere ");
    if ($row = mysqli_fetch_array($count_query)) {$numrows = $row['numrows'];} else {echo mysqli_error($conexion);}
    $total_pages = ceil($numrows / $per_page);
    $reload      = '../rep_retenciones_totales.php';
    //main query to fetch the data
    //echo "SELECT $campos FROM  $tables where $sWhere LIMIT $offset,$per_page";
    $sWhere .= " order by icr.codigo, icr.codigoretencion ASC";
    /*$sql = "SELECT icr.codigo AS codigo, icr.codigoretencion AS codigor, SUM(icr.baseimponible) AS base, SUM(icr.valorretenido) AS valor
            FROM impuestocomprobanteretencion20 icr
            INNER JOIN retencion20 r ON r.id_factura = icr.id_retencion
            where $sWhere LIMIT $offset,$per_page";*/
    $query = mysqli_query($conexion, "SELECT icr.codigo AS codigo, icr.codigoretencion AS codigor, SUM(icr.baseimponible) AS base, SUM(icr.valorretenido) AS valor
                                        FROM impuestocomprobanteretencion20 icr
                                        INNER JOIN retencion20 r ON r.id_factura = icr.id_retencion
                                        where $sWhere LIMIT $offset,$per_page");
    //loop through fetched data
    //var_dump($query);die;
    if ($numrows > 0) {
        ?>

        <div class="table-responsive">
            <table class="table table-condensed table-hover table-striped table-sm">
                <tr>
                    <!--<th class='text-center'>Nº</th>-->
                    <th class='text-center'>Tipo de Retencion</th>
                    <th class='text-center'>Codigo Retencion</th>
                    <th class='text-center'>Concepto</th>
                    <th class='text-center'>Base Imponible </th>
                    <th class='text-left'>Valor Retenido </th>
                </tr>
                <?php
$finales = 0;
        while ($row = mysqli_fetch_array($query)) {
            $codigo           = $row['codigo'];
            if($codigo  != null){
                $tiporetencion    = $row["codigo"];
                $codigor    = $row["codigor"];
                $base    = $row["base"];
                $valor    = $row["valor"];
                if($tiporetencion == '1'){
                    $tiporetencion = 'RENTA';
                }elseif($tiporetencion == '2'){
                    $tiporetencion = 'IVA';
                }else{
                    $tiporetencion = 'ISD';
                }
                $nombreretenido = nombreImpuestoRetencion($row['codigo']);
                
                /*$date_added        = $row['fecha_factura'];
                $user_fullname     = $row['nombre_users'] . ' ' . $row['apellido_users'];
                $subtotal          = $row['monto_factura'];
                $total             = $row['monto_factura'];
                $Estado            = $row['Estado'];
                $id_cliente        = $row['id_cliente'];
                $id_vendedor        = $row['id_vendedor'];
                $estado_factura    = $row['estado_factura'];
                $sql               = mysqli_query($conexion, "select * from clientes where id_cliente='" . $id_cliente . "'");
                $rw                = mysqli_fetch_array($sql);
                $cliente           = $rw['nombre_cliente'];
                $dias_credito           = $rw['dias_credito'];
                $formapago             = $row['formaPago'];
                $mensajesri        = $row['Mensaje'];
                $dinero_resibido_fac    = $row['dinero_resibido_fac'];
                if($Estado == null){
                    $Estado = 'Sin Envio';
                    $label_classe = 'badge-warning';
                    $mensajesri = '';
                }elseif($Estado == 'AUTORIZADO'){
                    $Estado = $row['Estado'];
                    $label_classe = 'badge-success';
                    $mensajesri = '';
                }else{
                    $Estado = $row['Estado'];
                    $label_classe = 'badge-danger';
                    $mensajesri = $row['Mensaje'];
                }


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
                $nombre_vendedor = get_row('users', 'CONCAT(nombre_users, " ", apellido_users)', 'id_users', $id_vendedor);
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
                    
                }*/
                ?>
                        <tr>
                            <!--<td class='text-center'><label class='badge badge-purple'><?php echo $factura; ?></label></td>-->
                            <td class='text-center'><?php echo $tiporetencion; ?></td>
                            <td class='text-center'><?php echo $codigor; ?></td>
                            <td class='text-center'><?php echo $nombreretenido; ?></td>
                            <td class='text-center'><?php echo $base; ?></td>
                            <td ><?php echo $valor; ?></td>
                            <!--<td class='text-center'><?php echo $fecha; ?></td>
                            <td class='text-center'><span class="badge <?php echo $label_class; ?>"><?php echo $text_estado; ?></span></td>
                            <td class='text-center'><span class="badge <?php echo $label_classe; ?>"><?php echo $Estado; ?></span></td>
                            <td class='text-center'><?php echo $mensajesri; ?></td>
                            <td class='text-center'><?php echo $formapago; ?></td>-->
                            <?php
                        /*if($diff->days>$dias_credito){
                                            $label_dias = 'badge-danger';

                        }else{
                            $label_dias = 'badge-success';
                        }*/
                            ?>
                            <!--<td class='text-center'><span class="badge <?php echo $label_dias; ?>"><?php echo $diff->days ;?></span></td>-->
                        
                            <!--<td><?php echo $user_fullname; ?></td>
                            <td><?php echo $nombre_vendedor; ?></td>
                            <td><?php echo $dinero_resibido_fac; ?></td>
                            <td class='text-left'><b><?php echo $simbolo_moneda . '' . number_format($total, 2); ?></b></td>-->
                        </tr>
                        <?php 
            }else{
                ?>
                <tr>
                      <td colspan='5'>Sin Datos</td>
                </tr>
                <?php 
            }
            ?>
            
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

