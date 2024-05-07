<style>
    /* Estilos CSS para la sección de redes sociales en el footer */
    .footer-social {
        padding: 20px 0;
        /* Espaciado interno superior e inferior */
        text-align: center;
        /* Centra el contenido horizontalmente */
    }

    .social-icons {
        list-style: none;
        padding: 20;
    }

    .social-icons li {
        display: inline-block;
        margin-right: 20px;
        /* Espaciado entre íconos de redes sociales */
    }

    .social-icons a {
        color: <?php echo get_row('perfil', 'texto_footer', 'id_perfil', 1); ?>;
        /* Color del icono de la red social */
        font-size: 24px;
        text-decoration: none;
    }

    .footer-poli {
        //background-color: #333; /* Color de fondo del footer */
        padding: 20px 0;
        /* Espaciado interno superior e inferior */
        text-align: center;
        /* Centra el contenido horizontalmente */
    }

    .footer-poli ul {
        list-style: none;
        padding: 0;
    }

    .footer-poli li {
        display: inline;
        margin-right: 20px;
        /* Espaciado entre elementos del menú */
    }

    .footer-poli a {
        color: #fff;
        /* Color del texto del menú */
        text-decoration: none;
        font-size: 16px;
    }
</style>
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<footer class="texto_footer footer color-accent-1 gradient section-sections--20805847089433__footer-padding">
    <div class="footer__content-top page-width">
        <div class="footer__blocks-wrapper grid">
            <div class="footer-block grid__item footer-block--desktop-3 footer-block--mobile-2">
                <h2 class="footer-block__heading texto_footer">Contacto:</h2>
                <div class="footer-block__details-content rte">
                    <p><?php echo get_row('perfil', 'texto_contactos', 'id_perfil', '1') ?> </p>
                    <p><?php echo get_row('perfil', 'direccion', 'id_perfil', '1') ?></p>
                </div>

            </div>

        </div>

        <div class="footer-social">
            <div class="container">
                <ul class="social-icons">
                    <?php if (get_row('perfil', 'facebook', 'id_perfil', '1')) {
                    ?>
                        <li><a target="_blank" href="<?php if (get_row('perfil', 'facebook', 'id_perfil', '1')) {
                                                            echo get_row('perfil', 'facebook', 'id_perfil', '1');
                                                        } ?>"><i class="fab fa-facebook"></i></a></li>

                    <?php  }
                    ?>
                    <?php if (get_row('perfil', 'instagram', 'id_perfil', '1')) {
                    ?>
                        <li><a target="_blank" target="_blank" href="<?php if (get_row('perfil', 'instagram', 'id_perfil', '1')) {
                                                                            echo get_row('perfil', 'instagram', 'id_perfil', '1');
                                                                        } ?>"><i class="fab fa-instagram"></i></a></li>

                    <?php  }
                    ?>
                    <?php if (get_row('perfil', 'tiktok', 'id_perfil', '1')) {
                    ?>
                        <li><a target="_blank" href="<?php if (get_row('perfil', 'tiktok', 'id_perfil', '1')) {
                                                            echo get_row('perfil', 'tiktok', 'id_perfil', '1');
                                                        } ?>"><i class="fab fa-tiktok"></i></a></li>

                    <?php  }
                    ?>



                    <!-- Agrega más íconos y enlaces a otras redes sociales si es necesario -->
                </ul>
            </div>
        </div>
        <div class="footer-block--newsletter"></div>
    </div>
    <div class="footer__content-bottom">
        <div class="footer__content-bottom-wrapper page-width">
            <div class="footer__column footer__localization isolate"></div>
            <div class="footer__column footer__column--info">
                <div class="footer__payment">
                    <span class="visually-hidden">Payment methods</span>
                    <!--ul class="list list-payment" role="list"><li class="list-payment__item">
                  <svg class="icon icon--full-color" viewBox="0 0 38 24" xmlns="http://www.w3.org/2000/svg" width="38" height="24" role="img" aria-labelledby="pi-paypal"><title id="pi-paypal">PayPal</title><path opacity=".07" d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3z"/><path fill="#fff" d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32"/><path fill="#003087" d="M23.9 8.3c.2-1 0-1.7-.6-2.3-.6-.7-1.7-1-3.1-1h-4.1c-.3 0-.5.2-.6.5L14 15.6c0 .2.1.4.3.4H17l.4-3.4 1.8-2.2 4.7-2.1z"/><path fill="#3086C8" d="M23.9 8.3l-.2.2c-.5 2.8-2.2 3.8-4.6 3.8H18c-.3 0-.5.2-.6.5l-.6 3.9-.2 1c0 .2.1.4.3.4H19c.3 0 .5-.2.5-.4v-.1l.4-2.4v-.1c0-.2.3-.4.5-.4h.3c2.1 0 3.7-.8 4.1-3.2.2-1 .1-1.8-.4-2.4-.1-.5-.3-.7-.5-.8z"/><path fill="#012169" d="M23.3 8.1c-.1-.1-.2-.1-.3-.1-.1 0-.2 0-.3-.1-.3-.1-.7-.1-1.1-.1h-3c-.1 0-.2 0-.2.1-.2.1-.3.2-.3.4l-.7 4.4v.1c0-.3.3-.5.6-.5h1.3c2.5 0 4.1-1 4.6-3.8v-.2c-.1-.1-.3-.2-.5-.2h-.1z"/></svg>
                </li></ul-->
                </div>
            </div>
        </div>
        <div class="footer-poli">
            <div class="container">
                <ul>

                    <?php
                    $sql = "select * from politicas_empresa";
                    $query = mysqli_query($conexion, $sql);
                    while ($row = mysqli_fetch_array($query)) {


                    ?>
                        <li><a href="politicas.php?id=<?php echo $row['id_politica']; ?>"><?php echo $row['nombre']; ?></a></li>
                    <?php
                    }

                    ?>

                    <!-- Agrega más elementos de menú si es necesario -->
                </ul>
            </div>
        </div>
        <div class="footer__content-bottom-wrapper page-width">
            <div class="footer__copyright caption">
                <small class="copyright__content">&copy; 2024 Sitio Web desarrollado por</small>
                <a href="https://www.imporsuit.com" title=""><small class="copyright__content">IMPORSUIT</small></a>
                <ul class="policies list-unstyled"></ul>
            </div>
        </div>
    </div>
</footer>