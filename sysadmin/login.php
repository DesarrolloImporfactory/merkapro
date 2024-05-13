<?php

if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once "vistas/libraries/password_compatibility_library.php";
}
// include the configs / constants for the database connection
require_once "vistas/db.php";

// load the login class
require_once "classes/Login.php";

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process. in consequence, you can simply ...
$login = new Login();

if (isset($_GET['change'])) {
    $change = $_GET['change'];
    if ($change == 'success') {
        $login->messages[] = "Contraseña cambiada correctamente, ingresá con tu nueva contraseña.";
    }
}

// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) {
    // the user is logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are logged in" view.
    //header("location: vistas/html/principal.php");
    header("location: vistas/html/dashboard.php");
} else {
    // the user is not logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are not logged in" view..
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="description" content="Constructor Merkapro">
        <meta name="author" content="Merkapro">

        <link rel="shortcut icon" href="assets/images/favicon.png">

        <title>Merkapro</title>

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
            background: url(img/login/logo_o.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            height: 100% !important;
        }
    </style>

    <body>

        <div class="wrapper-page">
            <?php
            include("vistas/db.php");
            include("vistas/php_conexion.php");
            include 'vistas/funciones.php';
            $url = get_row('perfil', 'logo_url', 'id_perfil', 1);
            $resultado = str_replace("../../", "", $url);

            if(empty($url) || $url == null){
                $resultado  = "https://marketplace.imporsuit.com/sysadmin/img/MERKATODO-LOGO.png";
            }
            //echo $resultado;
            // $nombre_empresa= get_row('perfil','nombre_empresa', 'id_perfil', 1);
            // echo $url;
            ?>
            <?php
            //echo $actualzacion_sistema;

            if (@$actualzacion_sistema == 1) {
                //include './vistas/verificar_actualizacion_base.php';

            ?>
                <div class="alert alert-success" role="alert">
                    <h4>¡Éxito! Tu sistema ha sido actualizado.</h4>
                </div>
            <?php
            }
            ?>
            <div align="center">
                <img src="<?php echo $resultado; ?>" class="img-responsive" alt="profile-image" height="100px">
            </div><br>

            <form method="post" accept-charset="utf-8" action="login.php" name="loginform" class="form-signin">
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
                <div class="card-d card-outline card-top-primary shadow-xl">
                    <div class="card-header-d  bg-white text-center">
                        <h2 class="text-bold"></h2>
                        <p></p>
                    </div>
                    <div class="card-body px-4 py-2">
                        <h5 class="card-title">
                            LOGIN
                        </h5>
                        <div class="input-group mb-3">
                            <input class="form-control" type="text" name="usuario_users" id="usuario_users" required="" placeholder="Usuario" autocomplete="off" autofocus="">
                        </div>


                        <div class="input-group mb-3">
                            <input class="form-control" type="password" name="con_users" required="" placeholder="Contraseña" autocomplete="off">
                        </div>

                        <div class="form-group text-right m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" name="login" id="submit"><i class='fa fa-unlock'></i> Iniciar Sesión
                                </button>
                            </div>
                        </div>


                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <a href="recovery_password.php" class="text-muted"><i class='fa fa-lock'></i> ¿Olvidaste tu contraseña?</a>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>


        <script>
            var resizefunc = [];
        </script>

        <!-- Plugins  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/tether.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/wow.min.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
        <script src="assets/plugins/switchery/switchery.min.js"></script>

        <!-- Custom main Js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            if (window.location.search != null) {
                $("#usuario_users").val(window.location.search.split("=")[1])
            }
        </script>

        <script>
            // obtiene el item del localstorage 
            var item = localStorage.getItem('actualizacion');
            // si el item es null, entonces no se ha actualizado
            if (window.location.origin != "https://yapando.Merkapro.com" && window.location.origin != "https://ecuashop.Merkapro.com" && window.location.origin != "https://onlytap.Merkapro.com") {
                if (item == null) {
                    // se crea el item en el localstorage
                    localStorage.setItem('actualizacion', 1);
                    // se redirecciona a la pagina de actualizacion
                    Swal.fire({
                        title: '¡Actualización!',
                        text: 'Se ha detectado una actualización, por favor espera mientras se actualiza.',
                        icon: 'info',
                        showConfirmButton: false,
                        didOpen: async () => {
                            Swal.showLoading()
                            // se espera 3 segundos
                            await fetch('../db_update291123.php').then(response => response.text()).then(data => {
                                Swal.fire({
                                    title: "¡Actualización exitosa!",
                                    text: "Se ha actualizado correctamente, por favor inicia sesión nuevamente.",
                                    icon: "success",
                                    textConfirm: "Aceptar",
                                })
                            });
                        }
                    })
                }
            }
        </script>
    </body>

    </html>
<?php
}
