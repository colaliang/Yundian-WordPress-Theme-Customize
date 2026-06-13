<?php
/**
 * The template for displaying product content in the single-product.php template
 * Split Screen Accordion Style (Astra Reference)
 *
 * @package ERDU_Lighting/WooCommerce
 */

defined('ABSPATH') || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 * @hooked woocommerce_output_all_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}

$subtitle = function_exists('get_field') ? get_field('product_subtitle') : '';

// Prepare gallery data
$video_url      = function_exists('get_field') ? get_field('product_video_url') : '';
$has_video      = !empty($video_url);
$main_image_id  = $product->get_image_id();
$attachment_ids = $product->get_gallery_image_ids();
$all_image_ids  = array_filter(array_merge(array($main_image_id), $attachment_ids));

// Prepare bottom section flags
$content         = get_the_content();
$has_desc        = trim(strip_tags($content));
$has_features    = function_exists('have_rows') && have_rows('product_features');
$has_specs       = function_exists('have_rows') && have_rows('product_specifications');
$has_certificates= function_exists('have_rows') && have_rows('product_certificates');
$has_faq         = function_exists('have_rows') && have_rows('product_faq');
$has_downloads   = function_exists('have_rows') && have_rows('product_downloads');
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class('product-split-wrapper erdu-container py-12', $product); ?>>

    <!-- Breadcrumbs -->
    <?php
    $erdu_settings   = function_exists('erdu_default_settings') ? get_option('erdu_settings', erdu_default_settings()) : get_option('erdu_settings', array());
    $show_breadcrumb = isset($erdu_settings['show_breadcrumb']) ? $erdu_settings['show_breadcrumb'] : true;

    if ($show_breadcrumb) {
        woocommerce_breadcrumb(array(
            'wrap_before' => '<nav class="woocommerce-breadcrumb text-sm text-gray-500 mb-6 font-medium flex flex-wrap items-center gap-2">',
            'wrap_after'  => '</nav>',
            'delimiter'   => '<span class="text-gray-300">/</span>',
        ));
    }
    ?>

    <!-- SECTION 1: Gallery (Left) & Info (Right) -->
    <div class="flex flex-col lg:flex-row gap-12 xl:gap-16 mb-16 erdu-product-columns">

        <!-- Left Column: Gallery & Video -->
        <div class="w-full lg:w-1/2 flex flex-col erdu-product-col-left">
            <?php
            wc_get_template('single-product/product-gallery.php', array(
                'product'       => $product,
                'all_image_ids' => $all_image_ids,
                'has_video'     => $has_video,
                'video_url'     => $video_url,
            ));
            ?>
        </div>

        <!-- Right Column: Product Info -->
        <div class="w-full xl:w-1/2 self-start xl:sticky xl:top-24 erdu-product-col-right">
            <?php
            wc_get_template('single-product/product-info.php', array(
                'product'  => $product,
                'subtitle' => $subtitle,
            ));
            ?>
        </div>

    </div>

    <!-- Related Products Section (Between Section 1 & 2) -->
    <?php
    $related_template = 'single-product/product-section-related.php';
    if (file_exists(get_template_directory() . '/woocommerce/' . $related_template)) {
        wc_get_template($related_template, array('product' => $product));
    } else {
        echo '<!-- DEBUG: Template not found: ' . esc_html($related_template) . ' -->';
    }
    ?>

    <!-- SECTION 2: Vertical Flow Content (Bottom) -->
    <div class="product-tabs-section w-full erdu-product-tabs-shell">
        <div class="w-full erdu-product-tabs-layout">

            <!-- Sticky Navigation Menu -->
            <div class="sticky top-[70px] z-40 bg-white/95 backdrop-blur-sm -mx-4 px-4 sm:mx-0 sm:px-0 erdu-product-sections-nav-wrap erdu-product-tabs-bar-wrap">
                <nav class="flex overflow-x-auto hide-scrollbar justify-start erdu-product-sections-nav erdu-product-tabs-bar" aria-label="Product Sections">
                    <?php
                    $nav_items = array();
                    if ($has_desc)        $nav_items[] = array('id' => 'section-desc',         'label' => __('Description', 'erdu-wp'));
                    if ($has_features)    $nav_items[] = array('id' => 'section-features',     'label' => __('Features', 'erdu-wp'));
                    if ($has_specs)       $nav_items[] = array('id' => 'section-specs',        'label' => __('Specs', 'erdu-wp'));
                    if ($has_certificates) $nav_items[] = array('id' => 'section-certificates', 'label' => __('Certificates', 'erdu-wp'));
                    if ($has_faq)         $nav_items[] = array('id' => 'section-faq',          'label' => __('FAQ', 'erdu-wp'));
                    if ($has_downloads)   $nav_items[] = array('id' => 'section-downloads',    'label' => __('Downloads', 'erdu-wp'));

                    foreach ($nav_items as $i => $item) :
                        $is_first = ($i === 0);
                    ?>
                    <a href="#<?php echo esc_attr($item['id']); ?>" class="erdu-nav-link erdu-product-tab-link whitespace-nowrap <?php echo $is_first ? 'active' : ''; ?>">
                        <?php echo esc_html($item['label']); ?>
                    </a>
                    <?php endforeach; ?>
                </nav>
            </div>

            <!-- Content Blocks -->
            <div class="erdu-content-blocks">
                <?php
                wc_get_template('single-product/product-section-desc.php');
                wc_get_template('single-product/product-section-features.php');
                wc_get_template('single-product/product-section-specs.php');
                wc_get_template('single-product/product-section-certificates.php');
                wc_get_template('single-product/product-section-faq.php');
                wc_get_template('single-product/product-section-downloads.php');
                ?>
            </div>

        </div>
    </div>

</div>

<?php
do_action('woocommerce_after_single_product');
