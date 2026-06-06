<?php
/**
 * Header Button / Language Switcher Component
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) {
    exit;
}

class Erdu_Header_Button {
    public static function render() {
        ?>
        <div class="hidden md:flex items-center gap-3">
            <span class="text-xs text-gray-400">EN / CN</span>
            <?php if (function_exists('erdu_get_page_url')) : ?>
            <a href="<?php echo esc_url(erdu_get_page_url('contact')); ?>" class="px-4 py-2 text-sm font-medium text-white rounded bg-orange-600 hover:bg-orange-700 transition-colors">
                <?php _e('Get a Quote', 'erdu-wp'); ?>
            </a>
            <?php endif; ?>
        </div>
        <?php
    }
}
