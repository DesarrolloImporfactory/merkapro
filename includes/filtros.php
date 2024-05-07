<div class="facets-container"><facet-filters-form class="facets small-hide">
      <form
        id="FacetFiltersForm"
        class="facets__form"
      >
          
          
          
<!--div class="active-facets active-facets-desktop">


<facet-remove class="active-facets__button-wrapper">
                <a href="/collections/all" class="active-facets__button-remove underlined-link">
                  <span>Remove all</span>
                </a>
              </facet-remove>
            </div-->

        

<!--div class="facet-filters sorting caption">
              <div class="facet-filters__field">
                <h2 class="facet-filters__label caption-large text-body">
                  <label for="SortBy">Sort by:</label>
                </h2>
                <div class="select"><select
                    name="sort_by"
                    class="facet-filters__sort select__select caption-large"
                    id="SortBy"
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

              <noscript>
                <button type="submit" class="facets__button-no-js button button--secondary">
                  Sort
                </button>
              </noscript>
            </div--><div class="product-count light" role="status">
            <h2 class="product-count__text text-body">
              <span id="ProductCountDesktop">
                  
                  <?php
                  if (isset($_GET['id_cat'])){
                      $sql="select * from productos where pagina_web='1' and id_linea_producto='$id_categoria'";
                  }else{
                      $sql="select * from productos where pagina_web='1'";
                  }
                
                           $query = mysqli_query($conexion, $sql);
                           $num_registros = mysqli_num_rows($query);
                           echo $num_registros, ' Productos';
                           while ($row = mysqli_fetch_array($query)) {
                           }
                           
                ?>
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
          </div></form>
    </facet-filters-form>