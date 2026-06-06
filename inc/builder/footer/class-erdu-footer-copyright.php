<?php
/**
 * Footer Copyright Component
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) {
    exit;
}

class Erdu_Footer_Copyright {
    public static function render($settings) {
        $copy_text = str_replace('{year}', date('Y'), $settings['copy_text']);
        ?>
        <div class="border-t py-6" style="border-color: <?php echo esc_attr($settings['border_color']); ?>;">
            <div class="erdu-container flex flex-col md:flex-row items-center justify-between gap-4 text-sm" style="color: <?php echo esc_attr($settings['text_color']); ?>;">
                
                <!-- Copyright Text -->
                <div class="text-center md:text-left">
                    <?php echo esc_html($copy_text); ?>
                </div>

                <!-- Copyright Links -->
                <?php if (!empty($settings['copy_links'])) : ?>
                <div class="flex flex-wrap justify-center gap-4">
                    <?php foreach ($settings['copy_links'] as $link) : 
                        $label = $link['label'] ?? '';
                        $url = $link['url'] ?? '#';
                    ?>
                    <a href="<?php echo esc_url($url); ?>" class="transition-colors hover:underline" style="color: <?php echo esc_attr($settings['text_color']); ?>;" onmouseover="this.style.color='<?php echo esc_attr($settings['hover_color']); ?>'" onmouseout="this.style.color='<?php echo esc_attr($settings['text_color']); ?>'"><?php echo esc_html($label); ?></a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

            </div>
        </div>
        <?php
    }
}