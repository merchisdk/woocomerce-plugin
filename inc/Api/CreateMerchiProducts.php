<?php
/**
 * @package MerchiPlugin
 */
namespace Inc\Api;

use \Inc\Base\BaseController;
use Automattic\WooCommerce\Client;
use Automattic\WooCommerce\HttpClient\HttpClientException;

class CreateMerchiProducts extends BaseController
{
    
    public function register()
    {
        add_action( "wp_ajax_create_merchi_products", array( $this, "create_merchi_products" ) );
    }
    function create_merchi_products() 
    {
        $woocommerce = new Client(
            get_option("siteurl"),
            get_option("woo_k_p"),  
            get_option("woo_k_s"),
            [
                'version' => 'wc/v3',
                'debug'           => true,
                'validate_url'    => false,
                'timeout'         => 60,
                'ssl_verify'      => false,
            ]
        );

        try {
            $woocommerce->post('products/batch', $_POST['products']);
        } catch (HttpClientException $e) {
            echo $e;
        }
    }
}
