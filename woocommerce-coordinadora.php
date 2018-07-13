<?php namespace WCCoordinadora;

/**
 * Plugin Name: Woocommerce Coordinadora
 * Plugin URI: https://dazzet.co
 * Description: Package tracking from Coordinadora Mercantil in Colombia
 * Version: 0.1
 * Author: Mario Yepes <mario.yepes@dazzet.co>
 * Text Domain: wc-coordinadora
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

include_once __DIR__ . '/lib/autoload.php';

add_action('init', function() {
    load_plugin_textdomain(
        'wc-coordinadora',
        false,
        dirname( plugin_basename(__FILE__)) . '/languages'
    );
});


// Create new tab Woocommerce Settings page
//Wordpress\Settings::instance()->start();

// Initialize Order meta box
Wordpress\OrderAdmin::instance()->start();

// if its the order page track order
Wordpress\OrderMyAccount::instance()->start();




