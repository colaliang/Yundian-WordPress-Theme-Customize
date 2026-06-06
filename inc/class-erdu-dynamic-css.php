<?php
/**
 * ERDU Dynamic CSS Generator
 * Generates inline CSS based on ACF theme color settings
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Erdu_Dynamic_CSS')) {

    class Erdu_Dynamic_CSS {

        private static $instance = null;
        private $css_vars = array();

        public static function get_instance() {
            if (is_null(self::$instance)) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        public function __construct() {
            add_action('wp_head', array($this, 'output_dynamic_css'), 100);
            add_action('admin_head', array($this, 'output_dynamic_css'), 100);
        }

        /**
         * Get theme color settings from ACF
         */
        private function get_color_settings() {
            $defaults = array(
                'primary_color'     => '#F37021',
                'primary_hover'     => '#E05D10',
                'secondary_color'   => '#2D1810',
                'text_color'        => '#333333',
                'text_light'        => '#6b7280',
                'bg_dark'           => '#1a1a2e',
                'bg_light'          => '#f9fafb',
                'border_color'      => '#e5e7eb',
                'footer_bg'         => '#1a1a2e',
                'footer_text'       => '#9ca3af',
                'footer_heading'    => '#ffffff',
                'footer_hover'      => '#F37021',
                'footer_border'     => '#374151',
            );

            // Try to get from ACF options
            if (function_exists('get_field')) {
                $settings = array();
                foreach ($defaults as $key => $default_value) {
                    $acf_value = get_field('erdu_' . $key, 'option');
                    $settings[$key] = $acf_value ? sanitize_hex_color($acf_value) : $default_value;
                }
                return $settings;
            }

            // Fallback to theme settings option
            $theme_settings = get_option('erdu_settings', array());
            if (!empty($theme_settings)) {
                $settings = array();
                foreach ($defaults as $key => $default_value) {
                    $settings[$key] = isset($theme_settings[$key]) ? sanitize_hex_color($theme_settings[$key]) : $default_value;
                }
                return $settings;
            }

            return $defaults;
        }

        /**
         * Generate CSS custom properties
         */
        private function generate_css_vars() {
            $colors = $this->get_color_settings();
            
            $this->css_vars = array(
                '--erdu-primary'        => $colors['primary_color'],
                '--erdu-primary-hover'  => $colors['primary_hover'],
                '--erdu-secondary'      => $colors['secondary_color'],
                '--erdu-text'           => $colors['text_color'],
                '--erdu-text-light'     => $colors['text_light'],
                '--erdu-bg-dark'        => $colors['bg_dark'],
                '--erdu-bg-light'       => $colors['bg_light'],
                '--erdu-border'         => $colors['border_color'],
                '--erdu-footer-bg'      => $colors['footer_bg'],
                '--erdu-footer-text'    => $colors['footer_text'],
                '--erdu-footer-heading' => $colors['footer_heading'],
                '--erdu-footer-hover'   => $colors['footer_hover'],
                '--erdu-footer-border'  => $colors['footer_border'],
            );

            return $this->css_vars;
        }

        /**
         * Output dynamic CSS in head
         */
        public function output_dynamic_css() {
            $css_vars = $this->generate_css_vars();
            
            $css = ":root {\n";
            foreach ($css_vars as $var => $value) {
                $css .= "  {$var}: {$value};\n";
            }
            $css .= "}\n\n";

            // Generate utility classes that use CSS variables
            $css .= $this->generate_utility_classes();

            echo "<style id='erdu-dynamic-css'>\n" . wp_strip_all_tags($css) . "\n</style>\n";
        }

        /**
         * Generate utility classes using CSS variables
         */
        private function generate_utility_classes() {
            return "
/* Dynamic Color Utilities */
.erdu-text-primary { color: var(--erdu-primary) !important; }
.erdu-bg-primary { background-color: var(--erdu-primary) !important; }
.erdu-border-primary { border-color: var(--erdu-primary) !important; }
.erdu-text-secondary { color: var(--erdu-secondary) !important; }
.erdu-bg-secondary { background-color: var(--erdu-secondary) !important; }

/* Hover states */
.erdu-hover-primary:hover { background-color: var(--erdu-primary-hover) !important; }
.erdu-hover-text:hover { color: var(--erdu-primary) !important; }

/* Footer specific */
.erdu-footer-bg { background-color: var(--erdu-footer-bg) !important; }
.erdu-footer-text { color: var(--erdu-footer-text) !important; }
.erdu-footer-heading { color: var(--erdu-footer-heading) !important; }
.erdu-footer-hover:hover { color: var(--erdu-footer-hover) !important; }
.erdu-footer-border { border-color: var(--erdu-footer-border) !important; }
";
        }

        /**
         * Get a single CSS variable value
         */
        public function get_var($var_name, $fallback = '') {
            if (empty($this->css_vars)) {
                $this->generate_css_vars();
            }
            
            $full_var = '--erdu-' . $var_name;
            return isset($this->css_vars[$full_var]) ? $this->css_vars[$full_var] : $fallback;
        }

        /**
         * Get CSS variable reference for use in inline styles
         */
        public static function var_ref($var_name, $fallback = '') {
            $instance = self::get_instance();
            $value = $instance->get_var($var_name, $fallback);
            return $value ? "var(--erdu-{$var_name}, {$value})" : "var(--erdu-{$var_name})";
        }
    }
}
