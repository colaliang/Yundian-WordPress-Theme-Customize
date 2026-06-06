<?php
/**
 * Header Top Bar Component
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) {
    exit;
}

class Erdu_Header_Topbar {
    public static function render() {
        if (!erdu_header_field('hd_topbar_enable', false)) {
            return;
        }

        $left_text  = erdu_header_field('hd_topbar_left', '');
        $right_text = erdu_header_field('hd_topbar_right', '');
        $bg_color   = erdu_header_field('hd_topbar_bg', '#1a1a2e');
        $text_color = erdu_header_field('hd_topbar_text', '#ffffff');

        if (empty($left_text) && empty($right_text)) {
            return;
        }
        ?>
        <div class="erdu-topbar" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;">
            <div class="erdu-container flex items-center justify-between py-1.5 text-xs">
                <?php if ($left_text) : ?>
                    <div class="flex items-center gap-2">
                        <span><?php echo esc_html($left_text); ?></span>
                    </div>
                <?php else : ?>
                    <div></div>
                <?php endif; ?>

                <?php if ($right_text) : ?>
                    <div class="flex items-center gap-2">
                        <span><?php echo esc_html($right_text); ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
}
