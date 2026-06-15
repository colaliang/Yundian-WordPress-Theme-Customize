<?php
/**
 * Single Product Section: Specifications
 *
 * Displays product specifications in a two-column table layout.
 * Falls back to preset default specifications if none are configured.
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
        // Try to get value from ACF field
        if (!empty($item['field']) && function_exists('get_field')) {
            $acf_value = get_field($item['field']);
            if (!empty($acf_value)) {
                $value = $acf_value;
            }
        }
        // Fallback to default
        if (empty($value) && !empty($item['default'])) {
            $value = $item['default'];
        }
        // Only add if we have a value
        if (!empty($value)) {
            $specs[] = array(
                'name'  => $item['label'],
                'value' => $value,
            );
        }
    }
}

// If still empty, don't render section
if (empty($specs)) {
    return;
}

// Split into two columns for paired layout
$total = count($specs);
$half  = (int) ceil($total / 2);
$left  = array_slice($specs, 0, $half);
$right = array_slice($specs, $half);
?>
<div id="section-specs" class="erdu-content-block scroll-mt-32 py-10 lg:py-16">
    <h2 class="text-2xl font-bold text-gray-900 mb-8 pb-4 border-b border-gray-100"><?php esc_html_e('Specifications', 'erdu-wp'); ?></h2>
    <div class="prose max-w-none border border-gray-200 rounded-lg overflow-hidden">
        <?php
        $max_rows = max(count($left), count($right));
        for ($i = 0; $i < $max_rows; $i++) :
            $has_left  = isset($left[$i]);
            $has_right = isset($right[$i]);
            $is_last   = ($i === $max_rows - 1);
        ?>
        <div class="flex flex-col md:flex-row <?php echo $is_last ? '' : 'border-b border-gray-200'; ?>">
            <?php if ($has_left) : ?>
            <div class="flex flex-1 items-stretch">
                <div class="w-1/2 md:w-1/3 py-4 px-6 bg-gray-50 text-gray-500 text-base leading-relaxed">
                    <?php echo esc_html($left[$i]['name']); ?>
                </div>
                <div class="w-1/2 md:w-2/3 py-4 px-6 text-gray-900 font-semibold text-base leading-relaxed">
                    <?php echo esc_html($left[$i]['value']); ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($has_right) : ?>
            <div class="flex flex-1 items-stretch <?php echo $has_left ? 'border-t md:border-t-0 md:border-l border-gray-200' : ''; ?>">
                <div class="w-1/2 md:w-1/3 py-4 px-6 bg-gray-50 text-gray-500 text-base leading-relaxed">
                    <?php echo esc_html($right[$i]['name']); ?>
                </div>
                <div class="w-1/2 md:w-2/3 py-4 px-6 text-gray-900 font-semibold text-base leading-relaxed">
                    <?php echo esc_html($right[$i]['value']); ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php endfor; ?>
    </div>
    <div class="mb-8"></div>
</div>
