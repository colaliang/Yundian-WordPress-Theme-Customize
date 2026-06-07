<?php
/**
 * ACF Block Render Callbacks
 * Front-end HTML output for each custom block.
 *
 * DATA SAFETY NOTE:
 * ACF Block field values are stored as serialized data inside each block
 * instance in post_content. They persist independently of theme files.
 * Theme updates/reinstalls do NOT affect saved block content.
 * Only changing a field's 'key' or 'name' in acf-blocks.php would break
 * existing data — NEVER do that.
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) exit;

/**
 * Safe wrapper to get an ACF field value with fallback.
 * Returns $default if ACF is not active or field has no value.
 *
 * @param string $field_name ACF field name.
 * @param mixed  $default    Fallback value.
 * @return mixed
 */
function erdu_block_field($field_name, $default = '')
{
    if (!function_exists('get_field')) {
        return $default;
    }
    $value = get_field($field_name);
    return ($value !== null && $value !== '' && !(is_array($value) && empty($value))) ? $value : $default;
}

// ==========================================
// 1. Hero Block
// ==========================================

function erdu_block_render_hero($block, $is_preview = false)
{
    $title    = erdu_block_field('title') ?: get_the_title();
    $subtitle = erdu_block_field('subtitle');
    $bg       = erdu_block_field('background_image');
    $overlay  = erdu_block_field('overlay_style') ?: 'orange';

    $gradients = array(
        'dark'   => 'linear-gradient(135deg, #0F172A 0%, #1E293B 100%)',
        'blue'   => 'linear-gradient(135deg, #1A1A2E 0%, #16213E 100%)',
        'orange' => 'linear-gradient(135deg, #2D1810 0%, #4A2510 100%)',
    );
    $text_colors = array('dark' => 'text-blue-100', 'blue' => 'text-blue-100', 'orange' => 'text-orange-100');
    $gradient = isset($gradients[$overlay]) ? $gradients[$overlay] : $gradients['orange'];
    $text_col = isset($text_colors[$overlay]) ? $text_colors[$overlay] : 'text-orange-100';
    ?>
    <section class="relative py-20" style="background: <?php echo esc_attr($gradient); ?>;">
        <?php if ($bg) : ?>
            <div class="absolute inset-0 opacity-20" style="background-image: url('<?php echo esc_url($bg); ?>'); background-size: cover; background-position: center;"></div>
        <?php endif; ?>
        <div class="relative erdu-container text-center">
            <?php if (function_exists('erdu_breadcrumb')) erdu_breadcrumb(); ?>
            <h1 class="text-3xl md:text-4xl font-bold text-white"><?php echo esc_html($title); ?></h1>
            <?php if ($subtitle) : ?><p class="<?php echo esc_attr($text_col); ?> mt-4 max-w-2xl mx-auto"><?php echo esc_html($subtitle); ?></p><?php endif; ?>
        </div>
    </section>
    <?php
}

// ==========================================
// 2. Content Block
// ==========================================

function erdu_block_render_content($block, $is_preview = false)
{
    $content = erdu_block_field('content');
    $bg      = erdu_block_field('bg_color') ?: 'white';
    $bg_class = $bg === 'gray' ? ' style="background-color: #F9FAFB;"' : ($bg === 'white' ? ' class="bg-white"' : '');
    if (!$content) return;
    ?>
    <section<?php echo $bg === 'gray' ? $bg_class : ' class="py-12 bg-white"'; ?>>
        <div class="erdu-container">
            <div class="prose prose-lg max-w-none"><?php echo wp_kses_post($content); ?></div>
        </div>
    </section>
    <?php
}

// ==========================================
// 3. Timeline Block
// ==========================================

function erdu_block_render_timeline($block, $is_preview = false)
{
    $title  = erdu_block_field('title') ?: __('Our Journey', 'erdu-wp');
    $events = erdu_block_field('events');
    if (!$events) return;
    ?>
    <section class="py-16" style="background-color: #F9FAFB;">
        <div class="erdu-container">
            <h2 class="erdu-h2 mb-8 text-center"><?php echo esc_html($title); ?></h2>
            <div class="relative max-w-3xl mx-auto">
                <div class="absolute left-1/2 top-0 bottom-0 w-0.5 -translate-x-1/2 hidden md:block" style="background-color: #FED7AA;"></div>
                <div class="space-y-8">
                    <?php foreach ($events as $i => $item) : ?>
                        <div class="flex flex-col md:flex-row items-center gap-6 <?php echo $i % 2 === 0 ? '' : 'md:flex-row-reverse'; ?>">
                            <div class="flex-1 text-right hidden md-block">
                                <?php if ($i % 2 === 0) : ?>
                                    <h4 class="text-xl font-bold" style="color: #333;"><?php echo esc_html($item['title']); ?></h4>
                                    <p class="text-sm text-gray-500 mt-1"><?php echo esc_html($item['description']); ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="w-16 h-16 rounded-full flex items-center justify-center text-white font-bold z-10 shadow-lg shrink-0" style="background-color: #F37021;"><?php echo esc_html(substr($item['year'], 2)); ?></div>
                            <div class="flex-1 text-center md:text-left">
                                <span class="text-sm font-bold md:hidden" style="color: #F37021;"><?php echo esc_html($item['year']); ?></span>
                                <h4 class="text-lg font-bold md:hidden" style="color: #333;"><?php echo esc_html($item['title']); ?></h4>
                                <p class="text-sm text-gray-500 mt-1 md:hidden"><?php echo esc_html($item['description']); ?></p>
                                <?php if ($i % 2 !== 0) : ?>
                                    <h4 class="text-xl font-bold hidden md:block" style="color: #333;"><?php echo esc_html($item['title']); ?></h4>
                                    <p class="text-sm text-gray-500 mt-1 hidden md:block"><?php echo esc_html($item['description']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <?php
}

// ==========================================
// 4. Team Block
// ==========================================

function erdu_block_render_team($block, $is_preview = false)
{
    $title   = erdu_block_field('title') ?: __('Leadership Team', 'erdu-wp');
    $members = erdu_block_field('members');
    if (!$members) return;
    ?>
    <section class="py-16" style="background-color: #F9FAFB;">
        <div class="erdu-container">
            <h3 class="erdu-h3 mb-6 text-center"><?php echo esc_html($title); ?></h3>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach ($members as $m) : ?>
                    <div class="text-center p-6 rounded-xl" style="background-color: #F9FAFB;">
                        <?php if (!empty($m['photo'])) : ?>
                            <img src="<?php echo esc_url($m['photo']); ?>" alt="<?php echo esc_attr($m['name']); ?>" class="w-20 h-20 rounded-full mx-auto mb-3 object-cover">
                        <?php else : ?>
                            <div class="w-20 h-20 rounded-full mx-auto mb-3 flex items-center justify-center text-white text-2xl font-bold" style="background-color: #F37021;"><?php echo esc_html($m['name'][0]); ?></div>
                        <?php endif; ?>
                        <h4 class="font-semibold" style="color: #333;"><?php echo esc_html($m['name']); ?></h4>
                        <?php if (!empty($m['role'])) : ?><p style="color: #F37021;" class="text-sm"><?php echo esc_html($m['role']); ?></p><?php endif; ?>
                        <?php if (!empty($m['bio'])) : ?><p class="text-xs text-gray-500 mt-1"><?php echo esc_html($m['bio']); ?></p><?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
}

// ==========================================
// 5. Values Block
// ==========================================

function erdu_block_render_values($block, $is_preview = false)
{
    $mission = erdu_block_field('mission');
    $values  = erdu_block_field('values');
    ?>
    <section class="py-16" style="background-color: #F9FAFB;">
        <div class="erdu-container">
            <?php if ($mission) : ?>
                <div class="text-center py-16 rounded-2xl mb-12" style="background: linear-gradient(135deg, #F37021 0%, #D45A0F 100%);">
                    <h3 class="text-3xl font-bold text-white mb-4"><?php _e('Our Mission', 'erdu-wp'); ?></h3>
                    <p class="text-xl text-orange-100 max-w-2xl mx-auto px-4"><?php echo esc_html($mission); ?></p>
                </div>
            <?php endif; ?>
            <?php if ($values) : ?>
                <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-6">
                    <?php foreach ($values as $v) : ?>
                        <div class="bg-white border border-gray-200 rounded-xl p-6 text-center hover:shadow-lg transition-shadow">
                            <h4 class="font-semibold" style="color: #333;"><?php echo esc_html($v['title']); ?></h4>
                            <p class="text-sm text-gray-500 mt-2"><?php echo esc_html($v['description']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php
}

// ==========================================
// 6. Stats Block
// ==========================================

function erdu_block_render_stats($block, $is_preview = false)
{
    $stats = erdu_block_field('stats');
    if (!$stats) return;
    ?>
    <section class="py-16 bg-white">
        <div class="erdu-container">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                <?php foreach ($stats as $s) : ?>
                    <div class="p-4 rounded-lg" style="background-color: #F9FAFB;">
                        <div class="text-2xl font-bold" style="color: #F37021;"><?php echo esc_html($s['value']); ?></div>
                        <div class="text-sm text-gray-500"><?php echo esc_html($s['label']); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
}

// ==========================================
// 7. CTA Block
// ==========================================

function erdu_block_render_cta($block, $is_preview = false)
{
    $title         = erdu_block_field('title');
    $button_text   = erdu_block_field('button_text') ?: __('Contact Us', 'erdu-wp');
    $button_link   = erdu_block_field('button_link');
    $secondary     = erdu_block_field('secondary_text');
    $secondary_link = erdu_block_field('secondary_link');
    if (!$title) return;
    ?>
    <section class="py-16" style="background: linear-gradient(135deg, #F37021 0%, #D45A0F 100%);">
        <div class="erdu-container text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-8"><?php echo esc_html($title); ?></h2>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <?php if ($button_link) : ?>
                    <a href="<?php echo esc_url($button_link); ?>" class="inline-flex items-center justify-center px-8 py-3 bg-white font-semibold rounded-lg transition-all hover:shadow-lg" style="color: #F37021;"><?php echo esc_html($button_text); ?></a>
                <?php endif; ?>
                <?php if ($secondary && $secondary_link) : ?>
                    <a href="<?php echo esc_url($secondary_link); ?>" class="inline-flex items-center justify-center px-8 py-3 border-2 border-white text-white font-semibold rounded-lg transition-all hover:bg-white hover:bg-opacity-10"><?php echo esc_html($secondary); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php
}

// ==========================================
// 8. Partners Block
// ==========================================

function erdu_block_render_partners($block, $is_preview = false)
{
    $title    = erdu_block_field('title') ?: __('Supply Chain Partners', 'erdu-wp');
    $partners = erdu_block_field('partners');
    if (!$partners) return;
    ?>
    <section class="py-16 bg-white">
        <div class="erdu-container">
            <h3 class="erdu-h3 mb-6 text-center"><?php echo esc_html($title); ?></h3>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <?php foreach ($partners as $p) : ?>
                    <div class="bg-white border border-gray-200 rounded-xl p-4 text-center hover:shadow-md transition-shadow">
                        <?php if (!empty($p['logo'])) : ?>
                            <img src="<?php echo esc_url($p['logo']); ?>" alt="<?php echo esc_attr($p['name']); ?>" class="h-8 mx-auto mb-2 object-contain">
                        <?php else : ?>
                            <div class="text-xl font-bold text-gray-400 mb-1"><?php echo esc_html($p['name']); ?></div>
                        <?php endif; ?>
                        <?php if (!empty($p['category'])) : ?><div class="text-xs" style="color: #F37021;"><?php echo esc_html($p['category']); ?></div><?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
}

// ==========================================
// 9. Case Studies Block
// ==========================================

function erdu_block_render_cases($block, $is_preview = false)
{
    $title = erdu_block_field('title') ?: __('Case Studies', 'erdu-wp');
    $cases = erdu_block_field('cases');
    if (!$cases) return;
    ?>
    <section class="py-16" style="background-color: #F9FAFB;">
        <div class="erdu-container">
            <h2 class="erdu-h2 mb-8 text-center"><?php echo esc_html($title); ?></h2>
            <div class="grid md:grid-cols-3 gap-6">
                <?php foreach ($cases as $c) : ?>
                    <div class="bg-white rounded-xl overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow">
                        <?php if (!empty($c['image'])) : ?>
                            <div class="h-48 overflow-hidden"><img src="<?php echo esc_url($c['image']); ?>" alt="<?php echo esc_attr($c['title']); ?>" class="w-full h-full object-cover hover:scale-105 transition-transform"></div>
                        <?php endif; ?>
                        <div class="p-5">
                            <?php if (!empty($c['industry'])) : ?><span class="text-xs px-2 py-1 rounded-full" style="background-color: #FFF5ED; color: #F37021;"><?php echo esc_html($c['industry']); ?></span><?php endif; ?>
                            <h3 class="font-semibold mt-2 mb-1" style="color: #333;"><?php echo esc_html($c['title']); ?></h3>
                            <?php if (!empty($c['description'])) : ?><p class="text-sm text-gray-500"><?php echo esc_html($c['description']); ?></p><?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
}

// ==========================================
// 10. FAQ Block
// ==========================================

function erdu_block_render_faq($block, $is_preview = false)
{
    $title = erdu_block_field('title') ?: __('Frequently Asked Questions', 'erdu-wp');
    $items = erdu_block_field('faq_items');
    if (!$items) return;
    ?>
    <section class="py-16 bg-white">
        <div class="erdu-container max-w-3xl">
            <h2 class="erdu-h2 mb-8 text-center"><?php echo esc_html($title); ?></h2>
            <div class="space-y-3" id="faq-accordion">
                <?php foreach ($items as $i => $faq) : ?>
                    <div class="border border-gray-200 rounded-lg bg-white">
                        <button type="button" class="w-full px-4 py-3 flex justify-between items-center text-left hover:bg-gray-50 transition-colors faq-toggle" data-index="<?php echo intval($i); ?>">
                            <span class="font-medium text-[#333] text-sm"><?php echo esc_html($faq['question']); ?></span>
                            <span class="faq-icon text-gray-400 transition-transform ml-4 shrink-0" style="line-height: 1;">+</span>
                        </button>
                        <div class="faq-content hidden px-4 pb-4">
                            <p class="text-sm text-gray-600"><?php echo nl2br(esc_html($faq['answer'])); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
}

// ==========================================
// 11. Contact Info Block
// ==========================================

function erdu_block_render_contact_info($block, $is_preview = false)
{
    $address = erdu_block_field('address');
    $phone   = erdu_block_field('phone');
    $email   = erdu_block_field('email');
    $hours   = erdu_block_field('hours');
    ?>
    <section class="py-16" style="background-color: #F9FAFB;">
        <div class="erdu-container">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <?php if ($address) : ?>
                    <div class="flex items-start gap-3"><svg class="w-5 h-5 mt-1 shrink-0" style="color: #F37021;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg><div><h4 class="font-medium text-sm" style="color: #333;"><?php _e('Address', 'erdu-wp'); ?></h4><p class="text-sm text-gray-500"><?php echo esc_html($address); ?></p></div></div>
                <?php endif; ?>
                <?php if ($phone) : ?>
                    <div class="flex items-start gap-3"><svg class="w-5 h-5 mt-1 shrink-0" style="color: #F37021;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg><div><h4 class="font-medium text-sm" style="color: #333;"><?php _e('Phone', 'erdu-wp'); ?></h4><p class="text-sm text-gray-500"><?php echo esc_html($phone); ?></p></div></div>
                <?php endif; ?>
                <?php if ($email) : ?>
                    <div class="flex items-start gap-3"><svg class="w-5 h-5 mt-1 shrink-0" style="color: #F37021;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg><div><h4 class="font-medium text-sm" style="color: #333;"><?php _e('Email', 'erdu-wp'); ?></h4><p class="text-sm text-gray-500"><?php echo esc_html($email); ?></p></div></div>
                <?php endif; ?>
                <?php if ($hours) : ?>
                    <div class="flex items-start gap-3"><svg class="w-5 h-5 mt-1 shrink-0" style="color: #F37021;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><div><h4 class="font-medium text-sm" style="color: #333;"><?php _e('Business Hours', 'erdu-wp'); ?></h4><p class="text-sm text-gray-500"><?php echo esc_html($hours); ?></p></div></div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php
}

// ==========================================
// 12. Certifications Block
// ==========================================

function erdu_block_render_certifications($block, $is_preview = false)
{
    $title = erdu_block_field('title') ?: __('Certifications', 'erdu-wp');
    $certs = erdu_block_field('certifications');
    if (!$certs) return;
    ?>
    <section class="py-16 bg-white">
        <div class="erdu-container">
            <h2 class="erdu-h2 mb-8 text-center"><?php echo esc_html($title); ?></h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 max-w-4xl mx-auto">
                <?php foreach ($certs as $c) : ?>
                    <div class="p-4 rounded-lg border border-gray-200 flex items-center gap-3 hover:shadow-md transition-shadow">
                        <svg class="w-10 h-10 shrink-0" style="color: #F37021;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <div>
                            <h4 class="font-semibold text-sm" style="color: #333;"><?php echo esc_html($c['name']); ?></h4>
                            <?php if (!empty($c['org'])) : ?><p class="text-xs text-gray-500"><?php echo esc_html($c['org']); ?></p><?php endif; ?>
                            <?php if (!empty($c['valid'])) : ?><p class="text-xs" style="color: #F37021;"><?php printf(__('Valid until %s', 'erdu-wp'), esc_html($c['valid'])); ?></p><?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
}

// ==========================================
// 13. Process Steps Block
// ==========================================

function erdu_block_render_process($block, $is_preview = false)
{
    $title = erdu_block_field('title') ?: __('Our Process', 'erdu-wp');
    $steps = erdu_block_field('steps');
    if (!$steps) return;
    ?>
    <section class="py-16" style="background-color: #F9FAFB;">
        <div class="erdu-container">
            <h2 class="erdu-h2 mb-12 text-center"><?php echo esc_html($title); ?></h2>
            <div class="grid md:grid-cols-5 gap-4">
                <?php foreach ($steps as $i => $s) : ?>
                    <div class="text-center">
                        <div class="w-16 h-16 rounded-full mx-auto mb-4 flex items-center justify-center" style="background-color: #EFF6FF;">
                            <?php if (!empty($s['icon'])) : ?>
                                <svg class="w-8 h-8" style="color: #2563EB;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo esc_attr($s['icon']); ?>"/></svg>
                            <?php else : ?>
                                <span class="text-xl font-bold" style="color: #F37021;"><?php echo intval($i + 1); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="text-sm font-bold mb-1" style="color: #F37021;">STEP <?php echo intval($i + 1); ?></div>
                        <h4 class="font-semibold text-sm mb-1" style="color: #333;"><?php echo esc_html($s['title']); ?></h4>
                        <?php if (!empty($s['description'])) : ?><p class="text-xs text-gray-500"><?php echo esc_html($s['description']); ?></p><?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
}

// ==========================================
// 14. Product Grid Block
// ==========================================

function erdu_block_render_product_grid($block, $is_preview = false)
{
    $title    = erdu_block_field('title') ?: __('Our Products', 'erdu-wp');
    $products = erdu_block_field('products');
    if (!$products) return;
    ?>
    <section class="py-16" style="background-color: #F9FAFB;">
        <div class="erdu-container">
            <h2 class="erdu-h2 mb-8 text-center"><?php echo esc_html($title); ?></h2>
            <div class="grid md:grid-cols-2 gap-6">
                <?php foreach ($products as $p) : ?>
                    <div class="bg-white rounded-xl overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow">
                        <?php if (!empty($p['image'])) : ?>
                            <div class="h-48 overflow-hidden"><img src="<?php echo esc_url($p['image']); ?>" alt="<?php echo esc_attr($p['name']); ?>" class="w-full h-full object-cover hover:scale-105 transition-transform"></div>
                        <?php endif; ?>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-semibold text-lg" style="color: #333;"><?php echo esc_html($p['name']); ?></h3>
                                <?php if (!empty($p['tag'])) : ?><span class="px-2 py-1 text-xs rounded-full" style="background-color: #FFF5ED; color: #F37021;"><?php echo esc_html($p['tag']); ?></span><?php endif; ?>
                            </div>
                            <?php if (!empty($p['description'])) : ?><p class="text-sm text-gray-600 mb-3"><?php echo esc_html($p['description']); ?></p><?php endif; ?>
                            <?php
                            $specs = array();
                            if (!empty($p['power'])) $specs[] = array('label' => __('Power', 'erdu-wp'), 'value' => $p['power']);
                            if (!empty($p['angle'])) $specs[] = array('label' => __('Beam', 'erdu-wp'), 'value' => $p['angle']);
                            if (!empty($p['cri'])) $specs[] = array('label' => 'CRI', 'value' => $p['cri']);
                            if (!empty($p['cct'])) $specs[] = array('label' => 'CCT', 'value' => $p['cct']);
                            if ($specs) : ?>
                                <div class="grid grid-cols-2 gap-2 text-xs">
                                    <?php foreach ($specs as $spec) : ?>
                                        <div class="p-2 rounded" style="background-color: #F9FAFB;"><span class="text-gray-500"><?php echo esc_html($spec['label']); ?>:</span> <span class="font-medium"><?php echo esc_html($spec['value']); ?></span></div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($p['link'])) : ?>
                                <a href="<?php echo esc_url($p['link']); ?>" class="mt-3 inline-flex items-center gap-1 text-sm font-medium hover:underline" style="color: #F37021;"><?php _e('Discover More', 'erdu-wp'); ?><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
}

// ==========================================
// 15. Exhibitions Block
// ==========================================

function erdu_block_render_exhibitions($block, $is_preview = false)
{
    $title = erdu_block_field('title') ?: __('Upcoming Exhibitions', 'erdu-wp');
    $exhibitions = erdu_block_field('exhibitions');
    if (!$exhibitions) return;
    ?>
    <section class="py-16" style="background-color: #F9FAFB;">
        <div class="erdu-container">
            <h3 class="erdu-h3 mb-6"><?php echo esc_html($title); ?></h3>
            <div class="grid md:grid-cols-3 gap-6">
                <?php foreach ($exhibitions as $e) : ?>
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                        <div class="flex items-center gap-2 mb-3"><span class="px-2 py-1 text-xs rounded-full" style="background-color: #FFF5ED; color: #F37021;"><?php _e('Upcoming', 'erdu-wp'); ?></span></div>
                        <h4 class="font-semibold mb-2" style="color: #333;"><?php echo esc_html($e['name']); ?></h4>
                        <?php if (!empty($e['date'])) : ?><p class="text-sm text-gray-500 mb-1"><?php echo esc_html($e['date']); ?></p><?php endif; ?>
                        <?php if (!empty($e['booth'])) : ?><p class="text-sm font-medium" style="color: #F37021;"><?php printf(__('Booth: %s', 'erdu-wp'), esc_html($e['booth'])); ?></p><?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
}

// ==========================================
// 16. Benefits Block
// ==========================================

function erdu_block_render_benefits($block, $is_preview = false)
{
    $title    = erdu_block_field('title') ?: __('Partner Benefits', 'erdu-wp');
    $benefits = erdu_block_field('benefits');
    if (!$benefits) return;
    ?>
    <section class="py-16" style="background-color: #F9FAFB;">
        <div class="erdu-container">
            <h3 class="erdu-h3 mb-6"><?php echo esc_html($title); ?></h3>
            <div class="space-y-4">
                <?php foreach ($benefits as $b) : ?>
                    <div class="bg-white rounded-lg p-4 border border-gray-200 flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0" style="background-color: #FFF5ED;"><svg class="w-5 h-5" style="color: #F37021;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg></div>
                        <div><h4 class="font-medium text-sm" style="color: #333;"><?php echo esc_html($b['title']); ?></h4><p class="text-xs text-gray-500"><?php echo esc_html($b['description']); ?></p></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
}

// ==========================================
// 17. Testimonials Block
// ==========================================

function erdu_block_render_testimonials($block, $is_preview = false)
{
    $title = erdu_block_field('title') ?: __('What Our Clients Say', 'erdu-wp');
    $desc  = erdu_block_field('description');
    $items = erdu_block_field('testimonials');
    if (!$items) return;
    ?>
    <section class="erdu-section bg-white">
        <div class="erdu-container">
            <div class="text-center mb-10">
                <h2 class="erdu-h2"><?php echo esc_html($title); ?></h2>
                <?php if ($desc) : ?><p class="text-gray-500 mt-2"><?php echo esc_html($desc); ?></p><?php endif; ?>
            </div>
            <?php foreach ($items as $t) : ?>
            <div class="max-w-3xl mx-auto rounded-xl p-8 mb-6" style="background-color: #F9FAFB;">
                <div class="text-4xl mb-4" style="color: #F37021; opacity: 0.3;">"</div>
                <p class="text-gray-700 text-lg leading-relaxed mb-6"><?php echo esc_html($t['quote']); ?></p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold" style="background-color: #F37021;"><?php echo esc_html(substr($t['author'], 0, 1)); ?></div>
                    <div>
                        <div class="font-semibold" style="color: #333;"><?php echo esc_html($t['author']); ?></div>
                        <?php if (!empty($t['role'])) : ?><div class="text-sm text-gray-500"><?php echo esc_html($t['role']); ?></div><?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php
}

// ==========================================
// 18. Newsletter Block
// ==========================================

function erdu_block_render_newsletter($block, $is_preview = false)
{
    $title       = erdu_block_field('title') ?: __('Stay Updated', 'erdu-wp');
    $placeholder = erdu_block_field('placeholder') ?: __('Enter your email', 'erdu-wp');
    $button      = erdu_block_field('button_text') ?: __('Subscribe', 'erdu-wp');
    ?>
    <section class="py-12 border-t border-gray-100" style="background-color: #F9FAFB;">
        <div class="erdu-container text-center">
            <h3 class="text-xl font-semibold mb-2" style="color: #333;"><?php echo esc_html($title); ?></h3>
            <form class="flex flex-wrap justify-center gap-2 max-w-md mx-auto mt-4">
                <input type="email" placeholder="<?php echo esc_attr($placeholder); ?>" class="erdu-input flex-1 min-w-[200px]">
                <button type="submit" class="erdu-btn erdu-btn-primary"><?php echo esc_html($button); ?></button>
            </form>
        </div>
    </section>
    <?php
}

// ==========================================
// 19. Applications Block
// ==========================================

function erdu_block_render_applications($block, $is_preview = false)
{
    $title = erdu_block_field('title') ?: __('Applications', 'erdu-wp');
    $desc  = erdu_block_field('description');
    $apps  = erdu_block_field('applications');
    if (!$apps) return;
    ?>
    <section class="erdu-section" style="background-color: #F9FAFB;">
        <div class="erdu-container">
            <div class="text-center mb-10">
                <h2 class="erdu-h2"><?php echo esc_html($title); ?></h2>
                <?php if ($desc) : ?><p class="text-gray-500 mt-2"><?php echo esc_html($desc); ?></p><?php endif; ?>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach ($apps as $a) :
                    $link = !empty($a['link']) ? $a['link'] : '#';
                ?>
                    <a href="<?php echo esc_url($link); ?>" class="bg-white rounded-xl p-6 text-center hover:shadow-lg transition-shadow border border-gray-100">
                        <?php if (!empty($a['icon'])) : ?><div class="text-4xl mb-3"><?php echo esc_html($a['icon']); ?></div><?php endif; ?>
                        <h3 class="font-semibold" style="color: #333;"><?php echo esc_html($a['name']); ?></h3>
                        <p class="text-sm text-gray-500 mt-2"><?php echo esc_html($a['description']); ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
}
