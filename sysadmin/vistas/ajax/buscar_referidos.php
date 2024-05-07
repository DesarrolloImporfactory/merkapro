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

$conexion_market = mysqli_connect("localhost", "imporsuit_marketplace", "imporsuit_marketplace", "imporsuit_marketplace");

// validar si tiene enlace referido
$validar_referido = "SELECT referido, token_referido FROM plataformas WHERE url_imporsuit = '$dominio_completo'";
$query_validar_referido = mysqli_query($conexion_market, $validar_referido);
$row_validar_referido = mysqli_fetch_array($query_validar_referido);
$referido = $row_validar_referido['referido'];
$token = $row_validar_referido['token_referido'];
if ($referido == 0 || $referido == '' || $referido == NULL) {
    echo '<div class="alert alert-warning alert-dismissible" role="alert" align="center">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Aviso!</strong> Aún no tienes un enlace de referido
    
    <br>
    <button class="btn btn-sm btn-success" onclick="generar_referido()">Generar enlace</button>

</div>';
    exit;
}

$enlace_referido = "https://registro.imporsuit.com/registro_referidos.php?premium=3&referido=$token";
echo '
<div class="alert alert-success alert-dismissible" role="alert" align="center">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"></span></button>
    <strong>Enlace de referido:</strong> <a href="' . $enlace_referido . '" target="_blank">' . $enlace_referido . '</a>
</div>
';
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';

if ($action == "ajax") {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q = mysqli_real_escape_string($conexion_market, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $sTable = "plataformas";
    $sWhere = "";
    $sWhere .= " WHERE refiere = '$token'";
    if ($_GET['q'] != "") {
        $sWhere .= " and nombre_tienda like '%$q%'";
    }
    $sWhere .= "";


    include 'pagination.php'; //include pagination file
    //pagination variables  
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 10; //how much records you want to show
    $adjacents  = 4; //gap between pages after number of adjacents
    $offset = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query   = mysqli_query($conexion_market, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
    $row = mysqli_fetch_array($count_query);
    $numrows = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload = '../reportes/wallet.php';
    //main query to fetch the data
    $sql = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
    $query = mysqli_query($conexion_market, $sql);
    $query = mysqli_fetch_all($query);

    if ($numrows > 0) {
?>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="thead-light">
                    <tr class="info">
                        <th class="text-center">Nombre de Tienda</th>
                        <th class="text-center">Dueño</th>
                        <th class="text-center">Contacto</th>
                        <th class="text-center">Fecha ingreso</th>
                        <th class="text-center">Fecha Caduca</th>
                        <th class="text-center">Enlace</th>
                    </tr>
                </thead>
                <tbody id="resultados">

                    <?php
                    foreach ($query as $row) {
                        $id_plataforma = $row[0];
                        $nombre_tienda = $row[1];
                        $contacto = $row[2];
                        $whatsapp = $row[3];
                        $fecha_ingreso = $row[4];
                        $fecha_actualza = $row[5];
                        $fecha_caduca = $row[6];
                        $url_imporsuit = $row[8];

                    ?>

                        <tr>
                            <td class="text-center"><?php echo $nombre_tienda; ?></td>
                            <td class="text-center"><?php echo $contacto; ?></td>
                            <td class="text-center"><?php echo $whatsapp; ?></td>
                            <td class="text-center"><?php echo $fecha_ingreso; ?></td>
                            <td class="text-center"><?php echo $fecha_caduca; ?></td>
                            <td class="text-center"><a href="<?php echo $url_imporsuit; ?>" target="_blank"><?php echo $url_imporsuit; ?></a></td>
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
            <strong>Aviso!</strong> No hay tiendas registradas a tu enlace de referido
        </div>
<?php
    }
}

?>