<?php
/**
 * @package MerchiPlugin
 */

namespace Inc\ShoppingCart;

use \Inc\Base\BaseController;

class ShoppingCartInject extends BaseController
{
    public function register()
    {
        // Inject Merchi cart into navigation
        add_action('wp_body_open', array( $this, 'inject_merchi_cart'), 98 );
    }

    public function inject_merchi_cart()
    {
        $id = get_option("merchi_url");
        $mountPoint = get_option("merchi_mount_point_id");
        $menuHider = "<script type='text/javascript'>
document.addEventListener('DOMContentLoaded', function(event) {
  const mountpoint = document.getElementsByClassName('$mountPoint')[0];
  const script = document.createElement('script')
  script.src =
   'https://merchi.co/static/js/dist/load-component.js?component=RemoteShoppingCart&mountpointClass=$mountPoint&onload=merchiComponentLoaded&props={\"storeId\":$id, \"includeModalCss\":true, \"showOpenCartButton\": true, \"cartButtonWrappedInContainer\": true, \"includeBootstrap\": true}';
  function merchiComponentLoaded() {
    // hidden by css, needs to be shown on load
    mountpoint.style.visibility = 'visible';
  }
  document.body.appendChild(script);
});
</script>";
        echo $menuHider;

    }
}
