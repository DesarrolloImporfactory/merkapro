<footer class="bg-dark footer " id="tempaltemo_footer">
        <div class="container">
            <div class="row">

                <div class="col-md-4 pt-5">
                    <h2 class="h2 texto_footer border-bottom pb-3 border-light logo">  <?php echo get_row('perfil', 'nombre_empresa', 'id_perfil', '1')?></h2>
                    <ul class="list-unstyled texto_footer footer-link-list">
                        <li>
                            <i class="fas fa-map-marker-alt fa-fw"></i>
                            <?php echo get_row('perfil', 'direccion', 'id_perfil', '1')?>
                        </li>
                        <li>
                            <i class="fa fa-phone fa-fw"></i>
                            <a  class="text-decoration-none texto_footer" href="tel:<?php echo get_row('perfil', 'telefono', 'id_perfil', '1')?>"><?php echo get_row('perfil', 'telefono', 'id_perfil', '1')?></a>
                        </li>
                        <li>
                            <i class="fa fa-envelope fa-fw"></i>
                            <a class="text-decoration-none texto_footer" href="mailto:<?php echo get_row('perfil', 'email', 'id_perfil', '1')?>info@company.com"><?php echo get_row('perfil', 'email', 'id_perfil', '1')?></a>
                        </li>
                    </ul>
                </div>

                <div class="col-md-4 pt-5">
                    <h2 class="h2 texto_footer border-bottom pb-3 border-light">Menu</h2>
                    <ul class="list-unstyled texto_footer footer-link-list">
                        <li><a class="text-decoration-none texto_footer" href="#">Productos</a></li>
                        <li><a class="text-decoration-none texto_footer" href="#">Contactos</a></li>
                       
                    </ul>
                </div>

                <!--div class="col-md-4 pt-5">
                    <h2 class="h2 texto_footer border-bottom pb-3 border-light">Further Info</h2>
                    <ul class="list-unstyled texto_footer footer-link-list">
                        <li><a class="text-decoration-none texto_footer" href="#">Home</a></li>
                        <li><a class="text-decoration-none texto_footer" href="#">About Us</a></li>
                        <li><a class="text-decoration-none texto_footer" href="#">Shop Locations</a></li>
                        <li><a class="text-decoration-none texto_footer" href="#">FAQs</a></li>
                        <li><a class="text-decoration-none texto_footer" href="#">Contact</a></li>
                    </ul>
                </div-->

            </div>

            <div class="row text-light mb-4">
                <div class="col-12 mb-3">
                    <div class="w-100 my-3 border-top border-light"></div>
                </div>
                <div class="col-auto me-auto">
                    <ul class="list-inline text-left footer-icons">
                         <?php  if(get_row('perfil', 'facebook', 'id_perfil', '1')) {
                            ?>
                        <li class="list-inline-item border border-light rounded-circle text-center">
                            <a class="texto_footer text-decoration-none" target="_blank" href="<?php if(get_row('perfil', 'facebook', 'id_perfil', '1')){ echo get_row('perfil', 'facebook', 'id_perfil', '1'); }?>"><i class="fab fa-facebook-f fa-lg fa-fw"></i></a>
                        </li>
                         <?php  }
                            ?>
                        <?php  if(get_row('perfil', 'instagram', 'id_perfil', '1')) {
                            ?>
                        
                        <li class="list-inline-item border border-light rounded-circle text-center">
                            <a class="texto_footer text-decoration-none" target="_blank" href="<?php  if(get_row('perfil', 'instagram', 'id_perfil', '1')) {echo get_row('perfil', 'instagram', 'id_perfil', '1'); }?>"><i class="fab fa-instagram fa-lg fa-fw"></i></a>
                        </li>
                               <?php  }
                            ?>
                         <?php  if(get_row('perfil', 'tiktok', 'id_perfil', '1')) {
                            ?>
                        <li class="list-inline-item border border-light rounded-circle text-center">
                            <a class="texto_footer text-decoration-none" target="_blank" href="<?php  if(get_row('perfil', 'tiktok', 'id_perfil', '1')) { echo get_row('perfil', 'tiktok', 'id_perfil', '1'); }?>"><i class="fab fa-tiktok fa-lg fa-fw"></i></a>
                        </li>
                        <?php  }
                            ?>
                        
                    </ul>
                </div>
                <div class="col-auto">
                    <label class="sr-only" for="subscribeEmail">Email address</label>
                    <div class="input-group mb-2">
                        <input type="text" class="form-control bg-dark border-light" id="subscribeEmail" placeholder="Email address">
                        <div class="input-group-text boton text-light">Subscribe</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-100 bg-black py-3">
            <div class="container">
                <div class="row pt-2">
                    <div class="col-12">
                        <p class="text-left texto_footer">
                            Copyright &copy; 2021 ImportFactory 
                            | Diseñado por <a rel="sponsored" href="https://templatemo.com" target="_blank">Más Información</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </footer>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<a href="https://api.whatsapp.com/send?phone=<?php
        echo get_row('perfil', 'whatsapp', 'id_perfil', '1');
    ?>" class="float" target="_blank">
<i class="fa fa-whatsapp my-float"></i>
</a>
