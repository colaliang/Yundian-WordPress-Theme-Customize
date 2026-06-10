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
<div id="section-features" class="erdu-content-block scroll-mt-32 py-10 lg:py-16">
    <h2 class="text-2xl font-bold text-gray-900 mb-8 pb-4 border-b border-gray-100"><?php esc_html_e('Features', 'erdu-wp'); ?></h2>
    <div class="prose max-w-none text-gray-600 text-base leading-relaxed">
        <?php while (have_rows('product_features')) : the_row();
            $f_title = get_sub_field('title');
            $f_desc  = get_sub_field('description');
        ?>
        <div class="flex items-start gap-3">
            <span class="mt-2 w-1.5 h-1.5 rounded-full bg-orange-500 flex-shrink-0"></span>
            <p>
                <span class="font-semibold text-gray-900"><?php echo esc_html($f_title); ?></span>
                <span class="mx-1">—</span>
                <?php echo esc_html($f_desc); ?>
            </p>
        </div>
        <?php endwhile; ?>
    </div>
    <div class="mb-8"></div>
</div>
