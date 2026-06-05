</main><!-- #primary -->

<?php
// ==========================================
// Fully Configurable Footer — ACF Options Page
// ==========================================

$theme_settings = get_option('erdu_settings', erdu_default_settings());

// ---- Appearance ----
$ft_bg       = erdu_footer_field('ft_bg_color', '#1a1a2e');
$ft_text     = erdu_footer_field('ft_text_color', '#9ca3af');
$ft_heading  = erdu_footer_field('ft_heading_color', '#ffffff');
$ft_hover    = erdu_footer_field('ft_link_hover_color', '#F37021');
$ft_border   = erdu_footer_field('ft_border_color', '#374151');

// ---- Logo & About ----
$ft_logo_type   = erdu_footer_field('ft_logo_type', 'text');
$ft_logo_image  = erdu_footer_field('ft_logo_image', '');
$ft_logo_text   = erdu_footer_field('ft_logo_text', 'ERDU LIGHTING');
$ft_logo_icon   = erdu_footer_field('ft_logo_icon', true);
$ft_logo_icon_t = erdu_footer_field('ft_logo_icon_text', 'E');
$ft_about       = erdu_footer_field('ft_about', 'Professional 48V Magnetic Track Light Manufacturer since 2009. 6300m² factory, 100+ employees, exporting to 20+ countries.');

// ---- Social Links ----
$ft_social_show  = erdu_footer_field('ft_social_show', true);
$ft_social_links = erdu_footer_field('ft_social_links', array());

// ---- Quick Links ----
$ft_quick_show   = erdu_footer_field('ft_quicklinks_show', true);
$ft_quick_title  = erdu_footer_field('ft_quicklinks_title', __('Quick Links', 'erdu-wp'));
$ft_quick_links  = erdu_footer_field('ft_quicklinks', array());

// ---- Contact Info ----
$ft_contact_show = erdu_footer_field('ft_contact_show', true);
$ft_contact_title = erdu_footer_field('ft_contact_title', __('Contact Info', 'erdu-wp'));
$ft_contact_addr = erdu_footer_field('ft_contact_address', '');
$ft_contact_phone = erdu_footer_field('ft_contact_phone', '');
$ft_contact_mobile = erdu_footer_field('ft_contact_mobile', '');
$ft_contact_email = erdu_footer_field('ft_contact_email', '');
$ft_contact_hours = erdu_footer_field('ft_contact_hours', '');

// ---- Newsletter ----
$ft_news_show   = erdu_footer_field('ft_newsletter_show', true);
$ft_news_title  = erdu_footer_field('ft_newsletter_title', __('Newsletter', 'erdu-wp'));
$ft_news_desc   = erdu_footer_field('ft_newsletter_desc', __('Stay updated with latest products & lighting trends.', 'erdu-wp'));
$ft_news_ph     = erdu_footer_field('ft_newsletter_placeholder', __('Your email', 'erdu-wp'));
$ft_news_btn    = erdu_footer_field('ft_newsletter_button', __('Subscribe', 'erdu-wp'));
$ft_news_footer = erdu_footer_field('ft_newsletter_footer', __('Join 500+ lighting professionals who trust our updates.', 'erdu-wp'));

// ---- Copyright ----
$ft_copy_text   = erdu_footer_field('ft_copyright_text', '© {year} ERDU Lighting Technology Co., Ltd. All Rights Reserved.');
$ft_copy_text   = str_replace('{year}', date('Y'), $ft_copy_text);
$ft_copy_links  = erdu_footer_field('ft_copyright_links', array());

// Social icon SVGs
$social_svgs = array(
    'facebook'  => '<path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>',
    'linkedin'  => '<path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2zM4 6a2 2 0 100-4 2 2 0 000 4z"/>',
    'youtube'   => '<path d="M22.54 6.42a2.78 2.78 0 00-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 00-1.94 2A29 29 0 001 11.75a29 29 0 00.46 5.33A2.78 2.78 0 003.4 19.13C5.12 19.56 12 19.56 12 19.56s6.88 0 8.6-.46a2.78 2.78 0 001.94-2 29 29 0 00.46-5.25 29 29 0 00-.46-5.43zM9.75 15.02V8.48l5.75 3.27-5.75 3.27z"/>',
    'instagram' => '<path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>',
    'twitter'   => '<path d="M23 3a10.9 10.9 0 01-3.14 1.53A4.48 4.48 0 0012 8v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/>',
    'whatsapp'  => '<path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>',
    'wechat'    => '<path d="M8.691 2.188C3.891 2.188 0 5.476 0 9.53c0 2.212 1.17 4.203 3.002 5.55a.59.59 0 01.213.665l-.39 1.48c-.019.07-.048.141-.048.213 0 .163.13.295.29.295a.326.326 0 00.167-.054l1.903-1.114a.864.864 0 01.717-.098 10.16 10.16 0 002.837.403c.276 0 .543-.027.811-.05-.857-2.578.157-4.972 1.932-6.446 1.703-1.415 3.882-1.98 5.853-1.838-.576-3.583-4.196-6.348-8.596-6.348zM5.785 5.991c.642 0 1.162.529 1.162 1.18a1.17 1.17 0 01-1.162 1.178A1.17 1.17 0 014.623 7.17c0-.651.52-1.18 1.162-1.18zm5.813 0c.642 0 1.162.529 1.162 1.18a1.17 1.17 0 01-1.162 1.178 1.17 1.17 0 01-1.162-1.178c0-.651.52-1.18 1.162-1.18zm5.34 2.867c-1.797-.052-3.746.512-5.28 1.786-1.72 1.428-2.687 3.72-1.78 6.22.942 2.453 3.666 4.229 6.884 4.229.826 0 1.622-.12 2.361-.336a.722.722 0 01.598.082l1.584.926a.272.272 0 00.14.047c.134 0 .24-.111.24-.247 0-.06-.023-.12-.038-.177l-.327-1.233a.582.582 0 01-.023-.156.49.49 0 01.201-.398C23.024 18.48 24 16.82 24 14.98c0-3.21-2.931-5.837-6.656-6.088-.139-.009-.278-.021-.418-.033h-.088zm-2.06 3.13c.535 0 .969.44.969.982a.976.976 0 01-.969.983.976.976 0 01-.969-.983c0-.542.434-.982.97-.982zm4.844 0c.535 0 .969.44.969.982a.976.976 0 01-.969.983.976.976 0 01-.969-.983c0-.542.434-.982.969-.982z"/>',
    'tiktok'    => '<path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.88-2.88 2.89 2.89 0 012.88-2.88c.28 0 .54.04.79.1v-3.5a6.37 6.37 0 00-.79-.05A6.34 6.34 0 003.15 15.2a6.34 6.34 0 006.35 6.35 6.34 6.34 0 006.35-6.35V8.75a8.27 8.27 0 004.74 1.5V6.69z"/>',
    'pinterest' => '<path d="M12 0C5.373 0 0 5.372 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738a.36.36 0 01.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z"/>',
    'custom'    => '<path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6M15 3h6v6M10 14L21 3"/>',
);

// Determine grid columns
$col_count = 0;
if ($ft_about || $ft_social_show) $col_count++;
if ($ft_quick_show && $ft_quick_links) $col_count++;
if ($ft_contact_show && ($ft_contact_addr || $ft_contact_phone || $ft_contact_email)) $col_count++;
if ($ft_news_show) $col_count++;
$grid_class = 'grid-cols-1';
if ($col_count >= 2) $grid_class .= ' md:grid-cols-2';
if ($col_count >= 3) $grid_class .= ' lg:grid-cols-' . min($col_count, 4);
?>

<!-- Footer -->
<footer class="erdu-footer" style="background-color: <?php echo esc_attr($ft_bg); ?>;">
    <div class="erdu-container py-12">
        <div class="grid <?php echo esc_attr($grid_class); ?> gap-8" style="color: <?php echo esc_attr($ft_text); ?>;">

            <!-- Column 1: Logo & About -->
            <?php if ($ft_about || $ft_social_show) : ?>
            <div>
                <!-- Logo -->
                <div class="flex items-center gap-2 mb-4">
                    <?php if ($ft_logo_type === 'image' && $ft_logo_image) : ?>
                        <img src="<?php echo esc_url($ft_logo_image); ?>" alt="<?php echo esc_attr($ft_logo_text); ?>" class="h-8">
                    <?php else : ?>
                        <?php if ($ft_logo_icon) : ?>
                        <div class="w-8 h-8 rounded flex items-center justify-center shrink-0" style="background-color: <?php echo esc_attr($theme_settings['primary_color'] ?? '#F37021'); ?>;">
                            <span class="text-white font-bold text-sm"><?php echo esc_html($ft_logo_icon_t); ?></span>
                        </div>
                        <?php endif; ?>
                        <span class="text-xl font-bold" style="color: <?php echo esc_attr($ft_heading); ?>;"><?php echo esc_html($ft_logo_text); ?></span>
                    <?php endif; ?>
                </div>

                <!-- About -->
                <?php if ($ft_about) : ?>
                <p class="text-sm mb-4" style="color: <?php echo esc_attr($ft_text); ?>;"><?php echo esc_html($ft_about); ?></p>
                <?php endif; ?>

                <!-- Social Links -->
                <?php if ($ft_social_show && $ft_social_links) : ?>
                <div class="flex gap-3">
                    <?php foreach ($ft_social_links as $sl) :
                        $platform = $sl['platform'] ?? 'custom';
                        $url = $sl['url'] ?? '#';
                        $label = $sl['label'] ?? ucfirst($platform);
                        $svg = $social_svgs[$platform] ?? $social_svgs['custom'];
                    ?>
                    <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener"
                       class="w-8 h-8 rounded-full flex items-center justify-center transition-colors"
                       style="background-color: rgba(255,255,255,0.1); color: <?php echo esc_attr($ft_text); ?>;"
                       onmouseover="this.style.backgroundColor='<?php echo esc_attr($theme_settings['primary_color'] ?? '#F37021'); ?>'; this.style.color='#fff';"
                       onmouseout="this.style.backgroundColor='rgba(255,255,255,0.1)'; this.style.color='<?php echo esc_attr($ft_text); ?>';"
                       aria-label="<?php echo esc_attr($label); ?>">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><?php echo wp_kses_post($svg); ?></svg>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- Column 2: Quick Links -->
            <?php if ($ft_quick_show && $ft_quick_links) : ?>
            <div>
                <h4 class="font-semibold mb-4" style="color: <?php echo esc_attr($ft_heading); ?>;"><?php echo esc_html($ft_quick_title); ?></h4>
                <ul class="space-y-2 text-sm">
                    <?php foreach ($ft_quick_links as $ql) :
                        $ql_label = $ql['label'] ?? '';
                        $ql_url = $ql['url'] ?? '#';
                    ?>
                    <li><a href="<?php echo esc_url($ql_url); ?>" class="transition-colors hover:underline" style="color: <?php echo esc_attr($ft_text); ?>;" onmouseover="this.style.color='<?php echo esc_attr($ft_hover); ?>'" onmouseout="this.style.color='<?php echo esc_attr($ft_text); ?>'"><?php echo esc_html($ql_label); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <!-- Column 3: Contact Info -->
            <?php if ($ft_contact_show && ($ft_contact_addr || $ft_contact_phone || $ft_contact_mobile || $ft_contact_email || $ft_contact_hours)) : ?>
            <div>
                <h4 class="font-semibold mb-4" style="color: <?php echo esc_attr($ft_heading); ?>;"><?php echo esc_html($ft_contact_title); ?></h4>
                <ul class="space-y-3 text-sm">
                    <?php if ($ft_contact_addr) : ?>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 mt-0.5 shrink-0" style="color: <?php echo esc_attr($ft_hover); ?>;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span><?php echo nl2br(esc_html($ft_contact_addr)); ?></span>
                    </li>
                    <?php endif; ?>
                    <?php if ($ft_contact_phone) : ?>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 shrink-0" style="color: <?php echo esc_attr($ft_hover); ?>;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span><?php echo esc_html($ft_contact_phone); ?></span>
                    </li>
                    <?php endif; ?>
                    <?php if ($ft_contact_mobile) : ?>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 shrink-0" style="color: <?php echo esc_attr($ft_hover); ?>;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        <span><?php echo esc_html($ft_contact_mobile); ?></span>
                    </li>
                    <?php endif; ?>
                    <?php if ($ft_contact_email) : ?>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 shrink-0" style="color: <?php echo esc_attr($ft_hover); ?>;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span><?php echo esc_html($ft_contact_email); ?></span>
                    </li>
                    <?php endif; ?>
                    <?php if ($ft_contact_hours) : ?>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 shrink-0" style="color: <?php echo esc_attr($ft_hover); ?>;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span><?php echo esc_html($ft_contact_hours); ?></span>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
            <?php endif; ?>

            <!-- Column 4: Newsletter -->
            <?php if ($ft_news_show) : ?>
            <div>
                <h4 class="font-semibold mb-4" style="color: <?php echo esc_attr($ft_heading); ?>;"><?php echo esc_html($ft_news_title); ?></h4>
                <p class="text-sm mb-3" style="color: <?php echo esc_attr($ft_text); ?>;"><?php echo esc_html($ft_news_desc); ?></p>
                <form class="flex gap-2" action="#" method="post">
                    <input type="email" name="email" placeholder="<?php echo esc_attr($ft_news_ph); ?>"
                           class="flex-1 px-3 py-2 rounded-md text-sm border focus:outline-none"
                           style="background-color: rgba(255,255,255,0.05); color: <?php echo esc_attr($ft_heading); ?>; border-color: <?php echo esc_attr($ft_border); ?>;"
                           onfocus="this.style.borderColor='<?php echo esc_attr($ft_hover); ?>'">
                    <button type="submit" class="px-4 py-2 font-medium text-sm rounded-md hover:opacity-90 transition-opacity" style="background-color: <?php echo esc_attr($theme_settings['primary_color'] ?? '#F37021'); ?>; color: #fff;">
                        <?php echo esc_html($ft_news_btn); ?>
                    </button>
                </form>
                <?php if ($ft_news_footer) : ?>
                <p class="text-xs mt-2" style="color: <?php echo esc_attr($ft_text); ?>; opacity: 0.7;"><?php echo esc_html($ft_news_footer); ?></p>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Copyright -->
        <div class="mt-10 pt-6 flex flex-col md:flex-row justify-between items-center gap-4 text-xs" style="border-top: 1px solid <?php echo esc_attr($ft_border); ?>; color: <?php echo esc_attr($ft_text); ?>; opacity: 0.7;">
            <p><?php echo esc_html($ft_copy_text); ?></p>
            <?php if ($ft_copy_links) : ?>
            <div class="flex gap-4">
                <?php foreach ($ft_copy_links as $cl) :
                    $cl_label = $cl['label'] ?? '';
                    $cl_url = $cl['url'] ?? '#';
                ?>
                <a href="<?php echo esc_url($cl_url); ?>" class="transition-colors hover:underline" style="color: <?php echo esc_attr($ft_text); ?>;" onmouseover="this.style.color='<?php echo esc_attr($ft_hover); ?>'" onmouseout="this.style.color='<?php echo esc_attr($ft_text); ?>'"><?php echo esc_html($cl_label); ?></a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
