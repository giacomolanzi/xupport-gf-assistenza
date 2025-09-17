<?php
if (!defined('ABSPATH')) exit;

/**
 * Qui aggiungeremo:
 * - popolamento server-side dei campi (es. Province)
 * - validazioni (gform_pre_validation)
 * - invio finale (gform_after_submission)
 * Per ora, stub.
 */

// Esempio: verifica che GF sia attivo (evita fatal se manca)
add_action('plugins_loaded', function () {
    if (!class_exists('GFForms')) {
        error_log('[xupport-gf-assistenza] Gravity Forms non attivo.');
    }
});
