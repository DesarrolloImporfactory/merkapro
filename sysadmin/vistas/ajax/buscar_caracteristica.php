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
$id_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q        = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $aColumns = array('texto'); //Columnas de busqueda
    $sTable   = "caracteristicas_tienda";
    $sWhere   = "";
  
    $sWhere .= " order by id";
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
    $reload      = '../html/lineas.php';
    //main query to fetch the data
    $sql   = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
    //echo $sql;
    $query = mysqli_query($conexion, $sql);
    //loop through fetched data
    if ($numrows > 0) {

        ?>
        <div class="table-responsive">
            <table class="table table-sm table-striped">
                <tr  class="info">
                    <th>Id</th>
                   
                    <th>Nombre</th>
                    <th>Icono</th>
                    <th>Enlace</th>
                    <th>Sub-texto Icono</th>
                    <th>Acciones</th>

                </tr>
                <?php
while ($row = mysqli_fetch_array($query)) {
            $id     = $row['id'];
            $id_producto     = $row['id_producto'];
            $texto       = $row['texto'];
            $icono       = $row['icon_text'];
            $enlace       = $row['enlace_icon'];
            $sub_texto       = $row['subtexto_icon'];
            $accion_icon  = $row['accion'];
           
            ?>

    <input type="hidden" value="<?php echo $texto; ?>" id="texto<?php echo $id; ?>">
    <input type="hidden" value="<?php echo $icono; ?>" id="icono<?php echo $id; ?>">
    <input type="hidden" value="<?php echo $enlace; ?>" id="enlace_icon<?php echo $id; ?>">
    <input type="hidden" value="<?php echo $sub_texto; ?>" id="subtexto_icon<?php echo $id; ?>">
     

    <tr>
        <td><span class="badge badge-purple"><?php echo $id; ?></span></td>
       
        <td><?php echo $texto; ?></td>
        <td><span style="font-size: 30px"><i class="fas <?php echo $icono; ?>"></i></td>
        <td><?php if ($enlace!=""){?><a class="btn btn-warning" href="<?php echo $enlace; ?>" target="black">Ver Accion</a><?php }?></td>
        <td><?php echo $sub_texto; ?></td>
        
       
        <td >
            <div class="btn-group dropdown">
                <button type="button" class="btn btn-warning btn-sm dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"> <i class='fa fa-cog'></i> <i class="caret"></i> </button>
                <div class="dropdown-menu dropdown-menu-right">
                   <?php if ($permisos_editar == 1) {?>
                   <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editarIconos" onclick="obtener_datos_icono('<?php echo $id; ?>');"><i class='fa fa-edit'></i> Editar</a>
                   <?php }
            if (($permisos_eliminar == 1) && ($accion_icon == 0)) {?>
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