<!doctype html>
<?php
   session_start(); 
  if (!isset($_SESSION["comprar"])){
         $session_id = 'user_' . mt_rand();
         $_SESSION["comprar"]=$session_id;
     }else{ 
       $session_id= $_SESSION["comprar"];  
     }   
zd
   $id_categoria=$_GET['id_cat'];
   require_once "sysadmin/vistas/db.php";
       require_once "sysadmin/vistas/php_conexion.php";
       require_once "sysadmin/vistas/funciones.php";
       
         $id_producto='';  
       $pagina='categorias';   
       include './auditoria.php';
       include './includes/style.php';
       
       $sql="select * from lineas where online='1' and padre='$id_categoria'";
                 //echo $sql;
$query = mysqli_query($conexion, $sql);
$categorias='';
while ($row = mysqli_fetch_array($query)) {
    $id_linea         = $row['id_linea'];
            $nombre_linea     = $row['nombre_linea'];
            $padre  = $row['padre'];
            $categorias.="'".$row['id_linea']."',";
}
   
       ?>
<html class="no-js" lang="en">
   <?php
   include 'includes/head.php'
   ?>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script><!-- comment -->


<style id="shopify-dynamic-checkout-cart">@media screen and (min-width: 750px) {
  #dynamic-checkout-cart {
    min-height: 50px;
  }
}

@media screen and (max-width: 750px) {
  #dynamic-checkout-cart {
    min-height: 60px;
  }
}
</style>

<link href="ccs/style_ini.css" rel="stylesheet" type="text/css"/>
    

    <link href="css/base.css?v=108207397045790613361693673626" rel="stylesheet" type="text/css" media="all" />

    

 





  

<!-- BEGIN app snippet: metafields-handlers -->






<style>
  

h3 #_rsi-buy-now-button { display: none !important }
</style>





<!-- END app snippet -->
<link href="ccs/style.min.css" rel="stylesheet" type="text/css"/>
<link href="ccs/datepicker.min.css" rel="stylesheet" type="text/css"/>

<!-- END app app block --><link href="https://monorail-edge.shopifysvc.com" rel="dns-prefetch">

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

<?php
         include 'includes/carrito.php';
         ?>






<!-- BEGIN sections: header-group -->
<div id="shopify-section-sections--20805847122201__2c2ec774-3430-481f-b927-e9c035b9d24e" class="shopify-section shopify-section-group-header-group">
    
    <link href="ccs/component-tickers.css?v=30346802988262109031693673627" rel="stylesheet" type="text/css" media="all" />
<style data-shopify>.section-sections--20805847122201__2c2ec774-3430-481f-b927-e9c035b9d24e-padding {
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
  }</style>

  <!-- <div class="horizontal-ticker__inner"> -->
  <?php
               include 'includes/horizontal_items.php';
               ?>
  <!-- </div> -->



</div><div id="shopify-section-sections--20805847122201__header" class="shopify-section shopify-section-group-header-group section-header">
    
    <link rel="stylesheet" href="ccs/component-list-menu.css?v=151968516119678728991693673627" media="print" onload="this.media='all'">
<link rel="stylesheet" href="ccs/component-search.css?v=184225813856820874251693673627" media="print" onload="this.media='all'">
<link rel="stylesheet" href="ccs/component-menu-drawer.css?v=183501262910778191901693673627" media="print" onload="this.media='all'">
<link rel="stylesheet" href="ccs/component-cart-notification.css?v=137625604348931474661693673627" media="print" onload="this.media='all'">
<link rel="stylesheet" href="ccs/component-cart-items.css?v=68325217056990975251693673627" media="print" onload="this.media='all'"><link rel="stylesheet" href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-price.css?v=183165605081763449011693673627" media="print" onload="this.media='all'">
  <link rel="stylesheet" href="ccs/component-loading-overlay.css?v=167310470843593579841693673627" media="print" onload="this.media='all'"><link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-cart-drawer.css?v=103351759924144934211693673627" rel="stylesheet" type="text/css" media="all" />
  <link href="ccs/component-cart.css?v=183883492810467818381693673627" rel="stylesheet" type="text/css" media="all" />
  <link href="ccs/omponent-totals.css?v=54425048278126878361693673627" rel="stylesheet" type="text/css" media="all" />
  <link href="ccs/component-price.css?v=183165605081763449011693673627" rel="stylesheet" type="text/css" media="all" />
  <link href="ccs/component-discounts.css?v=152760482443307489271693673627" rel="stylesheet" type="text/css" media="all" />
  <link href="ccs/component-loading-overlay.css?v=167310470843593579841693673627" rel="stylesheet" type="text/css" media="all" />

<link href="ccs/style_ini.css" rel="stylesheet" type="text/css"/>

<svg xmlns="http://www.w3.org/2000/svg" class="hidden">
  <symbol id="icon-search" viewbox="0 0 18 19" fill="none">
    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.03 11.68A5.784 5.784 0 112.85 3.5a5.784 5.784 0 018.18 8.18zm.26 1.12a6.78 6.78 0 11.72-.7l5.4 5.4a.5.5 0 11-.71.7l-5.41-5.4z" fill="currentColor"/>
  </symbol>

  <symbol id="icon-reset" class="icon icon-close"  fill="none" viewBox="0 0 18 18" stroke="currentColor">
    <circle r="8.5" cy="9" cx="9" stroke-opacity="0.2"/>
    <path d="M6.82972 6.82915L1.17193 1.17097" stroke-linecap="round" stroke-linejoin="round" transform="translate(5 5)"/>
    <path d="M1.22896 6.88502L6.77288 1.11523" stroke-linecap="round" stroke-linejoin="round" transform="translate(5 5)"/>
  </symbol>

  <symbol id="icon-close" class="icon icon-close" fill="none" viewBox="0 0 18 17">
    <path d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z" fill="currentColor">
  </symbol>
</svg>

<?php
$index_activa="";
$categoria_activa="menu_activo texto_boton";
            include 'includes/styky-header.php';
            ?>


</div>
<!-- END sections: header-group -->

    <main id="MainContent" class="content-for-layout focus-none" role="main" tabindex="-1">
      <div id="shopify-section-template--20805846040857__main-collection-banner" class="shopify-section section">
          
<link href="ccs/component-collection-hero.css?v=40426793502088958311693673627" rel="stylesheet" type="text/css" media="all" />
<style data-shopify>@media screen and (max-width: 749px) {
    .collection-hero--with-image .collection-hero__inner {
      padding-bottom: calc(0px + 2rem);
    }
  }</style><div class="collection-hero color-background-1 gradient">
  <div class="collection-hero__inner page-width">
    <div class="collection-hero__text-wrapper">
      <h1 class="collection-hero__title">
        <span class="visually-hidden">Collection: </span>Products</h1><div class="collection-hero__description rte"></div></div></div>
</div>


</div><div id="shopify-section-template--20805846040857__main-collection-product-grid" class="shopify-section section"><link href="//tiendamiaecu.com/cdn/shop/t/3/assets/template-collection.css?v=145944865380958730931693673629" rel="stylesheet" type="text/css" media="all" />
<link href="ccs/component-loading-overlay.css?v=167310470843593579841693673627" rel="stylesheet" type="text/css" media="all" />
<link href="ccs/component-card.css?v=171622893807557687511693673627" rel="stylesheet" type="text/css" media="all" />
<link href="ccs/component-price.css?v=183165605081763449011693673627" rel="stylesheet" type="text/css" media="all" />

<link
  rel="preload"
  href="ccs/component-rte.css?v=73443491922477598101693673627"
  as="style"
  onload="this.onload=null;this.rel='stylesheet'"
><link rel="stylesheet" href="css/quick-add.css?v=104678793703231887271693673628" media="print" onload="this.media='all'">
  

  @media screen and (min-width: 750px) {
    .section-template--20805846040857__main-collection-product-grid-padding {
      padding-top: 0px;
      padding-bottom: 0px;
    }
  }</style><div class="section-template--20805846040857__main-collection-product-grid-padding">
  
<div class="">
    <link href="ccs/component-facets.css?v=85339117615856704561693673627" rel="stylesheet" type="text/css" media="all" />
    
  
        

<link href="css/component-show-more.css?v=56103980314977906391693673627" rel="stylesheet" type="text/css" media="all" />

<?php include 'includes/filtros.php'; ?>
    

  <menu-drawer
    class="mobile-facets__wrapper medium-hide large-up-hide"
    data-breakpoint="mobile"
  >
    <details class="mobile-facets__disclosure disclosure-has-popup">
      <summary class="mobile-facets__open-wrapper focus-offset">
        <span class="mobile-facets__open">
          <svg
  class="icon icon-filter"
  aria-hidden="true"
  focusable="false"
  xmlns="http://www.w3.org/2000/svg"
  viewBox="0 0 20 20"
  fill="none"
>
  <path fill-rule="evenodd" d="M4.833 6.5a1.667 1.667 0 1 1 3.334 0 1.667 1.667 0 0 1-3.334 0ZM4.05 7H2.5a.5.5 0 0 1 0-1h1.55a2.5 2.5 0 0 1 4.9 0h8.55a.5.5 0 0 1 0 1H8.95a2.5 2.5 0 0 1-4.9 0Zm11.117 6.5a1.667 1.667 0 1 0-3.334 0 1.667 1.667 0 0 0 3.334 0ZM13.5 11a2.5 2.5 0 0 1 2.45 2h1.55a.5.5 0 0 1 0 1h-1.55a2.5 2.5 0 0 1-4.9 0H2.5a.5.5 0 0 1 0-1h8.55a2.5 2.5 0 0 1 2.45-2Z" fill="currentColor"/>
</svg>

          <span class="mobile-facets__open-label button-label medium-hide large-up-hide">Filter and sort
</span>
          <span class="mobile-facets__open-label button-label small-hide">Filter
</span>
        </span>
        <span tabindex="0" class="mobile-facets__close mobile-facets__close--no-js"><svg
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
      <facet-filters-form>
        <form id="FacetFiltersFormMobile" class="mobile-facets">
          <div class="mobile-facets__inner gradient">
            <div class="mobile-facets__header">
              <div class="mobile-facets__header-inner">
                <h2 class="mobile-facets__heading medium-hide large-up-hide">Filter and sort
</h2>
                <h2 class="mobile-facets__heading small-hide">Filter
</h2>
                <p class="mobile-facets__count"><?php
                $sql="select * from lineas where online='1' and padre='$id_categoria'";
                           $query = mysqli_query($conexion, $sql);
                           $num_registros = mysqli_num_rows($query);
                           echo $num_registros;
                           while ($row = mysqli_fetch_array($query)) {
                           }
                           
                ?>
</p>
              </div>
            </div>
            <div class="mobile-facets__main has-submenu gradient">
                      <details
                        id="Details-Mobile-1-template--20805846040857__main-collection-product-grid"
                        class="mobile-facets__details js-filter"
                        data-index="mobile-1"
                      >
                        <summary class="mobile-facets__summary focus-inset">
                          <div>
                            <span>Availability</span>
                            <span class="mobile-facets__arrow no-js-hidden"><svg
  viewBox="0 0 14 10"
  fill="none"
  aria-hidden="true"
  focusable="false"
  class="icon icon-arrow"
  xmlns="http://www.w3.org/2000/svg"
>
  <path fill-rule="evenodd" clip-rule="evenodd" d="M8.537.808a.5.5 0 01.817-.162l4 4a.5.5 0 010 .708l-4 4a.5.5 0 11-.708-.708L11.793 5.5H1a.5.5 0 010-1h10.793L8.646 1.354a.5.5 0 01-.109-.546z" fill="currentColor">
</svg>
</span>
                            
                          </div>
                        </summary>
                        <div
                          id="FacetMobile-1-template--20805846040857__main-collection-product-grid"
                          class="mobile-facets__submenu gradient"
                        >
                          <button
                            class="mobile-facets__close-button link link--text focus-inset"
                            aria-expanded="true"
                            type="button"
                          >
                            <svg
  viewBox="0 0 14 10"
  fill="none"
  aria-hidden="true"
  focusable="false"
  class="icon icon-arrow"
  xmlns="http://www.w3.org/2000/svg"
>
  <path fill-rule="evenodd" clip-rule="evenodd" d="M8.537.808a.5.5 0 01.817-.162l4 4a.5.5 0 010 .708l-4 4a.5.5 0 11-.708-.708L11.793 5.5H1a.5.5 0 010-1h10.793L8.646 1.354a.5.5 0 01-.109-.546z" fill="currentColor">
</svg>

                            Availability
                          </button>
                          <ul class="mobile-facets__list list-unstyled" role="list"><li class="mobile-facets__item list-menu__item">
                                <label
                                  for="Filter-filter.v.availability-mobile-1"
                                  class="mobile-facets__label"
                                >
                                  <input
                                    class="mobile-facets__checkbox"
                                    type="checkbox"
                                    name="filter.v.availability"
                                    value="1"
                                    id="Filter-filter.v.availability-mobile-1"
                                    
                                    
                                  >

                                  <span class="mobile-facets__highlight"></span>

                                  <svg
                                    width="1.6rem"
                                    height="1.6rem"
                                    viewBox="0 0 16 16"
                                    aria-hidden="true"
                                    focusable="false"
                                  >
                                    <rect width="16" height="16" stroke="currentColor" fill="none" stroke-width="1"></rect>
                                  </svg>

                                  <svg
                                    aria-hidden="true"
                                    class="icon icon-checkmark"
                                    width="1.1rem"
                                    height="0.7rem"
                                    viewBox="0 0 11 7"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                  >
                                    <path d="M1.5 3.5L2.83333 4.75L4.16667 6L9.5 1" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                                  </svg>

                                  <span aria-hidden="true">In stock (40)</span>
                                  <span class="visually-hidden">In stock (40 products)</span
                                  >
                                </label>
                              </li><li class="mobile-facets__item list-menu__item">
                                <label
                                  for="Filter-filter.v.availability-mobile-2"
                                  class="mobile-facets__label"
                                >
                                  <input
                                    class="mobile-facets__checkbox"
                                    type="checkbox"
                                    name="filter.v.availability"
                                    value="0"
                                    id="Filter-filter.v.availability-mobile-2"
                                    
                                    
                                  >

                                  <span class="mobile-facets__highlight"></span>

                                  <svg
                                    width="1.6rem"
                                    height="1.6rem"
                                    viewBox="0 0 16 16"
                                    aria-hidden="true"
                                    focusable="false"
                                  >
                                    <rect width="16" height="16" stroke="currentColor" fill="none" stroke-width="1"></rect>
                                  </svg>

                                  <svg
                                    aria-hidden="true"
                                    class="icon icon-checkmark"
                                    width="1.1rem"
                                    height="0.7rem"
                                    viewBox="0 0 11 7"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                  >
                                    <path d="M1.5 3.5L2.83333 4.75L4.16667 6L9.5 1" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                                  </svg>

                                  <span aria-hidden="true">Out of stock (1)</span>
                                  <span class="visually-hidden">Out of stock (1 products)</span
                                  >
                                </label>
                              </li></ul>

                          <div class="no-js-hidden mobile-facets__footer gradient">
                            <facet-remove class="mobile-facets__clear-wrapper">
                              <a href="/collections/all" class="mobile-facets__clear underlined-link">Clear</a>
                            </facet-remove>
                            <button
                              type="button"
                              class="no-js-hidden button button--primary"
                              onclick="this.closest('.mobile-facets__wrapper').querySelector('summary').click()"
                            >
                              Apply
                            </button>
                            
                          </div>
                        </div>
                      </details>
                    

                      <details
                        id="Details-Mobile-2-template--20805846040857__main-collection-product-grid"
                        class="mobile-facets__details js-filter"
                        data-index="mobile-2"
                      >
                        <summary class="mobile-facets__summary focus-inset">
                          <div>
                            <span>Preio</span>
                            <span class="mobile-facets__arrow no-js-hidden"><svg
  viewBox="0 0 14 10"
  fill="none"
  aria-hidden="true"
  focusable="false"
  class="icon icon-arrow"
  xmlns="http://www.w3.org/2000/svg"
>
  <path fill-rule="evenodd" clip-rule="evenodd" d="M8.537.808a.5.5 0 01.817-.162l4 4a.5.5 0 010 .708l-4 4a.5.5 0 11-.708-.708L11.793 5.5H1a.5.5 0 010-1h10.793L8.646 1.354a.5.5 0 01-.109-.546z" fill="currentColor">
</svg>
</span>
                           
                          </div>
                        </summary>
                        <div
                          id="FacetMobile-2-template--20805846040857__main-collection-product-grid"
                          class="mobile-facets__submenu gradient"
                        >
                          <button
                            class="mobile-facets__close-button link link--text focus-inset"
                            aria-expanded="true"
                            type="button"
                          >
                            <svg
  viewBox="0 0 14 10"
  fill="none"
  aria-hidden="true"
  focusable="false"
  class="icon icon-arrow"
  xmlns="http://www.w3.org/2000/svg"
>
  <path fill-rule="evenodd" clip-rule="evenodd" d="M8.537.808a.5.5 0 01.817-.162l4 4a.5.5 0 010 .708l-4 4a.5.5 0 11-.708-.708L11.793 5.5H1a.5.5 0 010-1h10.793L8.646 1.354a.5.5 0 01-.109-.546z" fill="currentColor">
</svg>

                            Price
                          </button><p class="mobile-facets__info">
                            The highest price is $49.99
                          </p>

                          <price-range class="facets__price">
                            <span class="field-currency">$</span>
                            <div class="field">
                              <input
                                class="field__input"
                                name="filter.v.price.gte"
                                id="Mobile-Filter-Price-GTE"type="number"
                                placeholder="0"
                                min="0"
                                inputmode="decimal"max="49.99"
                                
                              >
                              <label class="field__label" for="Mobile-Filter-Price-GTE">From</label>
                            </div>

                            <span class="field-currency">$</span>
                            <div class="field">
                              <input
                                class="field__input"
                                name="filter.v.price.lte"
                                id="Mobile-Filter-Price-LTE"type="number"
                                min="0"
                                inputmode="decimal"placeholder="49.99"
                                  max="49.99"
                                
                              >
                              <label class="field__label" for="Mobile-Filter-Price-LTE">To</label>
                            </div>
                          </price-range>
                          <div class="no-js-hidden mobile-facets__footer">
                            <facet-remove class="mobile-facets__clear-wrapper">
                              <a href="/collections/all" class="mobile-facets__clear underlined-link">Clear</a>
                            </facet-remove>
                            <button
                              type="button"
                              class="no-js-hidden button button--primary"
                              onclick="this.closest('.mobile-facets__wrapper').querySelector('summary').click()"
                            >
                              Apply
                            </button>
                            
                          </div>
                        </div>
                      </details>
                  
<div
                  class="mobile-facets__details js-filter"
                  data-index="mobile-"
                >
                  <div class="mobile-facets__summary">
                    <div class="mobile-facets__sort">
                      <label for="SortBy-mobile">Sort by:</label>
                      <div class="select">
                        <select
                          name="sort_by"
                          class="select__select"
                          id="SortBy-mobile"
                          aria-describedby="a11y-refresh-page-message"
                        ><option
                              value="manual"
                              
                            >
                              Featured
                            </option><option
                              value="best-selling"
                              
                            >
                              Best selling
                            </option><option
                              value="title-ascending"
                              
                                selected="selected"
                              
                            >
                              Alphabetically, A-Z
                            </option><option
                              value="title-descending"
                              
                            >
                              Alphabetically, Z-A
                            </option><option
                              value="price-ascending"
                              
                            >
                              Price, low to high
                            </option><option
                              value="price-descending"
                              
                            >
                              Price, high to low
                            </option><option
                              value="created-ascending"
                              
                            >
                              Date, old to new
                            </option><option
                              value="created-descending"
                              
                            >
                              Date, new to old
                            </option></select>
                        <svg aria-hidden="true" focusable="false" class="icon icon-caret" viewBox="0 0 10 6">
  <path fill-rule="evenodd" clip-rule="evenodd" d="M9.354.646a.5.5 0 00-.708 0L5 4.293 1.354.646a.5.5 0 00-.708.708l4 4a.5.5 0 00.708 0l4-4a.5.5 0 000-.708z" fill="currentColor">
</svg>

                      </div>
                    </div>
                  </div>
                </div><div class="mobile-facets__footer">
                <facet-remove class="mobile-facets__clear-wrapper">
                  <a href="/collections/all" class="mobile-facets__clear underlined-link">Remove all</a>
                </facet-remove>
                <button
                  type="button"
                  class="no-js-hidden button button--primary"
                  onclick="this.closest('.mobile-facets__wrapper').querySelector('summary').click()"
                >
                  Apply
                </button>
                
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
  
<div
    class="product-count light medium-hide large-up-hide"
    role="status"
  >
    <h2 class="product-count__text text-body">
      <span id="ProductCount"><?php ?>
</span>
    </h2>
    <div class="loading-overlay__spinner">
      <svg
        aria-hidden="true"
        focusable="false"
        class="spinner"
        viewBox="0 0 66 66"
        xmlns="http://www.w3.org/2000/svg"
      >
        <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
      </svg>
    </div>
  </div></div>

      </aside>
    <div class="product-grid-container" id="ProductGridContainer"><div class="collection page-width">
            <div class="loading-overlay gradient"></div>

            <ul
              id="product-grid"
              data-id="template--20805846040857__main-collection-product-grid"
              class="
                grid product-grid grid--2-col-tablet-down
                grid--4-col-desktop
              "
            >
                <link rel="stylesheet" href="assets/css/bootstrap.min.css">
               <script src="assets/js/bootstrap.bundle.min.js"></script>
               <script src="assets/js/jquery-1.11.0.min.js"></script>
    <script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
                 <?php
                  if ($categorias){
                      $lista_cat =substr($categorias, 0, -1);
                    }else{
                       $lista_cat="''";    
                    }
                $sql="select * from productos where pagina_web='1' and id_linea_producto in ($lista_cat) or id_linea_producto=$id_categoria";
                           $query = mysqli_query($conexion, $sql);
                           $num_registros = mysqli_num_rows($query);
                           //echo $num_registros, ' Productos';
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
            $precio_normal      = $row['valor4_producto'];
            $stock_producto       = $row['stock_producto'];
            $stock_min_producto   = $row['stock_min_producto'];
            $online   = $row['pagina_web'];
            $status_producto      = $row['estado_producto'];
            $date_added           = date('d/m/Y', strtotime($row['date_added']));
            $image_path           = $row['image_path'];
            $id_imp_producto      = $row['id_imp_producto'];
                           
                ?>
                <li class="grid__item">
                  

<link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-rating.css?v=24573085263941240431693673627" rel="stylesheet" type="text/css" media="all" />
<div class="card-wrapper product-card-wrapper underline-links-hover">
    <div
      class="
        card
        card--card
         card--media
         color-background-1 gradient
        
        
        
      "
      style="--ratio-percent: 100.0%;"
    >
      <div
        class="card__inner  ratio"
        style="--ratio-percent: 100.0%;"
      ><div class="card__media">
            <div class="media media--transparent media--hover-effect">
              
              <img
                srcset="//tiendamiaecu.com/cdn/shop/products/SoportePower_1080x1080px_1080x1080px_1_d7f37024-c770-47aa-8b5a-94dcd3222a4c.png?v=1691115268&width=165 165w,//tiendamiaecu.com/cdn/shop/products/SoportePower_1080x1080px_1080x1080px_1_d7f37024-c770-47aa-8b5a-94dcd3222a4c.png?v=1691115268&width=360 360w,//tiendamiaecu.com/cdn/shop/products/SoportePower_1080x1080px_1080x1080px_1_d7f37024-c770-47aa-8b5a-94dcd3222a4c.png?v=1691115268&width=533 533w,//tiendamiaecu.com/cdn/shop/products/SoportePower_1080x1080px_1080x1080px_1_d7f37024-c770-47aa-8b5a-94dcd3222a4c.png?v=1691115268&width=720 720w,//tiendamiaecu.com/cdn/shop/products/SoportePower_1080x1080px_1080x1080px_1_d7f37024-c770-47aa-8b5a-94dcd3222a4c.png?v=1691115268&width=940 940w,//tiendamiaecu.com/cdn/shop/products/SoportePower_1080x1080px_1080x1080px_1_d7f37024-c770-47aa-8b5a-94dcd3222a4c.png?v=1691115268&width=1066 1066w,//tiendamiaecu.com/cdn/shop/products/SoportePower_1080x1080px_1080x1080px_1_d7f37024-c770-47aa-8b5a-94dcd3222a4c.png?v=1691115268 1080w
                "
                src="//tiendamiaecu.com/cdn/shop/products/SoportePower_1080x1080px_1080x1080px_1_d7f37024-c770-47aa-8b5a-94dcd3222a4c.png?v=1691115268&width=533"
                sizes="(min-width: 1400px) 317px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)"
                alt="BRAZALETE - IRIS™️"
                class="motion-reduce"
                
                width="1080"
                height="1080"
              >
              
</div>
          </div><div class="card__content">
          <div class="card__information">
            <h3
              class="card__heading"
              
            >
              <a
                href="/products/brazalete-magico-iris"
                id="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8525627818265"
                class="full-unstyled-link"
                aria-labelledby="StandardCardNoMediaLink-template--20805846040857__main-collection-product-grid-8525627818265 NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8525627818265"
              >
                BRAZALETE - IRIS™️
              </a>
            </h3>
          </div>
          <div class="card__badge bottom left"><span
                id="NoMediaStandardBadge-template--20805846040857__main-collection-product-grid-8525627818265"
                class="badge badge--bottom-left color-accent-2"
              >
                
                
                <svg
  aria-hidden="true"
  focusable="false"
  class="icon icon-discount color-foreground-text"
  viewBox="0 0 12 12"
>
  <path fill-rule="evenodd" clip-rule="evenodd" d="M7 0h3a2 2 0 012 2v3a1 1 0 01-.3.7l-6 6a1 1 0 01-1.4 0l-4-4a1 1 0 010-1.4l6-6A1 1 0 017 0zm2 2a1 1 0 102 0 1 1 0 00-2 0z" fill="currentColor">
</svg>
 <span class='nowrap'>AHORRA UN 50%</span>
              </span></div>
        </div>
      </div>
      <div class="card__content">
        <div class="card__information">
          <h3
            class="card__heading h5"
            
              id="title-template--20805846040857__main-collection-product-grid-8525627818265"
            
          >
            <a
              href="/products/brazalete-magico-iris"
              id="CardLink-template--20805846040857__main-collection-product-grid-8525627818265"
              class="full-unstyled-link"
              aria-labelledby="CardLink-template--20805846040857__main-collection-product-grid-8525627818265 Badge-template--20805846040857__main-collection-product-grid-8525627818265"
            >
              BRAZALETE - IRIS™️
            </a>
          </h3>
                            

          <div class="card-information">
              <span class="caption-large light"></span>
<div
  class="
    price  price--on-sale "
>
  <div class="price__container"><div class="price__regular">
      <span class="visually-hidden visually-hidden--inline">Regular price</span>
      <span class="price-item price-item--regular">
        $29.99
      </span>
    </div>
    <div class="price__sale ">
      <span class="visually-hidden visually-hidden--inline regular-price-label">Precio Normal</span>
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
          <div class="quick-add no-js-hidden">
              </div>
          <a style="z-index:1000; height: 40px; font-size: 16px" class="btn boton text-white mt-2" href="#" onclick="agregar_tmp(<?php  echo $id_producto;?>, <?php  echo $precio_especial;?>)"   data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-cart-plus"></i><span>COMPRAR </span></a><!-- comment -->
      </div>
    </div>
  </div>
                </li>
                <?php
                           }
                           ?>

                
               


</ul>



</div></div>
  </div>
</div>


</div><section id="shopify-section-template--20805846040857__newsletter" class="shopify-section section"><link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-newsletter.css?v=180884587654672216131693673627" rel="stylesheet" type="text/css" media="all" />
<link href="//tiendamiaecu.com/cdn/shop/t/3/assets/newsletter-section.css?v=62410470717655853621693673628" rel="stylesheet" type="text/css" media="all" />
<link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-rte.css?v=73443491922477598101693673627" rel="stylesheet" type="text/css" media="all" />
<style data-shopify>.section-template--20805846040857__newsletter-padding {
    padding-top: 51px;
    padding-bottom: 39px;
  }

  @media screen and (min-width: 750px) {
    .section-template--20805846040857__newsletter-padding {
      padding-top: 68px;
      padding-bottom: 52px;
    }
  }</style><div class="newsletter center ">
  <div class="newsletter__wrapper color-background-2 gradient content-container isolate content-container--full-width section-template--20805846040857__newsletter-padding"><h2 class="h1" >
            Subscribe to our emails
          </h2><div class="newsletter__subheading rte" ><p>Join our email list for exclusive offers and the latest news. </p></div><div >
            <form method="post" action="/contact#contact_form" id="contact_form" accept-charset="UTF-8" class="newsletter-form"><input type="hidden" name="form_type" value="customer" /><input type="hidden" name="utf8" value="✓" />
              <input type="hidden" name="contact[tags]" value="newsletter">
              <div class="newsletter-form__field-wrapper">
                <div class="field">
                  <input
                    id="NewsletterForm--template--20805846040857__newsletter"
                    type="email"
                    name="contact[email]"
                    class="field__input"
                    value=""
                    aria-required="true"
                    autocorrect="off"
                    autocapitalize="off"
                    autocomplete="email"
                    
                    placeholder="Email"
                    required
                  >
                  <label class="field__label" for="NewsletterForm--template--20805846040857__newsletter">
                    Email
                  </label>
                  
                </div>
                
                  <button
                    type="submit"
                    class="button newsletter__solid-btn button--full-width"
                    name="commit"
                    id="Subscribe"
                    aria-label="Subscribe"
                  >
                    Sign up
                  </button>
                
</div></form>
          </div></div>
</div>


</section>
    </main>

    <div id="shopify-section-promo-popup" class="shopify-section"><link href="//tiendamiaecu.com/cdn/shop/t/3/assets/section-promo-popup.css?v=175993886525155844911693673629" rel="stylesheet" type="text/css" media="all" />
<link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-newsletter.css?v=180884587654672216131693673627" rel="stylesheet" type="text/css" media="all" />
<link href="//tiendamiaecu.com/cdn/shop/t/3/assets/newsletter-section.css?v=62410470717655853621693673628" rel="stylesheet" type="text/css" media="all" />
<link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-rte.css?v=73443491922477598101693673627" rel="stylesheet" type="text/css" media="all" />

</div>
    <div id="shopify-section-scroll-to-top-btn" class="shopify-section"><style data-shopify>
  .scroll-to-top-btn-scroll-to-top-btn {
    --offset-x: 20px;
    --offset-y: 20px;
  }
</style>




</div>
    <div id="shopify-section-global-music-player" class="shopify-section"><style data-shopify>
  .music-player-global-music-player {
    --offset-x: 20px;
    --offset-y: 20px;
  }
</style>




</div>
 <?php

        include 'modal/comprar.php';
      
   
    ?>
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

<!-- <link href="//tiendamiaecu.com/cdn/shop/t/3/assets/component-card.css?v=171622893807557687511693673627" rel="stylesheet" type="text/css" media="all" /> --><style data-shopify>.footer {
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
  }</style>

<?php
   include 'includes/footer.php';
?>



</div>
<!-- END sections: footer-group -->

    <ul hidden>
      <li id="a11y-refresh-page-message">Choosing a selection results in a full page refresh.</li>
      <li id="a11y-new-window-message">Opens in a new window.</li>
    </ul>


    <script>
        
   
    function cargar(){
            var sesion=$("#session").val()
          //  alert(sesion)
    $.ajax({
        type: "POST",
        url: "ajax/agregar_tmp_modalventas.php",
        data: "sesion="+sesion,
        beforeSend: function(objeto) {
            $("#resultados").html('<img src="../../img/ajax-loader.gif"> Cargando...');
           // total = $("#total_c").val();
            //$("#q").val();
           // alert(total)
            
        },
        success: function(datos) {
           // alert(datos)
            $("#resultados").html(datos);
        }
    });
    }
function agregar_tmp(id, precio_venta){
           
   
   
   cantidad=1;
    //Fin validacion
    // alert(id);
    sesion=$("#session").val()
    $.ajax({
        type: "POST",
        url: "ajax/agregar_tmp_modalventas.php",
        data: "id=" + id + "&precio_venta=" + precio_venta + "&cantidad=" + cantidad + "&operacion=" + 2+ "&sesion="+sesion,
        beforeSend: function(objeto) {
            $("#resultados").html('<img src="../../img/ajax-loader.gif"> Cargando...');
           // total = $("#total_c").val();
            //$("#q").val();
           // alert(total)
            
        },
        success: function(datos) {
           // alert(datos)
            $("#resultados").html(datos);
        }
    });
        }
        
         
        </script>
    
  
  <!-- "snippets/revy-bundle-script.liquid" was not rendered, the associated app was uninstalled -->
  
</body>
</html>
