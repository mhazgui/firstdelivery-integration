<?php
/*
Plugin Name: First Delivery Integration
Description: Integrates First Delivery Group API with WordPress.
Version: 1.0
Author: Your Name
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

define('FIRSTDELIVERY_API_KEY', 'your_api_key_here');
define('FIRSTDELIVERY_API_BASE_URL', 'https://www.firstdeliverygroup.com/api/v2');

// Function to make GET requests to the API
function fdg_api_get_request($endpoint) {
    $url = FIRSTDELIVERY_API_BASE_URL . $endpoint;

    $response = wp_remote_get($url, array(
        'headers' => array(
            'Authorization' => 'Bearer ' . FIRSTDELIVERY_API_KEY,
        ),
    ));

    if (is_wp_error($response)) {
        return false; // Handle errors
    }

    $body = wp_remote_retrieve_body($response);
    return json_decode($body, true); // Return as an array
}

// Function to make POST requests to the API
function fdg_api_post_request($endpoint, $data) {
    $url = FIRSTDELIVERY_API_BASE_URL . $endpoint;

    $response = wp_remote_post($url, array(
        'headers' => array(
            'Authorization' => 'Bearer ' . FIRSTDELIVERY_API_KEY,
            'Content-Type' => 'application/json',
        ),
        'body' => json_encode($data),
    ));

    if (is_wp_error($response)) {
        return false; // Handle errors
    }

    $body = wp_remote_retrieve_body($response);
    return json_decode($body, true); // Return as an array
}

// Example function to get deliveries
function fdg_get_deliveries() {
    $endpoint = '/deliveries';
    $deliveries = fdg_api_get_request($endpoint);

    if ($deliveries) {
        // Process the deliveries
        return $deliveries;
    }

    return [];
}

// Register admin page in WordPress dashboard
function fdg_register_admin_page() {
    add_menu_page(
        'First Delivery', 
        'First Delivery', 
        'manage_options', 
        'first-delivery', 
        'fdg_admin_page_callback'
    );
}
add_action('admin_menu', 'fdg_register_admin_page');

// Callback function for admin page
function fdg_admin_page_callback() {
    // Display a list of deliveries from the API
    $deliveries = fdg_get_deliveries();

    echo '<h1>Deliveries</h1>';
    if ($deliveries) {
        echo '<ul>';
        foreach ($deliveries as $delivery) {
            echo '<li>' . esc_html($delivery['name']) . '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>No deliveries found.</p>';
    }
}

// Shortcode to display deliveries in posts or pages
function fdg_deliveries_shortcode() {
    $deliveries = fdg_get_deliveries();

    ob_start();
    echo '<ul>';
    if ($deliveries) {
        foreach ($deliveries as $delivery) {
            echo '<li>' . esc_html($delivery['name']) . '</li>';
        }
    } else {
        echo '<p>No deliveries found.</p>';
    }
    echo '</ul>';
    
    return ob_get_clean();
}
add_shortcode('fdg_deliveries', 'fdg_deliveries_shortcode');
