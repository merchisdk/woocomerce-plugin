<?php declare(strict_types=1);
/**
 * @package MerchiPlugin
 */

namespace MerchiPlugin\PublicPages;

use \MerchiPlugin\Base\BaseController;

class ProductPage extends BaseController {


	public function register() {
		// Inject Merchi product into product page.
		add_filter( 'woocommerce_single_product_summary', [ $this, 'inject_merchi_product' ], 98 );
		// Remove product content based on category
		add_action( 'wp', [ $this, 'remove_product_content' ] );
	}


	public function inject_merchi_product() {
		global $product;
		// SKU used as Merchi ID. We are checking to see if Merchi ID exists. If so fetch Merchi product.
		if ($product->get_sku() !== '') {
			$id      = $product->get_sku();
			$content = '<script type="text/javascript" data-name="product-embed" src="https://merchi.co//static/product_embed/js/product.embed.js?product=' . $id . '&hidePreview=true&hideTitle=true&hideInfo=true&hidePrice=true&includeBootstrap=false&singleColumn=true"></script>';
			echo $content;
		} else {
			echo 'Merchi product not found.';
		}
	}


	public function remove_product_content() {
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
		remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
		remove_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
		remove_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
		remove_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
		remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 );
		remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
	}


}
