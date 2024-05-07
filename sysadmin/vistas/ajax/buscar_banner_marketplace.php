<?php

/*-------------------------
Autor: Eduardo Vega
Web: Imporsuit
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
//Finaliza Control de Permisos
//Archivo de funciones PHP
require_once "../funciones.php";

$conexion_marketplace = new mysqli('localhost', 'imporsuit_marketplace', 'imporsuit_marketplace', 'imporsuit_marketplace');
$id_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q        = mysqli_real_escape_string($conexion_marketplace, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $aColumns = array('titulo'); //Columnas de busqueda
    $sTable   = "banner_marketplace";
    $sWhere   = "";
    
    $sWhere .= " order by id";
    include 'pagination.php'; //include pagination file
    //pagination variables
    $page      = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page  = 10; //how much records you want to show
    $adjacents = 4; //gap between pages after number of adjacents
    $offset    = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query = mysqli_query($conexion_marketplace, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
    $row         = mysqli_fetch_array($count_query);
    $numrows     = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload      = '../html/lineas.php';
    //main query to fetch the data
    $sql   = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
    //echo $sql;
    $query = mysqli_query($conexion_marketplace, $sql);
    //loop through fetched data
    if ($numrows > 0) {

        ?>
        <div class="table-responsive">
            <table class="table table-sm table-striped">
                <tr  class="info">
                    <th>Fondo Banner</th>
                    <th>Titulo</th>
                    <th>Texto Banner</th>
                    <th>Texto Boton</th>
                    <th>Enlace Boton</th>
                    <th>Alineacion</th>
                    <th>Accion</th>

                </tr>
                <?php
while ($row = mysqli_fetch_array($query)) {
            $id = $row['id'];
            $fondo_banner     = $row['fondo_banner'];
            $titulo       = $row['titulo'];
            $texto_banner       = $row['texto_banner'];
            $texto_boton       = $row['texto_boton'];
            $enlace_boton       = $row['enlace_boton'];
            $alineacion  = $row['alineacion'];
           //echo 'asdasdasd'.$texto_banner;
            ?>

    <input type="hidden" value="<?php echo $titulo; ?>" id="titulo<?php echo $id; ?>">
    <input type="hidden" value="<?php echo $texto_banner; ?>" id="texto_banner<?php echo $id; ?>">
    <input type="hidden" value="<?php echo $texto_boton; ?>" id="texto_boton<?php echo $id; ?>">
    <input type="hidden" value="<?php echo $enlace_boton; ?>" id="enlace_boton<?php echo $id; ?>">
    <input type="hidden" value="<?php echo $alineacion; ?>" id="alineacion<?php echo $id; ?>">
     

    <tr>
        <td>
        <img src="<?php echo $fondo_banner; ?>" class="img-responsive" alt="profile-image" width="100px" >
        </td>
        <td><?php echo $titulo; ?></td>
        <td><?php echo $texto_banner; ?></td>
        <td><?php echo $texto_boton; ?></td>
        <td><?php echo $enlace_boton; ?></td>
        <td><?php echo $alineacion; ?></td>
        
       
        <td >
            <div class="btn-group dropdown">
                <button type="button" class="btn btn-warning btn-sm dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"> <i class='fa fa-cog'></i> <i class="caret"></i> </button>
                <div class="dropdown-menu dropdown-menu-right">
                   <?php if ($permisos_editar == 1) {?>
                   <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editarLinea" onclick="obtener_datos_banner('<?php echo $id; ?>');"><i class='fa fa-edit'></i> Editar</a>
                   <?php }
            if (($permisos_eliminar == 1)) {?>
                   <a class="dropdown-item" href="#" data-toggle="modal" data-target="#dataDelete"  onclick="eliminar('<?php echo $id; ?>',' banner_marketplace', 'id');"><i class='fa fa-trash'></i> Borrar</a>
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
      <strong>Aviso!</strong> No hay Registro de Características
  </div>
  <?php
}
// fin else
}
?>