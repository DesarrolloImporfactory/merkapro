<?php
//Verificar actualizaciones
//include './vistas/verificar_actualizacion.php';
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) { // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php // (this library adds the PHP 5.5 password hashing functions to older versions of PHP) require_once "vistas/libraries/password_compatibility_library.php" ; } // include the configs / constants for the database connection require_once "vistas/db.php" ; // load the login class require_once "classes/Login.php" ; // create a login object. when this object is created, it will do all login/logout stuff automatically // so this single line handles the entire login process. in consequence, you can simply ... $login=new Login(); // ... ask if we are logged in here: if ($login->isUserLoggedIn() == true) {
    // the user is logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are logged in" view.
    //header("location: vistas/html/principal.php");
    header("location: vistas/html/dashboard.php");
}
// include the configs / constants for the database connection
require_once "vistas/db.php";

// load the login class
require_once "classes/Login.php";

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process. in consequence, you can simply ...
$login = new Login();

// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) {
    // the user is logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are logged in" view.
    //header("location: vistas/html/principal.php");
    header("location: vistas/html/dashboard.php");
} else {
    // the user is not logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are not logged in" view..
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="Constructor Imporsuit">
    <meta name="author" content="Importsuit">

    <link rel="shortcut icon" href="assets/images/favicon.png">

    <title>Imporsuit</title>

    <link href="assets/plugins/switchery/switchery.min.css" rel="stylesheet" />

    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">

    <script src="assets/js/modernizr.min.js"></script>

</head>
<style>
    html {
        background: transparent !important;
    }

    body {
        background: url(img/login/login.png);
        background-repeat: no-repeat;
        background-size: cover;
        height: 100% !important;
    }
</style>

<body>
    <div class="wrapper-page">
        <?php
        include 'vistas/db.php';
        include 'vistas/php_conexion.php';
        include 'vistas/funciones.php';
        $url = get_row('perfil', 'logo_url', 'id_perfil', 1);
        $resultado = str_replace("../", "", $url);
        ?>
        <div class="text-center pb-3">
            <img src="<?php echo $resultado; ?>" class="img-responsive" alt="profile-image" height="100px">
        </div>
        <div class="card-d card-outline card-top-primary shadow-xl">

            <div class="card-header-d  bg-white text-center">
                <h2 class="text-bold">IMPOR SUIT</h2>
                <p></p>
            </div>
            <div class="card-body px-4 py-2">
                <h5 class="card-title">
                    Restablecer contraseña
                </h5>
                <form action="recovery_password.php" accept-charset="utf-8" name="recoveryForm" method="post">
                    <?php
                    // show potential errors / feedback (from login object)
                    if (isset($login)) {
                        if ($login->errors) {
                    ?>
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <strong>Error!</strong>

                                <?php
                                foreach ($login->errors as $error) {
                                    echo $error;
                                }
                                ?>
                            </div>
                        <?php
                        }
                        if ($login->messages) {
                        ?>
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <strong>Aviso!</strong>
                                <?php
                                foreach ($login->messages as $message) {
                                    echo $message;
                                }
                                ?>
                            </div>
                    <?php
                        }
                    }
                    ?>
                    <input type="hidden" name="_token" value="slUBxMVTFbF5mlIDI9fvoEiOe6xUuqdfKdnLGX85">

                    <div class="form-group mb-3">
                        <input type="email" name="email_users" class="form-control " value="" placeholder="Email" autofocus="">
                        <span class="text-right fs-xs ">
                            Ingrese su correo electrónico para restablecer su contraseña
                        </span>

                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" name="recovery" id="submit" class="btn btn-block btn-flat btn-primary">
                                <span class="fa fa-envelope"></span>
                                Enviar correo
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <a href="login.php" class="btn btn-block btn-flat btn-default">
                                <span class="fa fa-arrow-left text-muted">Volver</span>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>