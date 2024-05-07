<sticky-header data-sticky-type="on-scroll-up" class="header-wrapper color-background-1 gradient header-wrapper--border-bottom">
  <header class="header header--middle-center header--mobile-center page-width header--has-menu"><header-drawer data-breakpoint="tablet">
        <details id="Details-menu-drawer-container" class="menu-drawer-container">
          <summary class="header__icon header__icon--menu header__icon--summary link focus-inset" aria-label="Menu">
            <span>
              <svg
  xmlns="http://www.w3.org/2000/svg"
  aria-hidden="true"
  focusable="false"
  class="icon icon-hamburger"
  fill="none"
  viewBox="0 0 18 16"
>
  <path d="M1 .5a.5.5 0 100 1h15.71a.5.5 0 000-1H1zM.5 8a.5.5 0 01.5-.5h15.71a.5.5 0 010 1H1A.5.5 0 01.5 8zm0 7a.5.5 0 01.5-.5h15.71a.5.5 0 010 1H1a.5.5 0 01-.5-.5z" fill="currentColor">
</svg>

              <svg
  xmlns="http://www.w3.org/2000/svg"
  aria-hidden="true"
  focusable="false"
  class="icon icon-close"
  fill="none"
  viewBox="0 0 18 17"
>
  <path d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z" fill="currentColor">
</svg>

            </span>
          </summary>
          <div id="menu-drawer" class="gradient menu-drawer motion-reduce color-background-1" tabindex="-1">
            <div class="menu-drawer__inner-container">
              <div class='menu-drawer__mobile-content menu-drawer__title-and-close-btn'>
                <h3 class='menu-drawer__title'>Menu</h3>
                <button class='menu-drawer__close-btn header__icon header__icon--menu header__icon--summary link focus-inset'>
                  <svg
  xmlns="http://www.w3.org/2000/svg"
  aria-hidden="true"
  focusable="false"
  class="icon icon-close"
  fill="none"
  viewBox="0 0 18 17"
>
  <path d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z" fill="currentColor">
</svg>

                </button>
              </div>
              <div class="menu-drawer__navigation-container">
                <nav class="menu-drawer__navigation">
                  <ul class="menu-drawer__menu has-submenu list-menu" role="list"><li><a href="/" class="menu-drawer__menu-item list-menu__item link link--text focus-inset">
                            Inicio
                          </a></li><li><a href="categoria.php" class="menu-drawer__menu-item list-menu__item link link--text focus-inset menu-drawer__menu-item--active" aria-current="page">
                            Catálogo
                          </a></li><!--li><a href="/pages/contact" class="menu-drawer__menu-item list-menu__item link link--text focus-inset">
                            Contacto
                          </a></li--></ul>
                </nav>
<!--                 start secondary nav -->
                
                  <nav class="menu-drawer__navigation menu-drawer__secondary-nav">
                    <ul class="menu-drawer__menu has-submenu list-menu" role="list">
                        <!--li>
                            <a href="/search" class="menu-drawer__menu-item list-menu__item link link--text focus-inset">
                              Búsqueda
                            </a></li-->
                         <?php
       $sql="select * from politicas_empresa";
                           $query = mysqli_query($conexion, $sql);
                           while ($row = mysqli_fetch_array($query)) {
                                
                           
        ?>
                        <li><a href="politicas.php?id=<?php echo $row['id_politica'];?>" class="menu-drawer__menu-item list-menu__item link link--text focus-inset">
                             <?php echo $row['nombre'];?>
                            </a></li>
                        
                        
                        <?php
                        }
                        ?>
                    </ul>
                  </nav>
                
<!--                 end secondary nav -->
                <div class="menu-drawer__utility-links"><ul class="list list-social list-unstyled" role="list"></ul>
                </div>
              </div>
            </div>
          </div>
        </details>
      </header-drawer>
      <nav class="header__inline-menu">
        <ul class="list-menu list-menu--inline" role="list"><li>
                <a href="index.php" class=" <?php echo $index_activa;?> header__menu-item list-menu__item link link--text focus-inset">
                  <span class="">Inicio</span>
                </a></li><li>
                    <a  href="categoria.php" class="<?php echo $categoria_activa;?> header__menu-item list-menu__item link link--text focus-inset" aria-current="page">
                  <span class="">Catálogo</span>
                </a></li>
            <!--li><a href="#" class="header__menu-item list-menu__item link link--text focus-inset">
                  <span>Contacto</span>
                </a></li--></ul>
      </nav><a href="/" class="header__heading-link link link--text focus-inset">
          <img src="sysadmin/<?php  echo str_replace ( "../.." , "" , get_row('perfil', 'logo_url', 'id_perfil', '1')  )?>" alt=""  width="140" height="36.4" class="header__heading-logo">
</a>
      
  </header>
</sticky-header>