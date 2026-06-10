<?php
/**
 * Single Product Section: Description
 *
 * @package ERDU_Lighting/WooCommerce
 */

defined('ABSPATH') || exit;

$content = get_the_content();
$has_desc = trim(strip_tags($content));

if (!$has_desc) {
    return;
}
?>
<div id="section-desc" class="erdu-content-block scroll-mt-32 py-10 lg:py-16">
    <h2 class="text-2xl font-bold text-gray-900 mb-8 pb-4 border-b border-gray-100"><?php esc_html_e('Description', 'erdu-wp'); ?></h2>
    <div class="prose max-w-none text-gray-600 text-base leading-relaxed">
        <?php echo apply_filters('the_content', $content); ?>
    </div>
</div>
