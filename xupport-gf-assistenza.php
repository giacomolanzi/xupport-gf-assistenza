<?php

/**
 * Plugin Name: Xupport GF Assistenza
 * Plugin URI:  https://www.xupport.it
 * Description: Funzioni Gravity Forms + integrazione API Xupport (wizard assistenza/prima accensione).
 * Version:     v0.3.1
 * Author:      Giacomo Lanzi
 * Author URI:  https://planbproject.it
 * License:     GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: xupport-gf-assistenza
 *
 * GitHub Plugin URI: giacomolanzi/xupport-gf-assistenza
 * Primary Branch: main
 * Release Asset: true
 */

if (!defined('ABSPATH')) exit;

// --- Config letta da env o define in wp-config.php (NON mettere segreti nel repo)
if (!defined('XUPPORT_API_BASE')) define('XUPPORT_API_BASE', getenv('XUPPORT_API_BASE') ?: 'https://testapi.xupport.it:443');
if (!defined('XUPPORT_API_AUTH')) define('XUPPORT_API_AUTH', getenv('XUPPORT_API_AUTH') ?: '');
if (!defined('XUPPORT_API_USER')) define('XUPPORT_API_USER', getenv('XUPPORT_API_USER') ?: '');
if (!defined('XUPPORT_API_PASS')) define('XUPPORT_API_PASS', getenv('XUPPORT_API_PASS') ?: '');

// --- Autoload minimale
require_once __DIR__ . '/inc/class-api-client.php';
require_once __DIR__ . '/inc/gravity-hooks.php';
require_once __DIR__ . '/inc/rest-routes.php';

// --- Assets (JS per campi dinamici, lo useremo negli step successivi)
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script(
        'xupport-gf-dynamic',
        plugin_dir_url(__FILE__) . 'assets/js/gf-dynamic.js',
        [],
        '0.1.0',
        true
    );
});
