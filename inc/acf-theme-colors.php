<?php
/**
 * ACF Theme Color Settings
 * Provides color customization options in ACF Options Page
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) exit;

// Only run if ACF is active
if (!function_exists('acf_add_local_field_group')) {
    return;
}

add_action('acf/init', 'erdu_register_theme_color_fields');

function erdu_register_theme_color_fields() {
    
    // Register Options Page for Theme Colors
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page(array(
            'page_title'    => __('Theme Colors', 'erdu-wp'),
            'menu_title'    => __('Theme Colors', 'erdu-wp'),
            'menu_slug'     => 'erdu-theme-colors',
            'parent_slug'   => 'erdu-dashboard',
            'capability'    => 'manage_options',
            'redirect'      => false,
            'icon_url'      => 'dashicons-art',
            'position'      => 6,
        ));
    }

    // Theme Color Fields
    acf_add_local_field_group(array(
        'key'      => 'group_theme_colors',
        'title'    => __('Theme Color Settings', 'erdu-wp'),
        'fields'   => array(
            array(
                'key'   => 'field_color_tab_brand',
                'label' => __('Brand Colors', 'erdu-wp'),
                'name'  => '',
                'type'  => 'tab',
            ),
            array(
                'key'           => 'field_primary_color',
                'label'         => __('Primary Color', 'erdu-wp'),
                'name'          => 'erdu_primary_color',
                'type'          => 'color_picker',
                'default_value' => '#F37021',
                'instructions'  => __('Main brand color used for buttons, links, and highlights', 'erdu-wp'),
            ),
            array(
                'key'           => 'field_primary_hover',
                'label'         => __('Primary Hover Color', 'erdu-wp'),
                'name'          => 'erdu_primary_hover',
                'type'          => 'color_picker',
                'default_value' => '#E05D10',
                'instructions'  => __('Hover state for primary color elements', 'erdu-wp'),
            ),
            array(
                'key'           => 'field_secondary_color',
                'label'         => __('Secondary Color', 'erdu-wp'),
                'name'          => 'erdu_secondary_color',
                'type'          => 'color_picker',
                'default_value' => '#2D1810',
                'instructions'  => __('Secondary brand color for dark backgrounds and accents', 'erdu-wp'),
            ),
            
            array(
                'key'   => 'field_color_tab_text',
                'label' => __('Text Colors', 'erdu-wp'),
                'name'  => '',
                'type'  => 'tab',
            ),
            array(
                'key'           => 'field_text_color',
                'label'         => __('Primary Text Color', 'erdu-wp'),
                'name'          => 'erdu_text_color',
                'type'          => 'color_picker',
                'default_value' => '#333333',
                'instructions'  => __('Main body text color', 'erdu-wp'),
            ),
            array(
                'key'           => 'field_text_light',
                'label'         => __('Light Text Color', 'erdu-wp'),
                'name'          => 'erdu_text_light',
                'type'          => 'color_picker',
                'default_value' => '#6b7280',
                'instructions'  => __('Secondary/muted text color', 'erdu-wp'),
            ),
            
            array(
                'key'   => 'field_color_tab_background',
                'label' => __('Background Colors', 'erdu-wp'),
                'name'  => '',
                'type'  => 'tab',
            ),
            array(
                'key'           => 'field_bg_dark',
                'label'         => __('Dark Background', 'erdu-wp'),
                'name'          => 'erdu_bg_dark',
                'type'          => 'color_picker',
                'default_value' => '#1a1a2e',
                'instructions'  => __('Dark background for sections and footer', 'erdu-wp'),
            ),
            array(
                'key'           => 'field_bg_light',
                'label'         => __('Light Background', 'erdu-wp'),
                'name'          => 'erdu_bg_light',
                'type'          => 'color_picker',
                'default_value' => '#f9fafb',
                'instructions'  => __('Light background for alternate sections', 'erdu-wp'),
            ),
            array(
                'key'           => 'field_border_color',
                'label'         => __('Border Color', 'erdu-wp'),
                'name'          => 'erdu_border_color',
                'type'          => 'color_picker',
                'default_value' => '#e5e7eb',
                'instructions'  => __('Default border color', 'erdu-wp'),
            ),
            
            array(
                'key'   => 'field_color_tab_footer',
                'label' => __('Footer Colors', 'erdu-wp'),
                'name'  => '',
                'type'  => 'tab',
            ),
            array(
                'key'           => 'field_footer_bg',
                'label'         => __('Footer Background', 'erdu-wp'),
                'name'          => 'erdu_footer_bg',
                'type'          => 'color_picker',
                'default_value' => '#1a1a2e',
                'instructions'  => __('Footer background color', 'erdu-wp'),
            ),
            array(
                'key'           => 'field_footer_text',
                'label'         => __('Footer Text Color', 'erdu-wp'),
                'name'          => 'erdu_footer_text',
                'type'          => 'color_picker',
                'default_value' => '#9ca3af',
                'instructions'  => __('Footer text color', 'erdu-wp'),
            ),
            array(
                'key'           => 'field_footer_heading',
                'label'         => __('Footer Heading Color', 'erdu-wp'),
                'name'          => 'erdu_footer_heading',
                'type'          => 'color_picker',
                'default_value' => '#ffffff',
                'instructions'  => __('Footer heading/title color', 'erdu-wp'),
            ),
            array(
                'key'           => 'field_footer_hover',
                'label'         => __('Footer Link Hover', 'erdu-wp'),
                'name'          => 'erdu_footer_hover',
                'type'          => 'color_picker',
                'default_value' => '#F37021',
                'instructions'  => __('Footer link hover color', 'erdu-wp'),
            ),
            array(
                'key'           => 'field_footer_border',
                'label'         => __('Footer Border Color', 'erdu-wp'),
                'name'          => 'erdu_footer_border',
                'type'          => 'color_picker',
                'default_value' => '#374151',
                'instructions'  => __('Footer border/divider color', 'erdu-wp'),
            ),
        ),
        'location' => array(
            array(
                array('param' => 'options_page', 'operator' => '==', 'value' => 'erdu-theme-colors'),
            ),
        ),
        'position' => 'normal',
        'style'    => 'default',
    ));
}
