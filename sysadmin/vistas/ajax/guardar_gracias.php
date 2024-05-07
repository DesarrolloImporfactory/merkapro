<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['contenido'])) {
    $errors[] = "referencia vacío";
} else if (!empty($_POST['contenido'])) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    
    $politica      = $_POST['contenido'];
   
  // echo $politica;
    // check if user or email address already exists
    $sql   = "SELECT * FROM gracias";
     
    $query_check_user_name = mysqli_query($conexion, $sql);
    $query_check_user      = mysqli_num_rows($query_check_user_name);
    if ($query_check_user == true) {
        //update
         $sql = "update `gracias` set contenido= '".$politica."' ";
       //echo 'inserat0'.$sql;
        $query_new_insert = mysqli_query($conexion, $sql);

        if ($query_new_insert) {
            header("Location: ../html/gracias.php", TRUE, 301);

            exit();

        } else {
            $errors[] = "Lo sientos  s algo ha salido mal intenta nuevamente." . mysqli_error($conexion);
        }
        
    } else {
        // write new user's data into database

       $sql = "INSERT INTO `gracias` (  `contenido`) VALUES ('$politica')";
       echo 'inserat0'.$sql;
        $query_new_insert = mysqli_query($conexion, $sql);

        if ($query_new_insert) {
              header("Location: ../html/gracias.php", TRUE, 301);

        } else {
            $errors[] = "Lo siento ddfffr algo ha salido mal intenta nuevamente." . mysqli_error($conexion);
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