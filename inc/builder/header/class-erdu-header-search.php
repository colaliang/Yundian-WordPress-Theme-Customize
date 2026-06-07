<?php
/**
 * Header Search Component
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) {
    exit;
}

class Erdu_Header_Search {
    public static function render() {
        if (!erdu_header_field('hd_show_search', true)) {
            return;
        }

        $style    = erdu_header_field('hd_search_style', 'fullscreen'); // fullscreen, dropdown, inline
        $size     = erdu_header_field('hd_search_size', 'sm'); // sm, md, lg
        $width    = erdu_header_field('hd_search_width', 'w-64'); // w-48, w-64, w-80
        $history  = erdu_header_field('hd_search_history', true);
        $promoted = erdu_header_field('hd_search_promoted', '');
        
        $icon_class = 'w-5 h-5';
        if ($size === 'sm') $icon_class = 'w-4 h-4';
        if ($size === 'lg') $icon_class = 'w-6 h-6';

        // Calculate focus width for inline style
        $focus_width = 'focus-within:w-72';
        if ($width === 'w-48') $focus_width = 'focus-within:w-56';
        if ($width === 'w-80') $focus_width = 'focus-within:w-96';

        $promoted_words = array_filter(array_map('trim', explode(',', $promoted)));
        
        // Inline Search Form
        if ($style === 'inline') {
            ?>
            <div class="flex items-center group relative erdu-search-inline">
                <form action="<?php echo esc_url(home_url('/')); ?>" method="get" class="flex items-center bg-gray-50 rounded-full px-4 py-2 w-48 md:<?php echo esc_attr($width); ?> <?php echo esc_attr($focus_width); ?> focus-within:bg-white focus-within:ring-2 focus-within:ring-orange-500 transition-all duration-300">
                    <svg class="<?php echo esc_attr($icon_class); ?> text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="s" placeholder="<?php esc_attr_e('Search...', 'erdu-wp'); ?>" class="flex-1 bg-transparent border-none outline-none px-2 text-sm text-gray-700 placeholder-gray-400 erdu-search-input">
                </form>
                <?php self::render_dropdown_content($history, $promoted_words); ?>
            </div>
            <?php
            return;
        }
        
        // Icon Trigger
        ?>
        <div class="flex items-center relative erdu-search-trigger-container">
            <button class="p-2 rounded-md hover:bg-gray-100 transition-colors erdu-search-toggle"
                    data-style="<?php echo esc_attr($style); ?>"
                    aria-label="<?php esc_attr_e('Search', 'erdu-wp'); ?>">
                <svg class="<?php echo esc_attr($icon_class); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>
            
            <?php if ($style === 'dropdown') : ?>
                <!-- Dropdown Search -->
                <div class="fixed right-4 md:absolute md:right-0 top-[72px] md:top-full md:mt-2 w-[calc(100vw-2rem)] md:w-96 bg-white rounded-lg shadow-xl border border-gray-100 opacity-0 invisible transition-all z-[60] erdu-search-dropdown-panel">
                    <div class="p-4 border-b border-gray-100">
                        <form action="<?php echo esc_url(home_url('/')); ?>" method="get" class="flex items-center gap-2">
                            <input type="text" name="s" placeholder="<?php esc_attr_e('Search...', 'erdu-wp'); ?>" class="flex-1 bg-gray-50 border-none rounded px-3 py-2 text-sm outline-none focus:ring-1 focus:ring-orange-500 erdu-search-input">
                            <button type="submit" class="p-2 text-white rounded erdu-bg-primary hover:opacity-90 transition-opacity">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </button>
                        </form>
                    </div>
                    <?php self::render_dropdown_content($history, $promoted_words); ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($style === 'fullscreen') : ?>
            <!-- Fullscreen Overlay Search -->
            <div class="erdu-search-fullscreen fixed inset-0 z-[100] bg-black/80 backdrop-blur-md opacity-0 invisible transition-all duration-300 flex items-start justify-center pt-32">
                <div class="w-full max-w-3xl mx-4 bg-white rounded-xl shadow-2xl overflow-hidden transform scale-95 transition-transform duration-300 erdu-search-fullscreen-content">
                    <div class="p-6 border-b border-gray-100 flex items-center gap-4">
                        <svg class="w-8 h-8 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <form action="<?php echo esc_url(home_url('/')); ?>" method="get" class="flex-1 flex items-center">
                            <input type="text" name="s" placeholder="<?php esc_attr_e('Search products, articles, etc...', 'erdu-wp'); ?>"
                                   class="flex-1 text-2xl outline-none border-none bg-transparent erdu-search-input">
                        </form>
                        <button type="button" class="p-2 text-gray-400 hover:text-gray-600 rounded-full hover:bg-gray-100 transition-colors erdu-search-close">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <?php self::render_dropdown_content($history, $promoted_words, 'p-6'); ?>
                </div>
            </div>
        <?php endif; ?>
        <?php
    }

    private static function render_dropdown_content($history, $promoted_words, $padding_class = 'p-4') {
        if (!$history && empty($promoted_words)) return;
        ?>
        <div class="erdu-search-suggestions <?php echo esc_attr($padding_class); ?> bg-gray-50/50 hidden group-focus-within:block">
            <?php if ($history) : ?>
                <div class="erdu-search-history-container mb-4 hidden">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider"><?php _e('Recent Searches', 'erdu-wp'); ?></span>
                        <button type="button" class="text-xs text-orange-500 hover:underline erdu-search-clear-history"><?php _e('Clear', 'erdu-wp'); ?></button>
                    </div>
                    <div class="flex flex-wrap gap-2 erdu-search-history-list">
                        <!-- Populated by JS -->
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($promoted_words)) : ?>
                <div>
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 block"><?php _e('Popular Searches', 'erdu-wp'); ?></span>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach ($promoted_words as $word) : ?>
                            <a href="<?php echo esc_url(add_query_arg('s', urlencode($word), home_url('/'))); ?>" 
                               class="inline-flex items-center px-3 py-1 rounded-full bg-white border border-gray-200 text-sm text-gray-600 hover:border-orange-500 hover:text-orange-500 transition-colors">
                                <svg class="w-3 h-3 mr-1 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                <?php echo esc_html($word); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
}
