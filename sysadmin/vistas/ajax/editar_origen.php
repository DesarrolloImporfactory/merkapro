<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['provinica'])) {
    $errors[] = "Provincia de empresa esta vacío";
} else if (empty($_POST['provinica'])) {
    $errors[] = "Teléfono esta vacío";
} else if (
    !empty($_POST['provinica']) &&
    !empty($_POST['provinica'])
) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    //$provincia = mysqli_real_escape_string($conexion, (strip_tags($_POST["provincia"], ENT_QUOTES)));
    $ciudad          = mysqli_real_escape_string($conexion, (strip_tags($_POST["ciudad"], ENT_QUOTES)));
    $identificacion         = mysqli_real_escape_string($conexion, (strip_tags($_POST["identificacion"], ENT_QUOTES)));
    $provincia       = mysqli_real_escape_string($conexion, (strip_tags($_POST["provinica"], ENT_QUOTES)));
    $referencia         = mysqli_real_escape_string($conexion, (strip_tags($_POST["referencia"], ENT_QUOTES)));
    $nombre      = mysqli_real_escape_string($conexion, (strip_tags($_POST["nombre"], ENT_QUOTES)));
    $direccion         = mysqli_real_escape_string($conexion, (strip_tags($_POST["direccion"], ENT_QUOTES)));
    $numerocasa         = mysqli_real_escape_string($conexion, (strip_tags($_POST["numerocasa"], ENT_QUOTES)));
    $codigo_postal  = mysqli_real_escape_string($conexion, (strip_tags($_POST["codigo_postal"], ENT_QUOTES)));
    $telefono  = mysqli_real_escape_string($conexion, (strip_tags($_POST["telefono"], ENT_QUOTES)));
    $celular  = mysqli_real_escape_string($conexion, (strip_tags($_POST["celular"], ENT_QUOTES)));
    $postal = mysqli_real_escape_string($conexion, (strip_tags($_POST["codigo_postal"], ENT_QUOTES)));
    
    
    

    $sql = "UPDATE origen_laar SET provinciaO='" . $provincia . "',
                                            identificacion='" . $identificacion . "',
                                            ciudadO='" . $ciudad . "',
                                            nombreO='" . $nombre . "',
                                            direccion='" . $direccion . "',
                                            referencia='" . $referencia . "',
                                            numeroCasa='" . $numerocasa . "',
                                            postal='" . $postal . "',
                                            telefono='" . $telefono . "',
                                           
                                            celular='$celular'
                                            WHERE id_origen='1'";
    $query_update = mysqli_query($conexion, $sql);
    if ($query_update) {
        $messages[] = "Datos han sido actualizados satisfactoriamente.";
    } else {
        $errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($conexion);
    }
} else {
    $errors[] = "Error desconocido.";
}

if (isset($errors)) {

    ?>
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
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
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
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