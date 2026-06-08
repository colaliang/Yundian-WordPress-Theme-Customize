<?php
/**
 * Template Name: Product Category / Series
 *
 * Displays products from a specific category on a standard page.
 *
 * @package ERDU_Lighting
 */

get_header();

$hero_title    = erdu_page_field('pc_hero_title', get_the_title());
$hero_subtitle = erdu_page_field('pc_hero_subtitle', '');
$hero_bg       = erdu_page_field('pc_hero_bg', 'https://images.unsplash.com/photo-1565814329452-e1efa11c5b89?w=1200');
$page_content  = erdu_page_field('pc_page_editor', '');
$category_id   = erdu_page_field('pc_category', '');
?>

<!-- Hero -->
<section class="relative py-20 erdu-bg-dark">
    <div class="absolute inset-0 opacity-20" style="background-image: url('<?php echo esc_url($hero_bg); ?>'); background-size: cover; background-position: center;"></div>
    <div class="relative erdu-container text-center">
        <?php erdu_breadcrumb(); ?>
        <h1 class="text-3xl md:text-4xl font-bold text-white"><?php echo esc_html($hero_title); ?></h1>
        <?php if ($hero_subtitle) : ?>
            <p class="text-blue-100 mt-4 max-w-2xl mx-auto"><?php echo esc_html($hero_subtitle); ?></p>
        <?php endif; ?>
    </div>
</section>

<!-- Content -->
<?php if ($page_content) : ?>
<section class="py-12 bg-white">
    <div class="erdu-container">
        <div class="prose prose-lg max-w-none"><?php echo wp_kses_post($page_content); ?></div>
    </div>
</section>
<?php endif; ?>

<!-- Products -->
<section class="py-16 bg-gray-50">
    <div class="erdu-container">
        <?php 
        if (class_exists('WooCommerce') && $category_id) {
            $term = get_term($category_id, 'product_cat');
            if ($term && !is_wp_error($term)) {
                echo do_shortcode('[products category="' . esc_attr($term->slug) . '" limit="12" columns="4"]');
            } else {
                echo '<p class="text-center text-gray-500">' . esc_html__('Selected category not found.', 'erdu-wp') . '</p>';
            }
        } elseif (class_exists('WooCommerce')) {
            echo do_shortcode('[products limit="12" columns="4"]');
        } else {
            echo '<p class="text-center text-gray-500">' . esc_html__('WooCommerce is required to display products.', 'erdu-wp') . '</p>';
        }
        ?>
    </div>
</section>

<?php get_footer(); ?>
