<?php

/*-------------------------
Autor: EDUARDO VEGA
---------------------------*/
//include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../sysadmin/vistas/db.php";
require_once "../sysadmin/vistas/php_conexion.php";
//Inicia Control de Permisos
//include "../permisos.php";
//$user_id = $_SESSION['id_users'];
//get_cadena($user_id);
$modulo = "Proveedores";
//permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q        = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $aColumns = array('nombre', 'categoria'); //Columnas de busqueda
    $sTable   = "proveedor_marketplace";
    $sWhere   = "where id_proveedor>0";
    if ($_GET['q'] != "") {
        $sWhere .= " and (";
        for ($i = 0; $i < count($aColumns); $i++) {
            $sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ')';
    }
     if ($_GET['q2'] != "") {
         $pais=$_GET['q2'];
         //echo $pais; 
        $sWhere .= " and pais='$pais'";
        
       
    }
    $sWhere .= " order by nombre";
    include '../sysadmin/vistas/ajax/pagination.php'; //include pagination file
    //pagination variables
    $page      = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page  = 10; //how much records you want to show
    $adjacents = 4; //gap between pages after number of adjacents
    //$offset    = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query = mysqli_query($conexion, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
    $row         = mysqli_fetch_array($count_query);
    $numrows     = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload      = '../html/proveedores.php';
    //main query to fetch the data
    $sql   = "SELECT * FROM  $sTable $sWhere ";
    //echo $sql; 
    $query = mysqli_query($conexion, $sql);
    //loop through fetched data
    if ($numrows > 0) {

        ?>
        <div class="table-responsive">
            <table class="table table-sm table-striped">
                <tr  class="info">
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Modalidad</th>
                    <th>Pais</th>
                    <th>Categoria</th>
                    <th>Telefono</th>
                    <th>Telegram</th>
                  
                 

                </tr>
                <?php
while ($row = mysqli_fetch_array($query)) {
            $id_proveedor        = $row['id_proveedor'];
            $nombre_proveedor    = $row['nombre'];
            $modalidad    = $row['modalidad'];
            $pais       = $row['pais'];
            $categoria = $row['categoria'];
            $telefono  = $row['telefono'];
            $telegram     = $row['telegram'];
            $catalogo  = $row['catalogo'];
          

            ?>
                    <input type="hidden" value="<?php echo $nombre_proveedor; ?>" id="nombre_proveedor<?php echo $id_proveedor; ?>">
                    <input type="hidden" value="<?php echo $modalidad; ?>" id="modalidad<?php echo $id_proveedor; ?>">
                    <input type="hidden" value="<?php echo $pais; ?>" id="pais<?php echo $id_proveedor; ?>">
                    <input type="hidden" value="<?php echo $categoria; ?>" id="categoria<?php echo $id_proveedor; ?>">
                    <input type="hidden" value="<?php echo $telefono; ?>" id="telefono<?php echo $id_proveedor; ?>">
                    <input type="hidden" value="<?php echo $telegram; ?>" id="telegram<?php echo $id_proveedor; ?>">
                    <input type="hidden" value="<?php echo $catalogo; ?>" id="catalogo<?php echo $id_proveedor; ?>">
                    

                    <tr>
                    <td><span class="badge badge-purple"><?php echo $id_proveedor; ?></span></td>
                        <td>
                           
                            <?php echo $nombre_proveedor; ?>
                     
                    </td>
                    <td><?php echo $modalidad; ?></td>
                    <td><?php echo $pais; ?></td>
                    <td><?php echo $categoria; ?></td>
                    <td><?php echo $telefono; ?></td>
                    <td><a href="<?php echo $telegram; ?>" target="blank"><img width="40px" src="sysadmin/img_sistema/telegram.png" alt=""/></a></td>
                    

                    <td >
                     

                 </td>

             </tr>
             <?php
}
        ?>
      
        </table>
    </div>
    <?php
}
//Este else Fue agregado de Prueba de prodria Quitar
    else {
        ?>
    <div class="alert alert-warning alert-dismissible" role="alert" align="center">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Aviso!</strong> No hay Registro de Clientes
  </div>
  <?php
}
// fin else
}
?>