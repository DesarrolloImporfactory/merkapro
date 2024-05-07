<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['mod_id'])) {
    $errors[] = "ID vacío";
} else if (empty($_POST['mod_nombre'])) {
    $errors[] = "Nombre vacío";
} else if ($_POST['mod_estado'] == "") {
    $errors[] = "Selecciona el estado del cliente";
} else if (
    !empty($_POST['mod_id']) &&
    !empty($_POST['mod_nombre']) &&
    $_POST['mod_estado'] != ""
) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    $nombre    = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_nombre"], ENT_QUOTES)));
    $fiscal    = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_fiscal"], ENT_QUOTES)));
    $telefono  = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_telefono"], ENT_QUOTES)));
    $email     = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_email"], ENT_QUOTES)));
    $direccion = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_direccion"], ENT_QUOTES)));
    $estado    = intval($_POST['mod_estado']);

    $id_cliente = intval($_POST['mod_id']);
    
     $razon_social  = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_razon_social"], ENT_QUOTES)));
    $giro_negocio  = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_giro_negocio"], ENT_QUOTES)));
    $ciudad  = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_ciudad"], ENT_QUOTES)));
    $nombre_contacto  = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_nombre_contacto"], ENT_QUOTES)));
    
    $telefono_contacto  = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_telefono_contacto"], ENT_QUOTES)));
    $cargo_contacto  = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_cargo_contacto"], ENT_QUOTES)));
    $observaciones  = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_observaciones"], ENT_QUOTES)));
    $credito     = intval($_POST['mod_credito']);
    $sql        = "UPDATE clientes SET nombre_cliente='" . $nombre . "',
                                        fiscal_cliente='" . $fiscal . "',
                                        telefono_cliente='" . $telefono . "',
                                        email_cliente='" . $email . "',
                                        direccion_cliente='" . $direccion . "',
                                            
                                        razon_social='" . $razon_social . "',
                                        giro_negocio='" . $giro_negocio . "',
                                        ciudad='" . $ciudad . "',
                                        nombre_contacto='" . $nombre_contacto . "',
                                            telefono_contacto='" . $telefono_contacto . "',
                                        cargo_contacto='" . $cargo_contacto . "',
                                        observaciones='" . $observaciones . "',
                                        dias_credito='" . $credito . "',
                                            
                                        status_cliente='" . $estado . "'
                                        WHERE id_cliente='" . $id_cliente . "'";
    $query_update = mysqli_query($conexion, $sql);
    if ($query_update) {
        $messages[] = "Cliente ha sido actualizado con Exito.";
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