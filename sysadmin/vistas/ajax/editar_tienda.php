<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['mod_id'])) {
    $errors[] = "ID vacío";
} else if (
    !empty($_POST['mod_id'])
) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    $id_plataforma=$_POST['mod_id'];
    // escaping, additionally removing everything that could be (html/javascript-) code
   $nombre      = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_nombre"], ENT_QUOTES)));
    $contacto = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_contacto"], ENT_QUOTES)));
    $whatsapp = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_whatsapp"], ENT_QUOTES)));
    $ingreso = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_fecha_ingresa"], ENT_QUOTES)));
    $actualiza = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_fecha_actualza"], ENT_QUOTES)));
    $caduca = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_fecha_caduca"], ENT_QUOTES)));
    $plan = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_id_plan"], ENT_QUOTES)));
    $subdominio = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_subdominio"], ENT_QUOTES)));
    $carpeta = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_carpeta"], ENT_QUOTES)));
    $dominio = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_dominio"], ENT_QUOTES)));
    $email = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_email"], ENT_QUOTES)));
    $db_name = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_name"], ENT_QUOTES)));
    $db_user = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_user"], ENT_QUOTES)));
    $db_pass = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_pass"], ENT_QUOTES)));
    $referido = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_referido"], ENT_QUOTES)));
    $padre = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_token"], ENT_QUOTES)));
    $token = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_padre"], ENT_QUOTES)));

    
     $sql = "UPDATE plataformas SET  nombre_tienda='" . $nombre . "',
                                contacto='" . $contacto . "',
                                     whatsapp='" . $whatsapp . "',
                                     fecha_ingreso='" . $ingreso . "',
                                      fecha_actualza='" . $actualiza . "',
                                 fecha_caduca='" . $caduca . "',
                                  id_plan='" . $plan . "',
                                  url_imporsuit='" . $carpeta . "',
                                  dominio='" . $dominio . "',
                                   carpeta_servidor='" . $carpeta . "',
                                  email='" . $email . "',
                                   db_name='" . $db_name . "', 
                                         bd_usuario='" . $db_user . "', 
                                          bd_pass='" . $db_pass . "', 
                                           referido='" . $referido . "', 
                           token_referido='" . $token . "', 

                                refiere='" . $padre . "'
                                WHERE id_plataforma='" . $id_plataforma . "'";
    $query_update = mysqli_query($conexion, $sql);
    if ($query_update) {
        $messages[] = "Linea ha sido actualizada con Exito.";
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