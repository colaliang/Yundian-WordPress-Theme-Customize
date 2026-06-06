<?php
/**
 * Footer Quick Links Component
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) {
    exit;
}

class Erdu_Footer_Links {
    public static function render($settings) {
        if (!$settings['quick_show'] || empty($settings['quick_links'])) {
            return;
        }
        ?>
        <div>
            <h4 class="font-semibold mb-4" style="color: <?php echo esc_attr($settings['heading_color']); ?>;"><?php echo esc_html($settings['quick_title']); ?></h4>
            <ul class="space-y-2 text-sm">
                <?php foreach ($settings['quick_links'] as $ql) :
                    $ql_label = $ql['label'] ?? '';
                    $ql_url = $ql['url'] ?? '#';
                ?>
                <li><a href="<?php echo esc_url($ql_url); ?>" class="transition-colors hover:underline" style="color: <?php echo esc_attr($settings['text_color']); ?>;" onmouseover="this.style.color='<?php echo esc_attr($settings['hover_color']); ?>'" onmouseout="this.style.color='<?php echo esc_attr($settings['text_color']); ?>'"><?php echo esc_html($ql_label); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
    }
}