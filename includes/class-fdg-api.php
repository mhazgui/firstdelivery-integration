<?php

class FDG_API {
    private $api_key;

    public function __construct() {
        $this->api_key = FDG_API_KEY;
    }

    public function get_request($endpoint) {
        $url = FDG_API_BASE_URL . $endpoint;

        $response = wp_remote_get($url, array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $this->api_key,
            ),
        ));

        if (is_wp_error($response)) {
            return false; // Handle errors
        }

        return json_decode(wp_remote_retrieve_body($response), true);
    }

    public function post_request($endpoint, $data) {
        $url = FDG_API_BASE_URL . $endpoint;

        $response = wp_remote_post($url, array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $this->api_key,
                'Content-Type' => 'application/json',
            ),
            'body' => json_encode($data),
        ));

        if (is_wp_error($response)) {
            return false; // Handle errors
        }

        return json_decode(wp_remote_retrieve_body($response), true);
    }
}
