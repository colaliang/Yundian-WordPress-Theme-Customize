<?php
/**
 * Header Search Component
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) {
    exit;
}

class Erdu_Header_Search {
    public static function render() {
        if (!erdu_header_field('hd_show_search', true)) {
            return;
        }
        ?>
        <div class="hidden md:flex items-center">
            <button class="p-2 rounded-md hover:bg-gray-100 transition-colors"
                    onclick="document.getElementById('erdu-search-overlay').classList.toggle('hidden')"
                    aria-label="<?php esc_attr_e('Search', 'erdu-wp'); ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>
        </div>

        <!-- Search Overlay -->
        <div id="erdu-search-overlay" class="hidden fixed inset-0 z-[60] bg-black/50 backdrop-blur-sm" onclick="if(event.target===this)this.classList.add('hidden')">
            <div class="flex items-start justify-center pt-32">
                <div class="w-full max-w-2xl mx-4 bg-white rounded-lg shadow-2xl p-6">
                    <form action="<?php echo esc_url(home_url('/')); ?>" method="get" class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" name="s" placeholder="<?php esc_attr_e('Search products, articles...', 'erdu-wp'); ?>"
                               class="flex-1 text-lg outline-none" autofocus>
                        <button type="submit" class="px-4 py-2 text-white rounded erdu-bg-primary hover:opacity-90 transition-opacity">
                            <?php _e('Search', 'erdu-wp'); ?>
                        </button>
                        <button type="button" class="p-2 text-gray-400 hover:text-gray-600"
                                onclick="document.getElementById('erdu-search-overlay').classList.add('hidden')">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }
}
