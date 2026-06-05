<?php
/**
 * Theme Setup Functions
 *
 * @package ERDU_Lighting
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register image sizes
 */
add_action('after_setup_theme', 'erdu_image_sizes');
function erdu_image_sizes()
{
    add_image_size('erdu-card', 600, 400, true);
    add_image_size('erdu-hero', 1920, 600, true);
    add_image_size('erdu-product', 400, 400, true);
    add_image_size('erdu-thumbnail', 300, 200, true);
}

/**
 * Register sidebars
 */
add_action('widgets_init', 'erdu_widgets_init');
function erdu_widgets_init()
{
    register_sidebar(array(
        'name'          => __('Footer Sidebar 1', 'erdu-wp'),
        'id'            => 'footer-1',
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="text-white font-semibold mb-4">',
        'after_title'   => '</h4>',
    ));
}

/**
 * Custom excerpt length
 */
add_filter('excerpt_length', 'erdu_excerpt_length', 999);
function erdu_excerpt_length($length)
{
    return 30;
}

/**
 * Custom excerpt more
 */
add_filter('excerpt_more', 'erdu_excerpt_more');
function erdu_excerpt_more($more)
{
    return '...';
}

/**
 * Add body classes for pages
 */
add_filter('body_class', 'erdu_body_classes');
function erdu_body_classes($classes)
{
    if (is_front_page()) {
        $classes[] = 'erdu-home';
    }
    return $classes;
}

/**
 * Disable WordPress emoji
 */
add_action('init', 'erdu_disable_emoji');
function erdu_disable_emoji()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
}

/**
 * Remove WordPress version from head
 */
add_filter('the_generator', '__return_empty_string');
