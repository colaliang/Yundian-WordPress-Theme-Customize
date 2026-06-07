<?php
/**
 * Header Logo Component
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) {
    exit;
}

class Erdu_Header_Logo {
    public static function render() {
        $header_settings = Erdu_Builder_Header::get_instance()->get_settings();
        $logo_size = isset($header_settings['logo_size']) ? (int)$header_settings['logo_size'] : 32;
        $size_style = 'width: ' . $logo_size . 'px; height: ' . $logo_size . 'px;';
        
        ?>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2">
            <?php if (has_custom_logo()) : 
                $custom_logo_id = get_theme_mod('custom_logo');
                $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                if (has_custom_logo()) {
                    echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '" style="max-height: ' . $logo_size . 'px; width: auto;" class="custom-logo">';
                }
            ?>
            <?php else : ?>
                <div class="rounded-sm flex items-center justify-center erdu-bg-primary" style="<?php echo esc_attr($size_style); ?>">
                    <span class="text-white font-bold" style="font-size: <?php echo esc_attr($logo_size * 0.5); ?>px;">E</span>
                </div>
                <span class="font-bold erdu-text-primary" style="font-size: <?php echo esc_attr(max(16, $logo_size * 0.6)); ?>px;">ERDU</span>
                <span class="hidden sm:inline text-gray-500 ml-1" style="font-size: <?php echo esc_attr(max(10, $logo_size * 0.35)); ?>px;">LIGHTING</span>
            <?php endif; ?>
        </a>
        <?php
    }
}
