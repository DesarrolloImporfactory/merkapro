<?php

/*-------------------------
Autor: Eduardo vega
---------------------------*/
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
require_once "../funciones.php";
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Categorias";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisose
//Archivo de funciones PHP
require_once "../funciones.php";
$id_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q        = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $aColumns = array('nombre_tienda', 'contacto', 'email', 'url_imporsuit'); //Columnas de busqueda
    $sTable   = "plataformas";
    $sWhere   = "";
    if ($_GET['q'] != "") {
        $sWhere = " WHERE (";
        for ($i = 0; $i < count($aColumns); $i++) {
            $sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ')';
    }
    $sWhere .= " order by id_plataforma";
    include 'pagination.php'; //include pagination file
    //pagination variables
    $page      = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page  = 50; //how much records you want to show
    $adjacents = 4; //gap between pages after number of adjacents
    $offset    = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query = mysqli_query($conexion, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
    $row         = mysqli_fetch_array($count_query);
    $numrows     = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload      = '../html/lineas.php';
    //main query to fetch the data
    $sql   = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
    $query = mysqli_query($conexion, $sql);
    //loop through fetched data
    if ($numrows > 0) {

?>
        <div class="table-responsive">
            <table class="table table-sm table-striped">
                <tr class="info">
                    <th>Id</th>
                    <th>Tienda</th>
                    <th>Contacto</th>
                    <th>Whatsapp</th>
                    <th>Email</th>

                    <th>Ingresa</th>
                    <th>Actualiza</th>
                    <th>Caduca</th>
                    <th>Días Restantes</th>
                    <th>Plan</th>
                    <th>Subdominio</th>
                    <th>Dominio</th>
                    <th class='text-right'>Acciones</th>

                </tr>
                <?php
                while ($row = mysqli_fetch_array($query)) {
                    $id_tienda = $row['id_plataforma'];
                    $nombre       = $row['nombre_tienda'];
                    $contacto  = $row['contacto'];
                    $whatsapp = $row['whatsapp'];
                    $fecha_ingresa = $row['fecha_ingreso'];
                    $fecha_caduca = $row['fecha_caduca'];
                    $fecha_actualza   = $row['fecha_actualza'];

                    $id_plan   = $row['id_plan'];
                    $url_imporsuit   = $row['url_imporsuit'];
                    $dominio   = $row['dominio'];
                    $carpeta_servidor   = $row['carpeta_servidor'];
                    $email   = $row['email'];
                    $db_name   = $row['db_name'];
                    $db_user   = $row['bd_usuario'];
                    $db_pass   = $row['bd_pass'];

                    $enlace_whatsapp = 'https://wa.me/' . $row["whatsapp"];
                    //echo $online;
                    if ($id_plan == 1) {
                        $estado_online = "<span class='badge badge-success'>PRUEBA</span>";
                    } else {
                        if ($id_plan == 2) {
                            $estado_online = "<span class='badge badge-success'>GRATUITO</span>";
                        } else {
                            $estado_online = "<span class='badge badge-danger'>PREMIUM</span>";
                        }
                    }
                ?>

                    <input type="hidden" value="<?php echo $nombre; ?>" id="nombre<?php echo $id_tienda; ?>">
                    <input type="hidden" value="<?php echo $contacto; ?>" id="contacto<?php echo $id_tienda; ?>">
                    <input type="hidden" value="<?php echo $whatsapp; ?>" id="whatsapp<?php echo $id_tienda; ?>">
                    <input type="hidden" value="<?php echo $fecha_ingresa; ?>" id="fecha_ingresa<?php echo $id_tienda; ?>">
                    <input type="hidden" value="<?php echo $fecha_caduca; ?>" id="fecha_caduca<?php echo $id_tienda; ?>">
                    <input type="hidden" value="<?php echo $fecha_actualza; ?>" id="fecha_actualza<?php echo $id_tienda; ?>">
                    <input type="hidden" value="<?php echo $id_plan; ?>" id="id_plan<?php echo $id_tienda; ?>">
                    <input type="hidden" value="<?php echo $url_imporsuit; ?>" id="url_imporsuit<?php echo $id_tienda; ?>">
                    <input type="hidden" value="<?php echo $dominio; ?>" id="dominio<?php echo $id_tienda; ?>">
                    <input type="hidden" value="<?php echo $carpeta_servidor; ?>" id="carpeta_servidor<?php echo $id_tienda; ?>">
                    <input type="hidden" value="<?php echo $email; ?>" id="email<?php echo $id_tienda; ?>">
                    <input type="hidden" value="<?php echo $db_name; ?>" id="db_name<?php echo $id_tienda; ?>">
                    <input type="hidden" value="<?php echo $db_user; ?>" id="db_user<?php echo $id_tienda; ?>">
                    <input type="hidden" value="<?php echo $db_pass; ?>" id="db_pass<?php echo $id_tienda; ?>">


                    <tr>
                        <td><span class="badge badge-purple"><?php echo $id_tienda; ?></span></td>
                        <td><?php echo $nombre; ?></td>


                        <td><?php echo $contacto; ?></td>


                        <td><?php echo '<a href="' . $enlace_whatsapp . '" target="_blank"><img width="30px" src="../../img_sistema/wp1.png" alt=""/> ' . $whatsapp . '</a><br>';
                            ?></td>
                        <td><?php
                            echo $email;
                            ?></td>
                        <td><?php
                            echo $fecha_ingresa;
                            ?></td>
                        <td><?php
                            echo $fecha_actualza;
                            ?></td>
                        <td><?php
                            echo $fecha_caduca;
                            ?></td>
                        <td><?php
                            $fechaObjeto = new DateTime($fecha_caduca);

                            // Obtener la fecha actual
                            $fechaActual = new DateTime();

                            // Calcular la diferencia en días
                            $diferencia = $fechaObjeto->diff($fechaActual);

                            // Obtener el número de días faltantes
                            $diasFaltantes = $diferencia->days;

                            echo $diasFaltantes;

                            ?>

                        </td>
                        <td><?php echo $estado_online; ?></td>
                        <td><a target="blank" href="<?php
                                                    echo $url_imporsuit;
                                                    ?>"><?php
                                                        echo $url_imporsuit;
                                                        ?><a></td>
                        <td><?php
                            echo $dominio;
                            ?></td>
                        <td>
                            <div class="btn-group dropdown">
                                <button type="button" class="btn btn-warning btn-sm dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"> <i class='fa fa-cog'></i> <i class="caret"></i> </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <?php if ($permisos_editar == 1) { ?>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editarLinea" onclick="obtener_datos('<?php echo $id_tienda; ?>');"><i class='fa fa-edit'></i> Editar</a>
                                    <?php }
                                    if ($permisos_eliminar == 1) { ?>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#dataDelete" data-id="<?php echo $id_tienda; ?>"><i class='fa fa-trash'></i> Borrar</a>
                                    <?php }
                                    ?>


                                </div>
                            </div>

                        </td>

                    </tr>
                <?php
                }
                ?>
                <tr>
                    <td colspan="7">
                        <span class="pull-right">
                            <?php
                            echo paginate($reload, $page, $total_pages, $adjacents);
                            ?></span>
                    </td>
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
            <strong>Aviso!</strong> No hay Registro de Linea
        </div>
<?php
    }
    // fin else
}
?>