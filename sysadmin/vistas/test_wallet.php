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
if ($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q      = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $sTable = "facturas_cot, clientes, users";
    $sWhere = "";
    $sWhere .= " WHERE estado_factura <> 8 and estado_factura <> 7 and drogshipin <> 0 and drogshipin <> 2 and drogshipin <> 4 and facturas_cot.id_cliente=clientes.id_cliente and facturas_cot.id_vendedor=users.id_users";
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

        print_r($query);
    }
}
?>
<!-- 

<div class="table-responsive">
    <table class="table table-sm table-striped">
        <thead>

            <tr class="info">
                <th># Orden</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>TIPO</th>
                <th>TIENDA</th>
                <th>Telefono</th>
                <th>Localidad</th>
                <th>Direccion</th>

                <th colspan="2" style="text-align: center;">Estado</th>

                <th class='text-center'>Total</th>
                <th></th>
                <th></th>

            </tr>
        </thead>
        <tbody id="guia">

        </tbody>

        <script>
            async function validar_laar(guia) {
                let data = await fetch('https://api.laarcourier.com:9727/guias/' + guia, {
                    method: 'GET',
                })
                let result = await data.json();
                if (result["novedades"].length > 0) {
                    result["novedades"].forEach(element => {
                        if (element["codigoTipoNovedad"] == 42 || element["codigoTipoNovedad"] == 96) {
                            result["estado_codigo"] = 9;
                        } else {
                            result["estado_codigo"] = 7;
                        }
                    });
                } else {
                    result["estado_codigo"] = result["estadoActualCodigo"];
                }

                document.getElementById('guia').innerHTML += `
                <tr>
                        <td>${result["noGuia"]}</td>
                        <td>${result["destinatarioFecha"]}</td>
                        <td>${result["nombreCliente"]}</td>
                        <td>0</td>
                        <td>${result["nombreTienda"]}</td>
                        <td>${result["telefonoDestino2"]}</td>
                        <td>${result["direccionDestino"]}</td>
                        <td>${result["direccionOrigen"]}</td>
                        <td>${result["estado_codigo"]}</td>
                        <td>0</td>
                        <td>0</td>
                        </tr>
                

                    `
            }
        </script>
 -->
<?php
/*
        require_once "./db.php"; //Contiene las variables de configuracion para conectar a la base de datos
        require_once "./php_conexion.php"; //Contiene funcion que conecta a la base de datos
        require_once "./funciones.php"; //Contiene funcion que conecta a la base de datos


        $guias_laar = 'SELECT * FROM `guia_laar`WHERE guia_laar != "" ORDER BY `fecha` DESC';

        $guias_laar = mysqli_query($conexion, $guias_laar);

        while ($rw = mysqli_fetch_assoc($guias_laar)) {
            echo "<script> validar_laar('" . $rw['guia_laar'] . "')</script>";
        }
*/

?>