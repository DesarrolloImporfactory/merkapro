<?php
/*-------------------------
Autor: Delmar Lopez
Web: www.digitalsolution.com
Mail: softwysop@gmail.com
---------------------------*/
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
require_once "../funciones.php";

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';

if ($action == 'agrega') {
    $atributo= $_REQUEST['atributo'];
   
    $id_producto=$_REQUEST['id_producto'];
    
   $sql = "INSERT INTO `atributo_producto` (`atributo`, `id_producto`) VALUES "
           . " ('$atributo', '$id_producto')";
   //echo $sql;
        $query_new_insert = mysqli_query($conexion, $sql);

        if ($query_new_insert) {
            $messages[] = "Gasto ha sido ingresado con Exito.";
        } else {
            $errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($conexion);
        } 
}
if ($action == 'elimina') {
   
    $id_stock=$_REQUEST['id_stock'];
    
   $sql = "delete from `atributo_producto` where id_atributo=".$id_stock;
   //echo $sql;
        $query_new_insert = mysqli_query($conexion, $sql);

        if ($query_new_insert) {
            $messages[] = "Gasto ha sido ingresado con Exito.";
        } else {
            $errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($conexion);
        } 
}

    // escaping, additionally removing everything that could be (html/javascript-) code
  
    //$q        = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    //$aColumns = array(); //Columnas de busqueda
    $sTable   = "atributo_producto";
    $sWhere   = "where  id_producto=".$_REQUEST['id_producto'];
    
    include 'pagination.php'; //include pagination file
    //pagination variables
    
    //Count the total number of row in your table*/
   
    //main query to fetch the data
    $sql   = "SELECT * FROM  $sTable $sWhere ";
    //echo $sql;
    $query = mysqli_query($conexion, $sql);
    //loop through fetched data


        ?>
<div style="padding-left: 10px; padding-right: 10px" class="table-responsive">
              <table class="table table-bordered table-striped table-sm">
                <tr  class="info">
                    
                    <th class='text-center'>ATRIBUTO</th>
                    <th class='text-center' style="width: 36px;"></th>
                </tr>
                <?php
while ($row = mysqli_fetch_array($query)) {
     $id_atributo    = $row['id_atributo'];
            $atributo     = $row['atributo'];
          
            
            ?>
                    <tr>
                       
                            <td><?php echo $atributo; ?></td>
                      
                        
                        
                        
                        
                        
                        <td class='text-center'>
                        <a class='btn btn-danger' href="#" title="Eliminar Stock" onclick="eliminar_stock('<?php echo $id_atributo ?>')"><i class="fa fa-trash"></i>
                        </a>
                        </td>
                    </tr>
                    <?php
}
        ?>
             
              </table>
            </div>
            <?php


// fin else

?>