<?php

namespace CatalogX;

/**
 * CatalogX Shortcode class
 *
 * @class 		Shortcode class
 * @version		6.0.0
 * @author 		MultivendorX
 */
class Shortcode {
    /**
     * Shortcode class construct function
     */
    public function __construct() {
        //For quote page
        add_shortcode( 'catalogx_request_quote', [ $this, 'display_request_quote' ] );
    }

    public function frontend_scripts() {
        if (CatalogX()->modules->is_active('quote')) {
            FrontendScripts::load_scripts();
            FrontendScripts::localize_scripts('catalogx-quote-cart-script');
            FrontendScripts::enqueue_script('catalogx-quote-cart-script' );
            FrontendScripts::enqueue_style('catalogx-quote-cart-style');
        }
    }

    public function display_request_quote() {
        $this->frontend_scripts();
        ob_start();
        ?>
        <div id="request-quote-list">
        </div>
        <?php
        return ob_get_clean();
    }
    
} 