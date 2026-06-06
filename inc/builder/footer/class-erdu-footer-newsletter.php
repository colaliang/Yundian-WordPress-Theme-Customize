<?php
/**
 * Footer Newsletter Component
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) {
    exit;
}

class Erdu_Footer_Newsletter {
    public static function render($settings, $theme_settings) {
        if (!$settings['news_show']) {
            return;
        }
        ?>
        <div>
            <h4 class="font-semibold mb-4" style="color: <?php echo esc_attr($settings['heading_color']); ?>;"><?php echo esc_html($settings['news_title']); ?></h4>
            <p class="text-sm mb-3" style="color: <?php echo esc_attr($settings['text_color']); ?>;"><?php echo esc_html($settings['news_desc']); ?></p>
            <form class="flex gap-2" action="#" method="post">
                <input type="email" name="email" placeholder="<?php echo esc_attr($settings['news_ph']); ?>"
                       class="flex-1 px-3 py-2 rounded-md text-sm border focus:outline-none"
                       style="background-color: rgba(255,255,255,0.05); color: <?php echo esc_attr($settings['heading_color']); ?>; border-color: <?php echo esc_attr($settings['border_color']); ?>;"
                       onfocus="this.style.borderColor='<?php echo esc_attr($settings['hover_color']); ?>'"
                       onblur="this.style.borderColor='<?php echo esc_attr($settings['border_color']); ?>'">
                <button type="submit" class="px-4 py-2 font-medium text-sm rounded-md hover:opacity-90 transition-opacity" style="background-color: <?php echo esc_attr($theme_settings['primary_color'] ?? '#F37021'); ?>; color: #fff;">
                    <?php echo esc_html($settings['news_btn']); ?>
                </button>
            </form>
            <?php if ($settings['news_footer']) : ?>
            <p class="text-xs mt-2" style="color: <?php echo esc_attr($settings['text_color']); ?>; opacity: 0.7;"><?php echo esc_html($settings['news_footer']); ?></p>
            <?php endif; ?>
        </div>
        <?php
    }
}