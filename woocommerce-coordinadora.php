<?php namespace WcCoordinadora;

/**
 * Plugin Name: Coordinadora Mercantil WooCommerce Shipping Method
 * Plugin URI: https://dazzet.co
 * Description: Coordinadora Shipping Method Plugin for Woocommerce
 * Version: 1.0
 * Author: Mario Yepes <marioy47@gmail.com>
 * Text Domain: wc-coordinadora
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

include_once __DIR__ . '/vendor/autoload.php';

add_action('init', function() {
    load_plugin_textdomain(
        'wc-coordinadora',
        false,
        dirname( plugin_basename(__FILE__)) . '/languages'
    );
});

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), function($links) {
   $links[] = '<a href="'. esc_url( get_admin_url(null, 'admin.php?page=wc-settings&tab=wc-coordinadora') ) .'">'.__('Settings').'</a>';
   return $links;
});


// Create new tab Woocommerce Settings page
$settings = Wordpress\Settings::instance()->start();

// Initialize Order meta box
Wordpress\OrderAdmin::instance()->start();

// if its the order page track order
$client = new \SoapClient( $settings->option('api_tracking_wsdl'), array('trace' => 1));

$ags = Webservice\Ags::instance($client)->start();

$params =  Webservice\RequestParameter::instance()
    ->set('nit', $settings->option('client_id'))
    ->set('div', $settings->option('client_div'))
    ->set('referencia', '')
    ->set('imagen', 1)
    ->set('anexo', 1)
    ->set('apikey', $settings->option('api_key'))
    ->set('clave', $settings->option('api_pass'));
//    ->set('codigo_remision', '8787878')

Wordpress\OrderMyAccount::instance($ags, $params)->start();

