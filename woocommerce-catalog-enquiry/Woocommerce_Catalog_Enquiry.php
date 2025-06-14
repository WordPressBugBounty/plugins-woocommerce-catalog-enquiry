<?php
/**
 * Plugin Name: CatalogX - Product Catalog Mode For WooCommerce
 * Plugin URI: https://catalogx.com/
 * Description: Convert your WooCommerce store into a catalog website in a click
 * Author: MultiVendorX
 * Version: 6.0.6
 * Author URI: https://catalogx.com/
 * WC requires at least: 8.2
 * WC tested up to: 9.8.5
 * Text Domain: catalogx
 * Domain Path: /languages/
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

require_once trailingslashit(dirname(__FILE__)).'config.php';
require_once __DIR__ . '/vendor/autoload.php';

function CatalogX() {
    return \CatalogX\CatalogX::init(__FILE__);
}

CatalogX();
