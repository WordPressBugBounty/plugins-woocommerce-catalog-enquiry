<?php 

namespace CatalogX\Catalog;

/**
 * CatalogX Catalog Module Util class
 *
 * @class 		Util class
 * @version		6.0.0
 * @author 		MultivendorX
 */
class Util {

    /**
     * Check catalog functionlity available for current user
     * @return bool
     */
    public static function is_available() {
        // Get the current user
        $current_user = wp_get_current_user();

        // Get exclusion setting
        $catalog_exclusion_setting = CatalogX()->setting->get_option( 'catalogx_enquiry-quote-exclusion_settings', [] );

        // Get userroll exclusion settings
        $userroles_exclusion_settings = isset($catalog_exclusion_setting['catalog_exclusion_userroles_list']) ? $catalog_exclusion_setting[ 'catalog_exclusion_userroles_list' ] : [];
        
        // Get excluded user roles
        $exclude_user_roles = array_map( function( $userrole ) {
            return $userrole[ 'key' ];
        }, $userroles_exclusion_settings );

        // Check current user's role is in exclude user roles
        if ( array_intersect( $exclude_user_roles, $current_user->roles ) ) {
            return false;
        }
        
        // Get user exclusion settings
        $userlist_exclusion_settings = isset($catalog_exclusion_setting['catalog_exclusion_user_list']) ? $catalog_exclusion_setting[ 'catalog_exclusion_user_list' ] : [];

        // Get excluded user ids
        $exclude_user_ids = array_map( function( $userid ) {
            return $userid[ 'key' ];
        }, $userlist_exclusion_settings );

        // Check current user's id is in exclude user id
        if ( in_array( $current_user->ID, $exclude_user_ids ) ) {
            return false;
        }

        return true;
    }

    /**
     * Check catalog functionlity available for product
     * @return bool
     */
    public static function is_available_for_product($product_id) {
        // Get exclusion setting
        $catalog_exclusion_setting = CatalogX()->setting->get_option( 'catalogx_enquiry-quote-exclusion_settings', [] );

        // Get product exclusion settings
        $product_exclusion_settings = isset($catalog_exclusion_setting['catalog_exclusion_product_list']) ? $catalog_exclusion_setting['catalog_exclusion_product_list'] : [];
        
        // Get excluded products
        $exclude_products = array_map( function( $product ) {
            return $product[ 'key' ];
        }, $product_exclusion_settings );

        
        // Check current product id is in exclude products
        if ( in_array( $product_id, $exclude_products ) ) {
            return false;
        }

        // Get category exclusion settings
        $category_exclusion_settings = isset($catalog_exclusion_setting['catalog_exclusion_category_list']) ? $catalog_exclusion_setting['catalog_exclusion_category_list'] : [];
        
        // Get excluded category
        $exclude_categories = array_filter(array_map(function($category) use ($product_id) {
            $term_list = wp_get_post_terms($product_id, 'product_cat', ['fields' => 'ids']);
            return $category['key'] == $term_list[0] ? $product_id : null;
        }, $category_exclusion_settings));
        
        // Check current product id is in exclude categories
        if ( in_array( $product_id, $exclude_categories ) ) {
            return false;
        }

        // Get tag exclusion settings
        $tag_exclusion_settings = isset($catalog_exclusion_setting['catalog_exclusion_tag_list']) ? $catalog_exclusion_setting['catalog_exclusion_tag_list'] : [];
        
        // Get excluded tag
        $exclude_tags = array_filter(array_map( function( $tag ) use ($product_id) {
            $tag_term_list = wp_get_post_terms($product_id,'product_tag',['fields'=>'ids']);
            return $tag[ 'key' ] == (!empty($tag_term_list) && $tag_term_list[0]) ? $product_id : null;
        }, $tag_exclusion_settings ));

        // Check current product id is in exclude tags
        if ( in_array( $product_id, $exclude_tags ) ) {
            return false;
        }
        return true;
    }

}