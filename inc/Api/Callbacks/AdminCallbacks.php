<?php 
/**
 * @package  MerchiPlugin
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class AdminCallbacks extends BaseController
{
	public function adminDashboard()
	{
		return require_once( "$this->plugin_path/templates/admin.php" );
	}

	public function adminCpt()
	{
		return require_once( "$this->plugin_path/templates/cpt.php" );
	}

	public function merchiOptionsGroup( $input )
	{
		return $input;
	}

	public function merchiAdminSection()
	{
		echo 'Update your Merchi settings';
	}

	public function merchiStoreUrl()
	{
		$value = esc_attr( get_option( 'merchi_url' ) );
		echo '<input type="text" class="regular-text" name="merchi_url" value="' . $value . '" placeholder="00">';
	}

	public function wooSecret()
	{
		$value = esc_attr( get_option( 'woo_k_s' ) );
		echo '<input type="password" class="regular-text" name="woo_k_s" value="' . $value . '" placeholder="cs_xxxxxxxxxxxxxx">';
    }
    
    public function wooPublic()
	{
		$value = esc_attr( get_option( 'woo_k_p' ) );
		echo '<input type="text" class="regular-text" name="woo_k_p" value="' . $value . '" placeholder="ck_xxxxxxxxxxxxxx">';
	}

	public function merchiMountPointId()
	{
		$value = esc_attr( get_option( 'merchi_mount_point_id' ) );
		echo '<input type="text" class="regular-text" name="merchi_mount_point_id" value="' . $value . '" placeholder="example_class">';
	}
}
