<?php declare(strict_types=1);
/**
 * @package MerchiPlugin
 */

namespace MerchiPlugin\ShoppingCart;

use \MerchiPlugin\Base\BaseController;

class ShoppingCartInject extends BaseController {


	public function register() {
		// Inject Merchi cart into navigation
		add_action( 'wp_body_open', [ $this, 'inject_merchi_cart' ], 98 );
	}


	public function inject_merchi_cart() {
		$id          = get_option( 'merchi_url' );
		$mount_point = get_option( 'merchi_mount_point_id' );
		$menu_hider  = "<script type='text/javascript'>
document.addEventListener('DOMContentLoaded', function(event) {
  const mountpoint = document.getElementsByClassName('$mount_point')[0];
  const script = document.createElement('script')
  script.src =
   'https://merchi.co/static/js/dist/load-component.js?component=RemoteShoppingCart&mountpointClass=$mount_point&onload=merchiComponentLoaded&props={\"storeId\":$id, \"includeModalCss\":true, \"showOpenCartButton\": true, \"cartButtonWrappedInContainer\": true, \"includeBootstrap\": true}';
  function merchiComponentLoaded() {
    // hidden by css, needs to be shown on load
    mountpoint.style.visibility = 'visible';
  }
  document.body.appendChild(script);
});
</script>";
		echo $menu_hider;

	}
}
