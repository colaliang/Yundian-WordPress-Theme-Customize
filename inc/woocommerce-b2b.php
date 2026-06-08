<?php
/**
 * WooCommerce B2B Enhancements
 * 
 * Modifies default WooCommerce behavior to fit a B2B catalog model:
 * - Removes prices, cart, and checkout flows
 * - Replaces Add to Cart with an Inquire Now button
 * - Cleans up unnecessary ecommerce tabs (e.g., reviews)
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) exit;

/**
 * Declare WooCommerce Support
 */
add_action('after_setup_theme', 'erdu_woocommerce_support');
function erdu_woocommerce_support() {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}

/**
 * Remove Ecommerce Elements (Prices, Cart, Reviews)
 */
function erdu_remove_wc_ecommerce_elements() {
    // Single Product
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
    
    // Archive / Loop
    remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
    remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
}
add_action('init', 'erdu_remove_wc_ecommerce_elements');

/**
 * Add B2B Inquiry Button on Single Product Page
 */
add_action('woocommerce_single_product_summary', 'erdu_add_b2b_inquiry_button', 30);
function erdu_add_b2b_inquiry_button() {
    global $product;
    // Append product name as query param for context
    $inquiry_link = erdu_get_page_url('contact');
    
    // Add product context to URL
    $url = add_query_arg('product', urlencode($product->get_name()), $inquiry_link);
    
    echo '<div class="erdu-b2b-inquiry mt-8">';
    echo '<a href="' . esc_url($url) . '" class="inline-block px-8 py-4 bg-orange-600 text-white font-bold rounded-md hover:bg-orange-700 transition-colors shadow-lg hover:shadow-xl">';
    echo esc_html__('Inquire Now', 'erdu-wp');
    echo '</a>';
    echo '</div>';
}

/**
 * Remove Reviews Tab and Customize Existing Tabs
 */
add_filter('woocommerce_product_tabs', 'erdu_customize_product_tabs', 98);
function erdu_customize_product_tabs($tabs) {
    // Remove Reviews
    if (isset($tabs['reviews'])) {
        unset($tabs['reviews']);
    }
    
    // Rename Description to Overview/Features
    if (isset($tabs['description'])) {
        $tabs['description']['title'] = __('Overview & Features', 'erdu-wp');
    }
    
    // Rename Additional Information to Specifications
    if (isset($tabs['additional_information'])) {
        $tabs['additional_information']['title'] = __('Specifications', 'erdu-wp');
    }
    
    return $tabs;
}

/**
 * Disable all WooCommerce checkout and cart pages redirects
 */
add_action('template_redirect', 'erdu_disable_wc_pages');
function erdu_disable_wc_pages() {
    if (is_cart() || is_checkout() || is_account_page()) {
        wp_redirect(home_url());
        exit;
    }
}
