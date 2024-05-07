<?php

/*-------------------------
Autor: Eduardo Vega
Web: Imporsuit
---------------------------*/
//include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
require_once "../funciones.php";
//Inicia Control de Permisos
//include "../permisos.php";
//$user_id = $_SESSION['id_users'];
$transportadora = $_POST['transportadora'];
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
  
   
    //Count the total number of row in your table*/
   
    //loop through fetched data

        ?>

<?php

if($transportadora==1){
       ?>
<span class="help-block">Provincia </span>
<select onchange="cargar_provincia_pedido()" class="datos form-control" id="provinica" name="provinica" required>
                                                                <option value="">Provincia *</option>
                                                                <?php
                                                                $sql2 = "select * from provincia_laar ";
                                                                $query2 = mysqli_query($conexion, $sql2);

                                                                while ($row2 = mysqli_fetch_array($query2)) {
                                                                    $id_prov = $row2['id_prov'];
                                                                    $provincia = $row2['provincia'];
                                                                    $cod_provincia = $row2['codigo_provincia'];

                                                                    // Obtener el valor almacenado en la tabla orgien_laar
                                                                    $valor_seleccionado = $provinciadestino;

                                                                    // Verificar si el valor actual coincide con el almacenado en la tabla
                                                                    $selected = ($valor_seleccionado == $cod_provincia) ? 'selected' : '';

                                                                    // Imprimir la opción con la marca de "selected" si es el valor almacenado
                                                                    echo '<option value="' . $cod_provincia . '" ' . $selected . '>' . $provincia . '</option>';
                                                                }
                                                                ?>
                                                            </select>
<?php

    
}else{
    ?>
<span class="help-block">Ciudad </span>
    <select onchange="calcular_guia()" class="datos form-control" id="ciudad_entrega" name="ciudad_entrega" required>
                                                                <option value="">Ciudad *</option>
                                                               <option value="1">Quito </option>
                                                               <option value="2">Valle de los chillos </option>
                                                               <option value="2">Valle de Cumbaya </option>
                                                               <option value="2">Valle de Tumbaco </option>
                                                               
                                                            </select>
<?php
}
       ?>


