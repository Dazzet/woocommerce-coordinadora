<?php namespace WcCoordinadora;

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

$params =  WebService\RequestParameter::instance()
    ->set('nit', $settings->option('client_id'))
    ->set('div', $settings->option('client_dif'))
    ->set('referencia', '')
    ->set('imagen', 1)
    ->set('anexo', 1)
    ->set('apikey', $settings->option('api_key'))
    ->set('clave', $settings->option('api_pass'));
//    ->set('codigo_remision', '8787878')

Wordpress\OrderMyAccount::instance($ags, $params)->start();

