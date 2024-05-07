
<cart-drawer class="drawer is-empty">
  <div id="CartDrawer" class="cart-drawer">
    <div id="CartDrawer-Overlay" class="cart-drawer__overlay"></div>
    <div
      class="drawer__inner"
      role="dialog"
      aria-modal="true"
      aria-label="Your cart"
      tabindex="-1"
    ><div class="drawer__inner-empty">
          <div class="cart-drawer__warnings center">
            <div class="cart-drawer__empty-content">
              <h2 class="cart__empty-text">Your cart is empty</h2>
              <button
                class="drawer__close"
                type="button"
                onclick="this.closest('cart-drawer').close()"
                aria-label="Close"
              >
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
              <a href="/collections/all" class="button">
                Continue shopping
              </a></div>
          </div></div><div class="drawer__header">
        <h2 class="drawer__heading">Your cart</h2>
        <button
          class="drawer__close"
          type="button"
          onclick="this.closest('cart-drawer').close()"
          aria-label="Close"
        >
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
      
      <div class="cart-drawer-items-and-upsell">
        <cart-drawer-items
          
            class=" is-empty"
          
        >
          <form
            action="/cart"
            id="CartDrawer-Form"
            class="cart__contents cart-drawer__form"
            method="post"
          >
            <div id="CartDrawer-CartItems" class="drawer__contents js-contents"><p id="CartDrawer-LiveRegionText" class="visually-hidden" role="status"></p>
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

        <div class="cart-drawer__footer" >
          <div class="totals" role="status">
            <h2 class="totals__subtotal">Subtotal</h2>
            <p class="totals__subtotal-value">$0.00 USD</p>
          </div>

          <div></div>
        </div>

        <!-- CTAs -->

        <div class="cart__ctas" >
          <noscript>
            <button type="submit" class="cart__update-button button button--secondary" form="CartDrawer-Form">
              Update
            </button>
          </noscript>

          <button
            type="submit"
            id="CartDrawer-Checkout"
            class="cart__checkout-button button"
            name="checkout"
            form="CartDrawer-Form"
            
              disabled
            
          >
            Check out
          </button>
        </div>

        
        
      </div>
    </div>
  </div>
</cart-drawer>
