<?php

/*-------------------------
Autor: Eduardo Vega
Web: Imporsuit
---------------------------*/
//include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../sysadmin/vistas/db.php";
require_once "../sysadmin/vistas/php_conexion.php";
require_once "../sysadmin/vistas/funciones.php";
//Inicia Control de Permisos
//include "../permisos.php";
//$user_id = $_SESSION['id_users'];
$id_provincia = $_POST['provinica'];
//echo 'la puta madre0'.$_POST['provinica'];
//get_cadena($user_id);
//$modulo = "Categorias";
//permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
//Archivo de funciones PHP
//require_once "../funciones.php";

//$id_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);
//echo 'asdasd'.$_POST['provinica'].'asddas';

// escaping, additionally removing everything that could be (html/javascript-) code
//$q        = mysqli_real_escape_string($conexion, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
$aColumns = array('nombre'); //Columnas de busqueda
$sTable   = "ciudad_laar";
$sWhere   = "where codigoProvincia='$id_provincia'";

$sWhere .= " order by id_ciudad";

//Count the total number of row in your table*/

//main query to fetch the data
$sql   = "SELECT * FROM  $sTable $sWhere ";
//echo $sql;
$query = mysqli_query($conexion, $sql);
//loop through fetched data
$pais = get_row('perfil', 'pais', 'id_perfil', 1);
?>
<div class="input-group-prepend">
  <span style="height: 45px" class="icon_datos input-group-text"><i class="fas fa-map-marker-alt"></i></span>
</div>
<?php
if ($pais == 1) {
?>
  <select class="datos form-control" id="ciudad" name="ciudad" required>
    <option value="">Ciudad *</option>
    <?php
    $sql2 = "select * from ciudad_laar where codigoProvincia= '$id_provincia'";
    // echo $sql2;
    $query2 = mysqli_query($conexion, $sql2);

    $rowcount = mysqli_num_rows($query2);
    //echo $rowcount;
    $i = 1;
    while ($row2 = mysqli_fetch_array($query2)) {
      // echo $row2['provincia'];
      //$id_prov       = $row2['id_prov']; 
      $ciudad      = $row2['nombre'];
      $codigo      = $row2['codigo'];

    ?>
      <option value="<?php echo $codigo; ?>"><?php echo $ciudad; ?></option>
    <?php } ?>
  </select>
<?php
} else {


?>
  <input class="datos form-control" id="ciudad" name="ciudad" placeholder="Ingrese la ciudad" required>

<?php
}

?>