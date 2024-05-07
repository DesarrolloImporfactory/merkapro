<style>
    .superior {
        background-color: <?php echo get_row('perfil', 'color', 'id_perfil', '1') ?> !important;
    }

    .footer {
        background-color: <?php echo get_row('perfil', 'color_footer', 'id_perfil', '1') ?> !important;
    }

    .boton {
        background-color: <?php echo get_row('perfil', 'color_botones', 'id_perfil', '1') ?> !important;
        border-color: <?php echo get_row('perfil', 'color_botones', 'id_perfil', '1') ?> !important;

    }

    .boton2 {
        background-color: <?php echo get_row('perfil', 'color_botones', 'id_perfil', '1') ?> !important;
        border-color: <?php echo get_row('perfil', 'color_botones', 'id_perfil', '1') ?> !important;
        border-radius: 25px;
        height: 60px;
    }

    .boton2:hover {

        margin-bottom: 2px;

        box-shadow: inset 0 0 10px 0 white;
        ;

    }

    .migas_enlace {
        font-weight: bold !important;
        color: <?php echo get_row('perfil', 'color', 'id_perfil', '1') ?>
    }

    .migas {
        color: <?php echo get_row('perfil', 'color', 'id_perfil', '1') ?>
    }

    .texto_cabecera {
        color: <?php echo get_row('perfil', 'texto_cabecera', 'id_perfil', '1') ?> !important;
    }

    .texto_boton {
        color: <?php echo get_row('perfil', 'texto_boton', 'id_perfil', '1') ?> !important;
    }

    .texto_footer {
        color: <?php echo get_row('perfil', 'texto_footer', 'id_perfil', '1') ?> !important;
    }

    .precio_oferta {
        color: <?php echo get_row('perfil', 'texto_precio', 'id_perfil', '1') ?> !important;
        font-weight: bold;
    }

    .precio_normal {
        font-weight: bold;
    }

    .ahorro {
        color: #ea2929;
        border-style: solid;
        border-radius: 7px;
        padding: 3px;
        font-size: 11px
    }
</style>
<nav class="navbar navbar-expand-lg bg-dark superior navbar-light d-none d-lg-block texto_cabecera" id="templatemo_nav_top">
    <div class="container text-light">
        <div class="w-100 d-flex justify-content-between">
            <div class="texto_cabecera">
                <i class="fa fa-envelope mx-2"></i>
                <a class="navbar-sm-brand texto_cabecera text-decoration-none" href="mailto:<?php echo get_row('perfil', 'email', 'id_perfil', '1') ?>"><?php echo get_row('perfil', 'email', 'id_perfil', '1') ?></a>
                <i class="fa fa-phone mx-2"></i>
                <a class="navbar-sm-brand  texto_cabecera text-decoration-none" href="tel:<?php echo get_row('perfil', 'telefono', 'id_perfil', '1') ?>"><?php echo get_row('perfil', 'telefono', 'id_perfil', '1') ?></a>

            </div>
            <div class="flexbox">
                <strong style="font-size: 9px"> ❗ Alta Demanda de Pedidos - Realiza el Tuyo Antes Que Se Agoten</strong>
            </div>
            <div>



                <?php if (get_row('perfil', 'facebook', 'id_perfil', '1')) {
                ?>
                    <a class="text-light" href="<?php if (get_row('perfil', 'facebook', 'id_perfil', '1')) {
                                                    echo get_row('perfil', 'facebook', 'id_perfil', '1');
                                                } ?>" target="_blank" rel="sponsored"><i class="fab fa-facebook-f fa-sm fa-fw me-2"></i></a>
                <?php  }
                ?>
                <?php if (get_row('perfil', 'instagram', 'id_perfil', '1')) {
                ?>
                    <a class="text-light" href="<?php if (get_row('perfil', 'instagram', 'id_perfil', '1')) {
                                                    echo get_row('perfil', 'instagram', 'id_perfil', '1');
                                                } ?>" target="_blank"><i class="fab fa-instagram fa-sm fa-fw me-2"></i></a>
                <?php  }
                ?>
                <?php if (get_row('perfil', 'tiktok', 'id_perfil', '1')) {
                ?>
                    <a class="text-light" href="<?php if (get_row('perfil', 'tiktok', 'id_perfil', '1')) {
                                                    echo get_row('perfil', 'instagram', 'id_perfil', '1');
                                                } ?>" target="_blank"><i class="fab fa-tiktok fa-sm fa-fw me-2"></i></a>
                <?php  }
                ?>

            </div>
        </div>
    </div>
</nav>
<nav class="navbar navbar-expand-lg navbar-light shadow">
    <div class="container d-flex justify-content-between align-items-center">

        <a class="navbar-brand text-success logo h1 align-self-center" href="index.php">
            <img width="150px" class="" src="sysadmin/<?php echo str_replace("../..", "", get_row('perfil', 'logo_url', 'id_perfil', '1')) ?>">
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="align-self-center collapse navbar-collapse flex-fill  d-lg-flex justify-content-lg-between" id="templatemo_main_nav">
            <div class="flex-fill">
                <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Tienda</a>
                    </li>
                    <li class="nav-item">

                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contactos.php">Contactos</a>
                    </li>
                </ul>
            </div>
            <div class="navbar align-self-center d-flex">
                <div class="d-lg-none flex-sm-fill mt-3 mb-4 col-7 col-sm-auto pr-3">
                    <div class="input-group">
                        <input type="text" class="form-control" id="inputMobileSearch" placeholder="Buscar ...">
                        <div class="input-group-text">
                            <i class="fa fa-fw fa-search"></i>
                        </div>
                    </div>
                </div>
                <a class="nav-icon d-none d-lg-inline" href="#" data-bs-toggle="modal" data-bs-target="#templatemo_search">
                    <i class="fa fa-fw fa-search text-dark mr-2"></i>
                </a>
                <a class="nav-icon position-relative text-decoration-none" href="#">
                    <i class="fa fa-fw fa-cart-arrow-down text-dark mr-1"></i>
                    <span id="total_carrito" class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark">0</span>
                </a>

            </div>
        </div>

    </div>
</nav>
<input type="hidden" id="session" name="session" value="<?php echo $session_id;    ?>">