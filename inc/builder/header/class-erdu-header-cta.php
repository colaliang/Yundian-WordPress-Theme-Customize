<?php
/**
 * Header CTA Button Component
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) {
    exit;
}

class Erdu_Header_CTA {
    public static function render() {
        if (!erdu_header_field('hd_show_cta', true)) {
            return;
        }

        $text   = erdu_header_field('hd_cta_text', 'Get a Quote');
        $link   = erdu_header_field('hd_cta_link', '');
        $style  = erdu_header_field('hd_cta_style', 'primary');
        $target = erdu_header_field('hd_cta_target', false);

        // Fallback link
        if (empty($link) && function_exists('erdu_get_page_url')) {
            $link = erdu_get_page_url('contact');
        }
        if (empty($link)) {
            $link = home_url('/');
        }

        $class = 'hidden md:inline-flex px-4 py-2 text-sm font-medium rounded transition-colors items-center justify-center';
        switch ($style) {
            case 'outline':
                $class .= ' border-2 border-orange-500 text-orange-500 hover:bg-orange-500 hover:text-white';
                break;
            case 'ghost':
                $class .= ' text-orange-500 hover:bg-orange-50';
                break;
            case 'primary':
            default:
                $class .= ' text-white erdu-bg-primary erdu-hover-primary';
                break;
        }

        $target_attr = $target ? ' target="_blank" rel="noopener noreferrer"' : '';
        ?>
        <a href="<?php echo esc_url($link); ?>" class="<?php echo esc_attr($class); ?>"<?php echo $target_attr; ?>>
            <?php echo esc_html($text); ?>
        </a>
        <?php
    }
}
