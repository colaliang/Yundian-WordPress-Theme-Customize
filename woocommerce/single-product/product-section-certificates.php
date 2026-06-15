<?php
/**
 * Single Product Section: Certificates
 *
 * @package ERDU_Lighting/WooCommerce
 */

defined('ABSPATH') || exit;

if (!function_exists('have_rows') || !have_rows('product_certificates')) {
    return;
}
?>
<div id="section-certificates" class="erdu-content-block scroll-mt-32 py-10 lg:py-16">
    <h2 class="text-2xl font-bold text-gray-900 mb-8 pb-4 border-b border-gray-100"><?php esc_html_e('Certificates', 'erdu-wp'); ?></h2>
    <div class="prose max-w-none grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-6">
        <?php while (have_rows('product_certificates')) : the_row();
            $cert_name  = get_sub_field('cert_name');
            $cert_image = get_sub_field('cert_image');
        ?>
        <div class="flex flex-col items-center text-center group">
            <?php if ($cert_image) : ?>
                <div class="w-full aspect-[3/4] bg-white border border-gray-200 rounded-lg p-4 flex items-center justify-center mb-3 transition-shadow group-hover:shadow-md">
                    <img src="<?php echo esc_url($cert_image); ?>" alt="<?php echo esc_attr($cert_name); ?>" class="max-w-full max-h-full object-contain" />
                </div>
            <?php else : ?>
                <div class="w-full aspect-[3/4] bg-gray-50 border border-gray-200 rounded-lg p-4 flex items-center justify-center mb-3">
                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            <?php endif; ?>
            <?php if ($cert_name) : ?>
                <span class="text-base font-medium text-gray-700"><?php echo esc_html($cert_name); ?></span>
            <?php endif; ?>
        </div>
        <?php endwhile; ?>
    </div>
    <div class="mb-8"></div>
</div>
