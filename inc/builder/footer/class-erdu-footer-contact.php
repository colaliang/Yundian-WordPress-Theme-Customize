<?php
/**
 * Footer Contact Component
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) {
    exit;
}

class Erdu_Footer_Contact {
    public static function render($settings) {
        if (!$settings['contact_show'] || (!$settings['contact_addr'] && !$settings['contact_phone'] && !$settings['contact_mobile'] && !$settings['contact_email'] && !$settings['contact_hours'])) {
            return;
        }
        ?>
        <div>
            <h4 class="font-semibold mb-4" style="color: <?php echo esc_attr($settings['heading_color']); ?>;"><?php echo esc_html($settings['contact_title']); ?></h4>
            <ul class="space-y-3 text-sm">
                <?php if ($settings['contact_addr']) : ?>
                <li class="flex items-start gap-2">
                    <svg class="w-4 h-4 mt-0.5 shrink-0" style="color: <?php echo esc_attr($settings['hover_color']); ?>;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span><?php echo nl2br(esc_html($settings['contact_addr'])); ?></span>
                </li>
                <?php endif; ?>
                
                <?php if ($settings['contact_phone']) : ?>
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0" style="color: <?php echo esc_attr($settings['hover_color']); ?>;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span><?php echo esc_html($settings['contact_phone']); ?></span>
                </li>
                <?php endif; ?>
                
                <?php if ($settings['contact_mobile']) : ?>
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0" style="color: <?php echo esc_attr($settings['hover_color']); ?>;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    <span><?php echo esc_html($settings['contact_mobile']); ?></span>
                </li>
                <?php endif; ?>
                
                <?php if ($settings['contact_email']) : ?>
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0" style="color: <?php echo esc_attr($settings['hover_color']); ?>;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span><?php echo esc_html($settings['contact_email']); ?></span>
                </li>
                <?php endif; ?>
                
                <?php if ($settings['contact_hours']) : ?>
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0" style="color: <?php echo esc_attr($settings['hover_color']); ?>;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span><?php echo esc_html($settings['contact_hours']); ?></span>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <?php
    }
}