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

        public static function get_instance() {
            if (is_null(self::$instance)) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        public function __construct() {
            $this->load_components();
            $this->setup_hooks();
        }

        private function load_components() {
            require_once ERDU_DIR . '/inc/builder/header/class-erdu-header-logo.php';
            require_once ERDU_DIR . '/inc/builder/header/class-erdu-header-menu.php';
            require_once ERDU_DIR . '/inc/builder/header/class-erdu-header-button.php';
            require_once ERDU_DIR . '/inc/builder/header/class-erdu-header-mobile-trigger.php';
        }

        private function setup_hooks() {
            // Primary Header Items
            add_action('erdu_primary_header', array('Erdu_Header_Logo', 'render'), 10);
            add_action('erdu_primary_header', array('Erdu_Header_Menu', 'render_desktop'), 20);
            add_action('erdu_primary_header', array('Erdu_Header_Button', 'render'), 30);
            add_action('erdu_primary_header', array('Erdu_Header_Mobile_Trigger', 'render'), 40);

            // After Header (Mobile Menu)
            add_action('erdu_after_header', array('Erdu_Header_Menu', 'render_mobile'), 10);
        }
    }
}
