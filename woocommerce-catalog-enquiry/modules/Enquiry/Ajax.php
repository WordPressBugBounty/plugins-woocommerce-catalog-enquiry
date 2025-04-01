<?php

namespace CatalogX\Enquiry;

/**
 * CatalogX Enquiry Module Ajax class
 *
 * @class 		Ajax class
 * @version		6.0.0
 * @author 		MultivendorX
 */
class Ajax{
    /**
     * Ajax class constructor function.
     */
    public function __construct() {
        add_action( 'wp_ajax_add_variation_for_enquiry_mail', [ $this, 'add_variation_for_enquiry_mail' ] );
		add_action( 'wp_ajax_nopriv_add_variation_for_enquiry_mail', [ $this, 'add_variation_for_enquiry_mail' ] );
    }

    public function add_variation_for_enquiry_mail() {
        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
    
        if ($product_id) {
            if (get_transient('variation_list')) {
                delete_transient('variation_list');
            }
    
            $variation_data = filter_input(INPUT_POST, 'variation_data', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            set_transient('variation_list', $variation_data, 30 * MINUTE_IN_SECONDS);
        }
    
        die;
    }
    
}