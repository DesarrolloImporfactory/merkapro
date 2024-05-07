<?php
include "is_logged.php"; //Archivo comprueba si el usuario esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
#require_once "../libraries/inventory.php"; //Contiene funcion que controla stock en el inventario
//Inicia Control de Permisos
include "../permisos.php";
//Archivo de funciones PHP
require_once "../funciones.php";
$user_id = $_SESSION['id_users'];
$action  = (isset($_REQUEST['action']) && $_REQUEST['action'] != null) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    $daterange      = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['range'], ENT_QUOTES)));
    //echo $daterange;
 
  
        list($f_inicio, $f_final)                    = explode(" - ", $daterange); //Extrae la fecha inicial y la fecha final en formato espa?ol
        list($dia_inicio, $mes_inicio, $anio_inicio) = explode("/", $f_inicio); //Extrae fecha inicial
        $fecha_inicial                               = "$anio_inicio-$mes_inicio-$dia_inicio 00:00:00"; //Fecha inicial formato ingles
        list($dia_fin, $mes_fin, $anio_fin)          = explode("/", $f_final); //Extrae la fecha final
        $fecha_final                                 = "$anio_fin-$mes_fin-$dia_fin 23:59:59";

        $sql= " SELECT * FROM facturas_cot where date(fecha_factura)  BETWEEN '$fecha_inicial' and '$fecha_final' ";
   
    //$sWhere .= " order by facturas_ventas.id_factura";

   // include 'pagination.php'; //include pagination file
    //pagination variables
   
    //Count the total number of row in your table*/
    $count_query = mysqli_query($conexion, $sql);
 
    //main query to fetch the data
    //echo "SELECT $campos FROM  $tables where $sWhere LIMIT $offset,$per_page";
  //  $query = mysqli_query($conexion, "SELECT $campos FROM  $tables where $sWhere LIMIT $offset,$per_page");
    //loop through fetched data


        ?>

         
            
                <?php
$finales = 0;
$total_abono=0;
$id_moneda    = get_row('perfil', 'moneda', 'id_perfil', 1);
        while ($row = mysqli_fetch_array($count_query)) {
            $total_abono += $row['monto_factura'];
           
            ?>
                    <?php }
                    echo '' . $id_moneda . '' . number_format($total_abono, 2) . '';
                    ?>
             


            <?php

}
?>

