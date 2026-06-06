<?php
/**
 * Header Language Switcher Component
 *
 * @package ERDU_Lighting
 */

if (!defined('ABSPATH')) {
    exit;
}

class Erdu_Header_Lang {

    /**
     * 获取配置的语言列表
     */
    private static function get_languages() {
        $config = erdu_header_field('hd_lang_list', array());
        if (!empty($config) && is_array($config)) {
            return $config;
        }
        // 默认语言列表
        return array(
            array('code' => 'en', 'label' => 'EN', 'url' => home_url('/'), 'active' => true),
            array('code' => 'zh', 'label' => 'CN', 'url' => '#', 'active' => false),
        );
    }

    public static function render() {
        if (!erdu_header_field('hd_show_lang', true)) {
            return;
        }

        $languages = self::get_languages();
        if (empty($languages)) {
            return;
        }

        $display_style = erdu_header_field('hd_lang_style', 'text'); // text | dropdown | flags
        $show_flags    = erdu_header_field('hd_lang_show_flags', false);
        ?>
        <div class="hidden md:flex items-center">
            <?php if ($display_style === 'dropdown') : ?>
                <!-- 下拉菜单样式 -->
                <div class="relative group">
                    <button class="flex items-center gap-1.5 text-sm text-gray-600 hover:text-orange-500 transition-colors py-2"
                            aria-haspopup="true"
                            aria-expanded="false">
                        <?php foreach ($languages as $lang) :
                            if (!empty($lang['active'])) :
                                $flag = !empty($lang['flag']) ? $lang['flag'] : '';
                                if ($show_flags && $flag) : ?>
                                    <img src="<?php echo esc_url($flag); ?>" alt="" class="w-4 h-4 rounded-sm object-cover">
                                <?php endif; ?>
                                <span class="font-medium"><?php echo esc_html($lang['label']); ?></span>
                                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            <?php break; endif;
                        endforeach; ?>
                    </button>
                    <div class="absolute right-0 top-full mt-1 w-40 bg-white rounded-lg shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 py-1">
                        <?php foreach ($languages as $lang) :
                            $is_active = !empty($lang['active']);
                            $flag = !empty($lang['flag']) ? $lang['flag'] : '';
                            $url = !empty($lang['url']) ? $lang['url'] : '#';
                        ?>
                            <a href="<?php echo esc_url($url); ?>"
                               class="flex items-center gap-2 px-4 py-2 text-sm <?php echo $is_active ? 'text-orange-500 bg-orange-50 font-medium' : 'text-gray-600 hover:bg-gray-50'; ?> transition-colors">
                                <?php if ($show_flags && $flag) : ?>
                                    <img src="<?php echo esc_url($flag); ?>" alt="" class="w-4 h-4 rounded-sm object-cover">
                                <?php endif; ?>
                                <span><?php echo esc_html($lang['label']); ?></span>
                                <?php if ($is_active) : ?>
                                    <svg class="w-3 h-3 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                <?php endif; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

            <?php else : ?>
                <!-- 文本切换样式（默认） -->
                <div class="flex items-center gap-1.5 text-xs text-gray-500">
                    <?php
                    $first = true;
                    foreach ($languages as $lang) :
                        $is_active = !empty($lang['active']);
                        $url = !empty($lang['url']) ? $lang['url'] : '#';
                        if (!$first) :
                            ?><span class="text-gray-300">/</span><?php
                        endif;
                        $first = false;
                        if ($is_active) :
                            ?>
                            <span class="font-medium text-gray-700"><?php echo esc_html($lang['label']); ?></span>
                            <?php
                        else :
                            ?>
                            <a href="<?php echo esc_url($url); ?>" class="hover:text-orange-500 transition-colors"><?php echo esc_html($lang['label']); ?></a>
                            <?php
                        endif;
                    endforeach;
                    ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
}
