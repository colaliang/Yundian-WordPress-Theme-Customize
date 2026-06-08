<?php
/**
 * Editor Tweaks
 * Disables Gutenberg and Classic Editor for ACF-driven templates to provide a clean data-entry interface.
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) exit;

/**
 * List of templates that are fully ACF-driven and should not use the block editor.
 */
function erdu_get_acf_driven_templates() {
    return array(
        'front-page.php',
        'page-about.php',
        'page-home.php',
        'page-products.php',
        'page-solutions.php',
        'page-quality.php',
        'page-distributor.php',
        'page-cases.php',
        'page-news.php',
        'page-blog.php',
        'page-contact.php',
        'page-product-category.php',
        'page-product-single.php'
    );
}

/**
 * Disable Block Editor for ACF-driven page templates.
 */
add_filter('use_block_editor_for_post', 'erdu_disable_gutenberg_for_templates', 10, 2);
function erdu_disable_gutenberg_for_templates($use_block_editor, $post) {
    if ($post->post_type === 'page') {
        $template = get_post_meta($post->ID, '_wp_page_template', true);
        if (in_array($template, erdu_get_acf_driven_templates())) {
            return false;
        }
    }
    return $use_block_editor;
}

/**
 * Remove Classic Editor text area for ACF-driven templates.
 */
add_action('admin_init', 'erdu_remove_editor_for_templates');
function erdu_remove_editor_for_templates() {
    $post_id = 0;
    if (isset($_GET['post'])) {
        $post_id = intval($_GET['post']);
    } elseif (isset($_POST['post_ID'])) {
        $post_id = intval($_POST['post_ID']);
    }

    if ($post_id) {
        $template = get_post_meta($post_id, '_wp_page_template', true);
        if (in_array($template, erdu_get_acf_driven_templates())) {
            remove_post_type_support('page', 'editor');
        }
    }
}
