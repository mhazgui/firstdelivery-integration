<?php

class FDG_Admin {
    private $api;

    public function __construct() {
        $this->api = new FDG_API();
        add_action('admin_menu', array($this, 'register_admin_page'));
    }

    public function register_admin_page() {
        add_menu_page(
            'First Delivery', 
            'First Delivery', 
            'manage_options', 
            'first-delivery', 
            array($this, 'admin_page_callback')
        );
    }

    public function admin_page_callback() {
        echo '<h1>Deliveries</h1>';
        
        // Fetch deliveries using the API
        $deliveries = $this->api->get_request('/deliveries');

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
}
