<?php
/**
 * Single Product Section: FAQ
 *
 * @package ERDU_Lighting/WooCommerce
 */

defined('ABSPATH') || exit;

if (!function_exists('have_rows') || !have_rows('product_faq')) {
    return;
}
?>
<div id="section-faq" class="erdu-content-block scroll-mt-32">
    <h2 class="text-2xl font-bold text-gray-900 mb-8 pb-4 border-b border-gray-100"><?php esc_html_e('FAQ', 'erdu-wp'); ?></h2>
    <div class="space-y-5">
        <?php while (have_rows('product_faq')) : the_row();
            $question = get_sub_field('faq_question');
            $answer   = get_sub_field('faq_answer');
        ?>
        <div class="erdu-faq-item border border-gray-200 rounded-lg overflow-hidden">
            <button type="button" class="erdu-faq-question w-full flex items-center justify-between px-6 py-4 text-left bg-white hover:bg-gray-50 transition-colors">
                <span class="text-base font-semibold text-gray-900 pr-4"><?php echo esc_html($question); ?></span>
                <svg class="erdu-faq-icon w-5 h-5 text-gray-500 flex-shrink-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div class="erdu-faq-answer hidden px-6 pb-5 text-gray-600 text-base leading-relaxed">
                <?php echo wpautop(esc_html($answer)); ?>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>
