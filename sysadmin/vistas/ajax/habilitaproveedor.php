<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
require_once "../funciones.php";
$id = intval($_GET['id']);
$identi=get_row('origen_laar', 'identificacion', 'id_origen', 1);
if($id==0){
    

if($identi=='99999999999'){
    echo 0;
}else{
   
    $sql = "UPDATE perfil SET habilitar_proveedor=$id";
 //echo $sql;
            $query_update = mysqli_query($conexion, $sql);
             echo 1;
}
}else{
  $sql = "UPDATE perfil SET habilitar_proveedor=$id";
 //echo $sql;
            $query_update = mysqli_query($conexion, $sql);
             echo 1;  
}

 
            
            ?>

