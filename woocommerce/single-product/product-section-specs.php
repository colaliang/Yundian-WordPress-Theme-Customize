<?php
/**
 * Single Product Section: Specifications
 *
 * @package ERDU_Lighting/WooCommerce
 */

defined('ABSPATH') || exit;

if (!function_exists('have_rows') || !have_rows('product_specifications')) {
    return;
}

// Collect all spec rows into an array for paired layout
$specs = array();
while (have_rows('product_specifications')) : the_row();
    $specs[] = array(
        'name'  => get_sub_field('spec_name'),
        'value' => get_sub_field('spec_value'),
    );
endwhile;

$total = count($specs);
$half  = (int) ceil($total / 2);
$left  = array_slice($specs, 0, $half);
$right = array_slice($specs, $half);
?>
<div id="section-specs" class="erdu-content-block scroll-mt-32">
    <h2 class="text-2xl font-bold text-gray-900 mb-8 pb-4 border-b border-gray-100"><?php esc_html_e('Specifications', 'erdu-wp'); ?></h2>
    <div class="border border-gray-200 rounded-lg overflow-hidden">
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
                <div class="w-1/2 md:w-5/12 py-4 px-6 bg-gray-50 text-gray-500 text-base leading-relaxed">
                    <?php echo esc_html($left[$i]['name']); ?>
                </div>
                <div class="w-1/2 md:w-7/12 py-4 px-6 text-gray-900 font-semibold text-base leading-relaxed">
                    <?php echo esc_html($left[$i]['value']); ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($has_right) : ?>
            <div class="flex flex-1 items-stretch <?php echo $has_left ? 'border-t md:border-t-0 md:border-l border-gray-200' : ''; ?>">
                <div class="w-1/2 md:w-5/12 py-4 px-6 bg-gray-50 text-gray-500 text-base leading-relaxed">
                    <?php echo esc_html($right[$i]['name']); ?>
                </div>
                <div class="w-1/2 md:w-7/12 py-4 px-6 text-gray-900 font-semibold text-base leading-relaxed">
                    <?php echo esc_html($right[$i]['value']); ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php endfor; ?>
    </div>
</div>
