<?php
/**
 * Header Menu Component
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) {
    exit;
}

class Erdu_Header_Menu {
    public static function render_desktop() {
        ?>
        <nav class="hidden lg:flex items-center gap-1" id="erdu-desktop-nav">
            <?php
            if (has_nav_menu('primary')) {
                wp_nav_menu(array(
                    'theme_location'  => 'primary',
                    'container'       => false,
                    'items_wrap'      => '%3$s',
                    'depth'           => 1,
                    'walker'          => new ERDU_Walker_Nav_Menu(),
                    'fallback_cb'     => false,
                ));
            } else {
                self::render_fallback_desktop();
            }
            ?>
        </nav>
        <?php
    }

    public static function render_mobile() {
        ?>
        <div id="mobile-menu" class="erdu-mobile-menu lg:hidden bg-white border-t border-gray-100 hidden absolute left-0 right-0 top-full shadow-lg z-[50]">
            <div class="erdu-container py-4 space-y-2">
                <?php
                if (has_nav_menu('primary')) {
                    wp_nav_menu(array(
                        'theme_location'  => 'primary',
                        'container'       => false,
                        'items_wrap'      => '<div class="flex flex-col gap-1">%3$s</div>',
                        'depth'           => 1,
                        'walker'          => new ERDU_Walker_Mobile_Menu(),
                        'fallback_cb'     => false,
                    ));
                } else {
                    self::render_fallback_mobile();
                }
                ?>
            </div>
        </div>
        <?php
    }

    private static function render_fallback_desktop() {
        $fallback_items = self::get_fallback_items();
        foreach ($fallback_items as $item) {
            $is_active = function_exists('erdu_is_current_page') && erdu_is_current_page($item['url']);
            printf(
                '<a href="%s" class="erdu-nav-link %s">%s</a>',
                esc_url($item['url']),
                $is_active ? 'active' : '',
                esc_html($item['label'])
            );
        }
    }

    private static function render_fallback_mobile() {
        $fallback_items = self::get_fallback_items();
        echo '<div class="flex flex-col gap-1">';
        foreach ($fallback_items as $item) {
            $is_active = function_exists('erdu_is_current_page') && erdu_is_current_page($item['url']);
            $class = $is_active ? 'text-orange-600 bg-orange-50' : 'text-gray-700 hover:bg-gray-50';
            printf(
                '<a href="%s" class="block px-4 py-3 text-base font-medium rounded-md %s">%s</a>',
                esc_url($item['url']),
                esc_attr($class),
                esc_html($item['label'])
            );
        }
        echo '</div>';
    }

    private static function get_fallback_items() {
        if (!function_exists('erdu_get_page_url')) {
            return array();
        }
        return array(
            array('label' => __('Home', 'erdu-wp'), 'url' => home_url('/')),
            array('label' => __('About Us', 'erdu-wp'), 'url' => erdu_get_page_url('about')),
            array('label' => __('Products', 'erdu-wp'), 'url' => erdu_get_page_url('products')),
            array('label' => __('Solutions', 'erdu-wp'), 'url' => erdu_get_page_url('solutions')),
            array('label' => __('Quality', 'erdu-wp'), 'url' => erdu_get_page_url('quality')),
            array('label' => __('Distributor', 'erdu-wp'), 'url' => erdu_get_page_url('distributor')),
            array('label' => __('Case Studies', 'erdu-wp'), 'url' => erdu_get_page_url('cases')),
            array('label' => __('News', 'erdu-wp'), 'url' => erdu_get_page_url('news')),
            array('label' => __('Contact', 'erdu-wp'), 'url' => erdu_get_page_url('contact')),
        );
    }
}
