<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/

/* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    $titulo_slider2 = $_POST["titulo_slider"];
    $texto_btn_slider2 = $_POST["texto_btn_slider"];
    $enlace_btn_slider2 = $_POST["enlace_btn_slider"];
    $texto_slider2 = $_POST['texto_slider'];
    $alineacion = $_POST['alineacion2'];
    $conexion_marketplace = new mysqli('localhost', 'imporsuit_marketplace', 'imporsuit_marketplace', 'imporsuit_marketplace');

    //$posicion      = $_POST["posicion"];

    $users       = intval($_SESSION['id_users']);

       $sql = "INSERT INTO banner_marketplace (texto_banner,titulo,texto_boton,enlace_boton,alineacion)
       VALUES ('$texto_slider2','$titulo_slider2','$texto_btn_slider2','$enlace_btn_slider2','$alineacion')";
        $query_new_insert = mysqli_query($conexion_marketplace, $sql);
        echo mysqli_error($conexion_marketplace);
        if ($query_new_insert) {
            $messages[] = "Texto ha sido ingresada con Exito.";
        } else {
            $errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($conexion);
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
