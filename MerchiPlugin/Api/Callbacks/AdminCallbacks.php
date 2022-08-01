<?php declare(strict_types=1);
/**
 * @package  MerchiPlugin
 */

namespace MerchiPlugin\Api\Callbacks;

use MerchiPlugin\Base\BaseController;

class AdminCallbacks extends BaseController {


	public function adminDashboard() {
		return require_once( "$this->plugin_path/templates/admin.php" );
	}


	public function adminCpt() {
		return require_once( "$this->plugin_path/templates/cpt.php" );
	}


	public function merchiOptionsGroup( $input ) {
		return $input;
	}


	public function merchiAdminSection() {
		echo 'Update your Merchi settings';
	}


	// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
	public function merchiStoreUrl() {
		$value = esc_attr( get_option( 'merchi_url' ) );
		echo '<input type="text" class="regular-text" name="merchi_url" value="' . $value . '" placeholder="00">';
	}

        public function merchiApiSecret() {
		$value = esc_attr( get_option( 'merchi_api_secret' ) );
		echo '<input type="password" class="regular-text" name="merchi_api_secret" value="' . $value . '" placeholder="xxxxx">';
        }

	// public function wooSecret() {
		// $value = esc_attr( get_option( 'woo_k_s' ) );
		// echo '<input type="password" class="regular-text" name="woo_k_s" value="' . $value . '" placeholder="cs_xxxxxxxxxxxxxx">';
	// }

	// public function wooPublic() {
		// $value = esc_attr( get_option( 'woo_k_p' ) );
		// echo '<input type="text" class="regular-text" name="woo_k_p" value="' . $value . '" placeholder="ck_xxxxxxxxxxxxxx">';
	// }


	public function merchiMountPointId() {
		$value = esc_attr( get_option( 'merchi_mount_point_id' ) );
		echo '<input type="text" class="regular-text" name="merchi_mount_point_id" value="' . $value . '" placeholder="example_class">';
	}

	public function merchiRedirectURL() {
		$value = esc_attr( get_option( 'merchi_redirect_url' ) );
		echo '<input type="text" class="regular-text" name="merchi_redirect_url" value="' . $value . '" placeholder="https://example.com/success">';
	}



	// phpcs:enable
}
