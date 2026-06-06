<?php
/**
 * Header Language Switcher Component
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) {
    exit;
}

class Erdu_Header_Lang {
    public static function render() {
        if (!erdu_header_field('hd_show_lang', true)) {
            return;
        }
        ?>
        <div class="hidden md:flex items-center gap-1.5 text-xs text-gray-500">
            <span class="font-medium text-gray-700">EN</span>
            <span class="text-gray-300">/</span>
            <a href="#" class="hover:text-orange-500 transition-colors">CN</a>
        </div>
        <?php
    }
}
