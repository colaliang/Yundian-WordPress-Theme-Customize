<?php
/**
 * Single Product: Info Column (Title, SKU/Price/MOQ, Excerpt, Attributes, Buttons)
 *
 * Expected variables:
 *   $product  (WC_Product)
 *   $subtitle (string)
 *
 * @package ERDU_Lighting/WooCommerce
 */

defined('ABSPATH') || exit;
?>

<!-- Title & Subtitle -->
<h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-2 leading-tight">
    <?php the_title(); ?>
</h1>
<?php if ($subtitle) : ?>
    <div class="text-lg text-gray-500 mb-4"><?php echo esc_html($subtitle); ?></div>
<?php endif; ?>

<!-- SKU & Price & MOQ -->
<?php
$show_sku   = function_exists('get_field') ? get_field('show_product_sku') : false;
$show_price = function_exists('get_field') ? get_field('show_product_price') : false;
$moq        = function_exists('get_field') ? get_field('product_moq') : '';

if ($show_sku || $show_price || $moq) :
?>
<div class="flex flex-wrap items-center gap-4 mb-6">
    <?php if ($show_sku && wc_product_sku_enabled() && ($sku = $product->get_sku())) : ?>
        <div class="text-sm text-gray-600 bg-gray-100 px-3 py-1 rounded-md">
            <span class="font-medium text-gray-500 mr-1"><?php esc_html_e('SKU:', 'erdu-wp'); ?></span>
            <span class="font-bold text-gray-800"><?php echo esc_html($sku); ?></span>
        </div>
    <?php endif; ?>

    <?php if ($moq) : ?>
        <div class="text-sm text-gray-600 bg-orange-50 px-3 py-1 rounded-md border border-orange-100">
            <span class="font-medium text-orange-600 mr-1"><?php esc_html_e('MOQ:', 'erdu-wp'); ?></span>
            <span class="font-bold text-orange-800"><?php echo esc_html($moq); ?></span>
        </div>
    <?php endif; ?>

    <?php if ($show_price && $product->get_price_html()) : ?>
        <div class="text-2xl font-extrabold text-orange-600">
            <?php echo $product->get_price_html(); ?>
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<!-- Short Description -->
<?php if (has_excerpt()) : ?>
    <div class="prose prose-sm max-w-none text-gray-600 mb-6 leading-relaxed">
        <?php echo wp_kses_post(get_the_excerpt()); ?>
    </div>
<?php endif; ?>

<!-- Key Attributes Grid -->
<?php if (function_exists('have_rows') && have_rows('product_key_attributes')) : ?>
    <div class="mb-8">
        <h3 class="text-lg font-bold text-gray-900 mb-4"><?php esc_html_e('Key Attributes', 'erdu-wp'); ?></h3>
        <div class="bg-gray-50 rounded-xl p-6 border border-gray-100">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-6 gap-x-8">
                <?php while (have_rows('product_key_attributes')) : the_row();
                    $ka_label = get_sub_field('label');
                    $ka_value = get_sub_field('value');
                ?>
                <div class="flex flex-col relative <?php echo (get_row_index() % 3 !== 1) ? 'lg:before:content-[\'\'] lg:before:absolute lg:before:left-[-1rem] lg:before:top-1 lg:before:bottom-1 lg:before:w-px lg:before:bg-gray-200' : ''; ?>">
                    <span class="text-sm text-gray-500 mb-1"><?php echo esc_html($ka_label); ?></span>
                    <span class="font-bold text-gray-900 text-base leading-tight"><?php echo esc_html($ka_value); ?></span>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Product Variations / Attributes -->
<?php
$attributes = $product->get_attributes();
if (!empty($attributes)) :
    $has_visible_attributes = false;
    ob_start();
    foreach ($attributes as $attribute) :
        if (!$attribute->get_visible()) continue;

        $name    = wc_attribute_label($attribute->get_name());
        $options = $attribute->is_taxonomy() ? wc_get_product_terms($product->get_id(), $attribute->get_name(), array('fields' => 'names')) : $attribute->get_options();

        if (!empty($options)) :
            $has_visible_attributes = true;
?>
        <div class="mb-6">
            <h4 class="text-base font-bold text-gray-900 mb-3"><?php echo esc_html($name); ?></h4>
            <div class="flex flex-wrap gap-2 sm:gap-3">
                <?php foreach ($options as $index => $option) : ?>
                    <?php if ($index === 0) : ?>
                        <span class="px-4 py-2 border border-gray-900 rounded-md text-sm font-bold text-gray-900 bg-gray-50 shadow-sm"><?php echo esc_html($option); ?></span>
                    <?php else : ?>
                        <span class="px-4 py-2 bg-gray-100 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-200 transition-colors"><?php echo esc_html($option); ?></span>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
<?php
        endif;
    endforeach;
    $attr_html = ob_get_clean();

    if ($has_visible_attributes) :
        echo '<div class="mb-8">' . $attr_html . '</div>';
    endif;
endif;
?>

<!-- Action Buttons (Inquire & WhatsApp) -->
<div class="flex flex-row items-center gap-4 mb-8">
    <?php
    $inquiry_link = erdu_get_page_url('contact');
    $url = add_query_arg('product', urlencode($product->get_name()), $inquiry_link);
    ?>
    <a href="<?php echo esc_url($url); ?>" class="inline-flex items-center justify-center erdu-bg-primary text-white font-medium rounded transition-colors text-sm shadow-sm erdu-hover-primary erdu-btn-inquire">
        <svg class="w-4 h-4 mr-1.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        <span class="whitespace-nowrap"><?php esc_html_e('Inquire Now', 'erdu-wp'); ?></span>
    </a>

    <?php
    $show_wa   = function_exists('get_field') ? get_field('show_whatsapp_button') : false;
    $wa_number = function_exists('get_field') ? get_field('whatsapp_number') : '';
    if ($show_wa && $wa_number) :
        $wa_text = rawurlencode("Hi, I'm interested in " . $product->get_name());
        $wa_url  = "https://wa.me/" . preg_replace('/[^0-9]/', '', $wa_number) . "?text=" . $wa_text;
    ?>
    <a href="<?php echo esc_url($wa_url); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center text-white font-medium rounded transition-colors text-sm shadow-sm erdu-btn-whatsapp">
        <svg class="w-4 h-4 mr-1.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 0C5.385 0 0 5.385 0 12.031c0 2.122.553 4.195 1.603 6.01L.524 23.475l5.584-1.464A11.97 11.97 0 0012.031 24c6.646 0 12.031-5.385 12.031-12.031S18.677 0 12.031 0zm0 22.015a9.924 9.924 0 01-5.074-1.39l-.364-.216-3.771.989.998-3.676-.237-.377a9.94 9.94 0 01-1.522-5.314c0-5.513 4.487-10 10-10 5.513 0 10 4.487 10 10s-4.487 10-10 10zm5.495-7.513c-.301-.151-1.782-.881-2.057-.981-.275-.101-.476-.151-.676.151-.2.301-.776.981-.951 1.182-.175.201-.35.226-.651.075-.301-.151-1.271-.468-2.42-1.332-.894-.672-1.498-1.503-1.673-1.804-.175-.301-.019-.464.132-.614.136-.135.301-.351.451-.526.151-.175.201-.301.301-.501.101-.201.05-.376-.025-.526-.075-.151-.676-1.628-.926-2.228-.244-.585-.492-.505-.676-.514-.175-.01-.376-.01-.576-.01s-.526.075-.801.376c-.275.301-1.052 1.027-1.052 2.505s1.077 2.905 1.227 3.105c.151.201 2.118 3.228 5.129 4.526 2.063.89 2.853.957 3.914.857 1.135-.106 3.483-1.425 3.984-2.805.501-1.38.501-2.555.351-2.805-.151-.25-.551-.401-.852-.551z"/></svg>
        <span class="whitespace-nowrap">WhatsApp</span>
    </a>
    <?php endif; ?>
</div>
