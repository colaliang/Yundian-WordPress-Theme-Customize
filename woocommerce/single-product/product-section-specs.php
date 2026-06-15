<?php
/**
 * Single Product Section: Specifications
 *
 * Displays product specifications in a grid layout.
 * 2k screens and above show up to 3 columns.
 * Spec Name has a fixed width for consistency.
 *
 * @package ERDU_Lighting/WooCommerce
 */

defined('ABSPATH') || exit;

// Collect specs from ACF product_specifications repeater
$specs = array();
if (function_exists('have_rows') && have_rows('product_specifications')) {
    while (have_rows('product_specifications')) : the_row();
        $name  = get_sub_field('spec_name');
        $value = get_sub_field('spec_value');
        if ($name && $value) {
            $specs[] = array(
                'name'  => $name,
                'value' => $value,
            );
        }
    endwhile;
}

// If no specs configured, build from preset default fields
if (empty($specs)) {
    $preset = array(
        array('label' => __('Input Voltage(V)', 'erdu-wp'),         'field' => 'product_voltage',    'default' => '48 V DC'),
        array('label' => __('Color Temperature(CCT)', 'erdu-wp'),  'field' => 'product_cct',        'default' => '3000/4000/6000K'),
        array('label' => __('Color Rendering Index(Ra)', 'erdu-wp'), 'field' => 'product_cri',        'default' => '90'),
        array('label' => __('Lamp Luminous Efficiency(lm/w)', 'erdu-wp'), 'field' => 'product_lumen', 'default' => '80'),
        array('label' => __('Lifespan(Hours)', 'erdu-wp'),          'field' => '',                 'default' => '30000'),
        array('label' => __('Warranty(Year)', 'erdu-wp'),            'field' => 'product_warranty',   'default' => '3-Year'),
        array('label' => __('Installation', 'erdu-wp'),            'field' => '',                 'default' => 'Embedded, Surface Mounted'),
        array('label' => __('Support Dimmer', 'erdu-wp'),           'field' => '',                 'default' => 'Yes'),
        array('label' => __('Led chip', 'erdu-wp'),                'field' => '',                 'default' => 'Cob'),
        array('label' => __('Lamp Body Material', 'erdu-wp'),       'field' => 'product_material',   'default' => 'Aluminum'),
        array('label' => __('Design Style', 'erdu-wp'),            'field' => '',                 'default' => 'Modern'),
        array('label' => __('Application', 'erdu-wp'),             'field' => '',                 'default' => 'Mall'),
        array('label' => __('Item Type', 'erdu-wp'),                'field' => '',                 'default' => 'Track Lights'),
        array('label' => __('Lamp Luminous Flux(lm)', 'erdu-wp'),   'field' => 'product_lumen',      'default' => '540-1620'),
        array('label' => __('Model Number', 'erdu-wp'),             'field' => 'product_model',      'default' => ''),
        array('label' => __('Place of Origin', 'erdu-wp'),          'field' => '',                 'default' => 'Guangdong, China'),
        array('label' => __('Brand Name', 'erdu-wp'),              'field' => '',                 'default' => 'ERDU'),
        array('label' => __('Product Weight(kg)', 'erdu-wp'),       'field' => '',                 'default' => '1.5'),
        array('label' => __('Power', 'erdu-wp'),                   'field' => 'product_power',      'default' => '6W/10W/12W/18W/24W/36W/48W'),
        array('label' => __('Color', 'erdu-wp'),                   'field' => '',                 'default' => 'Black'),
        array('label' => __('Beam angle', 'erdu-wp'),              'field' => '',                 'default' => '24Degree'),
        array('label' => __('Working Time(hours)', 'erdu-wp'),      'field' => '',                 'default' => '30000'),
        array('label' => __('CRI(Ra>)', 'erdu-wp'),                'field' => 'product_cri',        'default' => '90'),
        array('label' => __('LED Light Source', 'erdu-wp'),         'field' => '',                 'default' => 'LED'),
    );

    foreach ($preset as $item) {
        $value = '';
        if (!empty($item['field']) && function_exists('get_field')) {
            $acf_value = get_field($item['field']);
            if (!empty($acf_value)) {
                $value = $acf_value;
            }
        }
        if (empty($value) && !empty($item['default'])) {
            $value = $item['default'];
        }
        if (!empty($value)) {
            $specs[] = array(
                'name'  => $item['label'],
                'value' => $value,
            );
        }
    }
}

if (empty($specs)) {
    return;
}
?>
<div id="section-specs" class="erdu-content-block scroll-mt-32 py-10 lg:py-16">
    <h2 class="text-2xl font-bold text-gray-900 mb-8 pb-4 border-b border-gray-100"><?php esc_html_e('Specifications', 'erdu-wp'); ?></h2>
    <div class="erdu-specs-grid">
        <?php foreach ($specs as $spec) : ?>
        <div class="erdu-spec-item">
            <div class="erdu-spec-name"><?php echo esc_html($spec['name']); ?></div>
            <div class="erdu-spec-value"><?php echo esc_html($spec['value']); ?></div>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="mb-8"></div>
</div>
