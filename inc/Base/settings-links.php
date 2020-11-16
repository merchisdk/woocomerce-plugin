<?php declare(strict_types=1);
/**
 * @package MerchiPlugin
 */

namespace Inc\Base;

use \Inc\Base\BaseController;

class SettingsLinks extends BaseController {


	public function register() {
		add_filter( "plugin_action_links_$this->plugin", [ $this, 'settings_link' ] );
	}


	public function settings_link( $links ) {
		$link_to_settings = '<a href="admin.php?page=merchi_plugin">Settings</a>';
		array_push( $links, $link_to_settings );
		return $links;
	}
}
