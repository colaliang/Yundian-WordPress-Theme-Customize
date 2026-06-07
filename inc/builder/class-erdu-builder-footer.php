<?php
/**
 * ERDU Builder Footer Loader
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Erdu_Builder_Footer')) {

    class Erdu_Builder_Footer {

        private static $instance = null;
        private $footer_settings = array();
        private $theme_settings = array();

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
            
            $this->theme_settings = get_option('erdu_settings', erdu_default_settings());
            
            if (function_exists('erdu_footer_field')) {
                // Inherit global theme colors instead of redefining them in Footer ACF
                $colors = erdu_get_theme_colors();
                
                $this->footer_settings = array(
                    'bg_color'      => '#111827', // Default dark gray for footer bg
                    'text_color'    => '#9ca3af', // Gray 400
                    'heading_color' => '#ffffff', // White
                    'hover_color'   => $colors['primary'] ?? '#F37021',
                    'border_color'  => '#374151', // Gray 700
                    
                    'logo_type'     => erdu_footer_field('ft_logo_type', 'text'),
                    'logo_image'    => erdu_footer_field('ft_logo_image', ''),
                    'logo_text'     => erdu_footer_field('ft_logo_text', 'ERDU LIGHTING'),
                    'logo_icon'     => erdu_footer_field('ft_logo_icon', true),
                    'logo_icon_t'   => erdu_footer_field('ft_logo_icon_text', 'E'),
                    'about'         => erdu_footer_field('ft_about', 'Professional 48V Magnetic Track Light Manufacturer since 2009. 6300m² factory, 100+ employees, exporting to 20+ countries.'),
                    
                    'social_show'   => erdu_footer_field('ft_social_show', true),
                    
                    'quick_show'    => erdu_footer_field('ft_quicklinks_show', true),
                    'quick_title'   => erdu_footer_field('ft_quicklinks_title', __('Quick Links', 'erdu-wp')),
                    'quick_links'   => erdu_footer_field('ft_quicklinks', array()),
                    
                    'contact_show'  => erdu_footer_field('ft_contact_show', true),
                    'contact_title' => erdu_footer_field('ft_contact_title', __('Contact Info', 'erdu-wp')),
                    
                    'news_show'     => erdu_footer_field('ft_newsletter_show', true),
                    'news_title'    => erdu_footer_field('ft_newsletter_title', __('Newsletter', 'erdu-wp')),
                    'news_desc'     => erdu_footer_field('ft_newsletter_desc', __('Stay updated with latest products & lighting trends.', 'erdu-wp')),
                    'news_ph'       => erdu_footer_field('ft_newsletter_placeholder', __('Your email', 'erdu-wp')),
                    'news_btn'      => erdu_footer_field('ft_newsletter_button', __('Subscribe', 'erdu-wp')),
                    'news_footer'   => erdu_footer_field('ft_newsletter_footer', __('Join 500+ lighting professionals who trust our updates.', 'erdu-wp')),
                    
                    'copy_text'     => erdu_footer_field('ft_copyright_text', '© {year} ERDU Lighting Technology Co., Ltd. All Rights Reserved.'),
                    'copy_links'    => erdu_footer_field('ft_copyright_links', array()),
                );
            }
        }

        private function load_components() {
            require_once ERDU_DIR . '/inc/builder/footer/class-erdu-footer-about.php';
            require_once ERDU_DIR . '/inc/builder/footer/class-erdu-footer-links.php';
            require_once ERDU_DIR . '/inc/builder/footer/class-erdu-footer-contact.php';
            require_once ERDU_DIR . '/inc/builder/footer/class-erdu-footer-newsletter.php';
            require_once ERDU_DIR . '/inc/builder/footer/class-erdu-footer-copyright.php';
        }

        private function setup_hooks() {
            add_action('erdu_primary_footer', array($this, 'render_primary_footer_wrapper_start'), 1);
            
            // Primary Footer Items (Columns)
            add_action('erdu_primary_footer', array($this, 'render_about_column'), 10);
            add_action('erdu_primary_footer', array($this, 'render_links_column'), 20);
            add_action('erdu_primary_footer', array($this, 'render_contact_column'), 30);
            add_action('erdu_primary_footer', array($this, 'render_newsletter_column'), 40);
            
            add_action('erdu_primary_footer', array($this, 'render_primary_footer_wrapper_end'), 99);

            // Below Footer
            add_action('erdu_below_footer', array($this, 'render_copyright'), 10);
        }

        public function render_primary_footer_wrapper_start() {
            $col_count = 0;
            if ($this->footer_settings['about'] || $this->footer_settings['social_show']) $col_count++;
            if ($this->footer_settings['quick_show'] && $this->footer_settings['quick_links']) $col_count++;
            if ($this->footer_settings['contact_show']) $col_count++;
            if ($this->footer_settings['news_show']) $col_count++;
            
            $grid_class = 'grid-cols-1';
            if ($col_count >= 2) $grid_class .= ' md:grid-cols-2';
            if ($col_count >= 3) $grid_class .= ' lg:grid-cols-' . min($col_count, 4);

            echo '<div class="grid ' . esc_attr($grid_class) . ' gap-8" style="color: ' . esc_attr($this->footer_settings['text_color']) . ';">';
        }

        public function render_primary_footer_wrapper_end() {
            echo '</div>'; // End grid
        }

        public function render_about_column() {
            Erdu_Footer_About::render($this->footer_settings, $this->theme_settings);
        }

        public function render_links_column() {
            Erdu_Footer_Links::render($this->footer_settings);
        }

        public function render_contact_column() {
            Erdu_Footer_Contact::render($this->footer_settings, $this->theme_settings);
        }

        public function render_newsletter_column() {
            Erdu_Footer_Newsletter::render($this->footer_settings, $this->theme_settings);
        }

        public function render_copyright() {
            Erdu_Footer_Copyright::render($this->footer_settings);
        }
        
        public function get_bg_color() {
            return $this->footer_settings['bg_color'] ?? '#1a1a2e';
        }
    }
}