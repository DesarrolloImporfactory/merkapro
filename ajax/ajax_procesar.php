<?php
//include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['contenido'])) {
    $errors[] = "referencia vacío";
     
} else if (!empty($_POST['contenido'])) {
    /* Connect To Database*/
    //echo 'sdsdfdddd-';
    
    require '../sysadmin/vistas/db.php';
    require '../sysadmin/vistas/php_conexion.php';
    // escaping, additionally removing everything that could be (html/javascript-) code
    
    $contenido      = $_POST['contenido'];
    $id      = $_POST['id_producto'];
   
    //echo $contenido;
    // check if user or email address already exists
    $sql   = "SELECT * FROM landing WHERE id_producto ='" . $id . "';";
     
    $query_check_user_name = mysqli_query($conexion, $sql);
    $query_check_user      = mysqli_num_rows($query_check_user_name);
    if ($query_check_user == true) {
        //update
         $sql = "update `landing` set contenido= '$contenido' where id_producto='$id'";
      // echo 'inserat0'.$sql;
        $query_new_insert = mysqli_query($conexion, $sql);

        if ($query_new_insert) {
              header("Location: ../landing.php?id=$id", TRUE, 301);

exit();

        } else {
            $errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($conexion);
        }
        
    } else {
        // write new user's data into database

       $sql = "INSERT INTO `landing` ( `id_producto`, `contenido`) VALUES ($id, '$contenido')";
      // echo 'inserat0'.$sql;
        $query_new_insert = mysqli_query($conexion, $sql);

        if ($query_new_insert) {
              header("Location: ../landing.php?id=$id", TRUE, 301);

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