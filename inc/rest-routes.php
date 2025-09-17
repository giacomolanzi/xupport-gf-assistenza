<?php
if (!defined('ABSPATH')) exit;

/**
 * Proxy REST interni (se ci servono chiamate AJAX dal front-end):
 * - /xupport/v1/province
 * - /xupport/v1/comuni?prov=XX
 * - /xupport/v1/modelli
 * - /xupport/v1/errori?modello=...
 * Per ora, lasciamo vuoto; li aggiungeremo allo Step 2/3.
 */

add_action('rest_api_init', function () {
    // placeholder route per sanity check
    register_rest_route('xupport/v1', '/ping', [
        'methods'  => 'GET',
        'callback' => fn() => ['ok' => true, 'time' => time()],
        'permission_callback' => '__return_true',
    ]);
});
