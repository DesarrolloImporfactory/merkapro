<?php

/*-------------------------
Autor: Eduardo Vega
---------------------------*/
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";

// Configuración de la base de datos de destino
if ($_SERVER['HTTP_HOST']=='localhost'){
    $destino = new mysqli('localhost', 'root', '', 'master');
}else{
 $destino = new mysqli('localhost', 'imporsuit_marketplace', 'imporsuit_marketplace', 'imporsuit_marketplace');   
}

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
    
         if (isset($_SERVER['HTTPS']) &&
    ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
    $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
  $protocol = 'https://';
}
else {
  $protocol = 'http://';
}
//$image_path = str_replace('../..', 'sysadmin', $image_path);

        $server_url = $protocol . $_SERVER['HTTP_HOST'];
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q            = mysqli_real_escape_string($destino, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $id_categoria = intval($_REQUEST['categoria']);
    $aColumns     = array('codigo_producto', 'nombre_producto'); //Columnas de busqueda
    $sTable       = "productos";
    $sWhere       = "where tienda <>'$server_url'";
    
    if ($id_categoria > 0) {
        $sWhere .= " and id_linea_producto = '" . $id_categoria . "' ";
    }
    if ($_GET['q'] != "") {
        $sWhere = "and (";
        for ($i = 0; $i < count($aColumns); $i++) {
            $sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ')';

    }

    $sWhere .= " order by nombre_producto asc";

    include 'pagination.php'; //include pagination file
    //pagination variables
    $page      = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page  = 10; //how much records you want to show
    $adjacents = 4; //gap between pages after number of adjacents
    $offset    = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    
    $count_query = mysqli_query($destino, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
    $row         = mysqli_fetch_array($count_query);
    $numrows     = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload      = '../html/productos.php';
    //main query to fetch the data
    $sql   = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
    //echo $sql;
    $query = mysqli_query($destino, $sql);
    //loop through fetched data
    if ($numrows > 0) {
        $simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
        ?>
        <div class="table-responsive">
          <table class="table table-sm table-striped">
            <tr  class="info">
                <th>ID</th>
                <th></th>
                <th>Código</th>
                <th>Producto</th>
                <th>Online</th>
                <th class='text-center'>Existencia</th>
               
                <th class='text-left'>Costo</th>
                <th class='text-left'>PxMayor</th>
                <th class='text-left'>PVP</th>
                <th class='text-left'>P. Referencial</th>
                
                
                 <th>Landing</th>
                 <th>Importar</th>
                 <th>Disponible</th>
                 
              
             
               

            </tr>
            <?php
while ($row = mysqli_fetch_array($query)) {
            $id_producto          = $row['id_producto'];
            $codigo_producto      = $row['codigo_producto'];
            $nombre_producto      = $row['nombre_producto'];
            $descripcion_producto = $row['descripcion_producto'];
            $linea_producto       = $row['id_linea_producto'];
            $med_producto         = $row['id_med_producto'];
            $id_proveedor         = $row['id_proveedor'];
            $inv_producto         = $row['inv_producto'];
            $impuesto_producto    = $row['iva_producto'];
            $costo_producto       = $row['costo_producto'];
            $utilidad_producto    = $row['utilidad_producto'];
            $precio_producto      = $row['valor1_producto'];
            $precio_mayoreo       = $row['valor2_producto'];
            $precio_especial      = $row['valor3_producto'];
            $precio_normal        = $row['valor4_producto'];
            $stock_producto       = $row['stock_producto'];
            $stock_min_producto   = $row['stock_min_producto'];
            
            
            $online   = $row['pagina_web'];
            $status_producto      = $row['estado_producto'];
            $date_added           = date('d/m/Y', strtotime($row['date_added']));
            $image_path           = $row['image_path'];
            $url_a1          = $row['url_a1'];
            $url_a2           = $row['url_a2'];
            $url_a3           = $row['url_a3'];
            $url_a4          = $row['url_a4'];
            $url_a5          = $row['url_a5'];
            $id_imp_producto      = $row['id_imp_producto'];
            $formato      = $row['formato'];
            $tienda      = $row['tienda'];
            
          //  $texto_boton1      = $row['texto_boton'];
           // $texto_boton2      = $row['texto_boton2'];
            
          //  $descripcion1      = $row['descripcion'];
           // $descripcion2      = $row['descripcion2'];
            
            if ($status_producto == 1) {
                $estado = "<span class='badge badge-success'>Activo</span>";
            } else {
                $estado = "<span class='badge badge-danger'>Inactivo</span>";
            }
            //echo $online;
             if ($online == 1) {
                $estado_online = "<span class='badge badge-success'>SI</span>";
            } else {
                $estado_online = "<span class='badge badge-danger'>NO</span>";
            }
            ?>
                <input type="hidden" value="<?php echo $online; ?>" id="online<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $codigo_producto; ?>" id="codigo_producto<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $nombre_producto; ?>" id="nombre_producto<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $descripcion_producto; ?>" id="descripcion_producto<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $linea_producto; ?>" id="linea_producto<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $id_proveedor; ?>" id="proveedor_producto<?php echo $id_producto; ?>">
                <!--<input type="hidden" value="<?php echo $med_producto; ?>" id="med_producto<?php echo $id_producto; ?>">-->
                <input type="hidden" value="<?php echo $inv_producto; ?>" id="inv_producto<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $impuesto_producto; ?>" id="impuesto_producto<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $stock_producto; ?>" id="stock_producto<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $stock_min_producto; ?>" id="stock_min_producto<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $status_producto; ?>" id="estado<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo number_format($costo_producto, 2, '.', ''); ?>" id="costo_producto<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $utilidad_producto; ?>" id="utilidad_producto<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo number_format($precio_producto, 2, '.', ''); ?>" id="precio_producto<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo number_format($precio_mayoreo, 2, '.', ''); ?>" id="precio_mayoreo<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo number_format($precio_especial, 2, '.', ''); ?>" id="precio_especial<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo number_format($precio_normal, 2, '.', ''); ?>" id="precio_normal<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $id_imp_producto; ?>" id="id_imp_producto<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $formato; ?>" id="formato<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $url_a1; ?>" id="url_a1<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $url_a2; ?>" id="url_a2<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $url_a3; ?>" id="url_a3<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $url_a4; ?>" id="url_a4<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $url_a5; ?>" id="url_a5<?php echo $id_producto; ?>">
                
                <input type="hidden" value="<?php echo $url1; ?>" id="url1<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $texto_boton1; ?>" id="texto_boton1<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $descripcion1; ?>" id="descripcion1<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $url2; ?>" id="url2<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $texto_boton2; ?>" id="texto_boton2<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $descripcion2; ?>" id="descripcion2<?php echo $id_producto; ?>">
                <input type="hidden" value="<?php echo $image_path; ?>" id="image_path<?php echo $id_producto; ?>">
                <tr>
                    <td><span class="badge badge-purple"><?php echo $id_producto; ?></span></td>
                    <td class='text-center'>
                        <?php
if ($image_path == null) {
                echo '<img src="../../img/productos/default.jpg" class="" style="height:280px !important" width="60">';
            } else {
                echo '<img src="' . $image_path . '" class="" width="60">';
            }

            ?>
                        <!--<img src="<?php echo $image_path; ?>" alt="Product Image" class='rounded-circle' width="60">-->
                    </td>
                    <td><?php echo $codigo_producto; ?></td>
                    <td ><?php echo $nombre_producto; ?></td>
                    <td><?php echo $estado_online; ?></td>
                    <td class='text-center'><?php echo stock($stock_producto); ?></td>
                    
                    <td><span class='pull-left'><?php echo $simbolo_moneda . '' . number_format($costo_producto, 2); ?></span></td>
                    <td><span class='pull-left'><?php echo $simbolo_moneda . '' . number_format($precio_mayoreo, 2); ?></span></td>
                    <td><span class='pull-left'><?php echo $simbolo_moneda . '' . number_format($precio_especial, 2); ?></span></td>
                    <td><span class='pull-left'><?php echo $simbolo_moneda . '' . number_format($precio_normal, 2); ?></span></td>
                    
                    <td>
                        <!--a class="" href="#" data-toggle="modal" data-target="#nuevoLanding" onclick="obtener_datos_landing('<?php echo $id_producto; ?>');carga_img1('<?php echo $id_producto; ?>')"> <img style="width: 30px" src="../../img/landing.png" alt=""/></a-->
                        <a class="" href="landing_market.php?id=<?php echo $id_producto; ?>"  data-target="#nuevoLanding" onclick="obtener_datos_landing('<?php echo $id_producto; ?>');carga_img1('<?php echo $id_producto; ?>')"> <img style="width: 30px" src="../../img/landing.png" alt=""/></a>
                    </td>
                    
                    <td>
                        <!--a class="" href="#" data-toggle="modal" data-target="#nuevoLanding" onclick="obtener_datos_landing('<?php echo $id_producto; ?>');carga_img1('<?php echo $id_producto; ?>')"> <img style="width: 30px" src="../../img/landing.png" alt=""/></a-->
                        <a class="" href="../ajax/importar.php?id=<?php echo $id_producto; ?>"  data-target="#nuevoLanding" onclick="obtener_datos_landing('<?php echo $id_producto; ?>');carga_img1('<?php echo $id_producto; ?>')"> <img style="width: 30px" src="../../img/importar.png" alt=""/></a>
                    </td>
                     
                    
                   
               
                    <td><?php echo $stock_producto; ?></td>
                    <td >

                      

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