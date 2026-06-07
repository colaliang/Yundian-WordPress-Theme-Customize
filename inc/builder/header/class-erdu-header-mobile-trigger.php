<?php
/**
 * Header Mobile Trigger Component
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) {
    exit;
}

class Erdu_Header_Mobile_Trigger {
    public static function render() {
        ?>
        <div class="flex lg:hidden items-center gap-3">
            <button class="p-2 rounded-md hover:bg-gray-100 erdu-mobile-toggle"
                    aria-expanded="false"
                    aria-label="<?php esc_attr_e('Toggle menu', 'erdu-wp'); ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
        <?php
    }
}
