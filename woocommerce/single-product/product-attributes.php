<?php
/**
 * Product attributes
 *
 * This template overrides the default WooCommerce product-attributes.php for Tailwind CSS styling.
 *
 * @package ERDU_Lighting/WooCommerce
 */

defined('ABSPATH') || exit;

if (!$product_attributes) {
    return;
}
?>
<div class="overflow-x-auto rounded-lg border border-gray-200">
    <table class="woocommerce-product-attributes shop_attributes min-w-full divide-y divide-gray-200 text-sm">
        <tbody class="divide-y divide-gray-200 bg-white">
            <?php foreach ($product_attributes as $product_attribute_key => $product_attribute) : ?>
                <tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--<?php echo esc_attr($product_attribute_key); ?> hover:bg-gray-50 transition-colors">
                    <th class="woocommerce-product-attributes-item__label whitespace-nowrap px-6 py-4 font-medium text-gray-900 bg-gray-50 w-1/3">
                        <?php echo wp_kses_post($product_attribute['label']); ?>
                    </th>
                    <td class="woocommerce-product-attributes-item__value px-6 py-4 text-gray-600 w-2/3">
                        <?php echo wp_kses_post($product_attribute['value']); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
