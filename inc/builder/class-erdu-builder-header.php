<?php
/**
 * ERDU Builder Header Loader
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Erdu_Builder_Header')) {

    class Erdu_Builder_Header {

        private static $instance = null;
        private $header_settings = array();

        public static function get_instance() {
            if (is_null(self::$instance)) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        public function __construct() {
            $this->load_components();
            add_action('wp', array($this, 'init_settings'));
            $this->setup_hooks();
        }

        public function init_settings() {
            // Only init on frontend
            if (is_admin()) return;

            if (function_exists('erdu_header_field')) {
                $this->header_settings = array(
                    'layout'         => erdu_header_field('hd_layout', 'default'),
                    'width'          => erdu_header_field('hd_width', 'container'),
                    'height'         => erdu_header_field('hd_height', 64),
                    'sticky'         => erdu_header_field('hd_sticky', true),
                    'sticky_shadow'  => erdu_header_field('hd_sticky_shadow', true),
                    'transparent'    => erdu_header_field('hd_transparent', false),
                    'bg_color'       => erdu_header_field('hd_bg_color', '#ffffff'),
                    'text_color'     => erdu_header_field('hd_text_color', '#333333'),
                    'link_hover'     => erdu_header_field('hd_link_hover', '#F37021'),
                    'border_color'   => erdu_header_field('hd_border_color', '#e5e7eb'),
                    'show_search'    => erdu_header_field('hd_show_search', true),
                    'show_lang'      => erdu_header_field('hd_show_lang', true),
                    'show_phone'     => erdu_header_field('hd_show_phone', false),
                    'show_email'     => erdu_header_field('hd_show_email', false),
                    'show_address'   => erdu_header_field('hd_show_address', false),
                    'show_cta'       => erdu_header_field('hd_show_cta', true),
                    'show_social'    => erdu_header_field('hd_show_social', false),
                    'mega_enable'    => erdu_header_field('hd_mega_enable', false),
                    'topbar_enable'  => erdu_header_field('hd_topbar_enable', false),
                );
            }
        }

        private function load_components() {
            require_once ERDU_DIR . '/inc/builder/header/class-erdu-header-logo.php';
            require_once ERDU_DIR . '/inc/builder/header/class-erdu-header-menu.php';
            require_once ERDU_DIR . '/inc/builder/header/class-erdu-header-mobile-trigger.php';
            require_once ERDU_DIR . '/inc/builder/header/class-erdu-header-search.php';
            require_once ERDU_DIR . '/inc/builder/header/class-erdu-header-lang.php';
            require_once ERDU_DIR . '/inc/builder/header/class-erdu-header-contact.php';
            require_once ERDU_DIR . '/inc/builder/header/class-erdu-header-social.php';
            require_once ERDU_DIR . '/inc/builder/header/class-erdu-header-cta.php';
            require_once ERDU_DIR . '/inc/builder/header/class-erdu-header-topbar.php';
            require_once ERDU_DIR . '/inc/builder/header/class-erdu-header-mega-menu.php';
            require_once ERDU_DIR . '/inc/builder/header/class-erdu-header-element-popup.php';
        }

        private function setup_hooks() {
            // Above Header (Top Bar)
            add_action('erdu_above_header', array('Erdu_Header_Topbar', 'render'), 10);

            // Primary Header Items
            add_action('erdu_primary_header', array('Erdu_Header_Logo', 'render'), 10);
            add_action('erdu_primary_header', array('Erdu_Header_Contact', 'render'), 15);
            add_action('erdu_primary_header', array('Erdu_Header_Menu', 'render_desktop'), 20);
            add_action('erdu_primary_header', array('Erdu_Header_Mega_Menu', 'render'), 25);
            add_action('erdu_primary_header', array('Erdu_Header_Social', 'render'), 28);
            add_action('erdu_primary_header', array('Erdu_Header_Search', 'render'), 29);
            add_action('erdu_primary_header', array('Erdu_Header_Lang', 'render'), 30);
            add_action('erdu_primary_header', array('Erdu_Header_Element_Popup', 'render'), 32);
            add_action('erdu_primary_header', array('Erdu_Header_CTA', 'render'), 35);
            add_action('erdu_primary_header', array('Erdu_Header_Mobile_Trigger', 'render'), 40);

            // After Header (Mobile Menu)
            add_action('erdu_after_header', array('Erdu_Header_Menu', 'render_mobile'), 10);

            // Dynamic header styles
            add_action('wp_head', array($this, 'output_dynamic_header_styles'), 100);
        }

        public function output_dynamic_header_styles() {
            if (is_admin()) return;

            $bg       = $this->header_settings['bg_color'] ?? '#ffffff';
            $text     = $this->header_settings['text_color'] ?? '#333333';
            $hover    = $this->header_settings['link_hover'] ?? '#F37021';
            $border   = $this->header_settings['border_color'] ?? '#e5e7eb';
            $height   = $this->header_settings['height'] ?? 64;
            $sticky   = $this->header_settings['sticky'] ?? true;
            $shadow   = $this->header_settings['sticky_shadow'] ?? true;

            $styles = array();
            $styles[] = '.erdu-header { background-color: ' . esc_attr($bg) . '; color: ' . esc_attr($text) . '; border-bottom-color: ' . esc_attr($border) . '; }';
            $styles[] = '.erdu-header .erdu-nav-link { color: ' . esc_attr($text) . '; }';
            $styles[] = '.erdu-header .erdu-nav-link:hover, .erdu-header .erdu-nav-link.active { color: ' . esc_attr($hover) . '; }';
            $styles[] = '.erdu-header .flex.items-center.justify-between { min-height: ' . intval($height) . 'px; }';

            if ($sticky) {
                $styles[] = '.erdu-header { position: sticky; top: 0; z-index: 50; }';
                if ($shadow) {
                    $styles[] = '.erdu-header.is-sticky, .erdu-header.sticky { box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }';
                }
            }

            echo '<style id="erdu-header-dynamic-css">' . implode("\n", $styles) . '</style>';
        }
    }
}
