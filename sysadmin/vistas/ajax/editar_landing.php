<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['mod_id_landing'])) {
    $errors[] = "ID vacío";
} else if (
    !empty($_POST['mod_id_landing']) 
) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    $boton1    = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_boton1"], ENT_QUOTES)));
    $boton2 = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_boton2"], ENT_QUOTES)));
    $descripcion1      = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_descripcion1"], ENT_QUOTES)));
    $descripcion2 = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_descripcion2"], ENT_QUOTES)));
    $id_landing=$_POST['mod_id_landing'];
    
    $sql             = "UPDATE landing_producto SET descripcion2='" . $descripcion2 . "',  descripcion='" . $descripcion1 . "', texto_boton='" . $boton1 . "',
                                        texto_boton2='" . $boton2 . "'
                                            
                                        WHERE id_producto_l='" . $id_landing . "'";
    echo $sql;
    $query_update = mysqli_query($conexion, $sql);
    if ($query_update) {
        $messages[] = "Producto ha sido actualizado satisfactoriamente.";
    } else {
        $errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($conexion);
    }
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