<?php
/**
 * Header Social Icons Component
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) {
    exit;
}

class Erdu_Header_Social {

    private static $icons = array(
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

    public static function render() {
        if (!erdu_header_field('hd_show_social', false)) {
            return;
        }

        $links = erdu_header_field('hd_social_links', array());
        if (empty($links)) {
            return;
        }
        ?>
        <div class="hidden lg:flex items-center gap-2">
            <?php foreach ($links as $link) :
                $platform = $link['platform'] ?? 'custom';
                $url = $link['url'] ?? '';
                $label = $link['label'] ?? ucfirst($platform);
                $icon = self::$icons[$platform] ?? self::$icons['custom'];
                if (empty($url)) continue;
            ?>
                <a href="<?php echo esc_url($url); ?>"
                   target="_blank"
                   rel="noopener noreferrer"
                   aria-label="<?php echo esc_attr($label); ?>"
                   class="w-8 h-8 flex items-center justify-center rounded-full text-gray-500 hover:text-orange-500 hover:bg-orange-50 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <?php echo $icon; ?>
                    </svg>
                </a>
            <?php endforeach; ?>
        </div>
        <?php
    }
}
