<?php
/**
 * Header Contact Info Component
 * Displays phone, email, address based on settings
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) {
    exit;
}

class Erdu_Header_Contact {
    public static function render() {
        $show_phone    = erdu_header_field('hd_show_phone', false);
        $show_email    = erdu_header_field('hd_show_email', false);
        $show_address  = erdu_header_field('hd_show_address', false);
        $show_hours    = erdu_header_field('hd_show_hours', false);

        if (!$show_phone && !$show_email && !$show_address && !$show_hours) {
            return;
        }

        $phone   = erdu_header_field('hd_phone', '+86-760-22380830');
        $email   = erdu_header_field('hd_email', 'gg@erduled.com');
        $address = erdu_header_field('hd_address', '');
        $hours   = erdu_header_field('hd_hours', '');
        ?>
        <div class="hidden lg:flex items-center gap-4 text-sm">
            <?php if ($show_phone && $phone) : ?>
                <a href="tel:<?php echo esc_attr(preg_replace('/[^\d+]/', '', $phone)); ?>" class="flex items-center gap-1.5 text-gray-600 hover:text-orange-500 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span><?php echo esc_html($phone); ?></span>
                </a>
            <?php endif; ?>

            <?php if ($show_email && $email) : ?>
                <a href="mailto:<?php echo esc_attr($email); ?>" class="flex items-center gap-1.5 text-gray-600 hover:text-orange-500 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span><?php echo esc_html($email); ?></span>
                </a>
            <?php endif; ?

            <?php if ($show_address && $address) : ?>
                <div class="flex items-center gap-1.5 text-gray-500">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="max-w-[200px] truncate"><?php echo esc_html($address); ?></span>
                </div>
            <?php endif; ?

            <?php if ($show_hours && $hours) : ?>
                <div class="flex items-center gap-1.5 text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span><?php echo esc_html($hours); ?></span>
                </div>
            <?php endif; ?
        </div>
        <?php
    }
}
