<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');


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
$modulo = "Tiendas";
function generateRandomString($length = 10)
{
    $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
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
    $conexion = mysqli_connect("localhost", "imporsuit_marketplace", "imporsuit_marketplace", "imporsuit_marketplace");
    $sTable = "plataformas";
    $sWhere = "";
    $sWhere .= " WHERE url_imporsuit like '%" . $dominio . "%' ";

    $sWhere .= " order by id_plataforma asc";
    include 'pagination.php'; //include pagination file
    //pagination variables
    $page      = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page  = 10; //how much records you want to show

    $adjacents = 4; //gap between pages after number of adjacents
    $offset    = ($page - 1) * $per_page;

    $count_query = mysqli_query($conexion, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
    $row         = mysqli_fetch_array($count_query);
    $numrows     = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload      = '../reportes/facturas.php';
    //main query to fetch the data
    $sql   = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
    //echo $sql;
    $query = mysqli_query($conexion, $sql);

    //loop through fetched data0
    if ($numrows > 0) {
        $row3;
        echo mysqli_error($conexion);

?>
        <div class="table-responsive">
            <table class="table table-sm table-striped align-middle">
                <tr class="info">
                    <th class="text-center">N° Tienda</th>
                    <th class="text-center">Nombre de la Tienda</th>
                    <th class="text-center">Dominio</th>
                    <th class="text-center">Drag</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($query)) {

                    $token_pagina = $row['token_pagina'];
                    $plan = $row['id_plan'];

                    if (empty($token_pagina)) {
                        $token_pagina = generateRandomString(50);
                        $sql = "UPDATE plataformas SET token_pagina = '$token_pagina' WHERE url_imporsuit like '%$dominio%'";
                        $query = mysqli_query($conexion, $sql);
                    }

                    $buscar = "SELECT * FROM plataformas WHERE token_pagina = '$token_pagina'";
                    $result = mysqli_query($conexion, $buscar);

                    while ($row2 = mysqli_fetch_assoc($result)) {
                        $id_tienda = $row2['id_plataforma'];
                        $nombre_tienda = $row2['nombre_tienda'];
                        $dominio_tienda = $row2['url_imporsuit'];
                        $tieneDrag = $row2['tieneDrag'];
                ?>
                        <tr>
                            <td class='text-center'><?php echo $id_tienda; ?></td>
                            <td class='text-center'><?php echo $nombre_tienda; ?></td>
                            <td class='text-center'><?php echo $dominio_tienda; ?></td>
                            <td class="text-center"><?php
                                                    if ($tieneDrag == 1) {
                                                        echo "<button type='button' class='btn btn-success' onclick='redirigir($id_tienda)'>Editar</button>";
                                                    } else {
                                                        echo "<input  type='checkbox' onclick='drag($id_tienda)' />";
                                                    }
                                                    ?></td>
                        </tr>
                <?php
                    }
                }

                $cantidad = mysqli_num_rows($query);
                $row3 = false;
                if (($cantidad != 3 && $plan == 3) || ($cantidad != 9 && $plan == 4)) {
                    $row3 = true;
                }

                ?>

            </table>
            <script>
                function drag(id) {
                    var url = "../ajax/drag.php";
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            id: id
                        },
                        success: function(data) {
                            load(1)
                        }
                    });
                }

                function redirigir(id) {
                    window.location.href = "plantillas_drag.php?id=" + id;
                }
            </script>
            <?php
            if ($row3) {
            ?>
                <div class="alert alert-warning" role="alert">
                    <strong>Advertencia!</strong> Aún no has creado tiendas todas las tiendas que puedes crear con tu plan.
                </div>
            <?php
            }
            ?>

        </div>

        <div class="table-pagination text-center">
            <?php
            echo paginate($reload, $page, $total_pages, $adjacents);
            ?>
        </div>

    <?php
    } else {
    ?>


        <div class='alert alert-warning'>No se encontraron datos</div>

<?php
    }
}
