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
?>
<div id="section-specs" class="erdu-content-block scroll-mt-32">
    <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-4 border-b border-gray-100"><?php esc_html_e('Specifications', 'erdu-wp'); ?></h2>
    <div class="text-gray-600 bg-gray-50 rounded-xl p-1 overflow-hidden">
        <table class="w-full text-left text-base border-collapse bg-white rounded-lg">
            <tbody class="divide-y divide-gray-100">
                <?php while (have_rows('product_specifications')) : the_row();
                    $spec_name  = get_sub_field('spec_name');
                    $spec_value = get_sub_field('spec_value');
                ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <th class="py-4 px-6 font-medium text-gray-500 w-1/3 lg:w-1/4 border-r border-gray-100"><?php echo esc_html($spec_name); ?></th>
                    <td class="py-4 px-6 font-bold text-gray-900"><?php echo esc_html($spec_value); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
