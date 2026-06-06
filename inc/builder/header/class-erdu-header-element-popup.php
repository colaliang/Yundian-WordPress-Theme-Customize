<?php
/**
 * Header Element Popup Component
 * Renders icon-triggered popup elements (dropdown, modal, mega menu style)
 * Similar to Mega Menu Blocks but for individual header elements.
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) {
    exit;
}

class Erdu_Header_Element_Popup {

    /**
     * 默认图标 SVG path 映射
     */
    private static $default_icons = array(
        'search'  => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
        'lang'    => 'M3 5h12M9 3v2m3 6V3m-3 14v2m-3-6h12m-3 4h-6m6-8h-6M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        'contact' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
        'social'  => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
        'custom'  => 'M12 6v6m0 0v6m0-6h6m-6 0H6',
    );

    /**
     * 渲染所有配置的 Element Popup
     */
    public static function render() {
        $popups = erdu_header_field('hd_element_popups', array());
        if (empty($popups) || !is_array($popups)) {
            return;
        }

        foreach ($popups as $index => $popup) {
            self::render_single_popup($popup, $index);
        }
    }

    /**
     * 渲染单个 Popup 元素
     */
    private static function render_single_popup($popup, $index) {
        $key         = $popup['key'] ?? 'custom';
        $icon        = $popup['icon'] ?? '';
        $icon_image  = $popup['icon_image'] ?? '';
        $label       = $popup['label'] ?? '';
        $popup_type  = $popup['popup_type'] ?? 'dropdown';
        $popup_width = $popup['popup_width'] ?? 'auto';
        $blocks      = $popup['blocks'] ?? array();

        // 使用自定义图标或默认图标
        $svg_path = !empty($icon) ? $icon : (self::$default_icons[$key] ?? self::$default_icons['custom']);

        // 生成唯一 ID
        $popup_id = 'erdu-header-popup-' . $index . '-' . sanitize_key($key);

        // 宽度样式
        $width_class = self::get_width_class($popup_width);
        $width_style = self::get_width_style($popup_width);

        ?>
        <div class="hidden md:flex items-center relative erdu-header-popup-wrapper"
             data-popup-type="<?php echo esc_attr($popup_type); ?>"
             data-popup-id="<?php echo esc_attr($popup_id); ?>">

            <!-- 触发按钮 -->
            <button type="button"
                    class="erdu-header-popup-trigger flex items-center gap-1.5 p-2 rounded-md hover:bg-gray-100 transition-colors text-gray-600 hover:text-orange-500"
                    aria-expanded="false"
                    aria-controls="<?php echo esc_attr($popup_id); ?>"
                    <?php if ($popup_type === 'modal') : ?>
                    onclick="document.getElementById('<?php echo esc_attr($popup_id); ?>').classList.toggle('hidden')"
                    <?php endif; ?>>
                <?php if ($icon_image) : ?>
                    <img src="<?php echo esc_url($icon_image); ?>" alt="" class="w-5 h-5 object-contain">
                <?php else : ?>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="<?php echo esc_attr($svg_path); ?>"/>
                    </svg>
                <?php endif; ?>
                <?php if ($label) : ?>
                    <span class="text-sm"><?php echo esc_html($label); ?></span>
                <?php endif; ?>
                <?php if ($popup_type === 'dropdown' || $popup_type === 'mega') : ?>
                    <svg class="w-3 h-3 text-gray-400 transition-transform popup-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                <?php endif; ?>
            </button>

            <?php if ($popup_type === 'dropdown' || $popup_type === 'mega') : ?>
                <!-- Dropdown / Mega 面板 -->
                <div id="<?php echo esc_attr($popup_id); ?>"
                     class="erdu-header-popup-panel absolute right-0 top-full mt-2 bg-white rounded-lg shadow-xl border border-gray-100 z-50 hidden <?php echo esc_attr($width_class); ?>"
                     style="<?php echo esc_attr($width_style); ?>">
                    <div class="p-5">
                        <?php self::render_blocks($blocks, $popup_type); ?>
                    </div>
                </div>

            <?php elseif ($popup_type === 'modal') : ?>
                <!-- Modal 遮罩层 -->
                <div id="<?php echo esc_attr($popup_id); ?>"
                     class="hidden fixed inset-0 z-[60] bg-black/50 backdrop-blur-sm"
                     onclick="if(event.target===this)this.classList.add('hidden')">
                    <div class="flex items-start justify-center pt-24 px-4">
                        <div class="bg-white rounded-lg shadow-2xl w-full <?php echo esc_attr($width_class); ?> max-h-[80vh] overflow-y-auto"
                             style="<?php echo esc_attr($width_style); ?>">
                            <!-- 关闭按钮 -->
                            <div class="flex items-center justify-between p-4 border-b border-gray-100">
                                <?php if ($label) : ?>
                                    <h3 class="text-lg font-semibold text-gray-800"><?php echo esc_html($label); ?></h3>
                                <?php else : ?>
                                    <div></div>
                                <?php endif; ?>
                                <button type="button"
                                        class="p-1 text-gray-400 hover:text-gray-600 transition-colors"
                                        onclick="document.getElementById('<?php echo esc_attr($popup_id); ?>').classList.add('hidden')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="p-5">
                                <?php self::render_blocks($blocks, $popup_type); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }

    /**
     * 渲染 Popup 内容 Blocks
     */
    private static function render_blocks($blocks, $popup_type) {
        if (empty($blocks) || !is_array($blocks)) {
            echo '<p class="text-sm text-gray-400">' . esc_html__('No content configured.', 'erdu-wp') . '</p>';
            return;
        }

        $is_mega = ($popup_type === 'mega');
        if ($is_mega && count($blocks) > 1) {
            $cols = min(count($blocks), 4);
            $grid_class = 'grid grid-cols-1';
            if ($cols >= 2) $grid_class .= ' md:grid-cols-2';
            if ($cols >= 3) $grid_class .= ' lg:grid-cols-3';
            if ($cols >= 4) $grid_class .= ' xl:grid-cols-4';
            echo '<div class="' . esc_attr($grid_class) . ' gap-6">';
        }

        foreach ($blocks as $block) {
            $type  = $block['type'] ?? 'links';
            $title = $block['title'] ?? '';

            if ($is_mega && count($blocks) > 1) {
                echo '<div class="erdu-popup-block">';
            }

            if ($title) {
                echo '<h4 class="font-semibold text-gray-900 mb-3 text-sm uppercase tracking-wide">' . esc_html($title) . '</h4>';
            }

            switch ($type) {
                case 'links':
                    self::render_block_links($block);
                    break;
                case 'products':
                    self::render_block_products($block);
                    break;
                case 'image':
                    self::render_block_image($block);
                    break;
                case 'html':
                    self::render_block_html($block);
                    break;
                case 'contact':
                    self::render_block_contact($block);
                    break;
                case 'social':
                    self::render_block_social($block);
                    break;
            }

            if ($is_mega && count($blocks) > 1) {
                echo '</div>';
            }
        }

        if ($is_mega && count($blocks) > 1) {
            echo '</div>';
        }
    }

    /**
     * Links List Block
     */
    private static function render_block_links($block) {
        $links = $block['links'] ?? array();
        if (empty($links)) {
            return;
        }
        ?>
        <ul class="space-y-2">
            <?php foreach ($links as $link) :
                $label = $link['label'] ?? '';
                $url   = $link['url'] ?? '';
                $desc  = $link['desc'] ?? '';
                if (empty($label) || empty($url)) continue;
            ?>
                <li>
                    <a href="<?php echo esc_url($url); ?>" class="group block">
                        <span class="text-sm font-medium text-gray-700 group-hover:text-orange-500 transition-colors"><?php echo esc_html($label); ?></span>
                        <?php if ($desc) : ?>
                            <span class="block text-xs text-gray-400 mt-0.5"><?php echo esc_html($desc); ?></span>
                        <?php endif; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php
    }

    /**
     * Product Categories Block
     */
    private static function render_block_products($block) {
        if (!class_exists('WooCommerce')) {
            echo '<p class="text-sm text-gray-500">' . esc_html__('WooCommerce not active.', 'erdu-wp') . '</p>';
            return;
        }

        $categories = get_terms(array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => true,
            'number'     => 6,
            'parent'     => 0,
        ));

        if (empty($categories) || is_wp_error($categories)) {
            echo '<p class="text-sm text-gray-500">' . esc_html__('No categories found.', 'erdu-wp') . '</p>';
            return;
        }
        ?>
        <ul class="space-y-2">
            <?php foreach ($categories as $cat) :
                $thumbnail_id = get_term_meta($cat->term_id, 'thumbnail_id', true);
                $image = $thumbnail_id ? wp_get_attachment_image_url($thumbnail_id, 'thumbnail') : '';
                $link = get_term_link($cat);
                if (is_wp_error($link)) continue;
            ?>
                <li>
                    <a href="<?php echo esc_url($link); ?>" class="flex items-center gap-3 group">
                        <?php if ($image) : ?>
                            <img src="<?php echo esc_url($image); ?>" alt="" class="w-10 h-10 rounded object-cover flex-shrink-0">
                        <?php else : ?>
                            <div class="w-10 h-10 rounded bg-gray-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                        <?php endif; ?>
                        <span class="text-sm font-medium text-gray-700 group-hover:text-orange-500 transition-colors"><?php echo esc_html($cat->name); ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php
    }

    /**
     * Image Card Block
     */
    private static function render_block_image($block) {
        $image = $block['image'] ?? '';
        $img_link = $block['image_link'] ?? '';
        if (empty($image)) {
            return;
        }
        ?>
        <div class="relative overflow-hidden rounded-lg">
            <?php if ($img_link) : ?>
                <a href="<?php echo esc_url($img_link); ?>">
            <?php endif; ?>
            <img src="<?php echo esc_url($image); ?>" alt="" class="w-full h-40 object-cover hover:scale-105 transition-transform duration-500">
            <?php if ($img_link) : ?>
                </a>
            <?php endif; ?>
        </div>
        <?php
    }

    /**
     * Custom HTML Block
     */
    private static function render_block_html($block) {
        $html = $block['html'] ?? '';
        if (empty($html)) {
            return;
        }
        ?>
        <div class="prose prose-sm max-w-none">
            <?php echo wp_kses_post($html); ?>
        </div>
        <?php
    }

    /**
     * Contact Info Block
     */
    private static function render_block_contact($block) {
        $phone   = $block['contact_phone'] ?? '';
        $email   = $block['contact_email'] ?? '';
        $address = $block['contact_address'] ?? '';

        if (!$phone && !$email && !$address) {
            return;
        }
        ?>
        <div class="space-y-3">
            <?php if ($phone) : ?>
                <a href="tel:<?php echo esc_attr(preg_replace('/[^\d+]/', '', $phone)); ?>" class="flex items-center gap-2 text-sm text-gray-600 hover:text-orange-500 transition-colors">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span><?php echo esc_html($phone); ?></span>
                </a>
            <?php endif; ?>

            <?php if ($email) : ?>
                <a href="mailto:<?php echo esc_attr($email); ?>" class="flex items-center gap-2 text-sm text-gray-600 hover:text-orange-500 transition-colors">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span><?php echo esc_html($email); ?></span>
                </a>
            <?php endif; ?>

            <?php if ($address) : ?>
                <div class="flex items-start gap-2 text-sm text-gray-500">
                    <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span><?php echo esc_html($address); ?></span>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }

    /**
     * Social Links Block
     */
    private static function render_block_social($block) {
        $links = $block['social_links'] ?? array();
        if (empty($links)) {
            return;
        }

        $icons = array(
            'facebook'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>',
            'linkedin'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/>',
            'youtube'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22.54 6.42a2.78 2.78 0 00-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 00-1.94 2A29 29 0 001 12a29 29 0 00.46 5.58 2.78 2.78 0 001.94 2C5.12 20 12 20 12 20s6.88 0 8.6-.46a2.78 2.78 0 001.94-2A29 29 0 0023 12a29 29 0 00-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02"/>',
            'instagram' => '<rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>',
            'twitter'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M23 3a10.9 10.9 0 01-3.14 1.53A4.48 4.48 0 0012 8v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/>',
            'whatsapp'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/>',
            'wechat'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-6a2 2 0 012-2h8z"/><path d="M7 10H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l4-4h2"/>',
            'tiktok'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12a4 4 0 104 4V4a5 5 0 005 5"/>',
            'custom'    => '<circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>',
        );
        ?>
        <div class="flex flex-wrap gap-2">
            <?php foreach ($links as $link) :
                $platform = $link['platform'] ?? 'custom';
                $url = $link['url'] ?? '';
                $lbl = $link['label'] ?? ucfirst($platform);
                $icon = $icons[$platform] ?? $icons['custom'];
                if (empty($url)) continue;
            ?>
                <a href="<?php echo esc_url($url); ?>"
                   target="_blank"
                   rel="noopener noreferrer"
                   aria-label="<?php echo esc_attr($lbl); ?>"
                   class="w-9 h-9 flex items-center justify-center rounded-full text-gray-500 hover:text-orange-500 hover:bg-orange-50 transition-all border border-gray-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <?php echo $icon; ?>
                    </svg>
                </a>
            <?php endforeach; ?>
        </div>
        <?php
    }

    /**
     * 获取宽度 CSS 类
     */
    private static function get_width_class($width) {
        switch ($width) {
            case 'sm':  return 'w-[280px]';
            case 'md':  return 'w-[400px]';
            case 'lg':  return 'w-[600px]';
            case 'full': return 'w-full max-w-6xl';
            default:    return 'min-w-[240px]';
        }
    }

    /**
     * 获取宽度内联样式
     */
    private static function get_width_style($width) {
        if ($width === 'full') {
            return 'left: 50%; transform: translateX(-50%);';
        }
        return '';
    }
}
