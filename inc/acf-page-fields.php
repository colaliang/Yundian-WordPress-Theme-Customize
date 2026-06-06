<?php
/**
 * ACF Page Content Fields
 * Provides editable content for each page template via ACF
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) exit;

// ==========================================
// Helper: Get ACF field value with fallback
// ==========================================

/**
 * Get ACF field value for the current page with fallback.
 *
 * Must be called inside a standard WordPress Loop (after the_post())
 * or on a singular page where the global $post is set.
 *
 * @param string $field_name ACF field name.
 * @param mixed  $default    Default value if field is empty.
 * @return mixed Field value or default.
 */
function erdu_page_field($field_name, $default = '')
{
    if (!function_exists('get_field')) {
        return $default;
    }

    // Let ACF auto-detect the current post — most reliable inside the Loop.
    $value = get_field($field_name);

    // Fallback: try with explicit post ID.
    if (($value === null || $value === '' || $value === false) && get_the_ID()) {
        $value = get_field($field_name, get_the_ID());
    }

    if ($value === null || $value === '' || $value === false) {
        return $default;
    }

    // Repeater fields return arrays — treat empty arrays as "no value".
    if (is_array($value) && empty($value)) {
        return $default;
    }

    return $value;
}

/**
 * Check if an ACF page field has a non-empty value.
 */
function erdu_has_page_field($field_name)
{
    if (!function_exists('get_field')) {
        return false;
    }

    $value = get_field($field_name);

    if (($value === null || $value === '' || $value === false) && get_the_ID()) {
        $value = get_field($field_name, get_the_ID());
    }

    return !($value === null || $value === '' || $value === false || (is_array($value) && empty($value)));
}

// ==========================================
// Register ACF Field Groups
// ==========================================

add_action('acf/init', 'erdu_register_page_field_groups');

function erdu_register_page_field_groups()
{
    // --- 1. Universal Page Fields (all pages) ---
    acf_add_local_field_group(array(
        'key'    => 'group_page_universal',
        'title'  => __('Page Settings', 'erdu-wp'),
        'fields' => array(
            array(
                'key'   => 'field_page_subtitle',
                'label' => __('Page Subtitle', 'erdu-wp'),
                'name'  => 'page_subtitle',
                'type'  => 'text',
            ),
            array(
                'key'           => 'field_page_hero_bg',
                'label'         => __('Hero Background Image', 'erdu-wp'),
                'name'          => 'page_hero_bg',
                'type'          => 'image',
                'return_format' => 'url',
                'preview_size'  => 'medium',
            ),
            array(
                'key'           => 'field_page_editor',
                'label'         => __('Page Content', 'erdu-wp'),
                'name'          => 'page_editor',
                'type'          => 'wysiwyg',
                'tabs'          => 'all',
                'toolbar'       => 'full',
                'media_upload'  => 1,
            ),
            array(
                'key'   => 'field_cta_override',
                'label' => __('Override CTA Section', 'erdu-wp'),
                'name'  => 'cta_override',
                'type'  => 'true_false',
                'ui'    => 1,
            ),
            array(
                'key'               => 'field_cta_title',
                'label'             => __('CTA Title', 'erdu-wp'),
                'name'              => 'cta_title',
                'type'              => 'text',
                'conditional_logic' => array(array(array('field' => 'field_cta_override', 'operator' => '==', 'value' => '1'))),
            ),
            array(
                'key'               => 'field_cta_button',
                'label'             => __('CTA Button Text', 'erdu-wp'),
                'name'              => 'cta_button',
                'type'              => 'text',
                'conditional_logic' => array(array(array('field' => 'field_cta_override', 'operator' => '==', 'value' => '1'))),
            ),
            array(
                'key'               => 'field_cta_link',
                'label'             => __('CTA Button Link', 'erdu-wp'),
                'name'              => 'cta_link',
                'type'              => 'url',
                'conditional_logic' => array(array(array('field' => 'field_cta_override', 'operator' => '==', 'value' => '1'))),
            ),
        ),
        'location'   => array(
            array(
                array('param' => 'post_type', 'operator' => '==', 'value' => 'page'),
                array('param' => 'page_template', 'operator' => '!=', 'value' => 'front-page.php'),
                array('param' => 'page_template', 'operator' => '!=', 'value' => 'page-about.php'),
                array('param' => 'page_template', 'operator' => '!=', 'value' => 'page-home.php'),
                array('param' => 'page_template', 'operator' => '!=', 'value' => 'page-products.php'),
                array('param' => 'page_template', 'operator' => '!=', 'value' => 'page-solutions.php'),
                array('param' => 'page_template', 'operator' => '!=', 'value' => 'page-quality.php'),
                array('param' => 'page_template', 'operator' => '!=', 'value' => 'page-distributor.php'),
                array('param' => 'page_template', 'operator' => '!=', 'value' => 'page-cases.php'),
                array('param' => 'page_template', 'operator' => '!=', 'value' => 'page-news.php'),
                array('param' => 'page_template', 'operator' => '!=', 'value' => 'page-blog.php'),
                array('param' => 'page_template', 'operator' => '!=', 'value' => 'page-contact.php'),
            ),
        ),
        'position'   => 'normal',
        'style'      => 'default',
        'menu_order' => 0,
    ));

    // --- 2. About Page Fields ---
    acf_add_local_field_group(array(
        'key'    => 'group_page_about',
        'title'  => __('About Page Content', 'erdu-wp'),
        'fields' => array(
            // --- Hero Tab ---
            array('key' => 'field_about_tab_hero', 'label' => __('Hero Banner', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_about_hero_title', 'label' => __('Hero Title', 'erdu-wp'), 'name' => 'about_hero_title', 'type' => 'text'),
            array('key' => 'field_about_hero_subtitle', 'label' => __('Hero Subtitle', 'erdu-wp'), 'name' => 'about_hero_subtitle', 'type' => 'textarea', 'rows' => 2),
            array('key' => 'field_about_hero_bg', 'label' => __('Hero Background Image', 'erdu-wp'), 'name' => 'about_hero_bg', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium'),
            array('key' => 'field_about_hero_btn', 'label' => __('Primary Button Text', 'erdu-wp'), 'name' => 'about_hero_btn', 'type' => 'text'),
            array('key' => 'field_about_hero_btn_link', 'label' => __('Primary Button Link', 'erdu-wp'), 'name' => 'about_hero_btn_link', 'type' => 'page_link', 'allow_null' => 1),
            array('key' => 'field_about_hero_btn2', 'label' => __('Secondary Button Text', 'erdu-wp'), 'name' => 'about_hero_btn2', 'type' => 'text'),
            array('key' => 'field_about_hero_btn2_link', 'label' => __('Secondary Button Link', 'erdu-wp'), 'name' => 'about_hero_btn2_link', 'type' => 'page_link', 'allow_null' => 1),

            // --- Page Content Tab ---
            array('key' => 'field_about_tab_content', 'label' => __('Page Content', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_about_page_editor', 'label' => __('Content (between Hero and Tabs)', 'erdu-wp'), 'name' => 'about_page_editor', 'type' => 'wysiwyg', 'toolbar' => 'full', 'tabs' => 'all', 'media_upload' => 1),

            // --- Profile Tab ---
            array('key' => 'field_about_tab_profile', 'label' => __('Company Profile', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_about_highlight', 'label' => __('Highlight Text (orange box)', 'erdu-wp'), 'name' => 'about_highlight', 'type' => 'textarea', 'rows' => 2),
            array('key' => 'field_about_company_intro', 'label' => __('Company Introduction', 'erdu-wp'), 'name' => 'about_company_intro', 'type' => 'wysiwyg', 'toolbar' => 'full', 'tabs' => 'all'),
            array('key' => 'field_about_profile_image', 'label' => __('Profile Image', 'erdu-wp'), 'name' => 'about_profile_image', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium'),
            array('key' => 'field_about_profile_stats', 'label' => __('Info Boxes', 'erdu-wp'), 'name' => 'about_profile_stats', 'type' => 'repeater', 'button_label' => __('Add Info Box', 'erdu-wp'), 'sub_fields' => array(
                array('key' => 'field_aps_label', 'label' => __('Label', 'erdu-wp'), 'name' => 'label', 'type' => 'text', 'required' => 1),
                array('key' => 'field_aps_value', 'label' => __('Value', 'erdu-wp'), 'name' => 'value', 'type' => 'text', 'required' => 1),
            )),
            array('key' => 'field_about_team', 'label' => __('Leadership Team', 'erdu-wp'), 'name' => 'about_team', 'type' => 'repeater', 'button_label' => __('Add Member', 'erdu-wp'), 'sub_fields' => array(
                array('key' => 'field_tm_name', 'label' => __('Name', 'erdu-wp'), 'name' => 'name', 'type' => 'text', 'required' => 1),
                array('key' => 'field_tm_role', 'label' => __('Role', 'erdu-wp'), 'name' => 'role', 'type' => 'text'),
                array('key' => 'field_tm_bio', 'label' => __('Bio', 'erdu-wp'), 'name' => 'bio', 'type' => 'textarea', 'rows' => 2),
            )),

            // --- Timeline Tab ---
            array('key' => 'field_about_tab_timeline', 'label' => __('Our Journey', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_about_timeline', 'label' => __('Timeline Events', 'erdu-wp'), 'name' => 'about_timeline', 'type' => 'repeater', 'button_label' => __('Add Event', 'erdu-wp'), 'sub_fields' => array(
                array('key' => 'field_tl_year', 'label' => __('Year', 'erdu-wp'), 'name' => 'year', 'type' => 'text', 'required' => 1),
                array('key' => 'field_tl_title', 'label' => __('Title', 'erdu-wp'), 'name' => 'title', 'type' => 'text', 'required' => 1),
                array('key' => 'field_tl_desc', 'label' => __('Description', 'erdu-wp'), 'name' => 'description', 'type' => 'textarea', 'rows' => 2),
            )),

            // --- Values Tab ---
            array('key' => 'field_about_tab_values', 'label' => __('Mission & Values', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_about_mission_title', 'label' => __('Mission Section Title', 'erdu-wp'), 'name' => 'about_mission_title', 'type' => 'text'),
            array('key' => 'field_about_mission_text', 'label' => __('Mission Statement', 'erdu-wp'), 'name' => 'about_mission_text', 'type' => 'textarea', 'rows' => 3),
            array('key' => 'field_about_values', 'label' => __('Company Values', 'erdu-wp'), 'name' => 'about_values', 'type' => 'repeater', 'button_label' => __('Add Value', 'erdu-wp'), 'sub_fields' => array(
                array('key' => 'field_val_title', 'label' => __('Title', 'erdu-wp'), 'name' => 'title', 'type' => 'text', 'required' => 1),
                array('key' => 'field_val_desc', 'label' => __('Description', 'erdu-wp'), 'name' => 'description', 'type' => 'textarea', 'rows' => 2),
            )),

            // --- Factory Tab ---
            array('key' => 'field_about_tab_factory', 'label' => __('Factory Tour', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_about_factory_title', 'label' => __('Factory Section Title', 'erdu-wp'), 'name' => 'about_factory_title', 'type' => 'text'),
            array('key' => 'field_about_factory_images', 'label' => __('Factory Images', 'erdu-wp'), 'name' => 'about_factory_images', 'type' => 'repeater', 'button_label' => __('Add Image', 'erdu-wp'), 'sub_fields' => array(
                array('key' => 'field_fimg_url', 'label' => __('Image', 'erdu-wp'), 'name' => 'url', 'type' => 'image', 'return_format' => 'url'),
                array('key' => 'field_fimg_caption', 'label' => __('Caption', 'erdu-wp'), 'name' => 'caption', 'type' => 'text'),
            )),
            array('key' => 'field_about_factory_stats', 'label' => __('Factory Stats', 'erdu-wp'), 'name' => 'about_factory_stats', 'type' => 'repeater', 'button_label' => __('Add Stat', 'erdu-wp'), 'sub_fields' => array(
                array('key' => 'field_fstat_label', 'label' => __('Label', 'erdu-wp'), 'name' => 'label', 'type' => 'text', 'required' => 1),
                array('key' => 'field_fstat_value', 'label' => __('Value', 'erdu-wp'), 'name' => 'value', 'type' => 'text', 'required' => 1),
            )),

            // --- Partners Tab ---
            array('key' => 'field_about_tab_partners', 'label' => __('Supply Chain Partners', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_about_partners_title', 'label' => __('Section Title', 'erdu-wp'), 'name' => 'about_partners_title', 'type' => 'text'),
            array('key' => 'field_about_partners_list', 'label' => __('Partners', 'erdu-wp'), 'name' => 'about_partners_list', 'type' => 'repeater', 'button_label' => __('Add Partner', 'erdu-wp'), 'sub_fields' => array(
                array('key' => 'field_ptn_logo', 'label' => __('Partner Logo', 'erdu-wp'), 'name' => 'logo', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'thumbnail'),
                array('key' => 'field_ptn_name', 'label' => __('Partner Name', 'erdu-wp'), 'name' => 'name', 'type' => 'text', 'required' => 1),
                array('key' => 'field_ptn_category', 'label' => __('Category / Type', 'erdu-wp'), 'name' => 'category', 'type' => 'text'),
            )),

            // --- Certifications Tab ---
            array('key' => 'field_about_tab_certs', 'label' => __('Certifications', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_about_certs_title', 'label' => __('Section Title', 'erdu-wp'), 'name' => 'about_certs_title', 'type' => 'text'),
            array('key' => 'field_about_certs_list', 'label' => __('Certifications', 'erdu-wp'), 'name' => 'about_certs_list', 'type' => 'repeater', 'button_label' => __('Add Certificate', 'erdu-wp'), 'sub_fields' => array(
                array('key' => 'field_ac_icon', 'label' => __('Certificate Icon / Badge', 'erdu-wp'), 'name' => 'icon', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'thumbnail'),
                array('key' => 'field_ac_name', 'label' => __('Certificate Name', 'erdu-wp'), 'name' => 'name', 'type' => 'text', 'required' => 1),
                array('key' => 'field_ac_org', 'label' => __('Issuing Organization', 'erdu-wp'), 'name' => 'org', 'type' => 'text'),
                array('key' => 'field_ac_scope', 'label' => __('Scope / Region', 'erdu-wp'), 'name' => 'scope', 'type' => 'text'),
            )),

            // --- CTA Tab ---
            array('key' => 'field_about_tab_cta', 'label' => __('CTA Section', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_about_cta_override', 'label' => __('Override CTA', 'erdu-wp'), 'name' => 'about_cta_override', 'type' => 'true_false', 'ui' => 1),
            array('key' => 'field_about_cta_title', 'label' => __('CTA Title', 'erdu-wp'), 'name' => 'about_cta_title', 'type' => 'text', 'conditional_logic' => array(array(array('field' => 'field_about_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_about_cta_button', 'label' => __('Primary Button Text', 'erdu-wp'), 'name' => 'about_cta_button', 'type' => 'text', 'conditional_logic' => array(array(array('field' => 'field_about_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_about_cta_link', 'label' => __('Primary Button Link', 'erdu-wp'), 'name' => 'about_cta_link', 'type' => 'page_link', 'allow_null' => 1, 'conditional_logic' => array(array(array('field' => 'field_about_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_about_cta_button2', 'label' => __('Secondary Button Text', 'erdu-wp'), 'name' => 'about_cta_button2', 'type' => 'text', 'conditional_logic' => array(array(array('field' => 'field_about_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_about_cta_link2', 'label' => __('Secondary Button Link', 'erdu-wp'), 'name' => 'about_cta_link2', 'type' => 'page_link', 'allow_null' => 1, 'conditional_logic' => array(array(array('field' => 'field_about_cta_override', 'operator' => '==', 'value' => '1')))),
        ),
        'location'   => array(array(array('param' => 'page_template', 'operator' => '==', 'value' => 'page-about.php'))),
        'position'   => 'normal',
        'style'      => 'default',
        'menu_order' => 5,
    ));

    // --- 3. Quality Page Fields ---
    acf_add_local_field_group(array(
        'key'    => 'group_page_quality',
        'title'  => __('Quality Page Content', 'erdu-wp'),
        'fields' => array(
            // --- Hero Tab ---
            array('key' => 'field_quality_tab_hero', 'label' => __('Hero Banner', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_quality_hero_title', 'label' => __('Hero Title', 'erdu-wp'), 'name' => 'quality_hero_title', 'type' => 'text'),
            array('key' => 'field_quality_hero_subtitle', 'label' => __('Hero Subtitle', 'erdu-wp'), 'name' => 'quality_hero_subtitle', 'type' => 'textarea', 'rows' => 2),
            array('key' => 'field_quality_hero_bg', 'label' => __('Hero Background Image', 'erdu-wp'), 'name' => 'quality_hero_bg', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium'),
            array('key' => 'field_quality_hero_btn', 'label' => __('Primary Button Text', 'erdu-wp'), 'name' => 'quality_hero_btn', 'type' => 'text'),
            array('key' => 'field_quality_hero_btn_link', 'label' => __('Primary Button Link', 'erdu-wp'), 'name' => 'quality_hero_btn_link', 'type' => 'page_link', 'allow_null' => 1),
            array('key' => 'field_quality_hero_btn2', 'label' => __('Secondary Button Text', 'erdu-wp'), 'name' => 'quality_hero_btn2', 'type' => 'text'),
            array('key' => 'field_quality_hero_btn2_link', 'label' => __('Secondary Button Link', 'erdu-wp'), 'name' => 'quality_hero_btn2_link', 'type' => 'page_link', 'allow_null' => 1),

            // --- Page Content Tab ---
            array('key' => 'field_quality_tab_content', 'label' => __('Page Content', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_quality_page_editor', 'label' => __('Content (between Hero and Quality Intro)', 'erdu-wp'), 'name' => 'quality_page_editor', 'type' => 'wysiwyg', 'toolbar' => 'full', 'tabs' => 'all', 'media_upload' => 1),

            // --- Intro Tab ---
            array('key' => 'field_quality_tab_intro', 'label' => __('Introduction', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_quality_intro', 'label' => __('Quality Introduction', 'erdu-wp'), 'name' => 'quality_intro', 'type' => 'wysiwyg', 'toolbar' => 'full'),

            // --- Process Tab ---
            array('key' => 'field_quality_tab_process', 'label' => __('5-Step Process', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_quality_steps', 'label' => __('QC Process Steps', 'erdu-wp'), 'name' => 'quality_steps', 'type' => 'repeater', 'button_label' => __('Add Step', 'erdu-wp'), 'sub_fields' => array(
                array('key' => 'field_qs_icon', 'label' => __('SVG Icon Path (d attribute)', 'erdu-wp'), 'name' => 'icon', 'type' => 'text'),
                array('key' => 'field_qs_title', 'label' => __('Step Title', 'erdu-wp'), 'name' => 'title', 'type' => 'text', 'required' => 1),
                array('key' => 'field_qs_desc', 'label' => __('Description', 'erdu-wp'), 'name' => 'description', 'type' => 'textarea', 'rows' => 2),
            )),
            array('key' => 'field_quality_process', 'label' => __('Additional QC Steps (ACF Override)', 'erdu-wp'), 'name' => 'quality_process', 'type' => 'repeater', 'button_label' => __('Add Step', 'erdu-wp'), 'sub_fields' => array(
                array('key' => 'field_qp_step', 'label' => __('Step Number', 'erdu-wp'), 'name' => 'step', 'type' => 'number', 'required' => 1, 'min' => 1),
                array('key' => 'field_qp_title', 'label' => __('Step Title', 'erdu-wp'), 'name' => 'title', 'type' => 'text', 'required' => 1),
                array('key' => 'field_qp_desc', 'label' => __('Description', 'erdu-wp'), 'name' => 'description', 'type' => 'textarea', 'rows' => 2),
            )),

            // --- Certs Tab ---
            array('key' => 'field_quality_tab_certs', 'label' => __('Certifications', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_quality_certs', 'label' => __('Certifications', 'erdu-wp'), 'name' => 'quality_certs', 'type' => 'repeater', 'button_label' => __('Add Certificate', 'erdu-wp'), 'sub_fields' => array(
                array('key' => 'field_qc_name', 'label' => __('Certificate Name', 'erdu-wp'), 'name' => 'name', 'type' => 'text', 'required' => 1),
                array('key' => 'field_qc_org', 'label' => __('Issuing Organization', 'erdu-wp'), 'name' => 'org', 'type' => 'text'),
                array('key' => 'field_qc_valid', 'label' => __('Valid Until', 'erdu-wp'), 'name' => 'valid', 'type' => 'text'),
            )),

            // --- Parameters Tab ---
            array('key' => 'field_quality_tab_params', 'label' => __('Parameters', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_quality_params', 'label' => __('Quality Parameters', 'erdu-wp'), 'name' => 'quality_params', 'type' => 'repeater', 'button_label' => __('Add Parameter', 'erdu-wp'), 'sub_fields' => array(
                array('key' => 'field_qpar_name', 'label' => __('Parameter', 'erdu-wp'), 'name' => 'param', 'type' => 'text', 'required' => 1),
                array('key' => 'field_qpar_value', 'label' => __('Value', 'erdu-wp'), 'name' => 'value', 'type' => 'text', 'required' => 1),
            )),

            // --- CTA Tab ---
            array('key' => 'field_quality_tab_cta', 'label' => __('CTA Section', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_quality_cta_override', 'label' => __('Override CTA', 'erdu-wp'), 'name' => 'quality_cta_override', 'type' => 'true_false', 'ui' => 1),
            array('key' => 'field_quality_cta_title', 'label' => __('CTA Title', 'erdu-wp'), 'name' => 'quality_cta_title', 'type' => 'text', 'conditional_logic' => array(array(array('field' => 'field_quality_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_quality_cta_button', 'label' => __('Primary Button Text', 'erdu-wp'), 'name' => 'quality_cta_button', 'type' => 'text', 'conditional_logic' => array(array(array('field' => 'field_quality_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_quality_cta_link', 'label' => __('Primary Button Link', 'erdu-wp'), 'name' => 'quality_cta_link', 'type' => 'page_link', 'allow_null' => 1, 'conditional_logic' => array(array(array('field' => 'field_quality_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_quality_cta_button2', 'label' => __('Secondary Button Text', 'erdu-wp'), 'name' => 'quality_cta_button2', 'type' => 'text', 'conditional_logic' => array(array(array('field' => 'field_quality_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_quality_cta_link2', 'label' => __('Secondary Button Link', 'erdu-wp'), 'name' => 'quality_cta_link2', 'type' => 'page_link', 'allow_null' => 1, 'conditional_logic' => array(array(array('field' => 'field_quality_cta_override', 'operator' => '==', 'value' => '1')))),
        ),
        'location'   => array(array(array('param' => 'page_template', 'operator' => '==', 'value' => 'page-quality.php'))),
        'position'   => 'normal',
        'style'      => 'default',
        'menu_order' => 5,
    ));

    // --- 4. Products Page Fields ---
    acf_add_local_field_group(array(
        'key'    => 'group_page_products',
        'title'  => __('Products Page Content', 'erdu-wp'),
        'fields' => array(
            // --- Hero Tab ---
            array('key' => 'field_products_tab_hero', 'label' => __('Hero Banner', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_products_hero_title', 'label' => __('Hero Title', 'erdu-wp'), 'name' => 'products_hero_title', 'type' => 'text'),
            array('key' => 'field_products_hero_subtitle', 'label' => __('Hero Subtitle', 'erdu-wp'), 'name' => 'products_hero_subtitle', 'type' => 'textarea', 'rows' => 2),
            array('key' => 'field_products_hero_bg', 'label' => __('Hero Background Image', 'erdu-wp'), 'name' => 'products_hero_bg', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium'),
            array('key' => 'field_products_hero_btn', 'label' => __('Primary Button Text', 'erdu-wp'), 'name' => 'products_hero_btn', 'type' => 'text'),
            array('key' => 'field_products_hero_btn_link', 'label' => __('Primary Button Link', 'erdu-wp'), 'name' => 'products_hero_btn_link', 'type' => 'page_link', 'allow_null' => 1),
            array('key' => 'field_products_hero_btn2', 'label' => __('Secondary Button Text', 'erdu-wp'), 'name' => 'products_hero_btn2', 'type' => 'text'),
            array('key' => 'field_products_hero_btn2_link', 'label' => __('Secondary Button Link', 'erdu-wp'), 'name' => 'products_hero_btn2_link', 'type' => 'page_link', 'allow_null' => 1),

            // --- Page Content Tab ---
            array('key' => 'field_products_tab_content', 'label' => __('Page Content', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_products_page_editor', 'label' => __('Content (between Hero and Products Grid)', 'erdu-wp'), 'name' => 'products_page_editor', 'type' => 'wysiwyg', 'toolbar' => 'full', 'tabs' => 'all', 'media_upload' => 1),

            // --- Introduction Tab ---
            array('key' => 'field_products_tab_intro', 'label' => __('Introduction', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_products_intro', 'label' => __('Products Introduction', 'erdu-wp'), 'name' => 'products_intro', 'type' => 'wysiwyg', 'toolbar' => 'full'),

            // --- CTA Tab ---
            array('key' => 'field_products_tab_cta', 'label' => __('CTA Section', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_products_cta_override', 'label' => __('Override CTA', 'erdu-wp'), 'name' => 'products_cta_override', 'type' => 'true_false', 'ui' => 1),
            array('key' => 'field_products_cta_title', 'label' => __('CTA Title', 'erdu-wp'), 'name' => 'products_cta_title', 'type' => 'text', 'conditional_logic' => array(array(array('field' => 'field_products_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_products_cta_button', 'label' => __('Primary Button Text', 'erdu-wp'), 'name' => 'products_cta_button', 'type' => 'text', 'conditional_logic' => array(array(array('field' => 'field_products_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_products_cta_link', 'label' => __('Primary Button Link', 'erdu-wp'), 'name' => 'products_cta_link', 'type' => 'page_link', 'allow_null' => 1, 'conditional_logic' => array(array(array('field' => 'field_products_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_products_cta_button2', 'label' => __('Secondary Button Text', 'erdu-wp'), 'name' => 'products_cta_button2', 'type' => 'text', 'conditional_logic' => array(array(array('field' => 'field_products_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_products_cta_link2', 'label' => __('Secondary Button Link', 'erdu-wp'), 'name' => 'products_cta_link2', 'type' => 'page_link', 'allow_null' => 1, 'conditional_logic' => array(array(array('field' => 'field_products_cta_override', 'operator' => '==', 'value' => '1')))),
        ),
        'location'   => array(array(array('param' => 'page_template', 'operator' => '==', 'value' => 'page-products.php'))),
        'position'   => 'normal',
        'style'      => 'default',
        'menu_order' => 5,
    ));

    // --- 5. Solutions Page Fields ---
    acf_add_local_field_group(array(
        'key'    => 'group_page_solutions',
        'title'  => __('Solutions Page Content', 'erdu-wp'),
        'fields' => array(
            // --- Hero Tab ---
            array('key' => 'field_solutions_tab_hero', 'label' => __('Hero Banner', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_solutions_hero_title', 'label' => __('Hero Title', 'erdu-wp'), 'name' => 'solutions_hero_title', 'type' => 'text'),
            array('key' => 'field_solutions_hero_subtitle', 'label' => __('Hero Subtitle', 'erdu-wp'), 'name' => 'solutions_hero_subtitle', 'type' => 'textarea', 'rows' => 2),
            array('key' => 'field_solutions_hero_bg', 'label' => __('Hero Background Image', 'erdu-wp'), 'name' => 'solutions_hero_bg', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium'),
            array('key' => 'field_solutions_hero_btn', 'label' => __('Primary Button Text', 'erdu-wp'), 'name' => 'solutions_hero_btn', 'type' => 'text'),
            array('key' => 'field_solutions_hero_btn_link', 'label' => __('Primary Button Link', 'erdu-wp'), 'name' => 'solutions_hero_btn_link', 'type' => 'page_link', 'allow_null' => 1),
            array('key' => 'field_solutions_hero_btn2', 'label' => __('Secondary Button Text', 'erdu-wp'), 'name' => 'solutions_hero_btn2', 'type' => 'text'),
            array('key' => 'field_solutions_hero_btn2_link', 'label' => __('Secondary Button Link', 'erdu-wp'), 'name' => 'solutions_hero_btn2_link', 'type' => 'page_link', 'allow_null' => 1),

            // --- Page Content Tab ---
            array('key' => 'field_solutions_tab_content', 'label' => __('Page Content', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_solutions_page_editor', 'label' => __('Content (between Hero and Categories)', 'erdu-wp'), 'name' => 'solutions_page_editor', 'type' => 'wysiwyg', 'toolbar' => 'full', 'tabs' => 'all', 'media_upload' => 1),

            // --- Introduction Tab ---
            array('key' => 'field_solutions_tab_intro', 'label' => __('Introduction', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_solutions_intro', 'label' => __('Solutions Introduction', 'erdu-wp'), 'name' => 'solutions_intro', 'type' => 'wysiwyg', 'toolbar' => 'full'),

            // --- Categories Tab ---
            array('key' => 'field_solutions_tab_categories', 'label' => __('Categories', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_solutions_categories', 'label' => __('Solution Categories', 'erdu-wp'), 'name' => 'solutions_categories', 'type' => 'repeater', 'button_label' => __('Add Category', 'erdu-wp'), 'sub_fields' => array(
                array('key' => 'field_sc_key', 'label' => __('Category Key (slug)', 'erdu-wp'), 'name' => 'key', 'type' => 'text'),
                array('key' => 'field_sc_name', 'label' => __('Category Name', 'erdu-wp'), 'name' => 'name', 'type' => 'text', 'required' => 1),
                array('key' => 'field_sc_desc', 'label' => __('Description', 'erdu-wp'), 'name' => 'description', 'type' => 'textarea', 'rows' => 2),
                array('key' => 'field_sc_image', 'label' => __('Image', 'erdu-wp'), 'name' => 'image', 'type' => 'image', 'return_format' => 'url'),
                array('key' => 'field_sc_link', 'label' => __('Detail Page Link', 'erdu-wp'), 'name' => 'link', 'type' => 'page_link', 'allow_null' => 1),
            )),

            // --- CTA Tab ---
            array('key' => 'field_solutions_tab_cta', 'label' => __('CTA Section', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_solutions_cta_override', 'label' => __('Override CTA', 'erdu-wp'), 'name' => 'solutions_cta_override', 'type' => 'true_false', 'ui' => 1),
            array('key' => 'field_solutions_cta_title', 'label' => __('CTA Title', 'erdu-wp'), 'name' => 'solutions_cta_title', 'type' => 'text', 'conditional_logic' => array(array(array('field' => 'field_solutions_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_solutions_cta_button', 'label' => __('Primary Button Text', 'erdu-wp'), 'name' => 'solutions_cta_button', 'type' => 'text', 'conditional_logic' => array(array(array('field' => 'field_solutions_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_solutions_cta_link', 'label' => __('Primary Button Link', 'erdu-wp'), 'name' => 'solutions_cta_link', 'type' => 'page_link', 'allow_null' => 1, 'conditional_logic' => array(array(array('field' => 'field_solutions_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_solutions_cta_button2', 'label' => __('Secondary Button Text', 'erdu-wp'), 'name' => 'solutions_cta_button2', 'type' => 'text', 'conditional_logic' => array(array(array('field' => 'field_solutions_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_solutions_cta_link2', 'label' => __('Secondary Button Link', 'erdu-wp'), 'name' => 'solutions_cta_link2', 'type' => 'page_link', 'allow_null' => 1, 'conditional_logic' => array(array(array('field' => 'field_solutions_cta_override', 'operator' => '==', 'value' => '1')))),
        ),
        'location'   => array(array(array('param' => 'page_template', 'operator' => '==', 'value' => 'page-solutions.php'))),
        'position'   => 'normal',
        'style'      => 'default',
        'menu_order' => 5,
    ));

    // --- 6. Case Studies Page Fields ---
    acf_add_local_field_group(array(
        'key'    => 'group_page_cases',
        'title'  => __('Case Studies Page Content', 'erdu-wp'),
        'fields' => array(
            // --- Hero Tab ---
            array('key' => 'field_cases_tab_hero', 'label' => __('Hero Banner', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_cases_hero_title', 'label' => __('Hero Title', 'erdu-wp'), 'name' => 'cases_hero_title', 'type' => 'text'),
            array('key' => 'field_cases_hero_subtitle', 'label' => __('Hero Subtitle', 'erdu-wp'), 'name' => 'cases_hero_subtitle', 'type' => 'textarea', 'rows' => 2),
            array('key' => 'field_cases_hero_bg', 'label' => __('Hero Background Image', 'erdu-wp'), 'name' => 'cases_hero_bg', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium'),
            array('key' => 'field_cases_hero_btn', 'label' => __('Primary Button Text', 'erdu-wp'), 'name' => 'cases_hero_btn', 'type' => 'text'),
            array('key' => 'field_cases_hero_btn_link', 'label' => __('Primary Button Link', 'erdu-wp'), 'name' => 'cases_hero_btn_link', 'type' => 'page_link', 'allow_null' => 1),
            array('key' => 'field_cases_hero_btn2', 'label' => __('Secondary Button Text', 'erdu-wp'), 'name' => 'cases_hero_btn2', 'type' => 'text'),
            array('key' => 'field_cases_hero_btn2_link', 'label' => __('Secondary Button Link', 'erdu-wp'), 'name' => 'cases_hero_btn2_link', 'type' => 'page_link', 'allow_null' => 1),

            // --- Page Content Tab ---
            array('key' => 'field_cases_tab_content', 'label' => __('Page Content', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_cases_page_editor', 'label' => __('Content (between Hero and Intro)', 'erdu-wp'), 'name' => 'cases_page_editor', 'type' => 'wysiwyg', 'toolbar' => 'full', 'tabs' => 'all', 'media_upload' => 1),

            // --- Intro Tab ---
            array('key' => 'field_cases_tab_intro', 'label' => __('Introduction', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_cases_intro', 'label' => __('Introduction', 'erdu-wp'), 'name' => 'cases_intro', 'type' => 'wysiwyg', 'toolbar' => 'full'),

            // --- Source Tab ---
            array('key' => 'field_cases_tab_source', 'label' => __('Case Studies Source', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_cases_source', 'label' => __('Case Studies Source', 'erdu-wp'), 'name' => 'cases_source', 'type' => 'select',
                'choices' => array('cpt' => __('From Case Studies CPT', 'erdu-wp'), 'custom' => __('Custom List (Manual)', 'erdu-wp')),
                'default_value' => 'cpt'),
            array('key' => 'field_cases_count', 'label' => __('Max Cases to Show', 'erdu-wp'), 'name' => 'cases_count', 'type' => 'number', 'default_value' => 6, 'min' => 1, 'max' => 24),
            array(
                'key'               => 'field_cases_list',
                'label'             => __('Custom Case Studies', 'erdu-wp'),
                'name'              => 'cases_list',
                'type'              => 'repeater',
                'button_label'      => __('Add Case Study', 'erdu-wp'),
                'conditional_logic' => array(array(array('field' => 'field_cases_source', 'operator' => '==', 'value' => 'custom'))),
                'sub_fields'        => array(
                    array('key' => 'field_case_title', 'label' => __('Project Title', 'erdu-wp'), 'name' => 'title', 'type' => 'text', 'required' => 1),
                    array('key' => 'field_case_industry', 'label' => __('Industry', 'erdu-wp'), 'name' => 'industry', 'type' => 'text'),
                    array('key' => 'field_case_image', 'label' => __('Image', 'erdu-wp'), 'name' => 'image', 'type' => 'image', 'return_format' => 'url'),
                    array('key' => 'field_case_desc', 'label' => __('Description', 'erdu-wp'), 'name' => 'description', 'type' => 'textarea', 'rows' => 3),
                    array('key' => 'field_case_link', 'label' => __('Case Detail Link', 'erdu-wp'), 'name' => 'link', 'type' => 'page_link', 'allow_null' => 1),
                ),
            ),

            // --- Industry Filters Tab ---
            array('key' => 'field_cases_tab_industries', 'label' => __('Industry Filters', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_cases_industries', 'label' => __('Industry Categories', 'erdu-wp'), 'name' => 'cases_industries', 'type' => 'repeater', 'button_label' => __('Add Industry', 'erdu-wp'), 'sub_fields' => array(
                array('key' => 'field_ci_key', 'label' => __('Key', 'erdu-wp'), 'name' => 'key', 'type' => 'text'),
                array('key' => 'field_ci_label', 'label' => __('Label', 'erdu-wp'), 'name' => 'label', 'type' => 'text', 'required' => 1),
            )),

            // --- CTA Tab ---
            array('key' => 'field_cases_tab_cta', 'label' => __('CTA Section', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_cases_cta_override', 'label' => __('Override CTA', 'erdu-wp'), 'name' => 'cases_cta_override', 'type' => 'true_false', 'ui' => 1),
            array('key' => 'field_cases_cta_title', 'label' => __('CTA Title', 'erdu-wp'), 'name' => 'cases_cta_title', 'type' => 'text', 'conditional_logic' => array(array(array('field' => 'field_cases_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_cases_cta_button', 'label' => __('Primary Button Text', 'erdu-wp'), 'name' => 'cases_cta_button', 'type' => 'text', 'conditional_logic' => array(array(array('field' => 'field_cases_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_cases_cta_link', 'label' => __('Primary Button Link', 'erdu-wp'), 'name' => 'cases_cta_link', 'type' => 'page_link', 'allow_null' => 1, 'conditional_logic' => array(array(array('field' => 'field_cases_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_cases_cta_button2', 'label' => __('Secondary Button Text', 'erdu-wp'), 'name' => 'cases_cta_button2', 'type' => 'text', 'conditional_logic' => array(array(array('field' => 'field_cases_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_cases_cta_link2', 'label' => __('Secondary Button Link', 'erdu-wp'), 'name' => 'cases_cta_link2', 'type' => 'page_link', 'allow_null' => 1, 'conditional_logic' => array(array(array('field' => 'field_cases_cta_override', 'operator' => '==', 'value' => '1')))),
        ),
        'location'   => array(array(array('param' => 'page_template', 'operator' => '==', 'value' => 'page-cases.php'))),
        'position'   => 'normal',
        'style'      => 'default',
        'menu_order' => 5,
    ));

    // --- 7. Distributor Page Fields ---
    acf_add_local_field_group(array(
        'key'    => 'group_page_distributor',
        'title'  => __('Distributor Page Content', 'erdu-wp'),
        'fields' => array(
            // --- Hero Tab ---
            array('key' => 'field_dist_tab_hero', 'label' => __('Hero Banner', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_dist_hero_title', 'label' => __('Hero Title', 'erdu-wp'), 'name' => 'dist_hero_title', 'type' => 'text'),
            array('key' => 'field_dist_hero_subtitle', 'label' => __('Hero Subtitle', 'erdu-wp'), 'name' => 'dist_hero_subtitle', 'type' => 'textarea', 'rows' => 2),
            array('key' => 'field_dist_hero_bg', 'label' => __('Hero Background Image', 'erdu-wp'), 'name' => 'dist_hero_bg', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium'),
            array('key' => 'field_dist_hero_btn', 'label' => __('Primary Button Text', 'erdu-wp'), 'name' => 'dist_hero_btn', 'type' => 'text'),
            array('key' => 'field_dist_hero_btn_link', 'label' => __('Primary Button Link', 'erdu-wp'), 'name' => 'dist_hero_btn_link', 'type' => 'page_link', 'allow_null' => 1),
            array('key' => 'field_dist_hero_btn2', 'label' => __('Secondary Button Text', 'erdu-wp'), 'name' => 'dist_hero_btn2', 'type' => 'text'),
            array('key' => 'field_dist_hero_btn2_link', 'label' => __('Secondary Button Link', 'erdu-wp'), 'name' => 'dist_hero_btn2_link', 'type' => 'page_link', 'allow_null' => 1),

            // --- Page Content Tab ---
            array('key' => 'field_dist_tab_content', 'label' => __('Page Content', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_dist_page_editor', 'label' => __('Content (between Hero and Intro)', 'erdu-wp'), 'name' => 'dist_page_editor', 'type' => 'wysiwyg', 'toolbar' => 'full', 'tabs' => 'all', 'media_upload' => 1),

            // --- Intro Tab ---
            array('key' => 'field_dist_tab_intro', 'label' => __('Introduction', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_dist_intro', 'label' => __('Introduction', 'erdu-wp'), 'name' => 'dist_intro', 'type' => 'wysiwyg', 'toolbar' => 'full'),
            array('key' => 'field_dist_partner_title', 'label' => __('Partner Section Title', 'erdu-wp'), 'name' => 'dist_partner_title', 'type' => 'text'),
            array('key' => 'field_dist_partner_content', 'label' => __('Partner Section Content', 'erdu-wp'), 'name' => 'dist_partner_content', 'type' => 'textarea', 'rows' => 3),

            // --- Benefits Tab ---
            array('key' => 'field_dist_tab_benefits', 'label' => __('Partner Benefits', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_dist_benefits', 'label' => __('Partner Benefits', 'erdu-wp'), 'name' => 'dist_benefits', 'type' => 'repeater', 'button_label' => __('Add Benefit', 'erdu-wp'), 'sub_fields' => array(
                array('key' => 'field_db_title', 'label' => __('Title', 'erdu-wp'), 'name' => 'title', 'type' => 'text', 'required' => 1),
                array('key' => 'field_db_desc', 'label' => __('Description', 'erdu-wp'), 'name' => 'description', 'type' => 'textarea', 'rows' => 2),
            )),

            // --- Requirements Tab ---
            array('key' => 'field_dist_tab_requirements', 'label' => __('Requirements', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_dist_req_title', 'label' => __('Requirements Section Title', 'erdu-wp'), 'name' => 'dist_req_title', 'type' => 'text'),
            array('key' => 'field_dist_req_intro', 'label' => __('Requirements Intro Text', 'erdu-wp'), 'name' => 'dist_req_intro', 'type' => 'textarea', 'rows' => 3),
            array('key' => 'field_dist_requirements', 'label' => __('Requirements List', 'erdu-wp'), 'name' => 'dist_requirements', 'type' => 'repeater', 'button_label' => __('Add Requirement', 'erdu-wp'), 'sub_fields' => array(
                array('key' => 'field_dr_text', 'label' => __('Requirement', 'erdu-wp'), 'name' => 'text', 'type' => 'textarea', 'rows' => 2),
            )),

            // --- CTA Tab ---
            array('key' => 'field_dist_tab_cta', 'label' => __('CTA Section', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_dist_cta_override', 'label' => __('Override CTA', 'erdu-wp'), 'name' => 'dist_cta_override', 'type' => 'true_false', 'ui' => 1),
            array('key' => 'field_dist_cta_title', 'label' => __('CTA Title', 'erdu-wp'), 'name' => 'dist_cta_title', 'type' => 'text', 'conditional_logic' => array(array(array('field' => 'field_dist_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_dist_cta_button', 'label' => __('Primary Button Text', 'erdu-wp'), 'name' => 'dist_cta_button', 'type' => 'text', 'conditional_logic' => array(array(array('field' => 'field_dist_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_dist_cta_link', 'label' => __('Primary Button Link', 'erdu-wp'), 'name' => 'dist_cta_link', 'type' => 'page_link', 'allow_null' => 1, 'conditional_logic' => array(array(array('field' => 'field_dist_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_dist_cta_button2', 'label' => __('Secondary Button Text', 'erdu-wp'), 'name' => 'dist_cta_button2', 'type' => 'text', 'conditional_logic' => array(array(array('field' => 'field_dist_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_dist_cta_link2', 'label' => __('Secondary Button Link', 'erdu-wp'), 'name' => 'dist_cta_link2', 'type' => 'page_link', 'allow_null' => 1, 'conditional_logic' => array(array(array('field' => 'field_dist_cta_override', 'operator' => '==', 'value' => '1')))),
        ),
        'location'   => array(array(array('param' => 'page_template', 'operator' => '==', 'value' => 'page-distributor.php'))),
        'position'   => 'normal',
        'style'      => 'default',
        'menu_order' => 5,
    ));

    // --- 8. Contact Page Fields ---
    acf_add_local_field_group(array(
        'key'    => 'group_page_contact',
        'title'  => __('Contact Page Content', 'erdu-wp'),
        'fields' => array(
            // --- Hero Tab ---
            array('key' => 'field_contact_tab_hero', 'label' => __('Hero Banner', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_contact_hero_title', 'label' => __('Hero Title', 'erdu-wp'), 'name' => 'contact_hero_title', 'type' => 'text'),
            array('key' => 'field_contact_hero_subtitle', 'label' => __('Hero Subtitle', 'erdu-wp'), 'name' => 'contact_hero_subtitle', 'type' => 'textarea', 'rows' => 2),
            array('key' => 'field_contact_hero_bg', 'label' => __('Hero Background Image', 'erdu-wp'), 'name' => 'contact_hero_bg', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium'),
            array('key' => 'field_contact_hero_btn', 'label' => __('Primary Button Text', 'erdu-wp'), 'name' => 'contact_hero_btn', 'type' => 'text'),
            array('key' => 'field_contact_hero_btn_link', 'label' => __('Primary Button Link', 'erdu-wp'), 'name' => 'contact_hero_btn_link', 'type' => 'page_link', 'allow_null' => 1),
            array('key' => 'field_contact_hero_btn2', 'label' => __('Secondary Button Text', 'erdu-wp'), 'name' => 'contact_hero_btn2', 'type' => 'text'),
            array('key' => 'field_contact_hero_btn2_link', 'label' => __('Secondary Button Link', 'erdu-wp'), 'name' => 'contact_hero_btn2_link', 'type' => 'page_link', 'allow_null' => 1),

            // --- Page Content Tab ---
            array('key' => 'field_contact_tab_content', 'label' => __('Page Content', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_contact_page_editor', 'label' => __('Content (between Hero and Contact Section)', 'erdu-wp'), 'name' => 'contact_page_editor', 'type' => 'wysiwyg', 'toolbar' => 'full', 'tabs' => 'all', 'media_upload' => 1),

            // --- Introduction Tab ---
            array('key' => 'field_contact_tab_intro', 'label' => __('Introduction', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_contact_intro', 'label' => __('Introduction', 'erdu-wp'), 'name' => 'contact_intro', 'type' => 'wysiwyg', 'toolbar' => 'full'),

            // --- Contact Info Tab ---
            array('key' => 'field_contact_tab_info', 'label' => __('Contact Information', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_contact_info_title', 'label' => __('Info Section Title', 'erdu-wp'), 'name' => 'contact_info_title', 'type' => 'text'),
            array('key' => 'field_contact_phone', 'label' => __('Phone (Tel)', 'erdu-wp'), 'name' => 'contact_phone', 'type' => 'text'),
            array('key' => 'field_contact_mobile', 'label' => __('Mobile', 'erdu-wp'), 'name' => 'contact_mobile', 'type' => 'text'),
            array('key' => 'field_contact_email', 'label' => __('Email', 'erdu-wp'), 'name' => 'contact_email', 'type' => 'email'),
            array('key' => 'field_contact_address', 'label' => __('Address', 'erdu-wp'), 'name' => 'contact_address', 'type' => 'textarea', 'rows' => 3),
            array('key' => 'field_contact_hours', 'label' => __('Business Hours', 'erdu-wp'), 'name' => 'contact_hours', 'type' => 'text'),

            // --- Contact Persons Tab ---
            array('key' => 'field_contact_tab_persons', 'label' => __('Contact Persons', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_contact_persons', 'label' => __('Contact Persons', 'erdu-wp'), 'name' => 'contact_persons', 'type' => 'repeater', 'button_label' => __('Add Person', 'erdu-wp'), 'sub_fields' => array(
                array('key' => 'field_cp_name', 'label' => __('Name', 'erdu-wp'), 'name' => 'name', 'type' => 'text', 'required' => 1),
                array('key' => 'field_cp_title', 'label' => __('Job Title', 'erdu-wp'), 'name' => 'title', 'type' => 'text'),
                array('key' => 'field_cp_email', 'label' => __('Email', 'erdu-wp'), 'name' => 'email', 'type' => 'email'),
                array('key' => 'field_cp_phone', 'label' => __('Phone/WhatsApp', 'erdu-wp'), 'name' => 'phone', 'type' => 'text'),
                array('key' => 'field_cp_initial', 'label' => __('Avatar Initial (1 letter)', 'erdu-wp'), 'name' => 'initial', 'type' => 'text', 'maxlength' => 1),
            )),

            // --- Social Links Tab ---
            array('key' => 'field_contact_tab_social', 'label' => __('Social / Messaging', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_contact_whatsapp', 'label' => __('WhatsApp Number / Link', 'erdu-wp'), 'name' => 'contact_whatsapp', 'type' => 'text'),
            array('key' => 'field_contact_wechat', 'label' => __('WeChat ID / QR Code Image', 'erdu-wp'), 'name' => 'contact_wechat', 'type' => 'text'),
            array('key' => 'field_contact_social_label', 'label' => __('Social Section Label', 'erdu-wp'), 'name' => 'contact_social_label', 'type' => 'text'),

            // --- Map Tab ---
            array('key' => 'field_contact_tab_map', 'label' => __('Map', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_contact_map_embed', 'label' => __('Map Embed Code (iframe)', 'erdu-wp'), 'name' => 'contact_map_embed', 'type' => 'textarea', 'rows' => 3, 'instructions' => __('Paste Google Maps or other map embed iframe code here.', 'erdu-wp')),
            array('key' => 'field_contact_map_image', 'label' => __('Map Fallback Image', 'erdu-wp'), 'name' => 'contact_map_image', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium'),

            // --- FAQ Tab ---
            array('key' => 'field_contact_tab_faq', 'label' => __('FAQ', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_contact_faq', 'label' => __('FAQ Items', 'erdu-wp'), 'name' => 'contact_faq', 'type' => 'repeater', 'button_label' => __('Add FAQ', 'erdu-wp'), 'sub_fields' => array(
                array('key' => 'field_faq_q', 'label' => __('Question', 'erdu-wp'), 'name' => 'question', 'type' => 'text', 'required' => 1),
                array('key' => 'field_faq_a', 'label' => __('Answer', 'erdu-wp'), 'name' => 'answer', 'type' => 'textarea', 'rows' => 3),
            )),

            // --- CTA Tab ---
            array('key' => 'field_contact_tab_cta', 'label' => __('CTA Section', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_contact_cta_override', 'label' => __('Override CTA', 'erdu-wp'), 'name' => 'contact_cta_override', 'type' => 'true_false', 'ui' => 1),
            array('key' => 'field_contact_cta_title', 'label' => __('CTA Title', 'erdu-wp'), 'name' => 'contact_cta_title', 'type' => 'text', 'conditional_logic' => array(array(array('field' => 'field_contact_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_contact_cta_button', 'label' => __('Primary Button Text', 'erdu-wp'), 'name' => 'contact_cta_button', 'type' => 'text', 'conditional_logic' => array(array(array('field' => 'field_contact_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_contact_cta_link', 'label' => __('Primary Button Link', 'erdu-wp'), 'name' => 'contact_cta_link', 'type' => 'page_link', 'allow_null' => 1, 'conditional_logic' => array(array(array('field' => 'field_contact_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_contact_cta_button2', 'label' => __('Secondary Button Text', 'erdu-wp'), 'name' => 'contact_cta_button2', 'type' => 'text', 'conditional_logic' => array(array(array('field' => 'field_contact_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_contact_cta_link2', 'label' => __('Secondary Button Link', 'erdu-wp'), 'name' => 'contact_cta_link2', 'type' => 'page_link', 'allow_null' => 1, 'conditional_logic' => array(array(array('field' => 'field_contact_cta_override', 'operator' => '==', 'value' => '1')))),
        ),
        'location'   => array(array(array('param' => 'page_template', 'operator' => '==', 'value' => 'page-contact.php'))),
        'position'   => 'normal',
        'style'      => 'default',
        'menu_order' => 5,
    ));

    // --- 9. News Page Fields ---
    acf_add_local_field_group(array(
        'key'    => 'group_page_news',
        'title'  => __('News Page Content', 'erdu-wp'),
        'fields' => array(
            // --- Hero Tab ---
            array('key' => 'field_news_tab_hero', 'label' => __('Hero Banner', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_news_hero_title', 'label' => __('Hero Title', 'erdu-wp'), 'name' => 'news_hero_title', 'type' => 'text'),
            array('key' => 'field_news_hero_subtitle', 'label' => __('Hero Subtitle', 'erdu-wp'), 'name' => 'news_hero_subtitle', 'type' => 'textarea', 'rows' => 2),
            array('key' => 'field_news_hero_bg', 'label' => __('Hero Background Image', 'erdu-wp'), 'name' => 'news_hero_bg', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium'),
            array('key' => 'field_news_hero_btn', 'label' => __('Primary Button Text', 'erdu-wp'), 'name' => 'news_hero_btn', 'type' => 'text'),
            array('key' => 'field_news_hero_btn_link', 'label' => __('Primary Button Link', 'erdu-wp'), 'name' => 'news_hero_btn_link', 'type' => 'page_link', 'allow_null' => 1),
            array('key' => 'field_news_hero_btn2', 'label' => __('Secondary Button Text', 'erdu-wp'), 'name' => 'news_hero_btn2', 'type' => 'text'),
            array('key' => 'field_news_hero_btn2_link', 'label' => __('Secondary Button Link', 'erdu-wp'), 'name' => 'news_hero_btn2_link', 'type' => 'page_link', 'allow_null' => 1),

            // --- Page Content Tab ---
            array('key' => 'field_news_tab_content', 'label' => __('Page Content', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_news_page_editor', 'label' => __('Content (between Hero and Tabs)', 'erdu-wp'), 'name' => 'news_page_editor', 'type' => 'wysiwyg', 'toolbar' => 'full', 'tabs' => 'all', 'media_upload' => 1),

            // --- Intro Tab ---
            array('key' => 'field_news_tab_intro', 'label' => __('Introduction', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_news_intro', 'label' => __('Introduction', 'erdu-wp'), 'name' => 'news_intro', 'type' => 'wysiwyg', 'toolbar' => 'full'),

            // --- News Settings Tab ---
            array('key' => 'field_news_tab_settings', 'label' => __('News Settings', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_news_count', 'label' => __('Max News Articles to Show', 'erdu-wp'), 'name' => 'news_count', 'type' => 'number', 'default_value' => 6, 'min' => 1, 'max' => 24),

            // --- Exhibitions Tab ---
            array('key' => 'field_news_tab_exhibitions', 'label' => __('Exhibitions', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_news_expo_source', 'label' => __('Exhibitions Source', 'erdu-wp'), 'name' => 'news_expo_source', 'type' => 'select',
                'choices' => array('cpt' => __('From Exhibitions CPT', 'erdu-wp'), 'custom' => __('Custom List (Manual)', 'erdu-wp')),
                'default_value' => 'custom'),
            array('key' => 'field_news_expo_count', 'label' => __('Max Exhibitions to Show', 'erdu-wp'), 'name' => 'news_expo_count', 'type' => 'number', 'default_value' => 3, 'min' => 1, 'max' => 12),
            array(
                'key'               => 'field_news_exhibitions',
                'label'             => __('Custom Exhibitions', 'erdu-wp'),
                'name'              => 'news_exhibitions',
                'type'              => 'repeater',
                'button_label'      => __('Add Exhibition', 'erdu-wp'),
                'conditional_logic' => array(array(array('field' => 'field_news_expo_source', 'operator' => '==', 'value' => 'custom'))),
                'sub_fields'        => array(
                    array('key' => 'field_ex_name', 'label' => __('Exhibition Name', 'erdu-wp'), 'name' => 'name', 'type' => 'text', 'required' => 1),
                    array('key' => 'field_ex_date', 'label' => __('Date', 'erdu-wp'), 'name' => 'date', 'type' => 'text'),
                    array('key' => 'field_ex_location', 'label' => __('Location', 'erdu-wp'), 'name' => 'location', 'type' => 'text'),
                    array('key' => 'field_ex_booth', 'label' => __('Booth Number', 'erdu-wp'), 'name' => 'booth', 'type' => 'text'),
                    array('key' => 'field_ex_link', 'label' => __('Exhibition Link', 'erdu-wp'), 'name' => 'link', 'type' => 'url'),
                ),
            ),

            // --- Tab Labels Tab ---
            array('key' => 'field_news_tab_labels', 'label' => __('Tab Labels', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_news_tab_news_label', 'label' => __('News Tab Label', 'erdu-wp'), 'name' => 'news_tab_news_label', 'type' => 'text'),
            array('key' => 'field_news_tab_expo_label', 'label' => __('Exhibitions Tab Label', 'erdu-wp'), 'name' => 'news_tab_expo_label', 'type' => 'text'),
            array('key' => 'field_news_empty_title', 'label' => __('Empty News Title', 'erdu-wp'), 'name' => 'news_empty_title', 'type' => 'text'),
            array('key' => 'field_news_empty_text', 'label' => __('Empty News Message', 'erdu-wp'), 'name' => 'news_empty_text', 'type' => 'textarea', 'rows' => 2),

            // --- CTA Tab ---
            array('key' => 'field_news_tab_cta', 'label' => __('CTA Section', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_news_cta_override', 'label' => __('Override CTA', 'erdu-wp'), 'name' => 'news_cta_override', 'type' => 'true_false', 'ui' => 1),
            array('key' => 'field_news_cta_title', 'label' => __('CTA Title', 'erdu-wp'), 'name' => 'news_cta_title', 'type' => 'text', 'conditional_logic' => array(array(array('field' => 'field_news_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_news_cta_button', 'label' => __('Primary Button Text', 'erdu-wp'), 'name' => 'news_cta_button', 'type' => 'text', 'conditional_logic' => array(array(array('field' => 'field_news_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_news_cta_link', 'label' => __('Primary Button Link', 'erdu-wp'), 'name' => 'news_cta_link', 'type' => 'page_link', 'allow_null' => 1, 'conditional_logic' => array(array(array('field' => 'field_news_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_news_cta_button2', 'label' => __('Secondary Button Text', 'erdu-wp'), 'name' => 'news_cta_button2', 'type' => 'text', 'conditional_logic' => array(array(array('field' => 'field_news_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_news_cta_link2', 'label' => __('Secondary Button Link', 'erdu-wp'), 'name' => 'news_cta_link2', 'type' => 'page_link', 'allow_null' => 1, 'conditional_logic' => array(array(array('field' => 'field_news_cta_override', 'operator' => '==', 'value' => '1')))),
        ),
        'location'   => array(array(array('param' => 'page_template', 'operator' => '==', 'value' => 'page-news.php'))),
        'position'   => 'normal',
        'style'      => 'default',
        'menu_order' => 5,
    ));

    // --------------------------------------
    // 10. Front Page (Home) Fields
    // --------------------------------------
    acf_add_local_field_group(array(
        'key'      => 'group_page_home',
        'title'    => __('Home Page Content', 'erdu-wp'),
        'fields'   => array(
            // --- Hero Tab ---
            array('key' => 'field_home_tab_hero', 'label' => __('Hero Banner', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_home_hero_title', 'label' => __('Hero Title', 'erdu-wp'), 'name' => 'home_hero_title', 'type' => 'text'),
            array('key' => 'field_home_hero_subtitle', 'label' => __('Hero Subtitle', 'erdu-wp'), 'name' => 'home_hero_subtitle', 'type' => 'textarea', 'rows' => 2),
            array('key' => 'field_home_hero_bg', 'label' => __('Hero Background Image', 'erdu-wp'), 'name' => 'home_hero_bg', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium'),
            array('key' => 'field_home_hero_btn', 'label' => __('Primary Button Text', 'erdu-wp'), 'name' => 'home_hero_btn', 'type' => 'text'),
            array('key' => 'field_home_hero_btn_link', 'label' => __('Primary Button Link', 'erdu-wp'), 'name' => 'home_hero_btn_link', 'type' => 'page_link', 'allow_null' => 1),
            array('key' => 'field_home_hero_btn2', 'label' => __('Secondary Button Text', 'erdu-wp'), 'name' => 'home_hero_btn2', 'type' => 'text'),
            array('key' => 'field_home_hero_btn2_link', 'label' => __('Secondary Button Link', 'erdu-wp'), 'name' => 'home_hero_btn2_link', 'type' => 'page_link', 'allow_null' => 1),
            array('key' => 'field_home_hero_video_enabled', 'label' => __('Enable Video Background', 'erdu-wp'), 'name' => 'home_hero_video_enabled', 'type' => 'true_false', 'default_value' => 0, 'ui' => 1),
            array(
                'key'               => 'field_home_hero_video',
                'label'             => __('Hero Video (MP4)', 'erdu-wp'),
                'name'              => 'home_hero_video',
                'type'              => 'file',
                'mime_types'        => 'mp4',
                'return_format'     => 'url',
                'conditional_logic' => array(array(array('field' => 'field_home_hero_video_enabled', 'operator' => '==', 'value' => 1))),
            ),
            array(
                'key'               => 'field_home_hero_video_poster',
                'label'             => __('Video Poster (Cover Image)', 'erdu-wp'),
                'name'              => 'home_hero_video_poster',
                'type'              => 'image',
                'return_format'     => 'url',
                'preview_size'      => 'medium',
                'instructions'      => __('Displayed before video loads. Falls back to Hero Background Image.', 'erdu-wp'),
                'conditional_logic' => array(array(array('field' => 'field_home_hero_video_enabled', 'operator' => '==', 'value' => 1))),
            ),

            // --- Stats Tab ---
            array('key' => 'field_home_tab_stats', 'label' => __('Trust Stats', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array(
                'key'          => 'field_home_stats',
                'label'        => __('Statistics', 'erdu-wp'),
                'name'         => 'home_stats',
                'type'         => 'repeater',
                'button_label' => __('Add Stat', 'erdu-wp'),
                'sub_fields'   => array(
                    array('key' => 'field_hs_num', 'label' => __('Number', 'erdu-wp'), 'name' => 'number', 'type' => 'text', 'required' => 1),
                    array('key' => 'field_hs_label', 'label' => __('Label', 'erdu-wp'), 'name' => 'label', 'type' => 'text', 'required' => 1),
                ),
            ),

            // --- About Tab ---
            array('key' => 'field_home_tab_about', 'label' => __('About Intro', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_home_about_title', 'label' => __('Section Title', 'erdu-wp'), 'name' => 'home_about_title', 'type' => 'text'),
            array('key' => 'field_home_about_highlight', 'label' => __('Highlight Text', 'erdu-wp'), 'name' => 'home_about_highlight', 'type' => 'textarea', 'rows' => 2),
            array('key' => 'field_home_about_content', 'label' => __('Content', 'erdu-wp'), 'name' => 'home_about_content', 'type' => 'wysiwyg', 'toolbar' => 'full', 'tabs' => 'all'),
            array('key' => 'field_home_about_image', 'label' => __('About Image', 'erdu-wp'), 'name' => 'home_about_image', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium'),
            array('key' => 'field_home_about_link', 'label' => __('Learn More Link', 'erdu-wp'), 'name' => 'home_about_link', 'type' => 'page_link', 'allow_null' => 1),
            array(
                'key'          => 'field_home_about_info',
                'label'        => __('Info Boxes', 'erdu-wp'),
                'name'         => 'home_about_info',
                'type'         => 'repeater',
                'button_label' => __('Add Info Box', 'erdu-wp'),
                'sub_fields'   => array(
                    array('key' => 'field_hai_label', 'label' => __('Label', 'erdu-wp'), 'name' => 'label', 'type' => 'text', 'required' => 1),
                    array('key' => 'field_hai_value', 'label' => __('Value', 'erdu-wp'), 'name' => 'value', 'type' => 'text', 'required' => 1),
                ),
            ),

            // --- Products Tab ---
            // NOTE: Products are pulled from WooCommerce product_cat automatically.
            // No manual product list needed.
            array('key' => 'field_home_tab_products', 'label' => __('Product Series', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_home_products_title', 'label' => __('Section Title', 'erdu-wp'), 'name' => 'home_products_title', 'type' => 'text'),
            array('key' => 'field_home_products_desc', 'label' => __('Section Description', 'erdu-wp'), 'name' => 'home_products_desc', 'type' => 'textarea', 'rows' => 2),
            array('key' => 'field_home_products_count', 'label' => __('Max Categories to Show', 'erdu-wp'), 'name' => 'home_products_count', 'type' => 'number', 'default_value' => 4, 'min' => 1, 'max' => 12,
                'instructions' => __('Number of WooCommerce product categories to display. Set up categories in WooCommerce > Products > Categories.', 'erdu-wp')),

            // --- Applications Tab ---
            array('key' => 'field_home_tab_apps', 'label' => __('Applications', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_home_apps_title', 'label' => __('Section Title', 'erdu-wp'), 'name' => 'home_apps_title', 'type' => 'text'),
            array('key' => 'field_home_apps_desc', 'label' => __('Section Description', 'erdu-wp'), 'name' => 'home_apps_desc', 'type' => 'textarea', 'rows' => 2),
            array(
                'key'          => 'field_home_apps',
                'label'        => __('Applications', 'erdu-wp'),
                'name'         => 'home_apps',
                'type'         => 'repeater',
                'button_label' => __('Add Application', 'erdu-wp'),
                'sub_fields'   => array(
                    array('key' => 'field_ha_name', 'label' => __('Name', 'erdu-wp'), 'name' => 'name', 'type' => 'text', 'required' => 1),
                    array('key' => 'field_ha_desc', 'label' => __('Description', 'erdu-wp'), 'name' => 'description', 'type' => 'textarea', 'rows' => 2),
                    array('key' => 'field_ha_icon', 'label' => __('Icon (emoji or text)', 'erdu-wp'), 'name' => 'icon', 'type' => 'text'),
                    array('key' => 'field_ha_link', 'label' => __('Link', 'erdu-wp'), 'name' => 'link', 'type' => 'page_link', 'allow_null' => 1),
                ),
            ),

            // --- CTA Tab ---
            array('key' => 'field_home_tab_cta', 'label' => __('CTA Banner', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_home_cta_title', 'label' => __('CTA Title', 'erdu-wp'), 'name' => 'home_cta_title', 'type' => 'text'),
            array('key' => 'field_home_cta_btn', 'label' => __('Primary Button Text', 'erdu-wp'), 'name' => 'home_cta_btn', 'type' => 'text'),
            array('key' => 'field_home_cta_btn_link', 'label' => __('Primary Button Link', 'erdu-wp'), 'name' => 'home_cta_btn_link', 'type' => 'page_link', 'allow_null' => 1),
            array('key' => 'field_home_cta_btn2', 'label' => __('Secondary Button Text', 'erdu-wp'), 'name' => 'home_cta_btn2', 'type' => 'text'),
            array('key' => 'field_home_cta_btn2_link', 'label' => __('Secondary Button Link', 'erdu-wp'), 'name' => 'home_cta_btn2_link', 'type' => 'page_link', 'allow_null' => 1),

            // --- Testimonials Tab ---
            array('key' => 'field_home_tab_testi', 'label' => __('Testimonials', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_home_testi_title', 'label' => __('Section Title', 'erdu-wp'), 'name' => 'home_testi_title', 'type' => 'text'),
            array('key' => 'field_home_testi_desc', 'label' => __('Section Description', 'erdu-wp'), 'name' => 'home_testi_desc', 'type' => 'textarea', 'rows' => 2),
            array(
                'key'          => 'field_home_testimonials',
                'label'        => __('Testimonials', 'erdu-wp'),
                'name'         => 'home_testimonials',
                'type'         => 'repeater',
                'button_label' => __('Add Testimonial', 'erdu-wp'),
                'sub_fields'   => array(
                    array('key' => 'field_ht_quote', 'label' => __('Quote', 'erdu-wp'), 'name' => 'quote', 'type' => 'textarea', 'rows' => 4, 'required' => 1),
                    array('key' => 'field_ht_author', 'label' => __('Author Name', 'erdu-wp'), 'name' => 'author', 'type' => 'text', 'required' => 1),
                    array('key' => 'field_ht_role', 'label' => __('Author Role', 'erdu-wp'), 'name' => 'role', 'type' => 'text'),
                ),
            ),

            // --- Exhibitions Tab ---
            array('key' => 'field_home_tab_expo', 'label' => __('Exhibitions', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_home_expo_title', 'label' => __('Section Title', 'erdu-wp'), 'name' => 'home_expo_title', 'type' => 'text'),
            array('key' => 'field_home_expo_desc', 'label' => __('Section Description', 'erdu-wp'), 'name' => 'home_expo_desc', 'type' => 'textarea', 'rows' => 2),
            array('key' => 'field_home_expo_source', 'label' => __('Exhibition Source', 'erdu-wp'), 'name' => 'home_expo_source', 'type' => 'select',
                'choices' => array('cpt' => __('From Exhibition CPT', 'erdu-wp'), 'custom' => __('Custom List', 'erdu-wp')),
                'default_value' => 'custom'),
            array('key' => 'field_home_expo_count', 'label' => __('Max Exhibitions to Show', 'erdu-wp'), 'name' => 'home_expo_count', 'type' => 'number', 'default_value' => 3, 'min' => 1, 'max' => 12),
            array(
                'key'               => 'field_home_expo_custom',
                'label'             => __('Custom Exhibitions', 'erdu-wp'),
                'name'              => 'home_expo_custom',
                'type'              => 'repeater',
                'button_label'      => __('Add Exhibition', 'erdu-wp'),
                'conditional_logic' => array(array(array('field' => 'field_home_expo_source', 'operator' => '==', 'value' => 'custom'))),
                'sub_fields'        => array(
                    array('key' => 'field_hec_name', 'label' => __('Exhibition Name', 'erdu-wp'), 'name' => 'name', 'type' => 'text', 'required' => 1),
                    array('key' => 'field_hec_date', 'label' => __('Date', 'erdu-wp'), 'name' => 'date', 'type' => 'text'),
                    array('key' => 'field_hec_location', 'label' => __('Location', 'erdu-wp'), 'name' => 'location', 'type' => 'text'),
                    array('key' => 'field_hec_booth', 'label' => __('Booth', 'erdu-wp'), 'name' => 'booth', 'type' => 'text'),
                ),
            ),

            // --- Partners Tab ---
            array('key' => 'field_home_tab_partners', 'label' => __('Partners', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_home_partners_title', 'label' => __('Section Title', 'erdu-wp'), 'name' => 'home_partners_title', 'type' => 'text'),
            array(
                'key'          => 'field_home_partners',
                'label'        => __('Partners', 'erdu-wp'),
                'name'         => 'home_partners',
                'type'         => 'repeater',
                'button_label' => __('Add Partner', 'erdu-wp'),
                'sub_fields'   => array(
                    array('key' => 'field_hprt_name', 'label' => __('Partner Name', 'erdu-wp'), 'name' => 'name', 'type' => 'text', 'required' => 1),
                    array('key' => 'field_hprt_logo', 'label' => __('Logo', 'erdu-wp'), 'name' => 'logo', 'type' => 'image', 'return_format' => 'url'),
                ),
            ),

            // --- FAQ Tab ---
            array('key' => 'field_home_tab_faq', 'label' => __('FAQ', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_home_faq_title', 'label' => __('Section Title', 'erdu-wp'), 'name' => 'home_faq_title', 'type' => 'text'),
            array(
                'key'          => 'field_home_faq_items',
                'label'        => __('FAQ Items', 'erdu-wp'),
                'name'         => 'home_faq_items',
                'type'         => 'repeater',
                'button_label' => __('Add FAQ', 'erdu-wp'),
                'sub_fields'   => array(
                    array('key' => 'field_hf_question', 'label' => __('Question', 'erdu-wp'), 'name' => 'question', 'type' => 'text', 'required' => 1),
                    array('key' => 'field_hf_answer', 'label' => __('Answer', 'erdu-wp'), 'name' => 'answer', 'type' => 'textarea', 'rows' => 4),
                ),
            ),

            // --- Newsletter Tab ---
            array('key' => 'field_home_tab_newsletter', 'label' => __('Newsletter', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_home_news_title', 'label' => __('Section Title', 'erdu-wp'), 'name' => 'home_news_title', 'type' => 'text'),
            array('key' => 'field_home_news_placeholder', 'label' => __('Email Placeholder', 'erdu-wp'), 'name' => 'home_news_placeholder', 'type' => 'text'),
            array('key' => 'field_home_news_button', 'label' => __('Button Text', 'erdu-wp'), 'name' => 'home_news_button', 'type' => 'text'),
        ),
        'location'   => array(array(array('param' => 'page_template', 'operator' => '==', 'value' => 'front-page.php'))),
        'position'   => 'normal',
        'style'      => 'default',
        'menu_order' => 5,
    ));
}


// ==========================================
// Downloads Fields (CPT)
// ==========================================

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
        'key'    => 'group_erdu_download',
        'title'  => __('Download File', 'erdu-wp'),
        'fields' => array(
            array(
                'key'           => 'field_download_file',
                'label'         => __('Upload File', 'erdu-wp'),
                'name'          => 'download_file',
                'type'          => 'file',
                'required'      => 1,
                'return_format' => 'url',
                'library'       => 'all',
                'mime_types'    => 'docx, xlsx, pdf, txt, ies, 3d, dwg, dxf, stp, step, zip, rar',
                'instructions'  => __('Supported formats: DOCX, XLSX, PDF, TXT, IES, 3D, DWG, DXF, STP, ZIP, RAR', 'erdu-wp'),
            ),
            array(
                'key'           => 'field_download_version',
                'label'         => __('Version', 'erdu-wp'),
                'name'          => 'download_version',
                'type'          => 'text',
                'instructions'  => __('e.g. v2.1, 2026 Edition', 'erdu-wp'),
            ),
            array(
                'key'           => 'field_download_size',
                'label'         => __('File Size (auto-detected)', 'erdu-wp'),
                'name'          => 'download_size',
                'type'          => 'text',
                'instructions'  => __('e.g. 2.5 MB, 1.2 GB. Leave empty to auto-detect.', 'erdu-wp'),
            ),
            array(
                'key'           => 'field_download_description',
                'label'         => __('Description', 'erdu-wp'),
                'name'          => 'download_description',
                'type'          => 'textarea',
                'rows'          => 3,
            ),
            array(
                'key'           => 'field_download_external',
                'label'         => __('External Link (optional)', 'erdu-wp'),
                'name'          => 'download_external',
                'type'          => 'url',
                'instructions'  => __('If set, this URL will be used instead of the uploaded file.', 'erdu-wp'),
            ),
        ),
        'location' => array(
            array(
                array('param' => 'post_type', 'operator' => '==', 'value' => 'erdu_download'),
            ),
        ),
        'position' => 'normal',
        'style'    => 'default',
        'menu_order' => 0,
    ));
}

// ==========================================
// Blog Page Fields
// ==========================================

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
        'key'    => 'group_page_blog',
        'title'  => __('Blog Page Content', 'erdu-wp'),
        'fields' => array(
            // --- Hero Tab ---
            array('key' => 'field_blog_tab_hero', 'label' => __('Hero Banner', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_blog_hero_title', 'label' => __('Hero Title', 'erdu-wp'), 'name' => 'blog_hero_title', 'type' => 'text'),
            array('key' => 'field_blog_hero_subtitle', 'label' => __('Hero Subtitle', 'erdu-wp'), 'name' => 'blog_hero_subtitle', 'type' => 'textarea', 'rows' => 2),
            array('key' => 'field_blog_hero_bg', 'label' => __('Hero Background Image', 'erdu-wp'), 'name' => 'blog_hero_bg', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium'),
            array('key' => 'field_blog_hero_btn', 'label' => __('Primary Button Text', 'erdu-wp'), 'name' => 'blog_hero_btn', 'type' => 'text'),
            array('key' => 'field_blog_hero_btn_link', 'label' => __('Primary Button Link', 'erdu-wp'), 'name' => 'blog_hero_btn_link', 'type' => 'page_link', 'allow_null' => 1),
            array('key' => 'field_blog_hero_btn2', 'label' => __('Secondary Button Text', 'erdu-wp'), 'name' => 'blog_hero_btn2', 'type' => 'text'),
            array('key' => 'field_blog_hero_btn2_link', 'label' => __('Secondary Button Link', 'erdu-wp'), 'name' => 'blog_hero_btn2_link', 'type' => 'page_link', 'allow_null' => 1),

            // --- Page Content Tab ---
            array('key' => 'field_blog_tab_content', 'label' => __('Page Content', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_blog_page_editor', 'label' => __('Content (between Hero and Blog Grid)', 'erdu-wp'), 'name' => 'blog_page_editor', 'type' => 'wysiwyg', 'toolbar' => 'full', 'tabs' => 'all', 'media_upload' => 1),

            // --- Intro Tab ---
            array('key' => 'field_blog_tab_intro', 'label' => __('Introduction', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_blog_intro', 'label' => __('Blog Introduction', 'erdu-wp'), 'name' => 'blog_intro', 'type' => 'wysiwyg', 'toolbar' => 'full'),

            // --- Settings Tab ---
            array('key' => 'field_blog_tab_settings', 'label' => __('Blog Settings', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_blog_count', 'label' => __('Max Posts per Page', 'erdu-wp'), 'name' => 'blog_count', 'type' => 'number', 'default_value' => 9, 'min' => 1, 'max' => 24),
            array('key' => 'field_blog_show_categories', 'label' => __('Show Category Filter', 'erdu-wp'), 'name' => 'blog_show_categories', 'type' => 'true_false', 'ui' => 1, 'default_value' => 1),
            array('key' => 'field_blog_show_excerpt', 'label' => __('Show Excerpt', 'erdu-wp'), 'name' => 'blog_show_excerpt', 'type' => 'true_false', 'ui' => 1, 'default_value' => 1),
            array('key' => 'field_blog_show_date', 'label' => __('Show Date', 'erdu-wp'), 'name' => 'blog_show_date', 'type' => 'true_false', 'ui' => 1, 'default_value' => 1),
            array('key' => 'field_blog_show_author', 'label' => __('Show Author', 'erdu-wp'), 'name' => 'blog_show_author', 'type' => 'true_false', 'ui' => 1, 'default_value' => 1),
            array('key' => 'field_blog_show_readmore', 'label' => __('Show Read More Link', 'erdu-wp'), 'name' => 'blog_show_readmore', 'type' => 'true_false', 'ui' => 1, 'default_value' => 1),

            // --- Featured Posts Tab ---
            array('key' => 'field_blog_tab_featured', 'label' => __('Featured Posts', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_blog_featured_show', 'label' => __('Show Featured Section', 'erdu-wp'), 'name' => 'blog_featured_show', 'type' => 'true_false', 'ui' => 1, 'default_value' => 1),
            array('key' => 'field_blog_featured_title', 'label' => __('Featured Section Title', 'erdu-wp'), 'name' => 'blog_featured_title', 'type' => 'text', 'default_value' => 'Featured Articles'),
            array('key' => 'field_blog_featured_count', 'label' => __('Number of Featured Posts', 'erdu-wp'), 'name' => 'blog_featured_count', 'type' => 'number', 'default_value' => 3, 'min' => 1, 'max' => 6),

            // --- CTA Tab ---
            array('key' => 'field_blog_tab_cta', 'label' => __('CTA Section', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_blog_cta_override', 'label' => __('Override CTA', 'erdu-wp'), 'name' => 'blog_cta_override', 'type' => 'true_false', 'ui' => 1),
            array('key' => 'field_blog_cta_title', 'label' => __('CTA Title', 'erdu-wp'), 'name' => 'blog_cta_title', 'type' => 'text', 'conditional_logic' => array(array(array('field' => 'field_blog_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_blog_cta_button', 'label' => __('Primary Button Text', 'erdu-wp'), 'name' => 'blog_cta_button', 'type' => 'text', 'conditional_logic' => array(array(array('field' => 'field_blog_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_blog_cta_link', 'label' => __('Primary Button Link', 'erdu-wp'), 'name' => 'blog_cta_link', 'type' => 'page_link', 'allow_null' => 1, 'conditional_logic' => array(array(array('field' => 'field_blog_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_blog_cta_button2', 'label' => __('Secondary Button Text', 'erdu-wp'), 'name' => 'blog_cta_button2', 'type' => 'text', 'conditional_logic' => array(array(array('field' => 'field_blog_cta_override', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_blog_cta_link2', 'label' => __('Secondary Button Link', 'erdu-wp'), 'name' => 'blog_cta_link2', 'type' => 'page_link', 'allow_null' => 1, 'conditional_logic' => array(array(array('field' => 'field_blog_cta_override', 'operator' => '==', 'value' => '1')))),
        ),
        'location'   => array(array(array('param' => 'page_template', 'operator' => '==', 'value' => 'page-blog.php'))),
        'position'   => 'normal',
        'style'      => 'default',
        'menu_order' => 5,
    ));
}

// ==========================================
// Footer Options Page
// ==========================================

/**
 * Read a Footer ACF option field with fallback default.
 *
 * @param string $field_name ACF field name (without 'ft_' prefix — pass full name).
 * @param mixed  $default    Fallback value if field is empty.
 * @return mixed
 */
function erdu_footer_field($field_name, $default = '')
{
    if (function_exists('get_field')) {
        $value = get_field($field_name, 'option');
        if ($value !== null && $value !== '' && !(is_array($value) && empty($value))) {
            return $value;
        }
    }
    return $default;
}

add_action('acf/init', 'erdu_register_footer_acf_fields');
function erdu_register_footer_acf_fields()
{
    if (!function_exists('acf_add_options_page') || !function_exists('acf_add_local_field_group')) {
        return;
    }

    // Register Options Page for Footer
    acf_add_options_page(array(
        'page_title'  => __('Footer Settings', 'erdu-wp'),
        'menu_title'  => __('Footer', 'erdu-wp'),
        'menu_slug'   => 'erdu-footer-settings',
        'parent_slug' => 'erdu-dashboard',
        'capability'  => 'manage_options',
        'redirect'    => false,
        'position'    => 5,
    ));

    // --- Footer Field Group ---
    acf_add_local_field_group(array(
        'key'      => 'group_footer',
        'title'    => __('Footer Settings', 'erdu-wp'),
        'fields'   => array(

            // ===== Logo & About Tab =====
            array('key' => 'field_ft_tab_logo', 'label' => __('Logo & About', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_ft_logo_type', 'label' => __('Logo Type', 'erdu-wp'), 'name' => 'ft_logo_type', 'type' => 'radio',
                'choices' => array('text' => __('Text Logo', 'erdu-wp'), 'image' => __('Image Logo', 'erdu-wp')),
                'default_value' => 'text', 'layout' => 'horizontal'),
            array('key' => 'field_ft_logo_image', 'label' => __('Logo Image', 'erdu-wp'), 'name' => 'ft_logo_image', 'type' => 'image', 'return_format' => 'url', 'conditional_logic' => array(array(array('field' => 'field_ft_logo_type', 'operator' => '==', 'value' => 'image')))),
            array('key' => 'field_ft_logo_text', 'label' => __('Logo Text', 'erdu-wp'), 'name' => 'ft_logo_text', 'type' => 'text', 'default_value' => 'ERDU LIGHTING'),
            array('key' => 'field_ft_logo_icon', 'label' => __('Show Icon Badge', 'erdu-wp'), 'name' => 'ft_logo_icon', 'type' => 'true_false', 'ui' => 1, 'default_value' => 1),
            array('key' => 'field_ft_logo_icon_text', 'label' => __('Icon Text (1 letter)', 'erdu-wp'), 'name' => 'ft_logo_icon_text', 'type' => 'text', 'default_value' => 'E', 'conditional_logic' => array(array(array('field' => 'field_ft_logo_icon', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_ft_about', 'label' => __('About Description', 'erdu-wp'), 'name' => 'ft_about', 'type' => 'textarea', 'rows' => 4,
                'default_value' => 'Professional 48V Magnetic Track Light Manufacturer since 2009. 6300m² factory, 100+ employees, exporting to 20+ countries.'),

            // ===== Social Links Tab =====
            array('key' => 'field_ft_tab_social', 'label' => __('Social Links', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_ft_social_show', 'label' => __('Show Social Icons', 'erdu-wp'), 'name' => 'ft_social_show', 'type' => 'true_false', 'ui' => 1, 'default_value' => 1),
            array('key' => 'field_ft_social_links', 'label' => __('Social Links', 'erdu-wp'), 'name' => 'ft_social_links', 'type' => 'repeater', 'button_label' => __('Add Social Link', 'erdu-wp'),
                'sub_fields' => array(
                    array('key' => 'field_ft_sl_platform', 'label' => __('Platform', 'erdu-wp'), 'name' => 'platform', 'type' => 'select',
                        'choices' => array(
                            'facebook'  => 'Facebook',
                            'linkedin'  => 'LinkedIn',
                            'youtube'   => 'YouTube',
                            'instagram' => 'Instagram',
                            'twitter'   => 'Twitter / X',
                            'whatsapp'  => 'WhatsApp',
                            'wechat'    => 'WeChat',
                            'tiktok'    => 'TikTok',
                            'pinterest' => 'Pinterest',
                            'custom'    => __('Custom', 'erdu-wp'),
                        )),
                    array('key' => 'field_ft_sl_url', 'label' => __('URL', 'erdu-wp'), 'name' => 'url', 'type' => 'url', 'required' => 1),
                    array('key' => 'field_ft_sl_label', 'label' => __('Label (for accessibility)', 'erdu-wp'), 'name' => 'label', 'type' => 'text'),
                )),

            // ===== Quick Links Tab =====
            array('key' => 'field_ft_tab_quicklinks', 'label' => __('Quick Links', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_ft_quicklinks_show', 'label' => __('Show Quick Links Column', 'erdu-wp'), 'name' => 'ft_quicklinks_show', 'type' => 'true_false', 'ui' => 1, 'default_value' => 1),
            array('key' => 'field_ft_quicklinks_title', 'label' => __('Column Title', 'erdu-wp'), 'name' => 'ft_quicklinks_title', 'type' => 'text', 'default_value' => 'Quick Links'),
            array('key' => 'field_ft_quicklinks', 'label' => __('Links', 'erdu-wp'), 'name' => 'ft_quicklinks', 'type' => 'repeater', 'button_label' => __('Add Link', 'erdu-wp'),
                'sub_fields' => array(
                    array('key' => 'field_ft_ql_label', 'label' => __('Label', 'erdu-wp'), 'name' => 'label', 'type' => 'text', 'required' => 1),
                    array('key' => 'field_ft_ql_url', 'label' => __('URL', 'erdu-wp'), 'name' => 'url', 'type' => 'link', 'return_format' => 'url'),
                ),
                'default_value' => array(
                    array('label' => 'Products', 'url' => ''),
                    array('label' => 'Solutions', 'url' => ''),
                    array('label' => 'About Us', 'url' => ''),
                    array('label' => 'Quality First', 'url' => ''),
                    array('label' => 'Distributor Program', 'url' => ''),
                    array('label' => 'Case Studies', 'url' => ''),
                    array('label' => 'News', 'url' => ''),
                    array('label' => 'Contact', 'url' => ''),
                )),

            // ===== Contact Info Tab =====
            array('key' => 'field_ft_tab_contact', 'label' => __('Contact Info', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_ft_contact_show', 'label' => __('Show Contact Info Column', 'erdu-wp'), 'name' => 'ft_contact_show', 'type' => 'true_false', 'ui' => 1, 'default_value' => 1),
            array('key' => 'field_ft_contact_title', 'label' => __('Column Title', 'erdu-wp'), 'name' => 'ft_contact_title', 'type' => 'text', 'default_value' => 'Contact Info'),
            array('key' => 'field_ft_contact_address', 'label' => __('Address', 'erdu-wp'), 'name' => 'ft_contact_address', 'type' => 'textarea', 'rows' => 3,
                'default_value' => "6th Floor, JinYe Building, Tongyi Industrial District, Guzhen, Zhongshan, Guangdong, China"),
            array('key' => 'field_ft_contact_phone', 'label' => __('Phone', 'erdu-wp'), 'name' => 'ft_contact_phone', 'type' => 'text', 'default_value' => '+86-760-22380830'),
            array('key' => 'field_ft_contact_mobile', 'label' => __('Mobile', 'erdu-wp'), 'name' => 'ft_contact_mobile', 'type' => 'text', 'default_value' => '+86-18938760626'),
            array('key' => 'field_ft_contact_email', 'label' => __('Email', 'erdu-wp'), 'name' => 'ft_contact_email', 'type' => 'email', 'default_value' => 'gg@erduled.com'),
            array('key' => 'field_ft_contact_hours', 'label' => __('Business Hours', 'erdu-wp'), 'name' => 'ft_contact_hours', 'type' => 'text', 'default_value' => 'Mon-Fri 9:00-18:00 CST'),

            // ===== Newsletter Tab =====
            array('key' => 'field_ft_tab_newsletter', 'label' => __('Newsletter', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_ft_newsletter_show', 'label' => __('Show Newsletter Column', 'erdu-wp'), 'name' => 'ft_newsletter_show', 'type' => 'true_false', 'ui' => 1, 'default_value' => 1),
            array('key' => 'field_ft_newsletter_title', 'label' => __('Title', 'erdu-wp'), 'name' => 'ft_newsletter_title', 'type' => 'text', 'default_value' => 'Newsletter'),
            array('key' => 'field_ft_newsletter_desc', 'label' => __('Description', 'erdu-wp'), 'name' => 'ft_newsletter_desc', 'type' => 'textarea', 'rows' => 2,
                'default_value' => 'Stay updated with latest products & lighting trends.'),
            array('key' => 'field_ft_newsletter_placeholder', 'label' => __('Email Placeholder', 'erdu-wp'), 'name' => 'ft_newsletter_placeholder', 'type' => 'text', 'default_value' => 'Your email'),
            array('key' => 'field_ft_newsletter_button', 'label' => __('Button Text', 'erdu-wp'), 'name' => 'ft_newsletter_button', 'type' => 'text', 'default_value' => 'Subscribe'),
            array('key' => 'field_ft_newsletter_footer', 'label' => __('Footer Text', 'erdu-wp'), 'name' => 'ft_newsletter_footer', 'type' => 'textarea', 'rows' => 2,
                'default_value' => 'Join 500+ lighting professionals who trust our updates.'),

            // ===== Copyright Tab =====
            array('key' => 'field_ft_tab_copyright', 'label' => __('Copyright', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_ft_copyright_text', 'label' => __('Copyright Text', 'erdu-wp'), 'name' => 'ft_copyright_text', 'type' => 'text',
                'default_value' => '© {year} ERDU Lighting Technology Co., Ltd. All Rights Reserved.'),
            array('key' => 'field_ft_copyright_links', 'label' => __('Bottom Links', 'erdu-wp'), 'name' => 'ft_copyright_links', 'type' => 'repeater', 'button_label' => __('Add Link', 'erdu-wp'),
                'sub_fields' => array(
                    array('key' => 'field_ft_cl_label', 'label' => __('Label', 'erdu-wp'), 'name' => 'label', 'type' => 'text', 'required' => 1),
                    array('key' => 'field_ft_cl_url', 'label' => __('URL', 'erdu-wp'), 'name' => 'url', 'type' => 'url'),
                ),
                'default_value' => array(
                    array('label' => 'Privacy Policy', 'url' => '#'),
                    array('label' => 'Terms of Service', 'url' => '#'),
                )),

            // ===== Appearance Tab =====
            array('key' => 'field_ft_tab_appearance', 'label' => __('Appearance', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_ft_bg_color', 'label' => __('Footer Background Color', 'erdu-wp'), 'name' => 'ft_bg_color', 'type' => 'color_picker', 'default_value' => '#1a1a2e'),
            array('key' => 'field_ft_text_color', 'label' => __('Text Color', 'erdu-wp'), 'name' => 'ft_text_color', 'type' => 'color_picker', 'default_value' => '#9ca3af'),
            array('key' => 'field_ft_heading_color', 'label' => __('Heading Color', 'erdu-wp'), 'name' => 'ft_heading_color', 'type' => 'color_picker', 'default_value' => '#ffffff'),
            array('key' => 'field_ft_link_hover_color', 'label' => __('Link Hover Color', 'erdu-wp'), 'name' => 'ft_link_hover_color', 'type' => 'color_picker', 'default_value' => '#F37021'),
            array('key' => 'field_ft_border_color', 'label' => __('Border Color', 'erdu-wp'), 'name' => 'ft_border_color', 'type' => 'color_picker', 'default_value' => '#374151'),

        ),
        'location' => array(array(array('param' => 'options_page', 'operator' => '==', 'value' => 'erdu-footer-settings'))),
        'position' => 'normal',
        'style'    => 'default',
    ));
}

// ==========================================
// Header Options Page
// ==========================================

/**
 * Read a Header ACF option field with fallback default.
 *
 * @param string $field_name ACF field name.
 * @param mixed  $default    Fallback value if field is empty.
 * @return mixed
 */
function erdu_header_field($field_name, $default = '')
{
    if (function_exists('get_field')) {
        $value = get_field($field_name, 'option');
        if ($value !== null && $value !== '' && !(is_array($value) && empty($value))) {
            return $value;
        }
    }
    return $default;
}

add_action('acf/init', 'erdu_register_header_acf_fields');
function erdu_register_header_acf_fields()
{
    if (!function_exists('acf_add_options_page') || !function_exists('acf_add_local_field_group')) {
        return;
    }

    // Register Options Page for Header
    acf_add_options_page(array(
        'page_title'  => __('Header Settings', 'erdu-wp'),
        'menu_title'  => __('Header', 'erdu-wp'),
        'menu_slug'   => 'erdu-header-settings',
        'parent_slug' => 'erdu-dashboard',
        'capability'  => 'manage_options',
        'redirect'    => false,
        'position'    => 4,
    ));

    // --- Header Field Group ---
    acf_add_local_field_group(array(
        'key'      => 'group_header',
        'title'    => __('Header Settings', 'erdu-wp'),
        'fields'   => array(

            // ===== Layout Tab =====
            array('key' => 'field_hd_tab_layout', 'label' => __('Layout', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_hd_layout', 'label' => __('Header Layout', 'erdu-wp'), 'name' => 'hd_layout', 'type' => 'radio',
                'choices' => array(
                    'default'   => __('Default (Logo + Menu + Actions)', 'erdu-wp'),
                    'centered'  => __('Centered Logo', 'erdu-wp'),
                    'split'     => __('Split Menu (Logo Center)', 'erdu-wp'),
                ),
                'default_value' => 'default', 'layout' => 'vertical'),
            array('key' => 'field_hd_width', 'label' => __('Header Width', 'erdu-wp'), 'name' => 'hd_width', 'type' => 'radio',
                'choices' => array('container' => __('Container', 'erdu-wp'), 'full' => __('Full Width', 'erdu-wp')),
                'default_value' => 'container', 'layout' => 'horizontal'),
            array('key' => 'field_hd_height', 'label' => __('Header Height (px)', 'erdu-wp'), 'name' => 'hd_height', 'type' => 'number',
                'default_value' => 64, 'min' => 48, 'max' => 120),
            array('key' => 'field_hd_sticky', 'label' => __('Sticky Header', 'erdu-wp'), 'name' => 'hd_sticky', 'type' => 'true_false',
                'ui' => 1, 'default_value' => 1),
            array('key' => 'field_hd_sticky_shadow', 'label' => __('Shadow on Sticky', 'erdu-wp'), 'name' => 'hd_sticky_shadow', 'type' => 'true_false',
                'ui' => 1, 'default_value' => 1, 'conditional_logic' => array(array(array('field' => 'field_hd_sticky', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_hd_transparent', 'label' => __('Transparent on Hero', 'erdu-wp'), 'name' => 'hd_transparent', 'type' => 'true_false',
                'ui' => 1, 'default_value' => 0, 'instructions' => __('Make header transparent on homepage hero section.', 'erdu-wp')),

            // ===== Elements Visibility Tab =====
            array('key' => 'field_hd_tab_elements', 'label' => __('Elements', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_hd_show_search', 'label' => __('Show Search', 'erdu-wp'), 'name' => 'hd_show_search', 'type' => 'true_false',
                'ui' => 1, 'default_value' => 1),
            array('key' => 'field_hd_show_lang', 'label' => __('Show Language Switcher', 'erdu-wp'), 'name' => 'hd_show_lang', 'type' => 'true_false',
                'ui' => 1, 'default_value' => 1),
            array('key' => 'field_hd_show_phone', 'label' => __('Show Phone', 'erdu-wp'), 'name' => 'hd_show_phone', 'type' => 'true_false',
                'ui' => 1, 'default_value' => 0),
            array('key' => 'field_hd_show_email', 'label' => __('Show Email', 'erdu-wp'), 'name' => 'hd_show_email', 'type' => 'true_false',
                'ui' => 1, 'default_value' => 0),
            array('key' => 'field_hd_show_address', 'label' => __('Show Address', 'erdu-wp'), 'name' => 'hd_show_address', 'type' => 'true_false',
                'ui' => 1, 'default_value' => 0),
            array('key' => 'field_hd_show_cta', 'label' => __('Show CTA Button', 'erdu-wp'), 'name' => 'hd_show_cta', 'type' => 'true_false',
                'ui' => 1, 'default_value' => 1),
            array('key' => 'field_hd_show_social', 'label' => __('Show Social Icons', 'erdu-wp'), 'name' => 'hd_show_social', 'type' => 'true_false',
                'ui' => 1, 'default_value' => 0),

            // ===== Contact Info Tab =====
            array('key' => 'field_hd_tab_contact', 'label' => __('Contact Info', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_hd_phone', 'label' => __('Phone Number', 'erdu-wp'), 'name' => 'hd_phone', 'type' => 'text',
                'default_value' => '+86-760-22380830'),
            array('key' => 'field_hd_email', 'label' => __('Email', 'erdu-wp'), 'name' => 'hd_email', 'type' => 'email',
                'default_value' => 'gg@erduled.com'),
            array('key' => 'field_hd_address', 'label' => __('Address', 'erdu-wp'), 'name' => 'hd_address', 'type' => 'textarea', 'rows' => 2,
                'default_value' => '6th Floor, JinYe Building, Tongyi Industrial District, Guzhen, Zhongshan, Guangdong, China'),
            array('key' => 'field_hd_hours', 'label' => __('Business Hours', 'erdu-wp'), 'name' => 'hd_hours', 'type' => 'text',
                'default_value' => 'Mon-Fri 9:00-18:00 CST'),

            // ===== CTA Button Tab =====
            array('key' => 'field_hd_tab_cta', 'label' => __('CTA Button', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_hd_cta_text', 'label' => __('Button Text', 'erdu-wp'), 'name' => 'hd_cta_text', 'type' => 'text',
                'default_value' => 'Get a Quote'),
            array('key' => 'field_hd_cta_link', 'label' => __('Button Link', 'erdu-wp'), 'name' => 'hd_cta_link', 'type' => 'page_link',
                'allow_null' => 1),
            array('key' => 'field_hd_cta_style', 'label' => __('Button Style', 'erdu-wp'), 'name' => 'hd_cta_style', 'type' => 'radio',
                'choices' => array('primary' => __('Primary', 'erdu-wp'), 'outline' => __('Outline', 'erdu-wp'), 'ghost' => __('Ghost', 'erdu-wp')),
                'default_value' => 'primary', 'layout' => 'horizontal'),
            array('key' => 'field_hd_cta_target', 'label' => __('Open in New Tab', 'erdu-wp'), 'name' => 'hd_cta_target', 'type' => 'true_false',
                'ui' => 1, 'default_value' => 0),

            // ===== Mega Menu Tab =====
            array('key' => 'field_hd_tab_mega', 'label' => __('Mega Menu', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_hd_mega_enable', 'label' => __('Enable Mega Menu', 'erdu-wp'), 'name' => 'hd_mega_enable', 'type' => 'true_false',
                'ui' => 1, 'default_value' => 0),
            array('key' => 'field_hd_mega_trigger', 'label' => __('Trigger Menu Item', 'erdu-wp'), 'name' => 'hd_mega_trigger', 'type' => 'text',
                'default_value' => 'Products', 'instructions' => __('Enter the exact menu item label that triggers the mega menu.', 'erdu-wp'),
                'conditional_logic' => array(array(array('field' => 'field_hd_mega_enable', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_hd_mega_columns', 'label' => __('Number of Columns', 'erdu-wp'), 'name' => 'hd_mega_columns', 'type' => 'select',
                'choices' => array('2' => '2', '3' => '3', '4' => '4'),
                'default_value' => '3',
                'conditional_logic' => array(array(array('field' => 'field_hd_mega_enable', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_hd_mega_blocks', 'label' => __('Mega Menu Blocks', 'erdu-wp'), 'name' => 'hd_mega_blocks', 'type' => 'repeater',
                'button_label' => __('Add Block', 'erdu-wp'),
                'conditional_logic' => array(array(array('field' => 'field_hd_mega_enable', 'operator' => '==', 'value' => '1'))),
                'sub_fields' => array(
                    array('key' => 'field_hd_mb_type', 'label' => __('Block Type', 'erdu-wp'), 'name' => 'type', 'type' => 'select',
                        'choices' => array(
                            'links'      => __('Links List', 'erdu-wp'),
                            'products'   => __('Product Categories', 'erdu-wp'),
                            'image'      => __('Image Card', 'erdu-wp'),
                            'html'       => __('Custom HTML', 'erdu-wp'),
                        ),
                        'default_value' => 'links'),
                    array('key' => 'field_hd_mb_title', 'label' => __('Block Title', 'erdu-wp'), 'name' => 'title', 'type' => 'text'),
                    array('key' => 'field_hd_mb_links', 'label' => __('Links', 'erdu-wp'), 'name' => 'links', 'type' => 'repeater',
                        'button_label' => __('Add Link', 'erdu-wp'),
                        'conditional_logic' => array(array(array('field' => 'field_hd_mb_type', 'operator' => '==', 'value' => 'links'))),
                        'sub_fields' => array(
                            array('key' => 'field_hd_mbl_label', 'label' => __('Label', 'erdu-wp'), 'name' => 'label', 'type' => 'text', 'required' => 1),
                            array('key' => 'field_hd_mbl_url', 'label' => __('URL', 'erdu-wp'), 'name' => 'url', 'type' => 'url', 'required' => 1),
                            array('key' => 'field_hd_mbl_desc', 'label' => __('Description', 'erdu-wp'), 'name' => 'desc', 'type' => 'textarea', 'rows' => 2),
                        )),
                    array('key' => 'field_hd_mb_image', 'label' => __('Image', 'erdu-wp'), 'name' => 'image', 'type' => 'image',
                        'return_format' => 'url', 'conditional_logic' => array(array(array('field' => 'field_hd_mb_type', 'operator' => '==', 'value' => 'image')))),
                    array('key' => 'field_hd_mb_image_link', 'label' => __('Image Link', 'erdu-wp'), 'name' => 'image_link', 'type' => 'url',
                        'conditional_logic' => array(array(array('field' => 'field_hd_mb_type', 'operator' => '==', 'value' => 'image')))),
                    array('key' => 'field_hd_mb_html', 'label' => __('Custom HTML', 'erdu-wp'), 'name' => 'html', 'type' => 'textarea', 'rows' => 6,
                        'conditional_logic' => array(array(array('field' => 'field_hd_mb_type', 'operator' => '==', 'value' => 'html')))),
                )),

            // ===== Top Bar Tab =====
            array('key' => 'field_hd_tab_topbar', 'label' => __('Top Bar', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_hd_topbar_enable', 'label' => __('Enable Top Bar', 'erdu-wp'), 'name' => 'hd_topbar_enable', 'type' => 'true_false',
                'ui' => 1, 'default_value' => 0),
            array('key' => 'field_hd_topbar_left', 'label' => __('Left Content', 'erdu-wp'), 'name' => 'hd_topbar_left', 'type' => 'text',
                'default_value' => '', 'instructions' => __('e.g. Welcome message or announcement.', 'erdu-wp'),
                'conditional_logic' => array(array(array('field' => 'field_hd_topbar_enable', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_hd_topbar_right', 'label' => __('Right Content', 'erdu-wp'), 'name' => 'hd_topbar_right', 'type' => 'text',
                'default_value' => '', 'instructions' => __('e.g. Phone or email.', 'erdu-wp'),
                'conditional_logic' => array(array(array('field' => 'field_hd_topbar_enable', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_hd_topbar_bg', 'label' => __('Background Color', 'erdu-wp'), 'name' => 'hd_topbar_bg', 'type' => 'color_picker',
                'default_value' => '#1a1a2e', 'conditional_logic' => array(array(array('field' => 'field_hd_topbar_enable', 'operator' => '==', 'value' => '1')))),
            array('key' => 'field_hd_topbar_text', 'label' => __('Text Color', 'erdu-wp'), 'name' => 'hd_topbar_text', 'type' => 'color_picker',
                'default_value' => '#ffffff', 'conditional_logic' => array(array(array('field' => 'field_hd_topbar_enable', 'operator' => '==', 'value' => '1')))),

            // ===== Social Links Tab =====
            array('key' => 'field_hd_tab_social', 'label' => __('Social Links', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_hd_social_links', 'label' => __('Social Links', 'erdu-wp'), 'name' => 'hd_social_links', 'type' => 'repeater',
                'button_label' => __('Add Social Link', 'erdu-wp'),
                'sub_fields' => array(
                    array('key' => 'field_hd_sl_platform', 'label' => __('Platform', 'erdu-wp'), 'name' => 'platform', 'type' => 'select',
                        'choices' => array(
                            'facebook'  => 'Facebook',
                            'linkedin'  => 'LinkedIn',
                            'youtube'   => 'YouTube',
                            'instagram' => 'Instagram',
                            'twitter'   => 'Twitter / X',
                            'whatsapp'  => 'WhatsApp',
                            'wechat'    => 'WeChat',
                            'tiktok'    => 'TikTok',
                            'custom'    => __('Custom', 'erdu-wp'),
                        )),
                    array('key' => 'field_hd_sl_url', 'label' => __('URL', 'erdu-wp'), 'name' => 'url', 'type' => 'url', 'required' => 1),
                    array('key' => 'field_hd_sl_label', 'label' => __('Label', 'erdu-wp'), 'name' => 'label', 'type' => 'text'),
                )),

            // ===== Appearance Tab =====
            array('key' => 'field_hd_tab_appearance', 'label' => __('Appearance', 'erdu-wp'), 'name' => '', 'type' => 'tab'),
            array('key' => 'field_hd_bg_color', 'label' => __('Header Background', 'erdu-wp'), 'name' => 'hd_bg_color', 'type' => 'color_picker',
                'default_value' => '#ffffff'),
            array('key' => 'field_hd_text_color', 'label' => __('Text Color', 'erdu-wp'), 'name' => 'hd_text_color', 'type' => 'color_picker',
                'default_value' => '#333333'),
            array('key' => 'field_hd_link_hover', 'label' => __('Link Hover Color', 'erdu-wp'), 'name' => 'hd_link_hover', 'type' => 'color_picker',
                'default_value' => '#F37021'),
            array('key' => 'field_hd_border_color', 'label' => __('Border/Bottom Color', 'erdu-wp'), 'name' => 'hd_border_color', 'type' => 'color_picker',
                'default_value' => '#e5e7eb'),

        ),
        'location' => array(array(array('param' => 'options_page', 'operator' => '==', 'value' => 'erdu-header-settings'))),
        'position' => 'normal',
        'style'    => 'default',
    ));
}
