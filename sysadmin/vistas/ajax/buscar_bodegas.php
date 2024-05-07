<?php

/*-------------------------
Autor: Delmar Lopez
Web: softwys.com
Mail: softwysop@gmail.com
---------------------------*/
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
//Archivo de funciones PHP
include "../funciones.php";
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Productos";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q            = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    //$id_categoria = intval($_REQUEST['categoria']);
    $aColumns     = array('nombre'); //Columnas de busqueda
    $sTable       = "bodega";
    $sWhere       = "where id_empresa=$user_id";

    if ($_GET['q'] != "") {
        $sWhere = "and (";
        for ($i = 0; $i < count($aColumns); $i++) {
            $sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ')';
    }

    $sWhere .= " order by nombre asc";

    include 'pagination.php'; //include pagination file
    //pagination variables
    $page      = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page  = 10; //how much records you want to show
    $adjacents = 4; //gap between pages after number of adjacents
    $offset    = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query = mysqli_query($conexion, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
    $row         = mysqli_fetch_array($count_query);
    $numrows     = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload      = '../html/productos.php';
    //main query to fetch the data
    $sql   = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
    //echo $sql;
    $query = mysqli_query($conexion, $sql);
    //loop through fetched data
    if ($numrows > 0) {
        $simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
?>
        <div class="table-responsive">
            <table class="table table-sm table-striped">
                <tr class="info">
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Direccion</th>
                    <th>Ciudad</th>
                    <th>Responsable</th>
                    <th>Telefono</th>



                    <th class='text-right'>Acciones</th>

                </tr>
                <?php
                while ($row = mysqli_fetch_array($query)) {
                    $id          = $row['id'];
                    $nombre      = $row['nombre'];
                    $direccion      = $row['direccion'];
                    $localidad = $row['localidad'];
                    $responsable      = $row['responsable'];
                    $contacto      = $row['contacto'];


                    //$id_imp_producto      = $row['id_imp_producto'];
                    /* if ($status_producto == 1) {
                $estado = "<span class='badge badge-success'>Activo</span>";
            } else {
                $estado = "<span class='badge badge-danger'>Inactivo</span>";
            }*/
                ?>


                    <input type="hidden" value="<?php echo $nombre; ?>" id="nombre<?php echo $id_edificio; ?>">
                    <input type="hidden" value="<?php echo $direccion; ?>" id="direccion<?php echo $id_edificio; ?>">
                    <input type="hidden" value="<?php echo $telefono; ?>" id="telefono<?php echo $id_edificio; ?>">
                    <input type="hidden" value="<?php echo $fecha_contrato; ?>" id="fecha<?php echo $id_edificio; ?>">

                    <tr>
                        <td><span class="badge badge-purple"><?php echo $id; ?></span></td>


                        <td><?php echo $nombre; ?></td>
                        <td><?php echo $direccion; ?></td>
                        <?php
                            $ciudad = get_row('ciudad_cotizacion','ciudad','id_cotizacion',$localidad);
                            ?>
                        <td><?php echo $ciudad; ?></td>
                        <td><?php echo $responsable; ?></td>
                        <td><?php echo $contacto; ?></td>

                        <td>

                            <div class="btn-group dropdown pull-right">
                                <button type="button" class="btn btn-warning btn-rounded waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"> <i class='fa fa-cog'></i> <i class="caret"></i> </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <?php if ($permisos_ver == 1) { ?>
                                        <a class="dropdown-item" href="../html/editar_bodega.php?id_bodega=<?php echo $id; ?>"><i class='fa fa-edit'></i> Editar</a>
                                    <?php }
                                    if ($permisos_editar == 1) { ?>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#dataDelete" data-id="<?php echo $id; ?>"><i class='fa fa-trash'></i> Borrar</a>
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
                    <td colspan=12><span class="pull-right">
                            <?php
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
            <strong>Aviso!</strong> No hay Registro de Producto
        </div>
<?php
    }
    // fin else
}
?>

<script>
$(document).ready(function(){
    $('#dataDelete').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        var id = button.data('id'); // Extraer información de atributos data-*
        var modal = $(this);
        modal.find('.modal-footer #deleteButton').data('id', id); // Asignar el id al botón dentro del modal
    });
});
</script>

<script>
$('#deleteButton').click(function() {
    var id = $(this).data('id'); // Obtener el id desde el botón de eliminar dentro del modal
    $.ajax({
        url: '../ajax/eliminar_bodega.php', // Ruta al script PHP que procesará la eliminación
        type: 'POST',
        data: {id: id},
        success: function(response) {
            // Cerrar modal
            $('#dataDelete').modal('hide');

            // Opcional: Actualizar la vista o redirigir
            location.reload(); // Esto recargará la página para actualizar la lista
        }
    });
});
</script>

