<?php

namespace CatalogX;

defined( 'ABSPATH' ) || exit;

/**
 * CatalogX Block class
 *
 * @class 		Block class
 * @version		6.0.0
 * @author 		MultivendorX
 */
class Block {
    private $blocks;

    public function __construct() {
        $this->blocks = $this->initialize_blocks();
        // Register block category
        add_filter( 'block_categories_all', [$this, 'register_block_category'] );
        // Register the block
        add_action( 'init', [$this, 'register_blocks'] );
        // Localize the script for block
        add_action( 'enqueue_block_assets', [ $this,'enqueue_all_block_assets'] );

    }
    
    public function initialize_blocks() {
        $blocks = [];

        if (CatalogX()->modules->is_active('enquiry')) {
            $blocks[] = [
                'name' => 'enquiry-button', // block name
                'textdomain' => 'catalogx',
                'block_path' => CatalogX()->plugin_path . 'build/blocks/',
            ];

            //this path is set for load the translation   
            CatalogX()->block_paths += [
                'blocks/enquiry-button' => 'build/blocks/enquiry-button/index.js',
                'blocks/enquiryForm' => 'build/blocks/enquiryForm/index.js',
            ];
        }

        if (CatalogX()->modules->is_active('quote')) {
            $blocks[] = [
                'name' => 'quote-button', // block name
                'textdomain' => 'catalogx',
                'block_path' => CatalogX()->plugin_path . 'build/blocks/',
            ];

            $blocks[] =  [
                'name' => 'quote-cart', // block name
                'textdomain' => 'catalogx',
                'block_path' => CatalogX()->plugin_path . 'build/blocks/',
            ];

            //this path is set for load the translation
            CatalogX()->block_paths += [
                'blocks/quote-cart' => 'build/blocks/quote-cart/index.js',
                'blocks/quote-button' => 'build/blocks/quote-button/index.js',
            ];            
        }

        return apply_filters('catalogx_initialize_blocks', $blocks);
    }

    public function enqueue_all_block_assets() {
        FrontendScripts::load_scripts();
        foreach ($this->blocks as $block_script) {
            FrontendScripts::localize_scripts($block_script['textdomain'] . '-' . $block_script['name'] . '-editor-script');
            FrontendScripts::localize_scripts($block_script['textdomain'] . '-' . $block_script['name'] . '-script');
        }
    }

    public function register_block_category($categories) {
        // Adding a new category.
        $categories[] = [
            'slug'  => 'catalogx',
            'title' => 'CatalogX'
        ];
        return $categories;
    }
    
    public function register_blocks() {
        foreach ($this->blocks as $block) {
            register_block_type( $block['block_path'] . $block['name']);
        }
    }
    
}