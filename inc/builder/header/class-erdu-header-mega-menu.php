<?php
/**
 * Header Mega Menu Component
 * Renders custom mega menu blocks when triggered
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) {
    exit;
}

class Erdu_Header_Mega_Menu {

    public static function render() {
        if (!erdu_header_field('hd_mega_enable', false)) {
            return;
        }

        $blocks   = erdu_header_field('hd_mega_blocks', array());
        $columns  = erdu_header_field('hd_mega_columns', '3');
        $trigger  = erdu_header_field('hd_mega_trigger', 'Products');

        if (empty($blocks)) {
            return;
        }

        $grid_class = 'grid-cols-1';
        if ($columns >= 2) $grid_class .= ' md:grid-cols-2';
        if ($columns >= 3) $grid_class .= ' lg:grid-cols-3';
        if ($columns >= 4) $grid_class .= ' xl:grid-cols-4';
        ?>
        <div id="erdu-mega-menu"
             class="hidden absolute left-0 right-0 top-full bg-white shadow-xl border-t border-gray-100 z-50"
             data-trigger="<?php echo esc_attr($trigger); ?>">
            <div class="erdu-container py-8">
                <div class="grid <?php echo esc_attr($grid_class); ?> gap-8">
                    <?php foreach ($blocks as $block) :
                        $type  = $block['type'] ?? 'links';
                        $title = $block['title'] ?? '';
                        ?>
                        <div class="erdu-mega-block">
                            <?php if ($title) : ?>
                                <h4 class="font-semibold text-gray-900 mb-4 text-sm uppercase tracking-wide"><?php echo esc_html($title); ?></h4>
                            <?php endif; ?>

                            <?php if ($type === 'links') :
                                $links = $block['links'] ?? array();
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

                            <?php elseif ($type === 'products') : ?>
                                <?php self::render_product_categories($title); ?>

                            <?php elseif ($type === 'image') :
                                $image = $block['image'] ?? '';
                                $img_link = $block['image_link'] ?? '';
                                if ($image) :
                                    ?>
                                    <div class="relative overflow-hidden rounded-lg">
                                        <?php if ($img_link) : ?>
                                            <a href="<?php echo esc_url($img_link); ?>">
                                        <?php endif; ?>
                                        <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>" class="w-full h-48 object-cover hover:scale-105 transition-transform duration-500">
                                        <?php if ($img_link) : ?></a><?php endif; ?>
                                    </div>
                                <?php endif; ?>

                            <?php elseif ($type === 'html') :
                                $html = $block['html'] ?? '';
                                if ($html) : ?>
                                    <div class="prose prose-sm max-w-none">
                                        <?php echo wp_kses_post($html); ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php
    }

    private static function render_product_categories($title) {
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
}
