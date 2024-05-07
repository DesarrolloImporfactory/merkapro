<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['id_tmp'])) {
    $errors[] = "ID vacío";
} else if (
    !empty($_POST['id_tmp'])
) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    require_once "../funciones.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    $id_tmp = intval($_POST['id_tmp']);
    $iva = $_POST['iva'];
    $precio= get_row('tmp_ventas', 'precio_tmp', 'id_tmp', $id_tmp);
    echo $iva;
//echo $precio;
    if($iva==1){
     $precio= $precio/1.15;  
    }else{
      $precio= $precio*1.15;    
    }
    $sql          = "UPDATE tmp_ventas SET  precio_tmp=$precio, iva_tmp='" . $iva . "' WHERE id_tmp='" . $id_tmp . "'";
    echo $sql;
    $query_update = mysqli_query($conexion, $sql);
} else {
    $errors[] = "Error desconocido.";
}

if (isset($errors)) {

    ?>
    <div class="alert alert-danger" role="alert">
        <strong>Error!</strong>
        <?php
foreach ($errors as $error) {
        echo $error;
    }
    ?>
    </div>
    <?php
}
if (isset($messages)) {

    ?>
    <div class="alert alert-success" role="alert">
        <strong>¡Bien hecho!</strong>
        <?php
foreach ($messages as $message) {
        echo $message;
    }
    ?>
    </div>
    <?php
}

?>