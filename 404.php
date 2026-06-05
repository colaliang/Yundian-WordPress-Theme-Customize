<?php
/**
 * 404 Error Page
 *
 * @package ERDU_Lighting
 */

get_header();
?>

<!-- 404 Hero -->
<section class="relative py-24" style="background: linear-gradient(135deg, #2D1810 0%, #4A2510 100%);">
    <div class="relative erdu-container text-center">
        <div class="text-8xl md:text-9xl font-bold text-white opacity-20 mb-4">404</div>
        <h1 class="text-3xl md:text-4xl font-bold text-white mb-4"><?php _e('Page Not Found', 'erdu-wp'); ?></h1>
        <p class="text-gray-300 max-w-lg mx-auto mb-8"><?php _e('Sorry, the page you are looking for does not exist or has been moved. Let us help you find what you need.', 'erdu-wp'); ?></p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="erdu-btn erdu-btn-white inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <?php _e('Back to Home', 'erdu-wp'); ?>
            </a>
            <a href="<?php echo esc_url(erdu_get_page_url('contact')); ?>" class="erdu-btn erdu-btn-outline">
                <?php _e('Contact Us', 'erdu-wp'); ?>
            </a>
        </div>
    </div>
</section>

<!-- Quick Links -->
<section class="py-16">
    <div class="erdu-container">
        <div class="text-center mb-10">
            <h2 class="erdu-h2"><?php _e('Popular Destinations', 'erdu-wp'); ?></h2>
            <p class="text-gray-500 mt-2"><?php _e('Explore these sections of our website', 'erdu-wp'); ?></p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 max-w-4xl mx-auto">
            <?php
            $quick_links = array(
                array('label' => __('Products', 'erdu-wp'), 'url' => erdu_get_page_url('products'), 'icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z'),
                array('label' => __('Solutions', 'erdu-wp'), 'url' => erdu_get_page_url('solutions'), 'icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z'),
                array('label' => __('Case Studies', 'erdu-wp'), 'url' => erdu_get_page_url('cases'), 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'),
                array('label' => __('Contact', 'erdu-wp'), 'url' => erdu_get_page_url('contact'), 'icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z'),
            );
            foreach ($quick_links as $link) : ?>
                <a href="<?php echo esc_url($link['url']); ?>" class="flex items-center gap-3 p-4 bg-white rounded-xl border border-gray-200 hover:shadow-md hover:border-orange-200 transition-all group">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0" style="background-color: #FFF5ED;">
                        <svg class="w-5 h-5" style="color: #F37021;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo esc_attr($link['icon']); ?>"/></svg>
                    </div>
                    <span class="font-medium" style="color: #333;"><?php echo esc_html($link['label']); ?></span>
                    <svg class="w-4 h-4 text-gray-300 ml-auto group-hover:text-orange-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Search -->
<section class="py-16" style="background-color: #F9FAFB;">
    <div class="erdu-container text-center">
        <h2 class="text-xl font-bold mb-4" style="color: #333;"><?php _e('Search Our Website', 'erdu-wp'); ?></h2>
        <form action="<?php echo esc_url(home_url('/')); ?>" method="get" class="max-w-lg mx-auto flex gap-2">
            <input type="text" name="s" placeholder="<?php _e('Search products, solutions, articles...', 'erdu-wp'); ?>"
                   class="flex-1 px-4 py-3 rounded-lg border border-gray-200 focus:border-orange-500 focus:outline-none text-sm">
            <button type="submit" class="px-6 py-3 font-medium text-sm rounded-lg text-white hover:opacity-90 transition-opacity" style="background-color: #F37021;">
                <?php _e('Search', 'erdu-wp'); ?>
            </button>
        </form>
    </div>
</section>

<?php get_footer(); ?>
