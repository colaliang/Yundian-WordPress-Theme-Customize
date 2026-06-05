<?php
/**
 * Enqueue Scripts and Styles
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) exit;

/**
 * Theme assets
 */
add_action('wp_enqueue_scripts', 'erdu_enqueue_assets');
function erdu_enqueue_assets()
{
    // Theme stylesheet (style.css contains theme header only)
    wp_enqueue_style('erdu-style', get_stylesheet_uri(), array(), ERDU_VERSION);

    // Main CSS
    wp_enqueue_style(
        'erdu-main',
        ERDU_URI . '/assets/css/main.css',
        array(),
        ERDU_VERSION
    );

    // Main JS
    wp_enqueue_script(
        'erdu-main',
        ERDU_URI . '/assets/js/main.js',
        array(),
        ERDU_VERSION,
        true
    );

    // Theme settings
    $theme_settings = get_option('erdu_settings', array());

    // Localize
    wp_localize_script('erdu-main', 'erdu_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('erdu_nonce'),
        'home_url' => home_url('/'),
        'settings' => $theme_settings,
        'customize' => array(
            'primary_color' => get_theme_mod('erdu_primary_color', '#F37021'),
            'primary_dark'  => get_theme_mod('erdu_primary_dark', '#D45A0F'),
        ),
        'strings'  => array(
            'required' => __('This field is required', 'erdu-wp'),
        ),
    ));
}

/**
 * Admin styles
 */
add_action('admin_enqueue_scripts', 'erdu_admin_styles');
function erdu_admin_styles($hook)
{
    wp_enqueue_style(
        'erdu-admin',
        ERDU_URI . '/assets/css/admin.css',
        array(),
        ERDU_VERSION
    );
}
