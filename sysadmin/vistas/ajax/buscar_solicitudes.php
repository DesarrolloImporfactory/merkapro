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
$modulo = "Wallets";

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
if ($action == 'ajax' and $server_url == "https://marketplace.imporsuit.com") {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q      = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $sTable = "solicitudes_pago, datos_banco_usuarios";
    $sWhere = "";
    $sWhere .= " where cantidad !=0 and solicitudes_pago.id_cuenta = datos_banco_usuarios.id_cuenta";
    if ($_GET['q'] != "") {
        $sWhere .= " and solicitudes_pago.id_cuenta = (SELECT id_cuenta from datos_banco_usuarios where tienda like '%$q%') and solicitudes_pago.id_cuenta = datos_banco_usuarios.id_cuenta";
    }

    $sWhere .= " ORDER BY `solicitudes_pago`.`visto` ASC, `solicitudes_pago`.`fecha` DESC";
    include 'pagination.php'; //include pagination file
    //pagination variables
    $page      = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page  = 10; //how much records you want to show
    if (isset($_GET["numero"])) {
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
                    <th class="text-center"><input type="checkbox" name="todos" id="todos"></th>
                    <th class="text-center">Fecha</th>
                    <th class="text-center">Cliente</th>
                    <th class="text-center">Tienda</th>
                    <th class="text-center">Banco</th>
                    <th class="text-center">Tipo de cuenta</th>
                    <th class="text-center">Numero de cuenta</th>
                    <th class="text-center">Cedula</th>
                    <th class="text-center">Telefono</th>
                    <th class="text-center">Correo</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-center">Ir a Wallet</th>
                    <th class="text-center">¿Borrar?</th>



                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($query)) {
                    $id_cuenta = $row['id_cuenta'];
                    $id_solicitud = $row['id_solicitud'];
                    $fecha = $row['fecha'];
                    $tienda = $row['tienda'];
                    $banco = $row['banco'];
                    $tipo_cuenta = $row['tipo_cuenta'];
                    $numero_cuenta = $row['numero_cuenta'];
                    $cedula = $row['cedula'];
                    $telefono = $row['telefono'];
                    $correo = $row['correo'];
                    $cantidad = $row['cantidad'];
                    $nombre = $row['nombre'];
                    $visto = $row['visto'];

                    $simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
                ?>
                    <input type="hidden" value="<?php echo $id_cuenta; ?>" id="estado<?php echo $id_cuenta; ?>" />

                    <tr class="align-middle">
                        <td class="align-middle"><input onchange="visto('<?php echo $id_solicitud; ?>')" type="checkbox" name="item" id="<?php echo $id_solicitud; ?>" <?php if ($visto == 1) {
                                                                                                                                                                            echo "checked disabled";
                                                                                                                                                                        } ?>></td>
                        <td class="text-center align-middle"><span><?php echo $fecha; ?></span></td>
                        <td class="align-middle text-center"><label class='badge badge-purple'><?php echo $nombre; ?></label></td>
                        <td class="text-center align-middle"><span><?php echo $tienda; ?></span></td>
                        <td class="text-center align-middle"><?php echo '<strong>' . $banco . '</strong>'; ?></td>
                        <td class="text-center align-middle"><span><?php echo $tipo_cuenta; ?></span></td>
                        <td class="text-center align-middle"><span><?php echo $numero_cuenta; ?></span></td>
                        <td class="text-center align-middle"><span><?php echo $cedula; ?></span></td>
                        <td class="text-center align-middle"><span><?php echo $telefono; ?></span></td>
                        <td class="text-center align-middle"><span><?php echo $correo; ?></span></td>
                        <td class="text-center align-middle"><span><?php echo $simbolo_moneda . '' . number_format($cantidad, 2); ?></span></td>
                        <td class="text-center align-middle"><a href="pagar_wallet.php?id_factura=&tienda=<?php echo $tienda; ?>" class="btn btn-sm btn-success"><i class="ti ti-wallet"></i></a></td>
                        <td class="text-center align-middle"><button class="btn btn-sm btn-danger" onclick="eliminar_solicitud('<?php echo $id_solicitud; ?>')"> <i class="ti ti-trash"></i> </button> </td>
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
            <strong>Aviso!</strong> No hay Registro de Solicitudes de Pago.
        </div>

<?php
    }
    // fin else
}
