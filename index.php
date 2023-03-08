<?php
/**
 * Plugin Name:       FSD API Key Demo
 * Plugin URI:        https://fullstackdigital.io
 * Description:       A plugin starter with encrypted API key functionality for WordPress
 * Version:           0.1.0
 * Requires at least: 5.9
 * Requires PHP:      7.2
 * Author:            Full Stack Digital
 * Author URI:        https://fullstackdigital.io
 * Text Domain:       fsdapikey
 */

if(!function_exists('add_action')) {
  echo 'Seems like you stumbled here by accident. 😛';
  exit;
}

// Setup
define('FSDAPIKEY_DIR', plugin_dir_path(__FILE__));
define('FSDAPIKEY_FILE', __FILE__);

// Includes
$rootFiles = glob(FSDAPIKEY_DIR . 'includes/*.php');
$subdirectoryFiles = glob(FSDAPIKEY_DIR . 'includes/**/*.php');
$allFiles = array_merge($rootFiles, $subdirectoryFiles);

foreach($allFiles as $filename) {
  include_once($filename);
}

// Hooks

add_action('admin_menu', 'fsdapikey_register_my_api_keys_page');


// API Endpoint
add_action('rest_api_init', function () {
  register_rest_route( 'fsd/v1', '/fetch-external-api', array(
      'methods' => 'POST',
      'callback' => 'fsdapikey_fetch_external_api_data',
      'permission_callback' => function(){
        return current_user_can( 'edit_posts' );
      }
  ));
});
