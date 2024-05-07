<!doctype html>
<?php
session_start();
if (!isset($_SESSION["comprar"])) {
  $session_id = 'user_' . mt_rand();
  $_SESSION["comprar"] = $session_id;
} else {
  $session_id = $_SESSION["comprar"];
}
//echo $session_id;
require_once "sysadmin/vistas/db.php";
require_once "sysadmin/vistas/php_conexion.php";
require_once "sysadmin/vistas/funciones.php";

$id_producto = $_GET['id'];

$pagina = 'PRODUCTO';
include './auditoria.php';
include './includes/style.php';



$aColumns     = array('codigo_producto', 'nombre_producto'); //Columnas de busqueda
$sTable       = "productos";
$sWhere       = "where id_producto=$id_producto ";
$sql   = "SELECT * FROM  $sTable $sWhere ";
$query = mysqli_query($conexion, $sql);
while ($row = mysqli_fetch_array($query)) {


  $id_producto          = $row['id_producto'];
  $codigo_producto      = $row['codigo_producto'];
  $nombre_producto      = $row['nombre_producto'];
  $descripcion_producto = $row['descripcion_producto'];
  $linea_producto       = $row['id_linea_producto'];
  $med_producto         = $row['id_med_producto'];
  $id_proveedor         = $row['id_proveedor'];
  $inv_producto         = $row['inv_producto'];
  $impuesto_producto    = $row['iva_producto'];
  $costo_producto       = $row['costo_producto'];
  $utilidad_producto    = $row['utilidad_producto'];
  $precio_producto      = $row['valor1_producto'];
  $precio_mayoreo       = $row['valor2_producto'];
  $precio_especial      = $row['valor3_producto'];
  $stock_producto       = $row['stock_producto'];
  $stock_min_producto   = $row['stock_min_producto'];
  $precio_normal      = $row['valor4_producto'];



  $online   = $row['pagina_web'];
  $status_producto      = $row['estado_producto'];
  $date_added           = date('d/m/Y', strtotime($row['date_added']));
  $image_path           = $row['image_path'];

  $id_imp_producto      = $row['id_imp_producto'];
  $formato      = $row['formato'];
}
?>
<html class="no-js" lang="en">
<?php
include 'includes/head_producto.php'
?>
<?php

//  include 'modal/comprar.php';


?>
<?php
if ($formato == 3) {
  $imporsuit_db = mysqli_connect("194.163.183.231", 'administrador', '69635201d674bcb6f0897604c7c97cf8', 'suit-imporcomex');
  $url_site = $_SERVER['HTTP_HOST'];
  $sql_usuario = "SELECT * FROM users WHERE url like '%" . $url_site . "%'";
  $query_usuario = mysqli_query($imporsuit_db, $sql_usuario);
  $rw_usuario = mysqli_fetch_array($query_usuario);
  echo mysqli_error($imporsuit_db);
  $users = $rw_usuario['id'];
  $pagina = $nombre_producto . "_" . $users;


  echo '
<frameset>
<frame src="https://drag.imporsuit.com/' . $pagina . '">
</frameset>
    
';
  exit;
}
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script><!-- comment -->
<script id="sections-script" data-sections="header,footer" defer="defer" src="js/scripts.js?84"></script><!-- comment -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<script src="assets/js/bootstrap.bundle.min.js"></script>

<body class="gradient">
  <a class="skip-to-content-link button visually-hidden" href="#MainContent">
    Skip to content
  </a>





  <style>
    .drawer {
      visibility: hidden;
      position: absolute;
    }
  </style>

  <cart-drawer class="drawer">
    <div id="CartDrawer" class="cart-drawer">
      <div id="CartDrawer-Overlay" class="cart-drawer__overlay"></div>
      <div class="drawer__inner" role="dialog" aria-modal="true" aria-label="Your cart" tabindex="-1">
        <div class="drawer__header">
          <h2 class="drawer__heading">Your cart</h2>
          <button class="drawer__close" type="button" onclick="this.closest('cart-drawer').close()" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" class="icon icon-close" fill="none" viewBox="0 0 18 17">
              <path d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z" fill="currentColor">
            </svg>

          </button>
        </div>

        <div class="cart-drawer-items-and-upsell">
          <cart-drawer-items>
            <form action="/cart" id="CartDrawer-Form" class="cart__contents cart-drawer__form" method="post">
              <div id="CartDrawer-CartItems" class="drawer__contents js-contents">
                <div class="drawer__cart-items-wrapper">
                  <table class="cart-items" role="table">
                    <thead role="rowgroup">
                      <tr role="row">
                        <th id="CartDrawer-ColumnProductImage" role="columnheader">
                          <span class="visually-hidden">Product image</span>
                        </th>
                        <th id="CartDrawer-ColumnProduct" class="caption-with-letter-spacing" scope="col" role="columnheader">
                          Producto
                        </th>
                        <th id="CartDrawer-ColumnTotal" class="right caption-with-letter-spacing" scope="col" role="columnheader">
                          Total
                        </th>
                        <th id="CartDrawer-ColumnQuantity" role="columnheader">
                          <span class="visually-hidden">Quantity</span>
                        </th>
                      </tr>
                    </thead>

                    <tbody role="rowgroup">
                      <tr id="CartDrawer-Item-1" class="cart-item" role="row">
                        <td class="cart-item__media" role="cell" headers="CartDrawer-ColumnProductImage">


                          <a href="producto.php?id=<?php echo $id_producto; ?>" class="cart-item__link" tabindex="-1" aria-hidden="true"> </a>
                          <img class="cart-item__image" src=" <?php
                                                              $subcadena = "http";

                                                              if (strpos(strtolower($image_path), strtolower($subcadena)) === 0) {
                                                              ?>
    <?php echo  $image_path . '"'; ?>
    <?php
                                                              } else {
    ?>
    sysadmin/<?php echo str_replace("../..", "", $image_path) ?>" <?php
                                                                }
                                                                  ?> alt="" loading="lazy" width="150" height="150">

                        </td>

                        <td class="cart-item__details" role="cell" headers="CartDrawer-ColumnProduct"><a href="/products/brazalete-magico-iris?variant=46049766080793" class="cart-item__name h4 break"><?php echo $nombre_producto; ?></a>
                          <dl></dl>

                          <p class="product-option"></p>
                          <ul class="discounts list-unstyled" role="list" aria-label="Discount"></ul>
                        </td>

                        <td class="cart-item__totals right" role="cell" headers="CartDrawer-ColumnTotal">
                          <div class="loading-overlay hidden">
                            <div class="loading-overlay__spinner">
                              <svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                              </svg>
                            </div>
                          </div>

                          <div class="cart-item__price-wrapper"><span class="price price--end">
                              <?php echo get_row('perfil', 'moneda', 'id_perfil', 1) . number_format($precio_especial, 2); ?>
                            </span></div>
                        </td>


                      </tr>
                    </tbody>
                  </table>
                </div>
                <p id="CartDrawer-LiveRegionText" class="visually-hidden" role="status"></p>
                <p id="CartDrawer-LineItemStatus" class="visually-hidden" aria-hidden="true" role="status">
                  Loading...
                </p>
              </div>
              <div id="CartDrawer-CartErrors" role="alert"></div>
            </form>
          </cart-drawer-items>

        </div>
        <div class="drawer__footer">


          <!-- Start blocks -->
          <!-- Subtotals -->

          <div class="cart-drawer__footer">
            <div class="totals" role="status">
              <h2 class="totals__subtotal">Subtotal</h2>
              <p class="totals__subtotal-value">$<?php echo number_format($precio_especial, 2); ?></p>
            </div>

            <div></div>
          </div>

          <!-- CTAs -->

          <div class="cart__ctas">
            <noscript>
              <button type="submit" class="cart__update-button button button--secondary" form="CartDrawer-Form">
                Update
              </button>
            </noscript>

            <button type="submit" id="CartDrawer-Checkout" class="cart__checkout-button button" name="checkout" form="CartDrawer-Form">
              Check out
            </button>
          </div>



        </div>
      </div>
    </div>
  </cart-drawer>





  <script>
    document.addEventListener('DOMContentLoaded', function() {
      function isIE() {
        const ua = window.navigator.userAgent;
        const msie = ua.indexOf('MSIE ');
        const trident = ua.indexOf('Trident/');

        return msie > 0 || trident > 0;
      }

      if (!isIE()) return;
      const cartSubmitInput = document.createElement('input');
      cartSubmitInput.setAttribute('name', 'checkout');
      cartSubmitInput.setAttribute('type', 'hidden');
      document.querySelector('#cart').appendChild(cartSubmitInput);
      document.querySelector('#checkout').addEventListener('click', function(event) {
        document.querySelector('#cart').submit();
      });
    });
  </script>
  <!-- BEGIN sections: header-group -->
  <div id="shopify-section-sections--20805847122201__2c2ec774-3430-481f-b927-e9c035b9d24e" class="shopify-section shopify-section-group-header-group">
    <link href="ccs/component-tickers.css?v=30346802988262109031693673627" rel="stylesheet" type="text/css" media="all" />

    <?php include './includes/flotante.php' ?>
    <?php
    include './includes/horizontal_items.php';
    ?>


  </div>
  <div id="shopify-section-sections--20805847122201__header" class="shopify-section shopify-section-group-header-group section-header">
    <link rel="stylesheet" href="ccs/component-list-menu.css?v=151968516119678728991693673627" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="ccs/component-search.css?v=184225813856820874251693673627" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="ccs/component-menu-drawer.css?v=183501262910778191901693673627" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="ccs/component-cart-notification.css?v=137625604348931474661693673627" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="ccs/component-cart-items.css?v=68325217056990975251693673627" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="ccs/component-price.css?v=183165605081763449011693673627" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="ccs/component-loading-overlay.css?v=167310470843593579841693673627" media="print" onload="this.media='all'">
    <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-cart-drawer.css?v=103351759924144934211693673627" rel="stylesheet" type="text/css" media="all" />
    <link href="ccs/component-cart.css?v=183883492810467818381693673627" rel="stylesheet" type="text/css" media="all" />
    <link href="ccs/component-totals.css?v=54425048278126878361693673627" rel="stylesheet" type="text/css" media="all" />
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
    <script src="js/cart-drawer.js?v=44260131999403604181693673626" defer="defer"></script><svg xmlns="http://www.w3.org/2000/svg" class="hidden">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">

    <?php
    $producto_activa = "";
    $producto_activa = "menu_activo texto_boton";
    include 'includes/styky-header.php';
    ?>


  </div>
  <!-- END sections: header-group -->




  <main id="MainContent" class="content-for-layout focus-none" role="main" tabindex="-1">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <section id="shopify-section-template--20805847023897__main" class="shopify-section section">
      <section id="MainProduct-template--20805847023897__main" class="page-width section-template--20805847023897__main-padding" data-section="template--20805847023897__main">

        <link href="ccs/section-main-product.css?v=134235731387245433901693673628" rel="stylesheet" type="text/css" media="all" />




        <style data-shopify>
          .section-template--20805847023897__main-padding {
            padding-top: 18px;
            padding-bottom: 0px;
          }

          @media screen and (min-width: 750px) {
            .section-template--20805847023897__main-padding {
              padding-top: 24px;
              padding-bottom: 0px;
            }
          }
        </style>
        <script src="js/product-info.js?v=174806172978439001541693673628" defer="defer"></script>




        <div class="product product--medium product--left product--thumbnail_slider product--mobile-hide grid grid--1-col grid--2-col-tablet">
          <div <?php if ($formato == 2) {
                  echo 'style: display:none';
                } ?>class="grid__item product__media-wrapper product__column-sticky">

            <media-gallery id="MediaGallery-template--20805847023897__main" role="region" aria-label="Gallery Viewer" data-desktop-layout="thumbnail_slider">
              <div id="GalleryStatus-template--20805847023897__main" class="visually-hidden" role="status"></div>
              <slider-component id="GalleryViewer-template--20805847023897__main" class="slider-mobile-gutter"><a class="skip-to-content-link button visually-hidden quick-add-hidden" href="#ProductInfo-template--20805847023897__main">
                  Skip to product information
                </a>
                <ul id="Slider-Gallery-template--20805847023897__main" class="product__media-list contains-media grid grid--peek list-unstyled slider slider--mobile" role="list">
                  <li id="Slide-template--20805847023897__main-34523778416921" class="product__media-item grid__item slider__slide is-active" data-media-id="template--20805847023897__main-34523778416921">

                    <div class="product-media-container media-type-image media-fit-contain global-media-settings gradient constrain-height" style="--ratio: 1.0; --preview-ratio: 1.0;">



                      <modal-opener class="product__modal-opener product__modal-opener--image no-js-hidden" data-modal="#ProductModal-template--20805847023897__main">
                        <span class="product__media-icon motion-reduce quick-add-hidden product__media-icon--none" aria-hidden="true"><svg aria-hidden="true" focusable="false" class="icon icon-plus" width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.66724 7.93978C4.66655 7.66364 4.88984 7.43922 5.16598 7.43853L10.6996 7.42464C10.9758 7.42395 11.2002 7.64724 11.2009 7.92339C11.2016 8.19953 10.9783 8.42395 10.7021 8.42464L5.16849 8.43852C4.89235 8.43922 4.66793 8.21592 4.66724 7.93978Z" fill="currentColor" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.92576 4.66463C8.2019 4.66394 8.42632 4.88723 8.42702 5.16337L8.4409 10.697C8.44159 10.9732 8.2183 11.1976 7.94215 11.1983C7.66601 11.199 7.44159 10.9757 7.4409 10.6995L7.42702 5.16588C7.42633 4.88974 7.64962 4.66532 7.92576 4.66463Z" fill="currentColor" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12.8324 3.03011C10.1255 0.323296 5.73693 0.323296 3.03011 3.03011C0.323296 5.73693 0.323296 10.1256 3.03011 12.8324C5.73693 15.5392 10.1255 15.5392 12.8324 12.8324C15.5392 10.1256 15.5392 5.73693 12.8324 3.03011ZM2.32301 2.32301C5.42035 -0.774336 10.4421 -0.774336 13.5395 2.32301C16.6101 5.39361 16.6366 10.3556 13.619 13.4588L18.2473 18.0871C18.4426 18.2824 18.4426 18.599 18.2473 18.7943C18.0521 18.9895 17.7355 18.9895 17.5402 18.7943L12.8778 14.1318C9.76383 16.6223 5.20839 16.4249 2.32301 13.5395C-0.774335 10.4421 -0.774335 5.42035 2.32301 2.32301Z" fill="currentColor" />
                          </svg>
                        </span>
                        <div class="product__media media media--transparent">
                          <img src=" <?php
                                      $subcadena = "http";

                                      if (strpos(strtolower($image_path), strtolower($subcadena)) === 0) {
                                      ?>
    <?php echo  $image_path . '"'; ?>
    <?php

                                      } else {
    ?>
    sysadmin/<?php echo str_replace("../..", "", $image_path) ?>" <?php
                                                                }
                                                                  ?> alt="" srcset=" <?php
                                                                                      $subcadena = "http";

                                                                                      if (strpos(strtolower($image_path), strtolower($subcadena)) === 0) {
                                                                                      ?>
    <?php echo  $image_path . '"'; ?>
    <?php
                                                                                      } else {
    ?>
    sysadmin/<?php echo str_replace("../..", "", $image_path) ?>" <?php
                                                                                      }
                                                                  ?> width="1946" height="1946" class="image-magnify-none" sizes="(min-width: 1400px) 715px, (min-width: 990px) calc(55.0vw - 10rem), (min-width: 750px) calc((100vw - 11.5rem) / 2), calc(100vw / 1 - 4rem)">
                        </div>
                        <button class="product__media-toggle quick-add-hidden product__media-zoom-none" type="button" aria-haspopup="dialog" data-media-id="34523778416921">
                          <span class="visually-hidden">
                            Open media 1 in modal
                          </span>
                        </button>
                      </modal-opener>
                    </div>

                  </li>
                </ul>
                <div class="slider-buttons no-js-hidden quick-add-hidden small-hide">
                  <button type="button" class="slider-button slider-button--prev" name="previous" aria-label="Slide left">
                    <svg aria-hidden="true" focusable="false" class="icon icon-caret" viewBox="0 0 10 6">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M9.354.646a.5.5 0 00-.708 0L5 4.293 1.354.646a.5.5 0 00-.708.708l4 4a.5.5 0 00.708 0l4-4a.5.5 0 000-.708z" fill="currentColor">
                    </svg>

                  </button>
                  <div class="slider-counter caption">
                    <span class="slider-counter--current">1</span>
                    <span aria-hidden="true"> / </span>
                    <span class="visually-hidden">of</span>
                    <span class="slider-counter--total">1</span>
                  </div>
                  <button type="button" class="slider-button slider-button--next" name="next" aria-label="Slide right">
                    <svg aria-hidden="true" focusable="false" class="icon icon-caret" viewBox="0 0 10 6">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M9.354.646a.5.5 0 00-.708 0L5 4.293 1.354.646a.5.5 0 00-.708.708l4 4a.5.5 0 00.708 0l4-4a.5.5 0 000-.708z" fill="currentColor">
                    </svg>

                  </button>
                </div>
              </slider-component>
            </media-gallery>

          </div>
          <div class="product__info-wrapper grid__item product__column-sticky" <?php if ($formato == 2) {
                                                                                  echo 'style="max-width:100% !important"';
                                                                                } ?>>
            <product-info id="ProductInfo-template--20805847023897__main" data-section="template--20805847023897__main" data-url="/products/brazalete-magico-iris" class="product__info-container">
              <div class="product__title">
                <h1 class="h1">
                  <?php echo $nombre_producto; ?>
                </h1>
                <a href="/products/brazalete-magico-iris" class="product__title">
                  <h2 class="h1">
                    <?php echo $nombre_producto; ?>
                  </h2>
                </a>
              </div>

              <!-- Start Areviews product title Rating Code -->
              <div class='areviews_header_stars'></div>
              <!-- End Areviews product title Rating Code -->
              <div class="no-js-hidden product-page-price" id="price-template--20805847023897__main" role="status">


                <div class="
                       price price--large price--on-sale  price--show-badge">
                  <div class="price__container">
                    <div class="price__regular">
                      <span class="visually-hidden visually-hidden--inline">Regular price</span>
                      <span class="price-item price-item--regular">
                        <?php echo get_row('perfil', 'moneda', 'id_perfil', 1) . $precio_especial; ?>
                      </span>
                    </div>
                    <div class="price__sale ">
                      <span class="visually-hidden visually-hidden--inline regular-price-label">Sale price</span>
                      <span class="price-item price-item--sale price-item--last">
                        <?php echo get_row('perfil', 'moneda', 'id_perfil', 1) . $precio_especial; ?>
                      </span>
                      <span class="visually-hidden visually-hidden--inline compare-price-label">Regular price</span>
                      <?php
                      if ($precio_normal > 0) {
                      ?>
                        <span class="price__compare-price">
                          <s class="price-item price-item--regular">
                            $<?php echo get_row('perfil', 'moneda', 'id_perfil', 1) . $precio_normal; ?>
                          </s>
                        <?php
                      }
                        ?>
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
                  <?php
                  if ($precio_normal > 0) {
                  ?>
                    <span class="badge price__badge-sale color-accent-2">


                      <svg aria-hidden="true" focusable="false" class="icon icon-discount color-foreground-text" viewBox="0 0 12 12">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 0h3a2 2 0 012 2v3a1 1 0 01-.3.7l-6 6a1 1 0 01-1.4 0l-4-4a1 1 0 010-1.4l6-6A1 1 0 017 0zm2 2a1 1 0 102 0 1 1 0 00-2 0z" fill="currentColor">
                      </svg>
                      <span class='nowrap'><?php echo "AHORRA UN&nbsp";
                                            echo number_format(100 - ($precio_especial * 100 / $precio_normal));
                                            echo "%"; ?></span>
                    </span>
                  <?php
                  }
                  ?>
                  <span class="badge price__badge-sold-out color-inverse">
                    Sold out
                  </span>
                </div>
              </div>
              <div>
                <form method="post" action="/cart/add" id="product-form-installment-template--20805847023897__main" accept-charset="UTF-8" class="installment caption-large" enctype="multipart/form-data"><input type="hidden" name="form_type" value="product" /><input type="hidden" name="utf8" value="✓" /><input type="hidden" name="id" value="46049766080793">

                </form>
              </div>
              <div <?php if ($formato == 2) {
                      echo 'style= display:none';
                    } ?> class="emoji-benefits-container">
                <?php
                $sql_car = "select * from caracteristicas_tienda";
                $query_car = mysqli_query($conexion, $sql_car);

                if ($query_car) {
                  $rowcount = mysqli_num_rows($query_car);


                  // $i = 1;
                  while ($row_car = mysqli_fetch_array($query_car)) {
                ?>

                    <p>- <?php echo $row_car['texto']; ?></p>
                <?php
                  }
                }
                ?>
              </div>




              <div>
                <product-form class="product-form">
                  <div class="product-form__error-message-wrapper" role="alert" hidden>
                    <svg aria-hidden="true" focusable="false" class="icon icon-error" viewBox="0 0 13 13">
                      <circle cx="6.5" cy="6.50049" r="5.5" stroke="white" stroke-width="2" />
                      <circle cx="6.5" cy="6.5" r="5.5" fill="#EB001B" stroke="#EB001B" stroke-width="0.7" />
                      <path d="M5.87413 3.52832L5.97439 7.57216H7.02713L7.12739 3.52832H5.87413ZM6.50076 9.66091C6.88091 9.66091 7.18169 9.37267 7.18169 9.00504C7.18169 8.63742 6.88091 8.34917 6.50076 8.34917C6.12061 8.34917 5.81982 8.63742 5.81982 9.00504C5.81982 9.37267 6.12061 9.66091 6.50076 9.66091Z" fill="white" />
                      <path d="M5.87413 3.17832H5.51535L5.52424 3.537L5.6245 7.58083L5.63296 7.92216H5.97439H7.02713H7.36856L7.37702 7.58083L7.47728 3.537L7.48617 3.17832H7.12739H5.87413ZM6.50076 10.0109C7.06121 10.0109 7.5317 9.57872 7.5317 9.00504C7.5317 8.43137 7.06121 7.99918 6.50076 7.99918C5.94031 7.99918 5.46982 8.43137 5.46982 9.00504C5.46982 9.57872 5.94031 10.0109 6.50076 10.0109Z" fill="white" stroke="#EB001B" stroke-width="0.7">
                    </svg>
                    <span class="product-form__error-message"></span>
                  </div>
                  <form method="post" action="/cart/add" id="product-form-template--20805847023897__main" accept-charset="UTF-8" class="form" enctype="multipart/form-data" novalidate="novalidate" data-type="add-to-cart-form"><input type="hidden" name="form_type" value="product" /><input type="hidden" name="utf8" value="✓" />
                    <div class="product-form__multiple-variant-ids"></div>
                    <input type="hidden" name="id" data-selected-id="46049766080793" value="46049766080793" disabled class="product-variant-id">
                    <div class="product-form__buttons product-form__buttons--uppercase">

                      <style>
                        @keyframes jump {
                          0% {
                            transform: translateY(0);
                            /* Sin desplazamiento vertical */
                          }

                          50% {
                            transform: translateY(-5px);
                            /* Desplazamiento hacia arriba */
                          }

                          100% {
                            transform: translateY(0);
                            /* Volver a la posición original */
                          }
                        }

                        /* Aplicar la animación al botón */
                        .jump-button {
                          animation: jump 3s ease infinite;
                          /* Animación llamada 'jump' que dura 3 segundos y se repite infinitamente */
                        }
                      </style>
                      <a style="height: 50px; font-size: 26px; width: 100%; border-radius: 15px" class="jump-button btn boton texto_boton " href="#" onclick="agregar_tmp(<?php echo $id_producto; ?>, <?php echo $precio_especial; ?>)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <span style="margin-top: 10px">COMPRAR AHORA </span></a><!-- comment -->


                    </div>

                  </form>
                </product-form>




              </div>

              <div>
                <?php


                $rutaArchivo = 'sysadmin/vistas/ajax/' . get_row('landing', 'contenido', 'id_producto', $id_producto); // Reemplaza con la ruta correcta

                // Verifica si el archivo existe
                if (file_exists($rutaArchivo)) {
                  // Carga y muestra el contenido del archivo HTML
                  $rutaArchivo = file_get_contents($rutaArchivo);
                  echo $rutaArchivo;
                } else {

                  //echo $rutaArchivo;
                  $contenido = get_row('landing', 'contenido', 'id_producto', $id_producto);
                  if (strpos($contenido, 'http') !== false) {
                    //echo 'si';
                    $rutaArchivo = $contenido;
                    $rutaArchivo = file_get_contents($rutaArchivo);
                    echo $rutaArchivo;
                  } else {
                    $rutaArchivo = '../ajax/' . $contenido; // Reemplaza con la ruta correcta   
                    // Verifica si el archivo existe
                    if (file_exists($rutaArchivo)) {
                      // Carga y muestra el contenido del archivo HTML
                      $rutaArchivo = file_get_contents($rutaArchivo);
                      echo $rutaArchivo;
                    } else {

                      //echo $rutaArchivo;
                      echo $contenido;
                    }
                  }
                }
                ?>

              </div>

            </product-info>
            <?php
            if ($formato == 2) { ?>
              <div class="product-form__buttons product-form__buttons--uppercase">

                <style>
                  @keyframes jump {
                    0% {
                      transform: translateY(0);
                      /* Sin desplazamiento vertical */
                    }

                    50% {
                      transform: translateY(-5px);
                      /* Desplazamiento hacia arriba */
                    }

                    100% {
                      transform: translateY(0);
                      /* Volver a la posición original */
                    }
                  }

                  /* Aplicar la animación al botón */
                  .jump-button {
                    animation: jump 3s ease infinite;
                    /* Animación llamada 'jump' que dura 3 segundos y se repite infinitamente */
                  }
                </style>
                <a style="height: 50px; font-size: 26px; width: 100%; border-radius: 15px" class="jump-button btn boton texto_boton" href="#" onclick="agregar_tmp(<?php echo $id_producto; ?>, <?php echo $precio_especial; ?>)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                  <span style="margin-top: 10px">COMPRAR AHORA </span></a><!-- comment -->


              </div>
            <?php
            } ?>
          </div>


        </div>





        <script src="assets/js/custom.js"></script>


      </section>


    </section>


    <!-- comment -->
    <?php
    include './includes/horizontal_items.php';
    ?>


    <section id="shopify-section-template--20805846597913__c65117da-b894-43a0-8d4d-7bd214ab10a9" class="shopify-section section">
      <link href="ccs/section-multicolumn.css" rel="stylesheet" type="text/css" />
      <link href="ccs/section-multicolumn.css?v=6265525776963667451693673628" rel="stylesheet" type="text/css" media="all" />
      <link href="ccs/section-testimonials.css?v=8614899098275451131693673629" rel="stylesheet" type="text/css" media="all" />
      <link href="ccs/component-rte.css?v=73443491922477598101693673627" rel="stylesheet" type="text/css" media="all" />
      <link rel="stylesheet" href="ccs/component-slider.css?v=17305047213098365241693673627" media="print" onload="this.media='all'">
      <noscript>
        <link href="ccs/component-slider.css?v=17305047213098365241693673627" rel="stylesheet" type="text/css" media="all" />
      </noscript>
      <style data-shopify>
        .section-template--20805846597913__c65117da-b894-43a0-8d4d-7bd214ab10a9-padding {
          padding-top: 27px;
          padding-bottom: 27px;
        }

        @media screen and (min-width: 750px) {
          .section-template--20805846597913__c65117da-b894-43a0-8d4d-7bd214ab10a9-padding {
            padding-top: 36px;
            padding-bottom: 36px;
          }
        }
      </style>
      <div class="multicolumn color-background-1 gradient background-primary">
        <div class="page-width section-template--20805846597913__c65117da-b894-43a0-8d4d-7bd214ab10a9-padding isolate">
          <div class="title-wrapper-with-link title-wrapper--self-padded-mobile title-wrapper--no-top-margin">
            <h2 class="title h1">
              Testimonios
            </h2>
          </div>
          <slider-component class="slider-mobile-gutter">
            <ul class="multicolumn-list contains-content-container grid grid--1-col-tablet-down grid--3-col-desktop slider slider--mobile grid--peek" id="Slider-template--20805846597913__c65117da-b894-43a0-8d4d-7bd214ab10a9" role="list">
              <?php
              $sql2 = "select * from testimonios where id_producto=$id_producto or id_producto=-1";
              $query2 = mysqli_query($conexion, $sql2);
              $contador_testimonio = 1;
              $bandera_testimonio = 'active';
              $rowcount = mysqli_num_rows($query2);
              //echo $rowcount;
              $i = 1;
              while ($row2 = mysqli_fetch_array($query2)) {


                //echo $contador_testimonio;
                $id_testimoniio       = $row2['id_testimonio'];
                $nombre    = $row2['nombre'];
                $testimonio    = $row2['testimonio'];

                $image_path           = $row2['imagen'];

              ?>
                <li id="Slide-template--20805846597913__c65117da-b894-43a0-8d4d-7bd214ab10a9-1" class="multicolumn-list__item grid__item center">
                  <div class="multicolumn-card content-container testimonial-card">
                    <div class="multicolumn-card__info">
                      <p class="testimonial-card__stars">★★★★★</p>
                      <div class="testimonial-card__quotes testimonial-card__quotes--image-blank">
                        <img src="ccs/quotes.png?v=117522929067270552721693673628" alt="''">
                      </div>
                      <a href="#">
                        <img style="border-radius: 75%; height: 100px; width: 100px " class="" src=" <?php
                                                                                                      $subcadena = "http";

                                                                                                      if (strpos(strtolower($image_path), strtolower($subcadena)) === 0) {
                                                                                                      ?>
    <?php echo  $image_path . '"'; ?>
    <?php
                                                                                                      } else {
    ?>
    sysadmin/<?php echo str_replace("../..", "", $image_path) ?>" <?php
                                                                                                      }
                                                                  ?> alt="Brand Logo"></a>
                      <div class="rte">
                        <p><?php echo $testimonio; ?></p>
                      </div>
                      <div class="testimonial-card__author-container">
                        <p class="testimonial-card__author">
                          <?php echo $nombre; ?>
                        </p>
                      </div>
                    </div>
                  </div>
                </li>
              <?php
                //echo $image_path;
              }

              ?>
            </ul>
            <div class="slider-buttons no-js-hidden medium-hide">
              <button type="button" class="slider-button slider-button--prev" name="previous" aria-label="Slide left">
                <svg aria-hidden="true" focusable="false" class="icon icon-caret" viewBox="0 0 10 6">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M9.354.646a.5.5 0 00-.708 0L5 4.293 1.354.646a.5.5 0 00-.708.708l4 4a.5.5 0 00.708 0l4-4a.5.5 0 000-.708z" fill="currentColor">
                </svg>
              </button>
              <div class="slider-counter caption">
                <span class="slider-counter--current">1</span>
                <span aria-hidden="true"> / </span>
                <span class="visually-hidden">of</span>
                <span class="slider-counter--total">3</span>
              </div>
              <button type="button" class="slider-button slider-button--next" name="next" aria-label="Slide right">
                <svg aria-hidden="true" focusable="false" class="icon icon-caret" viewBox="0 0 10 6">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M9.354.646a.5.5 0 00-.708 0L5 4.293 1.354.646a.5.5 0 00-.708.708l4 4a.5.5 0 00.708 0l4-4a.5.5 0 000-.708z" fill="currentColor">
                </svg>
              </button>
            </div>
          </slider-component>
        </div>
      </div>
    </section>
    <!-- comment -->
    <div id="shopify-section-template--20805847023897__03c08e95-f0ce-4379-bc05-787da4136202" class="shopify-section">

      <style data-shopify>
        .section-template--20805847023897__03c08e95-f0ce-4379-bc05-787da4136202-padding {
          padding-top: 12px;
          padding-bottom: 12px;
        }

        @media screen and (min-width: 750px) {
          .section-template--20805847023897__03c08e95-f0ce-4379-bc05-787da4136202-padding {
            padding-top: 16px;
            padding-bottom: 16px;
          }
        }

        .horizontal-ticker-template--20805847023897__03c08e95-f0ce-4379-bc05-787da4136202 .horizontal-ticker__item {
          font-size: 1.75rem;
          padding: 0 3rem;
        }

        .horizontal-ticker-template--20805847023897__03c08e95-f0ce-4379-bc05-787da4136202 .horizontal-ticker__container {
          animation: horTicker 50s linear infinite forwards;
        }
      </style>

      <?php include 'includes/horizontal_items.php'; ?>
      <!-- </div> -->



    </div>

    <div id="shopify-section-template--20805847023897__64c96926-2c31-48fe-bd21-30941bc87822" class="shopify-section">

      <link href="ccs/component-rte.css?v=73443491922477598101693673627" rel="stylesheet" type="text/css" media="all" />
      <style data-shopify>
        .section-template--20805847023897__64c96926-2c31-48fe-bd21-30941bc87822-padding {
          padding-top: 27px;
          padding-bottom: 27px;
        }

        @media screen and (min-width: 750px) {
          .section-template--20805847023897__64c96926-2c31-48fe-bd21-30941bc87822-padding {
            padding-top: 36px;
            padding-bottom: 36px;
          }
        }
      </style>
      <div class="color-background-1">
        <!--div class="page-width section-template--20805847023897__64c96926-2c31-48fe-bd21-30941bc87822-padding">
    <div class="content-and-results content-and-results--results-first"><div class="content-container center"><h2 class="title h1">
              Resultados
            </h2><p>Resultados de una encuesta realizada a más de 2000 clientes que compraron en Armonia Vital</p>
</div><div class="results-container">
        <div class="results"><h3 class="title h2 ">
              Sus valoraciones
            </h3><div class="results__rows-container"><div class="results__row">
                <div class="results__percentage" style="--percentage: 99%">
                  <p>99%</p>
                </div>
                <div class="results__text">
                  <p>Servicio y entrega</p>
                </div>
              </div><div class="results__row">
                <div class="results__percentage" style="--percentage: 96%">
                  <p>96%</p>
                </div>
                <div class="results__text">
                  <p>Calidad del producto</p>
                </div>
              </div><div class="results__row">
                <div class="results__percentage" style="--percentage: 94%">
                  <p>94%</p>
                </div>
                <div class="results__text">
                  <p>Atención al cliente recibida</p>
                </div>
              </div></div></div>
      </div>
    </div>
  </div>
</div>


</div-->
  </main>

  <div id="shopify-section-promo-popup" class="shopify-section">

    <link href="ccs/component-newsletter.css?v=180884587654672216131693673627" rel="stylesheet" type="text/css" media="all" />
    <link href="ccs/newsletter-section.css?v=62410470717655853621693673628" rel="stylesheet" type="text/css" media="all" />
    <link href="cs/component-rte.css?v=73443491922477598101693673627" rel="stylesheet" type="text/css" media="all" />

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



    <?php

    include 'modal/comprar.php';


    ?>
  </div>
  <!-- BEGIN sections: footer-group -->

  <div id="shopify-section-sections--20805847089433__footer" class="shopify-section shopify-section-group-footer-group">
    <link href="ccs/section-footer.css?v=46383091618275559031693673628" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="ccs/component-newsletter.css?v=180884587654672216131693673627" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="ccs/component-list-menu.css?v=151968516119678728991693673627" media="print" onload="this.media='all'">

    <link rel="stylesheet" href="ccs/component-list-social.css?v=52211663153726659061693673627" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="ccs/component-rte.css?v=73443491922477598101693673627" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="ccs/disclosure.css?v=646595190999601341693673628" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="ccs/component-card.css?v=171622893807557687511693673627" media="print" onload="this.media='all'">



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
    <?php
    include 'includes/footer.php'
    ?>
    <a style="" class=" btn-flotante-producto texto_boton" href="#" onclick="agregar_tmp(<?php echo $id_producto; ?>, <?php echo $precio_especial; ?>)" data-bs-toggle="modal" data-bs-target="#exampleModal">
      <span style="margin-top: 10px">COMPRAR AHORA </span></a>
  </div>

  <!-- END sections: footer-group -->








  <!-- "snippets/revy-bundle-script.liquid" was not rendered, the associated app was uninstalled -->

</body>

</html>