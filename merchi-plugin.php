<?php declare(strict_types = 1);
/**
 * Plugin Name:       Merchi Plugin
 * Plugin URI:        https://merchi.co
 * Description:       Fetch your products from Merchi. This plugin requires Woocommerce.
 * Version:           1.2
 * Author:            Charlie Campton
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package MerchiPlugin
 */

// If this file is called directly, exit.
if (! defined( 'ABSPATH' )) {
	exit;
}

// Require Composer Autoload.
if (file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' )) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

// Code that runs on activation.
function activate_merchi_plugin() {
	$my_account = get_page_by_path( 'my-account' );
	if (isset( $my_account )) {
			   wp_delete_post( $my_account->ID );
	}

			  flush_rewrite_rules();

}


register_activation_hook( __FILE__, 'activate_merchi_plugin' );


function deactivate_merchi_plugin() {
	flush_rewrite_rules();

}


register_activation_hook( __FILE__, 'deactivate_merchi_plugin' );

// Initialise all core classes of the plugin.
require_once( "MerchiPlugin/init.php" );
if (class_exists( 'MerchiPlugin\\Init' )) {
	MerchiPlugin\Init::register_services();
}

// Deactivate purchasing on woocommerce.
add_filter( 'woocommerce_widget_cart_is_hidden', '__return_true' );
add_filter( 'woocommerce_is_purchasable', '__return_false' );
