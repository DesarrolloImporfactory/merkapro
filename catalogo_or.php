<!doctype html>
<?php
session_start();
if (!isset($_SESSION["comprar"])) {
  $session_id = 'user_' . mt_rand();
  $_SESSION["comprar"] = $session_id;
} else {
  $session_id = $_SESSION["comprar"];
}
if (isset($_GET['id_cat'])) {
  $id_categoria = $_GET['id_cat'];
}

require_once "sysadmin/vistas/db.php";
require_once "sysadmin/vistas/php_conexion.php";
require_once "sysadmin/vistas/funciones.php";

$id_producto = '';
$pagina = 'categorias';
include './auditoria.php';
include './includes/style.php';
if (isset($_GET['id_cat'])) {
  $sql = "select * from lineas where online='1' and padre='$id_categoria'";


  //echo $sql;
  $query = mysqli_query($conexion, $sql);
  $categorias = '';
  while ($row = mysqli_fetch_array($query)) {
    $id_linea         = $row['id_linea'];
    $nombre_linea     = $row['nombre_linea'];
    $padre  = $row['padre'];
    $categorias .= "'" . $row['id_linea'] . "',";
  }
}
?>
<html class="no-js" lang="es">
<?php
include 'includes/head.php'
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script><!-- comment -->
<script id="sections-script" data-sections="header,footer" defer="defer" src="js/scripts.js?84"></script>

<body class="gradient">


  <script src="js/cart.js?v=139383546597281746371693673626" defer="defer"></script>
  <script src="js/product-info.js?v=174806172978439001541693673628" defer="defer"></script>
  <script src="js/product-form.js?v=70749256710412210451693673628" defer="defer"></script>


  <style>
    .drawer {
      visibility: hidden;
      position: absolute;

    }
  </style>

  <?php
  include 'includes/carrito.php';
  ?>






  <!-- BEGIN sections: header-group -->
  <div id="shopify-section-sections--20805847122201__2c2ec774-3430-481f-b927-e9c035b9d24e" class="shopify-section shopify-section-group-header-group">

    <link href="ccs/component-tickers.css?v=30346802988262109031693673627" rel="stylesheet" type="text/css" media="all" />
    <style data-shopify>
      .section-sections--20805847122201__2c2ec774-3430-481f-b927-e9c035b9d24e-padding {
        padding-top: 12px;
        padding-bottom: 12px;
      }

      @media screen and (min-width: 750px) {
        .section-sections--20805847122201__2c2ec774-3430-481f-b927-e9c035b9d24e-padding {
          padding-top: 16px;
          padding-bottom: 16px;
        }
      }

      .horizontal-ticker-sections--20805847122201__2c2ec774-3430-481f-b927-e9c035b9d24e .horizontal-ticker__item {
        font-size: 1.75rem;
        padding: 0 3rem;
      }

      .horizontal-ticker-sections--20805847122201__2c2ec774-3430-481f-b927-e9c035b9d24e .horizontal-ticker__container {
        animation: horTicker 50s linear infinite forwards;
      }
    </style>

    <!-- <div class="horizontal-ticker__inner"> -->
    <?php
    include 'includes/horizontal_items.php';
    ?>
    <!-- </div> -->



  </div>
  <!-- comment -->
  <div id="shopify-section-sections--20805847122201__header" class="shopify-section shopify-section-group-header-group section-header">
    <link rel="stylesheet" href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-list-menu.css?v=151968516119678728991693673627" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="ccs/component-list-menu.css?v=151968516119678728991693673627" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="ccs/component-search.css?v=184225813856820874251693673627" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="ccs/component-menu-drawer.css?v=183501262910778191901693673627" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="ccs/component-cart-notification.css?v=137625604348931474661693673627" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="ccs/component-cart-items.css?v=68325217056990975251693673627" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-price.css?v=183165605081763449011693673627" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="ccs/component-loading-overlay.css?v=167310470843593579841693673627" media="print" onload="this.media='all'">
    <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-cart-drawer.css?v=103351759924144934211693673627" rel="stylesheet" type="text/css" media="all" />
    <link href="ccs/component-cart.css?v=183883492810467818381693673627" rel="stylesheet" type="text/css" media="all" />
    <link href="ccs/omponent-totals.css?v=54425048278126878361693673627" rel="stylesheet" type="text/css" media="all" />
    <link href="ccs/component-price.css?v=183165605081763449011693673627" rel="stylesheet" type="text/css" media="all" />
    <link href="ccs/component-discounts.css?v=152760482443307489271693673627" rel="stylesheet" type="text/css" media="all" />
    <link href="ccs/component-loading-overlay.css?v=167310470843593579841693673627" rel="stylesheet" type="text/css" media="all" />
    <noscript>
      <link href="ccs/component-list-menu.css?v=151968516119678728991693673627" rel="stylesheet" type="text/css" media="all" />
    </noscript>
    <noscript>
      <link href="ccs/component-search.css?v=184225813856820874251693673627" rel="stylesheet" type="text/css" media="all" />
    </noscript>
    <noscript>
      <link href="ccs/component-menu-drawer.css?v=183501262910778191901693673627" rel="stylesheet" type="text/css" media="all" />
    </noscript>
    <noscript>
      <link href="ccs/component-cart-notification.css?v=137625604348931474661693673627" rel="stylesheet" type="text/css" media="all" />
    </noscript>
    <noscript>
      <link href="ccs/component-cart-items.css?v=68325217056990975251693673627" rel="stylesheet" type="text/css" media="all" />
    </noscript>

    <link href="ccs/style_ini.css" rel="stylesheet" type="text/css" />

    <script src="js/details-disclosure.js?v=153497636716254413831693673628" defer="defer"></script>
    <script src="js/details-modal.js?v=4511761896672669691693673628" defer="defer"></script>
    <script src="js/cart-notification.js?v=160453272920806432391693673626" defer="defer"></script>
    <script src="js/search-form.js?v=113639710312857635801693673628" defer="defer"></script>
    <script src="//tiendamiaecu.com/cdn/shop/t/3/assets/cart-drawer.js?v=44260131999403604181693673626" defer="defer"></script><svg xmlns="http://www.w3.org/2000/svg" class="hidden">
      <symbol id="icon-search" viewbox="0 0 18 19" fill="none">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.03 11.68A5.784 5.784 0 112.85 3.5a5.784 5.784 0 018.18 8.18zm.26 1.12a6.78 6.78 0 11.72-.7l5.4 5.4a.5.5 0 11-.71.7l-5.41-5.4z" fill="currentColor" />
      </symbol>

      <symbol id="icon-reset" class="icon icon-close" fill="none" viewBox="0 0 18 18" stroke="currentColor">
        <circle r="8.5" cy="9" cx="9" stroke-opacity="0.2" />
        <path d="M6.82972 6.82915L1.17193 1.17097" stroke-linecap="round" stroke-linejoin="round" transform="translate(5 5)" />
        <path d="M1.22896 6.88502L6.77288 1.11523" stroke-linecap="round" stroke-linejoin="round" transform="translate(5 5)" />
      </symbol>

      <symbol id="icon-close" class="icon icon-close" fill="none" viewBox="0 0 18 17">
        <path d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z" fill="currentColor">
      </symbol>
    </svg>
    <sticky-header data-sticky-type="on-scroll-up" class="header-wrapper color-background-1 gradient header-wrapper--border-bottom">
      <header class="header header--middle-center header--mobile-center page-width header--has-menu"><header-drawer data-breakpoint="tablet">
          <details id="Details-menu-drawer-container" class="menu-drawer-container">
            <summary class="header__icon header__icon--menu header__icon--summary link focus-inset" aria-label="Menu">
              <span>
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" class="icon icon-hamburger" fill="none" viewBox="0 0 18 16">
                  <path d="M1 .5a.5.5 0 100 1h15.71a.5.5 0 000-1H1zM.5 8a.5.5 0 01.5-.5h15.71a.5.5 0 010 1H1A.5.5 0 01.5 8zm0 7a.5.5 0 01.5-.5h15.71a.5.5 0 010 1H1a.5.5 0 01-.5-.5z" fill="currentColor">
                </svg>

                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" class="icon icon-close" fill="none" viewBox="0 0 18 17">
                  <path d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z" fill="currentColor">
                </svg>

              </span>
            </summary>
            <div id="menu-drawer" class="gradient menu-drawer motion-reduce color-background-1" tabindex="-1">
              <div class="menu-drawer__inner-container">
                <div class='menu-drawer__mobile-content menu-drawer__title-and-close-btn'>
                  <h3 class='menu-drawer__title'>Menu</h3>
                  <button class='menu-drawer__close-btn header__icon header__icon--menu header__icon--summary link focus-inset'>
                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" class="icon icon-close" fill="none" viewBox="0 0 18 17">
                      <path d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z" fill="currentColor">
                    </svg>

                  </button>
                </div>
                <div class="menu-drawer__navigation-container">
                  <nav class="menu-drawer__navigation">
                    <ul class="menu-drawer__menu has-submenu list-menu" role="list">
                      <li><a href="/" class="menu-drawer__menu-item list-menu__item link link--text focus-inset">
                          Inicio
                        </a></li>
                      <li><a href="/collections/all" class="menu-drawer__menu-item list-menu__item link link--text focus-inset menu-drawer__menu-item--active" aria-current="page">
                          Catálogo
                        </a></li>
                      <li><a href="/pages/contact" class="menu-drawer__menu-item list-menu__item link link--text focus-inset">
                          Contacto
                        </a></li>
                    </ul>
                  </nav>
                  <!--                 start secondary nav -->

                  <nav class="menu-drawer__navigation menu-drawer__secondary-nav">
                    <ul class="menu-drawer__menu has-submenu list-menu" role="list">
                      <li><a href="/search" class="menu-drawer__menu-item list-menu__item link link--text focus-inset">
                          Búsqueda
                        </a></li>
                      <li><a href="/pages/terminos-y-condiciones-de-uso" class="menu-drawer__menu-item list-menu__item link link--text focus-inset">
                          Terminos y Condiciones de uso
                        </a></li>
                      <li><a href="/pages/politica-de-devoluciones-y-reembolsos" class="menu-drawer__menu-item list-menu__item link link--text focus-inset">
                          Politica de Devoluciones y Reembolsos
                        </a></li>
                      <li><a href="/pages/politica-de-privacidad" class="menu-drawer__menu-item list-menu__item link link--text focus-inset">
                          Política de Privacidad
                        </a></li>
                      <li><a href="/pages/politica-de-envios" class="menu-drawer__menu-item list-menu__item link link--text focus-inset">
                          Politica de Envíos
                        </a></li>
                    </ul>
                  </nav>

                  <!--                 end secondary nav -->
                  <div class="menu-drawer__utility-links">
                    <ul class="list list-social list-unstyled" role="list"></ul>
                  </div>
                </div>
              </div>
            </div>
          </details>
        </header-drawer>
        <nav class="header__inline-menu">
          <ul class="list-menu list-menu--inline" role="list">
            <li><a href="/" class="header__menu-item list-menu__item link link--text focus-inset">
                <span>Inicio</span>
              </a></li>
            <li><a href="/collections/all" class="header__menu-item list-menu__item link link--text focus-inset" aria-current="page">
                <span class="header__active-menu-item-v2 color-accent-1">Catálogo</span>
              </a></li>
            <li><a href="/pages/contact" class="header__menu-item list-menu__item link link--text focus-inset">
                <span>Contacto</span>
              </a></li>
          </ul>
        </nav><a href="/" class="header__heading-link link link--text focus-inset"><img src="//tiendamiaecu.com/cdn/shop/files/Copy_of_Light_Gray_Black_Floral_Wedding_Organizer_Logo_500_x_500_px_500_x_130_px_8.png?v=1684366520&amp;width=500" alt="Tiendamia Ec" srcset="//tiendamiaecu.com/cdn/shop/files/Copy_of_Light_Gray_Black_Floral_Wedding_Organizer_Logo_500_x_500_px_500_x_130_px_8.png?v=1684366520&amp;width=50 50w, //tiendamiaecu.com/cdn/shop/files/Copy_of_Light_Gray_Black_Floral_Wedding_Organizer_Logo_500_x_500_px_500_x_130_px_8.png?v=1684366520&amp;width=100 100w, //tiendamiaecu.com/cdn/shop/files/Copy_of_Light_Gray_Black_Floral_Wedding_Organizer_Logo_500_x_500_px_500_x_130_px_8.png?v=1684366520&amp;width=150 150w, //tiendamiaecu.com/cdn/shop/files/Copy_of_Light_Gray_Black_Floral_Wedding_Organizer_Logo_500_x_500_px_500_x_130_px_8.png?v=1684366520&amp;width=200 200w, //tiendamiaecu.com/cdn/shop/files/Copy_of_Light_Gray_Black_Floral_Wedding_Organizer_Logo_500_x_500_px_500_x_130_px_8.png?v=1684366520&amp;width=250 250w, //tiendamiaecu.com/cdn/shop/files/Copy_of_Light_Gray_Black_Floral_Wedding_Organizer_Logo_500_x_500_px_500_x_130_px_8.png?v=1684366520&amp;width=300 300w, //tiendamiaecu.com/cdn/shop/files/Copy_of_Light_Gray_Black_Floral_Wedding_Organizer_Logo_500_x_500_px_500_x_130_px_8.png?v=1684366520&amp;width=400 400w, //tiendamiaecu.com/cdn/shop/files/Copy_of_Light_Gray_Black_Floral_Wedding_Organizer_Logo_500_x_500_px_500_x_130_px_8.png?v=1684366520&amp;width=500 500w" width="140" height="36.4" class="header__heading-logo">
        </a>
        <div class="header__icons">
          <details-modal class="header__search">
            <details>
              <summary class="header__icon header__icon--search header__icon--summary link focus-inset modal__toggle" aria-haspopup="dialog" aria-label="Search">
                <span>
                  <svg class="modal__toggle-open icon icon-search" aria-hidden="true" focusable="false">
                    <use href="#icon-search">
                  </svg>
                  <svg class="modal__toggle-close icon icon-close" aria-hidden="true" focusable="false">
                    <use href="#icon-close">
                  </svg>
                </span>
              </summary>
              <div class="search-modal modal__content gradient" role="dialog" aria-modal="true" aria-label="Search">
                <div class="modal-overlay"></div>
                <div class="search-modal__content search-modal__content-bottom" tabindex="-1"><predictive-search class="search-modal__form" data-loading-text="Loading...">
                    <form action="/search" method="get" role="search" class="search search-modal__form search search-modal__form--polyfill" data-search-value="">
                      <div class="field">
                        <input class="search__input field__input" id="Search-In-Modal" type="search" name="q" value="" placeholder="Search" role="combobox" aria-expanded="false" aria-owns="predictive-search-results" aria-controls="predictive-search-results" aria-haspopup="listbox" aria-autocomplete="list" autocorrect="off" autocomplete="off" autocapitalize="off" spellcheck="false">
                        <label class="field__label" for="Search-In-Modal">Search</label>
                        <input type="hidden" name="options[prefix]" value="last">
                        <button type="reset" class="reset__button field__button hidden" aria-label="Clear search term">
                          <svg class="icon icon-close" aria-hidden="true" focusable="false">
                            <use xlink:href="#icon-reset">
                          </svg>
                        </button>
                        <button class="search__button field__button" aria-label="Search">
                          <svg class="icon icon-search" aria-hidden="true" focusable="false">
                            <use href="#icon-search">
                          </svg>
                        </button>
                      </div>
                      <div class="predictive-search predictive-search--header" tabindex="-1" data-predictive-search>
                        <div class="predictive-search__loading-state">
                          <svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                            <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                          </svg>
                        </div>
                      </div>

                      <span class="predictive-search-status visually-hidden" role="status" aria-hidden="true"></span>
                    </form>
                  </predictive-search><button type="button" class="search-modal__close-button modal__close-button link link--text focus-inset" aria-label="Close">
                    <svg class="icon icon-close" aria-hidden="true" focusable="false">
                      <use href="#icon-close">
                    </svg>
                  </button>
                </div>
              </div>
            </details>
          </details-modal><a href="/cart" class="header__icon header__icon--cart link focus-inset" id="cart-icon-bubble"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 53.98 45.23" class="icon icon-cart" aria-hidden="true" focusable="false" fill="none">
              <polyline stroke="currentColor" points="1.5 1.5 10.04 2.06 15.09 27.94 45.39 27.94 52.48 6.79 18.25 6.65" style="fill:none;stroke-linecap:round;stroke-linejoin:round;stroke-width:3px" />
              <circle stroke="currentColor" cx="20.58" cy="39.74" r="3.99" style="fill:none;stroke-linecap:round;stroke-linejoin:round;stroke-width:3px" />
              <circle stroke="currentColor" cx="40.02" cy="39.74" r="3.99" style="fill:none;stroke-linecap:round;stroke-linejoin:round;stroke-width:3px" />
              <polyline stroke="currentColor" points="45.42 35.75 14.49 35.75 17.21 27.94" style="fill:none;stroke-linecap:round;stroke-linejoin:round;stroke-width:3px" />
            </svg>
            <span class="visually-hidden">Cart</span>
            <div class="cart-count-bubble"><span aria-hidden="true">1</span><span class="visually-hidden">1 item</span>
            </div>
          </a>
        </div>
      </header>
    </sticky-header>
    <?php
    $index_activa = "";
    $categoria_activa = "menu_activo texto_boton";
    include 'includes/styky-header.php';
    ?>
    <script type="application/ld+json">
      {
        "@context": "http://schema.org",
        "@type": "Organization",
        "name": "Tiendamia Ec",

        "logo": "https:\/\/tiendamiaecu.com\/cdn\/shop\/files\/Copy_of_Light_Gray_Black_Floral_Wedding_Organizer_Logo_500_x_500_px_500_x_130_px_8.png?v=1684366520\u0026width=500",

        "sameAs": [
          "",
          "",
          "",
          "",
          "",
          "",
          "",
          "",
          ""
        ],
        "url": "https:\/\/tiendamiaecu.com"
      }
    </script>
  </div>
  <!-- END sections: header-group -->

  <main id="MainContent" class="content-for-layout focus-none" role="main" tabindex="-1">
    <div id="shopify-section-template--20805846040857__main-collection-banner" class="shopify-section section">
      <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-collection-hero.css?v=40426793502088958311693673627" rel="stylesheet" type="text/css" media="all" />
      <style data-shopify>
        @media screen and (max-width: 749px) {
          .collection-hero--with-image .collection-hero__inner {
            padding-bottom: calc(0px + 2rem);
          }
        }
      </style>
      <div class="collection-hero color-background-1 gradient">
        <div class="collection-hero__inner page-width">
          <div class="collection-hero__text-wrapper">
            <h1 class="collection-hero__title">
              <span class="visually-hidden">Collection: </span>Products
            </h1>
            <div class="collection-hero__description rte"></div>
          </div>
        </div>
      </div>


    </div>
    <div id="shopify-section-template--20805846040857__main-collection-product-grid" class="shopify-section section">
      <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/template-collection.css?v=145944865380958730931693673629" rel="stylesheet" type="text/css" media="all" />
      <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-loading-overlay.css?v=167310470843593579841693673627" rel="stylesheet" type="text/css" media="all" />
      <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-card.css?v=171622893807557687511693673627" rel="stylesheet" type="text/css" media="all" />
      <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-price.css?v=183165605081763449011693673627" rel="stylesheet" type="text/css" media="all" />

      <link rel="preload" href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-rte.css?v=73443491922477598101693673627" as="style" onload="this.onload=null;this.rel='stylesheet'">
      <link rel="stylesheet" href="//tiendamiaecu.com/cdn/shop/t/3/assets/quick-add.css?v=104678793703231887271693673628" media="print" onload="this.media='all'">
      <script src="//tiendamiaecu.com/cdn/shop/t/3/assets/quick-add.js?v=21087258723263848871693673628" defer="defer"></script>
      <script src="//tiendamiaecu.com/cdn/shop/t/3/assets/product-form.js?v=70749256710412210451693673628" defer="defer"></script><noscript>
        <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-rte.css?v=73443491922477598101693673627" rel="stylesheet" type="text/css" media="all" />
      </noscript>
      <style data-shopify>
        .section-template--20805846040857__main-collection-product-grid-padding {
          padding-top: 0px;
          padding-bottom: 0px;
        }

        @media screen and (min-width: 750px) {
          .section-template--20805846040857__main-collection-product-grid-padding {
            padding-top: 0px;
            padding-bottom: 0px;
          }
        }
      </style>
      <div class="section-template--20805846040857__main-collection-product-grid-padding">

        <div class="">
          <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-facets.css?v=85339117615856704561693673627" rel="stylesheet" type="text/css" media="all" />
          <script src="//tiendamiaecu.com/cdn/shop/t/3/assets/facets.js?v=5979223589038938931693673628" defer="defer"></script>
          <aside aria-labelledby="verticalTitle" class="facets-wrapper page-width" id="main-collection-filters" data-id="template--20805846040857__main-collection-product-grid">


            <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-show-more.css?v=56103980314977906391693673627" rel="stylesheet" type="text/css" media="all" />
            <div class="facets-container"><facet-filters-form class="facets small-hide">
                <form id="FacetFiltersForm" class="facets__form">

                  <div id="FacetsWrapperDesktop" class="facets__wrapper">
                    <h2 class="facets__heading caption-large text-body" id="verticalTitle" tabindex="-1">
                      Filter:
                    </h2>
                    <script src="//tiendamiaecu.com/cdn/shop/t/3/assets/show-more.js?v=90883108635033788741693673629" defer="defer"></script>


                    <details id="Details-1-template--20805846040857__main-collection-product-grid" class="disclosure-has-popup facets__disclosure js-filter" data-index="1">
                      <summary class="facets__summary caption-large focus-offset" aria-label="Availability (0 selected)">
                        <div>
                          <span>Availability
                          </span>
                          <svg aria-hidden="true" focusable="false" class="icon icon-caret" viewBox="0 0 10 6">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.354.646a.5.5 0 00-.708 0L5 4.293 1.354.646a.5.5 0 00-.708.708l4 4a.5.5 0 00.708 0l4-4a.5.5 0 000-.708z" fill="currentColor">
                          </svg>

                        </div>
                      </summary>
                      <div id="Facet-1-template--20805846040857__main-collection-product-grid" class="parent-display facets__display">
                        <div class="facets__header">
                          <span class="facets__selected no-js-hidden">0 selected</span>
                          <facet-remove>
                            <a href="/collections/all" class="facets__reset link underlined-link">
                              Reset
                            </a>
                          </facet-remove>
                        </div>
                        <fieldset class="facets-wrap parent-wrap ">
                          <legend class="visually-hidden">Availability</legend>
                          <ul class=" facets__list list-unstyled no-js-hidden" role="list">
                            <li class="list-menu__item facets__item">
                              <label for="Filter-filter.v.availability-1" class="facet-checkbox">
                                <input type="checkbox" name="filter.v.availability" value="1" id="Filter-filter.v.availability-1">

                                <svg width="1.6rem" height="1.6rem" viewBox="0 0 16 16" aria-hidden="true" focusable="false">
                                  <rect width="16" height="16" stroke="currentColor" fill="none" stroke-width="1"></rect>
                                </svg>

                                <svg aria-hidden="true" class="icon icon-checkmark" width="1.1rem" height="0.7rem" viewBox="0 0 11 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M1.5 3.5L2.83333 4.75L4.16667 6L9.5 1" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>

                                <span aria-hidden="true">In stock (42)</span>
                                <span class="visually-hidden">In stock (42 products)</span>
                              </label>
                            </li>
                            <li class="list-menu__item facets__item">
                              <label for="Filter-filter.v.availability-2" class="facet-checkbox">
                                <input type="checkbox" name="filter.v.availability" value="0" id="Filter-filter.v.availability-2">

                                <svg width="1.6rem" height="1.6rem" viewBox="0 0 16 16" aria-hidden="true" focusable="false">
                                  <rect width="16" height="16" stroke="currentColor" fill="none" stroke-width="1"></rect>
                                </svg>

                                <svg aria-hidden="true" class="icon icon-checkmark" width="1.1rem" height="0.7rem" viewBox="0 0 11 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M1.5 3.5L2.83333 4.75L4.16667 6L9.5 1" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>

                                <span aria-hidden="true">Out of stock (1)</span>
                                <span class="visually-hidden">Out of stock (1 product)</span>
                              </label>
                            </li>
                          </ul>

                          <ul class=" facets__list no-js-list list-unstyled no-js" role="list">
                            <li class="list-menu__item facets__item">
                              <label for="Filter-filter.v.availability-1-no-js" class="facet-checkbox">
                                <input type="checkbox" name="filter.v.availability" value="1" id="Filter-filter.v.availability-1-no-js">

                                <svg width="1.6rem" height="1.6rem" viewBox="0 0 16 16" aria-hidden="true" focusable="false">
                                  <rect width="16" height="16" stroke="currentColor" fill="none" stroke-width="1"></rect>
                                </svg>

                                <svg aria-hidden="true" class="icon icon-checkmark" width="1.1rem" height="0.7rem" viewBox="0 0 11 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M1.5 3.5L2.83333 4.75L4.16667 6L9.5 1" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>

                                <span aria-hidden="true">In stock (42)</span>
                                <span class="visually-hidden">In stock (42 products)</span>
                              </label>
                            </li>
                            <li class="list-menu__item facets__item">
                              <label for="Filter-filter.v.availability-2-no-js" class="facet-checkbox">
                                <input type="checkbox" name="filter.v.availability" value="0" id="Filter-filter.v.availability-2-no-js">

                                <svg width="1.6rem" height="1.6rem" viewBox="0 0 16 16" aria-hidden="true" focusable="false">
                                  <rect width="16" height="16" stroke="currentColor" fill="none" stroke-width="1"></rect>
                                </svg>

                                <svg aria-hidden="true" class="icon icon-checkmark" width="1.1rem" height="0.7rem" viewBox="0 0 11 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M1.5 3.5L2.83333 4.75L4.16667 6L9.5 1" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>

                                <span aria-hidden="true">Out of stock (1)</span>
                                <span class="visually-hidden">Out of stock (1 product)</span>
                              </label>
                            </li>
                          </ul>
                        </fieldset>
                      </div>
                    </details>



                    <details id="Details-2-template--20805846040857__main-collection-product-grid" class="disclosure-has-popup facets__disclosure js-filter" data-index="2">
                      <summary class="facets__summary caption-large focus-offset">
                        <div>
                          <span>Price</span>
                          <svg aria-hidden="true" focusable="false" class="icon icon-caret" viewBox="0 0 10 6">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.354.646a.5.5 0 00-.708 0L5 4.293 1.354.646a.5.5 0 00-.708.708l4 4a.5.5 0 00.708 0l4-4a.5.5 0 000-.708z" fill="currentColor">
                          </svg>

                        </div>
                      </summary>
                      <div id="Facet-2-template--20805846040857__main-collection-product-grid" class="facets__display">
                        <div class="facets__header"><span class="facets__selected">The highest price is $49.99</span><facet-remove>
                            <a href="/collections/all" class="facets__reset link underlined-link">
                              Reset
                            </a>
                          </facet-remove></div>
                        <price-range class="facets__price">
                          <span class="field-currency">$</span>
                          <div class="field">
                            <input class="field__input" name="filter.v.price.gte" id="Filter-Price-GTE" type="number" placeholder="0" min="0" max="49.99">
                            <label class="field__label" for="Filter-Price-GTE">From</label>
                          </div><span class="field-currency">$</span>
                          <div class="field">
                            <input class="field__input" name="filter.v.price.lte" id="Filter-Price-LTE" type="number" min="0" placeholder="49.99" max="49.99">
                            <label class="field__label" for="Filter-Price-LTE">To</label>
                          </div>
                        </price-range>
                      </div>
                    </details>

                    <noscript>
                      <button type="submit" class="facets__button-no-js button button--secondary">
                        Filter
                      </button>
                    </noscript>
                  </div>

                  <div class="active-facets active-facets-desktop">


                    <facet-remove class="active-facets__button-wrapper">
                      <a href="/collections/all" class="active-facets__button-remove underlined-link">
                        <span>Remove all</span>
                      </a>
                    </facet-remove>
                  </div>



                  <div class="facet-filters sorting caption">
                    <div class="facet-filters__field">
                      <h2 class="facet-filters__label caption-large text-body">
                        <label for="SortBy">Sort by:</label>
                      </h2>
                      <div class="select"><select name="sort_by" class="facet-filters__sort select__select caption-large" id="SortBy" aria-describedby="a11y-refresh-page-message">
                          <option value="manual">
                            Featured
                          </option>
                          <option value="best-selling">
                            Best selling
                          </option>
                          <option value="title-ascending" selected="selected">
                            Alphabetically, A-Z
                          </option>
                          <option value="title-descending">
                            Alphabetically, Z-A
                          </option>
                          <option value="price-ascending">
                            Price, low to high
                          </option>
                          <option value="price-descending">
                            Price, high to low
                          </option>
                          <option value="created-ascending">
                            Date, old to new
                          </option>
                          <option value="created-descending">
                            Date, new to old
                          </option>
                        </select>
                        <svg aria-hidden="true" focusable="false" class="icon icon-caret" viewBox="0 0 10 6">
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M9.354.646a.5.5 0 00-.708 0L5 4.293 1.354.646a.5.5 0 00-.708.708l4 4a.5.5 0 00.708 0l4-4a.5.5 0 000-.708z" fill="currentColor">
                        </svg>

                      </div>
                    </div>

                    <noscript>
                      <button type="submit" class="facets__button-no-js button button--secondary">
                        Sort
                      </button>
                    </noscript>
                  </div>
                  <div class="product-count light" role="status">
                    <h2 class="product-count__text text-body">
                      <span id="ProductCountDesktop">43 products
                      </span>
                    </h2>
                    <div class="loading-overlay__spinner">
                      <svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                        <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                      </svg>
                    </div>
                  </div>
                </form>
              </facet-filters-form>


              <menu-drawer class="mobile-facets__wrapper medium-hide large-up-hide" data-breakpoint="mobile">
                <details class="mobile-facets__disclosure disclosure-has-popup">
                  <summary class="mobile-facets__open-wrapper focus-offset">
                    <span class="mobile-facets__open">
                      <svg class="icon icon-filter" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none">
                        <path fill-rule="evenodd" d="M4.833 6.5a1.667 1.667 0 1 1 3.334 0 1.667 1.667 0 0 1-3.334 0ZM4.05 7H2.5a.5.5 0 0 1 0-1h1.55a2.5 2.5 0 0 1 4.9 0h8.55a.5.5 0 0 1 0 1H8.95a2.5 2.5 0 0 1-4.9 0Zm11.117 6.5a1.667 1.667 0 1 0-3.334 0 1.667 1.667 0 0 0 3.334 0ZM13.5 11a2.5 2.5 0 0 1 2.45 2h1.55a.5.5 0 0 1 0 1h-1.55a2.5 2.5 0 0 1-4.9 0H2.5a.5.5 0 0 1 0-1h8.55a2.5 2.5 0 0 1 2.45-2Z" fill="currentColor" />
                      </svg>

                      <span class="mobile-facets__open-label button-label medium-hide large-up-hide">Filter and sort
                      </span>
                      <span class="mobile-facets__open-label button-label small-hide">Filter
                      </span>
                    </span>
                    <span tabindex="0" class="mobile-facets__close mobile-facets__close--no-js"><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" class="icon icon-close" fill="none" viewBox="0 0 18 17">
                        <path d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z" fill="currentColor">
                      </svg>
                    </span>
                  </summary>
                  <facet-filters-form>
                    <form id="FacetFiltersFormMobile" class="mobile-facets">
                      <div class="mobile-facets__inner gradient">
                        <div class="mobile-facets__header">
                          <div class="mobile-facets__header-inner">
                            <h2 class="mobile-facets__heading medium-hide large-up-hide">Filter and sort
                            </h2>
                            <h2 class="mobile-facets__heading small-hide">Filter
                            </h2>
                            <p class="mobile-facets__count">43 products
                            </p>
                          </div>
                        </div>
                        <div class="mobile-facets__main has-submenu gradient">
                          <details id="Details-Mobile-1-template--20805846040857__main-collection-product-grid" class="mobile-facets__details js-filter" data-index="mobile-1">
                            <summary class="mobile-facets__summary focus-inset">
                              <div>
                                <span>Availability</span>
                                <span class="mobile-facets__arrow no-js-hidden"><svg viewBox="0 0 14 10" fill="none" aria-hidden="true" focusable="false" class="icon icon-arrow" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.537.808a.5.5 0 01.817-.162l4 4a.5.5 0 010 .708l-4 4a.5.5 0 11-.708-.708L11.793 5.5H1a.5.5 0 010-1h10.793L8.646 1.354a.5.5 0 01-.109-.546z" fill="currentColor">
                                  </svg>
                                </span>
                                <noscript><svg aria-hidden="true" focusable="false" class="icon icon-caret" viewBox="0 0 10 6">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9.354.646a.5.5 0 00-.708 0L5 4.293 1.354.646a.5.5 0 00-.708.708l4 4a.5.5 0 00.708 0l4-4a.5.5 0 000-.708z" fill="currentColor">
                                  </svg>
                                </noscript>
                              </div>
                            </summary>
                            <div id="FacetMobile-1-template--20805846040857__main-collection-product-grid" class="mobile-facets__submenu gradient">
                              <button class="mobile-facets__close-button link link--text focus-inset" aria-expanded="true" type="button">
                                <svg viewBox="0 0 14 10" fill="none" aria-hidden="true" focusable="false" class="icon icon-arrow" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" clip-rule="evenodd" d="M8.537.808a.5.5 0 01.817-.162l4 4a.5.5 0 010 .708l-4 4a.5.5 0 11-.708-.708L11.793 5.5H1a.5.5 0 010-1h10.793L8.646 1.354a.5.5 0 01-.109-.546z" fill="currentColor">
                                </svg>

                                Availability
                              </button>
                              <ul class="mobile-facets__list list-unstyled" role="list">
                                <li class="mobile-facets__item list-menu__item">
                                  <label for="Filter-filter.v.availability-mobile-1" class="mobile-facets__label">
                                    <input class="mobile-facets__checkbox" type="checkbox" name="filter.v.availability" value="1" id="Filter-filter.v.availability-mobile-1">

                                    <span class="mobile-facets__highlight"></span>

                                    <svg width="1.6rem" height="1.6rem" viewBox="0 0 16 16" aria-hidden="true" focusable="false">
                                      <rect width="16" height="16" stroke="currentColor" fill="none" stroke-width="1"></rect>
                                    </svg>

                                    <svg aria-hidden="true" class="icon icon-checkmark" width="1.1rem" height="0.7rem" viewBox="0 0 11 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                      <path d="M1.5 3.5L2.83333 4.75L4.16667 6L9.5 1" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>

                                    <span aria-hidden="true">In stock (42)</span>
                                    <span class="visually-hidden">In stock (42 products)</span>
                                  </label>
                                </li>
                                <li class="mobile-facets__item list-menu__item">
                                  <label for="Filter-filter.v.availability-mobile-2" class="mobile-facets__label">
                                    <input class="mobile-facets__checkbox" type="checkbox" name="filter.v.availability" value="0" id="Filter-filter.v.availability-mobile-2">

                                    <span class="mobile-facets__highlight"></span>

                                    <svg width="1.6rem" height="1.6rem" viewBox="0 0 16 16" aria-hidden="true" focusable="false">
                                      <rect width="16" height="16" stroke="currentColor" fill="none" stroke-width="1"></rect>
                                    </svg>

                                    <svg aria-hidden="true" class="icon icon-checkmark" width="1.1rem" height="0.7rem" viewBox="0 0 11 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                      <path d="M1.5 3.5L2.83333 4.75L4.16667 6L9.5 1" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>

                                    <span aria-hidden="true">Out of stock (1)</span>
                                    <span class="visually-hidden">Out of stock (1 products)</span>
                                  </label>
                                </li>
                              </ul>

                              <div class="no-js-hidden mobile-facets__footer gradient">
                                <facet-remove class="mobile-facets__clear-wrapper">
                                  <a href="/collections/all" class="mobile-facets__clear underlined-link">Clear</a>
                                </facet-remove>
                                <button type="button" class="no-js-hidden button button--primary" onclick="this.closest('.mobile-facets__wrapper').querySelector('summary').click()">
                                  Apply
                                </button>
                                <noscript><button class="button button--primary">
                                    Apply
                                  </button></noscript>
                              </div>
                            </div>
                          </details>


                          <details id="Details-Mobile-2-template--20805846040857__main-collection-product-grid" class="mobile-facets__details js-filter" data-index="mobile-2">
                            <summary class="mobile-facets__summary focus-inset">
                              <div>
                                <span>Price</span>
                                <span class="mobile-facets__arrow no-js-hidden"><svg viewBox="0 0 14 10" fill="none" aria-hidden="true" focusable="false" class="icon icon-arrow" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.537.808a.5.5 0 01.817-.162l4 4a.5.5 0 010 .708l-4 4a.5.5 0 11-.708-.708L11.793 5.5H1a.5.5 0 010-1h10.793L8.646 1.354a.5.5 0 01-.109-.546z" fill="currentColor">
                                  </svg>
                                </span>
                                <noscript><svg aria-hidden="true" focusable="false" class="icon icon-caret" viewBox="0 0 10 6">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9.354.646a.5.5 0 00-.708 0L5 4.293 1.354.646a.5.5 0 00-.708.708l4 4a.5.5 0 00.708 0l4-4a.5.5 0 000-.708z" fill="currentColor">
                                  </svg>
                                </noscript>
                              </div>
                            </summary>
                            <div id="FacetMobile-2-template--20805846040857__main-collection-product-grid" class="mobile-facets__submenu gradient">
                              <button class="mobile-facets__close-button link link--text focus-inset" aria-expanded="true" type="button">
                                <svg viewBox="0 0 14 10" fill="none" aria-hidden="true" focusable="false" class="icon icon-arrow" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" clip-rule="evenodd" d="M8.537.808a.5.5 0 01.817-.162l4 4a.5.5 0 010 .708l-4 4a.5.5 0 11-.708-.708L11.793 5.5H1a.5.5 0 010-1h10.793L8.646 1.354a.5.5 0 01-.109-.546z" fill="currentColor">
                                </svg>

                                Price
                              </button>
                              <p class="mobile-facets__info">
                                The highest price is $49.99
                              </p>

                              <price-range class="facets__price">
                                <span class="field-currency">$</span>
                                <div class="field">
                                  <input class="field__input" name="filter.v.price.gte" id="Mobile-Filter-Price-GTE" type="number" placeholder="0" min="0" inputmode="decimal" max="49.99">
                                  <label class="field__label" for="Mobile-Filter-Price-GTE">From</label>
                                </div>

                                <span class="field-currency">$</span>
                                <div class="field">
                                  <input class="field__input" name="filter.v.price.lte" id="Mobile-Filter-Price-LTE" type="number" min="0" inputmode="decimal" placeholder="49.99" max="49.99">
                                  <label class="field__label" for="Mobile-Filter-Price-LTE">To</label>
                                </div>
                              </price-range>
                              <div class="no-js-hidden mobile-facets__footer">
                                <facet-remove class="mobile-facets__clear-wrapper">
                                  <a href="/collections/all" class="mobile-facets__clear underlined-link">Clear</a>
                                </facet-remove>
                                <button type="button" class="no-js-hidden button button--primary" onclick="this.closest('.mobile-facets__wrapper').querySelector('summary').click()">
                                  Apply
                                </button>
                                <noscript><button class="button button--primary">
                                    Apply
                                  </button></noscript>
                              </div>
                            </div>
                          </details>

                          <div class="mobile-facets__details js-filter" data-index="mobile-">
                            <div class="mobile-facets__summary">
                              <div class="mobile-facets__sort">
                                <label for="SortBy-mobile">Sort by:</label>
                                <div class="select">
                                  <select name="sort_by" class="select__select" id="SortBy-mobile" aria-describedby="a11y-refresh-page-message">
                                    <option value="manual">
                                      Featured
                                    </option>
                                    <option value="best-selling">
                                      Best selling
                                    </option>
                                    <option value="title-ascending" selected="selected">
                                      Alphabetically, A-Z
                                    </option>
                                    <option value="title-descending">
                                      Alphabetically, Z-A
                                    </option>
                                    <option value="price-ascending">
                                      Price, low to high
                                    </option>
                                    <option value="price-descending">
                                      Price, high to low
                                    </option>
                                    <option value="created-ascending">
                                      Date, old to new
                                    </option>
                                    <option value="created-descending">
                                      Date, new to old
                                    </option>
                                  </select>
                                  <svg aria-hidden="true" focusable="false" class="icon icon-caret" viewBox="0 0 10 6">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9.354.646a.5.5 0 00-.708 0L5 4.293 1.354.646a.5.5 0 00-.708.708l4 4a.5.5 0 00.708 0l4-4a.5.5 0 000-.708z" fill="currentColor">
                                  </svg>

                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="mobile-facets__footer">
                            <facet-remove class="mobile-facets__clear-wrapper">
                              <a href="/collections/all" class="mobile-facets__clear underlined-link">Remove all</a>
                            </facet-remove>
                            <button type="button" class="no-js-hidden button button--primary" onclick="this.closest('.mobile-facets__wrapper').querySelector('summary').click()">
                              Apply
                            </button>
                            <noscript><button class="button button--primary">Apply</button></noscript>
                          </div>
                        </div>


                      </div>
                    </form>
                  </facet-filters-form>
                </details>
              </menu-drawer>

              <div class="active-facets active-facets-mobile medium-hide large-up-hide"><facet-remove class="active-facets__button-wrapper">
                  <a href="/collections/all" class="active-facets__button-remove underlined-link">
                    <span>Remove all</span>
                  </a>
                </facet-remove>
              </div>

              <div class="product-count light medium-hide large-up-hide" role="status">
                <h2 class="product-count__text text-body">
                  <span id="ProductCount">43 products
                  </span>
                </h2>
                <div class="loading-overlay__spinner">
                  <svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                    <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                  </svg>
                </div>
              </div>
            </div>

          </aside>
          <div class="product-grid-container" id="ProductGridContainer">
            <div class="collection page-width">
              <div class="loading-overlay gradient"></div>

              <ul id="product-grid" data-id="template--20805846040857__main-collection-product-grid" class="
                grid product-grid grid--2-col-tablet-down
                grid--4-col-desktop
              ">
                <li class="grid__item">


                  <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-rating.css?v=24573085263941240431693673627" rel="stylesheet" type="text/css" media="all" />
                  <div class="card-wrapper product-card-wrapper underline-links-hover">
                    <div class="
        card
        card--card
         card--media
         color-background-1 gradient
        
        
        
      " style="--ratio-percent: 100.0%;">
                      <div class="card__inner  ratio" style="--ratio-percent: 100.0%;">
                        <div class="card__media">
                          <div class="media media--transparent media--hover-effect">

                            <img srcset="//tiendamiaecu.com/cdn/shop/files/AquaPure.png?v=1688481689&width=165 165w,//tiendamiaecu.com/cdn/shop/files/AquaPure.png?v=1688481689 350w
                " src="//tiendamiaecu.com/cdn/shop/files/AquaPure.png?v=1688481689&width=533" sizes="(min-width: 1400px) 317px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)" alt="AQUAPURE | DISPENSADOR AUTOMÁTICO 💦✨" class="motion-reduce" width="350" height="350">

                          </div>
                        </div>
                        <div class="card__content">
                          <div class="card__information">
                            <h3 class="card__heading">
                              <a href="/products/aquapure" id="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8434850955545" class="full-unstyled-link" aria-labelledby="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8434850955545 NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8434850955545">
                                AQUAPURE | DISPENSADOR AUTOMÁTICO 💦✨
                              </a>
                            </h3>
                          </div>
                          <div class="card__badge bottom left"></div>
                        </div>
                      </div>
                      <div class="card__content">
                        <div class="card__information">
                          <h3 class="card__heading h5" id="title-template--20805846040857__main-collection-product-grid-8434850955545">
                            <a href="/products/aquapure" id="CardLink-template--20805846040857__main-collection-product-grid-8434850955545" class="full-unstyled-link" aria-labelledby="CardLink-template--20805846040857__main-collection-product-grid-8434850955545 Badge-template--20805846040857__main-collection-product-grid-8434850955545">
                              AQUAPURE | DISPENSADOR AUTOMÁTICO 💦✨
                            </a>
                          </h3>
                          <div class="card-information"><span class="caption-large light"></span>
                            <div class="
    price ">
                              <div class="price__container">
                                <div class="price__regular">
                                  <span class="visually-hidden visually-hidden--inline">Regular price</span>
                                  <span class="price-item price-item--regular">
                                    $22.99
                                  </span>
                                </div>
                                <div class="price__sale ">
                                  <span class="visually-hidden visually-hidden--inline regular-price-label">Sale price</span>
                                  <span class="price-item price-item--sale price-item--last">
                                    $22.99
                                  </span>
                                  <span class="visually-hidden visually-hidden--inline compare-price-label">Regular price</span>
                                  <span class="price__compare-price">
                                    <s class="price-item price-item--regular">

                                    </s>
                                  </span>
                                </div>
                                <small class="unit-price caption hidden">
                                  <span class="visually-hidden">Unit price</span>
                                  <span class="price-item price-item--last">
                                    <span></span>
                                    <span aria-hidden="true">/</span>
                                    <span class="visually-hidden">&nbsp;per&nbsp;</span>
                                    <span>
                                    </span>
                                  </span>
                                </small>
                              </div>
                            </div>

                          </div>
                        </div>
                        <div class="quick-add no-js-hidden"><product-form>
                            <form method="post" action="/cart/add" id="quick-add-template--20805846040857__main-collection-product-grid8434850955545" accept-charset="UTF-8" class="form" enctype="multipart/form-data" novalidate="novalidate" data-type="add-to-cart-form"><input type="hidden" name="form_type" value="product" /><input type="hidden" name="utf8" value="✓" /><input type="hidden" name="id" value="45622098493721" disabled>
                              <button id="quick-add-template--20805846040857__main-collection-product-grid8434850955545-submit" type="submit" name="add" class="quick-add__submit button button--full-width button--secondary" aria-haspopup="dialog" aria-labelledby="quick-add-template--20805846040857__main-collection-product-grid8434850955545-submit title-template--20805846040857__main-collection-product-grid-8434850955545" aria-live="polite" data-sold-out-message="true">
                                <span>Add to cart
                                </span>
                                <span class="sold-out-message hidden">
                                  Sold out
                                </span>
                                <div class="loading-overlay__spinner hidden">
                                  <svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                    <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                                  </svg>
                                </div>
                              </button>
                            </form>
                          </product-form></div>
                        <div class="card__badge bottom left"></div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="grid__item">


                  <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-rating.css?v=24573085263941240431693673627" rel="stylesheet" type="text/css" media="all" />
                  <div class="card-wrapper product-card-wrapper underline-links-hover">
                    <div class="
        card
        card--card
         card--media
         color-background-1 gradient
        
        
        
      " style="--ratio-percent: 100.0%;">
                      <div class="card__inner  ratio" style="--ratio-percent: 100.0%;">
                        <div class="card__media">
                          <div class="media media--transparent media--hover-effect">

                            <img srcset="//tiendamiaecu.com/cdn/shop/products/SoportePower_1080x1080px_1080x1080px_1_d7f37024-c770-47aa-8b5a-94dcd3222a4c.png?v=1691115268&width=165 165w,//tiendamiaecu.com/cdn/shop/products/SoportePower_1080x1080px_1080x1080px_1_d7f37024-c770-47aa-8b5a-94dcd3222a4c.png?v=1691115268&width=360 360w,//tiendamiaecu.com/cdn/shop/products/SoportePower_1080x1080px_1080x1080px_1_d7f37024-c770-47aa-8b5a-94dcd3222a4c.png?v=1691115268&width=533 533w,//tiendamiaecu.com/cdn/shop/products/SoportePower_1080x1080px_1080x1080px_1_d7f37024-c770-47aa-8b5a-94dcd3222a4c.png?v=1691115268&width=720 720w,//tiendamiaecu.com/cdn/shop/products/SoportePower_1080x1080px_1080x1080px_1_d7f37024-c770-47aa-8b5a-94dcd3222a4c.png?v=1691115268&width=940 940w,//tiendamiaecu.com/cdn/shop/products/SoportePower_1080x1080px_1080x1080px_1_d7f37024-c770-47aa-8b5a-94dcd3222a4c.png?v=1691115268&width=1066 1066w,//tiendamiaecu.com/cdn/shop/products/SoportePower_1080x1080px_1080x1080px_1_d7f37024-c770-47aa-8b5a-94dcd3222a4c.png?v=1691115268 1080w
                " src="//tiendamiaecu.com/cdn/shop/products/SoportePower_1080x1080px_1080x1080px_1_d7f37024-c770-47aa-8b5a-94dcd3222a4c.png?v=1691115268&width=533" sizes="(min-width: 1400px) 317px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)" alt="BRAZALETE - IRIS™️" class="motion-reduce" width="1080" height="1080">

                          </div>
                        </div>
                        <div class="card__content">
                          <div class="card__information">
                            <h3 class="card__heading">
                              <a href="/products/brazalete-magico-iris" id="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8525627818265" class="full-unstyled-link" aria-labelledby="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8525627818265 NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8525627818265">
                                BRAZALETE - IRIS™️
                              </a>
                            </h3>
                          </div>
                          <div class="card__badge bottom left"><span id="NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8525627818265" class="badge badge--bottom-left color-accent-2">


                              <svg aria-hidden="true" focusable="false" class="icon icon-discount color-foreground-text" viewBox="0 0 12 12">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 0h3a2 2 0 012 2v3a1 1 0 01-.3.7l-6 6a1 1 0 01-1.4 0l-4-4a1 1 0 010-1.4l6-6A1 1 0 017 0zm2 2a1 1 0 102 0 1 1 0 00-2 0z" fill="currentColor">
                              </svg>
                              <span class='nowrap'>AHORRA UN 50%</span>
                            </span></div>
                        </div>
                      </div>
                      <div class="card__content">
                        <div class="card__information">
                          <h3 class="card__heading h5" id="title-template--20805846040857__main-collection-product-grid-8525627818265">
                            <a href="/products/brazalete-magico-iris" id="CardLink-template--20805846040857__main-collection-product-grid-8525627818265" class="full-unstyled-link" aria-labelledby="CardLink-template--20805846040857__main-collection-product-grid-8525627818265 Badge-template--20805846040857__main-collection-product-grid-8525627818265">
                              BRAZALETE - IRIS™️
                            </a>
                          </h3>
                          <div class="card-information"><span class="caption-large light"></span>
                            <div class="
    price  price--on-sale ">
                              <div class="price__container">
                                <div class="price__regular">
                                  <span class="visually-hidden visually-hidden--inline">Regular price</span>
                                  <span class="price-item price-item--regular">
                                    $29.99
                                  </span>
                                </div>
                                <div class="price__sale ">
                                  <span class="visually-hidden visually-hidden--inline regular-price-label">Sale price</span>
                                  <span class="price-item price-item--sale price-item--last">
                                    $29.99
                                  </span>
                                  <span class="visually-hidden visually-hidden--inline compare-price-label">Regular price</span>
                                  <span class="price__compare-price">
                                    <s class="price-item price-item--regular">
                                      $59.99
                                    </s>
                                  </span>
                                </div>
                                <small class="unit-price caption hidden">
                                  <span class="visually-hidden">Unit price</span>
                                  <span class="price-item price-item--last">
                                    <span></span>
                                    <span aria-hidden="true">/</span>
                                    <span class="visually-hidden">&nbsp;per&nbsp;</span>
                                    <span>
                                    </span>
                                  </span>
                                </small>
                              </div>
                            </div>

                          </div>
                        </div>
                        <div class="quick-add no-js-hidden"><product-form>
                            <form method="post" action="/cart/add" id="quick-add-template--20805846040857__main-collection-product-grid8525627818265" accept-charset="UTF-8" class="form" enctype="multipart/form-data" novalidate="novalidate" data-type="add-to-cart-form"><input type="hidden" name="form_type" value="product" /><input type="hidden" name="utf8" value="✓" /><input type="hidden" name="id" value="46049766080793" disabled>
                              <button id="quick-add-template--20805846040857__main-collection-product-grid8525627818265-submit" type="submit" name="add" class="quick-add__submit button button--full-width button--secondary" aria-haspopup="dialog" aria-labelledby="quick-add-template--20805846040857__main-collection-product-grid8525627818265-submit title-template--20805846040857__main-collection-product-grid-8525627818265" aria-live="polite" data-sold-out-message="true">
                                <span>Add to cart
                                </span>
                                <span class="sold-out-message hidden">
                                  Sold out
                                </span>
                                <div class="loading-overlay__spinner hidden">
                                  <svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                    <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                                  </svg>
                                </div>
                              </button>
                            </form>
                          </product-form></div>
                        <div class="card__badge bottom left"><span id="Badge-template--20805846040857__main-collection-product-grid-8525627818265" class="badge badge--bottom-left color-accent-2">
                            50%
                          </span></div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="grid__item">


                  <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-rating.css?v=24573085263941240431693673627" rel="stylesheet" type="text/css" media="all" />
                  <div class="card-wrapper product-card-wrapper underline-links-hover">
                    <div class="
        card
        card--card
         card--media
         color-background-1 gradient
        
        
        
      " style="--ratio-percent: 100.0%;">
                      <div class="card__inner  ratio" style="--ratio-percent: 100.0%;">
                        <div class="card__media">
                          <div class="media media--transparent media--hover-effect">

                            <img srcset="//tiendamiaecu.com/cdn/shop/products/CopiadeSoportePower_1080x1080px_1080x1080px_1.png?v=1691115271&width=165 165w,//tiendamiaecu.com/cdn/shop/products/CopiadeSoportePower_1080x1080px_1080x1080px_1.png?v=1691115271&width=360 360w,//tiendamiaecu.com/cdn/shop/products/CopiadeSoportePower_1080x1080px_1080x1080px_1.png?v=1691115271&width=533 533w,//tiendamiaecu.com/cdn/shop/products/CopiadeSoportePower_1080x1080px_1080x1080px_1.png?v=1691115271&width=720 720w,//tiendamiaecu.com/cdn/shop/products/CopiadeSoportePower_1080x1080px_1080x1080px_1.png?v=1691115271&width=940 940w,//tiendamiaecu.com/cdn/shop/products/CopiadeSoportePower_1080x1080px_1080x1080px_1.png?v=1691115271&width=1066 1066w,//tiendamiaecu.com/cdn/shop/products/CopiadeSoportePower_1080x1080px_1080x1080px_1.png?v=1691115271 1080w
                " src="//tiendamiaecu.com/cdn/shop/products/CopiadeSoportePower_1080x1080px_1080x1080px_1.png?v=1691115271&width=533" sizes="(min-width: 1400px) 317px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)" alt="BRAZALETE VIBES - AURA™️" class="motion-reduce" loading="lazy" width="1080" height="1080">

                          </div>
                        </div>
                        <div class="card__content">
                          <div class="card__information">
                            <h3 class="card__heading">
                              <a href="/products/brazalete-vibes-iris%E2%84%A2%EF%B8%8F" id="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8525628014873" class="full-unstyled-link" aria-labelledby="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8525628014873 NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8525628014873">
                                BRAZALETE VIBES - AURA™️
                              </a>
                            </h3>
                          </div>
                          <div class="card__badge bottom left"></div>
                        </div>
                      </div>
                      <div class="card__content">
                        <div class="card__information">
                          <h3 class="card__heading h5" id="title-template--20805846040857__main-collection-product-grid-8525628014873">
                            <a href="/products/brazalete-vibes-iris%E2%84%A2%EF%B8%8F" id="CardLink-template--20805846040857__main-collection-product-grid-8525628014873" class="full-unstyled-link" aria-labelledby="CardLink-template--20805846040857__main-collection-product-grid-8525628014873 Badge-template--20805846040857__main-collection-product-grid-8525628014873">
                              BRAZALETE VIBES - AURA™️
                            </a>
                          </h3>
                          <div class="card-information"><span class="caption-large light"></span>
                            <div class="
    price ">
                              <div class="price__container">
                                <div class="price__regular">
                                  <span class="visually-hidden visually-hidden--inline">Regular price</span>
                                  <span class="price-item price-item--regular">
                                    $29.99
                                  </span>
                                </div>
                                <div class="price__sale ">
                                  <span class="visually-hidden visually-hidden--inline regular-price-label">Sale price</span>
                                  <span class="price-item price-item--sale price-item--last">
                                    $29.99
                                  </span>
                                  <span class="visually-hidden visually-hidden--inline compare-price-label">Regular price</span>
                                  <span class="price__compare-price">
                                    <s class="price-item price-item--regular">

                                    </s>
                                  </span>
                                </div>
                                <small class="unit-price caption hidden">
                                  <span class="visually-hidden">Unit price</span>
                                  <span class="price-item price-item--last">
                                    <span></span>
                                    <span aria-hidden="true">/</span>
                                    <span class="visually-hidden">&nbsp;per&nbsp;</span>
                                    <span>
                                    </span>
                                  </span>
                                </small>
                              </div>
                            </div>

                          </div>
                        </div>
                        <div class="quick-add no-js-hidden"><product-form>
                            <form method="post" action="/cart/add" id="quick-add-template--20805846040857__main-collection-product-grid8525628014873" accept-charset="UTF-8" class="form" enctype="multipart/form-data" novalidate="novalidate" data-type="add-to-cart-form"><input type="hidden" name="form_type" value="product" /><input type="hidden" name="utf8" value="✓" /><input type="hidden" name="id" value="46049767260441" disabled>
                              <button id="quick-add-template--20805846040857__main-collection-product-grid8525628014873-submit" type="submit" name="add" class="quick-add__submit button button--full-width button--secondary" aria-haspopup="dialog" aria-labelledby="quick-add-template--20805846040857__main-collection-product-grid8525628014873-submit title-template--20805846040857__main-collection-product-grid-8525628014873" aria-live="polite" data-sold-out-message="true">
                                <span>Add to cart
                                </span>
                                <span class="sold-out-message hidden">
                                  Sold out
                                </span>
                                <div class="loading-overlay__spinner hidden">
                                  <svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                    <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                                  </svg>
                                </div>
                              </button>
                            </form>
                          </product-form></div>
                        <div class="card__badge bottom left"></div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="grid__item">


                  <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-rating.css?v=24573085263941240431693673627" rel="stylesheet" type="text/css" media="all" />
                  <div class="card-wrapper product-card-wrapper underline-links-hover">
                    <div class="
        card
        card--card
         card--media
         color-background-1 gradient
        
        
        
      " style="--ratio-percent: 98.79759519038076%;">
                      <div class="card__inner  ratio" style="--ratio-percent: 98.79759519038076%;">
                        <div class="card__media">
                          <div class="media media--transparent media--hover-effect">

                            <img srcset="//tiendamiaecu.com/cdn/shop/files/CapturadePantalla2023-08-30ala_s_4.53.06p.m..png?v=1693432557&width=165 165w,//tiendamiaecu.com/cdn/shop/files/CapturadePantalla2023-08-30ala_s_4.53.06p.m..png?v=1693432557&width=360 360w,//tiendamiaecu.com/cdn/shop/files/CapturadePantalla2023-08-30ala_s_4.53.06p.m..png?v=1693432557 499w
                " src="//tiendamiaecu.com/cdn/shop/files/CapturadePantalla2023-08-30ala_s_4.53.06p.m..png?v=1693432557&width=533" sizes="(min-width: 1400px) 317px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)" alt="Caja Misteriosa Belleza" class="motion-reduce" loading="lazy" width="499" height="493">

                          </div>
                        </div>
                        <div class="card__content">
                          <div class="card__information">
                            <h3 class="card__heading">
                              <a href="/products/copia-de-caja-misteriosa-tecnologica" id="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8646883016985" class="full-unstyled-link" aria-labelledby="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8646883016985 NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8646883016985">
                                Caja Misteriosa Belleza
                              </a>
                            </h3>
                          </div>
                          <div class="card__badge bottom left"><span id="NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8646883016985" class="badge badge--bottom-left color-accent-2">


                              <svg aria-hidden="true" focusable="false" class="icon icon-discount color-foreground-text" viewBox="0 0 12 12">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 0h3a2 2 0 012 2v3a1 1 0 01-.3.7l-6 6a1 1 0 01-1.4 0l-4-4a1 1 0 010-1.4l6-6A1 1 0 017 0zm2 2a1 1 0 102 0 1 1 0 00-2 0z" fill="currentColor">
                              </svg>
                              <span class='nowrap'>AHORRA UN 96%</span>
                            </span></div>
                        </div>
                      </div>
                      <div class="card__content">
                        <div class="card__information">
                          <h3 class="card__heading h5" id="title-template--20805846040857__main-collection-product-grid-8646883016985">
                            <a href="/products/copia-de-caja-misteriosa-tecnologica" id="CardLink-template--20805846040857__main-collection-product-grid-8646883016985" class="full-unstyled-link" aria-labelledby="CardLink-template--20805846040857__main-collection-product-grid-8646883016985 Badge-template--20805846040857__main-collection-product-grid-8646883016985">
                              Caja Misteriosa Belleza
                            </a>
                          </h3>
                          <div class="card-information"><span class="caption-large light"></span>
                            <div class="
    price  price--on-sale ">
                              <div class="price__container">
                                <div class="price__regular">
                                  <span class="visually-hidden visually-hidden--inline">Regular price</span>
                                  <span class="price-item price-item--regular">
                                    From $39.99
                                  </span>
                                </div>
                                <div class="price__sale ">
                                  <span class="visually-hidden visually-hidden--inline regular-price-label">Sale price</span>
                                  <span class="price-item price-item--sale price-item--last">
                                    From $39.99
                                  </span>
                                  <span class="visually-hidden visually-hidden--inline compare-price-label">Regular price</span>
                                  <span class="price__compare-price">
                                    <s class="price-item price-item--regular">
                                      $1,299.00
                                    </s>
                                  </span>
                                </div>
                                <small class="unit-price caption hidden">
                                  <span class="visually-hidden">Unit price</span>
                                  <span class="price-item price-item--last">
                                    <span></span>
                                    <span aria-hidden="true">/</span>
                                    <span class="visually-hidden">&nbsp;per&nbsp;</span>
                                    <span>
                                    </span>
                                  </span>
                                </small>
                              </div>
                            </div>

                          </div>
                        </div>
                        <div class="quick-add no-js-hidden"><modal-opener data-modal="#QuickAdd-8646883016985">
                            <button id="quick-add-template--20805846040857__main-collection-product-grid8646883016985-submit" type="submit" name="add" class="quick-add__submit button button--full-width button--secondary" aria-haspopup="dialog" aria-labelledby="quick-add-template--20805846040857__main-collection-product-grid8646883016985-submit title-template--20805846040857__main-collection-product-grid-8646883016985" data-product-url="/products/copia-de-caja-misteriosa-tecnologica">
                              Choose options
                              <div class="loading-overlay__spinner hidden">
                                <svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                  <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                                </svg>
                              </div>
                            </button>
                          </modal-opener>
                          <quick-add-modal id="QuickAdd-8646883016985" class="quick-add-modal">
                            <div role="dialog" aria-label="Choose options for Caja Misteriosa Belleza" aria-modal="true" class="quick-add-modal__content global-settings-popup" tabindex="-1">
                              <button id="ModalClose-8646883016985" type="button" class="quick-add-modal__toggle" aria-label="Close">
                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" class="icon icon-close" fill="none" viewBox="0 0 18 17">
                                  <path d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z" fill="currentColor">
                                </svg>

                              </button>
                              <div id="QuickAddInfo-8646883016985" class="quick-add-modal__content-info"></div>
                            </div>
                          </quick-add-modal>
                        </div>
                        <div class="card__badge bottom left"><span id="Badge-template--20805846040857__main-collection-product-grid-8646883016985" class="badge badge--bottom-left color-accent-2">
                            96%
                          </span></div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="grid__item">


                  <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-rating.css?v=24573085263941240431693673627" rel="stylesheet" type="text/css" media="all" />
                  <div class="card-wrapper product-card-wrapper underline-links-hover">
                    <div class="
        card
        card--card
         card--media
         color-background-1 gradient
        
        
        
      " style="--ratio-percent: 100.0%;">
                      <div class="card__inner  ratio" style="--ratio-percent: 100.0%;">
                        <div class="card__media">
                          <div class="media media--transparent media--hover-effect">

                            <img srcset="//tiendamiaecu.com/cdn/shop/products/descarga-2.png?v=1693334699&width=165 165w,//tiendamiaecu.com/cdn/shop/products/descarga-2.png?v=1693334699&width=360 360w,//tiendamiaecu.com/cdn/shop/products/descarga-2.png?v=1693334699&width=533 533w,//tiendamiaecu.com/cdn/shop/products/descarga-2.png?v=1693334699&width=720 720w,//tiendamiaecu.com/cdn/shop/products/descarga-2.png?v=1693334699 720w
                " src="//tiendamiaecu.com/cdn/shop/products/descarga-2.png?v=1693334699&width=533" sizes="(min-width: 1400px) 317px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)" alt="Caja Misteriosa 🎁 | Envío GRATIS" class="motion-reduce" loading="lazy" width="720" height="720">

                            <img srcset="//tiendamiaecu.com/cdn/shop/products/main_offers.png?v=1693334699&width=165 165w,//tiendamiaecu.com/cdn/shop/products/main_offers.png?v=1693334699&width=360 360w,//tiendamiaecu.com/cdn/shop/products/main_offers.png?v=1693334699 527w
                  " src="//tiendamiaecu.com/cdn/shop/products/main_offers.png?v=1693334699&width=533" sizes="(min-width: 1400px) 317px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)" alt="" class="motion-reduce" loading="lazy" width="527" height="465">
                          </div>
                        </div>
                        <div class="card__content">
                          <div class="card__information">
                            <h3 class="card__heading">
                              <a href="/products/caja-misteriosa-tecnologica" id="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8630808838425" class="full-unstyled-link" aria-labelledby="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8630808838425 NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8630808838425">
                                Caja Misteriosa 🎁 | Envío GRATIS
                              </a>
                            </h3>
                          </div>
                          <div class="card__badge bottom left"><span id="NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8630808838425" class="badge badge--bottom-left color-accent-2">


                              <svg aria-hidden="true" focusable="false" class="icon icon-discount color-foreground-text" viewBox="0 0 12 12">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 0h3a2 2 0 012 2v3a1 1 0 01-.3.7l-6 6a1 1 0 01-1.4 0l-4-4a1 1 0 010-1.4l6-6A1 1 0 017 0zm2 2a1 1 0 102 0 1 1 0 00-2 0z" fill="currentColor">
                              </svg>
                              <span class='nowrap'>AHORRA UN 96%</span>
                            </span></div>
                        </div>
                      </div>
                      <div class="card__content">
                        <div class="card__information">
                          <h3 class="card__heading h5" id="title-template--20805846040857__main-collection-product-grid-8630808838425">
                            <a href="/products/caja-misteriosa-tecnologica" id="CardLink-template--20805846040857__main-collection-product-grid-8630808838425" class="full-unstyled-link" aria-labelledby="CardLink-template--20805846040857__main-collection-product-grid-8630808838425 Badge-template--20805846040857__main-collection-product-grid-8630808838425">
                              Caja Misteriosa 🎁 | Envío GRATIS
                            </a>
                          </h3>
                          <div class="card-information"><span class="caption-large light"></span>
                            <div class="
    price  price--on-sale  price--no-compare">
                              <div class="price__container">
                                <div class="price__regular">
                                  <span class="visually-hidden visually-hidden--inline">Regular price</span>
                                  <span class="price-item price-item--regular">
                                    $49.99
                                  </span>
                                </div>
                                <div class="price__sale ">
                                  <span class="visually-hidden visually-hidden--inline regular-price-label">Sale price</span>
                                  <span class="price-item price-item--sale price-item--last">
                                    $49.99
                                  </span>
                                </div>
                                <small class="unit-price caption hidden">
                                  <span class="visually-hidden">Unit price</span>
                                  <span class="price-item price-item--last">
                                    <span></span>
                                    <span aria-hidden="true">/</span>
                                    <span class="visually-hidden">&nbsp;per&nbsp;</span>
                                    <span>
                                    </span>
                                  </span>
                                </small>
                              </div>
                            </div>

                          </div>
                        </div>
                        <div class="quick-add no-js-hidden"><modal-opener data-modal="#QuickAdd-8630808838425">
                            <button id="quick-add-template--20805846040857__main-collection-product-grid8630808838425-submit" type="submit" name="add" class="quick-add__submit button button--full-width button--secondary" aria-haspopup="dialog" aria-labelledby="quick-add-template--20805846040857__main-collection-product-grid8630808838425-submit title-template--20805846040857__main-collection-product-grid-8630808838425" data-product-url="/products/caja-misteriosa-tecnologica">
                              Choose options
                              <div class="loading-overlay__spinner hidden">
                                <svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                  <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                                </svg>
                              </div>
                            </button>
                          </modal-opener>
                          <quick-add-modal id="QuickAdd-8630808838425" class="quick-add-modal">
                            <div role="dialog" aria-label="Choose options for Caja Misteriosa 🎁 | Envío GRATIS" aria-modal="true" class="quick-add-modal__content global-settings-popup" tabindex="-1">
                              <button id="ModalClose-8630808838425" type="button" class="quick-add-modal__toggle" aria-label="Close">
                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" class="icon icon-close" fill="none" viewBox="0 0 18 17">
                                  <path d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z" fill="currentColor">
                                </svg>

                              </button>
                              <div id="QuickAddInfo-8630808838425" class="quick-add-modal__content-info"></div>
                            </div>
                          </quick-add-modal>
                        </div>
                        <div class="card__badge bottom left"><span id="Badge-template--20805846040857__main-collection-product-grid-8630808838425" class="badge badge--bottom-left color-accent-2">
                            96%
                          </span></div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="grid__item">


                  <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-rating.css?v=24573085263941240431693673627" rel="stylesheet" type="text/css" media="all" />
                  <div class="card-wrapper product-card-wrapper underline-links-hover">
                    <div class="
        card
        card--card
         card--media
         color-background-1 gradient
        
        
        
      " style="--ratio-percent: 100.0%;">
                      <div class="card__inner  ratio" style="--ratio-percent: 100.0%;">
                        <div class="card__media">
                          <div class="media media--transparent media--hover-effect">

                            <img srcset="//tiendamiaecu.com/cdn/shop/files/SoportePower_1080x1080px_1080x1080px_6885c276-4517-4faf-a359-8db63fd98f1b.jpg?v=1691021026&width=165 165w,//tiendamiaecu.com/cdn/shop/files/SoportePower_1080x1080px_1080x1080px_6885c276-4517-4faf-a359-8db63fd98f1b.jpg?v=1691021026&width=360 360w,//tiendamiaecu.com/cdn/shop/files/SoportePower_1080x1080px_1080x1080px_6885c276-4517-4faf-a359-8db63fd98f1b.jpg?v=1691021026&width=533 533w,//tiendamiaecu.com/cdn/shop/files/SoportePower_1080x1080px_1080x1080px_6885c276-4517-4faf-a359-8db63fd98f1b.jpg?v=1691021026&width=720 720w,//tiendamiaecu.com/cdn/shop/files/SoportePower_1080x1080px_1080x1080px_6885c276-4517-4faf-a359-8db63fd98f1b.jpg?v=1691021026&width=940 940w,//tiendamiaecu.com/cdn/shop/files/SoportePower_1080x1080px_1080x1080px_6885c276-4517-4faf-a359-8db63fd98f1b.jpg?v=1691021026&width=1066 1066w,//tiendamiaecu.com/cdn/shop/files/SoportePower_1080x1080px_1080x1080px_6885c276-4517-4faf-a359-8db63fd98f1b.jpg?v=1691021026 1080w
                " src="//tiendamiaecu.com/cdn/shop/files/SoportePower_1080x1080px_1080x1080px_6885c276-4517-4faf-a359-8db63fd98f1b.jpg?v=1691021026&width=533" sizes="(min-width: 1400px) 317px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)" alt="CAMARA FOCO DE SEGURIDAD 360" class="motion-reduce" loading="lazy" width="1080" height="1080">

                          </div>
                        </div>
                        <div class="card__content">
                          <div class="card__information">
                            <h3 class="card__heading">
                              <a href="/products/camara-foco-de-seguridad-360" id="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8521575366937" class="full-unstyled-link" aria-labelledby="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8521575366937 NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8521575366937">
                                CAMARA FOCO DE SEGURIDAD 360
                              </a>
                            </h3>
                          </div>
                          <div class="card__badge bottom left"></div>
                        </div>
                      </div>
                      <div class="card__content">
                        <div class="card__information">
                          <h3 class="card__heading h5" id="title-template--20805846040857__main-collection-product-grid-8521575366937">
                            <a href="/products/camara-foco-de-seguridad-360" id="CardLink-template--20805846040857__main-collection-product-grid-8521575366937" class="full-unstyled-link" aria-labelledby="CardLink-template--20805846040857__main-collection-product-grid-8521575366937 Badge-template--20805846040857__main-collection-product-grid-8521575366937">
                              CAMARA FOCO DE SEGURIDAD 360
                            </a>
                          </h3>
                          <div class="card-information"><span class="caption-large light"></span>
                            <div class="
    price ">
                              <div class="price__container">
                                <div class="price__regular">
                                  <span class="visually-hidden visually-hidden--inline">Regular price</span>
                                  <span class="price-item price-item--regular">
                                    $39.99
                                  </span>
                                </div>
                                <div class="price__sale ">
                                  <span class="visually-hidden visually-hidden--inline regular-price-label">Sale price</span>
                                  <span class="price-item price-item--sale price-item--last">
                                    $39.99
                                  </span>
                                  <span class="visually-hidden visually-hidden--inline compare-price-label">Regular price</span>
                                  <span class="price__compare-price">
                                    <s class="price-item price-item--regular">

                                    </s>
                                  </span>
                                </div>
                                <small class="unit-price caption hidden">
                                  <span class="visually-hidden">Unit price</span>
                                  <span class="price-item price-item--last">
                                    <span></span>
                                    <span aria-hidden="true">/</span>
                                    <span class="visually-hidden">&nbsp;per&nbsp;</span>
                                    <span>
                                    </span>
                                  </span>
                                </small>
                              </div>
                            </div>

                          </div>
                        </div>
                        <div class="quick-add no-js-hidden"><product-form>
                            <form method="post" action="/cart/add" id="quick-add-template--20805846040857__main-collection-product-grid8521575366937" accept-charset="UTF-8" class="form" enctype="multipart/form-data" novalidate="novalidate" data-type="add-to-cart-form"><input type="hidden" name="form_type" value="product" /><input type="hidden" name="utf8" value="✓" /><input type="hidden" name="id" value="46026585211161" disabled>
                              <button id="quick-add-template--20805846040857__main-collection-product-grid8521575366937-submit" type="submit" name="add" class="quick-add__submit button button--full-width button--secondary" aria-haspopup="dialog" aria-labelledby="quick-add-template--20805846040857__main-collection-product-grid8521575366937-submit title-template--20805846040857__main-collection-product-grid-8521575366937" aria-live="polite" data-sold-out-message="true">
                                <span>Add to cart
                                </span>
                                <span class="sold-out-message hidden">
                                  Sold out
                                </span>
                                <div class="loading-overlay__spinner hidden">
                                  <svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                    <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                                  </svg>
                                </div>
                              </button>
                            </form>
                          </product-form></div>
                        <div class="card__badge bottom left"></div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="grid__item">


                  <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-rating.css?v=24573085263941240431693673627" rel="stylesheet" type="text/css" media="all" />
                  <div class="card-wrapper product-card-wrapper underline-links-hover">
                    <div class="
        card
        card--card
         card--media
         color-background-1 gradient
        
        
        
      " style="--ratio-percent: 100.0%;">
                      <div class="card__inner  ratio" style="--ratio-percent: 100.0%;">
                        <div class="card__media">
                          <div class="media media--transparent media--hover-effect">

                            <img srcset="//tiendamiaecu.com/cdn/shop/products/2_f04e312f-18b5-4b61-92c5-660c0b27a22b.png?v=1693677054&width=165 165w,//tiendamiaecu.com/cdn/shop/products/2_f04e312f-18b5-4b61-92c5-660c0b27a22b.png?v=1693677054&width=360 360w,//tiendamiaecu.com/cdn/shop/products/2_f04e312f-18b5-4b61-92c5-660c0b27a22b.png?v=1693677054&width=533 533w,//tiendamiaecu.com/cdn/shop/products/2_f04e312f-18b5-4b61-92c5-660c0b27a22b.png?v=1693677054&width=720 720w,//tiendamiaecu.com/cdn/shop/products/2_f04e312f-18b5-4b61-92c5-660c0b27a22b.png?v=1693677054&width=940 940w,//tiendamiaecu.com/cdn/shop/products/2_f04e312f-18b5-4b61-92c5-660c0b27a22b.png?v=1693677054 1000w
                " src="//tiendamiaecu.com/cdn/shop/products/2_f04e312f-18b5-4b61-92c5-660c0b27a22b.png?v=1693677054&width=533" sizes="(min-width: 1400px) 317px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)" alt="Camiseta" class="motion-reduce" loading="lazy" width="1000" height="1000">

                          </div>
                        </div>
                        <div class="card__content">
                          <div class="card__information">
                            <h3 class="card__heading">
                              <a href="/products/paga-al-recibir-salud-camiseta" id="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8567018357017" class="full-unstyled-link" aria-labelledby="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8567018357017 NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8567018357017">
                                Camiseta
                              </a>
                            </h3>
                          </div>
                          <div class="card__badge bottom left"><span id="NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8567018357017" class="badge badge--bottom-left color-accent-2">


                              <svg aria-hidden="true" focusable="false" class="icon icon-discount color-foreground-text" viewBox="0 0 12 12">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 0h3a2 2 0 012 2v3a1 1 0 01-.3.7l-6 6a1 1 0 01-1.4 0l-4-4a1 1 0 010-1.4l6-6A1 1 0 017 0zm2 2a1 1 0 102 0 1 1 0 00-2 0z" fill="currentColor">
                              </svg>
                              <span class='nowrap'>AHORRA UN 50%</span>
                            </span></div>
                        </div>
                      </div>
                      <div class="card__content">
                        <div class="card__information">
                          <h3 class="card__heading h5" id="title-template--20805846040857__main-collection-product-grid-8567018357017">
                            <a href="/products/paga-al-recibir-salud-camiseta" id="CardLink-template--20805846040857__main-collection-product-grid-8567018357017" class="full-unstyled-link" aria-labelledby="CardLink-template--20805846040857__main-collection-product-grid-8567018357017 Badge-template--20805846040857__main-collection-product-grid-8567018357017">
                              Camiseta
                            </a>
                          </h3>
                          <div class="card-information"><span class="caption-large light"></span>
                            <div class="
    price  price--on-sale ">
                              <div class="price__container">
                                <div class="price__regular">
                                  <span class="visually-hidden visually-hidden--inline">Regular price</span>
                                  <span class="price-item price-item--regular">
                                    $29.99
                                  </span>
                                </div>
                                <div class="price__sale ">
                                  <span class="visually-hidden visually-hidden--inline regular-price-label">Sale price</span>
                                  <span class="price-item price-item--sale price-item--last">
                                    $29.99
                                  </span>
                                  <span class="visually-hidden visually-hidden--inline compare-price-label">Regular price</span>
                                  <span class="price__compare-price">
                                    <s class="price-item price-item--regular">
                                      $59.99
                                    </s>
                                  </span>
                                </div>
                                <small class="unit-price caption hidden">
                                  <span class="visually-hidden">Unit price</span>
                                  <span class="price-item price-item--last">
                                    <span></span>
                                    <span aria-hidden="true">/</span>
                                    <span class="visually-hidden">&nbsp;per&nbsp;</span>
                                    <span>
                                    </span>
                                  </span>
                                </small>
                              </div>
                            </div>

                          </div>
                        </div>
                        <div class="quick-add no-js-hidden"><modal-opener data-modal="#QuickAdd-8567018357017">
                            <button id="quick-add-template--20805846040857__main-collection-product-grid8567018357017-submit" type="submit" name="add" class="quick-add__submit button button--full-width button--secondary" aria-haspopup="dialog" aria-labelledby="quick-add-template--20805846040857__main-collection-product-grid8567018357017-submit title-template--20805846040857__main-collection-product-grid-8567018357017" data-product-url="/products/paga-al-recibir-salud-camiseta">
                              Choose options
                              <div class="loading-overlay__spinner hidden">
                                <svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                  <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                                </svg>
                              </div>
                            </button>
                          </modal-opener>
                          <quick-add-modal id="QuickAdd-8567018357017" class="quick-add-modal">
                            <div role="dialog" aria-label="Choose options for Camiseta" aria-modal="true" class="quick-add-modal__content global-settings-popup" tabindex="-1">
                              <button id="ModalClose-8567018357017" type="button" class="quick-add-modal__toggle" aria-label="Close">
                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" class="icon icon-close" fill="none" viewBox="0 0 18 17">
                                  <path d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z" fill="currentColor">
                                </svg>

                              </button>
                              <div id="QuickAddInfo-8567018357017" class="quick-add-modal__content-info"></div>
                            </div>
                          </quick-add-modal>
                        </div>
                        <div class="card__badge bottom left"><span id="Badge-template--20805846040857__main-collection-product-grid-8567018357017" class="badge badge--bottom-left color-accent-2">
                            50%
                          </span></div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="grid__item">


                  <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-rating.css?v=24573085263941240431693673627" rel="stylesheet" type="text/css" media="all" />
                  <div class="card-wrapper product-card-wrapper underline-links-hover">
                    <div class="
        card
        card--card
         card--media
         color-background-1 gradient
        
        
        
      " style="--ratio-percent: 100.0%;">
                      <div class="card__inner  ratio" style="--ratio-percent: 100.0%;">
                        <div class="card__media">
                          <div class="media media--transparent media--hover-effect">

                            <img srcset="//tiendamiaecu.com/cdn/shop/files/SoportePower_1080x1080px_1080x1080px_02ab9c5f-7080-45b8-8a3e-bded9d9b9d7f.jpg?v=1689987904&width=165 165w,//tiendamiaecu.com/cdn/shop/files/SoportePower_1080x1080px_1080x1080px_02ab9c5f-7080-45b8-8a3e-bded9d9b9d7f.jpg?v=1689987904&width=360 360w,//tiendamiaecu.com/cdn/shop/files/SoportePower_1080x1080px_1080x1080px_02ab9c5f-7080-45b8-8a3e-bded9d9b9d7f.jpg?v=1689987904&width=533 533w,//tiendamiaecu.com/cdn/shop/files/SoportePower_1080x1080px_1080x1080px_02ab9c5f-7080-45b8-8a3e-bded9d9b9d7f.jpg?v=1689987904&width=720 720w,//tiendamiaecu.com/cdn/shop/files/SoportePower_1080x1080px_1080x1080px_02ab9c5f-7080-45b8-8a3e-bded9d9b9d7f.jpg?v=1689987904&width=940 940w,//tiendamiaecu.com/cdn/shop/files/SoportePower_1080x1080px_1080x1080px_02ab9c5f-7080-45b8-8a3e-bded9d9b9d7f.jpg?v=1689987904&width=1066 1066w,//tiendamiaecu.com/cdn/shop/files/SoportePower_1080x1080px_1080x1080px_02ab9c5f-7080-45b8-8a3e-bded9d9b9d7f.jpg?v=1689987904 1080w
                " src="//tiendamiaecu.com/cdn/shop/files/SoportePower_1080x1080px_1080x1080px_02ab9c5f-7080-45b8-8a3e-bded9d9b9d7f.jpg?v=1689987904&width=533" sizes="(min-width: 1400px) 317px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)" alt="CEPILLO PARA MASCOTAS - PETBRUSH" class="motion-reduce" loading="lazy" width="1080" height="1080">

                          </div>
                        </div>
                        <div class="card__content">
                          <div class="card__information">
                            <h3 class="card__heading">
                              <a href="/products/peine-para-mascotas-petbrush-suciedad-gato-perro" id="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8490781966617" class="full-unstyled-link" aria-labelledby="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8490781966617 NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8490781966617">
                                CEPILLO PARA MASCOTAS - PETBRUSH
                              </a>
                            </h3>
                          </div>
                          <div class="card__badge bottom left"></div>
                        </div>
                      </div>
                      <div class="card__content">
                        <div class="card__information">
                          <h3 class="card__heading h5" id="title-template--20805846040857__main-collection-product-grid-8490781966617">
                            <a href="/products/peine-para-mascotas-petbrush-suciedad-gato-perro" id="CardLink-template--20805846040857__main-collection-product-grid-8490781966617" class="full-unstyled-link" aria-labelledby="CardLink-template--20805846040857__main-collection-product-grid-8490781966617 Badge-template--20805846040857__main-collection-product-grid-8490781966617">
                              CEPILLO PARA MASCOTAS - PETBRUSH
                            </a>
                          </h3>
                          <div class="card-information"><span class="caption-large light"></span>
                            <div class="
    price ">
                              <div class="price__container">
                                <div class="price__regular">
                                  <span class="visually-hidden visually-hidden--inline">Regular price</span>
                                  <span class="price-item price-item--regular">
                                    $22.99
                                  </span>
                                </div>
                                <div class="price__sale ">
                                  <span class="visually-hidden visually-hidden--inline regular-price-label">Sale price</span>
                                  <span class="price-item price-item--sale price-item--last">
                                    $22.99
                                  </span>
                                  <span class="visually-hidden visually-hidden--inline compare-price-label">Regular price</span>
                                  <span class="price__compare-price">
                                    <s class="price-item price-item--regular">

                                    </s>
                                  </span>
                                </div>
                                <small class="unit-price caption hidden">
                                  <span class="visually-hidden">Unit price</span>
                                  <span class="price-item price-item--last">
                                    <span></span>
                                    <span aria-hidden="true">/</span>
                                    <span class="visually-hidden">&nbsp;per&nbsp;</span>
                                    <span>
                                    </span>
                                  </span>
                                </small>
                              </div>
                            </div>

                          </div>
                        </div>
                        <div class="quick-add no-js-hidden"><product-form>
                            <form method="post" action="/cart/add" id="quick-add-template--20805846040857__main-collection-product-grid8490781966617" accept-charset="UTF-8" class="form" enctype="multipart/form-data" novalidate="novalidate" data-type="add-to-cart-form"><input type="hidden" name="form_type" value="product" /><input type="hidden" name="utf8" value="✓" /><input type="hidden" name="id" value="45881650675993" disabled>
                              <button id="quick-add-template--20805846040857__main-collection-product-grid8490781966617-submit" type="submit" name="add" class="quick-add__submit button button--full-width button--secondary" aria-haspopup="dialog" aria-labelledby="quick-add-template--20805846040857__main-collection-product-grid8490781966617-submit title-template--20805846040857__main-collection-product-grid-8490781966617" aria-live="polite" data-sold-out-message="true">
                                <span>Add to cart
                                </span>
                                <span class="sold-out-message hidden">
                                  Sold out
                                </span>
                                <div class="loading-overlay__spinner hidden">
                                  <svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                    <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                                  </svg>
                                </div>
                              </button>
                            </form>
                          </product-form></div>
                        <div class="card__badge bottom left"></div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="grid__item">


                  <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-rating.css?v=24573085263941240431693673627" rel="stylesheet" type="text/css" media="all" />
                  <div class="card-wrapper product-card-wrapper underline-links-hover">
                    <div class="
        card
        card--card
         card--media
         color-background-1 gradient
        
        
        
      " style="--ratio-percent: 100.0%;">
                      <div class="card__inner  ratio" style="--ratio-percent: 100.0%;">
                        <div class="card__media">
                          <div class="media media--transparent media--hover-effect">

                            <img srcset="//tiendamiaecu.com/cdn/shop/files/SoportePower_1080x1080px_1080x1080px_2.png?v=1690913876&width=165 165w,//tiendamiaecu.com/cdn/shop/files/SoportePower_1080x1080px_1080x1080px_2.png?v=1690913876&width=360 360w,//tiendamiaecu.com/cdn/shop/files/SoportePower_1080x1080px_1080x1080px_2.png?v=1690913876&width=533 533w,//tiendamiaecu.com/cdn/shop/files/SoportePower_1080x1080px_1080x1080px_2.png?v=1690913876&width=720 720w,//tiendamiaecu.com/cdn/shop/files/SoportePower_1080x1080px_1080x1080px_2.png?v=1690913876&width=940 940w,//tiendamiaecu.com/cdn/shop/files/SoportePower_1080x1080px_1080x1080px_2.png?v=1690913876&width=1066 1066w,//tiendamiaecu.com/cdn/shop/files/SoportePower_1080x1080px_1080x1080px_2.png?v=1690913876 1080w
                " src="//tiendamiaecu.com/cdn/shop/files/SoportePower_1080x1080px_1080x1080px_2.png?v=1690913876&width=533" sizes="(min-width: 1400px) 317px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)" alt="Collar Trébol de Corazones Magnéticos" class="motion-reduce" loading="lazy" width="1080" height="1080">

                            <img srcset="//tiendamiaecu.com/cdn/shop/files/collarimantreboldecorazon2en1_9.png?v=1690913877&width=165 165w,//tiendamiaecu.com/cdn/shop/files/collarimantreboldecorazon2en1_9.png?v=1690913877&width=360 360w,//tiendamiaecu.com/cdn/shop/files/collarimantreboldecorazon2en1_9.png?v=1690913877&width=533 533w,//tiendamiaecu.com/cdn/shop/files/collarimantreboldecorazon2en1_9.png?v=1690913877&width=720 720w,//tiendamiaecu.com/cdn/shop/files/collarimantreboldecorazon2en1_9.png?v=1690913877&width=940 940w,//tiendamiaecu.com/cdn/shop/files/collarimantreboldecorazon2en1_9.png?v=1690913877 1000w
                  " src="//tiendamiaecu.com/cdn/shop/files/collarimantreboldecorazon2en1_9.png?v=1690913877&width=533" sizes="(min-width: 1400px) 317px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)" alt="" class="motion-reduce" loading="lazy" width="1000" height="1000">
                          </div>
                        </div>
                        <div class="card__content">
                          <div class="card__information">
                            <h3 class="card__heading">
                              <a href="/products/collar-trebol-de-corazones-magneticos" id="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8515528261913" class="full-unstyled-link" aria-labelledby="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8515528261913 NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8515528261913">
                                Collar Trébol de Corazones Magnéticos
                              </a>
                            </h3>
                          </div>
                          <div class="card__badge bottom left"></div>
                        </div>
                      </div>
                      <div class="card__content">
                        <div class="card__information">
                          <h3 class="card__heading h5" id="title-template--20805846040857__main-collection-product-grid-8515528261913">
                            <a href="/products/collar-trebol-de-corazones-magneticos" id="CardLink-template--20805846040857__main-collection-product-grid-8515528261913" class="full-unstyled-link" aria-labelledby="CardLink-template--20805846040857__main-collection-product-grid-8515528261913 Badge-template--20805846040857__main-collection-product-grid-8515528261913">
                              Collar Trébol de Corazones Magnéticos
                            </a>
                          </h3>
                          <div class="card-information"><span class="caption-large light"></span>
                            <div class="
    price ">
                              <div class="price__container">
                                <div class="price__regular">
                                  <span class="visually-hidden visually-hidden--inline">Regular price</span>
                                  <span class="price-item price-item--regular">
                                    $29.99
                                  </span>
                                </div>
                                <div class="price__sale ">
                                  <span class="visually-hidden visually-hidden--inline regular-price-label">Sale price</span>
                                  <span class="price-item price-item--sale price-item--last">
                                    $29.99
                                  </span>
                                  <span class="visually-hidden visually-hidden--inline compare-price-label">Regular price</span>
                                  <span class="price__compare-price">
                                    <s class="price-item price-item--regular">

                                    </s>
                                  </span>
                                </div>
                                <small class="unit-price caption hidden">
                                  <span class="visually-hidden">Unit price</span>
                                  <span class="price-item price-item--last">
                                    <span></span>
                                    <span aria-hidden="true">/</span>
                                    <span class="visually-hidden">&nbsp;per&nbsp;</span>
                                    <span>
                                    </span>
                                  </span>
                                </small>
                              </div>
                            </div>

                          </div>
                        </div>
                        <div class="quick-add no-js-hidden"><product-form>
                            <form method="post" action="/cart/add" id="quick-add-template--20805846040857__main-collection-product-grid8515528261913" accept-charset="UTF-8" class="form" enctype="multipart/form-data" novalidate="novalidate" data-type="add-to-cart-form"><input type="hidden" name="form_type" value="product" /><input type="hidden" name="utf8" value="✓" /><input type="hidden" name="id" value="46040399544601" disabled>
                              <button id="quick-add-template--20805846040857__main-collection-product-grid8515528261913-submit" type="submit" name="add" class="quick-add__submit button button--full-width button--secondary" aria-haspopup="dialog" aria-labelledby="quick-add-template--20805846040857__main-collection-product-grid8515528261913-submit title-template--20805846040857__main-collection-product-grid-8515528261913" aria-live="polite" data-sold-out-message="true">
                                <span>Add to cart
                                </span>
                                <span class="sold-out-message hidden">
                                  Sold out
                                </span>
                                <div class="loading-overlay__spinner hidden">
                                  <svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                    <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                                  </svg>
                                </div>
                              </button>
                            </form>
                          </product-form></div>
                        <div class="card__badge bottom left"></div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="grid__item">


                  <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-rating.css?v=24573085263941240431693673627" rel="stylesheet" type="text/css" media="all" />
                  <div class="card-wrapper product-card-wrapper underline-links-hover">
                    <div class="
        card
        card--card
         card--media
         color-background-1 gradient
        
        
        
      " style="--ratio-percent: 100.0%;">
                      <div class="card__inner  ratio" style="--ratio-percent: 100.0%;">
                        <div class="card__media">
                          <div class="media media--transparent media--hover-effect">

                            <img srcset="//tiendamiaecu.com/cdn/shop/files/CREMAHEALTH.jpg?v=1692139280&width=165 165w,//tiendamiaecu.com/cdn/shop/files/CREMAHEALTH.jpg?v=1692139280&width=360 360w,//tiendamiaecu.com/cdn/shop/files/CREMAHEALTH.jpg?v=1692139280&width=533 533w,//tiendamiaecu.com/cdn/shop/files/CREMAHEALTH.jpg?v=1692139280&width=720 720w,//tiendamiaecu.com/cdn/shop/files/CREMAHEALTH.jpg?v=1692139280&width=940 940w,//tiendamiaecu.com/cdn/shop/files/CREMAHEALTH.jpg?v=1692139280&width=1066 1066w,//tiendamiaecu.com/cdn/shop/files/CREMAHEALTH.jpg?v=1692139280 1080w
                " src="//tiendamiaecu.com/cdn/shop/files/CREMAHEALTH.jpg?v=1692139280&width=533" sizes="(min-width: 1400px) 317px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)" alt="CREMA HEALTH ™ | ALIVIA EL DOLOR" class="motion-reduce" loading="lazy" width="1080" height="1080">

                          </div>
                        </div>
                        <div class="card__content">
                          <div class="card__information">
                            <h3 class="card__heading">
                              <a href="/products/eterna-juventud%E2%84%A2-artitris-aliviadolor-enviogratis-dolorcuerpo" id="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8379219837209" class="full-unstyled-link" aria-labelledby="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8379219837209 NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8379219837209">
                                CREMA HEALTH ™ | ALIVIA EL DOLOR
                              </a>
                            </h3>
                          </div>
                          <div class="card__badge bottom left"><span id="NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8379219837209" class="badge badge--bottom-left color-accent-2">


                              <svg aria-hidden="true" focusable="false" class="icon icon-discount color-foreground-text" viewBox="0 0 12 12">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 0h3a2 2 0 012 2v3a1 1 0 01-.3.7l-6 6a1 1 0 01-1.4 0l-4-4a1 1 0 010-1.4l6-6A1 1 0 017 0zm2 2a1 1 0 102 0 1 1 0 00-2 0z" fill="currentColor">
                              </svg>
                              <span class='nowrap'>AHORRA UN 40%</span>
                            </span></div>
                        </div>
                      </div>
                      <div class="card__content">
                        <div class="card__information">
                          <h3 class="card__heading h5" id="title-template--20805846040857__main-collection-product-grid-8379219837209">
                            <a href="/products/eterna-juventud%E2%84%A2-artitris-aliviadolor-enviogratis-dolorcuerpo" id="CardLink-template--20805846040857__main-collection-product-grid-8379219837209" class="full-unstyled-link" aria-labelledby="CardLink-template--20805846040857__main-collection-product-grid-8379219837209 Badge-template--20805846040857__main-collection-product-grid-8379219837209">
                              CREMA HEALTH ™ | ALIVIA EL DOLOR
                            </a>
                          </h3>
                          <div class="card-information"><span class="caption-large light"></span>
                            <div class="
    price  price--on-sale ">
                              <div class="price__container">
                                <div class="price__regular">
                                  <span class="visually-hidden visually-hidden--inline">Regular price</span>
                                  <span class="price-item price-item--regular">
                                    $29.99
                                  </span>
                                </div>
                                <div class="price__sale ">
                                  <span class="visually-hidden visually-hidden--inline regular-price-label">Sale price</span>
                                  <span class="price-item price-item--sale price-item--last">
                                    $29.99
                                  </span>
                                  <span class="visually-hidden visually-hidden--inline compare-price-label">Regular price</span>
                                  <span class="price__compare-price">
                                    <s class="price-item price-item--regular">
                                      $49.99
                                    </s>
                                  </span>
                                </div>
                                <small class="unit-price caption hidden">
                                  <span class="visually-hidden">Unit price</span>
                                  <span class="price-item price-item--last">
                                    <span></span>
                                    <span aria-hidden="true">/</span>
                                    <span class="visually-hidden">&nbsp;per&nbsp;</span>
                                    <span>
                                    </span>
                                  </span>
                                </small>
                              </div>
                            </div>

                          </div>
                        </div>
                        <div class="quick-add no-js-hidden"><product-form>
                            <form method="post" action="/cart/add" id="quick-add-template--20805846040857__main-collection-product-grid8379219837209" accept-charset="UTF-8" class="form" enctype="multipart/form-data" novalidate="novalidate" data-type="add-to-cart-form"><input type="hidden" name="form_type" value="product" /><input type="hidden" name="utf8" value="✓" /><input type="hidden" name="id" value="45422119452953" disabled>
                              <button id="quick-add-template--20805846040857__main-collection-product-grid8379219837209-submit" type="submit" name="add" class="quick-add__submit button button--full-width button--secondary" aria-haspopup="dialog" aria-labelledby="quick-add-template--20805846040857__main-collection-product-grid8379219837209-submit title-template--20805846040857__main-collection-product-grid-8379219837209" aria-live="polite" data-sold-out-message="true">
                                <span>Add to cart
                                </span>
                                <span class="sold-out-message hidden">
                                  Sold out
                                </span>
                                <div class="loading-overlay__spinner hidden">
                                  <svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                    <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                                  </svg>
                                </div>
                              </button>
                            </form>
                          </product-form></div>
                        <div class="card__badge bottom left"><span id="Badge-template--20805846040857__main-collection-product-grid-8379219837209" class="badge badge--bottom-left color-accent-2">
                            40%
                          </span></div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="grid__item">


                  <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-rating.css?v=24573085263941240431693673627" rel="stylesheet" type="text/css" media="all" />
                  <div class="card-wrapper product-card-wrapper underline-links-hover">
                    <div class="
        card
        card--card
         card--media
         color-background-1 gradient
        
        
        
      " style="--ratio-percent: 100.0%;">
                      <div class="card__inner  ratio" style="--ratio-percent: 100.0%;">
                        <div class="card__media">
                          <div class="media media--transparent media--hover-effect">

                            <img srcset="//tiendamiaecu.com/cdn/shop/files/0IDQPost_5_900x900_1024x1024_2x_155791f1-7d51-42b1-83cc-3f99b295f915.jpg?v=1689875206&width=165 165w,//tiendamiaecu.com/cdn/shop/files/0IDQPost_5_900x900_1024x1024_2x_155791f1-7d51-42b1-83cc-3f99b295f915.jpg?v=1689875206&width=360 360w,//tiendamiaecu.com/cdn/shop/files/0IDQPost_5_900x900_1024x1024_2x_155791f1-7d51-42b1-83cc-3f99b295f915.jpg?v=1689875206&width=533 533w,//tiendamiaecu.com/cdn/shop/files/0IDQPost_5_900x900_1024x1024_2x_155791f1-7d51-42b1-83cc-3f99b295f915.jpg?v=1689875206&width=720 720w,//tiendamiaecu.com/cdn/shop/files/0IDQPost_5_900x900_1024x1024_2x_155791f1-7d51-42b1-83cc-3f99b295f915.jpg?v=1689875206 900w
                " src="//tiendamiaecu.com/cdn/shop/files/0IDQPost_5_900x900_1024x1024_2x_155791f1-7d51-42b1-83cc-3f99b295f915.jpg?v=1689875206&width=533" sizes="(min-width: 1400px) 317px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)" alt="Cutter™ Cortador de Chapa para Taladros" class="motion-reduce" loading="lazy" width="900" height="900">

                            <img srcset="//tiendamiaecu.com/cdn/shop/files/PThEPost_3_900x900_da45b822-b23d-4924-a10e-de31053e37e7_1024x1024_2x_1.jpg?v=1689875206&width=165 165w,//tiendamiaecu.com/cdn/shop/files/PThEPost_3_900x900_da45b822-b23d-4924-a10e-de31053e37e7_1024x1024_2x_1.jpg?v=1689875206&width=360 360w,//tiendamiaecu.com/cdn/shop/files/PThEPost_3_900x900_da45b822-b23d-4924-a10e-de31053e37e7_1024x1024_2x_1.jpg?v=1689875206&width=533 533w,//tiendamiaecu.com/cdn/shop/files/PThEPost_3_900x900_da45b822-b23d-4924-a10e-de31053e37e7_1024x1024_2x_1.jpg?v=1689875206&width=720 720w,//tiendamiaecu.com/cdn/shop/files/PThEPost_3_900x900_da45b822-b23d-4924-a10e-de31053e37e7_1024x1024_2x_1.jpg?v=1689875206 900w
                  " src="//tiendamiaecu.com/cdn/shop/files/PThEPost_3_900x900_da45b822-b23d-4924-a10e-de31053e37e7_1024x1024_2x_1.jpg?v=1689875206&width=533" sizes="(min-width: 1400px) 317px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)" alt="" class="motion-reduce" loading="lazy" width="900" height="900">
                          </div>
                        </div>
                        <div class="card__content">
                          <div class="card__information">
                            <h3 class="card__heading">
                              <a href="/products/cutter%E2%84%A2-cortador-de-chapa-para-taladros" id="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8486389940505" class="full-unstyled-link" aria-labelledby="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8486389940505 NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8486389940505">
                                Cutter™ Cortador de Chapa para Taladros
                              </a>
                            </h3>
                          </div>
                          <div class="card__badge bottom left"></div>
                        </div>
                      </div>
                      <div class="card__content">
                        <div class="card__information">
                          <h3 class="card__heading h5" id="title-template--20805846040857__main-collection-product-grid-8486389940505">
                            <a href="/products/cutter%E2%84%A2-cortador-de-chapa-para-taladros" id="CardLink-template--20805846040857__main-collection-product-grid-8486389940505" class="full-unstyled-link" aria-labelledby="CardLink-template--20805846040857__main-collection-product-grid-8486389940505 Badge-template--20805846040857__main-collection-product-grid-8486389940505">
                              Cutter™ Cortador de Chapa para Taladros
                            </a>
                          </h3>
                          <div class="card-information"><span class="caption-large light"></span>
                            <div class="
    price ">
                              <div class="price__container">
                                <div class="price__regular">
                                  <span class="visually-hidden visually-hidden--inline">Regular price</span>
                                  <span class="price-item price-item--regular">
                                    $29.99
                                  </span>
                                </div>
                                <div class="price__sale ">
                                  <span class="visually-hidden visually-hidden--inline regular-price-label">Sale price</span>
                                  <span class="price-item price-item--sale price-item--last">
                                    $29.99
                                  </span>
                                  <span class="visually-hidden visually-hidden--inline compare-price-label">Regular price</span>
                                  <span class="price__compare-price">
                                    <s class="price-item price-item--regular">

                                    </s>
                                  </span>
                                </div>
                                <small class="unit-price caption hidden">
                                  <span class="visually-hidden">Unit price</span>
                                  <span class="price-item price-item--last">
                                    <span></span>
                                    <span aria-hidden="true">/</span>
                                    <span class="visually-hidden">&nbsp;per&nbsp;</span>
                                    <span>
                                    </span>
                                  </span>
                                </small>
                              </div>
                            </div>

                          </div>
                        </div>
                        <div class="quick-add no-js-hidden"><product-form>
                            <form method="post" action="/cart/add" id="quick-add-template--20805846040857__main-collection-product-grid8486389940505" accept-charset="UTF-8" class="form" enctype="multipart/form-data" novalidate="novalidate" data-type="add-to-cart-form"><input type="hidden" name="form_type" value="product" /><input type="hidden" name="utf8" value="✓" /><input type="hidden" name="id" value="45858394931481" disabled>
                              <button id="quick-add-template--20805846040857__main-collection-product-grid8486389940505-submit" type="submit" name="add" class="quick-add__submit button button--full-width button--secondary" aria-haspopup="dialog" aria-labelledby="quick-add-template--20805846040857__main-collection-product-grid8486389940505-submit title-template--20805846040857__main-collection-product-grid-8486389940505" aria-live="polite" data-sold-out-message="true">
                                <span>Add to cart
                                </span>
                                <span class="sold-out-message hidden">
                                  Sold out
                                </span>
                                <div class="loading-overlay__spinner hidden">
                                  <svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                    <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                                  </svg>
                                </div>
                              </button>
                            </form>
                          </product-form></div>
                        <div class="card__badge bottom left"></div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="grid__item">


                  <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-rating.css?v=24573085263941240431693673627" rel="stylesheet" type="text/css" media="all" />
                  <div class="card-wrapper product-card-wrapper underline-links-hover">
                    <div class="
        card
        card--card
         card--media
         color-background-1 gradient
        
        
        
      " style="--ratio-percent: 100.0%;">
                      <div class="card__inner  ratio" style="--ratio-percent: 100.0%;">
                        <div class="card__media">
                          <div class="media media--transparent media--hover-effect">

                            <img srcset="//tiendamiaecu.com/cdn/shop/files/defense_1.jpg?v=1687898241&width=165 165w,//tiendamiaecu.com/cdn/shop/files/defense_1.jpg?v=1687898241&width=360 360w,//tiendamiaecu.com/cdn/shop/files/defense_1.jpg?v=1687898241&width=533 533w,//tiendamiaecu.com/cdn/shop/files/defense_1.jpg?v=1687898241&width=720 720w,//tiendamiaecu.com/cdn/shop/files/defense_1.jpg?v=1687898241&width=940 940w,//tiendamiaecu.com/cdn/shop/files/defense_1.jpg?v=1687898241&width=1066 1066w,//tiendamiaecu.com/cdn/shop/files/defense_1.jpg?v=1687898241 1080w
                " src="//tiendamiaecu.com/cdn/shop/files/defense_1.jpg?v=1687898241&width=533" sizes="(min-width: 1400px) 317px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)" alt="DEFENSE PET | TU MASCOTA SALUDABLE SIEMPRE🐾" class="motion-reduce" loading="lazy" width="1080" height="1080">

                          </div>
                        </div>
                        <div class="card__content">
                          <div class="card__information">
                            <h3 class="card__heading">
                              <a href="/products/defense-pet-mascota-saludable-feliz-fuerte-gatos-perros" id="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8411440677145" class="full-unstyled-link" aria-labelledby="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8411440677145 NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8411440677145">
                                DEFENSE PET | TU MASCOTA SALUDABLE SIEMPRE🐾
                              </a>
                            </h3>
                          </div>
                          <div class="card__badge bottom left"></div>
                        </div>
                      </div>
                      <div class="card__content">
                        <div class="card__information">
                          <h3 class="card__heading h5" id="title-template--20805846040857__main-collection-product-grid-8411440677145">
                            <a href="/products/defense-pet-mascota-saludable-feliz-fuerte-gatos-perros" id="CardLink-template--20805846040857__main-collection-product-grid-8411440677145" class="full-unstyled-link" aria-labelledby="CardLink-template--20805846040857__main-collection-product-grid-8411440677145 Badge-template--20805846040857__main-collection-product-grid-8411440677145">
                              DEFENSE PET | TU MASCOTA SALUDABLE SIEMPRE🐾
                            </a>
                          </h3>
                          <div class="card-information"><span class="caption-large light"></span>
                            <div class="
    price ">
                              <div class="price__container">
                                <div class="price__regular">
                                  <span class="visually-hidden visually-hidden--inline">Regular price</span>
                                  <span class="price-item price-item--regular">
                                    $29.95
                                  </span>
                                </div>
                                <div class="price__sale ">
                                  <span class="visually-hidden visually-hidden--inline regular-price-label">Sale price</span>
                                  <span class="price-item price-item--sale price-item--last">
                                    $29.95
                                  </span>
                                  <span class="visually-hidden visually-hidden--inline compare-price-label">Regular price</span>
                                  <span class="price__compare-price">
                                    <s class="price-item price-item--regular">

                                    </s>
                                  </span>
                                </div>
                                <small class="unit-price caption hidden">
                                  <span class="visually-hidden">Unit price</span>
                                  <span class="price-item price-item--last">
                                    <span></span>
                                    <span aria-hidden="true">/</span>
                                    <span class="visually-hidden">&nbsp;per&nbsp;</span>
                                    <span>
                                    </span>
                                  </span>
                                </small>
                              </div>
                            </div>

                          </div>
                        </div>
                        <div class="quick-add no-js-hidden"><product-form>
                            <form method="post" action="/cart/add" id="quick-add-template--20805846040857__main-collection-product-grid8411440677145" accept-charset="UTF-8" class="form" enctype="multipart/form-data" novalidate="novalidate" data-type="add-to-cart-form"><input type="hidden" name="form_type" value="product" /><input type="hidden" name="utf8" value="✓" /><input type="hidden" name="id" value="45543731822873" disabled>
                              <button id="quick-add-template--20805846040857__main-collection-product-grid8411440677145-submit" type="submit" name="add" class="quick-add__submit button button--full-width button--secondary" aria-haspopup="dialog" aria-labelledby="quick-add-template--20805846040857__main-collection-product-grid8411440677145-submit title-template--20805846040857__main-collection-product-grid-8411440677145" aria-live="polite" data-sold-out-message="true">
                                <span>Add to cart
                                </span>
                                <span class="sold-out-message hidden">
                                  Sold out
                                </span>
                                <div class="loading-overlay__spinner hidden">
                                  <svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                    <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                                  </svg>
                                </div>
                              </button>
                            </form>
                          </product-form></div>
                        <div class="card__badge bottom left"></div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="grid__item">


                  <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-rating.css?v=24573085263941240431693673627" rel="stylesheet" type="text/css" media="all" />
                  <div class="card-wrapper product-card-wrapper underline-links-hover">
                    <div class="
        card
        card--card
         card--media
         color-background-1 gradient
        
        
        
      " style="--ratio-percent: 100.0%;">
                      <div class="card__inner  ratio" style="--ratio-percent: 100.0%;">
                        <div class="card__media">
                          <div class="media media--transparent media--hover-effect">

                            <img srcset="//tiendamiaecu.com/cdn/shop/files/img5_3996db0e-ae13-4987-88ae-45f537844a47.png?v=1691093571&width=165 165w,//tiendamiaecu.com/cdn/shop/files/img5_3996db0e-ae13-4987-88ae-45f537844a47.png?v=1691093571&width=360 360w,//tiendamiaecu.com/cdn/shop/files/img5_3996db0e-ae13-4987-88ae-45f537844a47.png?v=1691093571&width=533 533w,//tiendamiaecu.com/cdn/shop/files/img5_3996db0e-ae13-4987-88ae-45f537844a47.png?v=1691093571&width=720 720w,//tiendamiaecu.com/cdn/shop/files/img5_3996db0e-ae13-4987-88ae-45f537844a47.png?v=1691093571&width=940 940w,//tiendamiaecu.com/cdn/shop/files/img5_3996db0e-ae13-4987-88ae-45f537844a47.png?v=1691093571&width=1066 1066w,//tiendamiaecu.com/cdn/shop/files/img5_3996db0e-ae13-4987-88ae-45f537844a47.png?v=1691093571 1080w
                " src="//tiendamiaecu.com/cdn/shop/files/img5_3996db0e-ae13-4987-88ae-45f537844a47.png?v=1691093571&width=533" sizes="(min-width: 1400px) 317px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)" alt="DERMA BEAUTY | REMOVEDOR DE PUNTOS NEGROS" class="motion-reduce" loading="lazy" width="1080" height="1080">

                            <img srcset="//tiendamiaecu.com/cdn/shop/files/img2.png?v=1691093571&width=165 165w,//tiendamiaecu.com/cdn/shop/files/img2.png?v=1691093571&width=360 360w,//tiendamiaecu.com/cdn/shop/files/img2.png?v=1691093571&width=533 533w,//tiendamiaecu.com/cdn/shop/files/img2.png?v=1691093571&width=720 720w,//tiendamiaecu.com/cdn/shop/files/img2.png?v=1691093571&width=940 940w,//tiendamiaecu.com/cdn/shop/files/img2.png?v=1691093571&width=1066 1066w,//tiendamiaecu.com/cdn/shop/files/img2.png?v=1691093571 1080w
                  " src="//tiendamiaecu.com/cdn/shop/files/img2.png?v=1691093571&width=533" sizes="(min-width: 1400px) 317px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)" alt="" class="motion-reduce" loading="lazy" width="1080" height="1080">
                          </div>
                        </div>
                        <div class="card__content">
                          <div class="card__information">
                            <h3 class="card__heading">
                              <a href="/products/derma-beauty-removedor-de-puntos-negros-acne" id="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8426676912409" class="full-unstyled-link" aria-labelledby="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8426676912409 NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8426676912409">
                                DERMA BEAUTY | REMOVEDOR DE PUNTOS NEGROS
                              </a>
                            </h3>
                          </div>
                          <div class="card__badge bottom left"><span id="NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8426676912409" class="badge badge--bottom-left color-accent-2">


                              <svg aria-hidden="true" focusable="false" class="icon icon-discount color-foreground-text" viewBox="0 0 12 12">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 0h3a2 2 0 012 2v3a1 1 0 01-.3.7l-6 6a1 1 0 01-1.4 0l-4-4a1 1 0 010-1.4l6-6A1 1 0 017 0zm2 2a1 1 0 102 0 1 1 0 00-2 0z" fill="currentColor">
                              </svg>
                              <span class='nowrap'>AHORRA UN 49%</span>
                            </span></div>
                        </div>
                      </div>
                      <div class="card__content">
                        <div class="card__information">
                          <h3 class="card__heading h5" id="title-template--20805846040857__main-collection-product-grid-8426676912409">
                            <a href="/products/derma-beauty-removedor-de-puntos-negros-acne" id="CardLink-template--20805846040857__main-collection-product-grid-8426676912409" class="full-unstyled-link" aria-labelledby="CardLink-template--20805846040857__main-collection-product-grid-8426676912409 Badge-template--20805846040857__main-collection-product-grid-8426676912409">
                              DERMA BEAUTY | REMOVEDOR DE PUNTOS NEGROS
                            </a>
                          </h3>
                          <div class="card-information"><span class="caption-large light"></span>
                            <div class="
    price  price--on-sale ">
                              <div class="price__container">
                                <div class="price__regular">
                                  <span class="visually-hidden visually-hidden--inline">Regular price</span>
                                  <span class="price-item price-item--regular">
                                    $24.99
                                  </span>
                                </div>
                                <div class="price__sale ">
                                  <span class="visually-hidden visually-hidden--inline regular-price-label">Sale price</span>
                                  <span class="price-item price-item--sale price-item--last">
                                    $24.99
                                  </span>
                                  <span class="visually-hidden visually-hidden--inline compare-price-label">Regular price</span>
                                  <span class="price__compare-price">
                                    <s class="price-item price-item--regular">
                                      $49.95
                                    </s>
                                  </span>
                                </div>
                                <small class="unit-price caption hidden">
                                  <span class="visually-hidden">Unit price</span>
                                  <span class="price-item price-item--last">
                                    <span></span>
                                    <span aria-hidden="true">/</span>
                                    <span class="visually-hidden">&nbsp;per&nbsp;</span>
                                    <span>
                                    </span>
                                  </span>
                                </small>
                              </div>
                            </div>

                          </div>
                        </div>
                        <div class="quick-add no-js-hidden"><product-form>
                            <form method="post" action="/cart/add" id="quick-add-template--20805846040857__main-collection-product-grid8426676912409" accept-charset="UTF-8" class="form" enctype="multipart/form-data" novalidate="novalidate" data-type="add-to-cart-form"><input type="hidden" name="form_type" value="product" /><input type="hidden" name="utf8" value="✓" /><input type="hidden" name="id" value="45582422671641" disabled>
                              <button id="quick-add-template--20805846040857__main-collection-product-grid8426676912409-submit" type="submit" name="add" class="quick-add__submit button button--full-width button--secondary" aria-haspopup="dialog" aria-labelledby="quick-add-template--20805846040857__main-collection-product-grid8426676912409-submit title-template--20805846040857__main-collection-product-grid-8426676912409" aria-live="polite" data-sold-out-message="true">
                                <span>Add to cart
                                </span>
                                <span class="sold-out-message hidden">
                                  Sold out
                                </span>
                                <div class="loading-overlay__spinner hidden">
                                  <svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                    <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                                  </svg>
                                </div>
                              </button>
                            </form>
                          </product-form></div>
                        <div class="card__badge bottom left"><span id="Badge-template--20805846040857__main-collection-product-grid-8426676912409" class="badge badge--bottom-left color-accent-2">
                            49%
                          </span></div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="grid__item">


                  <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-rating.css?v=24573085263941240431693673627" rel="stylesheet" type="text/css" media="all" />
                  <div class="card-wrapper product-card-wrapper underline-links-hover">
                    <div class="
        card
        card--card
         card--media
         color-background-1 gradient
        
        
        
      " style="--ratio-percent: 100.0%;">
                      <div class="card__inner  ratio" style="--ratio-percent: 100.0%;">
                        <div class="card__media">
                          <div class="media media--transparent media--hover-effect">

                            <img srcset="//tiendamiaecu.com/cdn/shop/files/ep_1.png?v=1687703866&width=165 165w,//tiendamiaecu.com/cdn/shop/files/ep_1.png?v=1687703866&width=360 360w,//tiendamiaecu.com/cdn/shop/files/ep_1.png?v=1687703866 500w
                " src="//tiendamiaecu.com/cdn/shop/files/ep_1.png?v=1687703866&width=533" sizes="(min-width: 1400px) 317px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)" alt="ENVIO PRIORITARIO" class="motion-reduce" loading="lazy" width="500" height="500">

                          </div>
                        </div>
                        <div class="card__content">
                          <div class="card__information">
                            <h3 class="card__heading">
                              <a href="/products/envio-prioritario" id="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8409365184793" class="full-unstyled-link" aria-labelledby="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8409365184793 NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8409365184793">
                                ENVIO PRIORITARIO
                              </a>
                            </h3>
                          </div>
                          <div class="card__badge bottom left"></div>
                        </div>
                      </div>
                      <div class="card__content">
                        <div class="card__information">
                          <h3 class="card__heading h5" id="title-template--20805846040857__main-collection-product-grid-8409365184793">
                            <a href="/products/envio-prioritario" id="CardLink-template--20805846040857__main-collection-product-grid-8409365184793" class="full-unstyled-link" aria-labelledby="CardLink-template--20805846040857__main-collection-product-grid-8409365184793 Badge-template--20805846040857__main-collection-product-grid-8409365184793">
                              ENVIO PRIORITARIO
                            </a>
                          </h3>
                          <div class="card-information"><span class="caption-large light"></span>
                            <div class="
    price ">
                              <div class="price__container">
                                <div class="price__regular">
                                  <span class="visually-hidden visually-hidden--inline">Regular price</span>
                                  <span class="price-item price-item--regular">
                                    $0.99
                                  </span>
                                </div>
                                <div class="price__sale ">
                                  <span class="visually-hidden visually-hidden--inline regular-price-label">Sale price</span>
                                  <span class="price-item price-item--sale price-item--last">
                                    $0.99
                                  </span>
                                  <span class="visually-hidden visually-hidden--inline compare-price-label">Regular price</span>
                                  <span class="price__compare-price">
                                    <s class="price-item price-item--regular">

                                    </s>
                                  </span>
                                </div>
                                <small class="unit-price caption hidden">
                                  <span class="visually-hidden">Unit price</span>
                                  <span class="price-item price-item--last">
                                    <span></span>
                                    <span aria-hidden="true">/</span>
                                    <span class="visually-hidden">&nbsp;per&nbsp;</span>
                                    <span>
                                    </span>
                                  </span>
                                </small>
                              </div>
                            </div>

                          </div>
                        </div>
                        <div class="quick-add no-js-hidden"><product-form>
                            <form method="post" action="/cart/add" id="quick-add-template--20805846040857__main-collection-product-grid8409365184793" accept-charset="UTF-8" class="form" enctype="multipart/form-data" novalidate="novalidate" data-type="add-to-cart-form"><input type="hidden" name="form_type" value="product" /><input type="hidden" name="utf8" value="✓" /><input type="hidden" name="id" value="45533845356825" disabled>
                              <button id="quick-add-template--20805846040857__main-collection-product-grid8409365184793-submit" type="submit" name="add" class="quick-add__submit button button--full-width button--secondary" aria-haspopup="dialog" aria-labelledby="quick-add-template--20805846040857__main-collection-product-grid8409365184793-submit title-template--20805846040857__main-collection-product-grid-8409365184793" aria-live="polite" data-sold-out-message="true">
                                <span>Add to cart
                                </span>
                                <span class="sold-out-message hidden">
                                  Sold out
                                </span>
                                <div class="loading-overlay__spinner hidden">
                                  <svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                    <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                                  </svg>
                                </div>
                              </button>
                            </form>
                          </product-form></div>
                        <div class="card__badge bottom left"></div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="grid__item">


                  <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-rating.css?v=24573085263941240431693673627" rel="stylesheet" type="text/css" media="all" />
                  <div class="card-wrapper product-card-wrapper underline-links-hover">
                    <div class="
        card
        card--card
         card--media
         color-background-1 gradient
        
        
        
      " style="--ratio-percent: 100.0%;">
                      <div class="card__inner  ratio" style="--ratio-percent: 100.0%;">
                        <div class="card__media">
                          <div class="media media--transparent media--hover-effect">

                            <img srcset="//tiendamiaecu.com/cdn/shop/products/1681504026-slider1.webp?v=1694725346&width=165 165w,//tiendamiaecu.com/cdn/shop/products/1681504026-slider1.webp?v=1694725346&width=360 360w,//tiendamiaecu.com/cdn/shop/products/1681504026-slider1.webp?v=1694725346&width=533 533w,//tiendamiaecu.com/cdn/shop/products/1681504026-slider1.webp?v=1694725346 640w
                " src="//tiendamiaecu.com/cdn/shop/products/1681504026-slider1.webp?v=1694725346&width=533" sizes="(min-width: 1400px) 317px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)" alt="FILTRO AGUA PURIFICADOR + ENVÍO GRÁTIS" class="motion-reduce" loading="lazy" width="640" height="640">

                            <img srcset="//tiendamiaecu.com/cdn/shop/products/image.png?v=1694725346&width=165 165w,//tiendamiaecu.com/cdn/shop/products/image.png?v=1694725346&width=360 360w,//tiendamiaecu.com/cdn/shop/products/image.png?v=1694725346&width=533 533w,//tiendamiaecu.com/cdn/shop/products/image.png?v=1694725346&width=720 720w,//tiendamiaecu.com/cdn/shop/products/image.png?v=1694725346&width=940 940w,//tiendamiaecu.com/cdn/shop/products/image.png?v=1694725346&width=1066 1066w,//tiendamiaecu.com/cdn/shop/products/image.png?v=1694725346 1080w
                  " src="//tiendamiaecu.com/cdn/shop/products/image.png?v=1694725346&width=533" sizes="(min-width: 1400px) 317px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)" alt="" class="motion-reduce" loading="lazy" width="1080" height="1080">
                          </div>
                        </div>
                        <div class="card__content">
                          <div class="card__information">
                            <h3 class="card__heading">
                              <a href="/products/filtro-purificador-agua-domestico-zoosen-1" id="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8681319039257" class="full-unstyled-link" aria-labelledby="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8681319039257 NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8681319039257">
                                FILTRO AGUA PURIFICADOR + ENVÍO GRÁTIS
                              </a>
                            </h3>
                          </div>
                          <div class="card__badge bottom left"><span id="NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8681319039257" class="badge badge--bottom-left color-accent-2">


                              <svg aria-hidden="true" focusable="false" class="icon icon-discount color-foreground-text" viewBox="0 0 12 12">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 0h3a2 2 0 012 2v3a1 1 0 01-.3.7l-6 6a1 1 0 01-1.4 0l-4-4a1 1 0 010-1.4l6-6A1 1 0 017 0zm2 2a1 1 0 102 0 1 1 0 00-2 0z" fill="currentColor">
                              </svg>
                              <span class='nowrap'>AHORRA UN 33%</span>
                            </span></div>
                        </div>
                      </div>
                      <div class="card__content">
                        <div class="card__information">
                          <h3 class="card__heading h5" id="title-template--20805846040857__main-collection-product-grid-8681319039257">
                            <a href="/products/filtro-purificador-agua-domestico-zoosen-1" id="CardLink-template--20805846040857__main-collection-product-grid-8681319039257" class="full-unstyled-link" aria-labelledby="CardLink-template--20805846040857__main-collection-product-grid-8681319039257 Badge-template--20805846040857__main-collection-product-grid-8681319039257">
                              FILTRO AGUA PURIFICADOR + ENVÍO GRÁTIS
                            </a>
                          </h3>
                          <div class="card-information"><span class="caption-large light"></span>
                            <div class="
    price  price--on-sale ">
                              <div class="price__container">
                                <div class="price__regular">
                                  <span class="visually-hidden visually-hidden--inline">Regular price</span>
                                  <span class="price-item price-item--regular">
                                    $39.99
                                  </span>
                                </div>
                                <div class="price__sale ">
                                  <span class="visually-hidden visually-hidden--inline regular-price-label">Sale price</span>
                                  <span class="price-item price-item--sale price-item--last">
                                    $39.99
                                  </span>
                                  <span class="visually-hidden visually-hidden--inline compare-price-label">Regular price</span>
                                  <span class="price__compare-price">
                                    <s class="price-item price-item--regular">
                                      $59.99
                                    </s>
                                  </span>
                                </div>
                                <small class="unit-price caption hidden">
                                  <span class="visually-hidden">Unit price</span>
                                  <span class="price-item price-item--last">
                                    <span></span>
                                    <span aria-hidden="true">/</span>
                                    <span class="visually-hidden">&nbsp;per&nbsp;</span>
                                    <span>
                                    </span>
                                  </span>
                                </small>
                              </div>
                            </div>

                          </div>
                        </div>
                        <div class="quick-add no-js-hidden"><product-form>
                            <form method="post" action="/cart/add" id="quick-add-template--20805846040857__main-collection-product-grid8681319039257" accept-charset="UTF-8" class="form" enctype="multipart/form-data" novalidate="novalidate" data-type="add-to-cart-form"><input type="hidden" name="form_type" value="product" /><input type="hidden" name="utf8" value="✓" /><input type="hidden" name="id" value="46775602348313" disabled>
                              <button id="quick-add-template--20805846040857__main-collection-product-grid8681319039257-submit" type="submit" name="add" class="quick-add__submit button button--full-width button--secondary" aria-haspopup="dialog" aria-labelledby="quick-add-template--20805846040857__main-collection-product-grid8681319039257-submit title-template--20805846040857__main-collection-product-grid-8681319039257" aria-live="polite" data-sold-out-message="true">
                                <span>Add to cart
                                </span>
                                <span class="sold-out-message hidden">
                                  Sold out
                                </span>
                                <div class="loading-overlay__spinner hidden">
                                  <svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                    <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                                  </svg>
                                </div>
                              </button>
                            </form>
                          </product-form></div>
                        <div class="card__badge bottom left"><span id="Badge-template--20805846040857__main-collection-product-grid-8681319039257" class="badge badge--bottom-left color-accent-2">
                            33%
                          </span></div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="grid__item">


                  <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-rating.css?v=24573085263941240431693673627" rel="stylesheet" type="text/css" media="all" />
                  <div class="card-wrapper product-card-wrapper underline-links-hover">
                    <div class="
        card
        card--card
         card--media
         color-background-1 gradient
        
        
        
      " style="--ratio-percent: 100.0%;">
                      <div class="card__inner  ratio" style="--ratio-percent: 100.0%;">
                        <div class="card__media">
                          <div class="media media--transparent media--hover-effect">

                            <img srcset="//tiendamiaecu.com/cdn/shop/files/FLEX_GROW_15.png?v=1688672210&width=165 165w,//tiendamiaecu.com/cdn/shop/files/FLEX_GROW_15.png?v=1688672210 350w
                " src="//tiendamiaecu.com/cdn/shop/files/FLEX_GROW_15.png?v=1688672210&width=533" sizes="(min-width: 1400px) 317px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)" alt="FLEX&amp;GROW | BANDAS ELÁSTICAS PARA EJERCICIO💪" class="motion-reduce" loading="lazy" width="350" height="350">

                          </div>
                        </div>
                        <div class="card__content">
                          <div class="card__information">
                            <h3 class="card__heading">
                              <a href="/products/flex-grow-bandas-elasticas-para-ejercicio" id="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8440690475289" class="full-unstyled-link" aria-labelledby="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8440690475289 NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8440690475289">
                                FLEX&amp;GROW | BANDAS ELÁSTICAS PARA EJERCICIO💪
                              </a>
                            </h3>
                          </div>
                          <div class="card__badge bottom left"></div>
                        </div>
                      </div>
                      <div class="card__content">
                        <div class="card__information">
                          <h3 class="card__heading h5" id="title-template--20805846040857__main-collection-product-grid-8440690475289">
                            <a href="/products/flex-grow-bandas-elasticas-para-ejercicio" id="CardLink-template--20805846040857__main-collection-product-grid-8440690475289" class="full-unstyled-link" aria-labelledby="CardLink-template--20805846040857__main-collection-product-grid-8440690475289 Badge-template--20805846040857__main-collection-product-grid-8440690475289">
                              FLEX&amp;GROW | BANDAS ELÁSTICAS PARA EJERCICIO💪
                            </a>
                          </h3>
                          <div class="card-information"><span class="caption-large light"></span>
                            <div class="
    price ">
                              <div class="price__container">
                                <div class="price__regular">
                                  <span class="visually-hidden visually-hidden--inline">Regular price</span>
                                  <span class="price-item price-item--regular">
                                    $22.99
                                  </span>
                                </div>
                                <div class="price__sale ">
                                  <span class="visually-hidden visually-hidden--inline regular-price-label">Sale price</span>
                                  <span class="price-item price-item--sale price-item--last">
                                    $22.99
                                  </span>
                                  <span class="visually-hidden visually-hidden--inline compare-price-label">Regular price</span>
                                  <span class="price__compare-price">
                                    <s class="price-item price-item--regular">

                                    </s>
                                  </span>
                                </div>
                                <small class="unit-price caption hidden">
                                  <span class="visually-hidden">Unit price</span>
                                  <span class="price-item price-item--last">
                                    <span></span>
                                    <span aria-hidden="true">/</span>
                                    <span class="visually-hidden">&nbsp;per&nbsp;</span>
                                    <span>
                                    </span>
                                  </span>
                                </small>
                              </div>
                            </div>

                          </div>
                        </div>
                        <div class="quick-add no-js-hidden"><product-form>
                            <form method="post" action="/cart/add" id="quick-add-template--20805846040857__main-collection-product-grid8440690475289" accept-charset="UTF-8" class="form" enctype="multipart/form-data" novalidate="novalidate" data-type="add-to-cart-form"><input type="hidden" name="form_type" value="product" /><input type="hidden" name="utf8" value="✓" /><input type="hidden" name="id" value="45642624008473" disabled>
                              <button id="quick-add-template--20805846040857__main-collection-product-grid8440690475289-submit" type="submit" name="add" class="quick-add__submit button button--full-width button--secondary" aria-haspopup="dialog" aria-labelledby="quick-add-template--20805846040857__main-collection-product-grid8440690475289-submit title-template--20805846040857__main-collection-product-grid-8440690475289" aria-live="polite" data-sold-out-message="true">
                                <span>Add to cart
                                </span>
                                <span class="sold-out-message hidden">
                                  Sold out
                                </span>
                                <div class="loading-overlay__spinner hidden">
                                  <svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                    <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                                  </svg>
                                </div>
                              </button>
                            </form>
                          </product-form></div>
                        <div class="card__badge bottom left"></div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="grid__item">


                  <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-rating.css?v=24573085263941240431693673627" rel="stylesheet" type="text/css" media="all" />
                  <div class="card-wrapper product-card-wrapper underline-links-hover">
                    <div class="
        card
        card--card
         card--media
         color-background-1 gradient
        
        
        
      " style="--ratio-percent: 100.0%;">
                      <div class="card__inner  ratio" style="--ratio-percent: 100.0%;">
                        <div class="card__media">
                          <div class="media media--transparent media--hover-effect">

                            <img srcset="//tiendamiaecu.com/cdn/shop/files/foco_p.jpg?v=1691082950&width=165 165w,//tiendamiaecu.com/cdn/shop/files/foco_p.jpg?v=1691082950&width=360 360w,//tiendamiaecu.com/cdn/shop/files/foco_p.jpg?v=1691082950&width=533 533w,//tiendamiaecu.com/cdn/shop/files/foco_p.jpg?v=1691082950&width=720 720w,//tiendamiaecu.com/cdn/shop/files/foco_p.jpg?v=1691082950&width=940 940w,//tiendamiaecu.com/cdn/shop/files/foco_p.jpg?v=1691082950&width=1066 1066w,//tiendamiaecu.com/cdn/shop/files/foco_p.jpg?v=1691082950 1080w
                " src="//tiendamiaecu.com/cdn/shop/files/foco_p.jpg?v=1691082950&width=533" sizes="(min-width: 1400px) 317px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)" alt="FOCO PARLANTE BLUETOOTH - LIGHT" class="motion-reduce" loading="lazy" width="1080" height="1080">

                          </div>
                        </div>
                        <div class="card__content">
                          <div class="card__information">
                            <h3 class="card__heading">
                              <a href="/products/foco-parlante-light" id="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8502174548249" class="full-unstyled-link" aria-labelledby="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8502174548249 NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8502174548249">
                                FOCO PARLANTE BLUETOOTH - LIGHT
                              </a>
                            </h3>
                          </div>
                          <div class="card__badge bottom left"><span id="NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8502174548249" class="badge badge--bottom-left color-accent-2">


                              <svg aria-hidden="true" focusable="false" class="icon icon-discount color-foreground-text" viewBox="0 0 12 12">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 0h3a2 2 0 012 2v3a1 1 0 01-.3.7l-6 6a1 1 0 01-1.4 0l-4-4a1 1 0 010-1.4l6-6A1 1 0 017 0zm2 2a1 1 0 102 0 1 1 0 00-2 0z" fill="currentColor">
                              </svg>
                              <span class='nowrap'>AHORRA UN 44%</span>
                            </span></div>
                        </div>
                      </div>
                      <div class="card__content">
                        <div class="card__information">
                          <h3 class="card__heading h5" id="title-template--20805846040857__main-collection-product-grid-8502174548249">
                            <a href="/products/foco-parlante-light" id="CardLink-template--20805846040857__main-collection-product-grid-8502174548249" class="full-unstyled-link" aria-labelledby="CardLink-template--20805846040857__main-collection-product-grid-8502174548249 Badge-template--20805846040857__main-collection-product-grid-8502174548249">
                              FOCO PARLANTE BLUETOOTH - LIGHT
                            </a>
                          </h3>
                          <div class="card-information"><span class="caption-large light"></span>
                            <div class="
    price  price--on-sale ">
                              <div class="price__container">
                                <div class="price__regular">
                                  <span class="visually-hidden visually-hidden--inline">Regular price</span>
                                  <span class="price-item price-item--regular">
                                    $24.99
                                  </span>
                                </div>
                                <div class="price__sale ">
                                  <span class="visually-hidden visually-hidden--inline regular-price-label">Sale price</span>
                                  <span class="price-item price-item--sale price-item--last">
                                    $24.99
                                  </span>
                                  <span class="visually-hidden visually-hidden--inline compare-price-label">Regular price</span>
                                  <span class="price__compare-price">
                                    <s class="price-item price-item--regular">
                                      $44.99
                                    </s>
                                  </span>
                                </div>
                                <small class="unit-price caption hidden">
                                  <span class="visually-hidden">Unit price</span>
                                  <span class="price-item price-item--last">
                                    <span></span>
                                    <span aria-hidden="true">/</span>
                                    <span class="visually-hidden">&nbsp;per&nbsp;</span>
                                    <span>
                                    </span>
                                  </span>
                                </small>
                              </div>
                            </div>

                          </div>
                        </div>
                        <div class="quick-add no-js-hidden"><product-form>
                            <form method="post" action="/cart/add" id="quick-add-template--20805846040857__main-collection-product-grid8502174548249" accept-charset="UTF-8" class="form" enctype="multipart/form-data" novalidate="novalidate" data-type="add-to-cart-form"><input type="hidden" name="form_type" value="product" /><input type="hidden" name="utf8" value="✓" /><input type="hidden" name="id" value="45926954565913" disabled>
                              <button id="quick-add-template--20805846040857__main-collection-product-grid8502174548249-submit" type="submit" name="add" class="quick-add__submit button button--full-width button--secondary" aria-haspopup="dialog" aria-labelledby="quick-add-template--20805846040857__main-collection-product-grid8502174548249-submit title-template--20805846040857__main-collection-product-grid-8502174548249" aria-live="polite" data-sold-out-message="true">
                                <span>Add to cart
                                </span>
                                <span class="sold-out-message hidden">
                                  Sold out
                                </span>
                                <div class="loading-overlay__spinner hidden">
                                  <svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                    <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                                  </svg>
                                </div>
                              </button>
                            </form>
                          </product-form></div>
                        <div class="card__badge bottom left"><span id="Badge-template--20805846040857__main-collection-product-grid-8502174548249" class="badge badge--bottom-left color-accent-2">
                            44%
                          </span></div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="grid__item">


                  <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-rating.css?v=24573085263941240431693673627" rel="stylesheet" type="text/css" media="all" />
                  <div class="card-wrapper product-card-wrapper underline-links-hover">
                    <div class="
        card
        card--card
         card--media
         color-background-1 gradient
        
        
        
      " style="--ratio-percent: 100.0%;">
                      <div class="card__inner  ratio" style="--ratio-percent: 100.0%;">
                        <div class="card__media">
                          <div class="media media--transparent media--hover-effect">

                            <img srcset="//tiendamiaecu.com/cdn/shop/files/JABONVITABLANCA.png?v=1691621792&width=165 165w,//tiendamiaecu.com/cdn/shop/files/JABONVITABLANCA.png?v=1691621792&width=360 360w,//tiendamiaecu.com/cdn/shop/files/JABONVITABLANCA.png?v=1691621792&width=533 533w,//tiendamiaecu.com/cdn/shop/files/JABONVITABLANCA.png?v=1691621792&width=720 720w,//tiendamiaecu.com/cdn/shop/files/JABONVITABLANCA.png?v=1691621792&width=940 940w,//tiendamiaecu.com/cdn/shop/files/JABONVITABLANCA.png?v=1691621792&width=1066 1066w,//tiendamiaecu.com/cdn/shop/files/JABONVITABLANCA.png?v=1691621792 1080w
                " src="//tiendamiaecu.com/cdn/shop/files/JABONVITABLANCA.png?v=1691621792&width=533" sizes="(min-width: 1400px) 317px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)" alt="JABÓN VITABLANCA™️ 🧼 | ACLARA EL TONO." class="motion-reduce" loading="lazy" width="1080" height="1080">

                          </div>
                        </div>
                        <div class="card__content">
                          <div class="card__information">
                            <h3 class="card__heading">
                              <a href="/products/jabon-blanquead0r" id="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8548551229721" class="full-unstyled-link" aria-labelledby="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8548551229721 NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8548551229721">
                                JABÓN VITABLANCA™️ 🧼 | ACLARA EL TONO.
                              </a>
                            </h3>
                          </div>
                          <div class="card__badge bottom left"></div>
                        </div>
                      </div>
                      <div class="card__content">
                        <div class="card__information">
                          <h3 class="card__heading h5" id="title-template--20805846040857__main-collection-product-grid-8548551229721">
                            <a href="/products/jabon-blanquead0r" id="CardLink-template--20805846040857__main-collection-product-grid-8548551229721" class="full-unstyled-link" aria-labelledby="CardLink-template--20805846040857__main-collection-product-grid-8548551229721 Badge-template--20805846040857__main-collection-product-grid-8548551229721">
                              JABÓN VITABLANCA™️ 🧼 | ACLARA EL TONO.
                            </a>
                          </h3>
                          <div class="card-information"><span class="caption-large light"></span>
                            <div class="
    price ">
                              <div class="price__container">
                                <div class="price__regular">
                                  <span class="visually-hidden visually-hidden--inline">Regular price</span>
                                  <span class="price-item price-item--regular">
                                    $24.99
                                  </span>
                                </div>
                                <div class="price__sale ">
                                  <span class="visually-hidden visually-hidden--inline regular-price-label">Sale price</span>
                                  <span class="price-item price-item--sale price-item--last">
                                    $24.99
                                  </span>
                                  <span class="visually-hidden visually-hidden--inline compare-price-label">Regular price</span>
                                  <span class="price__compare-price">
                                    <s class="price-item price-item--regular">

                                    </s>
                                  </span>
                                </div>
                                <small class="unit-price caption hidden">
                                  <span class="visually-hidden">Unit price</span>
                                  <span class="price-item price-item--last">
                                    <span></span>
                                    <span aria-hidden="true">/</span>
                                    <span class="visually-hidden">&nbsp;per&nbsp;</span>
                                    <span>
                                    </span>
                                  </span>
                                </small>
                              </div>
                            </div>

                          </div>
                        </div>
                        <div class="quick-add no-js-hidden"><product-form>
                            <form method="post" action="/cart/add" id="quick-add-template--20805846040857__main-collection-product-grid8548551229721" accept-charset="UTF-8" class="form" enctype="multipart/form-data" novalidate="novalidate" data-type="add-to-cart-form"><input type="hidden" name="form_type" value="product" /><input type="hidden" name="utf8" value="✓" /><input type="hidden" name="id" value="46173828874521" disabled>
                              <button id="quick-add-template--20805846040857__main-collection-product-grid8548551229721-submit" type="submit" name="add" class="quick-add__submit button button--full-width button--secondary" aria-haspopup="dialog" aria-labelledby="quick-add-template--20805846040857__main-collection-product-grid8548551229721-submit title-template--20805846040857__main-collection-product-grid-8548551229721" aria-live="polite" data-sold-out-message="true">
                                <span>Add to cart
                                </span>
                                <span class="sold-out-message hidden">
                                  Sold out
                                </span>
                                <div class="loading-overlay__spinner hidden">
                                  <svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                    <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                                  </svg>
                                </div>
                              </button>
                            </form>
                          </product-form></div>
                        <div class="card__badge bottom left"></div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="grid__item">


                  <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-rating.css?v=24573085263941240431693673627" rel="stylesheet" type="text/css" media="all" />
                  <div class="card-wrapper product-card-wrapper underline-links-hover">
                    <div class="
        card
        card--card
         card--media
         color-background-1 gradient
        
        
        
      " style="--ratio-percent: 100.0%;">
                      <div class="card__inner  ratio" style="--ratio-percent: 100.0%;">
                        <div class="card__media">
                          <div class="media media--transparent media--hover-effect">

                            <img srcset="//tiendamiaecu.com/cdn/shop/files/BARBA.jpg?v=1691177915&width=165 165w,//tiendamiaecu.com/cdn/shop/files/BARBA.jpg?v=1691177915&width=360 360w,//tiendamiaecu.com/cdn/shop/files/BARBA.jpg?v=1691177915&width=533 533w,//tiendamiaecu.com/cdn/shop/files/BARBA.jpg?v=1691177915&width=720 720w,//tiendamiaecu.com/cdn/shop/files/BARBA.jpg?v=1691177915&width=940 940w,//tiendamiaecu.com/cdn/shop/files/BARBA.jpg?v=1691177915&width=1066 1066w,//tiendamiaecu.com/cdn/shop/files/BARBA.jpg?v=1691177915 1080w
                " src="//tiendamiaecu.com/cdn/shop/files/BARBA.jpg?v=1691177915&width=533" sizes="(min-width: 1400px) 317px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)" alt="KIT CAPILAR - BARBA LUX™️" class="motion-reduce" loading="lazy" width="1080" height="1080">

                            <img srcset="//tiendamiaecu.com/cdn/shop/files/CopiadeAnadirunpocodetexto3_480x480_ef03c086-ea4b-4c06-a267-48789b23d096.webp?v=1691177915&width=165 165w,//tiendamiaecu.com/cdn/shop/files/CopiadeAnadirunpocodetexto3_480x480_ef03c086-ea4b-4c06-a267-48789b23d096.webp?v=1691177915&width=360 360w,//tiendamiaecu.com/cdn/shop/files/CopiadeAnadirunpocodetexto3_480x480_ef03c086-ea4b-4c06-a267-48789b23d096.webp?v=1691177915 480w
                  " src="//tiendamiaecu.com/cdn/shop/files/CopiadeAnadirunpocodetexto3_480x480_ef03c086-ea4b-4c06-a267-48789b23d096.webp?v=1691177915&width=533" sizes="(min-width: 1400px) 317px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)" alt="" class="motion-reduce" loading="lazy" width="480" height="480">
                          </div>
                        </div>
                        <div class="card__content">
                          <div class="card__information">
                            <h3 class="card__heading">
                              <a href="/products/kit-capilar-barba-lux-crecimiento-barba" id="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8392528101657" class="full-unstyled-link" aria-labelledby="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8392528101657 NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8392528101657">
                                KIT CAPILAR - BARBA LUX™️
                              </a>
                            </h3>
                          </div>
                          <div class="card__badge bottom left"><span id="NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8392528101657" class="badge badge--bottom-left color-accent-2">


                              <svg aria-hidden="true" focusable="false" class="icon icon-discount color-foreground-text" viewBox="0 0 12 12">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7 0h3a2 2 0 012 2v3a1 1 0 01-.3.7l-6 6a1 1 0 01-1.4 0l-4-4a1 1 0 010-1.4l6-6A1 1 0 017 0zm2 2a1 1 0 102 0 1 1 0 00-2 0z" fill="currentColor">
                              </svg>
                              <span class='nowrap'>AHORRA UN 40%</span>
                            </span></div>
                        </div>
                      </div>
                      <div class="card__content">
                        <div class="card__information">
                          <h3 class="card__heading h5" id="title-template--20805846040857__main-collection-product-grid-8392528101657">
                            <a href="/products/kit-capilar-barba-lux-crecimiento-barba" id="CardLink-template--20805846040857__main-collection-product-grid-8392528101657" class="full-unstyled-link" aria-labelledby="CardLink-template--20805846040857__main-collection-product-grid-8392528101657 Badge-template--20805846040857__main-collection-product-grid-8392528101657">
                              KIT CAPILAR - BARBA LUX™️
                            </a>
                          </h3>
                          <div class="card-information"><span class="caption-large light"></span>
                            <div class="
    price  price--on-sale ">
                              <div class="price__container">
                                <div class="price__regular">
                                  <span class="visually-hidden visually-hidden--inline">Regular price</span>
                                  <span class="price-item price-item--regular">
                                    $29.99
                                  </span>
                                </div>
                                <div class="price__sale ">
                                  <span class="visually-hidden visually-hidden--inline regular-price-label">Sale price</span>
                                  <span class="price-item price-item--sale price-item--last">
                                    $29.99
                                  </span>
                                  <span class="visually-hidden visually-hidden--inline compare-price-label">Regular price</span>
                                  <span class="price__compare-price">
                                    <s class="price-item price-item--regular">
                                      $49.99
                                    </s>
                                  </span>
                                </div>
                                <small class="unit-price caption hidden">
                                  <span class="visually-hidden">Unit price</span>
                                  <span class="price-item price-item--last">
                                    <span></span>
                                    <span aria-hidden="true">/</span>
                                    <span class="visually-hidden">&nbsp;per&nbsp;</span>
                                    <span>
                                    </span>
                                  </span>
                                </small>
                              </div>
                            </div>

                          </div>
                        </div>
                        <div class="quick-add no-js-hidden"><product-form>
                            <form method="post" action="/cart/add" id="quick-add-template--20805846040857__main-collection-product-grid8392528101657" accept-charset="UTF-8" class="form" enctype="multipart/form-data" novalidate="novalidate" data-type="add-to-cart-form"><input type="hidden" name="form_type" value="product" /><input type="hidden" name="utf8" value="✓" /><input type="hidden" name="id" value="45474310160665" disabled>
                              <button id="quick-add-template--20805846040857__main-collection-product-grid8392528101657-submit" type="submit" name="add" class="quick-add__submit button button--full-width button--secondary" aria-haspopup="dialog" aria-labelledby="quick-add-template--20805846040857__main-collection-product-grid8392528101657-submit title-template--20805846040857__main-collection-product-grid-8392528101657" aria-live="polite" data-sold-out-message="true">
                                <span>Add to cart
                                </span>
                                <span class="sold-out-message hidden">
                                  Sold out
                                </span>
                                <div class="loading-overlay__spinner hidden">
                                  <svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                    <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                                  </svg>
                                </div>
                              </button>
                            </form>
                          </product-form></div>
                        <div class="card__badge bottom left"><span id="Badge-template--20805846040857__main-collection-product-grid-8392528101657" class="badge badge--bottom-left color-accent-2">
                            40%
                          </span></div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="grid__item">


                  <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-rating.css?v=24573085263941240431693673627" rel="stylesheet" type="text/css" media="all" />
                  <div class="card-wrapper product-card-wrapper underline-links-hover">
                    <div class="
        card
        card--card
         card--media
         color-background-1 gradient
        
        
        
      " style="--ratio-percent: 100.0%;">
                      <div class="card__inner  ratio" style="--ratio-percent: 100.0%;">
                        <div class="card__media">
                          <div class="media media--transparent media--hover-effect">

                            <img srcset="//tiendamiaecu.com/cdn/shop/files/LAMPARASOLAR_2e8c2546-68fc-4463-8191-560d7460d877.png?v=1693837945&width=165 165w,//tiendamiaecu.com/cdn/shop/files/LAMPARASOLAR_2e8c2546-68fc-4463-8191-560d7460d877.png?v=1693837945&width=360 360w,//tiendamiaecu.com/cdn/shop/files/LAMPARASOLAR_2e8c2546-68fc-4463-8191-560d7460d877.png?v=1693837945&width=533 533w,//tiendamiaecu.com/cdn/shop/files/LAMPARASOLAR_2e8c2546-68fc-4463-8191-560d7460d877.png?v=1693837945&width=720 720w,//tiendamiaecu.com/cdn/shop/files/LAMPARASOLAR_2e8c2546-68fc-4463-8191-560d7460d877.png?v=1693837945&width=940 940w,//tiendamiaecu.com/cdn/shop/files/LAMPARASOLAR_2e8c2546-68fc-4463-8191-560d7460d877.png?v=1693837945&width=1066 1066w,//tiendamiaecu.com/cdn/shop/files/LAMPARASOLAR_2e8c2546-68fc-4463-8191-560d7460d877.png?v=1693837945 1080w
                " src="//tiendamiaecu.com/cdn/shop/files/LAMPARASOLAR_2e8c2546-68fc-4463-8191-560d7460d877.png?v=1693837945&width=533" sizes="(min-width: 1400px) 317px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)" alt="LAMPARA SOLAR LED 🌞💡 | ENVIO GRATIS" class="motion-reduce" loading="lazy" width="1080" height="1080">

                          </div>
                        </div>
                        <div class="card__content">
                          <div class="card__information">
                            <h3 class="card__heading">
                              <a href="/products/copia-de-lampara-solar-led-%F0%9F%8C%9E%F0%9F%92%A1" id="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8656742908185" class="full-unstyled-link" aria-labelledby="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8656742908185 NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8656742908185">
                                LAMPARA SOLAR LED 🌞💡 | ENVIO GRATIS
                              </a>
                            </h3>
                          </div>
                          <div class="card__badge bottom left"></div>
                        </div>
                      </div>
                      <div class="card__content">
                        <div class="card__information">
                          <h3 class="card__heading h5" id="title-template--20805846040857__main-collection-product-grid-8656742908185">
                            <a href="/products/copia-de-lampara-solar-led-%F0%9F%8C%9E%F0%9F%92%A1" id="CardLink-template--20805846040857__main-collection-product-grid-8656742908185" class="full-unstyled-link" aria-labelledby="CardLink-template--20805846040857__main-collection-product-grid-8656742908185 Badge-template--20805846040857__main-collection-product-grid-8656742908185">
                              LAMPARA SOLAR LED 🌞💡 | ENVIO GRATIS
                            </a>
                          </h3>
                          <div class="card-information"><span class="caption-large light"></span>
                            <div class="
    price ">
                              <div class="price__container">
                                <div class="price__regular">
                                  <span class="visually-hidden visually-hidden--inline">Regular price</span>
                                  <span class="price-item price-item--regular">
                                    $34.95
                                  </span>
                                </div>
                                <div class="price__sale ">
                                  <span class="visually-hidden visually-hidden--inline regular-price-label">Sale price</span>
                                  <span class="price-item price-item--sale price-item--last">
                                    $34.95
                                  </span>
                                  <span class="visually-hidden visually-hidden--inline compare-price-label">Regular price</span>
                                  <span class="price__compare-price">
                                    <s class="price-item price-item--regular">

                                    </s>
                                  </span>
                                </div>
                                <small class="unit-price caption hidden">
                                  <span class="visually-hidden">Unit price</span>
                                  <span class="price-item price-item--last">
                                    <span></span>
                                    <span aria-hidden="true">/</span>
                                    <span class="visually-hidden">&nbsp;per&nbsp;</span>
                                    <span>
                                    </span>
                                  </span>
                                </small>
                              </div>
                            </div>

                          </div>
                        </div>
                        <div class="quick-add no-js-hidden"><product-form>
                            <form method="post" action="/cart/add" id="quick-add-template--20805846040857__main-collection-product-grid8656742908185" accept-charset="UTF-8" class="form" enctype="multipart/form-data" novalidate="novalidate" data-type="add-to-cart-form"><input type="hidden" name="form_type" value="product" /><input type="hidden" name="utf8" value="✓" /><input type="hidden" name="id" value="46690961195289" disabled>
                              <button id="quick-add-template--20805846040857__main-collection-product-grid8656742908185-submit" type="submit" name="add" class="quick-add__submit button button--full-width button--secondary" aria-haspopup="dialog" aria-labelledby="quick-add-template--20805846040857__main-collection-product-grid8656742908185-submit title-template--20805846040857__main-collection-product-grid-8656742908185" aria-live="polite" data-sold-out-message="true">
                                <span>Add to cart
                                </span>
                                <span class="sold-out-message hidden">
                                  Sold out
                                </span>
                                <div class="loading-overlay__spinner hidden">
                                  <svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                    <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                                  </svg>
                                </div>
                              </button>
                            </form>
                          </product-form></div>
                        <div class="card__badge bottom left"></div>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>

              <link rel="stylesheet" href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-pagination.css?v=136206814810731739951693673627" media="print" onload="this.media='all'">
              <noscript>
                <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-pagination.css?v=136206814810731739951693673627" rel="stylesheet" type="text/css" media="all" />
              </noscript>
              <div class="pagination-wrapper">
                <nav class="pagination" role="navigation" aria-label="Pagination">
                  <ul class="pagination__list list-unstyled" role="list">
                    <li><a role="link" aria-disabled="true" class="pagination__item pagination__item--current light" aria-current="page" aria-label="Page 1">1</a></li>
                    <li><a href="/collections/all?page=2" class="pagination__item link" aria-label="Page 2">2</a></li>
                    <li><a href="/collections/all?page=3" class="pagination__item link" aria-label="Page 3">3</a></li>
                    <li>
                      <a href="/collections/all?page=2" class="pagination__item pagination__item--prev pagination__item-arrow link motion-reduce" aria-label="Next page"><svg aria-hidden="true" focusable="false" class="icon icon-caret" viewBox="0 0 10 6">
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M9.354.646a.5.5 0 00-.708 0L5 4.293 1.354.646a.5.5 0 00-.708.708l4 4a.5.5 0 00.708 0l4-4a.5.5 0 000-.708z" fill="currentColor">
                        </svg>
                      </a>
                    </li>
                  </ul>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>


    </div>
    <section id="shopify-section-template--20805846040857__newsletter" class="shopify-section section">
      <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-newsletter.css?v=180884587654672216131693673627" rel="stylesheet" type="text/css" media="all" />
      <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/newsletter-section.css?v=62410470717655853621693673628" rel="stylesheet" type="text/css" media="all" />
      <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-rte.css?v=73443491922477598101693673627" rel="stylesheet" type="text/css" media="all" />
      <style data-shopify>
        .section-template--20805846040857__newsletter-padding {
          padding-top: 51px;
          padding-bottom: 39px;
        }

        @media screen and (min-width: 750px) {
          .section-template--20805846040857__newsletter-padding {
            padding-top: 68px;
            padding-bottom: 52px;
          }
        }
      </style>
      <div class="newsletter center ">
        <div class="newsletter__wrapper color-background-2 gradient content-container isolate content-container--full-width section-template--20805846040857__newsletter-padding">
          <h2 class="h1">
            Subscribe to our emails
          </h2>
          <div class="newsletter__subheading rte">
            <p>Join our email list for exclusive offers and the latest news. </p>
          </div>
          <div>
            <form method="post" action="/contact#contact_form" id="contact_form" accept-charset="UTF-8" class="newsletter-form"><input type="hidden" name="form_type" value="customer" /><input type="hidden" name="utf8" value="✓" />
              <input type="hidden" name="contact[tags]" value="newsletter">
              <div class="newsletter-form__field-wrapper">
                <div class="field">
                  <input id="NewsletterForm--template--20805846040857__newsletter" type="email" name="contact[email]" class="field__input" value="" aria-required="true" autocorrect="off" autocapitalize="off" autocomplete="email" placeholder="Email" required>
                  <label class="field__label" for="NewsletterForm--template--20805846040857__newsletter">
                    Email
                  </label>

                </div>

                <button type="submit" class="button newsletter__solid-btn button--full-width" name="commit" id="Subscribe" aria-label="Subscribe">
                  Sign up
                </button>

              </div>
            </form>
          </div>
        </div>
      </div>


    </section>
  </main>

  <div id="shopify-section-promo-popup" class="shopify-section">
    <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/section-promo-popup.css?v=175993886525155844911693673629" rel="stylesheet" type="text/css" media="all" />
    <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-newsletter.css?v=180884587654672216131693673627" rel="stylesheet" type="text/css" media="all" />
    <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/newsletter-section.css?v=62410470717655853621693673628" rel="stylesheet" type="text/css" media="all" />
    <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-rte.css?v=73443491922477598101693673627" rel="stylesheet" type="text/css" media="all" />

  </div>
  <div id="shopify-section-scroll-to-top-btn" class="shopify-section">
    <style data-shopify>
      .scroll-to-top-btn-scroll-to-top-btn {
        --offset-x: 20px;
        --offset-y: 20px;
      }
    </style>




  </div>
  <div id="shopify-section-global-music-player" class="shopify-section">
    <style data-shopify>
      .music-player-global-music-player {
        --offset-x: 20px;
        --offset-y: 20px;
      }
    </style>




  </div>
  <!-- BEGIN sections: footer-group -->
  <div id="shopify-section-sections--20805847089433__footer" class="shopify-section shopify-section-group-footer-group">
    <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/section-footer.css?v=46383091618275559031693673628" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-newsletter.css?v=180884587654672216131693673627" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-list-menu.css?v=151968516119678728991693673627" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-list-payment.css?v=69253961410771838501693673627" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-list-social.css?v=52211663153726659061693673627" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-rte.css?v=73443491922477598101693673627" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="//tiendamiaecu.com/cdn/shop/t/3/assets/disclosure.css?v=646595190999601341693673628" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-card.css?v=171622893807557687511693673627" media="print" onload="this.media='all'">

    <noscript>
      <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-newsletter.css?v=180884587654672216131693673627" rel="stylesheet" type="text/css" media="all" />
    </noscript>
    <noscript>
      <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-list-menu.css?v=151968516119678728991693673627" rel="stylesheet" type="text/css" media="all" />
    </noscript>
    <noscript>
      <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-list-payment.css?v=69253961410771838501693673627" rel="stylesheet" type="text/css" media="all" />
    </noscript>
    <noscript>
      <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-list-social.css?v=52211663153726659061693673627" rel="stylesheet" type="text/css" media="all" />
    </noscript>
    <noscript>
      <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-rte.css?v=73443491922477598101693673627" rel="stylesheet" type="text/css" media="all" />
    </noscript>
    <noscript>
      <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/disclosure.css?v=646595190999601341693673628" rel="stylesheet" type="text/css" media="all" />
    </noscript>
    <noscript>
      <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-card.css?v=171622893807557687511693673627" rel="stylesheet" type="text/css" media="all" />
    </noscript>

    <!-- <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-card.css?v=171622893807557687511693673627" rel="stylesheet" type="text/css" media="all" /> -->
    <style data-shopify>
      .footer {
        margin-top: 0px;
      }

      .section-sections--20805847089433__footer-padding {
        padding-top: 24px;
        padding-bottom: 15px;
      }

      @media screen and (min-width: 750px) {
        .footer {
          margin-top: 0px;
        }

        .section-sections--20805847089433__footer-padding {
          padding-top: 32px;
          padding-bottom: 20px;
        }
      }
    </style>
    <footer class="footer color-accent-1 gradient section-sections--20805847089433__footer-padding">
      <div class="footer__content-top page-width">
        <div class="footer__blocks-wrapper grid">
          <div class="footer-block grid__item footer-block--desktop-3 footer-block--mobile-2">
            <h2 class="footer-block__heading">Contacto:</h2>
            <div class="footer-block__details-content rte">
              <p>Cualquier duda escríbanos en el apartado de "contacto" y en menos de 1 hora nuestro equipo le atenderá. </p>
              <p>Dirección: Guayaquil Ecuador</p>
            </div>
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
              <ul class="list list-payment" role="list">
                <li class="list-payment__item">
                  <svg class="icon icon--full-color" viewBox="0 0 38 24" xmlns="http://www.w3.org/2000/svg" width="38" height="24" role="img" aria-labelledby="pi-paypal">
                    <title id="pi-paypal">PayPal</title>
                    <path opacity=".07" d="M35 0H3C1.3 0 0 1.3 0 3v18c0 1.7 1.4 3 3 3h32c1.7 0 3-1.3 3-3V3c0-1.7-1.4-3-3-3z" />
                    <path fill="#fff" d="M35 1c1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2H3c-1.1 0-2-.9-2-2V3c0-1.1.9-2 2-2h32" />
                    <path fill="#003087" d="M23.9 8.3c.2-1 0-1.7-.6-2.3-.6-.7-1.7-1-3.1-1h-4.1c-.3 0-.5.2-.6.5L14 15.6c0 .2.1.4.3.4H17l.4-3.4 1.8-2.2 4.7-2.1z" />
                    <path fill="#3086C8" d="M23.9 8.3l-.2.2c-.5 2.8-2.2 3.8-4.6 3.8H18c-.3 0-.5.2-.6.5l-.6 3.9-.2 1c0 .2.1.4.3.4H19c.3 0 .5-.2.5-.4v-.1l.4-2.4v-.1c0-.2.3-.4.5-.4h.3c2.1 0 3.7-.8 4.1-3.2.2-1 .1-1.8-.4-2.4-.1-.5-.3-.7-.5-.8z" />
                    <path fill="#012169" d="M23.3 8.1c-.1-.1-.2-.1-.3-.1-.1 0-.2 0-.3-.1-.3-.1-.7-.1-1.1-.1h-3c-.1 0-.2 0-.2.1-.2.1-.3.2-.3.4l-.7 4.4v.1c0-.3.3-.5.6-.5h1.3c2.5 0 4.1-1 4.6-3.8v-.2c-.1-.1-.3-.2-.5-.2h-.1z" />
                  </svg>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="footer__content-bottom-wrapper page-width">
          <div class="footer__copyright caption">
            <small class="copyright__content">&copy; 2023, <a href="/" title="">Tiendamia Ec</a></small>
            <small class="copyright__content">&#80;&#111;&#119;&#101;&#114;&#101;&#100;&#32;&#98;&#121;&#32;&#72;&#97;&#122;&#101;</small>
            <ul class="policies list-unstyled"></ul>
          </div>
        </div>
      </div>
    </footer>




  </div>
  <!-- END sections: footer-group -->

  <ul hidden>
    <li id="a11y-refresh-page-message">Choosing a selection results in a full page refresh.</li>
    <li id="a11y-new-window-message">Opens in a new window.</li>
  </ul>

  <script>
    window.shopUrl = 'https://tiendamiaecu.com';
    window.routes = {
      cart_add_url: '/cart/add',
      cart_change_url: '/cart/change',
      cart_update_url: '/cart/update',
      cart_url: '/cart',
      predictive_search_url: '/search/suggest'
    };

    window.cartStrings = {
      error: `There was an error while updating your cart. Please try again.`,
      quantityError: `You can only add [quantity] of this item to your cart.`
    }

    window.variantStrings = {
      addToCart: `Add to cart`,
      soldOut: `Sold out`,
      unavailable: `Unavailable`,
      unavailable_with_option: `[value] - Unavailable`,
    }

    window.accessibilityStrings = {
      imageAvailable: `Image [index] is now available in gallery view`,
      shareSuccess: `Link copied to clipboard`,
      pauseSlideshow: `Pause slideshow`,
      playSlideshow: `Play slideshow`,
    }
  </script>
  <script src="//tiendamiaecu.com/cdn/shop/t/3/assets/predictive-search.js?v=16985596534672189881693673628" defer="defer"></script>
  <script>
    window.addEventListener("contextmenu", (e) => {
      e.preventDefault();
    });
    document.addEventListener("selectstart", (e) => {
      e.preventDefault();
    });
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('img').forEach(img => {
        img.addEventListener('dragstart', function(e) {
          e.preventDefault();
        })
      })
    })

    function ctrlShiftKey(e, keyCode) {
      return e.ctrlKey && e.shiftKey && e.keyCode === keyCode.charCodeAt(0);
    }
    document.addEventListener('keydown', function(e) {
      if (
        event.keyCode === 123 ||
        ctrlShiftKey(e, 'I') ||
        ctrlShiftKey(e, 'J') ||
        ctrlShiftKey(e, 'C') ||
        (e.ctrlKey && e.keyCode === 'U'.charCodeAt(0))
      ) {
        e.preventDefault();
      }
    })
  </script>


  <!-- "snippets/revy-bundle-script.liquid" was not rendered, the associated app was uninstalled -->

</body>

</html>