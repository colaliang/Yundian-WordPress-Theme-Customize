<?php
/**
 * Single Product Section: Downloads
 *
 * @package ERDU_Lighting/WooCommerce
 */

defined('ABSPATH') || exit;

if (!function_exists('have_rows') || !have_rows('product_downloads')) {
    return;
}
?>
<div id="section-downloads" class="erdu-content-block scroll-mt-32 py-10 lg:py-16">
    <h2 class="text-2xl font-bold text-gray-900 mb-8 pb-4 border-b border-gray-100"><?php esc_html_e('Downloads', 'erdu-wp'); ?></h2>
    <div class="prose max-w-none grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        <?php while (have_rows('product_downloads')) : the_row();
            $title = get_sub_field('title');
            $file  = get_sub_field('file');
        ?>
            <a href="<?php echo esc_url($file); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-between text-base font-semibold text-orange-600 hover:text-orange-800 transition-all bg-orange-50 hover:bg-orange-100 border border-orange-100 px-6 py-4 rounded-xl shadow-sm hover:shadow-md">
                <span class="flex items-center">
                    <svg class="w-6 h-6 mr-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    <?php echo esc_html($title); ?>
                </span>
            </a>
        <?php endwhile; ?>
    </div>
    <div class="mb-8"></div>
</div>
