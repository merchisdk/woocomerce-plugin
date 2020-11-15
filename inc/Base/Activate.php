<?php
/**
 * @package MerchiPlugin
 */

namespace Inc\Base;

class Activate
{
    public static function activate() {
        // check to see if my-account page exists and delete it
        $my_account = get_page_by_path( 'my-account' );
        if (isset($my_account)) {
            wp_delete_post($my_account->ID);
        }
        flush_rewrite_rules();
    }
}
