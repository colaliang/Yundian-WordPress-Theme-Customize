<?php
/**
 * Single Product Section: Features
 *
 * @package ERDU_Lighting/WooCommerce
 */

defined('ABSPATH') || exit;

if (!function_exists('have_rows') || !have_rows('product_features')) {
    return;
}
?>
<div id="section-features" class="erdu-content-block scroll-mt-32">
    <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-4 border-b border-gray-100"><?php esc_html_e('Features', 'erdu-wp'); ?></h2>
    <div class="prose prose-lg max-w-none text-gray-600">
        <ul class="list-disc pl-5 space-y-4">
            <?php while (have_rows('product_features')) : the_row();
                $f_title = get_sub_field('title');
                $f_desc  = get_sub_field('description');
            ?>
                <li><strong class="text-gray-900"><?php echo esc_html($f_title); ?></strong> - <?php echo esc_html($f_desc); ?></li>
            <?php endwhile; ?>
        </ul>
    </div>
</div>
