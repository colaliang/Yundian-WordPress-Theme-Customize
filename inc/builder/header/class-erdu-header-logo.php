<?php
/**
 * Header Logo Component
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) {
    exit;
}

class Erdu_Header_Logo {
    public static function render() {
        ?>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <div class="w-8 h-8 rounded-sm flex items-center justify-center erdu-bg-primary">
                    <span class="text-white font-bold text-sm">E</span>
                </div>
                <span class="text-xl font-bold erdu-text-primary">ERDU</span>
                <span class="hidden sm:inline text-xs text-gray-500 ml-1">LIGHTING</span>
            <?php endif; ?>
        </a>
        <?php
    }
}
