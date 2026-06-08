<?php
/**
 * Page Live Preview in Admin
 * Disables Gutenberg for ACF-driven templates and adds a live preview iframe.
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

/**
 * Add Live Preview Meta Box
 */
add_action('add_meta_boxes', 'erdu_add_preview_meta_box', 1);
function erdu_add_preview_meta_box() {
    global $post;
    if (!$post || $post->post_type !== 'page') return;

    $template = get_post_meta($post->ID, '_wp_page_template', true);
    if (in_array($template, erdu_get_acf_driven_templates())) {
        add_meta_box(
            'erdu_page_preview',
            __('Live Page Preview', 'erdu-wp'),
            'erdu_render_preview_meta_box',
            'page',
            'normal',
            'high'
        );
    }
}

function erdu_render_preview_meta_box($post) {
    $preview_url = get_permalink($post->ID);
    // Add a query param to bypass cache
    $preview_url = add_query_arg('admin_preview', time(), $preview_url);
    ?>
    <div style="margin: -12px -12px -20px -12px;">
        <div style="background: #f0f0f1; padding: 10px 15px; border-bottom: 1px solid #ccd0d4; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center;">
                <span class="dashicons dashicons-desktop" style="color: #2271b1;"></span>
                <strong style="color: #1d2327; margin-left: 8px; font-size: 14px;"><?php _e('Frontend Visual Preview', 'erdu-wp'); ?></strong>
                <span style="color: #646970; margin-left: 15px; font-size: 13px; background: #fff; padding: 2px 8px; border-radius: 10px; border: 1px solid #dcdcde;">
                    <?php _e('The preview will update after you save the page changes below.', 'erdu-wp'); ?>
                </span>
            </div>
            <a href="<?php echo esc_url(get_permalink($post->ID)); ?>" target="_blank" class="button button-small" style="display: flex; align-items: center; gap: 4px;">
                <span class="dashicons dashicons-external" style="font-size: 14px; width: 14px; height: 14px;"></span>
                <?php _e('Open in New Tab', 'erdu-wp'); ?>
            </a>
        </div>
        <div style="position: relative; height: 600px; overflow: hidden; background: #fff;">
            <iframe src="<?php echo esc_url($preview_url); ?>" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" title="Page Preview"></iframe>
        </div>
    </div>
    <?php
}
