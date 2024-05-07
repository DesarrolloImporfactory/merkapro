<!DOCTYPE html>
<?php
session_start();

require_once "sysadmin/vistas/db.php";
    require_once "sysadmin/vistas/php_conexion.php";
    require_once "sysadmin/vistas/funciones.php";
    
        
    $pagina='contactos';   
    $id_producto='';
    include './auditoria.php';

    ?>
<html lang="en">

<head>
    <title><?php echo "CONTACTOS"."-".get_row('perfil', 'nombre_empresa', 'id_perfil', '1')?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

   <link rel="apple-touch-icon" href="sysadmin/<?php  echo str_replace ( "../.." , "" , get_row('perfil', 'logo_url', 'id_perfil', '1')  )?>">
    <link rel="shortcut icon" type="image/x-icon" href="sysadmin/<?php  echo str_replace ( "../.." , "" , get_row('perfil', 'logo_url', 'id_perfil', '1')  )?>">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/templatemo.css">
    <link rel="stylesheet" href="assets/css/custom.css">

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">

    <!-- Slick -->
    <link rel="stylesheet" type="text/css" href="assets/css/slick.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/slick-theme.css">
<!--
    
TemplateMo 559 Zay Shop

https://templatemo.com/tm-559-zay-shop

-->
</head>


<body>
    <!-- Start Top Nav -->
    
    <!-- Close Top Nav -->


    <!-- Header -->
     <?php
        include 'menu.php';
    ?>
    <!-- Close Header -->

<?php

        include 'modal/comprar.php';
      
   
    ?>
    <!-- Close Header -->

    <!-- Modal -->
    <div class="modal fade bg-white" id="templatemo_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="w-100 pt-1 mb-5 text-right">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="get" class="modal-content modal-body border-0 p-0">
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="inputModalSearch" name="q" placeholder="Search ...">
                    <button type="submit" class="input-group-text bg-success text-light">
                        <i class="fa fa-fw fa-search text-white"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- Start Content Page -->
    <div class="container-fluid bg-light py-5">
        <div class="col-md-6 m-auto text-center">
            <h1 class="h1">Contactos</h1>
            <p>
                <?php echo get_row('perfil', 'texto_contactos', 'id_perfil', '1')?>
            </p>
        </div>
        <div style="background-color: white" id="" class="row" >
            <div id="mapid" class="col-md-6" >
        
    </div>
     <div id="" class="col-md-6" >
      
        
            <form class="col-md-9 m-auto" method="post" role="form">
                <div class="row">
                    <div class="form-group col-md-6 mb-3">
                        <label for="inputname">Name</label>
                        <input type="text" class="form-control mt-1" id="name" name="name" placeholder="Name">
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="inputemail">Email</label>
                        <input type="email" class="form-control mt-1" id="email" name="email" placeholder="Email">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="inputsubject">Subject</label>
                    <input type="text" class="form-control mt-1" id="subject" name="subject" placeholder="Subject">
                </div>
                <div class="mb-3">
                    <label for="inputmessage">Message</label>
                    <textarea class="form-control mt-1" id="message" name="message" placeholder="Message" rows="8"></textarea>
                </div>
                <div class="row">
                    <div class="col text-end mt-2">
                        <button type="submit" class="btn btn-success btn-lg px-3">Let’s Talk</button>
                    </div>
                </div>
            </form>
       
   
    </div> 
        </div>
    </div>

  
    <!-- Ena Map -->

    <!-- Start Contact -->
    
    <!-- End Contact -->


    <!-- Start Footer -->
    <?php

   include './footer.php';
    ?>
    <!-- End Footer -->

    <!-- Start Script -->
    <script src="assets/js/jquery-1.11.0.min.js"></script>
    <script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/templatemo.js"></script>
    <script src="assets/js/custom.js"></script>
    <!-- End Script -->
</body>

</html>