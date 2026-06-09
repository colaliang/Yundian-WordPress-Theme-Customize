<?php
/**
 * ACF Fields Configuration
 * Compatible with both ACF Free and ACF Pro
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) exit;

// Only run if ACF is active
if (!function_exists('acf_add_local_field_group')) {
    return;
}

// Detect ACF Pro availability
$has_acf_pro = class_exists('acf_field_repeater') || function_exists('acf_repeater');

// ==========================================
// Product Fields
// ==========================================

$product_fields = array(
    array('key' => 'field_product_model',    'label' => __('Model Number', 'erdu-wp'),      'name' => 'product_model',    'type' => 'text'),
    array('key' => 'field_product_power',    'label' => __('Power (W)', 'erdu-wp'),         'name' => 'product_power',    'type' => 'text'),
    array('key' => 'field_product_voltage',  'label' => __('Voltage', 'erdu-wp'),           'name' => 'product_voltage',  'type' => 'text'),
    array('key' => 'field_product_lumen',    'label' => __('Luminous Flux (lm)', 'erdu-wp'), 'name' => 'product_lumen',    'type' => 'text'),
    array('key' => 'field_product_cri',      'label' => __('CRI', 'erdu-wp'),               'name' => 'product_cri',      'type' => 'text'),
    array('key' => 'field_product_cct',      'label' => __('CCT (K)', 'erdu-wp'),           'name' => 'product_cct',      'type' => 'text'),
    array('key' => 'field_product_size',     'label' => __('Size (mm)', 'erdu-wp'),         'name' => 'product_size',     'type' => 'text'),
    array('key' => 'field_product_material', 'label' => __('Material', 'erdu-wp'),          'name' => 'product_material', 'type' => 'text'),
    array('key' => 'field_product_warranty', 'label' => __('Warranty', 'erdu-wp'),          'name' => 'product_warranty', 'type' => 'text'),
    array('key' => 'field_product_pdf',      'label' => __('PDF Spec Sheet URL', 'erdu-wp'),'name' => 'product_pdf',      'type' => 'url'),
);

// NOTE: Product Details fields were removed. Products are now managed via WooCommerce.
// WooCommerce products have their own meta fields; ACF can be added to the 'product'
// post type if needed by creating a new field group targeting post_type == 'product'.

// ==========================================
// WooCommerce Product Categories Fields
// ==========================================
acf_add_local_field_group(array(
    'key'      => 'group_product_cat',
    'title'    => __('Category Settings', 'erdu-wp'),
    'fields'   => array(
        array(
            'key' => 'field_cat_banner',
            'label' => __('Category Banner Image', 'erdu-wp'),
            'name' => 'category_banner_image',
            'type' => 'image',
            'return_format' => 'url',
            'preview_size' => 'medium',
        ),
        array(
            'key' => 'field_cat_subtitle',
            'label' => __('Category Subtitle', 'erdu-wp'),
            'name' => 'category_subtitle',
            'type' => 'text',
        ),
    ),
    'location' => array(
        array(
            array('param' => 'taxonomy', 'operator' => '==', 'value' => 'product_cat')
        )
    ),
    'position' => 'normal',
    'style'    => 'default',
));

// ==========================================
// WooCommerce Product Fields (Landing Page Extensions)
// ==========================================
$wc_product_fields = array(
    // 1. Hero Tab
    array('key' => 'field_wc_tab_hero', 'label' => __('Hero Banner', 'erdu-wp'), 'type' => 'tab'),
    array('key' => 'field_wc_prod_subtitle', 'label' => __('Product Subtitle', 'erdu-wp'), 'name' => 'product_subtitle', 'type' => 'text'),
    array('key' => 'field_wc_hero_bg', 'label' => __('Hero Background Image', 'erdu-wp'), 'name' => 'hero_background_image', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium'),
    array('key' => 'field_wc_hero_img', 'label' => __('Hero Product Image (Cutout)', 'erdu-wp'), 'name' => 'hero_product_image', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium', 'instructions' => 'Optional. Displays over the background.'),
    
    // 2. Features Tab
    array('key' => 'field_wc_tab_features', 'label' => __('Features Blocks', 'erdu-wp'), 'type' => 'tab'),
);

if ($has_acf_pro) {
    $wc_product_fields[] = array(
        'key'        => 'field_wc_prod_features',
        'label'      => __('Product Features', 'erdu-wp'),
        'name'       => 'product_features',
        'type'       => 'repeater',
        'button_label' => __('Add Feature', 'erdu-wp'),
        'sub_fields' => array(
            array('key' => 'field_feat_title', 'label' => __('Title', 'erdu-wp'), 'name' => 'title', 'type' => 'text'),
            array('key' => 'field_feat_desc', 'label' => __('Description', 'erdu-wp'), 'name' => 'description', 'type' => 'textarea', 'rows' => 3),
        ),
    );
} else {
    // For ACF Free, we provide 6 static feature inputs for ease of use
    for ($i = 1; $i <= 6; $i++) {
        $wc_product_fields[] = array(
            'key'   => 'field_wc_prod_feature_' . $i . '_title',
            'label' => sprintf(__('Feature %d Title', 'erdu-wp'), $i),
            'name'  => 'feature_' . $i . '_title',
            'type'  => 'text',
        );
        $wc_product_fields[] = array(
            'key'   => 'field_wc_prod_feature_' . $i . '_desc',
            'label' => sprintf(__('Feature %d Description', 'erdu-wp'), $i),
            'name'  => 'feature_' . $i . '_description',
            'type'  => 'textarea',
            'rows'  => 2,
        );
    }
}

// 3. Applications Tab
$wc_product_fields[] = array('key' => 'field_wc_tab_apps', 'label' => __('Applications Gallery', 'erdu-wp'), 'type' => 'tab');
if ($has_acf_pro) {
    $wc_product_fields[] = array('key' => 'field_wc_app_gallery', 'label' => __('Application Images', 'erdu-wp'), 'name' => 'application_images', 'type' => 'gallery', 'return_format' => 'url');
} else {
    $wc_product_fields[] = array('key' => 'field_wc_app_gallery', 'label' => __('Application Image URLs (one per line)', 'erdu-wp'), 'name' => 'application_images_text', 'type' => 'textarea', 'rows' => 4);
}

// 4. Downloads Tab
$wc_product_fields[] = array('key' => 'field_wc_tab_dl', 'label' => __('Downloads', 'erdu-wp'), 'type' => 'tab');
if ($has_acf_pro) {
    $wc_product_fields[] = array(
        'key'        => 'field_wc_prod_downloads',
        'label'      => __('Downloads & Resources', 'erdu-wp'),
        'name'       => 'product_downloads',
        'type'       => 'repeater',
        'button_label' => __('Add Download', 'erdu-wp'),
        'sub_fields' => array(
            array('key' => 'field_dl_title', 'label' => __('Title', 'erdu-wp'), 'name' => 'title', 'type' => 'text'),
            array('key' => 'field_dl_file', 'label' => __('File URL', 'erdu-wp'), 'name' => 'file', 'type' => 'url'),
        ),
    );
} else {
    // For ACF Free, we provide 3 static download inputs
    for ($i = 1; $i <= 3; $i++) {
        $wc_product_fields[] = array(
            'key'   => 'field_wc_prod_download_' . $i . '_title',
            'label' => sprintf(__('Download %d Title', 'erdu-wp'), $i),
            'name'  => 'download_' . $i . '_title',
            'type'  => 'text',
        );
        $wc_product_fields[] = array(
            'key'   => 'field_wc_prod_download_' . $i . '_file',
            'label' => sprintf(__('Download %d File URL', 'erdu-wp'), $i),
            'name'  => 'download_' . $i . '_file',
            'type'  => 'url',
        );
    }
}

acf_add_local_field_group(array(
    'key'      => 'group_wc_product',
    'title'    => __('Product Landing Page Data', 'erdu-wp'),
    'fields'   => $wc_product_fields,
    'location' => array(
        array(
            array('param' => 'post_type', 'operator' => '==', 'value' => 'product')
        )
    ),
    'position' => 'normal',
    'style'    => 'default',
));

// ==========================================
// Case Study Fields
// ==========================================

$case_fields = array(
    array('key' => 'field_case_client',    'label' => __('Client Name', 'erdu-wp'),   'name' => 'case_client',    'type' => 'text'),
    array('key' => 'field_case_location',  'label' => __('Location', 'erdu-wp'),      'name' => 'case_location',  'type' => 'text'),
    array('key' => 'field_case_area',      'label' => __('Area (m2)', 'erdu-wp'),     'name' => 'case_area',      'type' => 'text'),
    array('key' => 'field_case_date',      'label' => __('Completion Date', 'erdu-wp'),'name' => 'case_date',      'type' => 'text'),
    array('key' => 'field_case_challenge', 'label' => __('Challenge', 'erdu-wp'),     'name' => 'case_challenge', 'type' => 'textarea', 'rows' => 4),
    array('key' => 'field_case_solution',  'label' => __('Solution', 'erdu-wp'),      'name' => 'case_solution',  'type' => 'textarea', 'rows' => 4),
    array('key' => 'field_case_result',    'label' => __('Result', 'erdu-wp'),        'name' => 'case_result',    'type' => 'textarea', 'rows' => 4),
    array('key' => 'field_case_rating',    'label' => __('Client Rating (1-5)', 'erdu-wp'),'name' => 'case_rating','type' => 'number', 'min' => 1, 'max' => 5),
    array('key' => 'field_case_person',    'label' => __('Contact Person', 'erdu-wp'),'name' => 'case_person',    'type' => 'text'),
    array('key' => 'field_case_title',     'label' => __('Person Title', 'erdu-wp'),  'name' => 'case_title',     'type' => 'text'),
    array('key' => 'field_case_testimonial','label' => __('Testimonial', 'erdu-wp'),  'name' => 'case_testimonial','type' => 'textarea', 'rows' => 4),
);

// Metrics - Pro uses repeater, Free uses JSON text
if ($has_acf_pro) {
    $case_fields[] = array(
        'key'        => 'field_case_metrics',
        'label'      => __('Key Metrics', 'erdu-wp'),
        'name'       => 'case_metrics',
        'type'       => 'repeater',
        'sub_fields' => array(
            array('key' => 'field_metric_label', 'label' => __('Label', 'erdu-wp'), 'name' => 'metric_label', 'type' => 'text'),
            array('key' => 'field_metric_value', 'label' => __('Value', 'erdu-wp'), 'name' => 'metric_value', 'type' => 'text'),
        ),
        'min' => 0,
        'max' => 4,
    );
    $case_fields[] = array(
        'key'        => 'field_case_products',
        'label'      => __('Products Used', 'erdu-wp'),
        'name'       => 'case_products',
        'type'       => 'repeater',
        'sub_fields' => array(
            array('key' => 'field_product_name', 'label' => __('Product Name', 'erdu-wp'), 'name' => 'product_name', 'type' => 'text'),
        ),
    );
} else {
    $case_fields[] = array(
        'key'   => 'field_case_metrics',
        'label' => __('Key Metrics (Label: Value, one per line)', 'erdu-wp'),
        'name'  => 'case_metrics',
        'type'  => 'textarea',
        'rows'  => 4,
        'instructions' => __('Format: Label: Value (e.g., Energy Savings: 65%)', 'erdu-wp'),
    );
    $case_fields[] = array(
        'key'   => 'field_case_products',
        'label' => __('Products Used (one per line)', 'erdu-wp'),
        'name'  => 'case_products',
        'type'  => 'textarea',
        'rows'  => 4,
    );
}

acf_add_local_field_group(array(
    'key'      => 'group_case',
    'title'    => __('Case Study Details', 'erdu-wp'),
    'fields'   => $case_fields,
    'location' => array(array(array('param' => 'post_type', 'operator' => '==', 'value' => 'erdu_case'))),
    'position' => 'normal',
    'style'    => 'default',
));

// ==========================================
// Exhibition Fields
// ==========================================

acf_add_local_field_group(array(
    'key'      => 'group_exhibition',
    'title'    => __('Exhibition Details', 'erdu-wp'),
    'fields'   => array(
        array('key' => 'field_expo_location', 'label' => __('Venue', 'erdu-wp'),      'name' => 'expo_location', 'type' => 'text'),
        array('key' => 'field_expo_date',     'label' => __('Date', 'erdu-wp'),       'name' => 'expo_date',     'type' => 'text'),
        array('key' => 'field_expo_booth',    'label' => __('Booth Number', 'erdu-wp'),'name' => 'expo_booth',    'type' => 'text'),
        array('key' => 'field_expo_status',   'label' => __('Status', 'erdu-wp'),     'name' => 'expo_status',   'type' => 'select',
            'choices' => array('upcoming' => 'Upcoming', 'ongoing' => 'Ongoing', 'completed' => 'Completed')),
    ),
    'location' => array(array(array('param' => 'post_type', 'operator' => '==', 'value' => 'erdu_exhibition'))),
    'position' => 'normal',
    'style'    => 'default',
));

// Note: Home Page fields are defined in acf-page-fields.php as group_page_home
// (more comprehensive version with Tabbed interface)
