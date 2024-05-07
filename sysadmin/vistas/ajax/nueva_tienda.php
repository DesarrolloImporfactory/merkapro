<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['nombre'])) {
    $errors[] = "referencia vacío";
} else if (!empty($_POST['nombre'])) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    $nombre      = mysqli_real_escape_string($conexion, (strip_tags($_POST["nombre"], ENT_QUOTES)));
    $contacto = mysqli_real_escape_string($conexion, (strip_tags($_POST["contacto"], ENT_QUOTES)));
    $whatsapp = mysqli_real_escape_string($conexion, (strip_tags($_POST["whatsapp"], ENT_QUOTES)));
    $ingreso = mysqli_real_escape_string($conexion, (strip_tags($_POST["ingreso"], ENT_QUOTES)));
    $actualiza = mysqli_real_escape_string($conexion, (strip_tags($_POST["actualiza"], ENT_QUOTES)));
    $caduca = mysqli_real_escape_string($conexion, (strip_tags($_POST["caduca"], ENT_QUOTES)));
    $plan = mysqli_real_escape_string($conexion, (strip_tags($_POST["plan"], ENT_QUOTES)));
    $subdominio = mysqli_real_escape_string($conexion, (strip_tags($_POST["subdominio"], ENT_QUOTES)));
    $carpeta = mysqli_real_escape_string($conexion, (strip_tags($_POST["carpeta"], ENT_QUOTES)));
    $dominio = mysqli_real_escape_string($conexion, (strip_tags($_POST["dominio"], ENT_QUOTES)));
    $email = mysqli_real_escape_string($conexion, (strip_tags($_POST["email"], ENT_QUOTES)));
    $db_name = mysqli_real_escape_string($conexion, (strip_tags($_POST["db_name"], ENT_QUOTES)));
    $db_user = mysqli_real_escape_string($conexion, (strip_tags($_POST["db_user"], ENT_QUOTES)));
    $db_pass = mysqli_real_escape_string($conexion, (strip_tags($_POST["db_pass"], ENT_QUOTES)));
    $referido = mysqli_real_escape_string($conexion, (strip_tags($_POST["referido"], ENT_QUOTES)));
    $padre = mysqli_real_escape_string($conexion, (strip_tags($_POST["padre"], ENT_QUOTES)));
    $token = mysqli_real_escape_string($conexion, (strip_tags($_POST["token"], ENT_QUOTES)));
    
    
    // check if user or email address already exists
    $sql                   = "SELECT * FROM plataformas WHERE url_imporsuit ='" . $subdominio . "';";
    $query_check_user_name = mysqli_query($conexion, $sql);
    $query_check_user      = mysqli_num_rows($query_check_user_name);
    if ($query_check_user == true) {
        $errors[] = "Subdominio  ya está en uso.";
    } else {
        // write new user's data into database

       $sql = "INSERT INTO `plataformas` (`nombre_tienda`, `contacto`, `whatsapp`, `fecha_ingreso`, `fecha_actualza`, `fecha_caduca`, `id_plan`, `url_imporsuit`, `dominio`, `carpeta_servidor`, `email`, `db_name`, `bd_usuario`, `bd_pass`, `referido`, `token_referido`, `refiere`, `estado`) "
               . "VALUES ( '$nombre', '$contacto', '$whatsapp', '$ingreso', '$actualiza', '$caduca', '$plan', '$subdominio', '$dominio', '$carpeta', '$email', '$db_name', '$db_user', '$db_pass', '$referido', '$token', '$padre', '1');";
//echo $sql;
       
        $query_new_insert = mysqli_query($conexion, $sql);
        if ($query_new_insert) {
            $messages[] = "Liena ha sido ingresada con Exito.";
        } else {
            $errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($conexion);
        }
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