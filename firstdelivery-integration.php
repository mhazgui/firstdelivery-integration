<?php
/*
Plugin Name: First Delivery Integration
Description: Integrates First Delivery Group API with WordPress.
Version: 1.0
Author: Your Name
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

// Define constants
define('FDG_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('FDG_PLUGIN_URL', plugin_dir_url(__FILE__));
define('FDG_API_BASE_URL', 'https://www.firstdeliverygroup.com/api/v2');
define('FDG_API_KEY', 'your_api_key_here');

// Include the necessary files
require_once FDG_PLUGIN_DIR . 'includes/class-fdg-api.php';
require_once FDG_PLUGIN_DIR . 'includes/class-fdg-admin.php';

// Initialize plugin functionalities
function fdg_initialize_plugin() {
    new FDG_Admin();
}
add_action('plugins_loaded', 'fdg_initialize_plugin');
